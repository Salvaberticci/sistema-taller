<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="font-bold text-2xl text-white leading-tight flex items-center gap-3">
                    <a href="{{ route('orders.index') }}" class="text-slate-500 hover:text-white transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                    </a>
                    {{ __('Detalles de Orden #OT-') }}{{ $order->id }}
                </h2>
                <p class="text-slate-400 text-sm mt-1 ml-9">Registrada el {{ \Carbon\Carbon::parse($order->entry_date)->format('d/m/Y H:i') }}</p>
            </div>
            <div class="flex items-center gap-3">
                <form action="{{ route('orders.updateStatus', $order) }}" method="POST" class="flex items-center gap-2">
                    @csrf @method('PATCH')
                    <select name="status" onchange="this.form.submit()" class="bg-slate-800 border-slate-700 text-white rounded-xl text-sm font-bold focus:ring-blue-500">
                        <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>En Espera</option>
                        <option value="in_progress" {{ $order->status == 'in_progress' ? 'selected' : '' }}>En Proceso</option>
                        <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Completada</option>
                        <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelada</option>
                    </select>
                </form>
                @if(!$order->invoice)
                    <form action="{{ route('invoices.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="service_order_id" value="{{ $order->id }}">
                        <button type="submit" class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white font-bold rounded-xl transition-all shadow-lg shadow-green-500/20">Finalizar y Facturar</button>
                    </form>
                @else
                    <a href="{{ route('invoices.show', $order->invoice) }}" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl shadow-lg">Ver Factura</a>
                @endif
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6 pb-12">
        @if (session('status'))
            <div class="p-4 bg-green-500/10 border border-green-500/20 rounded-xl text-green-400 font-bold text-sm">
                {{ session('status') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 space-y-8">
                <!-- Servicos y Repuestos List -->
                <div class="premium-card rounded-[2rem] shadow-xl overflow-hidden bg-slate-900 border border-slate-800">
                    <div class="p-6 border-b border-slate-700 bg-slate-800/30 flex justify-between items-center">
                        <h3 class="text-lg font-bold text-white">Servicios y Repuestos Cargados</h3>
                    </div>
                    <div class="p-0">
                        <table class="w-full text-left">
                            <thead class="bg-slate-800/50 text-[10px] text-slate-500 uppercase font-black tracking-widest">
                                <tr>
                                    <th class="px-6 py-4">Concepto</th>
                                    <th class="px-6 py-4 text-center">Cant.</th>
                                    <th class="px-6 py-4 text-right">Unitario</th>
                                    <th class="px-6 py-4 text-right">Total</th>
                                    <th class="px-6 py-4 text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-800">
                                @forelse($order->workItems as $item)
                                    <tr class="hover:bg-slate-800/20 transition-colors">
                                        <td class="px-6 py-4">
                                            <p class="text-sm font-bold text-white">{{ $item->description }}</p>
                                            <span class="text-[10px] font-black uppercase tracking-widest {{ $item->type == 'part' ? 'text-blue-400' : 'text-purple-400' }}">
                                                {{ $item->type == 'part' ? 'Repuesto' : 'Mano de Obra' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-center text-sm text-slate-300">{{ $item->quantity }}</td>
                                        <td class="px-6 py-4 text-right">@money($item->unit_price)</td>
                                        <td class="px-6 py-4 text-right">@money($item->total)</td>
                                        <td class="px-6 py-4 text-center">
                                            <form action="{{ route('orders.removeItem', $item) }}" method="POST" onsubmit="return confirm('¿Eliminar este item?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:text-red-400 transition-colors">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mx-auto" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="5" class="px-6 py-12 text-center text-slate-500">No hay items cargados en esta orden.</td></tr>
                                @endforelse
                            </tbody>
                            <tfoot class="bg-slate-800/40">
                                <tr>
                                    <td colspan="3" class="px-6 py-6 text-right text-xs font-black text-slate-500 uppercase tracking-widest">Total de la Orden</td>
                                    <td class="px-6 py-6 text-right">@money($order->total_amount)</td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <!-- Add Item Form -->
                <div class="premium-card rounded-[2rem] p-8 border border-slate-700 bg-slate-800/20">
                    <h3 class="text-lg font-bold text-white mb-6">Añadir Concepto a la Orden</h3>
                    <form action="{{ route('orders.addItem', $order) }}" method="POST" class="grid grid-cols-1 md:grid-cols-4 gap-6 items-end">
                        @csrf
                        <div class="md:col-span-2">
                            <x-input-label for="type" :value="__('Tipo de Item')" />
                            <select id="type" name="type" class="mt-1 block w-full bg-slate-900 border-slate-700 rounded-xl text-white focus:ring-blue-500 p-3 text-sm" onchange="toggleItemType(this.value)">
                                <option value="labor">Mano de Obra / Servicio</option>
                                <option value="part">Repuesto de Inventario</option>
                            </select>
                        </div>
                        <div>
                            <x-input-label for="quantity" :value="__('Cantidad')" />
                            <x-text-input id="quantity" name="quantity" type="number" step="0.01" class="mt-1 block w-full text-sm" value="1" required />
                        </div>
                        <div>
                            <button type="submit" class="w-full py-3.5 bg-blue-600 hover:bg-blue-700 text-white font-black rounded-xl shadow-lg transition-all active:scale-95 text-xs uppercase tracking-widest">
                                Añadir Item
                            </button>
                        </div>

                        <div class="md:col-span-3" id="description_container">
                            <x-input-label for="description" :value="__('Descripción / Nombre del Servicio')" />
                            <x-text-input id="description" name="description" type="text" class="mt-1 block w-full text-sm" placeholder="Ej: Cambio de Frenos Delanteros" />
                        </div>

                        <div class="md:col-span-3 hidden" id="parts_container">
                            <x-input-label for="part_select" :value="__('Seleccionar Repuesto')" />
                            <select id="part_select" class="mt-1 block w-full bg-slate-900 border-slate-700 rounded-xl text-white focus:ring-blue-500 p-3 text-sm" onchange="updatePartPrice(this)">
                                <option value="">-- Buscar repuesto --</option>
                                @foreach($parts as $part)
                                    <option value="{{ $part->name }}" data-price="{{ $part->price }}">{{ $part->name }} (Stock: {{ $part->stock }}) - ${{ $part->price }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <x-input-label for="unit_price" :value="__('Precio Unitario ($)')" />
                            <x-text-input id="unit_price" name="unit_price" type="number" step="0.01" class="mt-1 block w-full text-sm" required />
                        </div>
                    </form>
                </div>
            </div>

            <div class="space-y-8">
                <!-- Vehicle & Customer Info -->
                <div class="premium-card p-6 rounded-[2rem] border border-slate-700 bg-slate-800/40">
                    <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-4">Información del Servicio</p>
                    <div class="space-y-6">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-blue-600/10 rounded-2xl flex items-center justify-center text-blue-500 font-bold border border-blue-500/20">
                                {{ $order->vehicle->year }}
                            </div>
                            <div>
                                <h4 class="text-white font-bold">{{ $order->vehicle->make }} {{ $order->vehicle->model }}</h4>
                                <p class="text-blue-400 font-mono text-xs font-bold">{{ $order->vehicle->license_plate }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-purple-600/10 rounded-2xl flex items-center justify-center text-purple-500 font-bold border border-purple-500/20">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                            </div>
                            <div>
                                <h4 class="text-white font-bold">{{ $order->customer->name }}</h4>
                                <p class="text-slate-400 text-xs">{{ $order->customer->phone }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Diagnosis Card -->
                <div class="premium-card p-6 rounded-[2rem] border border-slate-700 bg-slate-900 shadow-inner">
                    <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-3">Diagnóstico Inicial / Reporte</p>
                    <p class="text-sm text-slate-300 leading-relaxed italic border-l-2 border-slate-700 pl-4">
                        "{{ $order->description }}"
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleItemType(type) {
            const descCont = document.getElementById('description_container');
            const partsCont = document.getElementById('parts_container');
            const descInput = document.getElementById('description');
            
            if (type === 'part') {
                descCont.classList.add('hidden');
                partsCont.classList.remove('hidden');
                descInput.value = '';
            } else {
                descCont.classList.remove('hidden');
                partsCont.classList.add('hidden');
                document.getElementById('part_select').value = '';
                document.getElementById('unit_price').value = '';
            }
        }

        function updatePartPrice(select) {
            const option = select.options[select.selectedIndex];
            const price = option.getAttribute('data-price');
            const descInput = document.getElementById('description');
            const priceInput = document.getElementById('unit_price');
            
            if (price) {
                descInput.value = option.value;
                priceInput.value = price;
            }
        }
    </script>
</x-app-layout>
