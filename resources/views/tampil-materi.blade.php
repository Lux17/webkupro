<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $materi->title }}</title>

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
    <div class="container mt-5 mx-5 p-4 border rounded">
    <p>tanggal: {{ $materi->tgl }} </p>
    <center> 
        <h3>{{ $materi->title }}-{{ $materi->id_mapel}}</h3>
    </center>
    <div class="materi">
    <p>
     {!! $materi->content !!}
    </p>
    </div>
    </div>



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