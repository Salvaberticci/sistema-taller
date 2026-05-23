<section class="space-y-6">
    <header>
        <h3 class="text-xl font-bold text-white">
            {{ __('Eliminar Cuenta') }}
        </h3>

        <p class="mt-1 text-sm text-slate-400">
            {{ __('Una vez que se elimine tu cuenta, todos sus recursos y datos se borrarán permanentemente. Antes de eliminar tu cuenta, por favor descarga cualquier dato o información que desees conservar.') }}
        </p>
    </header>

    <button type="button"
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="px-8 py-3 bg-red-600/80 hover:bg-red-700 text-white font-bold rounded-xl shadow-lg shadow-red-500/20 transition-all hover:scale-102 active:scale-98">
        {{ __('Eliminar Cuenta') }}
    </button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6 bg-slate-900 border border-slate-700 rounded-3xl">
            @csrf
            @method('delete')

            <h3 class="text-xl font-bold text-white">
                {{ __('¿Estás seguro de que deseas eliminar tu cuenta?') }}
            </h3>

            <p class="mt-2 text-sm text-slate-400">
                {{ __('Una vez que se elimine tu cuenta, todos sus recursos y datos se borrarán permanentemente. Por favor, introduce tu contraseña para confirmar que deseas eliminar permanentemente tu cuenta.') }}
            </p>

            <div class="mt-6">
                <x-input-label for="password" value="{{ __('Contraseña') }}" class="sr-only" />

                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-3/4 bg-slate-950 border border-slate-700 text-white rounded-xl"
                    placeholder="{{ __('Contraseña') }}"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <button type="button" x-on:click="$dispatch('close')" class="px-6 py-3 bg-slate-800 hover:bg-slate-700 text-slate-300 font-bold rounded-xl transition-all">
                    {{ __('Cancelar') }}
                </button>

                <button type="submit" class="px-6 py-3 bg-red-600 hover:bg-red-700 text-white font-bold rounded-xl shadow-lg shadow-red-500/20 transition-all">
                    {{ __('Eliminar Cuenta') }}
                </button>
            </div>
        </form>
    </x-modal>
</section>
