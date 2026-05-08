<x-user-layout>

<section id="info" class="bg-light d-flex flex-column min-vh-300">

    <style>
        body {
            background: linear-gradient(135deg, #eef2ff, #f8fafc);
            min-height: 100vh;
        }

        .result-card {
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            background: #fff;
        }

        .score {
            font-size: 80px;
            font-weight: bold;
            color: #22c55e;
        }

        .icon-check {
            font-size: 50px;
            color: #22c55e;
        }

        .btn-custom {
            border-radius: 30px;
            padding: 10px 25px;
        }
    </style>
    
        <div class="container">
          </div>
          <div class="d-flex justify-content-center align-items-center ">
          </div>
        <div class="bg-info border p-4 rounded bg-white " style="max-width: auto;">
          <div class="container justify-content-center align-items-center">
          
              <div class="my-5 justify-content-center align-items-center " style="width: autopx;">
 


<section style="height: 500px; ">



<div class="container d-flex justify-content-center align-items-center" style="min-height:100vh;">
    <div class="col-md-6">
        <div class="result-card text-center">

            <!-- Icon -->
            <div class="mb-3">
                ✅
            </div>

            <!-- Title -->
            <h2 class="fw-bold">Selamat!!!</h2>
            <p class="text-muted">nilai anda adalah</p>

            <!-- Score -->
            <div class="score">
                {{ $nilai2 }}
            </div>

            <!-- Info Box -->
            <div class="alert alert-success mt-4">
                <strong>Hebat!</strong><br>
                Anda telah menyelesaikan kuis dengan sempurna.
            </div>

            <!-- Button -->
            <a href="{{ route('info') }}" class="btn btn-primary btn-custom mt-3">
                Kembali ke Beranda
            </a>

        </div>
    </div>
</div>

  </div>
</section>
<!-- footer -->

  <footer class="main-footer">
    <strong>Copyright &copy; 2026 MendungSTEM<a href="#">  Created by Susanti</a>.</strong>
    All rights reserved.
  </footer>

</x-user-layout>