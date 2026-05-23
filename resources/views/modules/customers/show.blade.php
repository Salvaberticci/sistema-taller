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
                    <p class="text-xs text-slate-500 font-bold uppercase tracking-wider mb-1">Cédula / RIF</p>
                    <p class="text-slate-300">{{ $customer->id_card ?: 'No especificada' }}</p>
                </div>
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

        <!-- Resumen General -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="premium-card rounded-2xl shadow-xl overflow-hidden bg-slate-900 border border-slate-800 p-5">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-blue-600/20 rounded-xl flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-slate-500 font-bold uppercase tracking-wider">Vehículos</p>
                        <p class="text-2xl font-black text-white">{{ $customer->vehicles->count() }}</p>
                    </div>
                </div>
            </div>
            <div class="premium-card rounded-2xl shadow-xl overflow-hidden bg-slate-900 border border-slate-800 p-5">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-emerald-600/20 rounded-xl flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-slate-500 font-bold uppercase tracking-wider">Órdenes Totales</p>
                        <p class="text-2xl font-black text-white">{{ $customer->vehicles->sum(fn($v) => $v->serviceOrders->count()) }}</p>
                    </div>
                </div>
            </div>
            <div class="premium-card rounded-2xl shadow-xl overflow-hidden bg-slate-900 border border-slate-800 p-5">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-amber-600/20 rounded-xl flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-slate-500 font-bold uppercase tracking-wider">Total Facturado</p>
                        <p class="text-2xl font-black text-white">${{ number_format($customer->vehicles->sum(fn($v) => $v->serviceOrders->sum('total_amount')), 2) }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Historial por Vehículo -->
        <div>
            <h3 class="text-lg font-bold text-white mb-4 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Historial por Vehículo
            </h3>
            
            @if($customer->vehicles->count() > 0)
                <div class="space-y-6">
                    @foreach($customer->vehicles as $vehicle)
                        @php
                            $vehicleTotal = $vehicle->serviceOrders->sum('total_amount');
                            $completedOrders = $vehicle->serviceOrders->where('status', 'completed')->count();
                            $pendingOrders = $vehicle->serviceOrders->where('status', 'pending')->count();
                            $lastService = $vehicle->serviceOrders->sortByDesc('created_at')->first();
                        @endphp
                        <div class="premium-card rounded-2xl shadow-xl overflow-hidden bg-slate-900 border border-slate-800">
                            <!-- Cabecera del Vehículo -->
                            <div class="p-5 border-b border-slate-700 bg-slate-800/30">
                                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                                    <div class="flex items-center gap-4">
                                        <div class="w-14 h-14 bg-blue-600/20 rounded-2xl flex items-center justify-center flex-shrink-0">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0" />
                                            </svg>
                                        </div>
                                        <div>
                                            <div class="flex items-center gap-2 mb-1">
                                                <h4 class="text-lg font-bold text-white">{{ $vehicle->make }} {{ $vehicle->model }}</h4>
                                                <span class="px-2 py-0.5 bg-slate-700 text-slate-300 text-xs font-bold rounded">{{ $vehicle->year }}</span>
                                            </div>
                                            <p class="text-blue-400 font-mono text-sm font-bold uppercase tracking-widest">{{ $vehicle->license_plate }}</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-3">
                                        <div class="flex gap-4 text-center">
                                            <div>
                                                <p class="text-xs text-slate-500 font-bold uppercase">Órdenes</p>
                                                <p class="text-lg font-black text-white">{{ $vehicle->serviceOrders->count() }}</p>
                                            </div>
                                            <div>
                                                <p class="text-xs text-slate-500 font-bold uppercase">Total</p>
                                                <p class="text-lg font-black text-emerald-400">${{ number_format($vehicleTotal, 2) }}</p>
                                            </div>
                                        </div>
                                        <a href="{{ route('vehicles.show', $vehicle->id) }}" class="p-2 bg-slate-700/50 hover:bg-slate-600 text-white rounded-lg transition-colors" title="Ver detalles del vehículo">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </a>
                                    </div>
                                </div>

                                <!-- Mini resumen de estados -->
                                @if($vehicle->serviceOrders->count() > 0)
                                    <div class="flex items-center gap-4 mt-3 pt-3 border-t border-slate-700/50">
                                        @if($completedOrders > 0)
                                            <span class="flex items-center gap-1.5 text-xs text-green-400">
                                                <span class="w-2 h-2 bg-green-500 rounded-full"></span>
                                                {{ $completedOrders }} finalizada{{ $completedOrders > 1 ? 's' : '' }}
                                            </span>
                                        @endif
                                        @if($pendingOrders > 0)
                                            <span class="flex items-center gap-1.5 text-xs text-yellow-400">
                                                <span class="w-2 h-2 bg-yellow-500 rounded-full"></span>
                                                {{ $pendingOrders }} en espera
                                            </span>
                                        @endif
                                        @if($lastService)
                                            <span class="text-xs text-slate-500 ml-auto">
                                                Último servicio: {{ $lastService->created_at->format('d/m/Y') }}
                                            </span>
                                        @endif
                                    </div>
                                @endif
                            </div>

                            <!-- Lista de Órdenes de Servicio -->
                            <div class="divide-y divide-slate-800">
                                @if($vehicle->serviceOrders->count() > 0)
                                    @foreach($vehicle->serviceOrders->sortByDesc('created_at') as $order)
                                        <div class="group">
                                            <div class="p-4 hover:bg-slate-800/30 transition-colors cursor-pointer flex items-center justify-between gap-4" onclick="toggleOrderDetail('order-{{ $vehicle->id }}-{{ $order->id }}')">
                                                <div class="flex items-center gap-4 flex-1 min-w-0">
                                                    <!-- Timeline dot -->
                                                    <div class="flex flex-col items-center flex-shrink-0">
                                                        <div class="w-3 h-3 rounded-full {{ $order->status == 'completed' ? 'bg-green-500' : 'bg-yellow-500' }} ring-4 {{ $order->status == 'completed' ? 'ring-green-500/20' : 'ring-yellow-500/20' }}"></div>
                                                    </div>
                                                    <div class="flex-1 min-w-0">
                                                        <div class="flex items-center gap-2 mb-0.5">
                                                            <span class="text-sm font-bold text-white">#OT-{{ $order->id }}</span>
                                                            <span class="text-[10px] font-black {{ $order->status == 'pending' ? 'bg-yellow-500/10 text-yellow-500 border-yellow-500/20' : 'bg-green-500/10 text-green-500 border-green-500/20' }} px-2 py-0.5 rounded uppercase tracking-widest border">
                                                                {{ $order->status == 'pending' ? 'En Espera' : 'Finalizada' }}
                                                            </span>
                                                        </div>
                                                        <p class="text-xs text-slate-400 truncate">{{ $order->description ?: 'Sin descripción' }}</p>
                                                    </div>
                                                </div>
                                                <div class="flex items-center gap-4 flex-shrink-0">
                                                    <div class="text-right">
                                                        <p class="text-sm font-bold text-white">${{ number_format($order->total_amount, 2) }}</p>
                                                        <p class="text-xs text-slate-500">{{ $order->created_at->format('d/m/Y') }}</p>
                                                    </div>
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-500 group-hover:text-white transition-colors transform transition-transform duration-200" id="chevron-{{ $vehicle->id }}-{{ $order->id }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                                    </svg>
                                                </div>
                                            </div>

                                            <!-- Detalle expandible: Trabajos realizados -->
                                            <div id="order-{{ $vehicle->id }}-{{ $order->id }}" class="hidden bg-slate-800/20 border-t border-slate-800">
                                                <div class="p-4 pl-12">
                                                    @if($order->entry_date || $order->delivery_date)
                                                        <div class="flex gap-4 mb-3 text-xs text-slate-400">
                                                            @if($order->entry_date)
                                                                <span>📅 Ingreso: {{ \Carbon\Carbon::parse($order->entry_date)->format('d/m/Y') }}</span>
                                                            @endif
                                                            @if($order->delivery_date)
                                                                <span>📦 Entrega: {{ \Carbon\Carbon::parse($order->delivery_date)->format('d/m/Y') }}</span>
                                                            @endif
                                                        </div>
                                                    @endif

                                                    @if($order->workItems->count() > 0)
                                                        <p class="text-xs text-slate-500 font-bold uppercase tracking-wider mb-2">Trabajos Realizados</p>
                                                        <div class="space-y-2">
                                                            @foreach($order->workItems as $item)
                                                                <div class="flex items-center justify-between bg-slate-900/50 rounded-lg p-3 border border-slate-700/50">
                                                                    <div class="flex-1 min-w-0">
                                                                        <p class="text-sm text-white font-medium">{{ $item->description }}</p>
                                                                        @if($item->quantity && $item->quantity > 1)
                                                                            <p class="text-xs text-slate-500">Cantidad: {{ $item->quantity }}</p>
                                                                        @endif
                                                                    </div>
                                                                    <p class="text-sm font-bold text-emerald-400 ml-4">${{ number_format($item->total ?? $item->unit_price ?? 0, 2) }}</p>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    @else
                                                        <p class="text-xs text-slate-500 italic">No hay trabajos detallados para esta orden.</p>
                                                    @endif

                                                    <div class="mt-3 flex justify-end">
                                                        <a href="{{ route('orders.show', $order->id) }}" class="text-xs text-blue-400 hover:text-blue-300 font-bold flex items-center gap-1 transition-colors">
                                                            Ver orden completa
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                                            </svg>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="p-6 text-center">
                                        <p class="text-sm text-slate-500 italic">No hay órdenes de servicio registradas para este vehículo.</p>
                                    </div>
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

    <script>
        function toggleOrderDetail(id) {
            const el = document.getElementById(id);
            const chevron = document.getElementById('chevron-' + id.replace('order-', ''));
            if (el) {
                el.classList.toggle('hidden');
                if (chevron) {
                    chevron.style.transform = el.classList.contains('hidden') ? 'rotate(0deg)' : 'rotate(180deg)';
                }
            }
        }
    </script>
</x-app-layout>
