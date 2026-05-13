<x-guest-layout>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gradient-to-br from-gray-900 via-blue-900 to-indigo-900">
        <div class="w-full sm:max-w-md mt-6 px-8 py-10 bg-white/10 backdrop-blur-xl border border-white/20 shadow-2xl overflow-hidden sm:rounded-3xl">
            <!-- Logo/Icon -->
            <div class="flex flex-col items-center mb-8">
                <div class="w-20 h-20 bg-blue-600 rounded-3xl flex items-center justify-center shadow-lg shadow-blue-500/40 mb-4 transform -rotate-6">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
                <h2 class="text-xl font-extrabold text-white tracking-tight text-center">Inversiones Dios es Amor 31 C. A.</h2>
                <p class="text-blue-200/60 text-xs mt-1 uppercase tracking-widest font-semibold text-center">Taller Automotriz de Excelencia</p>
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                <!-- Email Address -->
                <div>
                    <label for="email" class="block text-sm font-medium text-blue-100 mb-2">Correo Electrónico</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-blue-300/50">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                            </svg>
                        </span>
                        <input id="email" type="email" name="email" :value="old('email')" required autofocus 
                            class="block w-full pl-12 pr-4 py-4 bg-white/5 border border-white/10 rounded-2xl text-white placeholder-blue-300/30 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                            placeholder="admin@mecanismart.com">
                    </div>
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-400" />
                </div>

                <!-- Password -->
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <label for="password" class="block text-sm font-medium text-blue-100">Contraseña</label>
                        @if (Route::has('password.request'))
                            <a class="text-xs text-blue-400 hover:text-blue-300 transition-colors" href="{{ route('password.request') }}">
                                ¿Olvidaste tu contraseña?
                            </a>
                        @endif
                    </div>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-blue-300/50">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                            </svg>
                        </span>
                        <input id="password" type="password" name="password" required autocomplete="current-password"
                            class="block w-full pl-12 pr-4 py-4 bg-white/5 border border-white/10 rounded-2xl text-white placeholder-blue-300/30 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                            placeholder="••••••••">
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-400" />
                </div>

                <!-- Remember Me -->
                <div class="flex items-center">
                    <input id="remember_me" type="checkbox" name="remember" class="w-4 h-4 rounded border-white/20 bg-white/5 text-blue-600 focus:ring-blue-500">
                    <label for="remember_me" class="ml-3 text-sm text-blue-100/70">Recordarme en este equipo</label>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full py-4 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-2xl shadow-lg shadow-blue-500/30 transition-all duration-200 transform hover:scale-[1.02] active:scale-[0.98]">
                    Entrar al Sistema
                </button>
            </form>

            <div class="mt-8 pt-6 border-t border-white/10 text-center">
                <p class="text-sm text-blue-100/50">
                    ¿No tienes una cuenta? 
                    <a href="{{ route('register') }}" class="text-blue-400 hover:text-blue-300 font-bold ml-1">Regístrate</a>
                </p>
            </div>
        </div>
    </div>
</x-guest-layout>
