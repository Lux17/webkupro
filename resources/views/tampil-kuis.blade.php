<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Soal Kuis</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('assets/css/app-ui.css') }}" rel="stylesheet">
    <style>
        body {
            background:
                radial-gradient(circle at top right, rgba(14, 165, 233, 0.1), transparent 25%),
                linear-gradient(180deg, #f8fbff 0%, #f8fafc 100%);
            min-height: 100vh;
        }
        .page-shell {
            max-width: 920px;
            margin: 0 auto;
            padding: 1.5rem 1rem 3rem;
        }
    </style>
</head>
<body>
    <div class="page-shell">
        <div class="mb-3">
            <a class="btn btn-outline-primary" href="{{ route('kuis') }}">← Kembali</a>
        </div>

        <div class="ms-hero mb-4">
            <div class="ms-badge">👁️ Preview Soal</div>
            <h1 class="h3 mb-1">Data Soal Kuis</h1>
            <p class="mb-0">Tinjau soal dan kunci jawaban sebelum dibagikan ke siswa.</p>
        </div>

        @forelse($soal as $k)
            <div class="quiz-question-card">
                <div class="q-head d-flex align-items-start gap-2">
                    <span class="badge bg-light text-primary">{{ $loop->iteration }}</span>
                    <span>{{ $k->pertanyaan }}</span>
                </div>
                <div class="q-body">
                    <div class="d-grid gap-2">
                        @foreach (['a' => $k->opsi_a, 'b' => $k->opsi_b, 'c' => $k->opsi_c, 'd' => $k->opsi_d, 'e' => $k->opsi_e] as $key => $opsi)
                            @if(filled($opsi))
                                <div class="quiz-option-label {{ strtolower($k->jawaban) === $key ? 'border-success' : '' }}"
                                     style="{{ strtolower($k->jawaban) === $key ? 'border-color:#10b981 !important; background:#ecfdf5 !important;' : '' }}">
                                    <strong class="me-1">{{ strtoupper($key) }}.</strong> {{ $opsi }}
                                </div>
                            @endif
                        @endforeach
                    </div>
                    <div class="mt-3">
                        <span class="badge rounded-pill text-bg-success px-3 py-2">
                            Jawaban Benar: {{ strtoupper($k->jawaban) }}
                        </span>
                    </div>
                </div>
            </div>
        @empty
            <div class="card">
                <div class="card-body ms-empty">
                    <div class="emoji">📭</div>
                    <h5 class="fw-bold text-dark">Belum ada soal</h5>
                    <p class="mb-0">Tambahkan soal lewat tombol + atau upload Excel di menu kuis.</p>
                </div>
            </div>
        @endforelse
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
