<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('staff.index') }}" class="p-2 bg-slate-800 hover:bg-slate-700 rounded-xl border border-slate-700 text-slate-400 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                </svg>
            </a>
            <h2 class="font-bold text-2xl text-white leading-tight">
                {{ __('Editar Perfil de') }} {{ $staff->name }}
            </h2>
        </div>
    </x-slot>

    <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
        <div class="premium-card rounded-[2.5rem] p-10 shadow-2xl border border-slate-700 bg-slate-800/50">
            <form action="{{ route('staff.update', $staff) }}" method="POST" class="space-y-6">
                @csrf @method('PATCH')
                
                <div>
                    <x-input-label for="name" :value="__('Nombre Completo')" />
                    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $staff->name)" required autofocus />
                    <x-input-error class="mt-2" :messages="$errors->get('name')" />
                </div>

                <div>
                    <x-input-label for="email" :value="__('Correo Electrónico')" />
                    <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $staff->email)" required />
                    <x-input-error class="mt-2" :messages="$errors->get('email')" />
                </div>

                <div>
                    <x-input-label for="role" :value="__('Rol en el Sistema')" />
                    <select id="role" name="role" class="mt-1 block w-full bg-slate-900 border border-slate-700 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all p-3" required>
                        <option value="admin" {{ $staff->role == 'admin' ? 'selected' : '' }}>Administrador (Acceso total)</option>
                        <option value="mecanico" {{ $staff->role == 'mecanico' ? 'selected' : '' }}>Mecánico (Gestión operativa)</option>
                        <option value="recepcionista" {{ $staff->role == 'recepcionista' ? 'selected' : '' }}>Recepcionista (Clientes y Citas)</option>
                    </select>
                    <x-input-error class="mt-2" :messages="$errors->get('role')" />
                </div>

                <div class="bg-blue-600/5 p-6 rounded-2xl border border-blue-500/20">
                    <p class="text-xs font-bold text-blue-400 uppercase tracking-widest mb-4 italic">Dejar en blanco para mantener la contraseña actual</p>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <x-input-label for="password" :value="__('Nueva Contraseña')" />
                            <x-text-input id="password" name="password" type="password" class="mt-1 block w-full" />
                            <x-input-error class="mt-2" :messages="$errors->get('password')" />
                        </div>
                        <div>
                            <x-input-label for="password_confirmation" :value="__('Confirmar Contraseña')" />
                            <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" />
                            <x-input-error class="mt-2" :messages="$errors->get('password_confirmation')" />
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-end mt-10 gap-4 border-t border-slate-700 pt-8">
                    <a href="{{ route('staff.index') }}" class="text-sm font-bold text-slate-400 hover:text-white transition-colors">Cancelar</a>
                    <button type="submit" class="px-10 py-4 bg-blue-600 hover:bg-blue-700 text-white font-black rounded-2xl shadow-lg shadow-blue-500/20 transition-all hover:scale-105 active:scale-95">
                        Actualizar Miembro
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
