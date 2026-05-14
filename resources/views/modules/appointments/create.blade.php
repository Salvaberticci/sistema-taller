<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('appointments.index') }}" class="p-2 bg-slate-800 hover:bg-slate-700 rounded-xl border border-slate-700 text-slate-400 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                </svg>
            </a>
            <h2 class="font-bold text-2xl text-white leading-tight">
                {{ __('Agendar Nueva Cita') }}
            </h2>
        </div>
    </x-slot>

    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div class="premium-card rounded-[2.5rem] p-8 shadow-2xl border border-slate-700 bg-slate-800/50">
            <form action="{{ route('appointments.store') }}" method="POST" class="space-y-6">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <x-input-label for="customer_id" :value="__('Seleccionar Cliente')" />
                        <select id="customer_id" name="customer_id" class="mt-1 block w-full bg-slate-900 border border-slate-700 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-purple-500 transition-all p-3" required onchange="updateVehicles(this.value)">
                            <option value="">-- Elija un cliente --</option>
                            @foreach($customers as $customer)
                                <option value="{{ $customer->id }}">{{ $customer->name }} ({{ $customer->phone }})</option>
                            @endforeach
                        </select>
                        <x-input-error class="mt-2" :messages="$errors->get('customer_id')" />
                    </div>

                    <div>
                        <x-input-label for="vehicle_id" :value="__('Seleccionar Vehículo')" />
                        <select id="vehicle_id" name="vehicle_id" class="mt-1 block w-full bg-slate-900 border border-slate-700 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-purple-500 transition-all p-3" disabled>
                            <option value="">Primero elija un cliente...</option>
                        </select>
                        <x-input-error class="mt-2" :messages="$errors->get('vehicle_id')" />
                    </div>

                    <div>
                        <x-input-label for="scheduled_at" :value="__('Fecha y Hora')" />
                        <x-text-input id="scheduled_at" name="scheduled_at" type="datetime-local" class="mt-1 block w-full" required />
                        <x-input-error class="mt-2" :messages="$errors->get('scheduled_at')" />
                    </div>

                    <div>
                        <x-input-label for="status" :value="__('Estado Inicial')" />
                        <select id="status" name="status" class="mt-1 block w-full bg-slate-900 border border-slate-700 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-purple-500 transition-all p-3" required>
                            <option value="scheduled">Pendiente</option>
                            <option value="confirmed">Confirmada</option>
                        </select>
                        <x-input-error class="mt-2" :messages="$errors->get('status')" />
                    </div>

                    <div class="md:col-span-2">
                        <x-input-label for="description" :value="__('Motivo de la Cita / Descripción')" />
                        <textarea id="description" name="description" rows="3" class="mt-1 block w-full bg-slate-900 border border-slate-700 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-purple-500 transition-all p-3" placeholder="Ej. Cambio de aceite, revisión de frenos..."></textarea>
                        <x-input-error class="mt-2" :messages="$errors->get('description')" />
                    </div>
                </div>

                <div class="flex items-center justify-end mt-8 gap-4">
                    <a href="{{ route('appointments.index') }}" class="text-sm font-bold text-slate-400 hover:text-white transition-colors">Cancelar</a>
                    <button type="submit" class="px-10 py-4 bg-purple-600 hover:bg-purple-700 text-white font-black rounded-2xl shadow-lg shadow-purple-500/20 transition-all hover:scale-105 active:scale-95">
                        Agendar Cita
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const customers = @json($customers);

        function updateVehicles(customerId) {
            const vehicleSelect = document.getElementById('vehicle_id');
            vehicleSelect.innerHTML = '<option value="">Seleccione vehículo...</option>';
            
            if (!customerId) {
                vehicleSelect.disabled = true;
                return;
            }

            const customer = customers.find(c => c.id == customerId);
            if (customer && customer.vehicles.length > 0) {
                customer.vehicles.forEach(v => {
                    const option = document.createElement('option');
                    option.value = v.id;
                    option.textContent = `${v.make} ${v.model} (${v.license_plate})`;
                    vehicleSelect.appendChild(option);
                });
                vehicleSelect.disabled = false;
            } else {
                vehicleSelect.innerHTML = '<option value="">Sin vehículos registrados</option>';
                vehicleSelect.disabled = true;
            }
        }
    </script>
</x-app-layout>
