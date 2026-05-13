<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-white leading-tight">
            {{ __('Inversiones Dios es Amor 31 C. A.') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Stat Card 1 -->
            <div class="premium-card p-6 rounded-2xl shadow-lg flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Ventas del Mes</p>
                    <h3 class="text-2xl font-bold text-white mt-1">${{ number_format($monthlySales, 2) }}</h3>
                    <p class="text-xs text-green-400 font-bold mt-2">Facturación actual</p>
                </div>
                <div class="bg-blue-600/20 p-3 rounded-xl">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>

            <!-- Stat Card 2 -->
            <div class="premium-card p-6 rounded-2xl shadow-lg flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Órdenes Activas</p>
                    <h3 class="text-2xl font-bold text-white mt-1">{{ $activeOrdersCount }}</h3>
                    <p class="text-xs text-orange-400 font-bold mt-2">{{ $readyToDeliverCount }} finalizadas hoy</p>
                </div>
                <div class="bg-orange-600/20 p-3 rounded-xl">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                    </svg>
                </div>
            </div>

            <!-- Stat Card 3 -->
            <div class="premium-card p-6 rounded-2xl shadow-lg flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Total Clientes</p>
                    <h3 class="text-2xl font-bold text-white mt-1">{{ $customersCount }}</h3>
                    <p class="text-xs text-purple-400 font-bold mt-2">Base de datos activa</p>
                </div>
                <div class="bg-purple-600/20 p-3 rounded-xl">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
            </div>

            <!-- Stat Card 4 -->
            <div class="premium-card p-6 rounded-2xl shadow-lg flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Estado Sistema</p>
                    <h3 class="text-2xl font-bold text-white mt-1">Online</h3>
                    <p class="text-xs text-green-400 font-bold mt-2">Conectado a la base de datos</p>
                </div>
                <div class="bg-green-600/20 p-3 rounded-xl">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Table -->
            <div class="lg:col-span-2 premium-card rounded-2xl shadow-lg overflow-hidden">
                <div class="p-6 border-b border-slate-700 flex justify-between items-center">
                    <h3 class="font-bold text-lg text-white">Órdenes Recientes</h3>
                    <a href="{{ route('orders.index') }}" class="text-sm text-blue-500 font-bold hover:underline">Ver todas</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-slate-800/50 text-xs text-slate-400 uppercase">
                            <tr>
                                <th class="px-6 py-4 font-bold">Vehículo</th>
                                <th class="px-6 py-4 font-bold">Cliente</th>
                                <th class="px-6 py-4 font-bold">Estado</th>
                                <th class="px-6 py-4 font-bold">Total</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-700">
                            @forelse($recentOrders as $order)
                                <tr class="hover:bg-slate-800/30 transition-colors">
                                    <td class="px-6 py-4">
                                        <p class="text-sm font-bold text-white">{{ $order->vehicle->make }} {{ $order->vehicle->model }}</p>
                                        <p class="text-xs text-slate-500 font-mono">{{ $order->vehicle->license_plate }}</p>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-slate-300">{{ $order->customer->name }}</td>
                                    <td class="px-6 py-4">
                                        <span class="px-3 py-1 {{ $order->status == 'pending' ? 'bg-yellow-500/10 text-yellow-500 border-yellow-500/20' : 'bg-green-500/10 text-green-500 border-green-500/20' }} text-[10px] font-black rounded-full border uppercase tracking-widest">
                                            {{ $order->status == 'pending' ? 'EN PROCESO' : 'COMPLETADA' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm font-bold text-white">${{ number_format($order->total_amount, 2) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-8 text-center text-slate-500">
                                        No hay órdenes recientes para mostrar.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- AI Sidebar -->
            <div class="bg-gradient-to-br from-blue-700 to-indigo-900 rounded-2xl p-8 text-white shadow-xl flex flex-col justify-between">
                <div>
                    <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center mb-6 border border-white/20">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-4">Asistente IA</h3>
                    <p class="text-blue-100 text-sm leading-relaxed opacity-90">
                        Optimiza tu taller con diagnósticos inteligentes y búsqueda rápida de repuestos.
                    </p>
                </div>
                <div class="mt-8">
                    <a href="{{ route('ai.chat') }}" class="block w-full py-4 bg-white text-blue-700 text-center font-bold rounded-xl hover:bg-blue-50 transition-all active:scale-95 shadow-lg">
                        Iniciar Chat
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
