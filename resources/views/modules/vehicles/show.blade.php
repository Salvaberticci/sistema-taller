<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="font-bold text-2xl text-white leading-tight flex items-center gap-3">
                    <a href="{{ route('vehicles.index') }}" class="text-slate-500 hover:text-white transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                    </a>
                    {{ __('Detalles del Vehículo') }}
                </h2>
                <p class="text-slate-400 text-sm mt-1 ml-9">{{ $vehicle->make }} {{ $vehicle->model }} ({{ $vehicle->year }})</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('vehicles.edit', $vehicle->id) }}" class="px-4 py-2 bg-slate-700 hover:bg-slate-600 text-white font-bold rounded-xl transition-all shadow-lg flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                    </svg>
                    Editar
                </a>
                <a href="{{ route('orders.create', ['vehicle_id' => $vehicle->id]) }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl transition-all shadow-lg shadow-blue-500/20 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                    Nueva Orden
                </a>
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- Tarjeta de Información del Vehículo -->
            <div class="lg:col-span-2 space-y-6">
                <div class="premium-card rounded-2xl shadow-xl overflow-hidden bg-slate-900 border border-slate-800">
                    <div class="p-6 border-b border-slate-700 bg-slate-800/30 flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            <div class="w-16 h-16 bg-blue-600/20 rounded-2xl flex items-center justify-center font-bold text-3xl text-blue-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-white">{{ $vehicle->make }} {{ $vehicle->model }}</h3>
                                <p class="text-blue-400 font-mono text-sm font-bold uppercase tracking-widest">{{ $vehicle->license_plate }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-xs text-slate-500 font-bold uppercase tracking-wider">Año</p>
                            <p class="text-xl font-black text-white">{{ $vehicle->year }}</p>
                        </div>
                    </div>
                    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <p class="text-xs text-slate-500 font-bold uppercase tracking-wider mb-1">Color</p>
                            <p class="text-slate-300">{{ $vehicle->color ?: 'No especificado' }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-500 font-bold uppercase tracking-wider mb-1">VIN / Chasis</p>
                            <p class="text-slate-300">{{ $vehicle->vin ?: 'No especificado' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Historial de Órdenes -->
                <div class="premium-card rounded-2xl shadow-xl overflow-hidden bg-slate-900 border border-slate-800">
                    <div class="p-6 border-b border-slate-700 bg-slate-800/30 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        <h3 class="text-lg font-bold text-white">Historial de Servicio</h3>
                    </div>
                    <div class="p-0">
                        @if($vehicle->serviceOrders->count() > 0)
                            <table class="w-full text-left">
                                <thead class="bg-slate-800/50 text-xs text-slate-400 uppercase">
                                    <tr>
                                        <th class="px-6 py-4 font-bold">Orden</th>
                                        <th class="px-6 py-4 font-bold">Fecha</th>
                                        <th class="px-6 py-4 font-bold">Estado</th>
                                        <th class="px-6 py-4 font-bold text-right">Total</th>
                                        <th class="px-6 py-4 font-bold"></th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-700">
                                    @foreach($vehicle->serviceOrders as $order)
                                        <tr class="hover:bg-slate-800/30 transition-colors">
                                            <td class="px-6 py-4">
                                                <p class="text-sm font-bold text-white">#OT-{{ $order->id }}</p>
                                            </td>
                                            <td class="px-6 py-4">
                                                <p class="text-sm text-slate-400">{{ $order->created_at->format('d/m/Y') }}</p>
                                            </td>
                                            <td class="px-6 py-4">
                                                <span class="text-[10px] font-black {{ $order->status == 'pending' ? 'bg-yellow-500/10 text-yellow-500 border-yellow-500/20' : 'bg-green-500/10 text-green-500 border-green-500/20' }} px-2 py-0.5 rounded uppercase tracking-widest border">
                                                    {{ $order->status == 'pending' ? 'En Espera' : 'Finalizada' }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 text-right">
                                                <p class="text-sm font-bold text-white">${{ number_format($order->total_amount, 2) }}</p>
                                            </td>
                                            <td class="px-6 py-4 text-right">
                                                <a href="{{ route('orders.show', $order->id) }}" class="text-slate-500 hover:text-white transition-colors">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                                    </svg>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <div class="p-8 text-center">
                                <p class="text-slate-500 font-medium">No hay historial de servicio para este vehículo.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Panel Lateral (Propietario) -->
            <div class="space-y-6">
                <div class="premium-card rounded-2xl shadow-xl overflow-hidden bg-slate-900 border border-slate-800">
                    <div class="p-5 border-b border-slate-700 bg-slate-800/30">
                        <h3 class="text-sm font-bold text-slate-400 uppercase tracking-wider flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            Propietario
                        </h3>
                    </div>
                    <div class="p-5 space-y-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-blue-600/20 rounded-full flex items-center justify-center font-bold text-blue-500">
                                {{ substr($vehicle->customer->name, 0, 1) }}
                            </div>
                            <div>
                                <p class="text-base font-bold text-white">{{ $vehicle->customer->name }}</p>
                                <p class="text-xs text-slate-500">{{ $vehicle->customer->phone }}</p>
                            </div>
                        </div>
                        <a href="{{ route('customers.show', $vehicle->customer->id) }}" class="w-full block text-center px-4 py-2 bg-slate-800 hover:bg-slate-700 text-sm font-bold text-white rounded-xl transition-colors border border-slate-700">
                            Ver Perfil Completo
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
