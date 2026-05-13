<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    $monthlySales = \App\Models\ServiceOrder::whereYear('created_at', now()->year)
        ->whereMonth('created_at', now()->month)
        ->sum('total_amount');
    
    $activeOrdersCount = \App\Models\ServiceOrder::where('status', 'pending')->count();
    $readyToDeliverCount = \App\Models\ServiceOrder::where('status', 'completed')->count(); // Example logic
    
    $customersCount = \App\Models\Customer::count();
    $recentOrders = \App\Models\ServiceOrder::with(['customer', 'vehicle'])->latest()->take(5)->get();

    return view('dashboard', compact(
        'monthlySales', 
        'activeOrdersCount', 
        'readyToDeliverCount', 
        'customersCount', 
        'recentOrders'
    ));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Módulos del Sistema
    Route::resource('/clientes', \App\Http\Controllers\CustomerController::class)->names('customers')->parameters(['clientes' => 'customer']);
    Route::resource('/vehiculos', \App\Http\Controllers\VehicleController::class)->names('vehicles')->parameters(['vehiculos' => 'vehicle']);
    Route::resource('/ordenes', \App\Http\Controllers\ServiceOrderController::class)->names('orders')->parameters(['ordenes' => 'order']);
    Route::resource('/inventario', \App\Http\Controllers\PartController::class)->names('inventory')->parameters(['inventario' => 'part']);
    Route::resource('/facturacion', \App\Http\Controllers\InvoiceController::class)->names('invoices')->parameters(['facturacion' => 'invoice']);
    Route::resource('/personal', \App\Http\Controllers\StaffController::class)->names('staff')->parameters(['personal' => 'staff']);
    Route::resource('/citas', \App\Http\Controllers\AppointmentController::class)->names('appointments')->parameters(['citas' => 'appointment']);

    Route::get('/ai-chat', [\App\Http\Controllers\AIController::class, 'index'])->name('ai.chat');
    Route::post('/ai-chat/send', [\App\Http\Controllers\AIController::class, 'chat'])->name('ai.send');
});

require __DIR__.'/auth.php';
