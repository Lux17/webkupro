<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;


new #[Layout('layouts.guest')] class extends Component
{
    public LoginForm $form;

    public function login(): void
    {
        $this->validate();
        $this->form->authenticate();
        Session::regenerate();

 
        if (Auth::user()->rolename === 'admin') {
            session()->put('is_admin', true);
            $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
        }elseif(Auth::user()->rolename === 'guru') {
            session()->put('is_guru', true);
            $this->redirectIntended(default: route('dashboard_guru', absolute: false), navigate: true);
        }else {
            session()->put('is_user', true);
            $this->redirectIntended(default: route('info', absolute: false), navigate: true);
        }

        return;
    }
}; ?>

<div class="auth-card">
    <div class="brand">
        <img src="{{ asset('assets/images/icon-stem.png') }}" style="height: 58px;" alt="MendungSTEM">
        <h5>MendungSTEM</h5>
    </div>

    <h1>Masuk Akun</h1>
    <p class="subtitle">Silakan masuk untuk melanjutkan belajar atau mengelola data.</p>

    <x-input-error :messages="$errors->get('form.email')" class="text-danger" />
    <x-input-error :messages="$errors->get('form.password')" class="text-danger" />
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form wire:submit="login">
        <div class="mb-3">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input wire:model="form.email" id="email" class="form-control" placeholder="Masukan Email" type="email" name="email" required autofocus autocomplete="username" />
        </div>

        <div class="mb-3">
            <x-input-label for="password" :value="__('Kata Sandi')" />
            <div class="input-group">
                <x-text-input wire:model="form.password" id="password" class="form-control"
                                type="password"
                                name="password"
                                placeholder="Masukan Kata Sandi"
                                required autocomplete="current-password" />
                <div class="input-group-append">
                    <span class="input-group-text" onclick="password_show_hide();" style="cursor:pointer; border-radius: 0 12px 12px 0;">
                        <i class="fas fa-eye" id="show_eye"></i>
                        <i class="fas fa-eye-slash d-none" id="hide_eye"></i>
                    </span>
                </div>
            </div>
        </div>

        <div class="mb-3 form-check">
            <div class="row align-items-center">
                <div class="col">
                    <label for="remember" class="inline-flex items-center mb-0">
                        <input wire:model="form.remember" id="remember" type="checkbox" class="rounded border-gray-300" name="remember">
                        <span class="text-sm text-gray-600 ms-1">{{ __('Ingat saya') }}</span>
                    </label>
                </div>
                <div class="col text-end">
                    @if (Route::has('password.request'))
                        <a class="text-sm text-decoration-none" href="{{ route('password.request') }}" wire:navigate>
                            {{ __('Lupa kata sandi?') }}
                        </a>
                    @endif
                </div>
            </div>
        </div>

        <div class="d-grid mb-3">
            <x-primary-button class="btn btn-primary">
                {{ __('Masuk') }}
            </x-primary-button>
        </div>

        <p class="text-center mb-0 text-muted">
            Belum punya akun?
            <a href="{{ route('register') }}" class="fw-bold text-decoration-none">Daftar</a>
        </p>
    </form>
</div>
