<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Livewire\Volt\Component;

new class extends Component
{
    public string $name = '';
    public string $email = '';
    public string $tgl_lahir = '';
    public string $no_hp = '';
    public string $alamat = '';
    public string $riwayat_penyakit = '';

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $this->name = Auth::user()->name;
        $this->email = Auth::user()->email;
        $this->tgl_lahir = Auth::user()->tgl_lahir;
        $this->no_hp = Auth::user()->no_hp;
        $this->alamat = Auth::user()->alamat;
        $this->riwayat_penyakit = Auth::user()->riwayat_penyakit;
    }

    /**
     * Update the profile information for the currently authenticated user.
     */
    public function updateProfileInformation(): void
    {
        $user = Auth::user();

        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($user->id)],
            'tgl_lahir' => ['required'],
            'no_hp' => ['required'],
            'alamat' => ['required', 'string', 'max:255'],
            'riwayat_penyakit' => ['required', 'string', 'max:255'],
        ]);

        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        $this->dispatch('profile-updated', name: $user->name);
    }

    /**
     * Send an email verification notification to the current user.
     */
    public function sendVerification(): void
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {

            if (Auth::user()->rolename === 'admin') {
                $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    
            }else {
    
                $this->redirectIntended(default: route('info', absolute: false), navigate: true);
            }

            return;
        }

        $user->sendEmailVerificationNotification();

        Session::flash('status', 'verification-link-sent');
    }
}; ?>

<div class="border p-4 rounded bg-white" style="max-width: 1500px;">
<div class="col-12" style="width: 25rem;">
<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Informasi Akun') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Ubah informasi akun dan email.") }}
        </p>
        <x-action-message class="me-3" on="profile-updated">
            <div class="alert alert-success">
            {{ __('Informasi Akun Telah di Perbarui.') }}
            </div>
        </x-action-message>
    </header>

    <form wire:submit="updateProfileInformation" class="mt-6 space-y-6">
        <div class="mb-3">
            <x-input-label for="name" :value="__('Nama')" />
        </div>
        <div class="mb-3">
            <x-text-input wire:model="name" id="name" name="name" type="text" class="form-control" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div class="mb-3">
            <x-input-label for="email" :value="__('Email')" />
        </div>
        <div class="mb-3">
            <x-text-input wire:model="email" id="email" name="email" type="email" class="form-control" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if (! auth()->user()->hasVerifiedEmail())
                <div>
                    <p class="text-clack mt-2 ">
                        {{ __('Email Kamu Belum Terverifikasi.') }}

                        <button wire:click.prevent="sendVerification" class="underline text-white noborder bg-warning rounded">
                            {{ __('Klik disini untuk kirim ulang verifikasi email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-success">
                            {{ __('Link Verifikasi yang baru telah dikirim ke email anda.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>
        @if((Auth::user()->rolename === 'pengguna'))
        <div class="mb-3">
            <x-input-label for="tgl_lahir" :value="__('Tanggal Lahir')" />
        </div>
        <div class="mb-3">
            <x-text-input wire:model="tgl_lahir" id="tgl_lahir" name="tgl_lahir" type="date" class="form-control" required autofocus autocomplete="tgl_lahir" />
            <x-input-error class="mt-2" :messages="$errors->get('tgl_lahir')" />
        </div>
        <div class="mb-3">
            <x-input-label for="no_hp" :value="__('Nomer HP')" />
        </div>
        <div class="mb-3">
            <x-text-input wire:model="no_hp" id="no_hp" name="no_hp" type="text" class="form-control" required autofocus autocomplete="no_hp" />
            <x-input-error class="mt-2" :messages="$errors->get('no_hp')" />
        </div>
        <div class="mb-3">
            <x-input-label for="alamat" :value="__('Alamat')" />
        </div>
        <div class="mb-3">
            <x-text-input wire:model="alamat" id="alamat" name="alamat" type="text" class="form-control" required autofocus autocomplete="alamat" />
            <x-input-error class="mt-2" :messages="$errors->get('alamat')" />
        </div>
        <div class="mb-3">
            <x-input-label for="riwayat_penyakit" :value="__('Riwayat Penyakit')" />
        </div>
        <div class="mb-3">
            <x-text-input wire:model="riwayat_penyakit" id="riwayat_penyakit" name="riwayat_penyakit" type="text" class="form-control" required autofocus autocomplete="riwayat_penyakit" />
            <x-input-error class="mt-2" :messages="$errors->get('riwayat_penyakit')" />
        </div>
        @endif
        <div class="flex items-center gap-4">
            <x-primary-button class="btn btn-large btn-block btn-primary">{{ __('Simpan') }}</x-primary-button>

        </div>
    </form>
</section>
</div>
</div>
