<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="font-bold text-2xl text-white leading-tight">
                    {{ __('Facturación y Pagos') }}
                </h2>
                <p class="text-slate-400 text-sm mt-1">Gestión de ingresos, facturas y flujo de caja.</p>
            </div>
            <button class="px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-bold rounded-xl transition-all shadow-lg shadow-green-500/20 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                </svg>
                Registrar Pago
            </button>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Finance Overview -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
            <div class="premium-card p-8 rounded-[2.5rem] bg-gradient-to-br from-slate-800 to-slate-900 border border-slate-700 shadow-2xl relative overflow-hidden">
                <div class="relative z-10">
                    <p class="text-sm font-bold text-slate-500 uppercase tracking-widest mb-2">Ingresos Totales (Mes)</p>
                    <h3 class="text-4xl font-black text-white">$24,850.45</h3>
                    <div class="mt-6 flex items-center gap-4">
                        <div class="flex flex-col">
                            <span class="text-[10px] font-bold text-slate-500 uppercase">Cobrado</span>
                            <span class="text-lg font-bold text-green-400">$21,000.00</span>
                        </div>
                        <div class="w-px h-8 bg-slate-700"></div>
                        <div class="flex flex-col">
                            <span class="text-[10px] font-bold text-slate-500 uppercase">Pendiente</span>
                            <span class="text-lg font-bold text-orange-400">$3,850.45</span>
                        </div>
                    </div>
                </div>
                <div class="absolute -right-10 -bottom-10 w-48 h-48 bg-blue-600/10 rounded-full blur-3xl"></div>
            </div>

            <div class="premium-card p-8 rounded-[2.5rem] flex flex-col justify-center border border-slate-700">
                <h4 class="text-lg font-bold text-white mb-6">Métodos de Pago Populares</h4>
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-green-500/10 rounded-lg flex items-center justify-center text-green-500 font-bold text-xs">$</div>
                            <span class="text-sm font-medium text-slate-300">Efectivo</span>
                        </div>
                        <span class="text-sm font-bold text-white">45%</span>
                    </div>
                    <div class="w-full bg-slate-800 rounded-full h-1.5">
                        <div class="bg-green-500 h-1.5 rounded-full" style="width: 45%"></div>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-blue-500/10 rounded-lg flex items-center justify-center text-blue-500 font-bold text-xs">C</div>
                            <span class="text-sm font-medium text-slate-300">Tarjeta / Transferencia</span>
                        </div>
                        <span class="text-sm font-bold text-white">55%</span>
                    </div>
                    <div class="w-full bg-slate-800 rounded-full h-1.5">
                        <div class="bg-blue-500 h-1.5 rounded-full" style="width: 55%"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="premium-card rounded-2xl shadow-xl overflow-hidden">
            <div class="p-6 border-b border-slate-700 bg-slate-800/30 flex items-center justify-between">
                <h3 class="font-bold text-lg text-white">Últimas Facturas</h3>
                <div class="flex gap-2">
                    <button class="px-4 py-2 bg-slate-800 text-slate-400 text-xs font-bold rounded-lg border border-slate-700 hover:text-white transition-colors">Exportar Excel</button>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-slate-800/50 text-xs text-slate-400 uppercase font-black">
                        <tr>
                            <th class="px-6 py-4">N° Factura</th>
                            <th class="px-6 py-4">Cliente</th>
                            <th class="px-6 py-4">Fecha</th>
                            <th class="px-6 py-4">Total</th>
                            <th class="px-6 py-4">Estado</th>
                            <th class="px-6 py-4 text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-700">
                        <tr class="hover:bg-slate-800/30 transition-colors">
                            <td class="px-6 py-4 font-bold text-white">#FAC-2024-001</td>
                            <td class="px-6 py-4 text-sm text-slate-300">María García</td>
                            <td class="px-6 py-4 text-sm text-slate-500">23 Abr 2024</td>
                            <td class="px-6 py-4 font-black text-white">$1,200.00</td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 bg-green-500/10 text-green-500 text-[10px] font-black rounded-full border border-green-500/20 uppercase tracking-widest">Pagado</span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex justify-center gap-3 text-slate-400">
                                    <button class="hover:text-red-400"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" /></svg></button>
                                    <button class="hover:text-blue-400"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" /></svg></button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
