<x-app-layout>
    <x-slot name="header">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h2 class="font-bold text-2xl text-white leading-tight">
                        {{ __('Inventario de Repuestos') }}
                    </h2>
                    <p class="text-slate-400 text-sm mt-1">Control de stock, alertas y proveedores.</p>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('reports.inventory') }}" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl transition-all shadow-lg shadow-blue-500/20 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                        </svg>
                        Generar Reporte
                    </a>
                    <a href="{{ route('inventory.create') }}" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl transition-all shadow-lg shadow-blue-500/20 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                        </svg>
                        Nuevo Repuesto
                    </a>
                </div>
            </div>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        @if (session('status'))
            <div class="mb-6 p-4 bg-green-500/10 border border-green-500/20 rounded-xl text-green-400 font-bold text-sm">
                {{ session('status') }}
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="premium-card p-4 rounded-2xl border-l-4 border-l-red-500">
                <p class="text-[10px] font-black text-red-500 uppercase tracking-widest mb-1">Stock Crítico</p>
                <h4 class="text-2xl font-black text-white">{{ $parts->where('stock', '<=', 'min_stock')->count() }} items</h4>
            </div>
            <div class="premium-card p-4 rounded-2xl border-l-4 border-l-blue-500">
                <p class="text-[10px] font-black text-blue-500 uppercase tracking-widest mb-1">Valor Total</p>
                <h4 class="mt-1">@money($parts->sum(fn($p) => $p->stock * $p->price))</h4>
            </div>
            <div class="premium-card p-4 rounded-2xl border-l-4 border-l-green-500">
                <p class="text-[10px] font-black text-green-500 uppercase tracking-widest mb-1">Total Repuestos</p>
                <h4 class="text-2xl font-black text-white">{{ $parts->count() }}</h4>
            </div>
        </div>

        <div class="premium-card rounded-2xl shadow-xl overflow-hidden">
            <div class="p-6 border-b border-slate-700 bg-slate-800/30 flex flex-wrap gap-4 justify-between items-center">
                <input type="text" placeholder="Buscar por código, nombre o categoría..." 
                    class="block w-full md:w-96 px-4 py-2 bg-slate-900 border border-slate-700 rounded-xl text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-slate-800/50 text-xs text-slate-400 uppercase font-black">
                        <tr>
                            <th class="px-6 py-4">Producto</th>
                            <th class="px-6 py-4">Categoría</th>
                            <th class="px-6 py-4">Stock</th>
                            <th class="px-6 py-4">Precio Venta</th>
                            <th class="px-6 py-4 text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-700">
                        @forelse($parts as $part)
                            <tr class="hover:bg-slate-800/30 transition-colors">
                                <td class="px-6 py-4">
                                    <p class="text-sm font-bold text-white">{{ $part->name }}</p>
                                    <p class="text-[10px] text-slate-500 uppercase font-bold tracking-widest">SKU: {{ $part->sku ?? 'N/A' }}</p>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 bg-blue-500/10 text-blue-400 text-[10px] font-black rounded-full border border-blue-500/20">
                                        {{ $part->category ?? 'GENERAL' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        <span class="text-sm font-bold {{ $part->stock <= $part->min_stock ? 'text-red-400' : 'text-white' }}">
                                            {{ $part->stock }}
                                        </span>
                                        <span class="w-2 h-2 rounded-full {{ $part->stock <= $part->min_stock ? 'bg-red-500 animate-pulse' : 'bg-green-500' }}"></span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">@money($part->price)</td>
                                <td class="px-6 py-4">
                                    <div class="flex justify-center gap-3">
                                        <a href="{{ route('inventory.edit', $part) }}" class="text-slate-400 hover:text-white">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                            </svg>
                                        </a>
                                        <form action="{{ route('inventory.destroy', $part) }}" method="POST" onsubmit="return confirm('¿Estás seguro?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-slate-400 hover:text-red-500">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-slate-500">No hay repuestos registrados.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
