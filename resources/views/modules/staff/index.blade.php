<x-app-layout>
    <x-slot name="header">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h2 class="font-bold text-2xl text-white leading-tight">
                        {{ __('Personal y Equipo') }}
                    </h2>
                    <p class="text-slate-400 text-sm mt-1">Gestión de roles, accesos y métricas del equipo.</p>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('reports.staff') }}" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl transition-all shadow-lg shadow-blue-500/20 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                        </svg>
                        Generar Reporte
                    </a>
                    <a href="{{ route('staff.create') }}" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl transition-all shadow-lg shadow-blue-500/20 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                        </svg>
                        Añadir Colaborador
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

        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-500/10 border border-red-500/20 rounded-xl text-red-400 font-bold text-sm">
                {{ $errors->first() }}
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($staff as $member)
                <div class="premium-card p-8 rounded-[2.5rem] shadow-2xl border border-slate-700 flex flex-col items-center text-center group hover:scale-[1.02] transition-all">
                    <div class="relative mb-6">
                        @php
                            $roleColors = [
                                'admin' => 'bg-red-600 shadow-red-500/20',
                                'mecanico' => 'bg-blue-600 shadow-blue-500/20',
                                'recepcionista' => 'bg-purple-600 shadow-purple-500/20',
                            ];
                            $initials = collect(explode(' ', $member->name))->map(fn($n) => substr($n, 0, 1))->take(2)->join('');
                        @endphp
                        <div class="w-24 h-24 {{ $roleColors[$member->role] ?? 'bg-slate-600' }} rounded-full flex items-center justify-center text-3xl font-black text-white shadow-xl group-hover:scale-110 transition-transform duration-500">
                            {{ strtoupper($initials) }}
                        </div>
                        <div class="absolute -bottom-1 -right-1 w-8 h-8 bg-green-500 border-4 border-slate-900 rounded-full shadow-lg"></div>
                    </div>
                    
                    <h3 class="text-xl font-bold text-white mb-1">{{ $member->name }}</h3>
                    <p class="text-xs font-black text-slate-400 uppercase tracking-widest mb-1">{{ $member->email }}</p>
                    <p class="text-[10px] font-black {{ $member->role == 'admin' ? 'text-red-400' : ($member->role == 'mecanico' ? 'text-blue-400' : 'text-purple-400') }} uppercase tracking-widest mb-4">
                        {{ $member->role }}
                    </p>
                    
                    <div class="w-full flex gap-3 mt-6 pt-6 border-t border-slate-700/50">
                        <a href="{{ route('staff.edit', $member) }}" class="flex-1 py-3 bg-slate-800 hover:bg-slate-700 text-slate-300 text-xs font-bold rounded-xl border border-slate-700 transition-colors">
                            Editar Perfil
                        </a>
                        @if($member->id !== auth()->id())
                            <form action="{{ route('staff.destroy', $member) }}" method="POST" onsubmit="return confirm('¿Eliminar a este miembro del equipo?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="p-3 bg-red-500/10 hover:bg-red-500/20 text-red-500 rounded-xl border border-red-500/20 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @endforeach

            <!-- Add New Card -->
            <a href="{{ route('staff.create') }}" class="border-2 border-dashed border-slate-700 p-8 rounded-[2.5rem] flex flex-col items-center justify-center text-slate-500 hover:border-blue-500 hover:text-blue-500 transition-all group">
                <div class="w-16 h-16 bg-slate-800 rounded-full flex items-center justify-center mb-4 group-hover:bg-blue-600/10 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                </div>
                <span class="font-bold">Nuevo Miembro</span>
            </a>
        </div>
    </div>
</x-app-layout>
