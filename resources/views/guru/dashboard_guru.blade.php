<x-guru-layout>
  <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <section class="content">
          <div class="container-fluid">

            <div class="ms-hero">
              <div class="ms-badge">👨‍🏫 Dashboard Guru</div>
              <h1>Selamat datang, {{ $user->name }}!</h1>
              <p>Pantau kuis, kelas, dan aktivitas siswa yang kamu ampu di MendungSTEM.</p>
            </div>

            <div class="row g-3">
              <div class="col-lg-4 col-md-6">
                <div class="ms-stat stat-orange">
                  <div class="icon-wrap"><i class="fa-solid fa-list-check"></i></div>
                  <div class="label">Jumlah Kuis</div>
                  <div class="value">{{ $hitung_kuis }}</div>
                </div>
              </div>

              <div class="col-lg-4 col-md-6">
                <div class="ms-stat stat-blue">
                  <div class="icon-wrap"><i class="fas fa-school"></i></div>
                  <div class="label">Jumlah Kelas</div>
                  <div class="value">{{ $hitung_kelas }}</div>
                </div>
              </div>

              <div class="col-lg-4 col-md-6">
                <div class="ms-stat stat-green">
                  <div class="icon-wrap"><i class="fa-solid fa-users"></i></div>
                  <div class="label">Jumlah Siswa</div>
                  <div class="value">{{ $hitung_users }}</div>
                </div>
              </div>
            </div>

            <div class="row g-3 mt-1">
              <div class="col-md-6">
                <div class="card h-100">
                  <div class="card-body">
                    <h5 class="fw-bold mb-2">Kelola Kuis</h5>
                    <p class="text-muted mb-3">Buat kuis, unggah soal Excel, dan kelola soal dengan cepat.</p>
                    <a href="{{ route('kuis') }}" class="btn btn-primary btn-sm">Buka Menu Kuis</a>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="card h-100">
                  <div class="card-body">
                    <h5 class="fw-bold mb-2">Nilai Siswa</h5>
                    <p class="text-muted mb-3">Lihat hasil kuis dan ekspor rekap nilai ke Excel.</p>
                    <a href="{{ route('hasil-kuis') }}" class="btn btn-success btn-sm">Lihat Nilai Kuis</a>
                  </div>
                </div>
              </div>
            </div>

          </div>
        </section>
      </div>
    </div>
  </div>

  <footer class="main-footer">
    <strong>Copyright &copy; 2026 MendungSTEM <a href="#">Created by Susanti</a>.</strong>
    All rights reserved.
  </footer>
</x-guru-layout>
