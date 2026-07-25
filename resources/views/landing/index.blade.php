@extends('landing.layouts.main')

@section('content')

<main class="main">
<section class="landing-hero">
  <div class="container">
    <div class="hero-content">
      <div class="eyebrow">✨ Platform Komik Digital · Etno-STEM</div>
      <h1>MendungSTEM</h1>
      <p>
        Platform pembelajaran komik digital berbasis Etno-STEM Mega Mendung
        untuk belajar sains dengan pendekatan budaya lokal yang interaktif dan menyenangkan.
      </p>
      <div class="d-flex flex-wrap gap-2">
        <a href="{{ route('login') }}" class="btn btn-light btn-lg px-4 fw-bold text-primary">Masuk</a>
        <a href="{{ route('register') }}" class="btn btn-outline-light btn-lg px-4 fw-bold">Daftar</a>
        <a href="#about" class="btn btn-outline-light btn-lg px-4">Pelajari</a>
      </div>
    </div>
  </div>
</section>

<section id="about" class="landing-about">
  <div class="container">
    <div class="text-center mb-4">
      <h2 class="fw-bold">Tentang Sistem</h2>
      <p class="text-muted mb-0">Deskripsi singkat platform pembelajaran MendungSTEM</p>
    </div>

    <div class="about-card">
      <div class="row g-0 align-items-stretch">
        <div class="col-lg-6">
          <div class="about-body h-100 d-flex flex-column justify-content-center">
            <h2>Belajar sains lewat budaya Mega Mendung</h2>
            <p>
              MendungSTEM adalah media pembelajaran inovatif yang mengintegrasikan kearifan lokal budaya Indonesia
              dengan pendekatan sains modern melalui konsep Etno-STEM. Platform ini mengangkat motif khas Mega Mendung
              sebagai konteks budaya untuk menyajikan materi pembelajaran, khususnya green chemistry, dalam bentuk
              komik digital yang interaktif dan mudah dipahami siswa.
            </p>
            <div class="d-flex flex-wrap gap-2 mt-2">
              <span class="badge rounded-pill text-bg-primary px-3 py-2">Materi Digital</span>
              <span class="badge rounded-pill text-bg-success px-3 py-2">Kuis Interaktif</span>
              <span class="badge rounded-pill text-bg-info px-3 py-2">Etno-STEM</span>
            </div>
          </div>
        </div>
        <div class="col-lg-6">
          <img src="{{ asset('assets/img/guru.png') }}" class="img-fluid" alt="MendungSTEM">
        </div>
      </div>
    </div>
  </div>
</section>
</main>

<a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

@endsection
