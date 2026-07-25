<?php

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Locked;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    #[Locked]
    public string $token = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    public function mount(string $token): void
    {
        $this->token = $token;

        $this->email = request()->string('email');
    }

    public function resetPassword(): void
    {
        $this->validate([
            'token' => ['required'],
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        //melakukan reset kata sandi di database
        $status = Password::reset(
            $this->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) {
                $user->forceFill([
                    'password' => Hash::make($this->password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        //Ketika Pengguna sudah reset kata sandi maka pengguna akan diredirect ke menu login
        //jika ada pesan kesalahan maka akan notifikasi
        if ($status != Password::PASSWORD_RESET) {
            $this->addError('email', __($status));

            return;
        }

        Session::flash('status', __($status));

        $this->redirectRoute('login', navigate: true);
    }
}; ?>

<div class="auth-card">
    <div class="brand">
        <img src="{{ asset('assets/images/icon-stem.png') }}" style="height: 52px;" alt="MendungSTEM">
        <h5>MendungSTEM</h5>
    </div>

    <h1>Ubah Kata Sandi</h1>
    <p class="subtitle">Masukkan kata sandi baru untuk akunmu.</p>

    <form wire:submit="resetPassword">
        <div class="mb-3">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input wire:model="email" id="email" class="form-control" type="email" name="email" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="text-danger" />
        </div>

        <div class="mb-3">
            <x-input-label for="password" :value="__('Kata Sandi Baru')" />
            <div class="input-group">
                <x-text-input wire:model="password" id="password" class="form-control" type="password" name="password" required autocomplete="new-password" />
                <div class="input-group-append">
                    <span class="input-group-text" onclick="password_show_hide();" style="cursor:pointer; border-radius:0 12px 12px 0;">
                        <i class="fas fa-eye" id="show_eye"></i>
                        <i class="fas fa-eye-slash d-none" id="hide_eye"></i>
                    </span>
                </div>
            </div>
            <x-input-error :messages="$errors->get('password')" class="text-danger" />
        </div>

        <div class="mb-3">
            <x-input-label for="password_confirmation" :value="__('Konfirmasi Kata Sandi Baru')" />
            <div class="input-group">
                <x-text-input wire:model="password_confirmation" id="password_confirmation" class="form-control"
                              type="password"
                              name="password_confirmation" required autocomplete="new-password" />
                <div class="input-group-append">
                    <span class="input-group-text" onclick="password_show_hide2();" style="cursor:pointer; border-radius:0 12px 12px 0;">
                        <i class="fas fa-eye" id="show_eye2"></i>
                        <i class="fas fa-eye-slash d-none" id="hide_eye2"></i>
                    </span>
                </div>
            </div>
            <x-input-error :messages="$errors->get('password_confirmation')" class="text-danger" />
        </div>

        <div class="d-grid">
            <x-primary-button class="btn btn-primary">
                {{ __('Simpan Kata Sandi') }}
            </x-primary-button>
        </div>
    </form>
</div>
