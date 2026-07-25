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

<div class="auth-card">
    <div class="brand">
        <img src="{{ asset('assets/images/icon-stem.png') }}" style="height: 52px;" alt="MendungSTEM">
        <h5>MendungSTEM</h5>
    </div>

    <h1>Lupa Kata Sandi</h1>
    <p class="subtitle">Masukkan email akunmu. Kami akan mengirim link untuk mengatur ulang kata sandi.</p>

    <x-auth-session-status class="text-success mb-3" :status="session('status')" />
    <x-input-error :messages="$errors->get('email')" class="text-danger" />

    <form wire:submit="sendPasswordResetLink">
        <div class="mb-3">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input wire:model="email" id="email" class="form-control" type="email" name="email" placeholder="Masukan Email" required />
        </div>

        <div class="d-grid mb-3">
            <x-primary-button class="btn btn-primary">
                {{ __('Kirim Link Reset') }}
            </x-primary-button>
        </div>

        <p class="text-center mb-0">
            <a href="{{ route('login') }}" class="fw-bold text-decoration-none" wire:navigate>Kembali ke Login</a>
        </p>
    </form>
</div>
