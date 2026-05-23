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
                            @php
                                $statusConfig = match($invoice->status) {
                                    'paid' => ['class' => 'bg-green-500/10 text-green-500 border-green-500/20', 'label' => 'PAGADO'],
                                    'partially_paid' => ['class' => 'bg-blue-500/10 text-blue-400 border-blue-500/20', 'label' => 'PAGO PARCIAL'],
                                    default => ['class' => 'bg-orange-500/10 text-orange-400 border-orange-500/20', 'label' => 'PENDIENTE DE PAGO'],
                                };
                            @endphp
                            <span class="px-4 py-1.5 {{ $statusConfig['class'] }} text-xs font-black rounded-full border uppercase tracking-widest">
                                {{ $statusConfig['label'] }}
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
                        @php
                            $totalConfirmed = $invoice->payments->where('status', 'confirmado')->sum('amount');
                            $totalPending = $invoice->payments->where('status', 'pendiente')->sum('amount');
                            $totalAll = $invoice->payments->whereIn('status', ['confirmado', 'pendiente'])->sum('amount');
                        @endphp
                        <div class="bg-slate-900/50 rounded-2xl p-6 mt-8">
                            <div class="flex justify-between items-center text-sm mb-2">
                                <span class="text-slate-500 uppercase font-bold tracking-widest">Total Factura</span>
                                <span class="text-white font-bold">@money($invoice->total)</span>
                            </div>
                            <div class="flex justify-between items-center text-sm mb-2">
                                <span class="text-slate-500 uppercase font-bold tracking-widest">Pagos Confirmados</span>
                                <span class="text-green-400 font-bold">@money($totalConfirmed)</span>
                            </div>
                            @if($totalPending > 0)
                                <div class="flex justify-between items-center text-sm mb-2">
                                    <span class="text-slate-500 uppercase font-bold tracking-widest">Pagos Pendientes</span>
                                    <span class="text-yellow-400 font-bold">@money($totalPending)</span>
                                </div>
                            @endif
                            <div class="border-t border-slate-700 my-4"></div>
                            <div class="flex justify-between items-center">
                                <span class="text-white font-black uppercase tracking-widest">Saldo Pendiente</span>
                                <span class="text-2xl font-black text-white">@money($invoice->total - $totalConfirmed)</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Payments History -->
                <div class="premium-card p-8 rounded-2xl border border-slate-700 bg-slate-800/30">
                    <div class="flex items-center justify-between mb-6">
                        <h4 class="text-sm font-black text-white uppercase tracking-widest">Historial de Pagos</h4>
                        <a href="{{ route('payments.history') }}" class="text-xs text-blue-500 font-bold hover:underline">Ver todos los pagos →</a>
                    </div>
                    <div class="space-y-4">
                        @forelse($invoice->payments->sortByDesc('created_at') as $payment)
                            <div class="p-5 bg-slate-900/50 rounded-xl border {{ $payment->isConfirmed() ? 'border-green-500/20' : ($payment->status === 'rechazado' ? 'border-red-500/20' : 'border-yellow-500/20') }}">
                                <div class="flex justify-between items-start">
                                    <div class="flex-1">
                                        <div class="flex items-center gap-3 mb-2">
                                            <p class="text-lg font-bold text-white">@money($payment->amount)</p>
                                            @php
                                                $paymentStatusConfig = match($payment->status) {
                                                    'confirmado' => ['class' => 'bg-green-500/10 text-green-500 border-green-500/20', 'label' => 'CONFIRMADO'],
                                                    'rechazado' => ['class' => 'bg-red-500/10 text-red-500 border-red-500/20', 'label' => 'RECHAZADO'],
                                                    default => ['class' => 'bg-yellow-500/10 text-yellow-500 border-yellow-500/20', 'label' => 'PENDIENTE'],
                                                };
                                            @endphp
                                            <span class="px-2.5 py-0.5 {{ $paymentStatusConfig['class'] }} text-[9px] font-black rounded-full border uppercase tracking-widest">
                                                {{ $paymentStatusConfig['label'] }}
                                            </span>
                                        </div>
                                        <div class="flex flex-wrap gap-x-4 gap-y-1 text-[10px] text-slate-500 uppercase font-bold tracking-widest">
                                            <span>{{ $payment->method }}</span>
                                            <span>{{ $payment->payment_date?->format('d/m/Y H:i') ?? $payment->payment_date }}</span>
                                            @if($payment->reference)
                                                <span>Ref: {{ $payment->reference }}</span>
                                            @endif
                                        </div>
                                        @if($payment->notes)
                                            <p class="text-xs text-slate-400 mt-2 italic">{{ $payment->notes }}</p>
                                        @endif
                                        @if($payment->isConfirmed() && $payment->confirmed_at)
                                            <p class="text-[10px] text-green-500/60 mt-1">Confirmado el {{ $payment->confirmed_at->format('d/m/Y H:i') }}</p>
                                        @endif
                                    </div>

                                    <!-- Actions -->
                                    @if($payment->isPending())
                                        <div class="flex items-center gap-2 ml-4 flex-shrink-0">
                                            <form action="{{ route('payments.confirm', $payment) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="p-2.5 bg-green-600/20 hover:bg-green-600/40 text-green-400 hover:text-green-300 rounded-xl border border-green-500/20 transition-all" title="Confirmar pago">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                                    </svg>
                                                </button>
                                            </form>
                                            <form action="{{ route('payments.reject', $payment) }}" method="POST" onsubmit="return confirm('¿Seguro que desea rechazar este pago?')">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="p-2.5 bg-red-600/20 hover:bg-red-600/40 text-red-400 hover:text-red-300 rounded-xl border border-red-500/20 transition-all" title="Rechazar pago">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    @elseif($payment->isConfirmed())
                                        <div class="ml-4 flex-shrink-0">
                                            <span class="text-green-400">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                </svg>
                                            </span>
                                        </div>
                                    @else
                                        <div class="ml-4 flex-shrink-0">
                                            <span class="text-red-400">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                                </svg>
                                            </span>
                                        </div>
                                    @endif
                                </div>
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
                        <form action="{{ route('invoices.payment', $invoice) }}" method="POST" class="space-y-5">
                            @csrf
                            <div>
                                <x-input-label for="amount" :value="__('Monto a Pagar ($)')" />
                                <x-text-input id="amount" name="amount" type="number" step="0.01" class="mt-1 block w-full" :value="$invoice->total - $totalConfirmed" required />
                                <x-input-error class="mt-2" :messages="$errors->get('amount')" />
                            </div>
                            <div>
                                <x-input-label for="method" :value="__('Método de Pago')" />
                                <select id="method" name="method" class="mt-1 block w-full bg-slate-900 border border-slate-700 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all p-3" required>
                                    <option value="Efectivo">Efectivo</option>
                                    <option value="Transferencia">Transferencia</option>
                                    <option value="Pago Móvil">Pago Móvil</option>
                                    <option value="Tarjeta">Tarjeta de Crédito/Débito</option>
                                    <option value="Zelle / Divisas">Zelle / Divisas</option>
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('method')" />
                            </div>
                            <div>
                                <x-input-label for="reference" :value="__('N° Referencia (opcional)')" />
                                <x-text-input id="reference" name="reference" type="text" class="mt-1 block w-full" placeholder="Ej: 00012345" />
                                <x-input-error class="mt-2" :messages="$errors->get('reference')" />
                            </div>
                            <div>
                                <x-input-label for="notes" :value="__('Notas (opcional)')" />
                                <textarea id="notes" name="notes" rows="2" class="mt-1 block w-full bg-slate-900 border border-slate-700 rounded-xl text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all p-3 text-sm" placeholder="Observaciones del pago..."></textarea>
                                <x-input-error class="mt-2" :messages="$errors->get('notes')" />
                            </div>
                            <button type="submit" class="w-full py-4 bg-green-600 hover:bg-green-700 text-white font-black rounded-2xl shadow-lg shadow-green-500/20 transition-all hover:scale-105 active:scale-95 mt-2">
                                Registrar Pago
                            </button>
                            <p class="text-[10px] text-slate-500 text-center mt-2">El pago quedará pendiente de confirmación.</p>
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
