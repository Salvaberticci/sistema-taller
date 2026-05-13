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
                <button class="px-6 py-3 bg-slate-800 hover:bg-slate-700 text-white font-bold rounded-xl transition-all border border-slate-700 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                    Nuevo Repuesto
                </button>
                <button class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl transition-all shadow-lg shadow-blue-500/20 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 100-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z" />
                    </svg>
                    Entrada de Stock
                </button>
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="premium-card p-4 rounded-2xl border-l-4 border-l-red-500">
                <p class="text-[10px] font-black text-red-500 uppercase tracking-widest mb-1">Stock Crítico</p>
                <h4 class="text-2xl font-black text-white">5 items</h4>
            </div>
            <div class="premium-card p-4 rounded-2xl border-l-4 border-l-blue-500">
                <p class="text-[10px] font-black text-blue-500 uppercase tracking-widest mb-1">Valor Total</p>
                <h4 class="text-2xl font-black text-white">$45,200.00</h4>
            </div>
            <div class="premium-card p-4 rounded-2xl border-l-4 border-l-purple-500">
                <p class="text-[10px] font-black text-purple-500 uppercase tracking-widest mb-1">Movimientos hoy</p>
                <h4 class="text-2xl font-black text-white">24</h4>
            </div>
            <div class="premium-card p-4 rounded-2xl border-l-4 border-l-green-500">
                <p class="text-[10px] font-black text-green-500 uppercase tracking-widest mb-1">Proveedores Activos</p>
                <h4 class="text-2xl font-black text-white">12</h4>
            </div>
        </div>

        <div class="premium-card rounded-2xl shadow-xl overflow-hidden">
            <div class="p-6 border-b border-slate-700 bg-slate-800/30 flex flex-wrap gap-4 justify-between items-center">
                <input type="text" placeholder="Buscar por código, nombre o categoría..." 
                    class="block w-full md:w-96 px-4 py-2 bg-slate-900 border border-slate-700 rounded-xl text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                <div class="flex gap-2">
                    <button class="px-4 py-2 bg-slate-800 text-slate-300 text-xs font-bold rounded-lg border border-slate-700">Filtros Avanzados</button>
                </div>
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
                        <tr class="hover:bg-slate-800/30 transition-colors">
                            <td class="px-6 py-4">
                                <p class="text-sm font-bold text-white">Filtro de Aceite Sintético</p>
                                <p class="text-[10px] text-slate-500 uppercase font-bold tracking-widest">COD: FA-0012</p>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 bg-blue-500/10 text-blue-400 text-[10px] font-black rounded-full border border-blue-500/20">MANTENIMIENTO</span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <span class="text-sm font-bold text-white">15</span>
                                    <span class="w-2 h-2 rounded-full bg-green-500 shadow-lg shadow-green-500/50"></span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm font-black text-white">$15.00</td>
                            <td class="px-6 py-4">
                                <div class="flex justify-center gap-2">
                                    <button class="p-2 text-slate-400 hover:text-white"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" /></svg></button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
