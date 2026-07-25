<x-app-layout>
<style>
    .tm-hero {
        position: relative;
        border-radius: 22px;
        overflow: hidden;
        box-shadow: 0 16px 40px rgba(15, 23, 42, 0.1);
        background: #fff;
        border: 1px solid rgba(226, 232, 240, .85);
    }

    .tm-hero-cover {
        position: relative;
        height: 280px;
        background:
            linear-gradient(135deg, #1d4ed8, #0ea5e9 55%, #38bdf8);
        overflow: hidden;
    }

    .tm-hero-cover img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .tm-hero-cover::after {
        content: "";
        position: absolute;
        inset: 0;
        background: linear-gradient(180deg, rgba(15, 23, 42, 0.05) 0%, rgba(15, 23, 42, 0.55) 100%);
    }

    .tm-hero-body {
        padding: 1.5rem 1.75rem 1.75rem;
    }

    .tm-badge {
        display: inline-flex;
        align-items: center;
        gap: .4rem;
        padding: .45rem .85rem;
        border-radius: 999px;
        font-size: .82rem;
        font-weight: 700;
        background: #eff6ff;
        color: #1d4ed8;
        border: 1px solid #dbeafe;
    }

    .tm-badge.soft {
        background: #f8fafc;
        color: #475569;
        border-color: #e2e8f0;
    }

    .tm-title {
        font-size: 1.75rem;
        font-weight: 800;
        letter-spacing: -0.03em;
        color: #0f172a;
        margin: .85rem 0 .5rem;
        line-height: 1.25;
    }

    .tm-meta {
        display: flex;
        flex-wrap: wrap;
        gap: .75rem 1.25rem;
        color: #64748b;
        font-size: .92rem;
        margin-bottom: 1rem;
    }

    .tm-meta i {
        color: #2563eb;
        margin-right: .35rem;
    }

    #description {
        overflow: hidden;
        display: -webkit-box;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 3;
        color: #475569;
        line-height: 1.75;
        margin-bottom: .35rem;
    }

    #description.show {
        -webkit-line-clamp: unset;
    }

    #toggle {
        cursor: pointer;
        color: #2563eb;
        font-weight: 700;
        text-decoration: none;
        display: inline-block;
        margin-top: .15rem;
    }

    #toggle:hover {
        color: #1d4ed8;
        text-decoration: underline;
    }

    .tm-section-head {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        align-items: end;
        gap: 1rem;
        margin: 1.75rem 0 1rem;
    }

    .tm-section-head h2 {
        font-size: 1.25rem;
        font-weight: 800;
        color: #0f172a;
        margin: 0 0 .2rem;
        letter-spacing: -0.02em;
    }

    .tm-section-head p {
        margin: 0;
        color: #64748b;
        font-size: .92rem;
    }

    .tm-episode {
        background: #fff;
        border: 1px solid rgba(226, 232, 240, .9) !important;
        border-radius: 16px !important;
        box-shadow: 0 8px 22px rgba(15, 23, 42, 0.05);
        margin-bottom: .85rem;
        transition: transform .18s ease, box-shadow .18s ease, background .18s ease;
        overflow: hidden;
    }

    .tm-episode:hover {
        transform: translateY(-2px);
        box-shadow: 0 14px 28px rgba(15, 23, 42, 0.09);
        background: #f8fbff;
    }

    .tm-episode-inner {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        padding: 1rem 1.15rem;
        flex-wrap: wrap;
    }

    .tm-episode-info {
        display: flex;
        align-items: center;
        gap: 1rem;
        min-width: 0;
        flex: 1 1 280px;
        text-decoration: none;
        color: inherit;
    }

    .tm-episode-thumb {
        width: 84px;
        height: 84px;
        border-radius: 14px;
        object-fit: cover;
        background: linear-gradient(135deg, #dbeafe, #e0f2fe);
        flex-shrink: 0;
        border: 1px solid #e2e8f0;
    }

    .tm-episode-thumb.placeholder {
        display: flex;
        align-items: center;
        justify-content: center;
        color: #2563eb;
        font-size: 1.4rem;
    }

    .tm-episode-title {
        font-size: 1.05rem;
        font-weight: 800;
        color: #0f172a;
        margin: 0 0 .25rem;
        line-height: 1.35;
    }

    .tm-episode-sub {
        color: #64748b;
        font-size: .88rem;
        margin: 0;
    }

    .tm-actions {
        display: flex;
        align-items: center;
        gap: .45rem;
        flex-shrink: 0;
    }

    .tm-actions .btn {
        width: 40px;
        height: 40px;
        padding: 0 !important;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px !important;
    }

    .tm-actions .btn-outline-primary {
        color: #2563eb !important;
        border-color: #93c5fd !important;
        background: #eff6ff !important;
    }

    .tm-actions .btn-outline-primary:hover {
        background: #2563eb !important;
        color: #fff !important;
    }

    .tm-actions .btn-outline-warning {
        color: #d97706 !important;
        border-color: #fcd34d !important;
        background: #fffbeb !important;
    }

    .tm-actions .btn-outline-warning:hover {
        background: #f59e0b !important;
        color: #fff !important;
        border-color: #f59e0b !important;
    }

    .tm-actions .btn-outline-danger {
        color: #dc2626 !important;
        border-color: #fca5a5 !important;
        background: #fef2f2 !important;
    }

    .tm-actions .btn-outline-danger:hover {
        background: #ef4444 !important;
        color: #fff !important;
    }

    .tm-add-card {
        border: 2px dashed #93c5fd !important;
        border-radius: 16px !important;
        background: linear-gradient(135deg, rgba(37, 99, 235, 0.04), rgba(14, 165, 233, 0.06));
        transition: .2s ease;
        text-decoration: none;
        display: block;
        margin-top: .5rem;
    }

    .tm-add-card:hover {
        border-color: #2563eb !important;
        background: linear-gradient(135deg, rgba(37, 99, 235, 0.08), rgba(14, 165, 233, 0.12));
        transform: translateY(-2px);
        text-decoration: none;
    }

    .tm-add-inner {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: .75rem;
        padding: 1.35rem 1rem;
        color: #2563eb;
        font-weight: 800;
    }

    .tm-add-inner i {
        width: 42px;
        height: 42px;
        border-radius: 12px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #2563eb, #0ea5e9);
        color: #fff;
        font-size: 1rem;
    }

    .tm-empty {
        text-align: center;
        padding: 2.5rem 1.25rem;
        background: #fff;
        border-radius: 16px;
        border: 1px solid #e2e8f0;
        color: #64748b;
    }

    .tm-empty .icon {
        font-size: 2.2rem;
        margin-bottom: .5rem;
    }

    @media (max-width: 576px) {
        .tm-hero-cover { height: 200px; }
        .tm-title { font-size: 1.35rem; }
        .tm-episode-thumb { width: 68px; height: 68px; }
    }
</style>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="pagetitle mx-2 mb-3">
                <h1>Detail Materi</h1>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Admin</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('materi') }}">Materi</a></li>
                        <li class="breadcrumb-item active">{{ $materi->title }}</li>
                    </ol>
                </nav>
            </div>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('danger'))
                <div class="alert alert-danger">{{ session('danger') }}</div>
            @endif

            <div class="mb-3">
                <a href="{{ route('materi') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left mr-1"></i> Kembali
                </a>
                <a href="{{ route('ubah-materi', $materi->id_materi) }}" class="btn btn-outline-primary ml-1">
                    <i class="fas fa-pen mr-1"></i> Ubah Materi
                </a>
            </div>

            {{-- Hero materi --}}
            <div class="tm-hero mb-4">
                <div class="tm-hero-cover">
                    @if(!empty($materi->img))
                        <img src="{{ asset($materi->img) }}" alt="{{ $materi->title }}"
                             onerror="this.style.display='none'">
                    @endif
                </div>
                <div class="tm-hero-body">
                    <div class="d-flex flex-wrap gap-2 mb-1">
                        <span class="tm-badge"><i class="fas fa-book-open"></i> Materi</span>
                        <span class="tm-badge soft"><i class="fas fa-list-ol"></i> {{ $hitung_episode }} Episode</span>
                        @if(!empty($materi->mapel?->nama_mapel))
                            <span class="tm-badge soft"><i class="fas fa-graduation-cap"></i> {{ $materi->mapel->nama_mapel }}</span>
                        @endif
                    </div>

                    <h2 class="tm-title">{{ $materi->title }}</h2>

                    <div class="tm-meta">
                        @if(!empty($materi->tgl))
                            <span><i class="far fa-calendar-alt"></i>{{ $materi->tgl }}</span>
                        @endif
                        @if(!empty($materi->guru?->name))
                            <span><i class="fas fa-chalkboard-teacher"></i>{{ $materi->guru->name }}</span>
                        @endif
                    </div>

                    @if(!empty($materi->deskripsi))
                        <p id="description">{{ $materi->deskripsi }}</p>
                        <a id="toggle">Lihat Selengkapnya</a>
                    @else
                        <p class="text-muted mb-0">Belum ada deskripsi untuk materi ini.</p>
                    @endif
                </div>
            </div>

            {{-- Daftar episode --}}
            <div class="tm-section-head">
                <div>
                    <h2>Daftar Episode</h2>
                    <p>Kelola episode materi ini — lihat, ubah atau hapus</p>
                </div>
            </div>

            @forelse ($episode as $ep)
                <div class="tm-episode">
                    <div class="tm-episode-inner">
                        <a href="{{ route('tampil-episode', $ep->id_eps) }}" class="tm-episode-info">
                            @if(!empty($ep->img))
                                <img src="{{ asset($ep->img) }}"
                                     alt="{{ $ep->nama_eps }}"
                                     class="tm-episode-thumb"
                                     onerror="this.classList.add('d-none'); this.nextElementSibling.classList.remove('d-none');">
                                <div class="tm-episode-thumb placeholder d-none">
                                    <i class="fas fa-play"></i>
                                </div>
                            @else
                                <div class="tm-episode-thumb placeholder">
                                    <i class="fas fa-play"></i>
                                </div>
                            @endif
                            <div class="min-w-0">
                                <h5 class="tm-episode-title">
                                    Episode {{ $ep->type }} · {{ $ep->nama_eps }}
                                </h5>
                                <p class="tm-episode-sub">
                                    <i class="far fa-clock mr-1"></i>{{ $ep->tgl ?? 'Tanpa tanggal' }}
                                </p>
                            </div>
                        </a>

                        <div class="tm-actions">
                            <a href="{{ route('tampil-episode', $ep->id_eps) }}"
                               class="btn btn-outline-primary"
                               title="Lihat episode">
                                <i class="far fa-eye"></i>
                            </a>
                            <a href="{{ route('ubah-episode', $ep->id_eps) }}"
                               class="btn btn-outline-warning"
                               title="Ubah episode">
                                <i class="far fa-edit"></i>
                            </a>
                            <button type="button"
                                    class="btn btn-outline-danger"
                                    data-toggle="modal"
                                    data-target="#hapus{{ $ep->id_eps }}"
                                    data-bs-toggle="modal"
                                    data-bs-target="#hapus{{ $ep->id_eps }}"
                                    title="Hapus episode">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Modal hapus --}}
                <div class="modal fade" id="hapus{{ $ep->id_eps }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Hapus Episode</h5>
                                <button type="button" class="close" data-dismiss="modal" data-bs-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                Apakah Anda yakin ingin menghapus episode
                                <strong>{{ $ep->nama_eps }}</strong>?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal" data-bs-dismiss="modal">
                                    Batal
                                </button>
                                <form action="{{ route('hapus_episode', $ep->id_eps) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Hapus</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="tm-empty mb-3">
                    <div class="icon">📭</div>
                    <h5 class="font-weight-bold text-dark mb-1">Belum ada episode</h5>
                    <p class="mb-3">Episode untuk materi ini belum ditambahkan.</p>
                    <a href="{{ route('tambah-episode', $materi->id_materi) }}" class="btn btn-primary">
                        <i class="fas fa-plus mr-1"></i> Tambah Episode Pertama
                    </a>
                </div>
            @endforelse

            @if($episode->count() > 0)
                <a href="{{ route('tambah-episode', $materi->id_materi) }}" class="tm-add-card">
                    <div class="tm-add-inner">
                        <i class="fas fa-plus"></i>
                        <span>Tambah Episode Baru</span>
                    </div>
                </a>
            @endif

            <div class="mb-5"></div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const desc = document.getElementById('description');
    const toggle = document.getElementById('toggle');
    if (desc && toggle) {
        toggle.addEventListener('click', function () {
            desc.classList.toggle('show');
            toggle.innerText = desc.classList.contains('show')
                ? 'Lihat Lebih Sedikit'
                : 'Lihat Selengkapnya';
        });
    }
});
</script>
</x-app-layout>
