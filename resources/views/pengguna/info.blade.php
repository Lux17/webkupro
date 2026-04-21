<x-user-layout>

<section id="info" class="bg-light">
<style>
      .button-lanjut {
      position: relative;
      transition: all 0.3s ease-in-out;
      box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.2);
      padding-block: 0.5rem;
      padding-inline: 1.25rem;
      background-color: rgb(0 107 179);
      border-radius: 9999px;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      color: #ffff;
      gap: 10px;
      font-weight: bold;
      border: 3px solid #ffffff4d;
      outline: none;
      overflow: hidden;
      font-size: 15px;
    }

    .icon-lanjut {
      width: 24px;
      height: 24px;
      transition: all 0.3s ease-in-out;
    }

    .button-lanjut:hover {
      transform: scale(1.05);
      border-color: #fff9;
    }

    .button-lanjut:hover .icon {
      transform: translate(4px);
    }

    .button-lanjut:hover::before {
      animation: shine 1.5s ease-out infinite;
    }

    .button-lanjut::before {
      content: "";
      position: absolute;
      width: 100px;
      height: 100%;
      background-image: linear-gradient(
        120deg,
        rgba(255, 255, 255, 0) 30%,
        rgba(255, 255, 255, 0.8),
        rgba(255, 255, 255, 0) 70%
      );
      top: 0;
      left: -100px;
      opacity: 0.6;
    }

    @keyframes shine {
      0% {
        left: -100px;
      }

      60% {
        left: 100%;
      }

      to {
        left: 100%;
      }
    }

    </style>
    
        <div class="container">
          </div>
          <div class="d-flex justify-content-center align-items-center ">
          </div>
        <div class="bg-info border p-4 rounded bg-white " style="max-width: auto;">
          <div class="container justify-content-center align-items-center">
            <center>
              <div class="my-5 justify-content-center align-items-center " style="width: autopx;">
                <div class="progress ">
                <div class="progress-bar" role="progressbar" style="width: 32%;" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <div class="container mt-2">
                <div class="row">
                <div class="col">
                <span class="text-primary text-informasi">Informasi Diagnosis</span>
                </div>
                <div class="col">
                <span class="text-warning text-informasi">Pertanyaan</span>
                </div>
                <div class="col">
                <span class="text-success text-informasi">Hasil Diagnosis</span>
                </div>
                </div>
              </div>
            </center>
            <center>
              <h1>Sistem Pakar Diagnosis Penyakit Ginjal Anak</h1>
              <h5 class="mb-2">Cek dan kenali gejala penyakit ginjal pada anak-anak untuk mengurangi dampak yang lebih serius</h5>
              <button class="button-lanjut my-3 mb-5" href="{{ route('diagnosis') }}" >
                <a  class="text-decoration-none text-white" href="{{ route('diagnosis') }}">Mulai Diagnosa</a>
              </button>
            </center>
            <h1 class="text-center text-primary mb-4">Pertanyaan yang Sering Diajukan - FAQ</h1>
            <div class="accordion" id="accordionPanelsStayOpenExample">
            <div class="accordion-item">
              <h2 class="accordion-header">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">
                  Apa itu Sistem Pakar Diagnosis Penyakit Ginjal Anak?
                </button>
              </h2>
              <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show">
                <div class="accordion-body">
                  <p>Sistem yang dapat diakses dengan mudah oleh pengguna untuk mengidentifikasi jenis penyakit ginjal yang dialami oleh anak-anak dan juga memberikan panduan/solusi tentang cara mengatasinya berdasarkan pengetahuan seorang ahli menggunakan metode Analitycal Hierarchy Process (AHP) dan Certainty Factor.</p>
                </div>
              </div>
            </div>
            <div class="accordion-item">
              <h2 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="false" aria-controls="panelsStayOpen-collapseTwo">
                  Siapa yang bisa mengakses sistem pakar?
                </button>
              </h2>
              <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse">
                <div class="accordion-body">
                  <p>Hanya pengguna yang sudah memiliki akun dan admin/dokter yang mengelola sistem yang dapat mengaksesnya.</p>
                </div>
              </div>
            </div>
            <div class="accordion-item">
              <h2 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseThree" aria-expanded="false" aria-controls="panelsStayOpen-collapseThree">
                  Apakah Hasil Screening/Diagnosis Sistem dapat diandalkan?
                </button>
              </h2>
              <div id="panelsStayOpen-collapseThree" class="accordion-collapse collapse">
                <div class="accordion-body">
                  <p>Hasil diagnosis dapat diandalkan karena sistem menggunakan metode AHP dan Certainty Factor , memberikan tingkat keyakinan terhadap diagnosis yang diberikan dengan bantuan pakar sistem ini dapat berjalan dengan baik.</p>
                </div>
              </div>
            </div>
            <div class="accordion-item">
              <h2 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapsefour" aria-expanded="false" aria-controls="panelsStayOpen-collapseThree">
                  Bagaimana Cara mendapatkan Solusi penanganan Penyakit?
                </button>
              </h2>
              <div id="panelsStayOpen-collapsefour" class="accordion-collapse collapse">
                <div class="accordion-body">
                 <p>Setelah mengisi formulir, pengguna akan menerima solusi sesuai dengan penyakit ginjal pada anak yang terdeteksi. Kami juga menyediakan saran dalam penanganan penyakit ginjal pada anak.</p>
                </div>
              </div>
            </div>
          </div>

          </div>
        </div>

    </section>
    


    
<!-- footer -->
<footer class="footer bg-dark text-white">
      <div class="container text-center">
        <br>
        <span>© Copyright 2024 Sistem Pakar Ginjal Anak. Created by Lucky Saputra</span>
      </div>
      <br>
</footer>

</x-user-layout>