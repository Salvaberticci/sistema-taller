<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="font-bold text-2xl text-white leading-tight flex items-center gap-3">
                    <a href="{{ route('orders.index') }}" class="text-slate-500 hover:text-white transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                    </a>
                    {{ __('Detalles de Orden #OT-') }}{{ $order->id }}
                </h2>
                <p class="text-slate-400 text-sm mt-1 ml-9">Registrada el {{ $order->entry_date ? \Carbon\Carbon::parse($order->entry_date)->format('d/m/Y H:i') : ($order->created_at ? $order->created_at->format('d/m/Y H:i') : 'Fecha no disponible') }}</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('orders.edit', $order->id) }}" class="px-4 py-2 bg-slate-700 hover:bg-slate-600 text-white font-bold rounded-xl transition-all shadow-lg flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                    </svg>
                    Editar Orden
                </a>
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- Resumen y Detalles Principales -->
            <div class="lg:col-span-2 space-y-6">
                
                <!-- Descripción del Problema -->
                <div class="premium-card rounded-2xl shadow-xl overflow-hidden bg-slate-900 border border-slate-800">
                    <div class="p-6 border-b border-slate-700 bg-slate-800/30 flex justify-between items-center">
                        <h3 class="text-lg font-bold text-white flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Descripción del Trabajo
                        </h3>
                        <span class="text-[10px] font-black {{ $order->status == 'pending' ? 'bg-yellow-500/10 text-yellow-500 border-yellow-500/20' : 'bg-green-500/10 text-green-500 border-green-500/20' }} px-3 py-1 rounded-full uppercase tracking-widest border">
                            {{ $order->status == 'pending' ? 'En Espera' : 'Finalizada' }}
                        </span>
                    </div>
                    <div class="p-6 text-slate-300 leading-relaxed whitespace-pre-wrap">{{ $order->description }}</div>
                </div>

                <!-- Elementos de Trabajo (Work Items) -->
                <div class="premium-card rounded-2xl shadow-xl overflow-hidden bg-slate-900 border border-slate-800">
                    <div class="p-6 border-b border-slate-700 bg-slate-800/30 flex justify-between items-center">
                        <h3 class="text-lg font-bold text-white flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            Servicios y Repuestos
                        </h3>
                    </div>
                    <div class="p-0">
                        @if($order->workItems->count() > 0)
                            <table class="w-full text-left">
                                <thead class="bg-slate-800/50 text-xs text-slate-400 uppercase">
                                    <tr>
                                        <th class="px-6 py-4 font-bold">Concepto</th>
                                        <th class="px-6 py-4 font-bold text-center">Cant.</th>
                                        <th class="px-6 py-4 font-bold text-right">Precio Unit.</th>
                                        <th class="px-6 py-4 font-bold text-right">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-700">
                                    @foreach($order->workItems as $item)
                                        <tr class="hover:bg-slate-800/30 transition-colors">
                                            <td class="px-6 py-4">
                                                <p class="text-sm font-bold text-white">{{ $item->description }}</p>
                                            </td>
                                            <td class="px-6 py-4 text-center">
                                                <span class="text-sm text-slate-300">{{ $item->quantity }}</span>
                                            </td>
                                            <td class="px-6 py-4 text-right">
                                                <span class="text-sm text-slate-300">${{ number_format($item->unit_price, 2) }}</span>
                                            </td>
                                            <td class="px-6 py-4 text-right">
                                                <span class="text-sm font-bold text-white">${{ number_format($item->quantity * $item->unit_price, 2) }}</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot class="bg-slate-800/50">
                                    <tr>
                                        <td colspan="3" class="px-6 py-4 text-right text-xs font-bold text-slate-400 uppercase tracking-wider">
                                            Total Estimado
                                        </td>
                                        <td class="px-6 py-4 text-right text-lg font-black text-blue-400">
                                            ${{ number_format($order->total_amount, 2) }}
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        @else
                            <div class="p-8 text-center">
                                <p class="text-slate-500 font-medium">No se han registrado servicios o repuestos en esta orden.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Panel Lateral (Cliente y Vehículo) -->
            <div class="space-y-6">
                
                <!-- Vehículo -->
                <div class="premium-card rounded-2xl shadow-xl overflow-hidden bg-slate-900 border border-slate-800">
                    <div class="p-5 border-b border-slate-700 bg-slate-800/30">
                        <h3 class="text-sm font-bold text-slate-400 uppercase tracking-wider flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0" />
                            </svg>
                            Vehículo
                        </h3>
                    </div>
                    <div class="p-5">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-12 h-12 bg-slate-800 rounded-xl flex items-center justify-center font-bold text-slate-400 border border-slate-700">
                                {{ $order->vehicle->year }}
                            </div>
                            <div>
                                <p class="text-lg font-bold text-white">{{ $order->vehicle->make }} {{ $order->vehicle->model }}</p>
                                <p class="text-blue-400 font-mono text-sm font-bold">{{ $order->vehicle->license_plate }}</p>
                            </div>
                        </div>
                        <a href="{{ route('vehicles.show', $order->vehicle->id) }}" class="w-full block text-center px-4 py-2 bg-slate-800 hover:bg-slate-700 text-sm font-bold text-white rounded-xl transition-colors border border-slate-700">
                            Ver Historial del Vehículo
                        </a>
                    </div>
                </div>

                <!-- Cliente -->
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
                                {{ substr($order->customer->name, 0, 1) }}
                            </div>
                            <div>
                                <p class="text-base font-bold text-white">{{ $order->customer->name }}</p>
                            </div>
                        </div>
                        <div class="space-y-2">
                            <p class="text-sm text-slate-300 flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                                {{ $order->customer->phone ?: 'No especificado' }}
                            </p>
                            <p class="text-sm text-slate-300 flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                {{ $order->customer->email ?: 'No especificado' }}
                            </p>
                        </div>
                        <a href="{{ route('customers.show', $order->customer->id) }}" class="w-full block text-center px-4 py-2 bg-slate-800 hover:bg-slate-700 text-sm font-bold text-white rounded-xl transition-colors border border-slate-700 mt-2">
                            Ver Perfil del Cliente
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
