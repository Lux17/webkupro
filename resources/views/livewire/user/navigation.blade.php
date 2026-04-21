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

<nav x-data="{ open: false }" class="bg-white">

  <header id="header" class="header fixed-top d-flex align-items-center bg-white">

  <div class="d-flex align-items-center justify-content-between ">
    <div class="d-flex align-items-center justify-content-between mx-5">
      <a href="{{ route('info')}}" class="logo d-flex align-items-center text-decoration-none">
        <img src="{{ asset('assets/images/logo.png') }}" style="width: 40px; height: 40px;" alt="">
        <span class="d-none d-lg-block mx-3"><b>SP KidneyKids</b></span>
      </a>
    </div> 
  </div>

  

  <nav class="header-nav ms-auto">
    <ul class="d-flex align-items-center">
      <div class="dropdown">
            <button class="btn btn-white dropdown-toggle justify-content-center" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                  <div x-data="{{ json_encode(['name' => auth()->user()->name]) }}" x-text="name" x-on:profile-updated.window="name = $event.detail.name"></div>
                  </button>
                <ul class="dropdown-menu">
                <center>
                <li>                        
                    <x-dropdown-link :href="route('profile')" wire:navigate style="text-decoration: none;">
                    {{ __('Profil') }}
                    </x-dropdown-link></li>
                  <li><a class="dropdown-item text-primary mx-2" href="{{ route('diagnosis')}}">Diagnosis</a></li>
                  <li><a class="dropdown-item text-primary mx-2" href="{{ route('riwayat')}}">Riwayat Diagnosis</a></li>
                  <li>
                      <button  data-bs-toggle="modal" data-bs-target="#keluar"  style="text-decoration: none; border: none;  background-color: transparent;">
                      <x-dropdown-link  style="text-decoration: none; ">
                          {{ __('Keluar') }}
                      </x-dropdown-link>
                      </button>
                  </li>
                </center>
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
        
  




