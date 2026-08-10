<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('invoices.index') }}" class="p-2 bg-slate-800 hover:bg-slate-700 rounded-xl border border-slate-700 text-slate-400 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                </svg>
            </a>
            <h2 class="font-bold text-2xl text-white leading-tight">
                {{ __('Editar Factura') }} {{ $invoice->number }}
            </h2>
        </div>
    </x-slot>

    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div class="premium-card rounded-2xl p-8 shadow-xl border border-slate-700">
            <div class="mb-8 p-4 bg-slate-800/40 rounded-xl border border-slate-700">
                <p class="text-[10px] text-slate-500 font-black uppercase tracking-widest mb-1">Cliente</p>
                <p class="text-sm font-bold text-white">{{ $invoice->serviceOrder->customer->name }}</p>
                <p class="text-[10px] text-slate-500 font-black uppercase tracking-widest mt-3 mb-1">Vehículo</p>
                <p class="text-sm font-bold text-white">{{ $invoice->serviceOrder->vehicle->make }} {{ $invoice->serviceOrder->vehicle->model }} - <span class="text-blue-400 font-mono">{{ $invoice->serviceOrder->vehicle->license_plate }}</span></p>
            </div>

            <form method="POST" action="{{ route('invoices.update', $invoice) }}" class="space-y-5">
                @csrf
                @method('PUT')

                <div>
                    <x-input-label for="issue_date" :value="__('Fecha de Emisión')" required />
                    <x-text-input id="issue_date" name="issue_date" type="date" class="mt-1 block w-full" :value="old('issue_date', $invoice->issue_date->format('Y-m-d'))" required />
                    <x-input-error class="mt-2" :messages="$errors->get('issue_date')" />
                </div>

                <div>
                    <x-input-label for="total" :value="__('Total (Bs.)')" required />
                    <x-text-input id="total" name="total" type="number" step="0.01" class="mt-1 block w-full" :value="old('total', $invoice->total)" required />
                    <x-input-error class="mt-2" :messages="$errors->get('total')" />
                </div>

                <div>
                    <x-input-label for="status" :value="__('Estado')" required />
                    <select id="status" name="status" class="mt-1 block w-full bg-slate-900 border border-slate-700 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all p-4">
                        <option value="unpaid" {{ old('status', $invoice->status) == 'unpaid' ? 'selected' : '' }}>Pendiente</option>
                        <option value="partially_paid" {{ old('status', $invoice->status) == 'partially_paid' ? 'selected' : '' }}>Pago Parcial</option>
                        <option value="paid" {{ old('status', $invoice->status) == 'paid' ? 'selected' : '' }}>Pagada</option>
                    </select>
                    <x-input-error class="mt-2" :messages="$errors->get('status')" />
                </div>

                <div class="flex gap-3 pt-4">
                    <a href="{{ route('invoices.show', $invoice) }}" class="px-6 py-3 bg-slate-800 hover:bg-slate-700 text-slate-300 font-bold rounded-xl transition-all text-sm">Cancelar</a>
                    <button type="submit" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl transition-all shadow-lg shadow-blue-500/20 text-sm">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
