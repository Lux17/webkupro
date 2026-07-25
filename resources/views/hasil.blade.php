<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Kuis</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('assets/css/app-ui.css') }}" rel="stylesheet">
</head>
<body class="user-surface d-flex flex-column min-vh-100">

<nav class="navbar">
    <div class="container">
        <a class="btn btn-outline-primary" href="{{ route('kuis') }}">← Kembali</a>
    </div>
</nav>

<div class="container d-flex justify-content-center align-items-center flex-grow-1 py-5">
    <div class="col-md-6 col-lg-5">
        <div class="card border-0 shadow text-center" style="border-radius:24px;">
            <div class="card-body p-4 p-md-5">
                <div style="font-size:3rem;">✅</div>
                <h2 class="fw-bold mt-2">Selamat!</h2>
                <p class="text-muted mb-2">Nilai anda adalah</p>
                <div class="display-3 fw-bold text-success mb-3">{{ $nilai2 }}</div>
                <div class="alert alert-success">
                    <strong>Hebat!</strong><br>
                    Anda telah menyelesaikan kuis dengan baik.
                </div>
                <a href="{{ route('kuis') }}" class="btn btn-primary px-4">Kembali ke Menu Kuis</a>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
