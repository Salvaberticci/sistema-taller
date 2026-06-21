<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="font-bold text-2xl text-white leading-tight flex items-center gap-3">
                    <a href="{{ route('vehicles.index') }}" class="text-slate-500 hover:text-white transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                    </a>
                    {{ __('Detalles del Vehículo') }}
                </h2>
                <p class="text-slate-400 text-sm mt-1 ml-9">{{ $vehicle->make }} {{ $vehicle->model }} ({{ $vehicle->year }})</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('vehicles.edit', $vehicle->id) }}" class="px-4 py-2 bg-slate-700 hover:bg-slate-600 text-white font-bold rounded-xl transition-all shadow-lg flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                    </svg>
                    Editar
                </a>
                <a href="{{ route('orders.create', ['vehicle_id' => $vehicle->id]) }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl transition-all shadow-lg shadow-blue-500/20 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                    Nueva Orden
                </a>
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- Tarjeta de Información del Vehículo -->
            <div class="lg:col-span-2 space-y-6">
                <div class="premium-card rounded-2xl shadow-xl overflow-hidden bg-slate-900 border border-slate-800">
                    <div class="p-6 border-b border-slate-700 bg-slate-800/30 flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            <div class="w-16 h-16 bg-blue-600/20 rounded-2xl flex items-center justify-center font-bold text-3xl text-blue-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-white">{{ $vehicle->make }} {{ $vehicle->model }}</h3>
                                <p class="text-blue-400 font-mono text-sm font-bold uppercase tracking-widest">{{ $vehicle->license_plate }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-xs text-slate-500 font-bold uppercase tracking-wider">Año</p>
                            <p class="text-xl font-black text-white">{{ $vehicle->year }}</p>
                        </div>
                    </div>
                    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <p class="text-xs text-slate-500 font-bold uppercase tracking-wider mb-1">Color</p>
                            <p class="text-slate-300">{{ $vehicle->color ?: 'No especificado' }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-500 font-bold uppercase tracking-wider mb-1">VIN / Chasis</p>
                            <p class="text-slate-300 font-mono tracking-widest">{{ $vehicle->vin ?: 'No especificado' }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-500 font-bold uppercase tracking-wider mb-1">Kilometraje</p>
                            <p class="text-slate-300">{{ $vehicle->mileage ? number_format($vehicle->mileage) . ' km' : 'No registrado' }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-500 font-bold uppercase tracking-wider mb-1">Nivel Combustible</p>
                            <p class="text-slate-300">
                                @switch($vehicle->fuel_level)
                                    @case('empty') Vacío @break
                                    @case('quarter') 1/4 @break
                                    @case('half') 1/2 @break
                                    @case('three_quarters') 3/4 @break
                                    @default No registrado
                                @endswitch
                            </p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-500 font-bold uppercase tracking-wider mb-1">Mecánico Encargado</p>
                            <p class="text-slate-300">{{ $vehicle->assignedMechanic?->name ?: 'No asignado' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Galería de Fotos -->
                <div class="premium-card rounded-2xl shadow-xl overflow-hidden bg-slate-900 border border-slate-800">
                    <div class="p-6 border-b border-slate-700 bg-slate-800/30 flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <h3 class="text-lg font-bold text-white">Galería de Fotos</h3>
                            <span class="ml-2 text-xs font-bold bg-slate-700 text-slate-300 px-2 py-0.5 rounded-full">{{ $vehicle->photos->count() }}</span>
                        </div>
                        <button onclick="document.getElementById('upload-modal').classList.remove('hidden')" class="px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold rounded-xl transition-all flex items-center gap-1.5">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            Subir Fotos
                        </button>
                    </div>
                    <div class="p-6">
                        @if($vehicle->photos->count() > 0)
                            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                                @foreach($vehicle->photos as $photo)
                                    <div class="group relative w-full h-32 sm:h-40 md:h-48 rounded-xl overflow-hidden border border-slate-700 hover:border-blue-500/50 transition-all duration-300 cursor-pointer" onclick="openLightbox('{{ asset('storage/' . $photo->photo_path) }}', '{{ $photo->description ?? $vehicle->make . ' ' . $vehicle->model }}')">
                                        <img src="{{ asset('storage/' . $photo->photo_path) }}" 
                                             alt="{{ $photo->description ?? 'Foto del vehículo' }}" 
                                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                        <!-- Overlay oscuro on hover -->
                                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                            <div class="absolute bottom-0 left-0 right-0 p-3">
                                                @if($photo->description)
                                                    <p class="text-white text-xs font-medium truncate">{{ $photo->description }}</p>
                                                @endif
                                                <p class="text-slate-400 text-[10px]">{{ $photo->created_at->format('d/m/Y H:i') }}</p>
                                            </div>
                                        </div>
                                        <!-- Botón eliminar -->
                                        <form action="{{ route('vehicles.photos.destroy', $photo->id) }}" method="POST" class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300" onsubmit="return confirm('¿Eliminar esta foto?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="w-7 h-7 bg-red-500/80 hover:bg-red-600 rounded-lg flex items-center justify-center transition-colors shadow-lg" onclick="event.stopPropagation()">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-white" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        </form>
                                        <!-- Icono de zoom -->
                                        <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none">
                                            <div class="w-10 h-10 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7" />
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-12">
                                <div class="w-20 h-20 mx-auto bg-slate-800 rounded-2xl flex items-center justify-center mb-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <p class="text-slate-500 font-bold text-sm">No hay fotos del vehículo</p>
                                <p class="text-slate-600 text-xs mt-1">Sube fotos para documentar el estado del vehículo</p>
                                <button onclick="document.getElementById('upload-modal').classList.remove('hidden')" class="mt-4 px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold rounded-xl transition-all inline-flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                    </svg>
                                    Subir primera foto
                                </button>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Historial de Órdenes -->
                <div class="premium-card rounded-2xl shadow-xl overflow-hidden bg-slate-900 border border-slate-800">
                    <div class="p-6 border-b border-slate-700 bg-slate-800/30 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        <h3 class="text-lg font-bold text-white">Historial de Servicio</h3>
                    </div>
                    <div class="p-0">
                        @if($vehicle->serviceOrders->count() > 0)
                            <table class="w-full text-left">
                                <thead class="bg-slate-800/50 text-xs text-slate-400 uppercase">
                                    <tr>
                                        <th class="px-6 py-4 font-bold">Orden</th>
                                        <th class="px-6 py-4 font-bold">Fecha</th>
                                        <th class="px-6 py-4 font-bold">Estado</th>
                                        <th class="px-6 py-4 font-bold text-right">Total</th>
                                        <th class="px-6 py-4 font-bold"></th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-700">
                                    @foreach($vehicle->serviceOrders as $order)
                                        <tr class="hover:bg-slate-800/30 transition-colors">
                                            <td class="px-6 py-4">
                                                <p class="text-sm font-bold text-white">#OT-{{ $order->id }}</p>
                                            </td>
                                            <td class="px-6 py-4">
                                                <p class="text-sm text-slate-400">{{ $order->created_at->format('d/m/Y') }}</p>
                                            </td>
                                            <td class="px-6 py-4">
                                                <span class="text-[10px] font-black {{ $order->status == 'pending' ? 'bg-yellow-500/10 text-yellow-500 border-yellow-500/20' : 'bg-green-500/10 text-green-500 border-green-500/20' }} px-2 py-0.5 rounded uppercase tracking-widest border">
                                                    {{ $order->status == 'pending' ? 'En Espera' : 'Finalizada' }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 text-right">
                                                <p class="text-sm font-bold text-white">${{ number_format($order->total_amount, 2) }}</p>
                                            </td>
                                            <td class="px-6 py-4 text-right">
                                                <a href="{{ route('orders.show', $order->id) }}" class="text-slate-500 hover:text-white transition-colors">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                                    </svg>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <div class="p-8 text-center">
                                <p class="text-slate-500 font-medium">No hay historial de servicio para este vehículo.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Panel Lateral (Propietario) -->
            <div class="space-y-6">
                <div class="premium-card rounded-2xl shadow-xl overflow-hidden bg-slate-900 border border-slate-800">
                    <div class="p-5 border-b border-slate-700 bg-slate-800/30">
                        <h3 class="text-sm font-bold text-slate-400 uppercase tracking-wider flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            Propietario
                        </h3>
                    </div>
                    <div class="p-5 space-y-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-blue-600/20 rounded-full flex items-center justify-center font-bold text-blue-500">
                                {{ substr($vehicle->customer->name, 0, 1) }}
                            </div>
                            <div>
                                <p class="text-base font-bold text-white">{{ $vehicle->customer->name }}</p>
                                <p class="text-xs text-slate-500">{{ $vehicle->customer->phone }}</p>
                            </div>
                        </div>
                        <a href="{{ route('customers.show', $vehicle->customer->id) }}" class="w-full block text-center px-4 py-2 bg-slate-800 hover:bg-slate-700 text-sm font-bold text-white rounded-xl transition-colors border border-slate-700">
                            Ver Perfil Completo
                        </a>
                    </div>
                </div>

                <!-- Estadísticas rápidas -->
                <div class="premium-card rounded-2xl shadow-xl overflow-hidden bg-slate-900 border border-slate-800">
                    <div class="p-5 border-b border-slate-700 bg-slate-800/30">
                        <h3 class="text-sm font-bold text-slate-400 uppercase tracking-wider flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                            Resumen
                        </h3>
                    </div>
                    <div class="p-5 space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-slate-400">Total Órdenes</span>
                            <span class="text-sm font-bold text-white">{{ $vehicle->serviceOrders->count() }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-slate-400">Fotos</span>
                            <span class="text-sm font-bold text-white">{{ $vehicle->photos->count() }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-slate-400">Total Gastado</span>
                            <span class="text-sm font-bold text-emerald-400">${{ number_format($vehicle->serviceOrders->sum('total_amount'), 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de subida de fotos -->
    <div id="upload-modal" class="{{ $errors->has('photos') || $errors->has('photos.*') ? '' : 'hidden' }} fixed inset-0 z-50 flex items-center justify-center p-4">
        <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" onclick="document.getElementById('upload-modal').classList.add('hidden')"></div>
        <div class="relative bg-slate-900 border border-slate-700 rounded-2xl shadow-2xl w-full max-w-lg z-10 overflow-hidden">
            <div class="p-6 border-b border-slate-700 bg-slate-800/30 flex items-center justify-between">
                <h3 class="text-lg font-bold text-white flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                    </svg>
                    Subir Fotos del Vehículo
                </h3>
                <button onclick="document.getElementById('upload-modal').classList.add('hidden')" class="text-slate-500 hover:text-white transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <form action="{{ route('vehicles.photos.store', $vehicle->id) }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
                @csrf
                <!-- Zona de drag & drop -->
                <div id="drop-zone" class="border-2 border-dashed border-slate-600 hover:border-blue-500 rounded-2xl p-8 text-center transition-colors duration-300 cursor-pointer" onclick="document.getElementById('photo-input').click()">
                    <div id="drop-zone-content">
                        <div class="w-16 h-16 mx-auto bg-blue-600/10 rounded-2xl flex items-center justify-center mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <p class="text-white font-bold text-sm">Arrastra fotos aquí o haz clic para seleccionar</p>
                        <p class="text-slate-500 text-xs mt-1">Formatos permitidos: JPG, PNG, GIF, WEBP</p>
                    </div>
                    <div id="preview-container" class="grid grid-cols-3 gap-3 mt-4 hidden" onclick="event.stopPropagation()"></div>
                </div>
                <input id="photo-input" type="file" name="photos[]" multiple accept="image/*" class="hidden" onchange="previewPhotos(this)">
                <x-input-error class="mt-2" :messages="$errors->get('photos')" />
                <x-input-error class="mt-2" :messages="\Illuminate\Support\Arr::flatten($errors->get('photos.*'))" />
                
                <div class="flex items-center justify-end gap-3">
                    <button type="button" onclick="document.getElementById('upload-modal').classList.add('hidden')" class="px-4 py-2 text-sm font-bold text-slate-400 hover:text-white transition-colors">
                        Cancelar
                    </button>
                    <button type="submit" id="upload-btn" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl transition-all shadow-lg shadow-blue-500/20 disabled:opacity-50 disabled:cursor-not-allowed flex items-center gap-2" disabled>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                        </svg>
                        Subir Fotos
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Lightbox -->
    <div id="lightbox" class="hidden fixed inset-0 z-[60] flex items-center justify-center p-4">
        <div class="absolute inset-0 bg-black/90 backdrop-blur-md" onclick="closeLightbox()"></div>
        <div class="relative max-w-4xl max-h-[85vh] z-10">
            <button onclick="closeLightbox()" class="absolute -top-12 right-0 text-white/60 hover:text-white transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
            <img id="lightbox-img" src="" alt="" class="max-w-full max-h-[85vh] object-contain rounded-xl shadow-2xl">
            <p id="lightbox-caption" class="text-center text-white/70 text-sm mt-4"></p>
        </div>
    </div>

    <script>
        // Preview photos before upload
        function previewPhotos(input) {
            const container = document.getElementById('preview-container');
            const btn = document.getElementById('upload-btn');
            container.innerHTML = '';
            
            if (input.files.length > 0) {
                container.classList.remove('hidden');
                btn.disabled = false;
                
                Array.from(input.files).forEach((file, index) => {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const div = document.createElement('div');
                        div.className = 'relative w-full h-24 sm:h-28 rounded-xl overflow-hidden border border-slate-600';
                        div.innerHTML = `
                            <img src="${e.target.result}" class="w-full h-full object-cover" alt="Preview">
                            <div class="absolute bottom-0 inset-x-0 bg-black/60 px-2 py-1">
                                <p class="text-white text-[10px] truncate">${file.name}</p>
                            </div>
                        `;
                        container.appendChild(div);
                    };
                    reader.readAsDataURL(file);
                });
            } else {
                container.classList.add('hidden');
                btn.disabled = true;
            }
        }

        // Drag & Drop
        const dropZone = document.getElementById('drop-zone');
        const photoInput = document.getElementById('photo-input');

        if (dropZone) {
            ['dragenter', 'dragover'].forEach(event => {
                dropZone.addEventListener(event, (e) => {
                    e.preventDefault();
                    dropZone.classList.add('border-blue-500', 'bg-blue-500/5');
                });
            });

            ['dragleave', 'drop'].forEach(event => {
                dropZone.addEventListener(event, (e) => {
                    e.preventDefault();
                    dropZone.classList.remove('border-blue-500', 'bg-blue-500/5');
                });
            });

            dropZone.addEventListener('drop', (e) => {
                e.preventDefault();
                photoInput.files = e.dataTransfer.files;
                previewPhotos(photoInput);
            });
        }

        // Lightbox
        function openLightbox(src, caption) {
            document.getElementById('lightbox-img').src = src;
            document.getElementById('lightbox-caption').textContent = caption;
            document.getElementById('lightbox').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeLightbox() {
            document.getElementById('lightbox').classList.add('hidden');
            document.body.style.overflow = '';
        }

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                closeLightbox();
                document.getElementById('upload-modal').classList.add('hidden');
            }
        });
    </script>
</x-app-layout>
