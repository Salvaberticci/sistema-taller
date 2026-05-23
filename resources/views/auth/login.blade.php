<x-guest-layout>
    <div class="min-h-screen flex flex-col md:flex-row bg-[#020617] text-white">
        <!-- Left Side: Image (hidden on small screens, shown on medium/large screens) -->
        <div class="hidden md:block md:w-1/2 lg:w-3/5 relative overflow-hidden">
            <img src="{{ asset('images/workshop_background.png') }}" alt="Taller Automotriz" class="absolute inset-0 w-full h-full object-cover filter brightness-[0.6] contrast-[1.1]">
            <!-- Overlay to blend with system style -->
            <div class="absolute inset-0 bg-gradient-to-r from-blue-950/20 to-[#020617] mix-blend-multiply"></div>
        </div>

        <!-- Right Side: Login Sidebar -->
        <div class="w-full md:w-1/2 lg:w-2/5 flex flex-col justify-between p-8 sm:p-12 lg:p-16 bg-[#090d1f] border-l border-slate-800/80 shadow-2xl relative z-10">
            <!-- Top space for vertical balance -->
            <div></div>

            <!-- Content Area -->
            <div class="w-full max-w-md mx-auto my-auto py-8">
                <!-- App Logo & Branding (matching layout from screenshot but styled with system colors) -->
                <div class="flex flex-col items-center mb-8">
                    <!-- Elegant Logo Icon -->
                    <div class="w-16 h-16 bg-blue-600 rounded-2xl flex items-center justify-center shadow-lg shadow-blue-500/30 mb-4 transform -rotate-3 transition-transform hover:rotate-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-9 w-9 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <!-- Brand Name -->
                    <h2 class="text-3xl font-black italic tracking-widest text-white uppercase text-center">
                        DIOS ES <span class="text-blue-500">AMOR</span>
                    </h2>
                    <p class="text-slate-400 text-xs mt-2 font-medium tracking-wide">Bienvenido a la versión web de nuestro sistema</p>
                </div>

                <!-- Session Status -->
                <x-auth-session-status class="mb-6" :status="session('status')" />

                <!-- Form -->
                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf

                    <!-- Email Input -->
                    <div>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                    <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                                </svg>
                            </span>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                                class="block w-full pl-12 pr-4 py-3.5 bg-slate-950/40 border border-slate-700/80 rounded-xl text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                                placeholder="Correo Electrónico">
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-2 text-xs text-red-400" />
                    </div>

                    <!-- Password Input -->
                    <div>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                                </svg>
                            </span>
                            <input id="password" type="password" name="password" required autocomplete="current-password"
                                class="block w-full pl-12 pr-4 py-3.5 bg-slate-950/40 border border-slate-700/80 rounded-xl text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                                placeholder="Contraseña">
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2 text-xs text-red-400" />
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center justify-between text-sm">
                        <label class="inline-flex items-center text-slate-400 cursor-pointer">
                            <input id="remember_me" type="checkbox" name="remember" class="w-4 h-4 rounded border-slate-700 bg-slate-950/40 text-blue-600 focus:ring-blue-500 focus:ring-offset-0">
                            <span class="ml-2 text-xs">Recordarme en este equipo</span>
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="w-full py-3.5 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl tracking-wider shadow-lg shadow-blue-500/25 transition-all duration-200 active:scale-[0.98] text-sm uppercase">
                        Iniciar Sesión
                    </button>
                </form>

                <!-- Navigation Links -->
                <div class="mt-8 space-y-4 text-center">
                    @if (Route::has('password.request'))
                        <div>
                            <a href="{{ route('password.request') }}" class="text-xs text-slate-400 hover:text-blue-400 transition-colors">
                                ¿Olvidaste tu contraseña o no la has creado?
                            </a>
                        </div>
                    @endif

                    <div class="pt-2">
                        <p class="text-xs text-slate-500 mb-3">¿No tienes una cuenta aún?</p>
                        <a href="{{ route('register') }}" class="inline-block w-full py-2.5 border border-slate-700 hover:border-blue-500 hover:text-blue-400 text-slate-300 font-semibold rounded-xl text-xs uppercase tracking-wide transition-all duration-200">
                            Registrarme
                        </a>
                    </div>
                </div>
            </div>

            <!-- Footer: Copyright & Version -->
            <div class="w-full text-center text-[10px] text-slate-600 space-y-1">
                <p>Copyright © 2026 Todos los derechos reservados</p>
                <p class="font-medium opacity-80">v-3.0.165</p>
            </div>
        </div>
    </div>
</x-guest-layout>

