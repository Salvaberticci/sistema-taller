<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('orders.index') }}" class="p-2 bg-slate-800 hover:bg-slate-700 rounded-xl border border-slate-700 text-slate-400 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                </svg>
            </a>
            <h2 class="font-bold text-2xl text-white leading-tight">
                {{ __('Editar Orden de Trabajo') }} #OT-{{ $order->id }}
            </h2>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="premium-card rounded-[2.5rem] p-8 shadow-2xl border border-slate-700">
            <form action="{{ route('orders.update', $order) }}" method="POST" class="space-y-8">
                @csrf @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Seleccionar Cliente -->
                    <div>
                        <x-input-label for="customer_id" :value="__('Seleccionar Cliente')" required />
                        <select id="customer_id" name="customer_id" class="mt-1 block w-full bg-slate-900 border border-slate-700 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all p-4" required onchange="filterVehicles(this.value)">
                            <option value="">-- Busque un cliente --</option>
                            @foreach($customers as $customer)
                                <option value="{{ $customer->id }}" {{ old('customer_id', $order->customer_id) == $customer->id ? 'selected' : '' }}>{{ $customer->name }} ({{ $customer->phone }})</option>
                            @endforeach
                        </select>
                        <x-input-error class="mt-2" :messages="$errors->get('customer_id')" />
                    </div>

                    <!-- Seleccionar Vehículo -->
                    <div>
                        <x-input-label for="vehicle_id" :value="__('Seleccionar Vehículo')" required />
                        <select id="vehicle_id" name="vehicle_id" class="mt-1 block w-full bg-slate-900 border border-slate-700 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all p-4" required>
                            <option value="">Seleccione el vehículo...</option>
                            @foreach($order->customer->vehicles as $vehicle)
                                <option value="{{ $vehicle->id }}" {{ old('vehicle_id', $order->vehicle_id) == $vehicle->id ? 'selected' : '' }}>{{ $vehicle->make }} {{ $vehicle->model }} ({{ $vehicle->license_plate }})</option>
                            @endforeach
                        </select>
                        <x-input-error class="mt-2" :messages="$errors->get('vehicle_id')" />
                    </div>

                    <div class="md:col-span-2">
                        <x-input-label for="description" :value="__('Diagnóstico Inicial / Motivo de Entrada')" required />
                        <textarea id="description" name="description" class="mt-1 block w-full bg-slate-900 border border-slate-700 rounded-xl text-white placeholder-slate-600 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all p-4" rows="4" required>{{ old('description', $order->description) }}</textarea>
                        <x-input-error class="mt-2" :messages="$errors->get('description')" />
                    </div>

                    <div>
                        <x-input-label for="estimated_total" :value="__('Presupuesto Estimado ($)')" />
                        <x-text-input id="estimated_total" name="estimated_total" type="number" step="0.01" class="mt-1 block w-full" :value="old('estimated_total', $order->total_amount)" />
                        <x-input-error class="mt-2" :messages="$errors->get('estimated_total')" />
                    </div>

                    <div>
                        <x-input-label for="status" :value="__('Estado')" required />
                        <select id="status" name="status" class="mt-1 block w-full bg-slate-900 border border-slate-700 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all p-4" required>
                            <option value="pending" {{ old('status', $order->status) == 'pending' ? 'selected' : '' }}>En Espera</option>
                            <option value="in_progress" {{ old('status', $order->status) == 'in_progress' ? 'selected' : '' }}>En Proceso</option>
                            <option value="completed" {{ old('status', $order->status) == 'completed' ? 'selected' : '' }}>Finalizada</option>
                            <option value="cancelled" {{ old('status', $order->status) == 'cancelled' ? 'selected' : '' }}>Cancelada</option>
                        </select>
                        <x-input-error class="mt-2" :messages="$errors->get('status')" />
                    </div>
                </div>

                <div class="flex items-center justify-end mt-8 gap-4 border-t border-slate-700 pt-8">
                    <a href="{{ route('orders.index') }}" class="px-6 py-3 border-2 border-slate-600 text-slate-300 font-bold rounded-xl hover:bg-slate-700 hover:text-white transition-all text-sm">
                        Cancelar
                    </a>
                    <button type="submit" class="px-10 py-4 bg-blue-600 hover:bg-blue-500 text-white font-black rounded-2xl shadow-lg shadow-blue-500/30 transition-all hover:scale-105 active:scale-95">
                        Guardar Cambios
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const customersData = @json($customers);

        function filterVehicles(customerId) {
            const vehicleSelect = document.getElementById('vehicle_id');
            vehicleSelect.innerHTML = '<option value="">Seleccione el vehículo...</option>';

            if (!customerId) {
                vehicleSelect.disabled = true;
                return;
            }

            const customer = customersData.find(c => c.id == customerId);
            if (customer && customer.vehicles.length > 0) {
                customer.vehicles.forEach(vehicle => {
                    const option = document.createElement('option');
                    option.value = vehicle.id;
                    option.textContent = `${vehicle.make} ${vehicle.model} (${vehicle.license_plate})`;
                    vehicleSelect.appendChild(option);
                });
                vehicleSelect.disabled = false;

                const currentVehicle = '{{ old('vehicle_id', $order->vehicle_id) }}';
                if (currentVehicle) {
                    vehicleSelect.value = currentVehicle;
                }
            } else {
                vehicleSelect.innerHTML = '<option value="">El cliente no tiene vehículos registrados</option>';
                vehicleSelect.disabled = true;
            }
        }
    </script>
</x-app-layout>