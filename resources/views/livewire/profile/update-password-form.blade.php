<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use Livewire\Volt\Component;

new class extends Component
{
    public string $current_password = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Update the password for the currently authenticated user.
     */
    public function updatePassword(): void
    {
        try {
            $validated = $this->validate([
                'current_password' => ['required', 'string', 'current_password'],
                'password' => ['required', 'string', Password::defaults(), 'confirmed'],
            ]);
        } catch (ValidationException $e) {
            $this->reset('current_password', 'password', 'password_confirmation');

            throw $e;
        }

        Auth::user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        $this->reset('current_password', 'password', 'password_confirmation');

        $this->dispatch('password-updated');
    }
}; ?>

<div class="border p-4 rounded bg-white" style="max-width: 1500px;">
<div class="col-12" style="width: 25rem;">
<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Ubah Kata Sandi') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Anda dapat mengubah kata sandi anda untuk menjaga akun agar tetap aman.') }}
        </p>
        <x-action-message class="me-3" on="password-updated">
            <div class="alert alert-success">
            {{ __('Kata Sandi Akun Telah di Perbarui.') }}
            </div>
        </x-action-message>
    </header>

    <form wire:submit="updatePassword" class="mt-6 space-y-6">
        <div class="mb-3">
            <x-input-label for="update_password_current_password" :value="__('Kata Sandi Saat ini')" />
        </div>
        <div class="mb-3">
            <x-text-input wire:model="current_password" id="update_password_current_password" name="current_password" type="password" class="form-control" autocomplete="current-password" />
            <x-input-error :messages="$errors->get('current_password')" class="mt-2" />
        </div>

        <div class="mb-3">
            <x-input-label for="update_password_password" :value="__('Kata Sandi Baru')" />
        </div>
        <div class="mb-3">
            <x-text-input wire:model="password" id="update_password_password" name="password" type="password" class="form-control" autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="mb-3">
            <x-input-label for="update_password_password_confirmation" :value="__('Konfirmasi kata sandi')" />
        </div>
        <div class="mb-3">
            <x-text-input wire:model="password_confirmation" id="update_password_password_confirmation" name="password_confirmation" type="password" class="form-control"  autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button class="btn btn-large btn-block btn-primary">{{ __('Simpan') }}</x-primary-button>


        </div>
    </form>
</section>
</div>
</div>
