<x-app-layout>
    <x-slot name="header">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h2 class="font-bold text-2xl text-white leading-tight">
                        {{ __('Órdenes de Trabajo') }}
                    </h2>
                    <p class="text-slate-400 text-sm mt-1">Control de flujo y estados de reparación.</p>
                </div>
                @php $isAdmin = in_array(Auth::user()->role, ['admin']); @endphp
                <div class="flex gap-3">
                    @if($isAdmin)
                    <a href="{{ route('reports.orders') }}" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl transition-all shadow-lg shadow-blue-500/20 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                        </svg>
                        Generar Reporte
                    </a>
                    @endif
                    <a href="{{ route('orders.create') }}" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl transition-all shadow-lg shadow-blue-500/20 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                        </svg>
                        Abrir Orden
                    </a>
                </div>
            </div>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        @if (session('status'))
            <div class="mb-6 p-4 bg-green-500/10 border border-green-500/20 rounded-xl text-green-400 font-bold text-sm">
                {{ session('status') }}
            </div>
        @endif

        <div class="grid grid-cols-1 gap-6">
            @forelse($orders as $order)
                <div class="premium-card rounded-2xl p-6 shadow-xl border-l-4 {{ $order->status == 'pending' ? 'border-l-yellow-500' : 'border-l-green-500' }} group hover:scale-[1.01] transition-all">
                    <div class="flex flex-col md:flex-row justify-between gap-6">
                        <div class="flex gap-4">
                            <div class="w-16 h-16 bg-slate-800 rounded-2xl flex items-center justify-center border border-slate-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                            <div>
                                <div class="flex items-center gap-2 mb-1">
                                    <span class="text-[10px] font-black {{ $order->status == 'pending' ? 'bg-yellow-500/10 text-yellow-500 border-yellow-500/20' : 'bg-green-500/10 text-green-500 border-green-500/20' }} px-2 py-0.5 rounded uppercase tracking-widest border">
                                        {{ $order->status == 'pending' ? 'En Espera' : 'Finalizada' }}
                                    </span>
                                    <span class="text-xs text-slate-500 font-bold">#OT-{{ $order->id }}</span>
                                </div>
                                <h3 class="text-lg font-bold text-white">{{ $order->vehicle->make }} {{ $order->vehicle->model }}</h3>
                                <p class="text-sm text-slate-400">Cliente: {{ $order->customer->name }} • <span class="text-blue-400 font-bold">Placa: {{ $order->vehicle->license_plate }}</span></p>
                            </div>
                        </div>
                        <div class="flex flex-col justify-between items-end gap-2">
                            <div class="text-right">
                                @money($order->total_amount)
                            </div>
                            <div class="flex items-center gap-2">
                                @if($isAdmin)
                                    @if($order->invoice)
                                        <a href="{{ route('invoices.show', $order->invoice) }}" class="px-4 py-2 bg-green-600/10 hover:bg-green-600/20 text-xs font-bold text-green-500 rounded-lg transition-colors border border-green-500/20">Ver Factura</a>
                                    @else
                                        <form action="{{ route('invoices.store') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="service_order_id" value="{{ $order->id }}">
                                            <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-xs font-bold text-white rounded-lg transition-colors shadow-lg shadow-blue-500/20">Generar Factura</button>
                                        </form>
                                    @endif
                                @endif
                                <a href="{{ route('orders.show', $order->id) }}" class="px-4 py-2 bg-slate-800 hover:bg-slate-700 text-xs font-bold text-slate-300 rounded-lg transition-colors border border-slate-700">Ver Detalles</a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="premium-card p-12 text-center text-slate-500 rounded-2xl border border-dashed border-slate-700">
                    No hay órdenes de trabajo abiertas.
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>
