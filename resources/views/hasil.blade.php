<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil ujian</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
        body {
            background: linear-gradient(135deg, #eef2ff, #f8fafc);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .result-card {
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            background: #fff;
            border: none;
        }

        .score {
            font-size: 80px;
            font-weight: bold;
            color: #22c55e;
            line-height: 1;
            margin: 15px 0;
        }

        .icon-check {
            font-size: 60px;
        }

        .btn-custom {
            border-radius: 30px;
            padding: 10px 30px;
            font-weight: 600;
        }

        /* Memastikan footer tetap berada di paling bawah halaman */
        footer {
            margin-top: auto;
            background-color: #ffffff;
            border-top: 1px solid #e2e8f0;
        }
    </style>
</head>

<body>

    <!-- Navbar -->
<nav class="navbar bg-transparent">
        <div class="container-fluid mt-3 mb-3 mx-md-5 px-md-5">
            <a class="btn btn-danger btn-custom shadow-sm" href="{{ route('kuis') }}">Kembali</a>
        </div>
    </nav>

    <div class="container d-flex justify-content-center align-items-center flex-grow-1 my-5">
        <div class="col-12 col-md-6 col-lg-5">
            <div class="result-card text-center shadow">

                <div class="mb-3 icon-check">
                    ✅
                </div>

                <h2 class="fw-bold text-dark">Selamat!!!</h2>
                <p class="text-muted mb-1">Nilai anda adalah</p>

                <div class="score">
                    {{ $nilai2 }}
                </div>

                <div class="alert alert-success mt-4 border-0 shadow-sm">
                    <strong>Hebat!</strong><br>
                    Anda telah menyelesaikan kuis dengan baik.
                </div>

                <a href="{{ route('kuis') }}" class="btn btn-primary btn-custom mt-3 shadow-sm">
                    Kembali ke Beranda
                </a>

            </div>
        </div>
    </div>



    <!-- TinyMCE -->
    <script src="https://cdn.jsdelivr.net/npm/tinymce@6/tinymce.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>


</body>
</html>