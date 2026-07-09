<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('vehicles.show', $vehicle->id) }}" class="p-2 bg-slate-800 hover:bg-slate-700 rounded-xl border border-slate-700 text-slate-400 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                </svg>
            </a>
            <h2 class="font-bold text-2xl text-white leading-tight">
                {{ __('Editar Vehículo') }}
            </h2>
        </div>
    </x-slot>

    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <!-- Formulario de datos del vehículo -->
        <div class="premium-card rounded-[2.5rem] p-8 shadow-2xl border border-slate-700">
            <form action="{{ route('vehicles.update', $vehicle->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <x-input-label for="customer_id" :value="__('Propietario')" required />
                        <select id="customer_id" name="customer_id" class="mt-1 block w-full bg-slate-900 border border-slate-700 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all p-4" required>
                            <option value="">Seleccione un cliente...</option>
                            @foreach($customers as $customer)
                                <option value="{{ $customer->id }}" {{ old('customer_id', $vehicle->customer_id) == $customer->id ? 'selected' : '' }}>{{ $customer->name }} ({{ $customer->phone }})</option>
                            @endforeach
                        </select>
                        <x-input-error class="mt-2" :messages="$errors->get('customer_id')" />
                    </div>

                    <div>
                        <x-input-label for="model_id" :value="__('Modelo')" required />
                        <select id="model_id" name="model_id" class="mt-1 block w-full bg-slate-900 border border-slate-700 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all p-4" onchange="autoFillFromModel(this)">
                            <option value="">Seleccione modelo...</option>
                            @foreach($models as $m)
                                <option value="{{ $m->id }}" {{ old('model_id', $vehicle->model_id) == $m->id ? 'selected' : '' }}>{{ $m->name }}</option>
                            @endforeach
                        </select>
                        <input type="hidden" name="model" id="model" value="{{ old('model', $vehicle->model) }}" />
                        <x-input-error class="mt-2" :messages="$errors->get('model')" />
                    </div>

                    <div>
                        <x-input-label for="make_id" :value="__('Marca')" required />
                        <select id="make_id" name="make_id" class="mt-1 block w-full bg-slate-900 border border-slate-700 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all p-4">
                            <option value="">Seleccione marca...</option>
                            @foreach($makes as $make)
                                <option value="{{ $make->id }}" {{ old('make_id', $vehicle->make_id) == $make->id ? 'selected' : '' }}>{{ $make->name }}</option>
                            @endforeach
                        </select>
                        <input type="hidden" name="make" id="make" value="{{ old('make', $vehicle->make) }}" />
                        <x-input-error class="mt-2" :messages="$errors->get('make')" />
                    </div>

                    <div>
                        <x-input-label for="year" :value="__('Año')" required />
                        <x-text-input id="year" name="year" type="number" class="mt-1 block w-full" :value="old('year', $vehicle->year)" required placeholder="2022" />
                        <x-input-error class="mt-2" :messages="$errors->get('year')" />
                    </div>

                    <div>
                        <x-input-label for="color" :value="__('Color')" />
                        <select id="color" name="color" class="mt-1 block w-full bg-slate-900 border border-slate-700 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all p-4">
                            <option value="">Seleccione color...</option>
                            <option value="Blanco" {{ old('color', $vehicle->color) == 'Blanco' ? 'selected' : '' }}>Blanco</option>
                            <option value="Negro" {{ old('color', $vehicle->color) == 'Negro' ? 'selected' : '' }}>Negro</option>
                            <option value="Plateado" {{ old('color', $vehicle->color) == 'Plateado' ? 'selected' : '' }}>Plateado</option>
                            <option value="Gris" {{ old('color', $vehicle->color) == 'Gris' ? 'selected' : '' }}>Gris</option>
                            <option value="Rojo" {{ old('color', $vehicle->color) == 'Rojo' ? 'selected' : '' }}>Rojo</option>
                            <option value="Azul" {{ old('color', $vehicle->color) == 'Azul' ? 'selected' : '' }}>Azul</option>
                            <option value="Verde" {{ old('color', $vehicle->color) == 'Verde' ? 'selected' : '' }}>Verde</option>
                            <option value="Beige" {{ old('color', $vehicle->color) == 'Beige' ? 'selected' : '' }}>Beige</option>
                            <option value="Marrón" {{ old('color', $vehicle->color) == 'Marrón' ? 'selected' : '' }}>Marrón</option>
                            <option value="Dorado" {{ old('color', $vehicle->color) == 'Dorado' ? 'selected' : '' }}>Dorado</option>
                            <option value="Naranja" {{ old('color', $vehicle->color) == 'Naranja' ? 'selected' : '' }}>Naranja</option>
                            <option value="Amarillo" {{ old('color', $vehicle->color) == 'Amarillo' ? 'selected' : '' }}>Amarillo</option>
                            <option value="Vino" {{ old('color', $vehicle->color) == 'Vino' ? 'selected' : '' }}>Vino</option>
                            <option value="Celeste" {{ old('color', $vehicle->color) == 'Celeste' ? 'selected' : '' }}>Celeste</option>
                        </select>
                        <x-input-error class="mt-2" :messages="$errors->get('color')" />
                    </div>

                    <div>
                        <x-input-label for="license_plate" :value="__('Placa')" required />
                        <x-text-input id="license_plate" name="license_plate" type="text" class="mt-1 block w-full uppercase" :value="old('license_plate', $vehicle->license_plate)" required placeholder="ABC-123 o ABC1234" maxlength="8" style="text-transform: uppercase;" oninput="this.value=this.value.toUpperCase().replace(/[^A-Z0-9-]/g,'')" />
                        <x-input-error class="mt-2" :messages="$errors->get('license_plate')" />
                    </div>

                    <div>
                        <x-input-label for="vin" :value="__('VIN / Serial de Chasis')" required />
                        <x-text-input id="vin" name="vin" type="text" class="mt-1 block w-full uppercase font-mono tracking-widest" :value="old('vin', $vehicle->vin)" required placeholder="17 caracteres (0-9, A-Z sin I/O/Q)" maxlength="17" style="text-transform: uppercase;" oninput="validateVin(this)" />
                        <p id="vin-hint" class="text-xs text-slate-500 mt-1">Debe tener 17 caracteres. Letras I, O, Q prohibidas.</p>
                        <x-input-error class="mt-2" :messages="$errors->get('vin')" />
                    </div>

                    <div>
                        <x-input-label for="mileage" :value="__('Kilometraje')" />
                        <x-text-input id="mileage" name="mileage" type="number" class="mt-1 block w-full" :value="old('mileage', $vehicle->mileage)" placeholder="Ej. 50000" min="0" />
                        <x-input-error class="mt-2" :messages="$errors->get('mileage')" />
                    </div>

                    <div>
                        <x-input-label for="fuel_level" :value="__('Nivel de Combustible')" />
                        <select id="fuel_level" name="fuel_level" class="mt-1 block w-full bg-slate-900 border border-slate-700 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all p-4">
                            <option value="">Seleccione nivel...</option>
                            <option value="empty" {{ old('fuel_level', $vehicle->fuel_level) == 'empty' ? 'selected' : '' }}>Vacío</option>
                            <option value="quarter" {{ old('fuel_level', $vehicle->fuel_level) == 'quarter' ? 'selected' : '' }}>1/4</option>
                            <option value="half" {{ old('fuel_level', $vehicle->fuel_level) == 'half' ? 'selected' : '' }}>1/2</option>
                            <option value="three_quarters" {{ old('fuel_level', $vehicle->fuel_level) == 'three_quarters' ? 'selected' : '' }}>3/4</option>
                        </select>
                        <x-input-error class="mt-2" :messages="$errors->get('fuel_level')" />
                    </div>

                    <div>
                        <x-input-label for="assigned_mechanic_id" :value="__('Mecánico Encargado')" />
                        <select id="assigned_mechanic_id" name="assigned_mechanic_id" class="mt-1 block w-full bg-slate-900 border border-slate-700 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all p-4">
                            <option value="">Seleccione mecánico...</option>
                            @foreach($mechanics as $mechanic)
                                <option value="{{ $mechanic->id }}" {{ old('assigned_mechanic_id', $vehicle->assigned_mechanic_id) == $mechanic->id ? 'selected' : '' }}>{{ $mechanic->name }}</option>
                            @endforeach
                        </select>
                        <x-input-error class="mt-2" :messages="$errors->get('assigned_mechanic_id')" />
                    </div>
                </div>

                <!-- Upload de fotos nuevas dentro del formulario de edición -->
                <div class="border-t border-slate-700 pt-6">
                    <x-input-label :value="__('Agregar Nuevas Fotos')" />
                    <div id="edit-drop-zone" class="mt-2 border-2 border-dashed border-slate-600 hover:border-blue-500 rounded-2xl p-6 text-center transition-colors duration-300 cursor-pointer" onclick="document.getElementById('edit-photo-input').click()">
                        <div id="edit-drop-content">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mx-auto text-slate-500 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            <p class="text-slate-400 text-sm font-medium">Clic o arrastra fotos aquí para agregarlas</p>
                            <p class="text-slate-600 text-xs mt-1">Formatos permitidos: JPG, PNG, GIF, WEBP</p>
                        </div>
                        <div id="edit-preview" class="grid grid-cols-4 gap-3 mt-3 hidden" onclick="event.stopPropagation()"></div>
                    </div>
                    <input id="edit-photo-input" type="file" name="photos[]" multiple accept="image/*" class="hidden" onchange="previewEditPhotos(this)">
                    <x-input-error class="mt-2" :messages="$errors->get('photos')" />
                    <x-input-error class="mt-2" :messages="\Illuminate\Support\Arr::flatten($errors->get('photos.*'))" />
                </div>

                <div class="flex items-center justify-end mt-8 gap-4">
                    <a href="{{ route('vehicles.show', $vehicle->id) }}" class="px-6 py-3 border-2 border-slate-600 text-slate-300 font-bold rounded-xl hover:bg-slate-700 hover:text-white transition-all text-sm">
                        Cancelar
                    </a>
                    <button type="submit" class="px-10 py-4 bg-blue-600 hover:bg-blue-500 text-white font-black rounded-2xl shadow-lg shadow-blue-500/30 transition-all hover:scale-105 active:scale-95">
                        Actualizar Vehículo
                    </button>
                </div>
            </form>
        </div>

        @if($vehicle->photos->count() > 0)
        <div class="premium-card rounded-[2.5rem] p-8 shadow-2xl border border-slate-700">
            <h3 class="text-lg font-bold text-white mb-4 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                Fotos Existentes
                <span class="ml-2 text-xs font-bold bg-slate-700 text-slate-300 px-2 py-0.5 rounded-full">{{ $vehicle->photos->count() }}</span>
            </h3>
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                @foreach($vehicle->photos as $photo)
                    <div class="group relative w-full h-28 sm:h-32 rounded-xl overflow-hidden border border-slate-700 hover:border-red-500/50 transition-all duration-300">
                        <img src="{{ asset('storage/' . $photo->photo_path) }}" alt="{{ $photo->description ?? 'Foto del vehículo' }}" class="w-full h-full object-cover">
                        <form action="{{ route('vehicles.photos.destroy', $photo->id) }}" method="POST" class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 flex items-center justify-center transition-opacity duration-300" onsubmit="return confirm('¿Eliminar esta foto?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-10 h-10 bg-red-500 hover:bg-red-600 rounded-xl flex items-center justify-center transition-colors shadow-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>

    <script>
        const modelsData = @json($models);

        function autoFillFromModel(select) {
            const modelId = select.value;
            const makeSelect = document.getElementById('make_id');
            const makeHidden = document.getElementById('make');
            const modelHidden = document.getElementById('model');

            if (!modelId) {
                makeSelect.value = '';
                makeHidden.value = '';
                modelHidden.value = '';
                return;
            }

            const model = modelsData.find(m => m.id == modelId);
            if (model) {
                makeSelect.value = model.vehicle_make_id;
                makeHidden.value = model.make.name;
                modelHidden.value = model.name;
            }
        }

        function validateVin(input) {
            input.value = input.value.toUpperCase().replace(/[IOQ]/g, '');
        }

        // Restore old selected values on page load
        document.addEventListener('DOMContentLoaded', function() {
            const oldModelId = '{{ old('model_id', $vehicle->model_id) }}';
            if (oldModelId) {
                document.getElementById('model_id').value = oldModelId;
                autoFillFromModel(document.getElementById('model_id'));
            }
        });

        function previewEditPhotos(input) {
            const container = document.getElementById('edit-preview');
            container.innerHTML = '';
            if (input.files.length > 0) {
                container.classList.remove('hidden');
                Array.from(input.files).forEach(file => {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const div = document.createElement('div');
                        div.className = 'relative w-full h-24 rounded-xl overflow-hidden border border-blue-500/30';
                        div.innerHTML = `<img src="${e.target.result}" class="w-full h-full object-cover" alt="Preview">`;
                        container.appendChild(div);
                    };
                    reader.readAsDataURL(file);
                });
            } else {
                container.classList.add('hidden');
            }
        }

        const editDropZone = document.getElementById('edit-drop-zone');
        const editPhotoInput = document.getElementById('edit-photo-input');

        if (editDropZone) {
            ['dragenter', 'dragover'].forEach(event => {
                editDropZone.addEventListener(event, (e) => {
                    e.preventDefault();
                    editDropZone.classList.add('border-blue-500', 'bg-blue-500/5');
                });
            });

            ['dragleave', 'drop'].forEach(event => {
                editDropZone.addEventListener(event, (e) => {
                    e.preventDefault();
                    editDropZone.classList.remove('border-blue-500', 'bg-blue-500/5');
                });
            });

            editDropZone.addEventListener('drop', (e) => {
                e.preventDefault();
                editPhotoInput.files = e.dataTransfer.files;
                previewEditPhotos(editPhotoInput);
            });
        }
    </script>
</x-app-layout>
