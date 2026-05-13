<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('vehicles.index') }}" class="p-2 bg-slate-800 hover:bg-slate-700 rounded-xl border border-slate-700 text-slate-400 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                </svg>
            </a>
            <h2 class="font-bold text-2xl text-white leading-tight">
                {{ __('Registrar Vehículo') }}
            </h2>
        </div>
    </x-slot>

    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div class="premium-card rounded-[2.5rem] p-8 shadow-2xl border border-slate-700">
            <form action="{{ route('vehicles.store') }}" method="POST" class="space-y-6">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <x-input-label for="customer_id" :value="__('Propietario')" />
                        <select id="customer_id" name="customer_id" class="mt-1 block w-full bg-slate-900 border border-slate-700 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all p-4" required>
                            <option value="">Seleccione un cliente...</option>
                            @foreach($customers as $customer)
                                <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>{{ $customer->name }} ({{ $customer->phone }})</option>
                            @endforeach
                        </select>
                        <x-input-error class="mt-2" :messages="$errors->get('customer_id')" />
                    </div>

                    <div>
                        <x-input-label for="make" :value="__('Marca')" />
                        <x-text-input id="make" name="make" type="text" class="mt-1 block w-full" required placeholder="Ej. Toyota" />
                        <x-input-error class="mt-2" :messages="$errors->get('make')" />
                    </div>

                    <div>
                        <x-input-label for="model" :value="__('Modelo')" />
                        <x-text-input id="model" name="model" type="text" class="mt-1 block w-full" required placeholder="Ej. Corolla" />
                        <x-input-error class="mt-2" :messages="$errors->get('model')" />
                    </div>

                    <div>
                        <x-input-label for="year" :value="__('Año')" />
                        <x-text-input id="year" name="year" type="number" class="mt-1 block w-full" required placeholder="2022" />
                        <x-input-error class="mt-2" :messages="$errors->get('year')" />
                    </div>

                    <div>
                        <x-input-label for="license_plate" :value="__('Placa / Patente')" />
                        <x-text-input id="license_plate" name="license_plate" type="text" class="mt-1 block w-full" required placeholder="ABC-123" />
                        <x-input-error class="mt-2" :messages="$errors->get('license_plate')" />
                    </div>

                    <div>
                        <x-input-label for="color" :value="__('Color')" />
                        <x-text-input id="color" name="color" type="text" class="mt-1 block w-full" placeholder="Blanco" />
                        <x-input-error class="mt-2" :messages="$errors->get('color')" />
                    </div>

                    <div>
                        <x-input-label for="vin" :value="__('VIN / Serial de Chasis')" />
                        <x-text-input id="vin" name="vin" type="text" class="mt-1 block w-full" placeholder="Opcional" />
                        <x-input-error class="mt-2" :messages="$errors->get('vin')" />
                    </div>
                </div>

                <div class="flex items-center justify-end mt-8 gap-4">
                    <a href="{{ route('vehicles.index') }}" class="text-sm font-bold text-slate-400 hover:text-white transition-colors">Cancelar</a>
                    <button type="submit" class="px-10 py-4 bg-blue-600 hover:bg-blue-700 text-white font-black rounded-2xl shadow-lg shadow-blue-500/20 transition-all hover:scale-105 active:scale-95">
                        Registrar Vehículo
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
