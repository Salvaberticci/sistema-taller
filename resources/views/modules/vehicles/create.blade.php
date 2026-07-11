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
            <form action="{{ route('vehicles.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <x-input-label for="customer_id" :value="__('Propietario')" required />
                        <select id="customer_id" name="customer_id" class="mt-1 block w-full bg-slate-900 border border-slate-700 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all p-4" required>
                            <option value="">Seleccione un cliente...</option>
                            @foreach($customers as $customer)
                                <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>{{ $customer->name }} ({{ $customer->phone }})</option>
                            @endforeach
                        </select>
                        <x-input-error class="mt-2" :messages="$errors->get('customer_id')" />
                    </div>

                    <div>
                        <x-input-label for="make_id" :value="__('Marca')" required />
                        <div class="flex gap-2 mt-1">
                            <select id="make_id" name="make_id" class="flex-1 block bg-slate-900 border border-slate-700 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all p-4" onchange="filterModelsByMake()">
                                <option value="">Seleccione marca...</option>
                                @foreach($makes as $make)
                                    <option value="{{ $make->id }}" {{ old('make_id') == $make->id ? 'selected' : '' }}>{{ $make->name }}</option>
                                @endforeach
                            </select>
                            <button type="button" onclick="openQuickAddMake()" class="px-4 bg-slate-800 hover:bg-blue-600 border border-slate-700 hover:border-blue-500 rounded-xl text-slate-400 hover:text-white transition-all shrink-0 font-bold text-lg">+</button>
                        </div>
                        <input type="hidden" name="make" id="make" value="{{ old('make') }}" />
                        <x-input-error class="mt-2" :messages="$errors->get('make')" />
                    </div>

                    <div>
                        <x-input-label for="model_id" :value="__('Modelo')" required />
                        <div class="flex gap-2 mt-1">
                            <select id="model_id" name="model_id" class="flex-1 block bg-slate-900 border border-slate-700 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all p-4" onchange="autoFillFromModel(this)">
                                <option value="">Seleccione modelo...</option>
                                @foreach($models as $m)
                                    <option value="{{ $m->id }}" {{ old('model_id') == $m->id ? 'selected' : '' }}>{{ $m->make->name ?? '' }} - {{ $m->name }}</option>
                                @endforeach
                            </select>
                            <button type="button" onclick="openQuickAddModel()" class="px-4 bg-slate-800 hover:bg-blue-600 border border-slate-700 hover:border-blue-500 rounded-xl text-slate-400 hover:text-white transition-all shrink-0 font-bold text-lg">+</button>
                        </div>
                        <input type="hidden" name="model" id="model" value="{{ old('model') }}" />
                        <x-input-error class="mt-2" :messages="$errors->get('model')" />
                    </div>

                    <div>
                        <x-input-label for="year" :value="__('Año')" required />
                        <x-text-input id="year" name="year" type="number" class="mt-1 block w-full" required placeholder="2022" />
                        <x-input-error class="mt-2" :messages="$errors->get('year')" />
                    </div>

                    <div>
                        <x-input-label for="color" :value="__('Color')" />
                        <select id="color" name="color" class="mt-1 block w-full bg-slate-900 border border-slate-700 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all p-4">
                            <option value="">Seleccione color...</option>
                            <option value="Blanco" {{ old('color') == 'Blanco' ? 'selected' : '' }}>Blanco</option>
                            <option value="Negro" {{ old('color') == 'Negro' ? 'selected' : '' }}>Negro</option>
                            <option value="Plateado" {{ old('color') == 'Plateado' ? 'selected' : '' }}>Plateado</option>
                            <option value="Gris" {{ old('color') == 'Gris' ? 'selected' : '' }}>Gris</option>
                            <option value="Rojo" {{ old('color') == 'Rojo' ? 'selected' : '' }}>Rojo</option>
                            <option value="Azul" {{ old('color') == 'Azul' ? 'selected' : '' }}>Azul</option>
                            <option value="Verde" {{ old('color') == 'Verde' ? 'selected' : '' }}>Verde</option>
                            <option value="Beige" {{ old('color') == 'Beige' ? 'selected' : '' }}>Beige</option>
                            <option value="Marrón" {{ old('color') == 'Marrón' ? 'selected' : '' }}>Marrón</option>
                            <option value="Dorado" {{ old('color') == 'Dorado' ? 'selected' : '' }}>Dorado</option>
                            <option value="Naranja" {{ old('color') == 'Naranja' ? 'selected' : '' }}>Naranja</option>
                            <option value="Amarillo" {{ old('color') == 'Amarillo' ? 'selected' : '' }}>Amarillo</option>
                            <option value="Vino" {{ old('color') == 'Vino' ? 'selected' : '' }}>Vino</option>
                            <option value="Celeste" {{ old('color') == 'Celeste' ? 'selected' : '' }}>Celeste</option>
                        </select>
                        <x-input-error class="mt-2" :messages="$errors->get('color')" />
                    </div>

                    <div>
                        <x-input-label for="license_plate" :value="__('Placa')" required />
                        <x-text-input id="license_plate" name="license_plate" type="text" class="mt-1 block w-full uppercase" required placeholder="ABC-123 o ABC1234" maxlength="8" style="text-transform: uppercase;" oninput="this.value=this.value.toUpperCase().replace(/[^A-Z0-9-]/g,'')" />
                        <x-input-error class="mt-2" :messages="$errors->get('license_plate')" />
                    </div>

                    <div>
                        <x-input-label for="vin" :value="__('VIN / Serial de Chasis')" required />
                        <x-text-input id="vin" name="vin" type="text" class="mt-1 block w-full uppercase font-mono tracking-widest" required placeholder="17 caracteres (0-9, A-Z sin I/O/Q)" maxlength="17" style="text-transform: uppercase;" oninput="validateVin(this)" />
                        <p id="vin-hint" class="text-xs text-slate-500 mt-1">Debe tener 17 caracteres. Letras I, O, Q prohibidas.</p>
                        <x-input-error class="mt-2" :messages="$errors->get('vin')" />
                    </div>

                    <div>
                        <x-input-label for="mileage" :value="__('Kilometraje')" />
                        <x-text-input id="mileage" name="mileage" type="number" class="mt-1 block w-full" placeholder="Ej. 50000" min="0" />
                        <x-input-error class="mt-2" :messages="$errors->get('mileage')" />
                    </div>

                    <div>
                        <x-input-label for="fuel_level" :value="__('Nivel de Combustible')" />
                        <select id="fuel_level" name="fuel_level" class="mt-1 block w-full bg-slate-900 border border-slate-700 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all p-4">
                            <option value="">Seleccione nivel...</option>
                            <option value="empty" {{ old('fuel_level') == 'empty' ? 'selected' : '' }}>Vacío</option>
                            <option value="quarter" {{ old('fuel_level') == 'quarter' ? 'selected' : '' }}>1/4</option>
                            <option value="half" {{ old('fuel_level') == 'half' ? 'selected' : '' }}>1/2</option>
                            <option value="three_quarters" {{ old('fuel_level') == 'three_quarters' ? 'selected' : '' }}>3/4</option>
                        </select>
                        <x-input-error class="mt-2" :messages="$errors->get('fuel_level')" />
                    </div>

                    <div>
                        <x-input-label for="assigned_mechanic_id" :value="__('Mecánico Encargado')" />
                        <select id="assigned_mechanic_id" name="assigned_mechanic_id" class="mt-1 block w-full bg-slate-900 border border-slate-700 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all p-4">
                            <option value="">Seleccione mecánico...</option>
                            @foreach($mechanics as $mechanic)
                                <option value="{{ $mechanic->id }}" {{ old('assigned_mechanic_id') == $mechanic->id ? 'selected' : '' }}>{{ $mechanic->name }}</option>
                            @endforeach
                        </select>
                        <x-input-error class="mt-2" :messages="$errors->get('assigned_mechanic_id')" />
                    </div>
                </div>

                <!-- Subir fotos al crear -->
                <div class="border-t border-slate-700 pt-6">
                    <x-input-label :value="__('Fotos del Vehículo (Opcional)')" />
                    <div id="create-drop-zone" class="mt-2 border-2 border-dashed border-slate-600 hover:border-blue-500 rounded-2xl p-6 text-center transition-colors duration-300 cursor-pointer" onclick="document.getElementById('create-photo-input').click()">
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mx-auto text-slate-500 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <p class="text-slate-400 text-sm font-medium">Clic o arrastra fotos aquí para seleccionarlas</p>
                            <p class="text-slate-600 text-xs mt-1">Formatos permitidos: JPG, PNG, GIF, WEBP</p>
                        </div>
                        <div id="create-preview" class="grid grid-cols-4 gap-3 mt-3 hidden" onclick="event.stopPropagation()"></div>
                    </div>
                    <input id="create-photo-input" type="file" name="photos[]" multiple accept="image/*" class="hidden" onchange="previewCreatePhotos(this)">
                    <x-input-error class="mt-2" :messages="$errors->get('photos')" />
                    <x-input-error class="mt-2" :messages="\Illuminate\Support\Arr::flatten($errors->get('photos.*'))" />
                </div>

                <div class="flex items-center justify-end mt-8 gap-4">
                    <a href="{{ route('vehicles.index') }}" class="px-6 py-3 border-2 border-slate-600 text-slate-300 font-bold rounded-xl hover:bg-slate-700 hover:text-white transition-all text-sm">
                        Cancelar
                    </a>
                    <button type="submit" class="px-10 py-4 bg-blue-600 hover:bg-blue-500 text-white font-black rounded-2xl shadow-lg shadow-blue-500/30 transition-all hover:scale-105 active:scale-95">
                        Registrar Vehículo
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const modelsData = @json($models);

        function filterModelsByMake() {
            const makeId = document.getElementById('make_id').value;
            const modelSelect = document.getElementById('model_id');
            const options = modelSelect.querySelectorAll('option');

            options.forEach(opt => {
                if (!opt.value) return;
                const model = modelsData.find(m => m.id == opt.value);
                if (model) {
                    opt.style.display = makeId === '' || model.vehicle_make_id == makeId ? '' : 'none';
                }
            });

            if (modelSelect.value && !modelSelect.querySelector('option[value="' + modelSelect.value + '"]:not([style*="none"])')) {
                modelSelect.value = '';
                document.getElementById('model').value = '';
            }
        }

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
            const oldMakeId = '{{ old('make_id') }}';
            if (oldMakeId) {
                document.getElementById('make_id').value = oldMakeId;
                filterModelsByMake();
            }
            const oldModelId = '{{ old('model_id') }}';
            if (oldModelId) {
                document.getElementById('model_id').value = oldModelId;
                autoFillFromModel(document.getElementById('model_id'));
            }
        });

        function previewCreatePhotos(input) {
            const container = document.getElementById('create-preview');
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

        const createDropZone = document.getElementById('create-drop-zone');
        const createPhotoInput = document.getElementById('create-photo-input');

        if (createDropZone) {
            ['dragenter', 'dragover'].forEach(event => {
                createDropZone.addEventListener(event, (e) => {
                    e.preventDefault();
                    createDropZone.classList.add('border-blue-500', 'bg-blue-500/5');
                });
            });

            ['dragleave', 'drop'].forEach(event => {
                createDropZone.addEventListener(event, (e) => {
                    e.preventDefault();
                    createDropZone.classList.remove('border-blue-500', 'bg-blue-500/5');
                });
            });

            createDropZone.addEventListener('drop', (e) => {
                e.preventDefault();
                createPhotoInput.files = e.dataTransfer.files;
                previewCreatePhotos(createPhotoInput);
            });
        }
    </script>

    <!-- Modal Agregar Marca -->
    <div id="quick-make-modal" class="fixed inset-0 z-50 bg-black/60 backdrop-blur-sm hidden items-center justify-center" onclick="closeQuickModal('quick-make-modal', event)">
        <div class="bg-slate-900 border border-slate-700 rounded-2xl p-6 w-full max-w-sm mx-4 shadow-2xl" onclick="event.stopPropagation()">
            <h3 class="text-lg font-bold text-white mb-4">Agregar Marca</h3>
            <input id="quick-make-input" type="text" placeholder="Nombre de la marca" class="w-full px-4 py-3 bg-slate-800 border border-slate-600 rounded-xl text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500 mb-4">
            <p id="quick-make-error" class="text-red-400 text-xs mb-3 hidden"></p>
            <div class="flex gap-3 justify-end">
                <button onclick="closeQuickModal('quick-make-modal', null)" class="px-5 py-2.5 bg-slate-700 hover:bg-slate-600 text-slate-300 rounded-xl font-bold text-sm transition-all">Cancelar</button>
                <button onclick="submitQuickAddMake()" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-bold text-sm transition-all">Guardar</button>
            </div>
        </div>
    </div>

    <!-- Modal Agregar Modelo -->
    <div id="quick-model-modal" class="fixed inset-0 z-50 bg-black/60 backdrop-blur-sm hidden items-center justify-center" onclick="closeQuickModal('quick-model-modal', event)">
        <div class="bg-slate-900 border border-slate-700 rounded-2xl p-6 w-full max-w-sm mx-4 shadow-2xl" onclick="event.stopPropagation()">
            <h3 class="text-lg font-bold text-white mb-4">Agregar Modelo</h3>
            <input id="quick-model-input" type="text" placeholder="Nombre del modelo" class="w-full px-4 py-3 bg-slate-800 border border-slate-600 rounded-xl text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500 mb-4">
            <p id="quick-model-error" class="text-red-400 text-xs mb-3 hidden"></p>
            <div class="flex gap-3 justify-end">
                <button onclick="closeQuickModal('quick-model-modal', null)" class="px-5 py-2.5 bg-slate-700 hover:bg-slate-600 text-slate-300 rounded-xl font-bold text-sm transition-all">Cancelar</button>
                <button onclick="submitQuickAddModel()" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-bold text-sm transition-all">Guardar</button>
            </div>
        </div>
    </div>

    <script>
        function openQuickAddMake() {
            document.getElementById('quick-make-input').value = '';
            document.getElementById('quick-make-error').classList.add('hidden');
            document.getElementById('quick-make-modal').classList.remove('hidden');
            document.getElementById('quick-make-modal').classList.add('flex');
            setTimeout(() => document.getElementById('quick-make-input').focus(), 100);
        }

        function openQuickAddModel() {
            const makeId = document.getElementById('make_id').value;
            if (!makeId) {
                alert('Primero selecciona o agrega una marca.');
                return;
            }
            document.getElementById('quick-model-input').value = '';
            document.getElementById('quick-model-error').classList.add('hidden');
            document.getElementById('quick-model-modal').classList.remove('hidden');
            document.getElementById('quick-model-modal').classList.add('flex');
            setTimeout(() => document.getElementById('quick-model-input').focus(), 100);
        }

        function closeQuickModal(id, e) {
            if (e === null || (e && e.target === e.currentTarget)) {
                document.getElementById(id).classList.add('hidden');
                document.getElementById(id).classList.remove('flex');
            }
        }

        function submitQuickAddMake() {
            const input = document.getElementById('quick-make-input');
            const error = document.getElementById('quick-make-error');
            const name = input.value.trim();
            if (!name) { error.textContent = 'Escribe el nombre de la marca.'; error.classList.remove('hidden'); return; }
            error.classList.add('hidden');

            fetch('{{ route("quick-add.make") }}', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: JSON.stringify({ name }),
            })
            .then(r => r.json().then(d => ({ status: r.status, data: d })))
            .then(({ status, data }) => {
                if (!data.success) { error.textContent = data.message; error.classList.remove('hidden'); return; }
                const select = document.getElementById('make_id');
                const opt = document.createElement('option');
                opt.value = data.id; opt.textContent = data.name;
                select.appendChild(opt);
                select.value = data.id;
                filterModelsByMake();
                closeQuickModal('quick-make-modal', null);
            })
            .catch(() => { error.textContent = 'Error al guardar. Intenta de nuevo.'; error.classList.remove('hidden'); });
        }

        function submitQuickAddModel() {
            const input = document.getElementById('quick-model-input');
            const error = document.getElementById('quick-model-error');
            const name = input.value.trim();
            const makeId = document.getElementById('make_id').value;
            if (!name) { error.textContent = 'Escribe el nombre del modelo.'; error.classList.remove('hidden'); return; }
            error.classList.add('hidden');

            fetch('{{ route("quick-add.model") }}', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: JSON.stringify({ name, make_id: makeId }),
            })
            .then(r => r.json().then(d => ({ status: r.status, data: d })))
            .then(({ status, data }) => {
                if (!data.success) { error.textContent = data.message; error.classList.remove('hidden'); return; }
                const select = document.getElementById('model_id');
                const opt = document.createElement('option');
                opt.value = data.id; opt.textContent = data.make_name + ' - ' + data.name;
                select.appendChild(opt);
                select.value = data.id;
                autoFillFromModel(select);
                closeQuickModal('quick-model-modal', null);
            })
            .catch(() => { error.textContent = 'Error al guardar. Intenta de nuevo.'; error.classList.remove('hidden'); });
        }

        // Enter key support on modals
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('quick-make-input').addEventListener('keydown', function(e) {
                if (e.key === 'Enter') { e.preventDefault(); submitQuickAddMake(); }
            });
            document.getElementById('quick-model-input').addEventListener('keydown', function(e) {
                if (e.key === 'Enter') { e.preventDefault(); submitQuickAddModel(); }
            });
        });
    </script>
</x-app-layout>
