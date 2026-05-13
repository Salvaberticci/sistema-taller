<nav x-data="{ open: false }" class="bg-[#0f172a] border-b border-slate-800 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20 items-center">
            <!-- Logo & Desktop Links -->
            <div class="flex items-center gap-4 lg:gap-8 overflow-hidden">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden xl:flex items-center space-x-1 lg:space-x-4">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                    <x-nav-link :href="route('customers.index')" :active="request()->routeIs('customers.*')">
                        {{ __('Clientes') }}
                    </x-nav-link>
                    <x-nav-link :href="route('vehicles.index')" :active="request()->routeIs('vehicles.*')">
                        {{ __('Vehículos') }}
                    </x-nav-link>
                    <x-nav-link :href="route('orders.index')" :active="request()->routeIs('orders.*')">
                        {{ __('Órdenes') }}
                    </x-nav-link>
                    <x-nav-link :href="route('inventory.index')" :active="request()->routeIs('inventory.*')">
                        {{ __('Inventario') }}
                    </x-nav-link>
                    <x-nav-link :href="route('invoices.index')" :active="request()->routeIs('invoices.*')">
                        {{ __('Facturación') }}
                    </x-nav-link>
                    <x-nav-link :href="route('appointments.index')" :active="request()->routeIs('appointments.*')">
                        {{ __('Citas') }}
                    </x-nav-link>
                    <x-nav-link :href="route('staff.index')" :active="request()->routeIs('staff.*')">
                        {{ __('Personal') }}
                    </x-nav-link>
                    <x-nav-link :href="route('ai.chat')" :active="request()->routeIs('ai.chat')" class="text-blue-400 font-bold">
                        {{ __('IA Assistant') }}
                    </x-nav-link>
                </div>
            </div>

            <!-- Settings & Mobile Menu -->
            <div class="flex items-center gap-2">
                <!-- Settings Dropdown (Hidden on small screens) -->
                <div class="hidden sm:flex sm:items-center">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-slate-800 text-sm font-medium rounded-xl text-slate-400 bg-slate-900/50 hover:text-white hover:bg-slate-800 transition duration-150 ease-in-out shadow-sm">
                                <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center text-xs font-black text-white shadow-lg shadow-blue-500/20 mr-2">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                                <span class="hidden md:inline">{{ Auth::user()->name }}</span>
                                <svg class="fill-current h-4 w-4 ml-2 opacity-50" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <div class="bg-slate-900 border border-slate-800 rounded-xl overflow-hidden shadow-2xl">
                                <div class="px-4 py-3 border-b border-slate-800">
                                    <p class="text-[10px] text-slate-500 uppercase tracking-widest font-black mb-1">Usuario</p>
                                    <p class="text-sm font-bold text-white">{{ Auth::user()->name }}</p>
                                    <p class="text-[10px] text-blue-500 font-bold uppercase">{{ Auth::user()->role }}</p>
                                </div>
                                <x-dropdown-link :href="route('profile.edit')" class="text-slate-400 hover:text-white hover:bg-slate-800">
                                    {{ __('Configuración') }}
                                </x-dropdown-link>

                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <x-dropdown-link :href="route('logout')" class="text-red-400 hover:bg-red-500/10"
                                            onclick="event.preventDefault();
                                                        this.closest('form').submit();">
                                        {{ __('Cerrar Sesión') }}
                                    </x-dropdown-link>
                                </form>
                            </div>
                        </x-slot>
                    </x-dropdown>
                </div>

                <!-- Hamburger -->
                <div class="flex items-center xl:hidden">
                    <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-xl text-slate-400 hover:text-white hover:bg-slate-800 focus:outline-none transition duration-150 ease-in-out border border-slate-800 bg-slate-900/50">
                        <span class="text-xs font-bold mr-2 uppercase tracking-widest lg:hidden">Menu</span>
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden xl:hidden bg-[#0f172a] border-t border-slate-800">
        <div class="pt-2 pb-6 space-y-1 px-4">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">{{ __('Dashboard') }}</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('customers.index')" :active="request()->routeIs('customers.*')">{{ __('Clientes') }}</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('vehicles.index')" :active="request()->routeIs('vehicles.*')">{{ __('Vehículos') }}</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('orders.index')" :active="request()->routeIs('orders.*')">{{ __('Órdenes') }}</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('inventory.index')" :active="request()->routeIs('inventory.*')">{{ __('Inventario') }}</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('invoices.index')" :active="request()->routeIs('invoices.*')">{{ __('Facturación') }}</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('appointments.index')" :active="request()->routeIs('appointments.*')">{{ __('Citas') }}</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('staff.index')" :active="request()->routeIs('staff.*')">{{ __('Personal') }}</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('ai.chat')" :active="request()->routeIs('ai.chat')" class="text-blue-400 font-bold border-l-4 border-blue-500">{{ __('IA Assistant') }}</x-responsive-nav-link>
            
            <!-- Mobile User Section -->
            <div class="pt-4 pb-1 border-t border-slate-800 mt-4">
                <div class="px-4 py-3 bg-slate-900/50 rounded-2xl mb-4">
                    <div class="font-bold text-base text-white">{{ Auth::user()->name }}</div>
                    <div class="text-[10px] text-blue-500 font-black uppercase tracking-widest">{{ Auth::user()->role }}</div>
                </div>
                <div class="space-y-1">
                    <x-responsive-nav-link :href="route('profile.edit')">{{ __('Perfil') }}</x-responsive-nav-link>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link :href="route('logout')" class="text-red-400" onclick="event.preventDefault(); this.closest('form').submit();">{{ __('Cerrar Sesión') }}</x-responsive-nav-link>
                    </form>
                </div>
            </div>
        </div>
    </div>
</nav>
