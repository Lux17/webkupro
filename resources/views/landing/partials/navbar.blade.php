<header class="header fixed-top">
      <nav class="navbar navbar-expand-lg ">
        <div class="container-fluid">
              <a class="navbar-brand mx-3" href="#" >
                <img src="{{ asset('assets/images/logo.png') }}" style="width: 40px; height: 40px;" alt="logo" class="mx-3 d-inline-block align-text-top">
                <span class="d-inline-block align-text-top text-primary ml-1"><b>SP KidneyKids</b></span>
              </a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse justify-content-end ml-auto" id="navbarNav">
            <ul class="navbar-nav">
              <li class="nav-item mx-2">
                <a class="nav-link" href="#informasi">Informasi</a>
              </li>
              <li class="nav-item mx-2">
                <a class="nav-link" href="#tentang">Tentang</a>
              </li>
              @if (Route::has('login')) 
              <livewire:welcome.navigation />
              @endif
              
              <li class="nav-item mx-5">
              </li>
            </ul>
          </div>
        </div>
      </nav>
    </header>