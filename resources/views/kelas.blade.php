<x-app-layout>
  <div class="content-wrapper">

    <div class="content-header">
    <div class="container-fluid">
    <section class="content">
      <div class="container-fluid">
      <div class="container z-1">
        <div class="pagetitle mx-2 mb-2">
          <h1>Data Kelas</h1>
          <nav>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="#">Admin</a></li>
              <li class="breadcrumb-item active">Kelas</li>
            </ol>
          </nav>
        </div>

            <div class="container">
                <div class="row">
                <div class="col-lg-3 col-6">
                  <div class="small-box bg-info">
                    <div class="inner">
                      <p>Jumlah Kelas</p>
                      <h3>{{ $hitung_kelas }}</h3>
                    </div>
                    <div class="icon">
                      <i class="fa-solid fa-virus"></i>
                    </div>
                  </div>
                </div>
                </div>
            </div>
            <button type="button" class="btn btn-primary mx-2 mb-3" data-bs-toggle="modal" data-bs-target="#Tambahkelas">
                Tambah Data
            </button>
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

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form class="d-flex mx-2" method="get" action="{{ route('search_kelas') }}">
              <input class="form-control me-2" type="text" name="search" placeholder="Cari Nama kelas" aria-label="Search">
              <button class="btn btn-outline-success" type="submit">Cari</button>
            </form>
            
                  <!-- Tabel simple -->
                  <div class="row my-3">
                    <div class="col-12">
                      <div class="card">
                        <div class="card-header">
                          <h3 class="card-title">Tabel Data Kelas</h3>
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
                          <th scope="col">No</th>
                          <th scope="col">ID Kelas</th>
                          <th scope="col">Nama Kelas</th>
                          <th scope="col" colspan="2" class="text-center">Aksi</th>
                        </tr>
                      </thead>
                      <tbody>
                      @foreach ($kelas as $p)
                        <tr>
                          <th scope="row">{{ $loop->iteration }}</th>
                          <td>{{ $p->id_kelas }}</td>
                          <td>{{ $p->nama_kelas }}</td>
                          <td>
                            <a class="dropdown-item btn button-primary" style="width: 5px;" data-bs-toggle="modal" data-bs-target="#Ubahkelas{{ $p->id_kelas }}" ><i class="fa-regular fa-pen-to-square" style="color: blue;"></i></a>
                          </td>
                          <td>
                            <a class="dropdown-item btn button-danger" style="width: 5px;" data-bs-toggle="modal" data-bs-target="#hapus{{ $p->id_kelas }}"><i class="fa-solid fa-trash" style="color: red;"></i></a>
                          </td>
                            <!-- Modal Hapus -->
                          <div class="modal fade" id="hapus{{ $p->id_kelas }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                            <div class="modal-dialog">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h1 class="modal-title fs-5" id="hapusLabel">Hapus Data kelas</h1>
                                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                  Apakah Anda Yakin Ingin Menghapus Data Ini?
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                  <form action="{{ route('hapus_kelas', $p->id_kelas) }}" method="POST"
                                    style="display: inline-block;">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="btn btn-danger ">Hapus</button>
                                  </form>
                                </div>
                              </div>
                            </div>
                          </div>

                            <!-- Modal Ubah-->
                            <div class="modal fade" id="Ubahkelas{{ $p->id_kelas }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="UbahkelasLabel">Ubah Data kelas</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="{{ route('update_kelas', $p->id_kelas) }}"
                                    method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="InputID" class="form-label">ID kelas</label>
                                                <input type="text" class="form-control" id="id_kelas" value="{{ $p->id_kelas }}" name="id_kelas" required="">
                                            </div>
                                            <div class="mb-3">
                                                <label for="InputNama" class="form-label">Nama kelas</label>
                                                <input type="text" class="form-control" id="nama_kelas" value="{{ $p->nama_kelas }}" name="nama_kelas" required="">
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Tutup</button>
                                            <button  type="submit" class="btn btn-primary">Ubah</button>
                                        </div>
                                    </form>
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

    
            <!-- Modal Tambah-->
        <div class="modal fade" id="Tambahkelas" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="TambahkelasLabel">Tambah Data kelas</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="/kelas/simpan" enctype="multipart/form-data">
                @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="InputNama" class="form-label">Nama kelas</label>
                            <input type="text" class="form-control" id="nama_kelas" name="nama_kelas" required="" >
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
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
    <strong>Copyright &copy; 2024 <a href="#">Sistem Pakar Ginjal Anak. Created by Lucky Saputra</a>.</strong>
    All rights reserved.
  </footer>

  </main>
</x-app-layout>


