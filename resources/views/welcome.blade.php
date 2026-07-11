<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>MecaniSmart AI - Gestión de Talleres Inteligente</title>
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap" rel="stylesheet">
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            body { font-family: 'Outfit', sans-serif; }
            .glass { background: rgba(255, 255, 255, 0.03); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.1); }
            .glow { box-shadow: 0 0 50px -10px rgba(59, 130, 246, 0.5); }
        </style>
    </head>
    <body class="antialiased bg-[#020617] text-white overflow-x-hidden">
        <div class="relative min-h-screen flex flex-col items-center justify-center">
            <!-- Background Decorations -->
            <div class="absolute top-0 left-0 w-full h-full overflow-hidden -z-10">
                <div class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] rounded-full bg-blue-600/20 blur-[120px]"></div>
                <div class="absolute bottom-[-10%] right-[-10%] w-[40%] h-[40%] rounded-full bg-indigo-600/20 blur-[120px]"></div>
            </div>

            <!-- Navbar -->
            <nav class="fixed top-0 w-full z-50 px-6 py-8">
                <div class="max-w-7xl mx-auto flex justify-between items-center">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center shadow-lg shadow-blue-500/20">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </div>
                        <span class="text-2xl font-black tracking-tighter uppercase">Dios es Amor <span class="text-blue-500">31</span></span>
                    </div>
                    <div class="flex items-center gap-6">
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ url('/dashboard') }}" class="text-sm font-bold hover:text-blue-400 transition-colors">Panel de Control</a>
                            @else
                                <a href="{{ route('login') }}" class="text-sm font-bold hover:text-blue-400 transition-colors">Iniciar Sesión</a>
                                <a href="{{ route('login') }}" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 rounded-full text-sm font-bold transition-all hover:scale-105 active:scale-95 shadow-lg shadow-blue-500/25">Iniciar Sesión</a>
                            @endauth
                        @endif
                    </div>
                </div>
            </nav>

            <!-- Hero Section -->
            <main class="relative z-10 px-6 text-center max-w-4xl mx-auto">
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full glass mb-8 animate-bounce">
                    <span class="flex h-2 w-2 rounded-full bg-blue-500"></span>
                    <span class="text-xs font-bold tracking-widest uppercase text-blue-200/60">Optimización con Inteligencia Artificial</span>
                </div>
                <h1 class="text-6xl md:text-8xl font-black tracking-tighter leading-none mb-8">
                    Gestiona tu taller <br>
                    <span class="bg-gradient-to-r from-blue-400 via-indigo-400 to-purple-400 bg-clip-text text-transparent italic">como nunca antes.</span>
                </h1>
                <p class="text-xl text-gray-400 max-w-2xl mx-auto mb-12 font-medium leading-relaxed">
                    La plataforma inteligente de Inversiones Dios es Amor 31 C. A. para automatizar tu flujo de trabajo y maximizar la rentabilidad.
                </p>
                <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                    <a href="{{ route('login') }}" class="w-full sm:w-auto px-10 py-5 bg-white text-black rounded-2xl font-black text-lg transition-all hover:scale-105 hover:bg-blue-50 active:scale-95 shadow-2xl">
                        Iniciar Sesión
                    </a>
                    <a href="#features" class="w-full sm:w-auto px-10 py-5 glass rounded-2xl font-bold text-lg transition-all hover:bg-white/5 active:scale-95">
                        Ver Módulos
                    </a>
                </div>

                <!-- Preview Card -->
                <div class="mt-24 relative group">
                    <div class="absolute -inset-1 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-[3rem] blur opacity-25 group-hover:opacity-40 transition duration-1000"></div>
                    <div class="relative glass rounded-[2.5rem] p-4 glow overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1619642751034-765dfdf7c58e?q=80&w=1974&auto=format&fit=crop" alt="Dashboard Preview" class="rounded-[2rem] w-full shadow-2xl grayscale hover:grayscale-0 transition-all duration-700">
                    </div>
                </div>
            </main>

            <!-- Features Quick Info -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-7xl mx-auto px-6 mt-32 pb-24">
                <div class="p-8 rounded-3xl glass hover:bg-white/[0.05] transition-colors">
                    <h3 class="text-xl font-bold mb-4 flex items-center gap-3 text-blue-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                        Analítica Avanzada
                    </h3>
                    <p class="text-gray-400 leading-relaxed">Métricas de rentabilidad y eficiencia en tiempo real para decisiones basadas en datos.</p>
                </div>
                <div class="p-8 rounded-3xl glass hover:bg-white/[0.05] transition-colors border-t-2 border-t-blue-500/30">
                    <h3 class="text-xl font-bold mb-4 flex items-center gap-3 text-indigo-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                        Expert Chat AI
                    </h3>
                    <p class="text-gray-400 leading-relaxed">Asistente mecánico disponible 24/7 para diagnósticos complejos y búsqueda de procedimientos.</p>
                </div>
                <div class="p-8 rounded-3xl glass hover:bg-white/[0.05] transition-colors">
                    <h3 class="text-xl font-bold mb-4 flex items-center gap-3 text-purple-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Automatización
                    </h3>
                    <p class="text-gray-400 leading-relaxed">Gestión de stock inteligente, citas automatizadas y flujos de trabajo optimizados.</p>
                </div>
            </div>
        </div>
    </body>
</html>
