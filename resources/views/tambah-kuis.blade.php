<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Soal Kuis</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('assets/css/app-ui.css') }}" rel="stylesheet">
    <style>
        body {
            background:
                radial-gradient(circle at top right, rgba(14, 165, 233, 0.1), transparent 25%),
                linear-gradient(180deg, #f8fbff 0%, #f8fafc 100%);
            min-height: 100vh;
        }
        .soal-item {
            background: #fff;
            border: 0 !important;
            border-radius: 18px !important;
            box-shadow: 0 12px 30px rgba(15, 23, 42, 0.08);
            padding: 1.25rem !important;
            margin-bottom: 1rem !important;
        }
        .page-shell {
            max-width: 960px;
            margin: 0 auto;
            padding: 1.5rem 1rem 3rem;
        }
    </style>
</head>
<body>
    <div class="page-shell">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <a class="btn btn-outline-primary" href="{{ route('kuis') }}">← Kembali</a>
        </div>

        <div class="ms-hero mb-4">
            <div class="ms-badge">📝 Tambah Soal</div>
            <h1 class="h3">{{ $kuis->nama_kuis ?? 'Kuis' }}</h1>
            <p class="mb-0">Kode: {{ $kuis->kode_kuis }} · Durasi: {{ $kuis->durasi }} menit</p>
        </div>

        <form method="POST" action="{{ route('tambah-soal') }}">
            @csrf
            <input type="hidden" value="{{ trim($kuis->kode_kuis) }}" name="kode_kuis">
            <input type="hidden" value="{{ trim((string)$kuis->id_mapel) }}" name="id_mapel">
            <input type="hidden" value="{{ trim((string)$kuis->id_guru) }}" name="id_guru">
            <input type="hidden" value="{{ trim((string)$kuis->durasi) }}" name="durasi">

            <div id="soal-wrapper">
                <div class="soal-item">
                    <div class="fw-bold mb-2">Soal 1</div>
                    <input type="text" name="questions[0][pertanyaan]" placeholder="Pertanyaan" class="form-control mb-2" required>
                    <label class="form-label">Opsi Jawaban</label>
                    <input type="text" name="questions[0][opsi_a]" placeholder="Opsi A" class="form-control mb-1" required>
                    <input type="text" name="questions[0][opsi_b]" placeholder="Opsi B" class="form-control mb-1" required>
                    <input type="text" name="questions[0][opsi_c]" placeholder="Opsi C" class="form-control mb-1">
                    <input type="text" name="questions[0][opsi_d]" placeholder="Opsi D" class="form-control mb-1">
                    <input type="text" name="questions[0][opsi_e]" placeholder="Opsi E" class="form-control mb-2">
                    <label class="form-label">Jawaban Benar</label>
                    <select name="questions[0][jawaban]" class="form-control" required>
                        <option value="">Pilih..</option>
                        <option value="a">A</option>
                        <option value="b">B</option>
                        <option value="c">C</option>
                        <option value="d">D</option>
                        <option value="e">E</option>
                    </select>
                    <button type="button" class="btn btn-danger btn-sm mt-3 hapus-soal">Hapus</button>
                </div>
            </div>

            <div class="d-flex flex-wrap gap-2 mt-2">
                <button type="button" id="tambah-soal" class="btn btn-success">+ Tambah Soal</button>
                <button type="submit" class="btn btn-primary">Simpan Soal</button>
            </div>
        </form>
    </div>

    <script>
    let index = 1;
    const meta = {
        kode_kuis: @json(trim($kuis->kode_kuis)),
        id_mapel: @json(trim((string)$kuis->id_mapel)),
        id_guru: @json(trim((string)$kuis->id_guru)),
        durasi: @json(trim((string)$kuis->durasi)),
    };

    document.getElementById('tambah-soal').addEventListener('click', function() {
        const wrapper = document.getElementById('soal-wrapper');
        const html = `
        <div class="soal-item">
            <div class="fw-bold mb-2">Soal ${index + 1}</div>
            <input type="text" name="questions[${index}][pertanyaan]" placeholder="Pertanyaan" class="form-control mb-2" required>
            <label class="form-label">Opsi Jawaban</label>
            <input type="text" name="questions[${index}][opsi_a]" placeholder="Opsi A" class="form-control mb-1" required>
            <input type="text" name="questions[${index}][opsi_b]" placeholder="Opsi B" class="form-control mb-1" required>
            <input type="text" name="questions[${index}][opsi_c]" placeholder="Opsi C" class="form-control mb-1">
            <input type="text" name="questions[${index}][opsi_d]" placeholder="Opsi D" class="form-control mb-1">
            <input type="text" name="questions[${index}][opsi_e]" placeholder="Opsi E" class="form-control mb-2">
            <label class="form-label">Jawaban Benar</label>
            <select name="questions[${index}][jawaban]" class="form-control" required>
                <option value="">Pilih..</option>
                <option value="a">A</option>
                <option value="b">B</option>
                <option value="c">C</option>
                <option value="d">D</option>
                <option value="e">E</option>
            </select>
            <button type="button" class="btn btn-danger btn-sm mt-3 hapus-soal">Hapus</button>
        </div>`;
        wrapper.insertAdjacentHTML('beforeend', html);
        index++;
    });

    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('hapus-soal')) {
            const items = document.querySelectorAll('.soal-item');
            if (items.length <= 1) {
                alert('Minimal satu soal harus ada.');
                return;
            }
            e.target.closest('.soal-item').remove();
        }
    });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
