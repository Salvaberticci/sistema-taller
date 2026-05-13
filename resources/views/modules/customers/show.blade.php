<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="font-bold text-2xl text-white leading-tight flex items-center gap-3">
                    <a href="{{ route('customers.index') }}" class="text-slate-500 hover:text-white transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                    </a>
                    {{ __('Detalles del Cliente') }}
                </h2>
                <p class="text-slate-400 text-sm mt-1 ml-9">Información completa de {{ $customer->name }}.</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('customers.edit', $customer->id) }}" class="px-4 py-2 bg-slate-700 hover:bg-slate-600 text-white font-bold rounded-xl transition-all shadow-lg flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                    </svg>
                    Editar
                </a>
                <a href="{{ route('vehicles.create', ['customer_id' => $customer->id]) }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl transition-all shadow-lg shadow-blue-500/20 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                    Añadir Vehículo
                </a>
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <!-- Tarjeta de Información del Cliente -->
        <div class="premium-card rounded-2xl shadow-xl overflow-hidden bg-slate-900 border border-slate-800">
            <div class="p-6 border-b border-slate-700 bg-slate-800/30 flex items-center gap-4">
                <div class="w-16 h-16 bg-blue-600/20 rounded-2xl flex items-center justify-center font-bold text-3xl text-blue-500">
                    {{ substr($customer->name, 0, 1) }}
                </div>
                <div>
                    <h3 class="text-xl font-bold text-white">{{ $customer->name }}</h3>
                    <p class="text-slate-400 text-sm">Registrado el {{ $customer->created_at->format('d/m/Y') }}</p>
                </div>
            </div>
            <div class="p-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div>
                    <p class="text-xs text-slate-500 font-bold uppercase tracking-wider mb-1">Teléfono</p>
                    <p class="text-slate-300">{{ $customer->phone ?: 'No especificado' }}</p>
                </div>
                <div>
                    <p class="text-xs text-slate-500 font-bold uppercase tracking-wider mb-1">Correo Electrónico</p>
                    <p class="text-slate-300">{{ $customer->email ?: 'No especificado' }}</p>
                </div>
                <div class="lg:col-span-3">
                    <p class="text-xs text-slate-500 font-bold uppercase tracking-wider mb-1">Dirección</p>
                    <p class="text-slate-300">{{ $customer->address ?: 'No especificada' }}</p>
                </div>
            </div>
        </div>

        <!-- Sección de Vehículos -->
        <div>
            <h3 class="text-lg font-bold text-white mb-4">Vehículos Asociados</h3>
            
            @if($customer->vehicles->count() > 0)
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    @foreach($customer->vehicles as $vehicle)
                        <div class="premium-card rounded-2xl shadow-xl overflow-hidden bg-slate-800/50 border border-slate-700 hover:border-blue-500/50 transition-colors">
                            <div class="p-5 flex justify-between items-start border-b border-slate-700/50">
                                <div>
                                    <div class="flex items-center gap-2 mb-1">
                                        <h4 class="text-lg font-bold text-white">{{ $vehicle->make }} {{ $vehicle->model }}</h4>
                                        <span class="px-2 py-0.5 bg-slate-700 text-slate-300 text-xs font-bold rounded">{{ $vehicle->year }}</span>
                                    </div>
                                    <p class="text-blue-400 font-mono text-sm">{{ $vehicle->license_plate }}</p>
                                </div>
                                <a href="{{ route('vehicles.show', $vehicle->id) }}" class="p-2 bg-slate-700/50 hover:bg-slate-600 text-white rounded-lg transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </a>
                            </div>
                            <div class="p-5 bg-slate-900/30">
                                <p class="text-xs text-slate-500 font-bold uppercase tracking-wider mb-2">Historial de Órdenes ({{ $vehicle->serviceOrders->count() }})</p>
                                
                                @if($vehicle->serviceOrders->count() > 0)
                                    <div class="space-y-2">
                                        @foreach($vehicle->serviceOrders->take(3) as $order)
                                            <a href="{{ route('orders.show', $order->id) }}" class="block p-3 bg-slate-800 rounded-xl border border-slate-700 hover:border-slate-600 transition-colors">
                                                <div class="flex justify-between items-center">
                                                    <span class="text-sm font-bold text-white">#OT-{{ $order->id }}</span>
                                                    <span class="text-xs text-slate-400">{{ $order->created_at->format('d/m/Y') }}</span>
                                                </div>
                                                <p class="text-xs text-slate-400 mt-1 truncate">{{ $order->description }}</p>
                                            </a>
                                        @endforeach
                                        
                                        @if($vehicle->serviceOrders->count() > 3)
                                            <a href="{{ route('orders.index', ['vehicle_id' => $vehicle->id]) }}" class="block text-center text-xs text-blue-400 hover:text-blue-300 font-bold mt-2">
                                                Ver todas las órdenes
                                            </a>
                                        @endif
                                    </div>
                                @else
                                    <p class="text-sm text-slate-500 italic">No hay órdenes de servicio registradas para este vehículo.</p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="premium-card rounded-2xl shadow-xl overflow-hidden bg-slate-800/30 border border-slate-700 p-8 text-center">
                    <div class="w-16 h-16 bg-slate-800 rounded-full flex items-center justify-center mx-auto mb-4 border border-slate-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <p class="text-slate-400 font-medium mb-4">Este cliente no tiene vehículos registrados aún.</p>
                    <a href="{{ route('vehicles.create', ['customer_id' => $customer->id]) }}" class="inline-flex px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl transition-all items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                        </svg>
                        Registrar su primer vehículo
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
