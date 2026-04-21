<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';
    public string $jenis_kelamin = '';
    public string $rolename = 'pengguna';
    public string $no_hp = '';
    public string $alamat = '';
    public string $riwayat_penyakit = '';
    public string $tgl_lahir = '';


    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
            'jenis_kelamin' => [ 'string', 'max:25'],
            'no_hp' => [ 'string', 'max:25'],
            'rolename' => [ 'string', 'max:25'],
            'alamat' => [ 'string', 'max:200'],
            'riwayat_penyakit' => [ 'string', 'max:25'],
            'tgl_lahir' => [ 'date'],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        event(new Registered($user = User::create($validated)));

        Auth::login($user);

        $this->redirect(route('info', absolute: false), navigate: true);
    }
}; ?>

<div class="border p-4 rounded bg-white mt-5" >
    <h1 class="text-primary" >Registrasi</h1>
    <p>Silahkan registrasi akun terlebih dahulu untuk dapat masuk ke sistem.</p>
    <form wire:submit="register">
    <div class="col-12">
        <!-- Nama -->
        <div class="mb-3">
            <x-input-label for="name" :value="__('Nama')" />
        </div>
        <div class="mb-3">
            <x-text-input wire:model="name" id="name" class="form-control" type="text" name="name" placeholder="Masukan Nama" required  />
            <x-input-error :messages="$errors->get('name')" class="text-danger" />
        </div>

        <!-- Email -->
        <div class="mb-3">
            <x-input-label for="email" :value="__('Email')" />
        <div class="mb-3">
            <x-text-input wire:model="email" id="email" class="form-control" type="email" name="email" placeholder="Masukan Email" required  />
            <x-input-error :messages="$errors->get('email')" class="text-danger" />
        </div>

        <!-- Kata Sandi -->
        <div class="mb-3">
            <x-input-label for="password" :value="__('Kata Sandi (minimal 8 karakter)')" />
        </div>
        <div class="mb-3">
            <x-text-input wire:model="password" id="password" class="form-control"
                            type="password"
                            name="password"
                            placeholder="Masukan Kata Sandi"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="text-danger" />
        </div>

        <!-- Konfirmasi Kata Sandi-->
        <div class="mb-3">
            <x-input-label for="password_confirmation" :value="__('Konfirmasi Kata Sandi')" />
        </div>
        <div class="mb-3">
            <x-text-input wire:model="password_confirmation" id="password_confirmation" class="form-control"
                            type="password"
                            name="password_confirmation" placeholder="Masukan Ulang Kata Sandi" required  />

            <x-input-error :messages="$errors->get('password_confirmation')" class="text-danger" />
        </div>

        <div class="mb-3">
            <x-input-label for="tgl_lahir" :value="__('Tanggal Lahir')" />
        </div>
        <div class="mb-3">
            <x-text-input wire:model="tgl_lahir" id="tgl_lahir" class="form-control" type="date" name="tgl_lahir" required  />
            <x-input-error :messages="$errors->get('tgl_lahir')" class="text-danger" />
        </div>
        <div class="mb-3">
        <x-text-input class="form-control" wire:model="rolename" id="rolename" name="rolename" type="hidden" />
        </div>
        <div class="mb-3">
            <label for="InputName" class="form-label">Jenis Kelamin</label>
                <select class="form-control" wire:model="jenis_kelamin" id="jenisKelamin" name="jenis_kelamin" required >
                    <option value="">Pilih</option>
                    <option value="Laki-laki">Laki-laki</option>
                    <option value="Perempuan">Perempuan</option>
                </select>
        </div>
        <div class="mb-3">
            <label for="InputName" class="form-label">Alamat</label>
            <textarea type="text" wire:model="alamat" class="form-control" id="alamat" name="alamat" required> </textarea>
        </div>

        <div class="mb-3">
            <x-input-label for="no_hp" :value="__('Nomer HP')" />
        </div>
        <div class="mb-3">
            <x-text-input wire:model="no_hp" id="no_hp" class="form-control" type="text" name="no_hp" placeholder="Masukan Nomer HP" required  />
            <x-input-error :messages="$errors->get('no_hp')" class="text-danger" />
        </div>

        <div class="mb-3">
            <x-input-label for="riwayat_penyakit" :value="__('Riwayat Penyakit')" />
        </div>
        <div class="mb-3">
            <x-text-input wire:model="riwayat_penyakit" id="riwayat_penyakit" class="form-control" type="text"  placeholder="Masukan Riwayat Penyakit" name="riwayat_penyakit" required />
            <x-input-error :messages="$errors->get('riwayat_penyakit')" class="text-danger" />
        </div>

        <div class="mb-3 d-grid gap-2">
        <x-primary-button class="btn btn-large btn-block btn-primary tombol">
                {{ __('Daftar') }}
        </x-primary-button>
        </div>
        <div class="flex items-center justify-end mt-4">
            Sudah Punya Akun?
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}" wire:navigate>
                {{ __('Masuk') }}
            </a>
        </div>
    </form>
</div>
</div>

