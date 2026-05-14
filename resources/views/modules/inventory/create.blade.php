<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('inventory.index') }}" class="p-2 bg-slate-800 hover:bg-slate-700 rounded-xl border border-slate-700 text-slate-400 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                </svg>
            </a>
            <h2 class="font-bold text-2xl text-white leading-tight">
                {{ __('Nuevo Repuesto') }}
            </h2>
        </div>
    </x-slot>

    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div class="premium-card rounded-[2.5rem] p-8 shadow-2xl border border-slate-700 bg-slate-800/50">
            <form action="{{ route('inventory.store') }}" method="POST" class="space-y-6">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <x-input-label for="name" :value="__('Nombre del Repuesto')" />
                        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" required autofocus placeholder="Ej. Filtro de Aceite" />
                        <x-input-error class="mt-2" :messages="$errors->get('name')" />
                    </div>

                    <div>
                        <x-input-label for="sku" :value="__('SKU / Código')" />
                        <x-text-input id="sku" name="sku" type="text" class="mt-1 block w-full" placeholder="FA-001" />
                        <x-input-error class="mt-2" :messages="$errors->get('sku')" />
                    </div>

                    <div>
                        <x-input-label for="category" :value="__('Categoría')" />
                        <x-text-input id="category" name="category" type="text" class="mt-1 block w-full" placeholder="Ej. Motor" />
                        <x-input-error class="mt-2" :messages="$errors->get('category')" />
                    </div>

                    <div>
                        <x-input-label for="stock" :value="__('Stock Inicial')" />
                        <x-text-input id="stock" name="stock" type="number" step="0.01" class="mt-1 block w-full" required placeholder="0.00" />
                        <x-input-error class="mt-2" :messages="$errors->get('stock')" />
                    </div>

                    <div>
                        <x-input-label for="min_stock" :value="__('Stock Mínimo (Alerta)')" />
                        <x-text-input id="min_stock" name="min_stock" type="number" step="0.01" class="mt-1 block w-full" required placeholder="5.00" />
                        <x-input-error class="mt-2" :messages="$errors->get('min_stock')" />
                    </div>

                    <div class="md:col-span-2">
                        <x-input-label for="price" :value="__('Precio de Venta ($)')" />
                        <x-text-input id="price" name="price" type="number" step="0.01" class="mt-1 block w-full" required placeholder="0.00" />
                        <x-input-error class="mt-2" :messages="$errors->get('price')" />
                    </div>
                </div>

                <div class="flex items-center justify-end mt-8 gap-4">
                    <a href="{{ route('inventory.index') }}" class="text-sm font-bold text-slate-400 hover:text-white transition-colors">Cancelar</a>
                    <button type="submit" class="px-10 py-4 bg-blue-600 hover:bg-blue-700 text-white font-black rounded-2xl shadow-lg shadow-blue-500/20 transition-all hover:scale-105 active:scale-95">
                        Registrar Repuesto
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
