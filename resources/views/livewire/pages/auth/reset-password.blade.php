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

<div class="border p-4 mt-5 rounded bg-white reset" >
<div class ="align-center text-center">
    <img src="{{ asset('assets/images/logo.png') ;}}" style="height: 60px;" alt="">
    <h5 style="color: #0a44c1;">SP KidneyKids</h5>
</div>
<div class="col-12" >
    <h1 style="color: #0a44c1;">Ubah Kata Sandi</h1>
    <p>Silahkan masukan kata sandi baru anda</p>
    <form wire:submit="resetPassword">
        <!-- Email-->
        <div class="mb-3">
            <x-input-label for="email" :value="__('Email')" />
        </div>
        <div class="mb-3">
            <x-text-input wire:model="email" id="email" class="form-control" type="email" name="email" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="text-danger" />
        </div>

        <!-- Kata Sandi -->
        <div class="mb-3">
            <x-input-label for="password" :value="__('Kata Sandi Baru')" />
        </div>
        <div class="mb-3 input-group">
            <x-text-input wire:model="password" id="password" class="form-control" type="password" name="password" required autocomplete="new-password" />
            <div class= "input-group-append">
                <span class="input-group-text" onclick="password_show_hide();">
                    <i class="mb-2 fas fa-eye" id="show_eye"></i>
                <i class="mb-2 fas fa-eye-slash d-none" id="hide_eye"></i>
                </span>
            </div>
            <x-input-error :messages="$errors->get('password')" class="text-danger" />
        </div>

        <!-- Konfirmasi Kata Sandi-->
        <div class="mb-3">
            <x-input-label for="password_confirmation" :value="__('Konfirmasi Kata Sandi Baru')" />
        </div>       
        <div class="mb-3  input-group">
            <x-text-input wire:model="password_confirmation" id="password_confirmation" class="form-control"
                          type="password"
                          name="password_confirmation" required autocomplete="new-password" />
            <div class= "input-group-append">
                <span class="input-group-text" onclick="password_show_hide2();">
                    <i class="mb-2 fas fa-eye" id="show_eye2"></i>
                <i class="mb-2 fas fa-eye-slash d-none" id="hide_eye2"></i>
                </span>
            </div>
            <x-input-error :messages="$errors->get('password_confirmation')" class="text-danger" />
        </div>

        <div class="mb-3 d-grid gap-2">
            <x-primary-button class="btn btn-large btn-block btn-primary tombol">
                {{ __('Kirim') }}
            </x-primary-button>
        </div>
    </form>
</div>
