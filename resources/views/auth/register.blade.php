<x-guest-layout>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gradient-to-br from-gray-900 via-blue-900 to-indigo-900">
        <div class="w-full sm:max-w-lg mt-6 px-8 py-10 bg-white/10 backdrop-blur-xl border border-white/20 shadow-2xl overflow-hidden sm:rounded-3xl">
            <!-- Logo/Icon -->
            <div class="flex flex-col items-center mb-8">
                <div class="w-16 h-16 bg-blue-600 rounded-2xl flex items-center justify-center shadow-lg shadow-blue-500/40 mb-4 transform rotate-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                    </svg>
                </div>
                <h2 class="text-2xl font-extrabold text-white tracking-tight">Nueva Cuenta</h2>
                <p class="text-blue-200/60 text-xs mt-1 uppercase tracking-widest font-semibold">Únete a MecaniSmart AI</p>
            </div>

            <form method="POST" action="{{ route('register') }}" class="space-y-4">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-blue-100 mb-1">Nombre</label>
                        <input id="name" type="text" name="name" :value="old('name')" required autofocus 
                            class="block w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder-blue-300/30 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all"
                            placeholder="Ej. Pedro Gómez">
                        <x-input-error :messages="$errors->get('name')" class="mt-1 text-xs text-red-400" />
                    </div>

                    <!-- Role -->
                    <div>
                        <label for="role" class="block text-sm font-medium text-blue-100 mb-1">Rol en el Taller</label>
                        <select id="role" name="role" required
                            class="block w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all appearance-none cursor-pointer">
                            <option value="receptionist" class="bg-gray-800 text-white">Recepcionista</option>
                            <option value="mechanic" class="bg-gray-800 text-white">Mecánico</option>
                            <option value="admin" class="bg-gray-800 text-white">Administrador</option>
                        </select>
                        <x-input-error :messages="$errors->get('role')" class="mt-1 text-xs text-red-400" />
                    </div>
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-blue-100 mb-1">Correo Electrónico</label>
                    <input id="email" type="email" name="email" :value="old('email')" required
                        class="block w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder-blue-300/30 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all"
                        placeholder="email@ejemplo.com">
                    <x-input-error :messages="$errors->get('email')" class="mt-1 text-xs text-red-400" />
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-blue-100 mb-1">Contraseña</label>
                        <input id="password" type="password" name="password" required autocomplete="new-password"
                            class="block w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder-blue-300/30 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all"
                            placeholder="••••••••">
                        <x-input-error :messages="$errors->get('password')" class="mt-1 text-xs text-red-400" />
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-blue-100 mb-1">Confirmar</label>
                        <input id="password_confirmation" type="password" name="password_confirmation" required
                            class="block w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder-blue-300/30 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all"
                            placeholder="••••••••">
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="pt-4">
                    <button type="submit" class="w-full py-4 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-2xl shadow-lg shadow-blue-500/30 transition-all duration-200 transform hover:scale-[1.01]">
                        Crear Mi Cuenta
                    </button>
                </div>
            </form>

            <div class="mt-6 pt-6 border-t border-white/10 text-center">
                <p class="text-sm text-blue-100/50">
                    ¿Ya tienes una cuenta? 
                    <a href="{{ route('login') }}" class="text-blue-400 hover:text-blue-300 font-bold ml-1">Inicia Sesión</a>
                </p>
            </div>
        </div>
    </div>
</x-guest-layout>
