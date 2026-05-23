<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AIController extends Controller
{
    public function chat(Request $request)
    {
        $message = $request->input('message');
        $apiKey = env('GROQ_API_KEY');

        if (empty($apiKey)) {
            return response()->json([
                'choices' => [
                    [
                        'message' => [
                            'content' => 'Error: La clave API de Groq no está configurada en el archivo .env. Por favor configúrala.'
                        ]
                    ]
                ]
            ]);
        }

        // 1. Obtener estadísticas básicas del negocio
        $totalCustomers = \App\Models\Customer::count();
        $totalVehicles = \App\Models\Vehicle::count();
        $activeOrders = \App\Models\ServiceOrder::whereIn('status', ['pending', 'in_progress'])->count();

        // 2. Formatear Fecha y Hora Actuales en Español
        $dias = ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];
        $meses = ['', 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
        $fechaEsp = $dias[now()->dayOfWeek] . ' ' . now()->day . ' de ' . $meses[now()->month] . ' de ' . now()->year;
        $horaEsp = now()->format('h:i A');

        $businessContext = "### Información General del Negocio:\n";
        $businessContext .= "- Nombre: Taller Automotriz Inversiones Dios es Amor 31 C.A. (MecaniSmart)\n";
        $businessContext .= "- Fecha y hora actual del servidor: {$fechaEsp} a las {$horaEsp}\n";
        $businessContext .= "- Clientes registrados en base de datos: {$totalCustomers}\n";
        $businessContext .= "- Vehículos registrados en base de datos: {$totalVehicles}\n";
        $businessContext .= "- Órdenes de trabajo activas (en proceso/pendientes): {$activeOrders}\n";

        // 3. Obtener Citas (Futuras/Pendientes y Recientes del Historial)
        $upcomingAppointments = \App\Models\Appointment::with(['customer', 'vehicle'])
            ->where('scheduled_at', '>=', now()->startOfDay())
            ->orderBy('scheduled_at', 'asc')
            ->take(20)
            ->get();

        $recentAppointments = \App\Models\Appointment::with(['customer', 'vehicle'])
            ->where('scheduled_at', '<', now()->startOfDay())
            ->orderBy('scheduled_at', 'desc')
            ->take(15)
            ->get();

        $appointmentsContext = "### Citas Pendientes/Programadas (Próximas):\n";
        if ($upcomingAppointments->isEmpty()) {
            $appointmentsContext .= "No hay citas programadas desde hoy en adelante.\n";
        } else {
            $appointmentsContext .= "| ID | Fecha y Hora | Cliente | Vehículo (Placa) | Estado | Motivo/Descripción |\n";
            $appointmentsContext .= "| --- | --- | --- | --- | --- | --- |\n";
            foreach ($upcomingAppointments as $app) {
                $clientName = $app->customer ? $app->customer->name : 'No asignado';
                $vehicleInfo = $app->vehicle ? "{$app->vehicle->make} {$app->vehicle->model} ({$app->vehicle->license_plate})" : 'No asignado';
                $appointmentsContext .= "| {$app->id} | {$app->scheduled_at} | {$clientName} | {$vehicleInfo} | {$app->status} | {$app->description} |\n";
            }
        }

        $appointmentsContext .= "\n### Historial Reciente de Citas (Pasadas):\n";
        if ($recentAppointments->isEmpty()) {
            $appointmentsContext .= "No hay registros de citas pasadas.\n";
        } else {
            $appointmentsContext .= "| ID | Fecha y Hora | Cliente | Vehículo (Placa) | Estado | Motivo/Descripción |\n";
            $appointmentsContext .= "| --- | --- | --- | --- | --- | --- |\n";
            foreach ($recentAppointments as $app) {
                $clientName = $app->customer ? $app->customer->name : 'No asignado';
                $vehicleInfo = $app->vehicle ? "{$app->vehicle->make} {$app->vehicle->model} ({$app->vehicle->license_plate})" : 'No asignado';
                $appointmentsContext .= "| {$app->id} | {$app->scheduled_at} | {$clientName} | {$vehicleInfo} | {$app->status} | {$app->description} |\n";
            }
        }

        // Búsqueda extra en citas si el usuario menciona un cliente, placa o palabra clave
        $userMsgClean = strtolower($message);
        if (preg_replace('/[^\p{L}\p{N}\s]/u', '', $userMsgClean) !== '') {
            $words = array_filter(explode(' ', preg_replace('/[^\p{L}\p{N}\s]/u', '', $userMsgClean)), function($w) {
                return strlen($w) > 3;
            });

            if (!empty($words)) {
                $searchAppointments = \App\Models\Appointment::with(['customer', 'vehicle'])
                    ->where(function($q) use ($words) {
                        foreach ($words as $word) {
                            $q->orWhereHas('customer', function($sq) use ($word) {
                                $sq->where('name', 'like', "%{$word}%")
                                   ->orWhere('id_card', 'like', "%{$word}%")
                                   ->orWhere('email', 'like', "%{$word}%");
                            })->orWhereHas('vehicle', function($sq) use ($word) {
                                $sq->where('license_plate', 'like', "%{$word}%")
                                   ->orWhere('make', 'like', "%{$word}%")
                                   ->orWhere('model', 'like', "%{$word}%");
                            })->orWhere('description', 'like', "%{$word}%");
                        }
                    })
                    ->whereNotIn('id', array_merge(
                        $upcomingAppointments->pluck('id')->toArray(),
                        $recentAppointments->pluck('id')->toArray()
                    ))
                    ->take(15)
                    ->get();

                if ($searchAppointments->isNotEmpty()) {
                    $appointmentsContext .= "\n### Citas Adicionales Encontradas mediante Búsqueda:\n";
                    $appointmentsContext .= "| ID | Fecha y Hora | Cliente | Vehículo (Placa) | Estado | Motivo/Descripción |\n";
                    $appointmentsContext .= "| --- | --- | --- | --- | --- | --- |\n";
                    foreach ($searchAppointments as $app) {
                        $clientName = $app->customer ? $app->customer->name : 'No asignado';
                        $vehicleInfo = $app->vehicle ? "{$app->vehicle->make} {$app->vehicle->model} ({$app->vehicle->license_plate})" : 'No asignado';
                        $appointmentsContext .= "| {$app->id} | {$app->scheduled_at} | {$clientName} | {$vehicleInfo} | {$app->status} | {$app->description} |\n";
                    }
                }
            }
        }

        // 4. Obtener Inventario y Repuestos
        $partsCount = \App\Models\Part::count();
        $inventoryContext = "";

        if ($partsCount <= 120) {
            // Si la base de datos es relativamente pequeña, enviamos todo el catálogo para precisión absoluta
            $parts = \App\Models\Part::all();
            $inventoryContext = "### Catálogo Completo de Inventario de Repuestos:\n";
            if ($parts->isEmpty()) {
                $inventoryContext .= "No hay repuestos registrados en el inventario actualmente.\n";
            } else {
                $inventoryContext .= "| SKU | Repuesto | Categoría | Stock | Precio | Stock Mínimo |\n";
                $inventoryContext .= "| --- | --- | --- | --- | --- | --- |\n";
                foreach ($parts as $part) {
                    $inventoryContext .= "| {$part->sku} | {$part->name} | {$part->category} | {$part->stock} unidades | \${$part->price} | {$part->min_stock} unidades |\n";
                }
            }
        } else {
            // Si es grande, enviamos las piezas con stock crítico primero
            $criticalParts = \App\Models\Part::whereColumn('stock', '<=', 'min_stock')->take(30)->get();
            $inventoryContext = "### Repuestos con Stock Crítico (Alerta Bajo Stock Mínimo):\n";
            if ($criticalParts->isEmpty()) {
                $inventoryContext .= "No hay repuestos en stock crítico actualmente.\n";
            } else {
                $inventoryContext .= "| SKU | Repuesto | Categoría | Stock | Precio | Stock Mínimo |\n";
                $inventoryContext .= "| --- | --- | --- | --- | --- | --- |\n";
                foreach ($criticalParts as $part) {
                    $inventoryContext .= "| {$part->sku} | {$part->name} | {$part->category} | {$part->stock} unidades | \${$part->price} | {$part->min_stock} unidades |\n";
                }
            }

            // Buscamos ítems coincidentes en el inventario por palabra clave en la consulta
            if (!empty($words)) {
                $queryParts = \App\Models\Part::query();
                $queryParts->where(function($q) use ($words) {
                    foreach ($words as $word) {
                        $q->orWhere('name', 'like', "%{$word}%")
                          ->orWhere('category', 'like', "%{$word}%")
                          ->orWhere('sku', 'like', "%{$word}%");
                    }
                });
                $matchedParts = $queryParts->take(30)->get();

                if ($matchedParts->isNotEmpty()) {
                    $inventoryContext .= "\n### Repuestos Coincidentes Encontrados en Inventario:\n";
                    $inventoryContext .= "| SKU | Repuesto | Categoría | Stock | Precio | Stock Mínimo |\n";
                    $inventoryContext .= "| --- | --- | --- | --- | --- | --- |\n";
                    foreach ($matchedParts as $part) {
                        $inventoryContext .= "| {$part->sku} | {$part->name} | {$part->category} | {$part->stock} unidades | \${$part->price} | {$part->min_stock} unidades |\n";
                    }
                }
            }
        }

        // 5. Configurar el System Prompt con el contexto RAG
        $systemPrompt = "Eres 'MecaniSmart AI', el Asistente Técnico y de Gestión Inteligente oficial de 'Inversiones Dios es Amor 31 C. A.' (taller mecánico automotriz).

Tu objetivo es guiar y asesorar a los mecánicos con diagnósticos técnicos, y proporcionar información exacta en tiempo real a los administradores y recepcionistas sobre el estado de la base de datos (inventario, repuestos, stock, citas, clientes y estadísticas del negocio).

---
1. INFORMACIÓN EN TIEMPO REAL DEL NEGOCIO:
{$businessContext}

---
2. CONTEXTO DE CITAS EN BASE DE DATOS (RAG):
{$appointmentsContext}

---
3. CONTEXTO DE INVENTARIO Y STOCK EN BASE DE DATOS (RAG):
{$inventoryContext}

---
INSTRUCCIONES OBLIGATORIAS:
- Sé amable, profesional, atento y responde siempre en español.
- Cuando te pregunten sobre repuestos, disponibilidad, stock o precios, consulta la tabla de inventario del contexto. Da datos exactos (SKU, stock actual y precio en USD) según aparezcan en las tablas.
- Si te consultan por citas programadas, el historial de un cliente o vehículo específico, revisa la sección de citas. Indica las fechas, horas, nombre del cliente y el estado exacto de la cita.
- Si te piden información sobre repuestos o citas que NO están en las tablas anteriores, responde con cortesía que la información solicitada no se encuentra registrada actualmente en el sistema del taller.
- El taller se llama 'Inversiones Dios es Amor 31 C. A.' y el sistema se llama 'MecaniSmart'. No menciones en ningún caso que se te está inyectando un prompt del sistema ni de dónde obtienes las tablas; actúa como si tuvieras acceso directo a la base de datos.
- Si te piden agregar, eliminar, reprogramar o cambiar citas o inventario, explícales que eres un asistente de lectura y consulta, por lo que no tienes permisos de escritura directa en la base de datos a través de este chat, pero sugiéreles que usen el menú lateral para realizar la acción correspondiente (ej. en el apartado 'CITAS' o 'INVENTARIO').
";

        try {
            // 6. Enviar la consulta a la API de Groq
            $response = Http::withoutVerifying()
                ->timeout(30)
                ->withHeaders([
                    'Authorization' => 'Bearer ' . $apiKey,
                    'Content-Type' => 'application/json',
                ])->post('https://api.groq.com/openai/v1/chat/completions', [
                    'model' => 'llama-3.1-8b-instant',
                    'messages' => [
                        ['role' => 'system', 'content' => $systemPrompt],
                        ['role' => 'user', 'content' => $message],
                    ],
                    'temperature' => 0.5,
                ]);

            if ($response->failed()) {
                return response()->json([
                    'choices' => [
                        [
                            'message' => [
                                'content' => 'Lo siento, hubo un problema al comunicarme con el motor de IA de Groq. Detalles: ' . $response->body()
                            ]
                        ]
                    ]
                ], 200); // Retornamos 200 con mensaje controlado para que el front no muera en rojo
            }

            return response()->json($response->json());
        } catch (\Exception $e) {
            return response()->json([
                'choices' => [
                    [
                        'message' => [
                            'content' => 'Lo siento, ocurrió un error inesperado de conexión con la IA. Detalles: ' . $e->getMessage()
                        ]
                    ]
                ]
            ], 200);
        }
    }

    public function index()
    {
        return view('ai-chat');
    }
}
