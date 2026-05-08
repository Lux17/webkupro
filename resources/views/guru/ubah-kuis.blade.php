<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ubah Kuis</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<!-- Navbar -->
<nav class="navbar bg-body-tertiary">
    <div class="container-fluid mt-3 mb-3 mx-5 px-5">
        <a class="btn btn-danger" href="{{ route('kuis') }}">Kembali</a>
    </div>
</nav>

<form method="POST" action="{{ route('ubah-soal', $kuis2->id_kuis) }}">
@csrf

<div class="container mt-5" style="max-width: 900px;">

    <!-- Hidden (cukup sekali) -->

    <input type="hidden" name="kode_kuis" value="{{ $kuis2->kode_kuis }}">
    <input type="hidden" name="id_mapel" value="{{ $kuis2->id_mapel }}">
    <input type="hidden" name="id_guru" value="{{ $kuis2->id_guru }}">
    <input type="hidden" name="durasi" value="{{ $kuis2->durasi }}">

    <div id="soal-wrapper">

        @foreach($soal as $i => $s)
        <div class="soal-item border p-3 mb-3">

            <input type="text" name="questions[{{ $i }}][pertanyaan]"
                value="{{ $s->pertanyaan }}"
                placeholder="Pertanyaan"
                class="form-control mb-2">

            <label class="form-label">Opsi Jawaban:</label>
            <input type="hidden" name="questions[{{ $i }}][id_soal]" value="{{ $s->id_soal }}">
            <input type="text" name="questions[{{ $i }}][opsi_a]" value="{{ $s->opsi_a }}" class="form-control mb-1" placeholder="Opsi A">
            <input type="text" name="questions[{{ $i }}][opsi_b]" value="{{ $s->opsi_b }}" class="form-control mb-1" placeholder="Opsi B">
            <input type="text" name="questions[{{ $i }}][opsi_c]" value="{{ $s->opsi_c }}" class="form-control mb-1" placeholder="Opsi C">
            <input type="text" name="questions[{{ $i }}][opsi_d]" value="{{ $s->opsi_d }}" class="form-control mb-1" placeholder="Opsi D">
            <input type="text" name="questions[{{ $i }}][opsi_e]" value="{{ $s->opsi_e }}" class="form-control mb-2" placeholder="Opsi E">

            <label class="form-label">Jawaban Benar:</label>
            <select name="questions[{{ $i }}][jawaban]" class="form-control">
                <option value="a" {{ $s->jawaban == 'a' ? 'selected' : '' }}>A</option>
                <option value="b" {{ $s->jawaban == 'b' ? 'selected' : '' }}>B</option>
                <option value="c" {{ $s->jawaban == 'c' ? 'selected' : '' }}>C</option>
                <option value="d" {{ $s->jawaban == 'd' ? 'selected' : '' }}>D</option>
                <option value="e" {{ $s->jawaban == 'e' ? 'selected' : '' }}>E</option>
            </select>
            <input type="hidden" class="deleted-id" value="{{ $s->id_soal }}">
            <input type="hidden" id="deleted_ids" name="deleted_ids">
            <button type="button" class="btn btn-danger btn-sm mt-2 hapus-soal">Hapus</button>

        </div>
        @endforeach

    </div>

    <button type="button" id="tambah-soal" class="btn btn-success mb-3">
        + Tambah Soal
    </button>

    <br><br>

    <button type="submit" class="btn btn-primary">
        Simpan Soal
    </button>

</div>
</form>



<script>
let index = {{ count($soal) }};

// tambah soal
document.getElementById('tambah-soal').addEventListener('click', function() {

    let wrapper = document.getElementById('soal-wrapper');

    let html = `
    <div class="soal-item border p-3 mb-3">

        <input type="text" name="questions[${index}][pertanyaan]"
            placeholder="Pertanyaan"
            class="form-control mb-2">

        <label class="form-label">Opsi Jawaban:</label>

        <input type="text" name="questions[${index}][opsi_a]" class="form-control mb-1" placeholder="Opsi A">
        <input type="text" name="questions[${index}][opsi_b]" class="form-control mb-1" placeholder="Opsi B">
        <input type="text" name="questions[${index}][opsi_c]" class="form-control mb-1" placeholder="Opsi C">
        <input type="text" name="questions[${index}][opsi_d]" class="form-control mb-1" placeholder="Opsi D">
        <input type="text" name="questions[${index}][opsi_e]" class="form-control mb-2" placeholder="Opsi E">

        <label class="form-label">Jawaban Benar:</label>
        <select name="questions[${index}][jawaban]" class="form-control">
            <option selected>Pilih..</option>
            <option value="a">A</option>
            <option value="b">B</option>
            <option value="c">C</option>
            <option value="d">D</option>
            <option value="e">E</option>
        </select>

        <button type="button" class="btn btn-danger btn-sm mt-2 hapus-soal">Hapus</button>
    </div>
    `;

    wrapper.insertAdjacentHTML('beforeend', html);
    index++;
});

// hapus soal (event delegation)
document.addEventListener('click', function(e) {
    if (e.target.classList.contains('hapus-soal')) {
        e.target.closest('.soal-item').remove();
    }
});



let deleted = [];

document.addEventListener('click', function(e) {
    if (e.target.classList.contains('hapus-soal')) {

        let item = e.target.closest('.soal-item');

        // ambil id_soal kalau ada
        let idInput = item.querySelector('.deleted-id');

        if (idInput) {
            deleted.push(idInput.value);
            document.getElementById('deleted_ids').value = deleted.join(',');
        }

        item.remove();
    }
});
</script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>