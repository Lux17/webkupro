<?php

use App\Models\User;
use App\Models\Kelas;
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
        public string $nisn = '';
        public string $alamat = '';
        public $id_kelas = null;
        public $tgl_lahir = null;
        public string $no_hp = '';

    public $kelas = [];

        public function mount()
        {
            $this->kelas = Kelas::orderBy('id_kelas', 'asc')->get();
        }


    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
            'jenis_kelamin' => ['nullable', 'string', 'max:25'],
            'no_hp' => ['nullable', 'string', 'max:25'],
            'nisn' => ['nullable', 'string', 'max:25'],
            'alamat' => ['nullable', 'string', 'max:200'],
            'id_kelas' => ['nullable', 'integer'],
            'tgl_lahir' => ['nullable', 'date'],

        ]);

        // Password is hashed by the User model cast ('hashed').
        // Force student role server-side — never trust client-supplied rolename.
        $user = new User($validated);
        $user->rolename = 'pengguna';
        $user->save();

        event(new Registered($user));

        Auth::login($user);

        $this->redirect(route('info', absolute: false), navigate: true);
    }
}; ?>

<div class="auth-card" style="max-width: 560px;">
    <div class="brand">
        <img src="{{ asset('assets/images/icon-stem.png') }}" style="height: 52px;" alt="MendungSTEM">
        <h5>MendungSTEM</h5>
    </div>
    <h1>Registrasi Siswa</h1>
    <p class="subtitle">Buat akun untuk mulai belajar di platform MendungSTEM.</p>

    <form wire:submit="register">
        <div class="mb-3">
            <x-input-label for="name" :value="__('Nama')" />
            <x-text-input wire:model="name" id="name" class="form-control" type="text" name="name" placeholder="Masukan Nama" required />
            <x-input-error :messages="$errors->get('name')" class="text-danger" />
        </div>

        <div class="mb-3">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input wire:model="email" id="email" class="form-control" type="email" name="email" placeholder="Masukan Email" required />
            <x-input-error :messages="$errors->get('email')" class="text-danger" />
        </div>

        <div class="mb-3">
            <x-input-label for="nisn" :value="__('NISN')" />
            <x-text-input wire:model="nisn" id="nisn" class="form-control" type="text" name="nisn" placeholder="Masukan NISN" required />
            <x-input-error :messages="$errors->get('nisn')" class="text-danger" />
        </div>

        <div class="mb-3">
            <x-input-label for="password" :value="__('Kata Sandi (minimal 8 karakter)')" />
            <x-text-input wire:model="password" id="password" class="form-control" type="password" name="password" placeholder="Masukan Kata Sandi" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="text-danger" />
        </div>

        <div class="mb-3">
            <x-input-label for="password_confirmation" :value="__('Konfirmasi Kata Sandi')" />
            <x-text-input wire:model="password_confirmation" id="password_confirmation" class="form-control" type="password" name="password_confirmation" placeholder="Masukan Ulang Kata Sandi" required />
            <x-input-error :messages="$errors->get('password_confirmation')" class="text-danger" />
        </div>

        <div class="mb-3">
            <x-input-label for="tgl_lahir" :value="__('Tanggal Lahir')" />
            <x-text-input wire:model="tgl_lahir" id="tgl_lahir" class="form-control" type="date" name="tgl_lahir" required />
            <x-input-error :messages="$errors->get('tgl_lahir')" class="text-danger" />
        </div>

        

        <div class="mb-3">
            <label for="jenisKelamin" class="form-label">Jenis Kelamin</label>
            <select class="form-control" wire:model="jenis_kelamin" id="jenisKelamin" name="jenis_kelamin" required>
                <option value="">Pilih</option>
                <option value="Laki-laki">Laki-laki</option>
                <option value="Perempuan">Perempuan</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="id_kelas" class="form-label">Kelas</label>
            <select class="form-control" wire:model="id_kelas" id="id_kelas" name="id_kelas">
                <option value="">Pilih</option>
                @foreach($kelas as $k)
                    <option value="{{ $k->id_kelas }}">{{ $k->nama_kelas }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="alamat" class="form-label">Alamat</label>
            <textarea wire:model="alamat" class="form-control" id="alamat" name="alamat" rows="3" required></textarea>
        </div>

        <div class="mb-3">
            <x-input-label for="no_hp" :value="__('Nomor HP')" />
            <x-text-input wire:model="no_hp" id="no_hp" class="form-control" type="text" name="no_hp" placeholder="Masukan Nomor HP" required />
            <x-input-error :messages="$errors->get('no_hp')" class="text-danger" />
        </div>

        <div class="d-grid mb-3">
            <x-primary-button class="btn btn-primary">
                {{ __('Daftar') }}
            </x-primary-button>
        </div>

        <p class="text-center mb-0 text-muted">
            Sudah punya akun?
            <a class="fw-bold text-decoration-none" href="{{ route('login') }}" wire:navigate>{{ __('Masuk') }}</a>
        </p>
    </form>
</div>

