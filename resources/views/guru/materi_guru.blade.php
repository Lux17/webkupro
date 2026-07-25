<x-guru-layout>
  <div class="content-wrapper">
    <div class="content-header">
    <div class="container-fluid">
    <section class="content">
      <div class="container-fluid">
      <div class="container z-1 ">
                <div class="pagetitle mx-3 mb-3">
          <h1>Data Materi</h1>
          <nav>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ route('dashboard_guru') }}">Guru</a></li>
              <li class="breadcrumb-item active">Materi</li>
            </ol>
          </nav>
        </div>

        <section class="content mb-5">
        <div class="container z-1">
          <div class="row mb-3">
            <div class="col-lg-3 col-md-6">
              <div class="ms-stat stat-orange">
                <div class="icon-wrap"><i class="fas fa-book"></i></div>
                <div class="label">Jumlah Materi</div>
                <div class="value">{{ $hitung_materi }}</div>
              </div>
            </div>
          </div>

            <div class="ms-toolbar mx-2">
              <a class="btn btn-primary" href="{{ route('tambah-materi') }}">
                <i class="fas fa-plus me-1"></i> Tambah Data
              </a>
              <form class="ms-search" method="get" action="{{ route('search_materi') }}">
                <input class="form-control" type="text" name="search" placeholder="Cari nama materi..." aria-label="Search">
                <button class="btn btn-outline-success" type="submit">Cari</button>
              </form>
            </div>

            @if(session('success'))
              <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('danger'))
              <div class="alert alert-danger">{{ session('danger') }}</div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif


                  <!-- Tabel simple -->
                  <div class="row my-3">
                    <div class="col-12">
                      <div class="card">
                        <div class="card-header">
                          <h3 class="card-title">Tabel Data materi</h3>
                          <div class="card-tools">
                            <div class="input-group input-group-sm" style="width: 150px;">
                            </div>
                          </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0" style="height: 650px;">
                          <table class="table table-head-fixed">
                        <thead>
                        <tr>
                          <th scope="col">No</th>
                          <th scope="col">Cover</th>
                          <th scope="col">Judul Materi</th>   
                          <th scope="col">Tanggal</th>
                          <th scope="col">Mata Pelajaran</th>
                          <th scope="col" colspan="2" class="text-center" >Aksi</th>
                        </tr>
                      </thead>
                      <tbody>
                      @foreach ($materi as $g)
                        <tr>
                          <th scope="row">{{ $loop->iteration }}</th>
                            <td><img src="{{ asset($g->img) }}" class="img-thumbnail" style="width:60px; height: 60px" /></td>
                            <td>{{ $g->title }}</td>
                            <td>{{ $g->tgl}}</td>
                            <td>{{  $g->mapel->nama_mapel ?? '-' }}</td>
                            <td>
                              <a class="dropdown-item btn button-white" style="width: 5px;" href="{{ route('tampil-materi', $g->id_materi) }}" "><i class="fa-solid fa-pen-to-square" style="color: black;"></i></a>
                            </td>
                            <td>
                              <a class="dropdown-item btn button-danger" style="width: 5px;" data-bs-toggle="modal" data-bs-target="#hapus{{ $g->id_materi }}"><i class="fa-solid fa-trash" style="color: red;"></i></a>
                            </td>
                                      <!-- Modal Hapus -->
                                      <div class="modal fade" id="hapus{{ $g->id_materi }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                      <div class="modal-dialog">
                                        <div class="modal-content">
                                          <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="hapusLabel">Hapus Data materi</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                          </div>
                                          <div class="modal-body">
                                            Apakah Anda Yakin Ingin Menghapus Data Ini?
                                          </div>
                                          <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                            <form action="{{ route('hapus_materi', $g->id_materi) }}" method="POST"
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


        </div>
    </section>
      
          <!-- Modal Keluar -->
          <div class="modal fade" id="exit" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h1 class="modal-title fs-5" id="exitLabel">Keluar</h1>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  Apakah Anda Yakin Ingin Keluar?
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                  <a type="button"  class="btn btn-danger" href="../index.html">Keluar</a>
                </div>
              </div>
            </div>
          </div>




    </section>
          </div>
      </div>
    </section>
  </div>



  <footer class="main-footer">
    <strong>Copyright &copy; 2026 MendungSTEM<a href="#">  Created by Susanti</a>.</strong>
    All rights reserved.
  </footer>

  </main>
</x-guru-layout>
