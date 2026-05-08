<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah kuis</title>

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

    <!-- Form -->
    <form method="POST" action="{{ route('tambah-soal') }}">
        @csrf

        <div class="container mt-5" style="max-width: 1300px;">
        <div id="soal-wrapper">
            <!-- Soal pertama -->
            <div class="soal-item border p-3 mb-3">
        <input type="hidden" class="form-control" id="kode_kuis" value="{{ $kuis->kode_kuis }} " name="kode_kuis" readonly>
        <input type="hidden" class="form-control" id="id_mapel" value="{{ $kuis->id_mapel}} " name="id_mapel" readonly>
        <input type="hidden" class="form-control" id="id_guru" value="{{ $kuis->id_guru }} " name="id_guru" readonly>
        <input type="hidden" class="form-control" id="durasi" value="{{ $kuis->durasi }} " name="durasi" readonly>
        
                <input type="text" name="questions[0][pertanyaan]" placeholder="Pertanyaan" class="form-control mb-2">
                <label for="LabelInput" class="form-label ">Opsi Jawaban: </label>
                <input type="text" name="questions[0][opsi_a]" placeholder="Opsi A" class="form-control mb-1">
                <input type="text" name="questions[0][opsi_b]" placeholder="Opsi B" class="form-control mb-1">
                <input type="text" name="questions[0][opsi_c]" placeholder="Opsi C" class="form-control mb-1">
                <input type="text" name="questions[0][opsi_d]" placeholder="Opsi D" class="form-control mb-1">
                <input type="text" name="questions[0][opsi_e]" placeholder="Opsi E" class="form-control mb-2">
                <label for="LabelInput" class="form-label "> Jawaban Benar: </label>
                <select name="questions[0][jawaban]" class="form-control">
                    <option  selected >Pilih..</option>
                    <option value="a">A</option>
                    <option value="b">B</option>
                    <option value="c">C</option>
                    <option value="d">D</option>
                    <option value="e">E</option>
                </select>

                <button type="button" class="btn btn-danger btn-sm mt-2 hapus-soal">Hapus</button>
            </div>
        </div>

        <button type="button" id="tambah-soal" class="btn btn-success mb-3">
            + Tambah Soal
        </button>
        <br>
        <br>
        <button type="submit" class="btn btn-primary">
            Simpan Soal
        </button>


        </div>
    </form>


    <script>
    let index = 1;

    document.getElementById('tambah-soal').addEventListener('click', function() {

        let wrapper = document.getElementById('soal-wrapper');

        let html = `
        <div class="soal-item border p-3 mb-3">
        <input type="hidden" class="form-control" id="kode_kuis" value="{{ $kuis->kode_kuis }} " name="kode_kuis" readonly>
        <input type="hidden" class="form-control" id="id_mapel" value="{{ $kuis->id_mapel}} " name="id_mapel" readonly>
        <input type="hidden" class="form-control" id="id_guru" value="{{ $kuis->id_guru }} " name="id_guru" readonly>
        <input type="hidden" class="form-control" id="durasi" value="{{ $kuis->durasi }} " name="durasi" readonly> 
        <input type="text" name="questions[${index}][pertanyaan]" placeholder="Pertanyaan" class="form-control mb-2">
            <label for="LabelInput" class="form-label ">Opsi Jawaban: </label>
            <input type="text" name="questions[${index}][opsi_a]" placeholder="Opsi A" class="form-control mb-1">
            <input type="text" name="questions[${index}][opsi_b]" placeholder="Opsi B" class="form-control mb-1">
            <input type="text" name="questions[${index}][opsi_c]" placeholder="Opsi C" class="form-control mb-1">
            <input type="text" name="questions[${index}][opsi_d]" placeholder="Opsi D" class="form-control mb-1">
            <input type="text" name="questions[${index}][opsi_e]" placeholder="Opsi E" class="form-control mb-2">
            <label for="LabelInput" class="form-label ">Jawaban Benar: </label>
            <select name="questions[${index}][jawaban]" class="form-control">
            <option  selected >Pilih..</option>
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


    // hapus soal
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('hapus-soal')) {
            e.target.closest('.soal-item').remove();
        }
    });
    </script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>


</body>
</html>