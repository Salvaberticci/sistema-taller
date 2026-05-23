<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('customers.index') }}" class="p-2 bg-slate-800 hover:bg-slate-700 rounded-xl border border-slate-700 text-slate-400 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                </svg>
            </a>
            <h2 class="font-bold text-2xl text-white leading-tight">
                {{ __('Editar Cliente') }}
            </h2>
        </div>
    </x-slot>

    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div class="premium-card rounded-[2.5rem] p-8 shadow-2xl border border-slate-700">
            <form action="{{ route('customers.update', $customer->id) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <x-input-label for="name" :value="__('Nombre Completo')" />
                        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $customer->name)" required autofocus placeholder="Ej. Juan Pérez" />
                        <x-input-error class="mt-2" :messages="$errors->get('name')" />
                    </div>

                    <div>
                        <x-input-label for="id_card" :value="__('Cédula / RIF')" />
                        <x-text-input id="id_card" name="id_card" type="text" class="mt-1 block w-full" :value="old('id_card', $customer->id_card)" placeholder="Ej. V-12345678" />
                        <x-input-error class="mt-2" :messages="$errors->get('id_card')" />
                    </div>

                    <div>
                        <x-input-label for="email" :value="__('Correo Electrónico')" />
                        <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $customer->email)" placeholder="juan@ejemplo.com" />
                        <x-input-error class="mt-2" :messages="$errors->get('email')" />
                    </div>

                    <div>
                        <x-input-label for="phone" :value="__('Teléfono / WhatsApp')" />
                        <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full" :value="old('phone', $customer->phone)" required placeholder="+58 412..." />
                        <x-input-error class="mt-2" :messages="$errors->get('phone')" />
                    </div>

                    <div class="md:col-span-2">
                        <x-input-label for="address" :value="__('Dirección')" />
                        <textarea id="address" name="address" class="mt-1 block w-full bg-slate-900 border border-slate-700 rounded-xl text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all p-4" rows="3" placeholder="Dirección de habitación o trabajo...">{{ old('address', $customer->address) }}</textarea>
                        <x-input-error class="mt-2" :messages="$errors->get('address')" />
                    </div>
                </div>

                <div class="flex items-center justify-end mt-8 gap-4">
                    <a href="{{ route('customers.index') }}" class="text-sm font-bold text-slate-400 hover:text-white transition-colors">Cancelar</a>
                    <button type="submit" class="px-10 py-4 bg-blue-600 hover:bg-blue-700 text-white font-black rounded-2xl shadow-lg shadow-blue-500/20 transition-all hover:scale-105 active:scale-95">
                        Actualizar Cliente
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
