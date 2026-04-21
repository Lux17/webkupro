<?php

use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Auth;
use App\Models\Hasil;
use Livewire\Volt\Component;

new class extends Component
{
    public string $password = '';

    /**
     * Delete the currently authenticated user.
     */
    public function deleteUser(Logout $logout): void
    {
        $this->validate([
            'password' => ['required', 'string', 'current_password'],
        ]);

        $id_user = Auth::user()->id;
        Hasil::where('idpengguna', $id_user)->delete();
        $cari_email = Hasil::where('idpengguna', $id_user)->pluck('email');
        $hapus_token  = DB::table('password_reset_tokens')->where('email', $cari_email)->delete();
        $hapus_sesi = DB::table('sessions')->where('user_id', $id_user)->delete();
        tap(Auth::user(), $logout(...))->delete();

        $this->redirect('/', navigate: true);
    }
}; ?>
<div class="border p-4 rounded bg-white" style="max-width: 1500px;">
<div class="col-12" style="width: 25rem;">
<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Hapus Permanen Akun') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Akun kamu akan dihapus secara permanen dan dapat menghapus semua aktivitas dan riwayat pada sistem.') }}
        </p>
    </header>

    <x-danger-button
        x-data=""
        class="btn btn-large btn-block btn-danger"
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
    >{{ __('Hapus Akun') }}</x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->isNotEmpty()" focusable>
        <form wire:submit="deleteUser" class="p-6">

            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('Anda yakin ingin menghapus akun?') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                {{ __('Ketika akun anda dihapus semua data pada sistem akan dihapus termasuk aktivitas pada sistem secara permanen.') }}
            </p>

            <div class="mt-6">
                <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />

                <x-text-input
                    wire:model="password"
                    id="password"
                    name="password"
                    type="password"
                    class="form-control"
                    placeholder="{{ __('Kata Sandi') }}"
                />

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button  x-on:click="$dispatch('close')">
                    {{ __('Batal') }}
                </x-secondary-button>

                <x-danger-button class="btn btn-large btn-block btn-danger">
                    {{ __('Hapus Akun') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
</div>
