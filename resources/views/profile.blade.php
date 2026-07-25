<x-profil-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Profil') }}
        </h2>
    </x-slot>

    <div class="py-10" style="background: linear-gradient(180deg,#f8fbff,#f8fafc); min-height:100vh;">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @php
                $role = Auth::user()->rolename ?? 'admin';
                $fallback = match ($role) {
                    'guru' => route('dashboard_guru'),
                    'pengguna' => route('info'),
                    default => route('dashboard'),
                };
                $backUrl = (url()->previous() && url()->previous() !== url()->current())
                    ? url()->previous()
                    : $fallback;
            @endphp


            <div class="ms-hero" style="padding:1.25rem 1.5rem;">
                <div class="ms-badge">👤 Akun Saya</div>
                <h1 class="h3 mb-1">Pengaturan Profil</h1>
                <p class="mb-0">Perbarui informasi akun, kata sandi, atau hapus akun jika diperlukan.</p>
            </div>
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 px-4">
                <a href="{{ $backUrl }}" class="btn btn-outline-danger">
                    <i class="fas fa-arrow-left me-1"></i> Kembali
                </a>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg" style="border-radius:18px;">
                <div class="max-w-xl">
                    <livewire:profile.update-profile-information-form />
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg" style="border-radius:18px;">
                <div class="max-w-xl">
                    <livewire:profile.update-password-form />
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg" style="border-radius:18px;">
                <div class="max-w-xl">
                    <livewire:profile.delete-user-form />
                </div>
            </div>
        </div>
    </div>
</x-profil-layout>
