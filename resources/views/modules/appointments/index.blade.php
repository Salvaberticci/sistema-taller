<x-app-layout>
    <x-slot name="header">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h2 class="font-bold text-2xl text-white leading-tight">
                        {{ __('Agenda de Citas') }}
                    </h2>
                    <p class="text-slate-400 text-sm mt-1">Programación de servicios y recepción de vehículos.</p>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('reports.appointments') }}" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl transition-all shadow-lg shadow-blue-500/20 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                        </svg>
                        Generar Reporte
                    </a>
                    <a href="{{ route('appointments.create') }}" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl transition-all shadow-lg shadow-blue-500/20 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                        </svg>
                        Agendar Cita
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

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8 items-start">
            <!-- Calendar Sidebar -->
            <div class="lg:col-span-1 space-y-6">
                <div class="premium-card p-6 rounded-2xl border border-slate-700 bg-slate-800/50">
                    <h4 class="text-sm font-bold text-white mb-6 uppercase tracking-widest text-center">{{ now()->translatedFormat('F Y') }}</h4>
                    <div class="grid grid-cols-7 gap-1">
                        @foreach(['L','M','X','J','V','S','D'] as $day)
                            <div class="text-[10px] font-black text-slate-500 text-center pb-2">{{ $day }}</div>
                        @endforeach
                        @php
                            $startOfMonth = now()->startOfMonth();
                            $daysInMonth = now()->daysInMonth;
                            $dayOfWeek = $startOfMonth->dayOfWeekIso;
                        @endphp
                        @for($i=1; $i<$dayOfWeek; $i++)
                            <div></div>
                        @endfor
                        @for($i=1; $i<=$daysInMonth; $i++)
                            <div class="aspect-square flex items-center justify-center">
                                <button class="w-full h-full flex items-center justify-center rounded-lg text-xs font-bold transition-all {{ $i == now()->day ? 'bg-purple-600 text-white shadow-lg shadow-purple-500/30' : 'text-slate-400 hover:bg-slate-700 hover:text-white' }}">
                                    {{ $i }}
                                </button>
                            </div>
                        @endfor
                    </div>
                </div>
                
                <div class="premium-card p-6 rounded-2xl border border-slate-700 bg-slate-800/30">
                    <h4 class="text-xs font-bold text-slate-500 mb-4 uppercase tracking-widest">Resumen</h4>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-slate-300">Pendientes</span>
                            <span class="text-sm font-bold text-white bg-purple-500/20 px-2 py-1 rounded-lg">{{ $appointments->where('status', 'scheduled')->count() }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-slate-300">Confirmadas</span>
                            <span class="text-sm font-bold text-green-400 bg-green-500/20 px-2 py-1 rounded-lg">{{ $appointments->where('status', 'confirmed')->count() }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Appointments Timeline -->
            <div class="lg:col-span-3 premium-card rounded-[2.5rem] p-8 shadow-2xl border border-slate-700 bg-slate-800/20">
                <div class="flex justify-between items-center mb-8">
                    <h3 class="font-black text-xl text-white">Próximas Citas</h3>
                    <span class="text-xs font-bold text-slate-500 uppercase tracking-widest">{{ now()->translatedFormat('d \d\e F, Y') }}</span>
                </div>
                
                <div class="space-y-6 relative before:absolute before:left-[17px] before:top-2 before:bottom-2 before:w-px before:bg-slate-700">
                    @forelse($appointments as $appointment)
                        <div class="relative pl-12 group">
                            @php
                                $statusColors = [
                                    'scheduled' => ['bg' => 'bg-slate-700', 'text' => 'text-slate-400', 'border' => 'border-slate-700'],
                                    'confirmed' => ['bg' => 'bg-green-600', 'text' => 'text-green-400', 'border' => 'border-green-600'],
                                    'completed' => ['bg' => 'bg-blue-600', 'text' => 'text-blue-400', 'border' => 'border-blue-600'],
                                    'cancelled' => ['bg' => 'bg-red-600', 'text' => 'text-red-400', 'border' => 'border-red-600'],
                                ];
                                $color = $statusColors[$appointment->status];
                            @endphp
                            <div class="absolute left-0 top-1 w-9 h-9 bg-slate-900 border-2 {{ $color['border'] }} rounded-full z-10 flex items-center justify-center shadow-lg">
                                <div class="w-2 h-2 {{ $color['bg'] }} rounded-full {{ $appointment->status == 'confirmed' ? 'animate-pulse' : '' }}"></div>
                            </div>
                            <div class="premium-card p-5 rounded-2xl border border-slate-700 bg-slate-800/40 group-hover:border-purple-500/50 transition-all group-hover:translate-x-1">
                                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                                    <div>
                                        <p class="text-[10px] font-black text-purple-500 uppercase tracking-widest mb-1">{{ \Carbon\Carbon::parse($appointment->scheduled_at)->format('H:i A') }} • {{ \Carbon\Carbon::parse($appointment->scheduled_at)->format('d/m') }}</p>
                                        <h4 class="text-lg font-bold text-white">{{ $appointment->description ?? 'Servicio General' }}</h4>
                                        <p class="text-sm text-slate-400">Cliente: <span class="text-slate-200">{{ $appointment->customer->name }}</span> • <span class="text-purple-400 font-bold italic">{{ $appointment->vehicle->make ?? 'N/A' }} {{ $appointment->vehicle->model ?? '' }}</span></p>
                                    </div>
                                    <div class="flex items-center gap-3">
                                        <form action="{{ route('appointments.update', $appointment) }}" method="POST">
                                            @csrf @method('PATCH')
                                            <select name="status" onchange="this.form.submit()" class="bg-slate-900 border border-slate-700 text-[10px] font-black rounded-full px-3 py-1 uppercase tracking-widest text-slate-300 focus:ring-0 transition-all cursor-pointer">
                                                <option value="scheduled" {{ $appointment->status == 'scheduled' ? 'selected' : '' }}>Pendiente</option>
                                                <option value="confirmed" {{ $appointment->status == 'confirmed' ? 'selected' : '' }}>Confirmada</option>
                                                <option value="completed" {{ $appointment->status == 'completed' ? 'selected' : '' }}>Completada</option>
                                                <option value="cancelled" {{ $appointment->status == 'cancelled' ? 'selected' : '' }}>Cancelada</option>
                                            </select>
                                        </form>
                                        <form action="{{ route('appointments.destroy', $appointment) }}" method="POST" onsubmit="return confirm('¿Eliminar cita?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="p-2 bg-slate-800 rounded-lg text-slate-400 hover:text-red-500 transition-colors border border-slate-700">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-12">
                            <p class="text-slate-500 font-bold">No hay citas programadas.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
