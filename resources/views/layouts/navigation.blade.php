@php
    $allNavItems = [
        [
            'route' => 'dashboard',
            'activePattern' => 'dashboard',
            'label' => 'Dashboard',
            'icon' => 'home',
            'roles' => ['admin', 'receptionist', 'mechanic'],
        ],
        [
            'route' => 'customers.index',
            'activePattern' => 'customers.*',
            'label' => 'Clientes',
            'icon' => 'users',
            'roles' => ['admin', 'receptionist'],
        ],
        [
            'route' => 'vehicles.index',
            'activePattern' => 'vehicles.*',
            'label' => 'Vehículos',
            'icon' => 'truck',
            'roles' => ['admin', 'receptionist'],
        ],
        [
            'route' => 'orders.index',
            'activePattern' => 'orders.*',
            'label' => 'Órdenes',
            'icon' => 'clipboard',
            'roles' => ['admin', 'receptionist', 'mechanic'],
        ],
        [
            'route' => 'inventory.index',
            'activePattern' => 'inventory.*',
            'label' => 'Inventario',
            'icon' => 'box',
            'roles' => ['admin', 'receptionist', 'mechanic'],
        ],
        [
            'route' => 'invoices.index',
            'activePattern' => 'invoices.*',
            'label' => 'Facturación',
            'icon' => 'receipt',
            'roles' => ['admin'],
        ],
        [
            'route' => 'appointments.index',
            'activePattern' => 'appointments.*',
            'label' => 'Citas',
            'icon' => 'calendar',
            'roles' => ['admin', 'receptionist'],
        ],
        [
            'route' => 'staff.index',
            'activePattern' => 'staff.*',
            'label' => 'Personal',
            'icon' => 'user-group',
            'roles' => ['admin', 'receptionist'],
        ],
        [
            'route' => 'ai.chat',
            'activePattern' => 'ai.*',
            'label' => 'Asistente de IA',
            'icon' => 'sparkles',
            'isAi' => true,
            'roles' => ['admin', 'receptionist', 'mechanic'],
        ],
    ];

    $userRole = match(Auth::user()->role) { 'mecanico' => 'mechanic', 'recepcionista' => 'receptionist', default => Auth::user()->role ?? 'receptionist' };
    $navItems = array_filter($allNavItems, function ($item) use ($userRole) {
        return in_array($userRole, $item['roles']);
    });
@endphp

<div x-data="{ open: false }" class="sticky md:static top-0 z-40 flex-shrink-0 w-full md:w-64 xl:w-72">
    <!-- Desktop Sidebar -->
    <aside class="hidden md:flex md:w-64 xl:w-72 flex-col bg-[#090d16] border-r border-slate-800 h-screen sticky top-0 z-40">
        <!-- Logo Section -->
        <div class="px-6 py-6 border-b border-slate-800/80 flex items-center justify-between">
            <a href="{{ route('dashboard') }}" class="block">
                <x-application-logo class="h-9 w-auto" />
            </a>
        </div>

        <!-- Navigation Links -->
        <nav class="flex-1 py-6 px-4 space-y-1.5 overflow-y-auto">
            @foreach ($navItems as $item)
                @php
                    $isActive = request()->routeIs($item['activePattern']);
                    $baseClass = "flex items-center gap-3 px-4 py-3.5 rounded-2xl text-xs font-bold uppercase transition-all duration-200 group border";
                    
                    if (isset($item['isAi']) && $item['isAi']) {
                        $itemClass = $isActive 
                            ? "{$baseClass} bg-blue-600/20 text-blue-400 border-blue-500/30 shadow-lg shadow-blue-500/10"
                            : "{$baseClass} text-blue-400 hover:bg-blue-600/10 hover:text-blue-300 border-transparent";
                    } else {
                        $itemClass = $isActive 
                            ? "{$baseClass} bg-blue-600 text-white border-blue-500/30 shadow-lg shadow-blue-500/20"
                            : "{$baseClass} text-slate-400 hover:bg-slate-800/60 hover:text-white border-transparent";
                    }
                @endphp

                <a href="{{ route($item['route']) }}" class="{{ $itemClass }}">
                    <span class="{{ $isActive ? 'text-white' : (isset($item['isAi']) ? 'text-blue-400' : 'text-slate-400 group-hover:text-white') }} transition-colors duration-200">
                        @if ($item['icon'] === 'home')
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                        @elseif ($item['icon'] === 'users')
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                        @elseif ($item['icon'] === 'truck')
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"></path>
                            </svg>
                        @elseif ($item['icon'] === 'clipboard')
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                            </svg>
                        @elseif ($item['icon'] === 'box')
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                        @elseif ($item['icon'] === 'receipt')
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                            </svg>
                        @elseif ($item['icon'] === 'calendar')
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        @elseif ($item['icon'] === 'user-group')
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        @elseif ($item['icon'] === 'sparkles')
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                            </svg>
                        @endif
                    </span>
                    <span>{{ mb_strtoupper(__($item['label']), 'UTF-8') }}</span>
                </a>
            @endforeach
        </nav>

        <!-- User Profile Footer -->
        <div class="mt-auto border-t border-slate-800 bg-[#070a11] p-4 flex flex-col gap-2">
            <div class="flex items-center gap-3 px-2 py-1.5 rounded-xl bg-slate-900/50">
                <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center text-sm font-black text-white shadow-lg shadow-blue-500/20 flex-shrink-0">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                <div class="min-w-0 flex-1">
                    <p class="text-xs font-bold text-white truncate">{{ Auth::user()->name }}</p>
                    <p class="text-[10px] text-blue-500 font-bold uppercase tracking-wider">{{ ['admin' => 'Admin', 'mechanic' => 'Mecánico', 'receptionist' => 'Recepcionista', 'mecanico' => 'Mecánico', 'recepcionista' => 'Recepcionista'][Auth::user()->role] ?? Auth::user()->role }}</p>
                </div>
            </div>
            
            <div class="flex items-center gap-1.5 justify-between px-1 pt-1">
                <a href="{{ route('profile.edit') }}" class="flex items-center justify-center p-2 rounded-xl bg-slate-800/40 border border-slate-700/50 hover:bg-slate-800 text-slate-400 hover:text-white transition-all text-xs font-bold w-1/2 text-center">
                    Configuración
                </a>
                <form method="POST" action="{{ route('logout') }}" class="w-1/2">
                    @csrf
                    <button type="submit" class="flex items-center justify-center p-2 rounded-xl bg-red-950/20 border border-red-900/30 hover:bg-red-950/40 text-red-400 hover:text-red-300 transition-all text-xs font-bold w-full text-center">
                        Salir
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <!-- Mobile Top Header -->
    <header class="md:hidden flex items-center justify-between h-16 px-4 bg-[#090d16] border-b border-slate-800 sticky top-0 z-40 w-full">
        <a href="{{ route('dashboard') }}" class="block">
            <x-application-logo class="h-8 w-auto" />
        </a>
        <button @click="open = true" class="p-2 rounded-xl text-slate-400 hover:text-white hover:bg-slate-800 border border-slate-800 bg-slate-900/50 transition duration-150">
            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
    </header>

    <!-- Mobile Sidebar Drawer -->
    <div x-show="open" class="md:hidden fixed inset-0 z-50 flex" x-cloak>
        <!-- Overlay -->
        <div x-show="open" x-transition:enter="transition-opacity ease-linear duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-linear duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-black/60 backdrop-blur-sm" @click="open = false"></div>

        <!-- Sidebar Panel -->
        <div x-show="open" x-transition:enter="transition ease-in-out duration-300 transform" x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0" x-transition:leave="transition ease-in-out duration-300 transform" x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full" class="relative flex-1 flex flex-col max-w-xs w-full bg-[#090d16] border-r border-slate-800 pt-5 pb-4">
            <!-- Close Button -->
            <div class="absolute top-2 right-2">
                <button @click="open = false" class="p-2 rounded-xl text-slate-400 hover:text-white hover:bg-slate-800 border border-slate-800 bg-slate-900/50 transition">
                    <svg class="h-5 w-5" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Logo -->
            <div class="flex-shrink-0 px-6 pb-5 border-b border-slate-800/80">
                <x-application-logo class="h-9 w-auto" />
            </div>

            <!-- Scrollable Navigation -->
            <nav class="flex-1 mt-5 px-4 space-y-1.5 overflow-y-auto">
                @foreach ($navItems as $item)
                    @php
                        $isActive = request()->routeIs($item['activePattern']);
                        $baseClass = "flex items-center gap-3 px-4 py-3 rounded-2xl text-xs font-bold uppercase transition-all duration-200 group border";
                        
                        if (isset($item['isAi']) && $item['isAi']) {
                            $itemClass = $isActive 
                                ? "{$baseClass} bg-blue-600/20 text-blue-400 border-blue-500/30 shadow-lg shadow-blue-500/10"
                                : "{$baseClass} text-blue-400 hover:bg-blue-600/10 hover:text-blue-300 border-transparent";
                        } else {
                            $itemClass = $isActive 
                                ? "{$baseClass} bg-blue-600 text-white border-blue-500/30 shadow-lg shadow-blue-500/20"
                                : "{$baseClass} text-slate-400 hover:bg-slate-800/60 hover:text-white border-transparent";
                        }
                    @endphp

                    <a href="{{ route($item['route']) }}" class="{{ $itemClass }}" @click="open = false">
                        <span class="{{ $isActive ? 'text-white' : (isset($item['isAi']) ? 'text-blue-400' : 'text-slate-400 group-hover:text-white') }} transition-colors duration-200">
                            @if ($item['icon'] === 'home')
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                </svg>
                            @elseif ($item['icon'] === 'users')
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                </svg>
                            @elseif ($item['icon'] === 'truck')
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"></path>
                                </svg>
                            @elseif ($item['icon'] === 'clipboard')
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                                </svg>
                            @elseif ($item['icon'] === 'box')
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                            @elseif ($item['icon'] === 'receipt')
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                </svg>
                            @elseif ($item['icon'] === 'calendar')
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            @elseif ($item['icon'] === 'user-group')
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                            @elseif ($item['icon'] === 'sparkles')
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                                </svg>
                            @endif
                        </span>
                        <span>{{ mb_strtoupper(__($item['label']), 'UTF-8') }}</span>
                    </a>
                @endforeach
            </nav>

            <!-- Mobile Footer Profile -->
            <div class="mt-auto border-t border-slate-800 bg-[#070a11] p-4 flex flex-col gap-2">
                <div class="flex items-center gap-3 px-2 py-1.5 rounded-xl bg-slate-900/50">
                    <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center text-sm font-black text-white shadow-lg shadow-blue-500/20 flex-shrink-0">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="text-xs font-bold text-white truncate">{{ Auth::user()->name }}</p>
                    <p class="text-[10px] text-blue-500 font-bold uppercase tracking-wider">{{ ['admin' => 'Admin', 'mechanic' => 'Mecánico', 'receptionist' => 'Recepcionista', 'mecanico' => 'Mecánico', 'recepcionista' => 'Recepcionista'][Auth::user()->role] ?? Auth::user()->role }}</p>
                    </div>
                </div>
                
                <div class="flex items-center gap-1.5 justify-between px-1 pt-1">
                    <a href="{{ route('profile.edit') }}" class="flex items-center justify-center p-2 rounded-xl bg-slate-800/40 border border-slate-700/50 hover:bg-slate-800 text-slate-400 hover:text-white transition-all text-xs font-bold w-1/2 text-center" @click="open = false">
                        Configuración
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="w-1/2">
                        @csrf
                        <button type="submit" class="flex items-center justify-center p-2 rounded-xl bg-red-950/20 border border-red-900/30 hover:bg-red-950/40 text-red-400 hover:text-red-300 transition-all text-xs font-bold w-full text-center">
                            Salir
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
