<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil ujian</title>

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

    <center>
        <h3>Selamat!!! nilai anda adalah  {{( $nilai2 )}}</h3>
    </center>
    </div>



    <!-- TinyMCE -->
    <script src="https://cdn.jsdelivr.net/npm/tinymce@6/tinymce.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>


</body>
</html>