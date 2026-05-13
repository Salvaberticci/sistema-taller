<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="font-bold text-2xl text-white leading-tight flex items-center gap-3">
                    <a href="{{ route('orders.show', $order->id) }}" class="p-2 bg-slate-800 hover:bg-slate-700 rounded-xl border border-slate-700 text-slate-400 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                    </a>
                    {{ __('Editar Orden #OT-') }}{{ $order->id }}
                </h2>
                <p class="text-slate-400 text-sm mt-1 ml-11">Actualiza el estado y detalles de la reparación.</p>
            </div>
        </div>
    </x-slot>

    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div class="premium-card rounded-2xl shadow-xl overflow-hidden bg-slate-900 border border-slate-800 p-8">
            <form action="{{ route('orders.update', $order->id) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Información del Cliente/Vehículo (Solo Lectura) -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 p-4 bg-slate-800/30 rounded-xl border border-slate-700/50 mb-6">
                    <div>
                        <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-1">Cliente</p>
                        <p class="text-white font-bold">{{ $order->customer->name }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-1">Vehículo</p>
                        <p class="text-blue-400 font-bold">{{ $order->vehicle->make }} {{ $order->vehicle->model }} ({{ $order->vehicle->license_plate }})</p>
                    </div>
                </div>

                <!-- Estado -->
                <div>
                    <label for="status" class="block text-sm font-bold text-slate-400 mb-2">Estado de la Orden</label>
                    <select name="status" id="status" class="block w-full px-4 py-3 bg-slate-800 border border-slate-700 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                        <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>En Espera / Pendiente</option>
                        <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Finalizada / Entregada</option>
                        <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelada</option>
                    </select>
                    @error('status') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Descripción -->
                <div>
                    <label for="description" class="block text-sm font-bold text-slate-400 mb-2">Descripción del Trabajo / Notas</label>
                    <textarea name="description" id="description" rows="5" 
                        class="block w-full px-4 py-3 bg-slate-800 border border-slate-700 rounded-xl text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">{{ old('description', $order->description) }}</textarea>
                    @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Monto Total -->
                <div>
                    <label for="total_amount" class="block text-sm font-bold text-slate-400 mb-2">Monto Total ($)</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-500 font-bold">$</span>
                        <input type="number" step="0.01" name="total_amount" id="total_amount" 
                            value="{{ old('total_amount', $order->total_amount) }}"
                            class="block w-full pl-8 pr-4 py-3 bg-slate-800 border border-slate-700 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                    </div>
                    @error('total_amount') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="pt-6 border-t border-slate-800 flex items-center justify-between">
                    <a href="{{ route('orders.show', $order->id) }}" class="text-sm font-bold text-slate-400 hover:text-white transition-colors">Cancelar</a>
                    <button type="submit" class="px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl transition-all shadow-lg shadow-blue-500/20">
                        Guardar Cambios
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
