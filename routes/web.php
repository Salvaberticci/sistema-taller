<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware('auth')->group(function () {
    Route::get('/clear-cache', function () {
        try {
            \Artisan::call('optimize:clear');
            return '¡Caché limpiada y paquetes redescubiertos con éxito!';
        } catch (\Exception $e) {
            return 'Error al limpiar caché: ' . $e->getMessage();
        }
    });

    Route::get('/fix-storage', function () {
        try {
            $publicStoragePath = public_path('storage');
            $messages = [];

            $storagePublic = storage_path('app/public');
            if (!file_exists($storagePublic)) {
                mkdir($storagePublic, 0755, true);
                $messages[] = 'Creada carpeta storage/app/public';
            }

            if (file_exists($publicStoragePath) || is_link($publicStoragePath)) {
                if (is_link($publicStoragePath)) {
                    unlink($publicStoragePath);
                    $messages[] = 'Eliminado enlace simbólico viejo public/storage';
                } else {
                    $backupName = $publicStoragePath . '_backup_' . time();
                    rename($publicStoragePath, $backupName);
                    $messages[] = "Directorio real public/storage renombrado a {$backupName}";
                }
            }

            \Artisan::call('storage:link');
            $messages[] = 'Enlace simbólico recreado mediante storage:link';

            $dirsToFix = [
                storage_path(),
                storage_path('app'),
                storage_path('app/public')
            ];

            foreach ($dirsToFix as $dir) {
                if (file_exists($dir)) {
                    chmod($dir, 0755);
                }
            }

            if (file_exists($storagePublic)) {
                $iterator = new \RecursiveIteratorIterator(
                    new \RecursiveDirectoryIterator($storagePublic, \RecursiveDirectoryIterator::SKIP_DOTS),
                    \RecursiveIteratorIterator::SELF_FIRST
                );

                foreach ($iterator as $item) {
                    if ($item->isDir()) {
                        chmod($item->getPathname(), 0755);
                    } else {
                        chmod($item->getPathname(), 0644);
                    }
                }
                $messages[] = 'Permisos corregidos a 755 para directorios y 644 para archivos dentro de storage/app/public';
            }

            return 'Operaciones completadas:<br>- ' . implode('<br>- ', $messages);
        } catch (\Exception $e) {
            return 'Error al corregir el almacenamiento: ' . $e->getMessage();
        }
    });
});

Route::get('/dashboard', function () {
    $monthlySales = \App\Models\ServiceOrder::whereYear('created_at', now()->year)
        ->whereMonth('created_at', now()->month)
        ->sum('total_amount');
    
    $activeOrdersCount = \App\Models\ServiceOrder::where('status', 'pending')->count();
    $readyToDeliverCount = \App\Models\ServiceOrder::where('status', 'completed')->count(); // Example logic
    
    $customersCount = \App\Models\Customer::count();
    $recentOrders = \App\Models\ServiceOrder::with(['customer', 'vehicle'])->latest()->take(5)->get();

    // Inventory Stats
    $criticalStockCount = \App\Models\Part::whereColumn('stock', '<=', 'min_stock')->count();

    return view('dashboard', compact(
        'monthlySales', 
        'activeOrdersCount', 
        'readyToDeliverCount', 
        'customersCount', 
        'recentOrders',
        'criticalStockCount'
    ));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ─── Rutas exclusivas del Administrador ───
    Route::middleware('role:admin')->group(function () {
        // Facturación y Pagos
        Route::resource('/facturacion', \App\Http\Controllers\InvoiceController::class)->names('invoices')->parameters(['facturacion' => 'invoice']);
        Route::post('/facturacion/{invoice}/pagar', [\App\Http\Controllers\InvoiceController::class, 'addPayment'])->name('invoices.payment');
        Route::patch('/pagos/{payment}/confirmar', [\App\Http\Controllers\InvoiceController::class, 'confirmPayment'])->name('payments.confirm');
        Route::patch('/pagos/{payment}/rechazar', [\App\Http\Controllers\InvoiceController::class, 'rejectPayment'])->name('payments.reject');
        Route::get('/pagos/historial', [\App\Http\Controllers\InvoiceController::class, 'paymentHistory'])->name('payments.history');
    });

    // ─── Reportes PDF (todos los roles) ───
    Route::middleware('role:admin,receptionist,mechanic')->group(function () {
        Route::get('/reportes/dashboard', [\App\Http\Controllers\ReportController::class, 'dashboard'])->name('reports.dashboard');
        Route::get('/reportes/inventario', [\App\Http\Controllers\ReportController::class, 'inventory'])->name('reports.inventory');
        Route::get('/reportes/ordenes', [\App\Http\Controllers\ReportController::class, 'orders'])->name('reports.orders');
        Route::get('/reportes/facturas', [\App\Http\Controllers\ReportController::class, 'invoices'])->name('reports.invoices');
        Route::get('/reportes/personal', [\App\Http\Controllers\ReportController::class, 'staff'])->name('reports.staff');
        Route::get('/reportes/clientes', [\App\Http\Controllers\ReportController::class, 'customers'])->name('reports.customers');
        Route::get('/reportes/vehiculos', [\App\Http\Controllers\ReportController::class, 'vehicles'])->name('reports.vehicles');
        Route::get('/reportes/agenda', [\App\Http\Controllers\ReportController::class, 'appointments'])->name('reports.appointments');
        Route::get('/reportes/factura/{invoice}', [\App\Http\Controllers\ReportController::class, 'invoice'])->name('reports.invoice');
    });

    // ─── Rutas compartidas: Administrador y Recepcionista ───
    Route::middleware('role:admin,receptionist')->group(function () {
        // Personal (solo admin puede crear/editar administradores)
        Route::resource('/personal', \App\Http\Controllers\StaffController::class)->names('staff')->parameters(['personal' => 'staff']);

        Route::resource('/clientes', \App\Http\Controllers\CustomerController::class)->names('customers')->parameters(['clientes' => 'customer']);
        Route::resource('/vehiculos', \App\Http\Controllers\VehicleController::class)->names('vehicles')->parameters(['vehiculos' => 'vehicle']);
        Route::post('/vehiculos/{vehicle}/fotos', [\App\Http\Controllers\VehicleController::class, 'storePhotos'])->name('vehicles.photos.store');
        Route::delete('/vehiculos/fotos/{photo}', [\App\Http\Controllers\VehicleController::class, 'destroyPhoto'])->name('vehicles.photos.destroy');
        Route::resource('/citas', \App\Http\Controllers\AppointmentController::class)->names('appointments')->parameters(['citas' => 'appointment']);

        // Administración de inventario (crear, editar, eliminar repuestos)
        Route::get('/inventario/create', [\App\Http\Controllers\PartController::class, 'create'])->name('inventory.create');
        Route::post('/inventario/store', [\App\Http\Controllers\PartController::class, 'store'])->name('inventory.store');
        Route::get('/inventario/{part}/edit', [\App\Http\Controllers\PartController::class, 'edit'])->name('inventory.edit');
        Route::put('/inventario/{part}/update', [\App\Http\Controllers\PartController::class, 'update'])->name('inventory.update');
        Route::delete('/inventario/{part}/destroy', [\App\Http\Controllers\PartController::class, 'destroy'])->name('inventory.destroy');

    });

    // ─── Rutas compartidas con Mecánico ───
    Route::middleware('role:admin,receptionist,mechanic')->group(function () {
        // Administración de órdenes (crear, editar, eliminar, items)
        Route::get('/ordenes/crear/nueva', [\App\Http\Controllers\ServiceOrderController::class, 'create'])->name('orders.create');
        Route::post('/ordenes/guardar', [\App\Http\Controllers\ServiceOrderController::class, 'store'])->name('orders.store');
        Route::get('/ordenes/{order}/editar', [\App\Http\Controllers\ServiceOrderController::class, 'edit'])->name('orders.edit');
        Route::put('/ordenes/{order}/actualizar', [\App\Http\Controllers\ServiceOrderController::class, 'update'])->name('orders.update');
        Route::delete('/ordenes/{order}/eliminar', [\App\Http\Controllers\ServiceOrderController::class, 'destroy'])->name('orders.destroy');
        Route::post('/ordenes/{order}/items', [\App\Http\Controllers\ServiceOrderController::class, 'addItem'])->name('orders.addItem');
        Route::delete('/ordenes/items/{workItem}', [\App\Http\Controllers\ServiceOrderController::class, 'removeItem'])->name('orders.removeItem');

        // IA
        Route::get('/ai-chat', [\App\Http\Controllers\AIController::class, 'index'])->name('ai.chat');
        Route::post('/ai-chat/send', [\App\Http\Controllers\AIController::class, 'chat'])->name('ai.send');

        // Inventario (solo lectura)
        Route::get('/inventario', [\App\Http\Controllers\PartController::class, 'index'])->name('inventory.index');
        Route::get('/inventario/{part}', [\App\Http\Controllers\PartController::class, 'show'])->name('inventory.show');

        // Órdenes de trabajo (ver y actualizar estado)
        Route::get('/ordenes', [\App\Http\Controllers\ServiceOrderController::class, 'index'])->name('orders.index');
        Route::get('/ordenes/{order}', [\App\Http\Controllers\ServiceOrderController::class, 'show'])->name('orders.show');
        Route::patch('/ordenes/{order}/status', [\App\Http\Controllers\ServiceOrderController::class, 'updateStatus'])->name('orders.updateStatus');
    });
});

Route::post('/_captcha/verify', function () {
    $input = request('captcha_indices', '');
    $selected = $input !== '' ? explode(',', $input) : [];
    $selected = array_map('intval', $selected);
    sort($selected);

    $correct = session('captcha_correct', []);
    if ($selected === $correct) {
        session(['captcha_verified' => true]);
        return response()->json(['success' => true]);
    }

    return response()->json(['success' => false, 'message' => 'Selecciona las imágenes correctas.']);
})->middleware('web')->name('captcha.verify');

Route::post('/_quick-add-make', function () {
    $name = trim(request('name', ''));
    if (!$name) {
        return response()->json(['success' => false, 'message' => 'El nombre de la marca es obligatorio.'], 422);
    }
    $make = \App\Models\VehicleMake::firstOrCreate(['name' => $name]);
    return response()->json(['success' => true, 'id' => $make->id, 'name' => $make->name]);
})->middleware('auth')->name('quick-add.make');

Route::post('/_quick-add-model', function () {
    $name = trim(request('name', ''));
    $makeId = request('make_id');
    if (!$name) {
        return response()->json(['success' => false, 'message' => 'El nombre del modelo es obligatorio.'], 422);
    }
    if (!$makeId || !\App\Models\VehicleMake::find($makeId)) {
        return response()->json(['success' => false, 'message' => 'La marca seleccionada no es válida.'], 422);
    }
    $model = \App\Models\VehicleModel::firstOrCreate([
        'vehicle_make_id' => $makeId,
        'name' => $name,
    ]);
    $model->load('make');
    return response()->json(['success' => true, 'id' => $model->id, 'name' => $model->name, 'make_id' => $model->vehicle_make_id, 'make_name' => $model->make->name]);
})->middleware('auth')->name('quick-add.model');

require __DIR__.'/auth.php';
