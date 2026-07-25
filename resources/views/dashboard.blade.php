<x-app-layout>
  <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <section class="content">
          <div class="container-fluid">

            <div class="ms-hero">
              <div class="ms-badge">📊 Dashboard Admin</div>
              <h1>Selamat datang, {{ $user->name }}!</h1>
              <p>Ringkasan data platform MendungSTEM untuk monitoring kelas, kuis, siswa dan guru.</p>
            </div>

            <div class="row g-3">
              <div class="col-lg-3 col-md-6">
                <div class="ms-stat stat-green">
                  <div class="icon-wrap"><i class="fas fa-school"></i></div>
                  <div class="label">Jumlah Kelas</div>
                  <div class="value">{{ $hitung_kelas }}</div>
                </div>
              </div>

              <div class="col-lg-3 col-md-6">
                <div class="ms-stat stat-blue">
                  <div class="icon-wrap"><i class="fa-solid fa-list-check"></i></div>
                  <div class="label">Jumlah Kuis</div>
                  <div class="value">{{ $hitung_kuis }}</div>
                </div>
              </div>

              <div class="col-lg-3 col-md-6">
                <div class="ms-stat stat-orange">
                  <div class="icon-wrap"><i class="fa-solid fa-users"></i></div>
                  <div class="label">Jumlah Siswa</div>
                  <div class="value">{{ $hitung_users }}</div>
                </div>
              </div>

              <div class="col-lg-3 col-md-6">
                <div class="ms-stat stat-red">
                  <div class="icon-wrap"><i class="fas fa-user-graduate"></i></div>
                  <div class="label">Jumlah Guru</div>
                  <div class="value">{{ $hitung_guru }}</div>
                </div>
              </div>
            </div>

            <div class="row g-3 mt-1">
              <div class="col-lg-4">
                <div class="card h-100">
                  <div class="card-body">
                    <h5 class="fw-bold mb-2">Kelola Data</h5>
                    <p class="text-muted mb-3">Kelola kelas, mapel, materi, dan kuis dari menu sidebar.</p>
                    <a href="{{ route('kelas') }}" class="btn btn-primary btn-sm">Buka Data Kelas</a>
                  </div>
                </div>
              </div>
              <div class="col-lg-4">
                <div class="card h-100">
                  <div class="card-body">
                    <h5 class="fw-bold mb-2">Nilai Kuis</h5>
                    <p class="text-muted mb-3">Pantau hasil kuis siswa dan ekspor ke Excel.</p>
                    <a href="{{ route('hasil-kuis') }}" class="btn btn-success btn-sm">Lihat Nilai</a>
                  </div>
                </div>
              </div>
              <div class="col-lg-4">
                <div class="card h-100">
                  <div class="card-body">
                    <h5 class="fw-bold mb-2">Pengguna</h5>
                    <p class="text-muted mb-3">Kelola data admin, guru, dan siswa terdaftar.</p>
                    <a href="{{ route('pengguna') }}" class="btn btn-outline-primary btn-sm">Data Siswa</a>
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
</x-app-layout>
