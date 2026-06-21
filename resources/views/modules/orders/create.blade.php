<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('orders.index') }}" class="p-2 bg-slate-800 hover:bg-slate-700 rounded-xl border border-slate-700 text-slate-400 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                </svg>
            </a>
            <h2 class="font-bold text-2xl text-white leading-tight">
                {{ __('Nueva Orden de Trabajo') }}
            </h2>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="premium-card rounded-[2.5rem] p-8 shadow-2xl border border-slate-700">
            <form action="{{ route('orders.store') }}" method="POST" class="space-y-8">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Seleccionar Cliente -->
                    <div>
                        <x-input-label for="customer_id" :value="__('Seleccionar Cliente')" required />
                        <div class="flex gap-2 mt-1">
                            <select id="customer_id" name="customer_id" class="flex-1 bg-slate-900 border border-slate-700 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all p-4" required onchange="filterVehicles(this.value)">
                                <option value="">-- Busque un cliente --</option>
                                @foreach($customers as $customer)
                                    <option value="{{ $customer->id }}">{{ $customer->name }} ({{ $customer->phone }})</option>
                                @endforeach
                            </select>
                            <button type="button" onclick="openClientModal()" class="px-3 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl transition-all text-xs flex items-center gap-1 shadow-lg shadow-emerald-500/20 whitespace-nowrap">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M8 9a3 3 0 100-6 3 3 0 000 6zM8 11a6 6 0 016 6H2a6 6 0 016-6z" />
                                    <path fill-rule="evenodd" d="M17 8a1 1 0 10-2 0v1h-1a1 1 0 100 2h1v1a1 1 0 102 0v-1h1a1 1 0 100-2h-1V8z" />
                                </svg>
                                Cliente Nuevo
                            </button>
                        </div>
                        <x-input-error class="mt-2" :messages="$errors->get('customer_id')" />
                    </div>

                    <!-- Seleccionar Vehículo -->
                    <div>
                        <x-input-label for="vehicle_id" :value="__('Seleccionar Vehículo')" required />
                        <select id="vehicle_id" name="vehicle_id" class="mt-1 block w-full bg-slate-900 border border-slate-700 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all p-4" required disabled>
                            <option value="">Primero elija un cliente...</option>
                        </select>
                        <x-input-error class="mt-2" :messages="$errors->get('vehicle_id')" />
                    </div>

                    <div class="md:col-span-2">
                        <x-input-label for="description" :value="__('Diagnóstico Inicial / Motivo de Entrada')" required />
                        <textarea id="description" name="description" class="mt-1 block w-full bg-slate-900 border border-slate-700 rounded-xl text-white placeholder-slate-600 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all p-4" rows="4" required placeholder="Ej: Ruido en la suspensión delantera, cambio de aceite..."></textarea>
                        <x-input-error class="mt-2" :messages="$errors->get('description')" />
                    </div>

                    <div>
                        <x-input-label for="estimated_total" :value="__('Presupuesto Estimado ($)')" />
                        <x-text-input id="estimated_total" name="estimated_total" type="number" step="0.01" class="mt-1 block w-full" placeholder="0.00" />
                        <x-input-error class="mt-2" :messages="$errors->get('estimated_total')" />
                    </div>
                </div>

                <div class="flex items-center justify-end mt-8 gap-4 border-t border-slate-700 pt-8">
                    <a href="{{ route('orders.index') }}" class="px-6 py-3 border-2 border-slate-600 text-slate-300 font-bold rounded-xl hover:bg-slate-700 hover:text-white transition-all text-sm">
                        Cancelar
                    </a>
                    <button type="submit" class="px-10 py-4 bg-blue-600 hover:bg-blue-500 text-white font-black rounded-2xl shadow-lg shadow-blue-500/30 transition-all hover:scale-105 active:scale-95">
                        Abrir Orden de Trabajo
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal: Nuevo Cliente + Vehículo Rápido -->
    <div id="client-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4">
        <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" onclick="closeClientModal()"></div>
        <div class="relative bg-slate-900 border border-slate-700 rounded-2xl shadow-2xl w-full max-w-lg z-10 overflow-hidden">
            <div class="p-6 border-b border-slate-700 bg-slate-800/30 flex items-center justify-between">
                <h3 class="text-lg font-bold text-white flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                    </svg>
                    Registrar Cliente y Vehículo
                </h3>
                <button onclick="closeClientModal()" class="text-slate-500 hover:text-white transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <form id="quick-client-form" class="p-6 space-y-4">
                @csrf
                <div>
                    <x-input-label for="q_name" :value="__('Nombre Completo')" required />
                    <x-text-input id="q_name" name="name" type="text" class="mt-1 block w-full" required placeholder="Ej. Juan Pérez" />
                </div>
                <div>
                    <x-input-label for="q_phone" :value="__('Teléfono / WhatsApp')" required />
                    <x-text-input id="q_phone" name="phone" type="text" class="mt-1 block w-full" required placeholder="+58 412..." />
                </div>
                <div>
                    <x-input-label for="q_license_plate" :value="__('Placa del Vehículo')" required />
                    <x-text-input id="q_license_plate" name="license_plate" type="text" class="mt-1 block w-full uppercase" required placeholder="ABC-123" style="text-transform: uppercase;" />
                </div>
                <div>
                    <x-input-label for="q_vin" :value="__('VIN / Serial de Chasis')" required />
                    <x-text-input id="q_vin" name="vin" type="text" class="mt-1 block w-full uppercase font-mono" required placeholder="17 caracteres" maxlength="17" style="text-transform: uppercase;" oninput="this.value = this.value.toUpperCase().replace(/[IOQ]/g, '')" />
                </div>
                <div id="q_error" class="hidden p-3 bg-red-500/10 border border-red-500/20 rounded-xl text-red-400 text-sm"></div>
                <div class="flex items-center justify-end gap-3 pt-4">
                    <button type="button" onclick="closeClientModal()" class="px-4 py-2 text-sm font-bold text-slate-400 hover:text-white transition-colors">
                        Cancelar
                    </button>
                    <button type="submit" class="px-6 py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl transition-all shadow-lg shadow-emerald-500/20">
                        Guardar y Seleccionar
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
            } else {
                vehicleSelect.innerHTML = '<option value="">El cliente no tiene vehículos registrados</option>';
                vehicleSelect.disabled = true;
            }
        }

        function openClientModal() {
            document.getElementById('client-modal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeClientModal() {
            document.getElementById('client-modal').classList.add('hidden');
            document.body.style.overflow = '';
        }

        document.getElementById('quick-client-form').addEventListener('submit', function(e) {
            e.preventDefault();
            const form = this;
            const formData = new FormData(form);
            const errorDiv = document.getElementById('q_error');

            fetch('{{ route("customers.store") }}', {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' },
                body: formData
            })
            .then(r => r.json())
            .then(data => {
                if (data.errors) {
                    errorDiv.classList.remove('hidden');
                    errorDiv.textContent = Object.values(data.errors).flat().join('. ');
                    return;
                }
                // Also register the vehicle
                const vin = document.getElementById('q_vin').value;
                const plate = document.getElementById('q_license_plate').value;
                const customerId = data.id;
                const make = 'S/C';
                const model = 'S/C';

                fetch('{{ route("vehicles.store") }}', {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' },
                    body: new URLSearchParams({
                        '_token': '{{ csrf_token() }}',
                        'customer_id': customerId,
                        'make': make,
                        'model': model,
                        'license_plate': plate,
                        'vin': vin,
                        'year': new Date().getFullYear(),
                    })
                })
                .then(r => r.json())
                .then(vData => {
                    closeClientModal();
                    location.reload();
                })
                .catch(() => { location.reload(); });
            })
            .catch(() => { errorDiv.textContent = 'Error de conexión. Verifica los datos.'; errorDiv.classList.remove('hidden'); });
        });
    </script>
</x-app-layout>
