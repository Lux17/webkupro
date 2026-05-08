<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ubah Materi</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar bg-body-tertiary">
        <div class="container-fluid mt-3 mb-3 mx-5 px-5">
            <a class="btn btn-danger" href="{{ route('materi') }}">Kembali</a>
        </div>
    </nav>
    <!-- Form -->
        <form action="{{ route('update_materi', $materi->id_materi) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="container mt-5" style="max-width: 1300px;">

            <!-- Judul Materi -->
            <div class="mb-4">
                <label for="InputNama" class="form-label">Judul Materi</label>
                <input type="text" class="form-control" name="title" value="{{ $materi->title }}"> 
            </div>

            <!-- Editor -->
            <div class="mb-4">
                <label for="InputNama" class="form-label">Materi</label>
                <textarea name="content" id="editor" value="{{ $materi->content}}"> {{ $materi->content}}</textarea>
            </div>
            <div>
                <input type="hidden" class="form-control" name="tgl" value="{{ now() }}">
            </div>           
             <div class="mb-3">
                <label for="InputNama" class="form-label">Mata Pelajaran</label>
                <select class="form-select form-control" id="id_mapel" name="id_mapel" value="{{ $materi->id_mapel }}" required>
                <option  selected >Pilih..</option>
                  @foreach ($mapel as $m)
                <option value="{{ $m->id_mapel }}">{{ $m->nama_mapel}} - {{ $m->id_guru }} </option>
                  @endforeach
                </select>
             </div>
            <!-- Button -->
            <div class="mb-5">
                <button type="submit" class="btn btn-primary btn-lg px-5">
                    Simpan
                </button>
            </div>
        </div>
    </form>

    <!-- TinyMCE -->
    <script src="https://cdn.jsdelivr.net/npm/tinymce@6/tinymce.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        tinymce.init({
            selector: '#editor',
            height: 500,
            plugins: 'image link media table code lists',
            toolbar: 'undo redo | styles | bold italic underline | alignleft aligncenter alignright | bullist numlist | image media table | code'
        });
    </script>

</body>
</html>