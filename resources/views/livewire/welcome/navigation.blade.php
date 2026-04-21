<nav class="mx-3 flex flex-1 justify-end">
    @auth
        @if(auth()->user()->rolename === 'admin')
            <a href="{{ url('/dashboard') }}"
            class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
                Dashboard
            </a>
        @else
            <a href="{{ url('/info') }}"
            class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
                Info
            </a>
        @endif
    @else
    <div class="collapse navbar-collapse justify-content-end ml-auto" id="navbarNav">
    <ul class="navbar-nav">
    <li class="nav-item mx-1">  
        <a
            href="{{ route('login') }}"
            class="btn btn-primary d-flex text-center justify-content-center"
        >
            Masuk
        </a>
    </li>
        @if (Route::has('register'))
        <li class="nav-item mx-1"> 
            <a
                href="{{ route('register') }}"
                class="btn btn-warning d-flex text-center justify-content-center"
            >
                Daftar
            </a>
            </li>
        @endif
        </ul>
        </div>
    @endauth
</nav>
