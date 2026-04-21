@extends('landing.layouts.main')

@section('content')
@include('landing.partials.navbar')

<main class="main">
<style>
        .hero {
            background-image: url("{{ asset('assets/images/doctor.jpg') }}"); /* Ganti dengan path gambar yang diinginkan */
            background-size: cover; 
            background-position: center; 
        }
</style>


<section id="hero" class="hero section">
  <div class="container mb-5">
    <div class="row my-4">
      <div class="col-lg-6 order-2 my-5 order-lg-1 d-flex flex-column justify-content-center">
        <h1>Sistem Pakar Diagnosis Penyakit Ginjal Anak</h1>
        <p>Menggunakan Metode AHP dan Certainty Factor</p>
        <div class="d-flex">

          <a href="{{ route('diagnosis') }}" class="btn-get-started">Mulai Diagnosis</a>

        </div>
      </div>
      <div class="my-5">
      </div>
    </div>
  </div>

</section>



<section id="about" class="about section">

  <div class="container section-title" data-aos="fade-up">
    <h2>Tetang Sistem</h2>
    <p>Deskripsi dan penjelasan singkat tentang sistem ini</p>
  </div>

  <div class="container">
    <div class="row">
      <section id="tentang" class="bg-light">
        <div class="container" data-aos="fade-up" data-aos-delay="100" >
          <div class="row gx-0">
            <div class="col-lg-6 d-flex flex-column justify-content-center">
              <div class="content my-3 mx-2">
                <h3>Sistem Pakar Diagnosis Penyakit Ginjal Anak.</h3>
                <p>
                  Sistem pakar ini dibangun dengan menggunakan metode Analytical Hierarchy Process (AHP) sebagai penentu prioritas (bobot) dengan perbandingan berpasangan terhadap gejala pada penyakit yang ada dan Certainty Factor untuk menghitung presentase keyakinan keputusan, yang memungkinkan untuk melakukan diagnosis penyakit ginjal. Sistem ini berbasis web, sehingga memastikan kemudahan akses bagi pengguna dan dokter. 
                </p>
              </div>
            </div>
            <div class="col-lg-6 d-flex align-items-center" >
              <img src="{{ asset('assets/img/kidney2.png') }}" class="img-fluid" alt="">
            </div>
          </div>
        </div>
    </section>

    </div>

  </div>

</section>

<section id="stats" class="stats section">
  <div class="container" data-aos="fade-up" data-aos-delay="100">
    <div class="row gy-4 align-items-center">
      <div class="col-lg-5">
        <img src="{{ asset('assets/img/ginjal.jpg') }}" alt="" style="width: 500px" class="img-fluid">
      </div>
      <div class="col-lg-7">
        <div class="row gy-4">
          <div class="col-lg-6">
            <div class="stats-item d-flex">
              <div>
              <i class="fa-solid fa-earth-asia flex-shrink-0"></i>
                <h2 class="my-2 mb-0"><strong>189</strong></h2>
                <p><strong><span style="font-size: 20px;"></span>Kasus Ginjal Anak</strong> <span> di Indonesia 2022</span></p>
              </div>
            </div>
          </div>

          <div class="col-lg-6">
            <div class="stats-item d-flex">
              <div>
              <i class="fa-regular fa-hospital flex-shrink-0"></i> 
              <h2 class="my-2 mb-0"><strong>61</strong></h2>   
                <p><strong><span style="font-size: 20px;"> </span>Kasus Ginjal Anak</strong> <span>di Rumah Sakit Daerah Gunung Jati</span></p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>


<section id="services" class="services section">
  <div class="container section-title" data-aos="fade-up">
    <h2>Fitur & Keunggulan</h2>
    <p>Fitur atau keunggulan sistem pakar diagnosis penyakit ginjal anak</p>
  </div>

  <div class="container">
    <div class="row gy-4">
      <div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="100">
        <div class="service-item position-relative">
          <i class="bi bi-activity"></i>
          <h4><a href="" class="stretched-link">Diagnosis</a></h4>
          <p>Diagnosis jenis penyakit ginjal pada anak berdasarkan gejala-gejala yang muncul pada anak, dan berdasarkan pengetahuan Ahli/Dokter.</p>
        </div>
      </div>

      <div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="200">
        <div class="service-item position-relative">
          <i class="bi bi-bounding-box-circles"></i>
          <h4><a href="" class="stretched-link">Metode</a></h4>
          <p>Sistem ini menggunakan dua metode dalam pengambilan keputusan yaitu Analytical Hierarcy Process(AHP) & Certainty Factor</p>
        </div>
      </div>

      <div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="300">
        <div class="service-item position-relative">
          <i class="bi bi-calendar4-week"></i>
          <h4><a href="" class="stretched-link">Informasi</a></h4>
          <p>Memberikan Informasi kepada pengguna mengenai jenis-jenis penyakit ginjal pada anak.</p>
        </div>
      </div>

      <div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="400">
        <div class="service-item position-relative">
          <i class="bi bi-broadcast"></i>
          <h4><a href="" class="stretched-link">Solusi</a></h4>
          <p>Memberikan Solusi atau saran penanganan pada penyakit ginjal anak</p>
        </div>
      </div>
    </div>
  </div>
</section>


<section id="informasi" class="alt-services section">
  <div class="container" data-aos="fade-up" data-aos-delay="100">
    <div class="row gy-4">
      <div class="col-lg-6" data-aos="zoom-in" data-aos-delay="200">
        <div class="service-item position-relative">
          <div class="img">
            <img src="{{ asset('assets/img/penyakit/gagal.png') }}" class="img-fluid" alt="">
          </div>
          <div class="details">
            <a href="service-details.html" class="stretched-link">
              <h3>Gagal Ginjal</h3>
            </a>
            <p>Gagal ginjal akut adalah keadaan tiba-tiba di mana fungsi ginjal terganggu sehingga tidak mampu menyaring limbah dan cairan berlebih dari darah. Ini bisa disebabkan oleh beragam faktor seperti infeksi, cedera, atau gangguan aliran darah ke ginjal, Gejala yang mungkin timbul termasuk penurunan produksi urine, pembengkakan, kelelahan, dan mual.</p>
          </div>
        </div>
      </div>

      <div class="col-lg-6" data-aos="zoom-in" data-aos-delay="300">
        <div class="service-item position-relative">
          <div class="img">
            <img src="{{ asset('assets/img/penyakit/batu.png') }}" class="img-fluid" alt="">
          </div>
          <div class="details">
            <a href="service-details.html" class="stretched-link">
              <h3>Batu Ginjal</h3>
            </a>
            <p>Batu ginjal adalah pembentukan massa keras yang terdiri dari kristal yang terakumulasi dalam saluran kemih. Batu ini dapat menyebabkan nyeri parah saat melewati saluran kemih, serta gejala seperti demam, mual, dan darah dalam urine, Faktor risiko meliputi dehidrasi, konsumsi garam atau protein yang tinggi, dan riwayat keluarga.</p>
          </div>
        </div>
      </div>

      <div class="col-lg-6" data-aos="zoom-in" data-aos-delay="400">
        <div class="service-item position-relative">
          <div class="img">
            <img src="{{ asset('assets/img/penyakit/kanker.png') }}" class="img-fluid" alt="">
          </div>
          <div class="details">
            <a href="service-details.html" class="stretched-link">
              <h3>Kanker Ginjal</h3>
            </a>
            <p>Kanker ginjal merupakan pertumbuhan sel-sel ganas yang terjadi di dalam ginjal. Gejala kanker ginjal mungkin tidak terlihat pada tahap awal, tetapi gejala bisa mencakup darah dalam urine, nyeri punggung, penurunan berat badan yang tidak disengaja, dan kelelahan, Faktor risiko diantaranya terpapar asap rokok, obesitas, dan tekanan darah tinggi.</p>
          </div>
        </div>
      </div>

      <div class="col-lg-6" data-aos="zoom-in" data-aos-delay="500">
        <div class="service-item position-relative">
          <div class="img">
            <img src="{{ asset('assets/img/penyakit/isk2.png') }}" class="img-fluid" alt="">
          </div>
          <div class="details">
            <a href="service-details.html" class="stretched-link">
              <h3>Infeksi Saluran Kemih(ISK)</h3>
            </a>
            <p>dalah keadaan dimana organ dalam 
              sistem kemih terinfeksi, ini dapat terjadi pada salah satu bagian dari 
              sistem urine, seperti ginjal, kandung kemih, atau uretra. kondisi ini 
              timbul ketika bakteri yang mungkin awalnya nerada dibagian tubuh 
              lain seperti kandung kemih, berhasil berpindah dan menginfeksi 
              salah satu atau kedua ginjal.</p>
            <a href="service-details.html" class="stretched-link"></a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

</main>

    </section>

  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>


  @endsection