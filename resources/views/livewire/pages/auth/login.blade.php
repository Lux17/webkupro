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
    
        }else {
            session()->put('is_user', true);
            $this->redirectIntended(default: route('info', absolute: false), navigate: true);
        }

        return;
    }
}; ?>



<div class ="border pt-4 mt-5 rounded bg-white align-center masuk">
<div class ="align-center text-center">
    <img src="{{ asset('assets/images/logo.png') ;}}" style="height: 60px;" alt="">
    <h5 style="color: #0a44c1;">SP KidneyKids</h5>
</div>
<center>
    <h1 style="color: #0a44c1;  ">Masuk Akun</h1>
    <p class="card-text" style="color: #343fba;">Silahkan  masuk ke akunmu.</p>
</center>
<!-- Session Status -->
<x-input-error :messages="$errors->get('form.email')" class="text-danger" />
<x-input-error :messages="$errors->get('form.password')" class="text-danger" />
<x-auth-session-status class="mb-4" :status="session('status')" />
    <form class="mx-4"  wire:submit="login">
    <div class="col-12" >
        <!-- Email -->
        <div class="mb-3">
            <x-input-label for="email" :value="__('Email')" />
        </div>
        <div class="mb-3">
            <x-text-input wire:model="form.email" id="email"  class="form-control" placeholder="Masukan Email" type="email" name="email" required autofocus autocomplete="username" />
        </div>
        <!-- Kata Sandi -->
        <div class="mb-3">
            <x-input-label for="password" :value="__('Kata Sandi')" />

        </div>
        <div class="mb-3  input-group">
            <x-text-input wire:model="form.password" id="password" class="form-control"
                            type="password"
                            name="password"
                            placeholder="Masukan Kata Sandi"
                            required autocomplete="current-password" />
            <div class= "input-group-append">
                <span class="input-group-text" onclick="password_show_hide();">
                    <i class="mb-2 fas fa-eye" id="show_eye"></i>
                <i class="mb-2 fas fa-eye-slash d-none" id="hide_eye"></i>
                </span>
            </div>
        </div>

        <!-- Ingat Saya -->
        <div class="mb-3 form-check">
                <div class="row">
                    <div class="col">
                    <label for="remember" class="inline-flex items-center">
                        <input wire:model="form.remember" id="remember" type="checkbox" class="rounded dark:bg-gray-900 border-gray-300 " name="remember">
                        <span class=" text-sm text-gray-600 dark:text-gray-400">{{ __('Ingat saya') }}</span>
                    </label>
                    </div>
               
                    <div class="col text-end">
                        @if (Route::has('password.request'))
                            <a class="mx-0 underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md " href="{{ route('password.request') }}" wire:navigate>
                                {{ __('Lupa kata sandi?') }}
                            </a>
                        @endif
                    </div>
                </div>
        </div>
        <div class="mb-3 d-grid gap-2">
            <x-primary-button class="btn btn-large btn-block btn-primary tombol">
                {{ __('Masuk') }}
            </x-primary-button>
        </div>
        <div class="mb-4">
            <p >Belum Punya Akun? <a href="{{ route('register') }}">Daftar</a> </p>
        </div>
    </div>
    </form>
</div>


