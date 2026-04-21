<?php

use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $email = '';

    public function sendPasswordResetLink(): void
    {
        $this->validate([
            'email' => ['required', 'string', 'email'],
        ]);


        //Mengirim link reset kata sandi kemudian mengecek statusnya dan menampilkannya
        $status = Password::sendResetLink(
            $this->only('email')
        );

        if ($status != Password::RESET_LINK_SENT) {
            $this->addError('email', __($status));

            return;
        }

        $this->reset('email');

        session()->flash('status', __($status));
    }
}; ?>

<div class="border p-4 my-5 rounded bg-white forgot">
<div class ="align-center text-center">
    <img src="{{ asset('assets/images/logo.png') ;}}" style="height: 60px;" alt="">
    <h5 style="color: #0a44c1;">SP KidneyKids</h5>
</div>
<div  >
<div class="col-12 forgot">

<h1 style="color: #0a44c1;" >Lupa Kata Sandi</h1>
    <div class="mb-3 text-sm text-gray-600 dark:text-gray-400">
        {{ __('Silahkan Masukan Email Anda dan Kami akan mengirim link ubah kata sandi ke email anda.') }}
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="text-success" :status="session('status')" />
    <x-input-error :messages="$errors->get('email')" class="text-danger" />

    <form wire:submit="sendPasswordResetLink">
        <div class="mb-3">
            <x-input-label for="email" :value="__('Email')" />
        </div>
        <div class="mb-3">
            <x-text-input wire:model="email" id="email" class="form-control" type="email" name="email"  placeholder="Masukan Email" required />
        </div>

        <div class="mb-3 d-grid gap-2 mt-4">
            <x-primary-button class="btn btn-large btn-block btn-primary">
                {{ __('Kirim') }}
            </x-primary-button>
        </div>
    </form>
</div>
</div>
</div>
