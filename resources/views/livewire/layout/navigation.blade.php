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

<nav x-data="{ open: false }" class="bg-white ">
     
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
  
  <!-- Right navbar links -->
  <!-- Left navbar links -->
  <ul class="navbar-nav mx-4">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
    </li>
  </ul>
    <ul class="navbar-nav ml-auto">
      <!-- Notifications Dropdown Menu -->




<nav class="header-nav ms-auto" style="margin-right:15px; ">
  <ul class="d-flex align-items-center">
  <div class="dropdown">
      <button class="btn btn-white dropdown-toggle justify-content-center" type="button" data-bs-toggle="dropdown" aria-expanded="false">
      <div x-data="{{ json_encode(['name' => auth()->user()->name]) }}" x-text="name" x-on:profile-updated.window="name = $event.detail.name"></div>
      </button>
      <ul class="dropdown-menu">
      <li class ="mx-2 mb-3">                        
      <x-dropdown-link :href="route('profile')" wire:navigate>
            {{ __('Profil') }}
      </x-dropdown-link>
      </li>

      <li>
          <button  data-bs-toggle="modal" data-bs-target="#keluar"  style="text-decoration: none; border: none;  background-color: transparent;">
          <x-dropdown-link >
              {{ __('Keluar') }}
          </x-dropdown-link>
          </button>
      </li>
      </ul>
  </div>
  </ul>

  </nav>
  


  <!-- /.navbar -->
     <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
  <div class="d-flex align-items-center justify-content-between mx-4 my-2">
  <div class="d-flex align-items-center justify-content-between ">
      <a href="#" class="logo d-flex align-items-center text-decoration-none">
        <img src="{{ asset('assets/images/logo.png') }}" style="width: 40px; height: 40px;" alt="">
        <span class="d-none d-lg-block mx-3"><b>SP KidneyKids</b></span>
      </a>
  </div> 
    <i class="bi bi-list toggle-sidebar-btn"></i>
  </div>
  <hr>
    <!-- Sidebar -->
    <div class="sidebar" style="color:white;">

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column " data-widget="treeview" role="menu" >
        <li class="nav-item has-treeview mb-2">
            <a class="nav-link {{ Route::currentRouteName() == 'dashboard' ? 'active' : 'collapsed'}}" href="{{ route('dashboard') }} ">
                <i class="nav-icon fas fa-tachometer-alt text-white"></i>
                <p class="text-white">
                    Dashboard
                </p>
            </a>
        </li>

        <div class="mx-3 mb-0">
          <p class="text-secondary">Kelola Data</p>
        </div>

        <li class="nav-item has-treeview my-0">
            <a class="nav-link {{ (Route::currentRouteName() == 'kelas' || Request::is('kelas/*'))  ? 'active' : 'collapsed'}}" href="{{ route('kelas') }}">
                <i class="nav-icon fa-solid fa-virus text-white "></i>
                <p  class="text-white">
                    Kelas
                </p>
            </a>
        </li>
        <li class="nav-item has-treeview my-0">
            <a class="nav-link {{ (Route::currentRouteName() == 'mapel' || Request::is('mapel/*'))  ? 'active' : 'collapsed'}}" href="{{ route('mapel') }}">
                <i class="nav-icon fa-solid fa-virus text-white "></i>
                <p  class="text-white">
                    Mata pelajaran
                </p>
            </a>
        </li>

        <li class="nav-item has-treeview my-0">
            <a class="nav-link ">
                <i class="nav-icon fa-solid fa-virus text-white"></i>
                <p  class="text-white">
                    Materi
                </p>
            </a>
        </li>

        
        <li class="nav-item has-treeview my-0">
            <a class="nav-link ">
                <i class="nav-icon fa-solid fa-virus text-white"></i>
                <p  class="text-white">
                    Kuis
                </p>
            </a>
        </li>

        <div class="mx-3">
          <p class="text-secondary">Analisis</p>
        </div>


        <div class="mx-3">
          <p class="text-secondary">Kelola Akun</p>
        </div>
        <li class="nav-item has-treeview">
            <a class="nav-link {{ (Route::currentRouteName() == 'pengguna' || Request::is('pengguna/*'))  ? 'active' : 'collapsed'}}" href="{{ route('pengguna') }}">
                <i class="nav-icon fa-solid fa-users text-white"></i>
                <p  class="text-white">
                    Siswa
                </p>
            </a>
        </li>

        <li class="nav-item has-treeview">
            <a class="nav-link {{ (Route::currentRouteName() == 'guru' || Request::is('guru/*'))  ? 'active' : 'collapsed'}}" href="{{ route('guru') }}">
                <i class="nav-icon fa-solid fa-users text-white"></i>
                <p  class="text-white">
                    Guru
                </p>
            </a>
        </li>


        <li class="nav-item has-treeview">
            <a class="nav-link {{ (Route::currentRouteName() == 'admin' || Request::is('admin/*'))  ? 'active' : 'collapsed'}}" href="{{ route('admin') }}">
                <i class="nav-icon fa-regular fa-user text-white"></i>
                <p  class="text-white">
                    Admin
                </p>
            </a>
        </li>

        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

</nav>


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


