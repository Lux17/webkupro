<x-user-layout>

<style>
    :root {
        --stem-primary: #1d4ed8;
        --stem-secondary: #0ea5e9;
        --stem-accent: #10b981;
        --stem-soft: #f0f9ff;
        --stem-dark: #0f172a;
        --stem-muted: #64748b;
        --stem-card: #ffffff;
        --stem-shadow: 0 12px 40px rgba(15, 23, 42, 0.08);
    }

    .user-dashboard {
        min-height: 100vh;
        background:
            radial-gradient(circle at top right, rgba(14, 165, 233, 0.12), transparent 28%),
            radial-gradient(circle at top left, rgba(16, 185, 129, 0.1), transparent 24%),
            linear-gradient(180deg, #f8fbff 0%, #eef6ff 45%, #f8fafc 100%);
        padding: 7rem 0 4rem;
    }

    .hero-panel {
        background: linear-gradient(135deg, #0f172a 0%, #1d4ed8 55%, #0ea5e9 100%);
        border-radius: 28px;
        padding: 2.2rem;
        color: #fff;
        box-shadow: 0 20px 50px rgba(29, 78, 216, 0.25);
        position: relative;
        overflow: hidden;
    }

    .hero-panel::before {
        content: "";
        position: absolute;
        width: 220px;
        height: 220px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.08);
        top: -60px;
        right: -40px;
    }

    .hero-panel::after {
        content: "";
        position: absolute;
        width: 140px;
        height: 140px;
        border-radius: 50%;
        background: rgba(16, 185, 129, 0.18);
        bottom: -40px;
        left: 40%;
    }

    .hero-badge {
        display: inline-flex;
        align-items: center;
        gap: .5rem;
        background: rgba(255, 255, 255, 0.14);
        border: 1px solid rgba(255, 255, 255, 0.18);
        padding: .45rem .9rem;
        border-radius: 999px;
        font-size: .85rem;
        margin-bottom: 1rem;
        backdrop-filter: blur(8px);
    }

    .hero-title {
        font-size: clamp(1.6rem, 3vw, 2.3rem);
        font-weight: 800;
        margin-bottom: .6rem;
        line-height: 1.2;
    }

    .hero-subtitle {
        color: rgba(255, 255, 255, 0.85);
        max-width: 640px;
        margin-bottom: 0;
    }

    .stat-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1rem;
        margin-top: 1.5rem;
    }

    .stat-card {
        background: rgba(255, 255, 255, 0.12);
        border: 1px solid rgba(255, 255, 255, 0.16);
        border-radius: 18px;
        padding: 1rem 1.1rem;
        backdrop-filter: blur(8px);
    }

    .stat-card h3 {
        font-size: 1.6rem;
        font-weight: 800;
        margin: 0;
    }

    .stat-card p {
        margin: 0;
        font-size: .85rem;
        color: rgba(255, 255, 255, 0.8);
    }

    .section-head {
        display: flex;
        justify-content: space-between;
        align-items: end;
        gap: 1rem;
        margin: 2.5rem 0 1.25rem;
    }

    .section-head h2 {
        font-size: 1.35rem;
        font-weight: 800;
        color: var(--stem-dark);
        margin: 0;
    }

    .section-head p {
        margin: .25rem 0 0;
        color: var(--stem-muted);
        font-size: .95rem;
    }

    .mapel-card {
        border: 0;
        border-radius: 22px;
        overflow: hidden;
        background: var(--stem-card);
        box-shadow: var(--stem-shadow);
        transition: transform .25s ease, box-shadow .25s ease;
        height: 100%;
        text-decoration: none;
        color: inherit;
        display: block;
    }

    .mapel-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 18px 45px rgba(15, 23, 42, 0.14);
        color: inherit;
    }

    .mapel-top {
        min-height: 140px;
        padding: 1.25rem;
        color: #fff;
        position: relative;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .mapel-top .icon-bubble {
        width: 44px;
        height: 44px;
        border-radius: 14px;
        background: rgba(255, 255, 255, 0.18);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
    }

    .mapel-top h5 {
        margin: 0;
        font-weight: 800;
        font-size: 1.1rem;
    }

    .mapel-top small {
        opacity: .9;
    }

    .mapel-body {
        padding: 1.15rem 1.25rem 1.35rem;
    }

    .teacher-chip {
        display: inline-flex;
        align-items: center;
        gap: .5rem;
        background: #f1f5f9;
        color: #334155;
        border-radius: 999px;
        padding: .4rem .8rem;
        font-size: .85rem;
        font-weight: 600;
    }

    .mapel-action {
        margin-top: 1rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        color: var(--stem-primary);
        font-weight: 700;
        font-size: .92rem;
    }

    .theme-blue { background: linear-gradient(135deg, #2563eb, #38bdf8); }
    .theme-green { background: linear-gradient(135deg, #059669, #34d399); }
    .theme-orange { background: linear-gradient(135deg, #ea580c, #fbbf24); }
    .theme-purple { background: linear-gradient(135deg, #7c3aed, #c084fc); }
    .theme-pink { background: linear-gradient(135deg, #db2777, #fb7185); }
    .theme-teal { background: linear-gradient(135deg, #0f766e, #2dd4bf); }

    .quiz-card {
        border: 0;
        border-radius: 20px;
        background: #fff;
        box-shadow: var(--stem-shadow);
        transition: transform .2s ease, box-shadow .2s ease;
        overflow: hidden;
        height: 100%;
    }

    .quiz-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 16px 40px rgba(15, 23, 42, 0.12);
    }

    .quiz-card .card-body {
        padding: 1.25rem 1.35rem;
        display: flex;
        flex-direction: column;
        gap: .85rem;
        height: 100%;
    }

    .quiz-meta {
        display: flex;
        flex-wrap: wrap;
        gap: .5rem;
    }

    .meta-pill {
        display: inline-flex;
        align-items: center;
        gap: .35rem;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        color: #475569;
        border-radius: 999px;
        padding: .35rem .7rem;
        font-size: .8rem;
        font-weight: 600;
    }

    .quiz-title {
        font-size: 1.05rem;
        font-weight: 800;
        color: var(--stem-dark);
        margin: 0;
    }

    .btn-start {
        margin-top: auto;
        border: 0;
        border-radius: 14px;
        padding: .7rem 1rem;
        font-weight: 700;
        background: linear-gradient(135deg, #2563eb, #0ea5e9);
        color: #fff;
        text-decoration: none;
        text-align: center;
        transition: opacity .2s ease, transform .2s ease;
    }

    .btn-start:hover {
        opacity: .92;
        color: #fff;
        transform: translateY(-1px);
    }

    .empty-state {
        background: #fff;
        border-radius: 22px;
        padding: 2.5rem 1.5rem;
        text-align: center;
        box-shadow: var(--stem-shadow);
        color: var(--stem-muted);
    }

    .empty-state .emoji {
        font-size: 2rem;
        margin-bottom: .75rem;
    }

    @media (max-width: 991px) {
        .stat-grid {
            grid-template-columns: 1fr;
        }

        .section-head {
            flex-direction: column;
            align-items: start;
        }
    }

    @media (max-width: 576px) {
        .user-dashboard {
            padding-top: 6rem;
        }

        .hero-panel {
            padding: 1.5rem;
            border-radius: 22px;
        }
    }
</style>

@php
    $totalMapel = $mapel->count();
    $totalKuis = $mapel->sum(fn ($m) => $m->kuis->count());
    $totalGuru = $mapel->pluck('guru.name')->filter()->unique()->count();
    $themes = ['theme-blue', 'theme-green', 'theme-orange', 'theme-purple', 'theme-pink', 'theme-teal'];
    $icons = ['📘', '🧪', '🧮', '🌍', '🎨', '🔬'];
@endphp

<section class="user-dashboard">
    <div class="container">
        <div class="hero-panel">
            <div class="position-relative" style="z-index: 1;">
                <div class="hero-badge">
                    <span>✨</span>
                    <span>Dashboard Siswa · MendungSTEM</span>
                </div>
                <h1 class="hero-title">
                    Halo, {{ auth()->user()->name }} 👋
                </h1>
                <p class="hero-subtitle">
                    Selamat datang di ruang belajar digital berbasis Etno-STEM. Pilih mata pelajaran untuk melihat materi, atau kerjakan kuis yang tersedia untuk kelasmu.
                </p>

                <div class="stat-grid">
                    <div class="stat-card">
                        <p>Mata Pelajaran</p>
                        <h3>{{ $totalMapel }}</h3>
                    </div>
                    <div class="stat-card">
                        <p>Kuis Tersedia</p>
                        <h3>{{ $totalKuis }}</h3>
                    </div>  
                </div>
            </div>
        </div>

        <div class="section-head">
            <div>
                <h2>Mata Pelajaran</h2>
                <p>Pilih mapel untuk membuka daftar materi pembelajaran</p>
            </div>
        </div>

        <div class="row g-4">
            @forelse ($mapel as $index => $m)
                @php
                    $theme = $themes[$index % count($themes)];
                    $icon = $icons[$index % count($icons)];
                @endphp
                <div class="col-md-6 col-lg-4">
                    <a href="{{ route('class', $m->id_mapel) }}" class="mapel-card">
                        <div class="mapel-top {{ $theme }}">
                            <div class="icon-bubble">{{ $icon }}</div>
                            <div>
                                <h5>{{ $m->nama_mapel }}</h5>
                                <small>{{ $m->kelas->nama_kelas ?? 'Kelas belum diatur' }}</small>
                            </div>
                        </div>
                        <div class="mapel-body">
                            <div class="teacher-chip">
                                <span>👨‍🏫</span>
                                <span>{{ $m->guru->name ?? 'Guru belum diatur' }}</span>
                            </div>
                            <div class="mapel-action">
                                <span>{{ $m->kuis->count() }} kuis</span>
                                <span>Buka Materi →</span>
                            </div>
                        </div>
                    </a>
                </div>
            @empty
                <div class="col-12">
                    <div class="empty-state">
                        <div class="emoji">📭</div>
                        <h5 class="fw-bold text-dark">Belum ada mata pelajaran</h5>
                        <p class="mb-0">Data mapel untuk kelasmu belum tersedia. Hubungi guru atau admin.</p>
                    </div>
                </div>
            @endforelse
        </div>

        <div class="section-head">
            <div>
                <h2>Daftar Kuis</h2>
                <p>Kerjakan kuis yang sudah dibuka oleh guru</p>
            </div>
        </div>

        <div class="row g-4">
            @php $adaKuis = false; @endphp

            @foreach ($mapel as $n)
                @foreach ($n->kuis as $k)
                    @php $adaKuis = true; @endphp
                    <div class="col-md-6 col-lg-4">
                        <div class="quiz-card">
                            <div class="card-body">
                                <div class="quiz-meta">
                                    <span class="meta-pill">📚 {{ $n->nama_mapel }}</span>
                                    <span class="meta-pill">⏱️ {{ $k->durasi }} menit</span>
                                </div>
                                <h3 class="quiz-title">{{ $k->nama_kuis }}</h3>
                                <div class="quiz-meta">
                                    <span class="meta-pill">🏫 {{ $n->kelas->nama_kelas ?? '-' }}</span>
                                    <span class="meta-pill">🧑‍🏫 {{ $n->guru->name ?? '-' }}</span>
                                </div>
                                <a href="{{ route('quiz', $k->kode_kuis) }}" class="btn-start">
                                    Mulai Kuis
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endforeach

            @unless ($adaKuis)
                <div class="col-12">
                    <div class="empty-state">
                        <div class="emoji">📝</div>
                        <h5 class="fw-bold text-dark">Belum ada kuis aktif</h5>
                        <p class="mb-0">Saat guru menambahkan kuis, daftarnya akan muncul di sini.</p>
                    </div>
                </div>
            @endunless
        </div>
    </div>
</section>

</x-user-layout>
