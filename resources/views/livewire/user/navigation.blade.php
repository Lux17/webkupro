<?php

use App\Livewire\Actions\Logout;
use Livewire\Volt\Component;

new class extends Component
{

    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }
}; ?>

<nav x-data="{ open: false }" class="user-topnav">

<style>
  .user-topnav .header {
    box-shadow: 0 8px 24px rgba(15, 23, 42, 0.06);
    border-bottom: 1px solid rgba(226, 232, 240, 0.9);
    min-height: 70px;
    padding: 0 1rem;
  }

  .user-topnav .logo span {
    color: #0f172a;
    font-weight: 800;
    letter-spacing: -0.02em;
  }

  .user-topnav .user-menu-btn {
    border: 1px solid #e2e8f0;
    border-radius: 999px;
    background: #fff;
    padding: .45rem .9rem .45rem .5rem;
    display: inline-flex;
    align-items: center;
    gap: .55rem;
    font-weight: 600;
    color: #0f172a;
  }

  .user-topnav .user-avatar {
    width: 34px;
    height: 34px;
    border-radius: 50%;
    background: linear-gradient(135deg, #2563eb, #0ea5e9);
    color: #fff;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: .85rem;
    font-weight: 800;
  }

  .user-topnav .dropdown-menu {
    border: 0;
    border-radius: 14px;
    box-shadow: 0 12px 30px rgba(15, 23, 42, 0.12);
    padding: .5rem;
    min-width: 180px;
  }

  .user-topnav .dropdown-menu a,
  .user-topnav .dropdown-menu button {
    border-radius: 10px;
  }
</style>

  <header id="header" class="header fixed-top d-flex align-items-center bg-white">

  <div class="d-flex align-items-center justify-content-between ">
    <div class="d-flex align-items-center justify-content-between mx-3 mx-md-5">
      <a href="{{ route('info')}}" class="logo d-flex align-items-center text-decoration-none">
        <img src="{{ asset('assets/images/icon-stem.png') }}" style="width: 40px; height: 40px;" alt="">
        <span class="d-none d-lg-block mx-3">MendungSTEM</span>
      </a>
    </div>
  </div>



  <nav class="header-nav ms-auto">
    <ul class="d-flex align-items-center">
      <div class="dropdown">
            <button class="user-menu-btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                  <span class="user-avatar">{{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}</span>
                  <div x-data="{{ json_encode(['name' => auth()->user()->name]) }}" x-text="name" x-on:profile-updated.window="name = $event.detail.name"></div>
                  </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <x-dropdown-link :href="route('profile')" wire:navigate style="text-decoration: none;">
                    {{ __('Profil') }}
                    </x-dropdown-link>
                      <button  data-bs-toggle="modal" data-bs-target="#keluar"  style="text-decoration: none; border: none;  background-color: transparent; width: 100%; text-align: left;">
                      <x-dropdown-link  style="text-decoration: none; ">
                          {{ __('Keluar') }}
                      </x-dropdown-link>
                      </button>
                </ul>
      </div>
    </ul>
  </nav>
</header>
          <!-- Modal Keluar -->
          <div class="modal fade" id="keluar" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h1 class="modal-title fs-5" id="exitLabel">Keluar</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                Apakah Anda Yakin Ingin Keluar?
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <a type="button"  class="btn btn-danger text-white" wire:click="logout">Keluar</a>
              </div>
            </div>
          </div>
        </div>
