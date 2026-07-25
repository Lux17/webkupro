<nav class="d-flex align-items-center gap-2 ms-lg-2">
    @auth
        @if(auth()->user()->rolename === 'admin')
            <a href="{{ url('/dashboard') }}" class="btn btn-primary btn-sm">Dashboard</a>
        @elseif(auth()->user()->rolename === 'guru')
            <a href="{{ url('/dashboard_guru') }}" class="btn btn-primary btn-sm">Dashboard Guru</a>
        @else
            <a href="{{ url('/info') }}" class="btn btn-primary btn-sm">Dashboard</a>
        @endif
    @else
        <a href="{{ route('login') }}" class="btn btn-primary btn-sm px-3">Masuk</a>
        @if (Route::has('register'))
            <a href="{{ route('register') }}" class="btn btn-warning btn-sm px-3 text-white">Daftar</a>
        @endif
    @endauth
</nav>
