<x-user-layout>

<style>
    .class-page {
        min-height: 100vh;
        background:
            radial-gradient(circle at top right, rgba(14, 165, 233, 0.1), transparent 25%),
            linear-gradient(180deg, #f8fbff 0%, #eef6ff 50%, #f8fafc 100%);
        padding: 7rem 0 4rem;
    }

    .class-hero {
        background: linear-gradient(135deg, #1d4ed8, #0ea5e9);
        border-radius: 24px;
        padding: 1.8rem 2rem;
        color: #fff;
        box-shadow: 0 16px 40px rgba(29, 78, 216, 0.2);
        margin-bottom: 2rem;
    }

    .class-hero h1 {
        font-size: 1.6rem;
        font-weight: 800;
        margin-bottom: .35rem;
    }

    .class-hero p {
        margin: 0;
        opacity: .9;
    }

    .materi-card {
        border: 0;
        border-radius: 18px;
        background: #fff;
        box-shadow: 0 12px 35px rgba(15, 23, 42, 0.08);
        transition: transform .2s ease, box-shadow .2s ease;
        overflow: hidden;
    }

    .materi-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 16px 40px rgba(15, 23, 42, 0.12);
    }

    .materi-card .card-body {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 1rem;
        padding: 1.25rem 1.4rem;
    }

    .materi-icon {
        width: 48px;
        height: 48px;
        border-radius: 14px;
        background: linear-gradient(135deg, #dbeafe, #e0f2fe);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        flex-shrink: 0;
    }

    .materi-title {
        font-weight: 800;
        color: #0f172a;
        margin: 0 0 .25rem;
        font-size: 1.05rem;
    }

    .materi-date {
        color: #64748b;
        font-size: .88rem;
        margin: 0;
    }

    .btn-lihat {
        border: 0;
        border-radius: 12px;
        padding: .65rem 1.1rem;
        font-weight: 700;
        background: linear-gradient(135deg, #2563eb, #0ea5e9);
        color: #fff;
        text-decoration: none;
        white-space: nowrap;
    }

    .btn-lihat:hover {
        color: #fff;
        opacity: .92;
    }

    .empty-state {
        background: #fff;
        border-radius: 22px;
        padding: 2.5rem 1.5rem;
        text-align: center;
        box-shadow: 0 12px 35px rgba(15, 23, 42, 0.08);
        color: #64748b;
    }
</style>

<section class="class-page">
    <div class="container">
        <div class="class-hero">
            <h1>📚 Daftar Materi</h1>
            <p>Pilih materi untuk mulai belajar. Setiap materi berisi episode dan konten pembelajaran.</p>
        </div>

        @forelse ($materi as $m)
            <div class="materi-card mb-3">
                <div class="card-body">
                    <div class="d-flex align-items-center gap-3">
                        <div class="materi-icon">📖</div>
                        <div>
                            <h5 class="materi-title">{{ $m->title }}</h5>
                            <p class="materi-date">Tanggal: {{ $m->tgl }}</p>
                        </div>
                    </div>
                    <a href="{{ route('lessons', $m->id_materi) }}" class="btn-lihat">Lihat Materi</a>
                </div>
            </div>
        @empty
            <div class="empty-state">
                <div style="font-size:2rem;margin-bottom:.75rem;">📭</div>
                <h5 class="fw-bold text-dark">Belum ada materi</h5>
                <p class="mb-0">Materi untuk mapel ini belum ditambahkan.</p>
            </div>
        @endforelse
    </div>
</section>

</x-user-layout>
