<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('invoices.index') }}" class="p-2 bg-slate-800 hover:bg-slate-700 rounded-xl border border-slate-700 text-slate-400 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                </svg>
            </a>
            <h2 class="font-bold text-2xl text-white leading-tight">
                {{ __('Detalle de Factura') }} {{ $invoice->number }}
            </h2>
        </div>
    </x-slot>

    <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-8">
        @if (session('status'))
            <div class="p-4 bg-green-500/10 border border-green-500/20 rounded-xl text-green-400 font-bold text-sm">
                {{ session('status') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Invoice Details -->
            <div class="lg:col-span-2 space-y-6">
                <div class="premium-card p-8 rounded-[2.5rem] border border-slate-700 bg-slate-800/50">
                    <div class="flex justify-between items-start mb-12">
                        <div>
                            <h3 class="text-3xl font-black text-white mb-1">FACTURA</h3>
                            <p class="text-blue-500 font-bold tracking-widest uppercase text-xs">{{ $invoice->number }}</p>
                        </div>
                        <div class="text-right">
                            <span class="px-4 py-1.5 {{ $invoice->status == 'paid' ? 'bg-green-500/10 text-green-500 border-green-500/20' : 'bg-orange-500/10 text-orange-400 border-orange-500/20' }} text-xs font-black rounded-full border uppercase tracking-widest">
                                {{ $invoice->status == 'paid' ? 'PAGADO' : 'PENDIENTE DE PAGO' }}
                            </span>
                            <p class="text-slate-500 text-[10px] font-bold mt-3 uppercase tracking-widest">Emitido: {{ $invoice->issue_date }}</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-12 mb-12">
                        <div>
                            <p class="text-[10px] text-slate-500 font-black uppercase tracking-widest mb-2">Cliente</p>
                            <h4 class="text-lg font-bold text-white">{{ $invoice->serviceOrder->customer->name }}</h4>
                            <p class="text-sm text-slate-400">{{ $invoice->serviceOrder->customer->phone }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-[10px] text-slate-500 font-black uppercase tracking-widest mb-2">Vehículo</p>
                            <h4 class="text-lg font-bold text-white">{{ $invoice->serviceOrder->vehicle->make }} {{ $invoice->serviceOrder->vehicle->model }}</h4>
                            <p class="text-sm text-blue-400 font-mono font-bold">{{ $invoice->serviceOrder->vehicle->license_plate }}</p>
                        </div>
                    </div>

                    <div class="border-t border-slate-700 pt-8 mt-8">
                        <div class="flex justify-between items-center mb-4">
                            <span class="text-slate-400 font-bold">Concepto: Orden de Trabajo #{{ $invoice->service_order_id }}</span>
                            <div class="text-white font-black text-xl">@money($invoice->total)</div>
                        </div>
                        <div class="bg-slate-900/50 rounded-2xl p-6 mt-8">
                            <div class="flex justify-between items-center text-sm mb-2">
                                <span class="text-slate-500 uppercase font-bold tracking-widest">Total Factura</span>
                                <span class="text-white font-bold">@money($invoice->total)</span>
                            </div>
                            <div class="flex justify-between items-center text-sm mb-2">
                                <span class="text-slate-500 uppercase font-bold tracking-widest">Total Pagado</span>
                                <span class="text-green-400 font-bold">@money($invoice->payments->sum('amount'))</span>
                            </div>
                            <div class="border-t border-slate-700 my-4"></div>
                            <div class="flex justify-between items-center">
                                <span class="text-white font-black uppercase tracking-widest">Saldo Pendiente</span>
                                <span class="text-2xl font-black text-white">@money($invoice->total - $invoice->payments->sum('amount'))</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Payments History -->
                <div class="premium-card p-8 rounded-2xl border border-slate-700 bg-slate-800/30">
                    <h4 class="text-sm font-black text-white uppercase tracking-widest mb-6">Historial de Pagos</h4>
                    <div class="space-y-4">
                        @forelse($invoice->payments as $payment)
                            <div class="flex justify-between items-center p-4 bg-slate-900/50 rounded-xl border border-slate-700">
                                <div>
                                    <p class="text-sm font-bold text-white">@money($payment->amount)</p>
                                    <p class="text-[10px] text-slate-500 uppercase font-bold tracking-widest">{{ $payment->method }} • {{ $payment->payment_date }}</p>
                                </div>
                                <span class="text-green-400"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" /></svg></span>
                            </div>
                        @empty
                            <p class="text-center text-slate-500 text-sm py-4">No se han registrado pagos para esta factura.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Payment Action Sidebar -->
            @if($invoice->status != 'paid')
                <div class="lg:col-span-1">
                    <div class="premium-card p-8 rounded-[2.5rem] border border-slate-700 bg-blue-600/5 sticky top-28">
                        <h4 class="text-lg font-black text-white mb-6">Registrar Pago</h4>
                        <form action="{{ route('invoices.payment', $invoice) }}" method="POST" class="space-y-6">
                            @csrf
                            <div>
                                <x-input-label for="amount" :value="__('Monto a Pagar ($)')" />
                                <x-text-input id="amount" name="amount" type="number" step="0.01" class="mt-1 block w-full" :value="$invoice->total - $invoice->payments->sum('amount')" required />
                            </div>
                            <div>
                                <x-input-label for="method" :value="__('Método de Pago')" />
                                <select id="method" name="method" class="mt-1 block w-full bg-slate-900 border border-slate-700 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all p-3" required>
                                    <option value="Efectivo">Efectivo</option>
                                    <option value="Transferencia">Transferencia</option>
                                    <option value="Tarjeta">Tarjeta de Crédito/Débito</option>
                                    <option value="Zelle / Divisas">Zelle / Divisas</option>
                                </select>
                            </div>
                            <button type="submit" class="w-full py-4 bg-green-600 hover:bg-green-700 text-white font-black rounded-2xl shadow-lg shadow-green-500/20 transition-all hover:scale-105 active:scale-95 mt-4">
                                Confirmar Pago
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <div class="lg:col-span-1">
                    <div class="premium-card p-8 rounded-[2.5rem] border border-green-500/30 bg-green-500/5 text-center">
                        <div class="w-16 h-16 bg-green-500/20 rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <h4 class="text-xl font-black text-white mb-2">Factura Pagada</h4>
                        <p class="text-slate-400 text-sm">Esta factura se encuentra totalmente solventada.</p>
                        <a href="{{ route('reports.invoice', $invoice) }}" target="_blank" class="w-full block text-center py-4 bg-slate-800 hover:bg-slate-700 text-white font-bold rounded-2xl transition-all mt-8 border border-slate-700">
                            Descargar PDF
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
