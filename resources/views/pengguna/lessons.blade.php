<x-user-layout>

<style>
    .lessons-page {
        min-height: 100vh;
        background:
            radial-gradient(circle at top right, rgba(14, 165, 233, 0.1), transparent 25%),
            linear-gradient(180deg, #f8fbff 0%, #eef6ff 50%, #f8fafc 100%);
        padding: 6.5rem 0 3rem;
    }

    .comic-card {
        background: #fff;
        border-radius: 22px;
        box-shadow: 0 14px 40px rgba(15, 23, 42, 0.08);
        overflow: hidden;
    }

    .comic-card img.cover {
        width: 100%;
        max-height: 360px;
        object-fit: cover;
    }

    .episode-item {
        transition: .2s ease;
        border: 0 !important;
        border-radius: 14px !important;
        margin-bottom: .65rem;
        box-shadow: 0 8px 20px rgba(15, 23, 42, 0.05);
    }

    .episode-item:hover {
        transform: translateX(4px);
        background: #f8fbff !important;
    }

    .episode-thumb {
        width: 84px;
        height: 84px;
        object-fit: cover;
        border-radius: 12px;
        background: #e2e8f0;
    }

    #description {
        overflow: hidden;
        display: -webkit-box;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 3;
        color: #475569;
        line-height: 1.7;
    }

    #description.show {
        -webkit-line-clamp: unset;
    }

    #toggle {
        cursor: pointer;
        color: #2563eb;
        font-weight: 700;
        text-decoration: none;
    }
</style>

<section class="lessons-page">
    <div class="container">
        <div class="mb-3">
            <a href="{{ route('info') }}" class="btn btn-outline-primary">← Kembali ke Dashboard</a>
        </div>

        <div class="comic-card mb-4">
            @if(!empty($materi->img_materi))
                <img src="{{ asset($materi->img_materi) }}" class="cover" alt="{{ $materi->title }}">
            @endif

            <div class="p-4 p-md-5">
                <div class="d-flex flex-wrap gap-2 mb-3">
                    <span class="badge rounded-pill text-bg-primary px-3 py-2">Materi</span>
                    <span class="badge rounded-pill text-bg-light border px-3 py-2">📖 {{ $hitung_episode }} Episode</span>
                </div>

                <h1 class="fw-bold mb-2" style="letter-spacing:-0.02em;">{{ $materi->title }}</h1>
                <p id="description" class="mb-2">{{ $materi->deskripsi }}</p>
                <a id="toggle">Lihat Selengkapnya</a>
            </div>
        </div>

        <div class="d-flex justify-content-between align-items-end mb-3">
            <div>
                <h2 class="fw-bold mb-1 h4">Daftar Episode</h2>
                <p class="text-muted mb-0">Pilih episode untuk mulai membaca</p>
            </div>
        </div>

        <div class="list-group">
            @forelse ($episode as $ep)
                <a href="{{ route('tampil-episode', $ep->id_eps) }}" class="list-group-item list-group-item-action episode-item">
                    <div class="d-flex align-items-center gap-3 p-1">
                        <img src="{{ asset($ep->img) }}" class="episode-thumb" alt="{{ $ep->nama_eps }}"
                             onerror="this.style.display='none'">
                        <div class="flex-grow-1">
                            <h5 class="mb-1 fw-bold">Episode {{ $ep->type }} · {{ $ep->nama_eps }}</h5>
                            <small class="text-muted">{{ $ep->tgl }}</small>
                        </div>
                        <span class="text-primary fw-bold">Baca →</span>
                    </div>
                </a>
            @empty
                <div class="card">
                    <div class="card-body text-center text-muted py-5">
                        <div style="font-size:2rem;">📭</div>
                        <h5 class="fw-bold text-dark">Belum ada episode</h5>
                        <p class="mb-0">Episode untuk materi ini belum ditambahkan.</p>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</section>

<script>
const desc = document.getElementById('description');
const toggle = document.getElementById('toggle');
if (desc && toggle) {
    toggle.addEventListener('click', function () {
        desc.classList.toggle('show');
        toggle.innerText = desc.classList.contains('show') ? 'Lihat Lebih Sedikit' : 'Lihat Selengkapnya';
    });
}
</script>

</x-user-layout>
