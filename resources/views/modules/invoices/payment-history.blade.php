<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="font-bold text-2xl text-white leading-tight">
                    {{ __('Historial de Pagos') }}
                </h2>
                <p class="text-slate-400 text-sm mt-1">Registro completo de todos los pagos del sistema.</p>
            </div>
            <a href="{{ route('invoices.index') }}" class="px-6 py-3 bg-slate-700 hover:bg-slate-600 text-white font-bold rounded-xl transition-all shadow-lg flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                </svg>
                Volver a Facturación
            </a>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
        @if (session('status'))
            <div class="p-4 bg-green-500/10 border border-green-500/20 rounded-xl text-green-400 font-bold text-sm">
                {{ session('status') }}
            </div>
        @endif

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="premium-card p-6 rounded-2xl shadow-lg border border-slate-700">
                <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Total Registrado</p>
                <h3 class="text-2xl font-black text-white mt-1">@money($totalRegistered)</h3>
                <p class="text-xs text-slate-400 mt-2">Todos los pagos</p>
            </div>
            <div class="premium-card p-6 rounded-2xl shadow-lg border border-green-500/20">
                <p class="text-xs font-bold text-green-500 uppercase tracking-wider">Confirmados</p>
                <h3 class="text-2xl font-black text-green-400 mt-1">@money($totalConfirmed)</h3>
                <p class="text-xs text-green-500/60 mt-2">Pagos verificados</p>
            </div>
            <div class="premium-card p-6 rounded-2xl shadow-lg border border-yellow-500/20">
                <p class="text-xs font-bold text-yellow-500 uppercase tracking-wider">Pendientes</p>
                <h3 class="text-2xl font-black text-yellow-400 mt-1">@money($totalPending)</h3>
                <p class="text-xs text-yellow-500/60 mt-2">Por confirmar</p>
            </div>
            <div class="premium-card p-6 rounded-2xl shadow-lg border border-red-500/20">
                <p class="text-xs font-bold text-red-500 uppercase tracking-wider">Rechazados</p>
                <h3 class="text-2xl font-black text-red-400 mt-1">@money($totalRejected)</h3>
                <p class="text-xs text-red-500/60 mt-2">Pagos anulados</p>
            </div>
        </div>

        <!-- Filters -->
        <div class="premium-card p-6 rounded-2xl border border-slate-700 bg-slate-800/30">
            <form method="GET" action="{{ route('payments.history') }}" class="flex flex-wrap gap-4 items-end">
                <div class="flex-1 min-w-[160px]">
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Estado</label>
                    <select name="status" class="w-full bg-slate-900 border border-slate-700 rounded-xl text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent p-3 text-sm">
                        <option value="">Todos</option>
                        <option value="pendiente" {{ request('status') === 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                        <option value="confirmado" {{ request('status') === 'confirmado' ? 'selected' : '' }}>Confirmado</option>
                        <option value="rechazado" {{ request('status') === 'rechazado' ? 'selected' : '' }}>Rechazado</option>
                    </select>
                </div>
                <div class="flex-1 min-w-[160px]">
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Método</label>
                    <select name="method" class="w-full bg-slate-900 border border-slate-700 rounded-xl text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent p-3 text-sm">
                        <option value="">Todos</option>
                        <option value="Efectivo" {{ request('method') === 'Efectivo' ? 'selected' : '' }}>Efectivo</option>
                        <option value="Transferencia" {{ request('method') === 'Transferencia' ? 'selected' : '' }}>Transferencia</option>
                        <option value="Pago Móvil" {{ request('method') === 'Pago Móvil' ? 'selected' : '' }}>Pago Móvil</option>
                        <option value="Tarjeta" {{ request('method') === 'Tarjeta' ? 'selected' : '' }}>Tarjeta</option>
                        <option value="Zelle / Divisas" {{ request('method') === 'Zelle / Divisas' ? 'selected' : '' }}>Zelle / Divisas</option>
                    </select>
                </div>
                <button type="submit" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl transition-all shadow-lg shadow-blue-500/20">
                    Filtrar
                </button>
                @if(request()->hasAny(['status', 'method']))
                    <a href="{{ route('payments.history') }}" class="px-6 py-3 bg-slate-700 hover:bg-slate-600 text-white font-bold rounded-xl transition-all">
                        Limpiar
                    </a>
                @endif
            </form>
        </div>

        <!-- Payments Table -->
        <div class="premium-card rounded-2xl shadow-xl overflow-hidden border border-slate-700">
            <div class="p-6 border-b border-slate-700 bg-slate-800/30 flex items-center justify-between">
                <h3 class="font-bold text-lg text-white">Registro de Pagos</h3>
                <span class="text-xs font-bold text-slate-500">{{ $payments->count() }} pagos encontrados</span>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-slate-800/50 text-xs text-slate-400 uppercase font-black">
                        <tr>
                            <th class="px-6 py-4">Fecha</th>
                            <th class="px-6 py-4">Factura</th>
                            <th class="px-6 py-4">Cliente</th>
                            <th class="px-6 py-4">Monto</th>
                            <th class="px-6 py-4">Método</th>
                            <th class="px-6 py-4">Referencia</th>
                            <th class="px-6 py-4">Estado</th>
                            <th class="px-6 py-4 text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-700">
                        @forelse($payments as $payment)
                            <tr class="hover:bg-slate-800/30 transition-colors">
                                <td class="px-6 py-4">
                                    <p class="text-sm font-bold text-white">{{ $payment->payment_date?->format('d/m/Y') ?? '-' }}</p>
                                    <p class="text-[10px] text-slate-500">{{ $payment->payment_date?->format('H:i') ?? '' }}</p>
                                </td>
                                <td class="px-6 py-4">
                                    <a href="{{ route('invoices.show', $payment->invoice) }}" class="text-blue-400 font-bold text-sm hover:underline">
                                        {{ $payment->invoice->number }}
                                    </a>
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-300">
                                    {{ $payment->invoice->serviceOrder->customer->name ?? 'N/A' }}
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-white font-bold">@money($payment->amount)</span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-xs text-slate-400 font-bold uppercase">{{ $payment->method }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-xs text-slate-500 font-mono">{{ $payment->reference ?? '-' }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    @php
                                        $statusConfig = match($payment->status) {
                                            'confirmado' => ['class' => 'bg-green-500/10 text-green-500 border-green-500/20', 'label' => 'CONFIRMADO'],
                                            'rechazado' => ['class' => 'bg-red-500/10 text-red-500 border-red-500/20', 'label' => 'RECHAZADO'],
                                            default => ['class' => 'bg-yellow-500/10 text-yellow-500 border-yellow-500/20', 'label' => 'PENDIENTE'],
                                        };
                                    @endphp
                                    <span class="px-3 py-1 {{ $statusConfig['class'] }} text-[10px] font-black rounded-full border uppercase tracking-widest">
                                        {{ $statusConfig['label'] }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex justify-center gap-2">
                                        @if($payment->isPending())
                                            <form action="{{ route('payments.confirm', $payment) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="p-2 bg-green-600/20 hover:bg-green-600/40 text-green-400 hover:text-green-300 rounded-lg border border-green-500/20 transition-all" title="Confirmar">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                                    </svg>
                                                </button>
                                            </form>
                                            <form action="{{ route('payments.reject', $payment) }}" method="POST" onsubmit="return confirm('¿Seguro que desea rechazar este pago?')">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="p-2 bg-red-600/20 hover:bg-red-600/40 text-red-400 hover:text-red-300 rounded-lg border border-red-500/20 transition-all" title="Rechazar">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                    </svg>
                                                </button>
                                            </form>
                                        @else
                                            <a href="{{ route('invoices.show', $payment->invoice) }}" class="p-2 text-slate-400 hover:text-blue-400 transition-colors" title="Ver factura">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                                    <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                                </svg>
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-12 text-center text-slate-500">No se encontraron pagos.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
