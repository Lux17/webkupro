<x-app-layout>
  <div class="content-wrapper">
    <div class="content-header">
    <div class="container-fluid">
    <section class="content">
      <div class="container-fluid">
      <div class="container z-1">
      <div class="pagetitle mx-3">
          <h1>Data Laporan Hasil Diagnosis</h1>
          <nav class="mb-3">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="#">Admin</a></li>
              <li class="breadcrumb-item active">Laporan Hasil Diagnosis</li>
            </ol>
          </nav>
        </div>
    
        <section class="content mb-5">
        <div class="container z-1">
            <form class="d-flex mx-2" method="get" action="{{ route('cari_hasil') }}">
              <input class="form-control me-2" type="text" name="search" placeholder="Cari ID Pengguna" aria-label="Search">
              <button class="btn btn-outline-success" type="submit">Cari</button>
            </form>
            <!-- Session/Notif -->
            <div class="container">
                <div class="row">
            <div class="list-penyakit my-4 mb-5  table-responsive">
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
                  <!-- Tabel simple -->
                  <div class="row my-3">
                    <div class="col-12">
                      <div class="card">
                        <div class="card-header">
                          <h3 class="card-title">Tabel Data Hasil Diagnosis</h3>
                          <div class="card-tools">
                            <div class="input-group input-group-sm" style="width: 150px;">
                            </div>
                          </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0">
                          <table class="table table-hover">
                            <thead>
                        <tr>
                          <th scope="col" >No</th>
                          <th scope="col">ID</th>
                          <th scope="col">ID Pengguna</th>
                          <th scope="col">Jenis Penyakit</th>
                          <th scope="col">Persentase</th>
                          <th scope="col" colspan="2"  class="text-center">Aksi</th>
                          <th></th>
                          <th></th>
                        </tr>
                      </thead>
                      <tbody>
                      @foreach ($hasil_diagnosis as $hasil)
                        <tr>
                          <th scope="row">{{ $loop->iteration }}</th>
                          <td>{{ $hasil->kode_hasil }}</td>
                          <td>{{ $hasil->idpengguna }}</td>
                          <td>{{ $hasil->penyakit }}</td>
                          <td>{{ intval($hasil->nilai_hasil) }}%</td>
                          <td>
                          <a class="dropdown-item btn text-primary mx-0" style="width: 5px;" href="{{ route('laporanhasil', $hasil->id_hasil) }}">Rincian</a>
                          </td>
                          <td>
                            <a class="dropdown-item btn text-danger" style="width: 5px;" data-bs-toggle="modal" data-bs-target="#hapus{{ $hasil->id_hasil }}" href="#">Hapus</a>
                          </td>
                          <td></td>
                          <td></td>

                           <!-- Modal Hapus -->
                            <div class="modal fade" id="hapus{{ $hasil->id_hasil }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                              <div class="modal-dialog">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="hapusLabel">Hapus Data Hasil Diagnosis</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                  </div>
                                  <div class="modal-body">
                                    Apakah Anda Yakin Ingin Menghapus Data Ini?
                                  </div>
                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                    <form action="{{ route('hapus_hasil', $hasil->id_hasil) }}" method="POST"
                                      style="display: inline-block;">
                                      @csrf
                                      @method('delete')
                                    <button type="submit" class="btn btn-danger ">Hapus</button>
                                    </form>
                                  </div>
                                </div>
                              </div>
                            </div>

                          @endforeach
                        </tr>
                      </tbody>
                </table>
            </div>
            <!-- Pagination -->
            <div class="d-flex justify-content-center">
                  {{ $hasil_diagnosis->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </section>
      
        
    </section>
  </div>
  </div>
      </div>
    </section>
  </div>


  <footer class="main-footer">
    <strong>Copyright &copy; 2024 <a href="#">Sistem Pakar Ginjal Anak. Created by Lucky Saputra</a>.</strong>
    All rights reserved.
  </footer>

  </main>
</x-app-layout>


