@extends('landing.layouts.main')

@section('content')
@include('landing.partials.navbar')

<main class="main">
<style>
        .hero {
            background-image: url("{{ asset('assets/images/bg-awal.png') }}"); /* Ganti dengan path gambar yang diinginkan */
            background-size: 1100px; 
            background-position: center; 
        }
</style>


<section id="hero" class="hero section">
  <div class="container mb-5">
    <div class="row my-4">
      <div class="col-lg-6 order-2 my-5 order-lg-1 d-flex flex-column justify-content-center">
        <br>
        <br>
        <h1>MendungSTEM</h1>
        <p>Platform Komik Digital Berbasis Etno-STEM Mega Mendung</p>
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
                <h3>MendungSTEM - Platform Digital Berbasis Etno-STEM Mega Mendung</h3>
                <p>
                  MendungSTEM – Platform Digital Berbasis Etno-STEM Mega Mendung adalah media pembelajaran inovatif yang mengintegrasikan kearifan lokal budaya Indonesia dengan pendekatan sains modern melalui konsep Etno-STEM. Platform ini mengangkat motif khas Mega Mendung sebagai konteks budaya untuk menyajikan materi pembelajaran, khususnya pada topik green chemistry, dalam bentuk komik digital yang interaktif dan mudah dipahami oleh siswa. 
                </p>
              </div>
            </div>
            <div class="col-lg-6 d-flex align-items-center" >
              <img src="{{ asset('assets/img/guru.png') }}" class="img-fluid" alt="">
            </div>
          </div>
        </div>
    </section>

    </div>

  </div>

</section>
</main>

    </section>

  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>


  @endsection