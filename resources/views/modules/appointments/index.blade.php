<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="font-bold text-2xl text-white leading-tight">
                    {{ __('Agenda de Citas') }}
                </h2>
                <p class="text-slate-400 text-sm mt-1">Programación de servicios y recepción de vehículos.</p>
            </div>
            <button class="px-6 py-3 bg-purple-600 hover:bg-purple-700 text-white font-bold rounded-xl transition-all shadow-lg shadow-purple-500/20 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                </svg>
                Agendar Cita
            </button>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8 items-start">
            <!-- Calendar Sidebar Placeholder -->
            <div class="lg:col-span-1 space-y-6">
                <div class="premium-card p-6 rounded-2xl border border-slate-700 bg-slate-800/50">
                    <h4 class="text-sm font-bold text-white mb-6 uppercase tracking-widest text-center">Abril 2024</h4>
                    <div class="grid grid-cols-7 gap-1">
                        @foreach(['L','M','X','J','V','S','D'] as $day)
                            <div class="text-[10px] font-black text-slate-500 text-center pb-2">{{ $day }}</div>
                        @endforeach
                        @for($i=1; $i<=30; $i++)
                            <div class="aspect-square flex items-center justify-center">
                                <button class="w-full h-full flex items-center justify-center rounded-lg text-xs font-bold transition-all {{ $i == 23 ? 'bg-blue-600 text-white shadow-lg shadow-blue-500/30' : 'text-slate-400 hover:bg-slate-700 hover:text-white' }}">
                                    {{ $i }}
                                </button>
                            </div>
                        @endfor
                    </div>
                </div>
                
                <div class="premium-card p-6 rounded-2xl border border-slate-700 bg-slate-800/30">
                    <h4 class="text-xs font-bold text-slate-500 mb-4 uppercase tracking-widest">Resumen de hoy</h4>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-slate-300">Confirmadas</span>
                            <span class="text-sm font-bold text-white bg-blue-500/20 px-2 py-1 rounded-lg">8</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-slate-300">Pendientes</span>
                            <span class="text-sm font-bold text-orange-400 bg-orange-500/20 px-2 py-1 rounded-lg">3</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Appointments Timeline -->
            <div class="lg:col-span-3 premium-card rounded-[2.5rem] p-8 shadow-2xl border border-slate-700 bg-slate-800/20">
                <div class="flex justify-between items-center mb-8">
                    <h3 class="font-black text-xl text-white">Próximas Citas (Hoy)</h3>
                    <span class="text-xs font-bold text-slate-500 uppercase tracking-widest">23 de Abril, 2024</span>
                </div>
                
                <div class="space-y-6 relative before:absolute before:left-[17px] before:top-2 before:bottom-2 before:w-px before:bg-slate-700">
                    <!-- Appointment 1 -->
                    <div class="relative pl-12 group">
                        <div class="absolute left-0 top-1 w-9 h-9 bg-slate-900 border-2 border-blue-600 rounded-full z-10 flex items-center justify-center shadow-[0_0_15px_rgba(37,99,235,0.3)]">
                            <div class="w-2 h-2 bg-blue-600 rounded-full animate-pulse"></div>
                        </div>
                        <div class="premium-card p-5 rounded-2xl border border-slate-700 bg-slate-800/40 group-hover:border-blue-500/50 transition-all group-hover:translate-x-1">
                            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                                <div>
                                    <p class="text-[10px] font-black text-blue-500 uppercase tracking-widest mb-1">08:30 AM</p>
                                    <h4 class="text-lg font-bold text-white">Cambio de Aceite y Filtros</h4>
                                    <p class="text-sm text-slate-400">Cliente: <span class="text-slate-200">Ricardo Sosa</span> • <span class="text-blue-400 font-bold italic">Toyota Hilux</span></p>
                                </div>
                                <div class="flex items-center gap-3">
                                    <span class="px-3 py-1 bg-blue-500/10 text-blue-400 text-[10px] font-black rounded-full border border-blue-500/20 uppercase tracking-widest">Confirmada</span>
                                    <button class="p-2 bg-slate-800 rounded-lg text-slate-400 hover:text-white transition-colors border border-slate-700">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Appointment 2 -->
                    <div class="relative pl-12 group">
                        <div class="absolute left-0 top-1 w-9 h-9 bg-slate-900 border-2 border-slate-700 rounded-full z-10 flex items-center justify-center">
                            <div class="w-2 h-2 bg-slate-700 rounded-full"></div>
                        </div>
                        <div class="premium-card p-5 rounded-2xl border border-slate-700 bg-slate-800/40 group-hover:border-blue-500/50 transition-all opacity-80 group-hover:translate-x-1">
                            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                                <div>
                                    <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-1">10:00 AM</p>
                                    <h4 class="text-lg font-bold text-white">Revisión de Frenos</h4>
                                    <p class="text-sm text-slate-400">Cliente: <span class="text-slate-200">Elena Paz</span> • <span class="text-blue-400 font-bold italic">Mazda 3</span></p>
                                </div>
                                <div class="flex items-center gap-3">
                                    <span class="px-3 py-1 bg-orange-500/10 text-orange-400 text-[10px] font-black rounded-full border border-orange-500/20 uppercase tracking-widest">Pendiente</span>
                                    <button class="p-2 bg-slate-800 rounded-lg text-slate-400 hover:text-white transition-colors border border-slate-700">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
