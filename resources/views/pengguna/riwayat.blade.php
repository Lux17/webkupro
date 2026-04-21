<x-user-layout>
    
<main id="main" class="main">
    <section class="main-content mb-5">
      <div class="container z-1">
        <div class="pagetitle">
          <h1>Data Laporan Hasil Diagnosis</h1>
          <nav>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="#">Pengguna</a></li>
              <li class="breadcrumb-item active">Riwayat Hasil Diagnosis</li>
            </ol>
          </nav>
        </div>
    
        <section class="content mb-5">
        <div class="container z-1">
            <form class="d-flex mx-2" method="get" action="{{ route('cari_riwayat') }}">
              <input class="form-control me-2" type="text" name="search" placeholder="Cari ID Riwayat" aria-label="Search">
              <button class="btn btn-outline-success" type="submit">Cari</button>
            </form>

            <div class="container">
                <div class="row">
            <div class="list-penyakit my-4 mb-5 mx-2 table-responsive">
            @if(session('success'))
              <div class="alert alert-success">
            {{ session('success') }}
              </div>
            @endif
            @if(session('danger'))
              <div class="alert alert-danger">
            {{ session('danger') }}
              </div>
            @endif
                <hr>
                <table class="table table-hover">
                    <thead>
                        <tr>
                          <th scope="col">No</th>
                          <th scope="col">ID Diagnosis</th>
                          <th scope="col">ID Pengguna</th>
                          <th scope="col">Jenis Penyakit</th>
                          <th scope="col">Persentase</th>
                          <th scope="col">Tanggal</th>
                          <th scope="col" colspan="2">Aksi</th>
                        </tr>
                      </thead>
                      <tbody>
                      @foreach ($hasil_diagnosis as $hasil)
                        <tr>
                          <th scope="row">{{ $loop->iteration }}</th>
                          <td>{{ $hasil->kode_hasil }}</td>
                          <td>{{ $hasil->idpengguna }}</td>
                          <td>{{ $hasil->penyakit }}</td>
                          <td>{{ $hasil->nilai_hasil }}</td>
                          <td>{{ $hasil->tanggal }}</td>
                          <td>
                          <a class="dropdown-item btn text-primary" style="width: 5px;" href="{{ route('rincian', $hasil->kode_hasil) }}">Rincian</a>
                          </td>
                          <td>
                          </td>
                      @endforeach
                        </tr>
                      </tbody>
                </table>
            </div>
        </div>
    </section>
      


  <footer class="footer bg-dark text-white">
      <div class="container text-center">
        <br>
        <span>© Copyright 2024 Sistem Pakar Ginjal Anak. Created by Lucky Saputra</span>
      </div>
      <br>
  </footer>
 
        </div>
    </div>

  </main>
  
</x-user-layout>