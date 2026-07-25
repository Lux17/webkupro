<header class="header fixed-top bg-white shadow-sm">
  <nav class="navbar navbar-expand-lg py-2">
    <div class="container">
      <a class="navbar-brand d-flex align-items-center gap-2" href="{{ url('/') }}">
        <img src="{{ asset('assets/images/icon-stem.png') }}" style="width: 42px; height: 42px;" alt="logo">
        <span class="fw-bold text-primary">MendungSTEM</span>
      </a>

      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <ul class="navbar-nav align-items-lg-center gap-lg-2">
          <li class="nav-item">
            <a class="nav-link fw-semibold" href="#about">Tentang</a>
          </li>
          @if (Route::has('login'))
            <livewire:welcome.navigation />
          @endif
        </ul>
      </div>
    </div>
  </nav>
</header>
