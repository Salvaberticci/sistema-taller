<x-app-layout>
    <x-slot name="header">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h2 class="font-bold text-2xl text-white leading-tight">
                        {{ __('Facturación y Pagos') }}
                    </h2>
                    <p class="text-slate-400 text-sm mt-1">Gestión de ingresos, facturas y flujo de caja.</p>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('payments.history') }}" class="px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-bold rounded-xl transition-all shadow-lg shadow-green-500/20 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                        </svg>
                        Historial de Pagos
                    </a>
                    <a href="{{ route('reports.invoices') }}" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl transition-all shadow-lg shadow-blue-500/20 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                        </svg>
                        Generar Reporte
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

        <!-- Tasa BCV -->
        <div class="premium-card p-4 rounded-2xl border border-slate-700 bg-slate-800/30 mb-6 flex items-center gap-4">
            <div class="w-10 h-10 bg-yellow-600/20 rounded-xl flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Tasa de Cambio BCV</p>
                <p class="text-xl font-black text-white">Bs. {{ number_format($bcvRate, 2) }} <span class="text-sm font-bold text-slate-500">por USD</span></p>
            </div>
        </div>

        <!-- Finance Overview -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
            @php
                $totalInvoiced = $invoices->sum('total');
                $totalPaid = $invoices->flatMap->payments->where('status', 'confirmado')->sum('amount');
                $pending = $totalInvoiced - $totalPaid;
            @endphp
            <div class="premium-card p-8 rounded-[2.5rem] bg-gradient-to-br from-slate-800 to-slate-900 border border-slate-700 shadow-2xl relative overflow-hidden">
                <div class="relative z-10">
                    <p class="text-sm font-bold text-slate-500 uppercase tracking-widest mb-2">Resumen Financiero Total</p>
                    <h3 class="mt-1">@money($totalInvoiced)</h3>
                    <div class="mt-6 flex items-center gap-4">
                        <div class="flex flex-col">
                            <span class="text-[10px] font-bold text-slate-500 uppercase">Cobrado</span>
                            <span class="text-lg font-bold text-green-400">@money($totalPaid)</span>
                        </div>
                        <div class="w-px h-8 bg-slate-700"></div>
                        <div class="flex flex-col">
                            <span class="text-[10px] font-bold text-slate-500 uppercase">Pendiente</span>
                            <span class="text-lg font-bold text-orange-400">@money($pending)</span>
                        </div>
                    </div>
                </div>
                <div class="absolute -right-10 -bottom-10 w-48 h-48 bg-blue-600/10 rounded-full blur-3xl"></div>
            </div>

            <div class="premium-card p-8 rounded-[2.5rem] flex flex-col justify-center border border-slate-700">
                <h4 class="text-lg font-bold text-white mb-6">Estado de Facturación</h4>
                <div class="space-y-4">
                    @php
                        $paidCount = $invoices->where('status', 'paid')->count();
                        $unpaidCount = $invoices->where('status', 'unpaid')->count();
                        $totalCount = $invoices->count() ?: 1;
                        $paidPercent = ($paidCount / $totalCount) * 100;
                        $unpaidPercent = ($unpaidCount / $totalCount) * 100;
                    @endphp
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-slate-300">Pagadas ({{ $paidCount }})</span>
                        <span class="text-sm font-bold text-white">{{ round($paidPercent) }}%</span>
                    </div>
                    <div class="w-full bg-slate-800 rounded-full h-1.5">
                        <div class="bg-green-500 h-1.5 rounded-full" style="width: {{ $paidPercent }}%"></div>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-slate-300">Pendientes ({{ $unpaidCount }})</span>
                        <span class="text-sm font-bold text-white">{{ round($unpaidPercent) }}%</span>
                    </div>
                    <div class="w-full bg-slate-800 rounded-full h-1.5">
                        <div class="bg-orange-500 h-1.5 rounded-full" style="width: {{ $unpaidPercent }}%"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="premium-card rounded-2xl shadow-xl overflow-hidden">
            <div class="p-6 border-b border-slate-700 bg-slate-800/30 flex items-center justify-between">
                <h3 class="font-bold text-lg text-white">Listado de Facturas</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-slate-800/50 text-xs text-slate-400 uppercase font-black">
                        <tr>
                            <th class="px-6 py-4">N° Factura</th>
                            <th class="px-6 py-4">Cliente</th>
                            <th class="px-6 py-4">Fecha</th>
                            <th class="px-6 py-4">Total</th>
                            <th class="px-6 py-4">Estado</th>
                            <th class="px-6 py-4 text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-700">
                        @forelse($invoices as $invoice)
                            <tr class="hover:bg-slate-800/30 transition-colors">
                                <td class="px-6 py-4 font-bold text-white">{{ $invoice->number }}</td>
                                <td class="px-6 py-4">
                                    <p class="text-sm font-bold text-white">{{ $invoice->serviceOrder->customer->name }}</p>
                                    @if($invoice->serviceOrder->customer->id_card)
                                        <p class="text-[10px] text-slate-500 font-mono">{{ $invoice->serviceOrder->customer->id_card }}</p>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-500">{{ $invoice->issue_date }}</td>
                                <td class="px-6 py-4">@money($invoice->total)</td>
                                <td class="px-6 py-4">
                                    @php
                                        $sConfig = match($invoice->status) {
                                            'paid' => ['class' => 'bg-green-500/10 text-green-500 border-green-500/20', 'label' => 'PAGADO'],
                                            'partially_paid' => ['class' => 'bg-blue-500/10 text-blue-400 border-blue-500/20', 'label' => 'PARCIAL'],
                                            default => ['class' => 'bg-orange-500/10 text-orange-500 border-orange-500/20', 'label' => 'PENDIENTE'],
                                        };
                                    @endphp
                                    <span class="px-3 py-1 {{ $sConfig['class'] }} text-[10px] font-black rounded-full border uppercase tracking-widest">
                                        {{ $sConfig['label'] }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex justify-center gap-3">
                                        <a href="{{ route('invoices.show', $invoice) }}" class="text-slate-400 hover:text-blue-400" title="Ver detalle">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </a>
                                        <a href="{{ route('invoices.edit', $invoice) }}" class="text-slate-400 hover:text-yellow-400" title="Editar factura">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                            </svg>
                                        </a>
                                        <form action="{{ route('invoices.destroy', $invoice) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar esta factura? Esta acción no se puede deshacer.')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-slate-400 hover:text-red-500" title="Eliminar factura">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-slate-500">No hay facturas registradas.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
