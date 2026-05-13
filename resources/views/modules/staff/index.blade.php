<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="font-bold text-2xl text-white leading-tight">
                    {{ __('Personal y Mecánicos') }}
                </h2>
                <p class="text-slate-400 text-sm mt-1">Gestión de equipo, especialidades y productividad.</p>
            </div>
            <button class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl transition-all shadow-lg shadow-blue-500/20 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                </svg>
                Añadir Colaborador
            </button>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Staff Card 1 -->
            <div class="premium-card p-8 rounded-[2.5rem] shadow-2xl border border-slate-700 flex flex-col items-center text-center group hover:scale-[1.02] transition-all">
                <div class="relative mb-6">
                    <div class="w-24 h-24 bg-blue-600 rounded-full flex items-center justify-center text-3xl font-black text-white shadow-xl shadow-blue-500/20 group-hover:scale-110 transition-transform duration-500">
                        RM
                    </div>
                    <div class="absolute -bottom-1 -right-1 w-8 h-8 bg-green-500 border-4 border-slate-900 rounded-full shadow-lg"></div>
                </div>
                <h3 class="text-xl font-bold text-white mb-1">Roberto Mendoza</h3>
                <p class="text-xs font-black text-blue-400 uppercase tracking-widest mb-4">Mecánico Senior</p>
                
                <div class="w-full grid grid-cols-2 gap-4 mt-6 pt-6 border-t border-slate-700/50">
                    <div>
                        <p class="text-[10px] text-slate-500 font-bold uppercase">Órdenes Hoy</p>
                        <p class="text-lg font-black text-white">4</p>
                    </div>
                    <div>
                        <p class="text-[10px] text-slate-500 font-bold uppercase">Eficiencia</p>
                        <p class="text-lg font-black text-green-400">98%</p>
                    </div>
                </div>
                
                <button class="mt-8 w-full py-3 bg-slate-800 hover:bg-slate-700 text-slate-300 font-bold rounded-xl border border-slate-700 transition-colors">Ver Historial</button>
            </div>

            <!-- Staff Card 2 -->
            <div class="premium-card p-8 rounded-[2.5rem] shadow-2xl border border-slate-700 flex flex-col items-center text-center group hover:scale-[1.02] transition-all">
                <div class="relative mb-6">
                    <div class="w-24 h-24 bg-purple-600 rounded-full flex items-center justify-center text-3xl font-black text-white shadow-xl shadow-purple-500/20 group-hover:scale-110 transition-transform duration-500">
                        MG
                    </div>
                    <div class="absolute -bottom-1 -right-1 w-8 h-8 bg-green-500 border-4 border-slate-900 rounded-full shadow-lg"></div>
                </div>
                <h3 class="text-xl font-bold text-white mb-1">María García</h3>
                <p class="text-xs font-black text-purple-400 uppercase tracking-widest mb-4">Recepcionista</p>
                
                <div class="w-full grid grid-cols-2 gap-4 mt-6 pt-6 border-t border-slate-700/50">
                    <div>
                        <p class="text-[10px] text-slate-500 font-bold uppercase">Citas Hoy</p>
                        <p class="text-lg font-black text-white">12</p>
                    </div>
                    <div>
                        <p class="text-[10px] text-slate-500 font-bold uppercase">Satisfacción</p>
                        <p class="text-lg font-black text-blue-400">4.9/5</p>
                    </div>
                </div>
                
                <button class="mt-8 w-full py-3 bg-slate-800 hover:bg-slate-700 text-slate-300 font-bold rounded-xl border border-slate-700 transition-colors">Ver Historial</button>
            </div>

            <!-- Add New Card -->
            <button class="border-2 border-dashed border-slate-700 p-8 rounded-[2.5rem] flex flex-col items-center justify-center text-slate-500 hover:border-blue-500 hover:text-blue-500 transition-all group">
                <div class="w-16 h-16 bg-slate-800 rounded-full flex items-center justify-center mb-4 group-hover:bg-blue-600/10 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                </div>
                <span class="font-bold">Nuevo Miembro</span>
            </button>
        </div>
    </div>
</x-app-layout>
