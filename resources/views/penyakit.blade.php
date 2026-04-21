<x-app-layout>
  <div class="content-wrapper">

    <div class="content-header">
    <div class="container-fluid">
    <section class="content">
      <div class="container-fluid">
      <div class="container z-1">
        <div class="pagetitle mx-2 mb-2">
          <h1>Data Penyakit</h1>
          <nav>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="#">Admin</a></li>
              <li class="breadcrumb-item active">Penyakit</li>
            </ol>
          </nav>
        </div>

            <div class="container">
                <div class="row">
                <div class="col-lg-3 col-6">
                  <div class="small-box bg-info">
                    <div class="inner">
                      <p>Jumlah Penyakit</p>
                      <h3>{{ $hitung_penyakit }}</h3>
                    </div>
                    <div class="icon">
                      <i class="fa-solid fa-virus"></i>
                    </div>
                  </div>
                </div>
                </div>
            </div>
            <button type="button" class="btn btn-primary mx-2 mb-3" data-bs-toggle="modal" data-bs-target="#Tambahpenyakit">
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

            <form class="d-flex mx-2" method="get" action="{{ route('search_penyakit') }}">
              <input class="form-control me-2" type="text" name="search" placeholder="Cari Nama Penyakit" aria-label="Search">
              <button class="btn btn-outline-success" type="submit">Cari</button>
            </form>
            
                  <!-- Tabel simple -->
                  <div class="row my-3">
                    <div class="col-12">
                      <div class="card">
                        <div class="card-header">
                          <h3 class="card-title">Tabel Data Penyakit</h3>
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
                          <th scope="col">Kode Penyakit</th>
                          <th scope="col">Nama Penyakit</th>
                          <th scope="col">Solusi</th>
                          <th scope="col">Gambar</th>
                          <th scope="col" colspan="2" class="text-center">Aksi</th>
                        </tr>
                      </thead>
                      <tbody>
                      @foreach ($penyakit as $p)
                        <tr>
                          <th scope="row">{{ $loop->iteration }}</th>
                          <td>{{ $p->kode_penyakit }}</td>
                          <td>{{ $p->nama_penyakit }}</td>
                          <td>{{ Str::words($p->solusi , 10, '...') }} </td>
                          <td><img src="{{ asset($p->images) }}" class="img-thumbnail" style="width:60px; height: 60px" /></td>
                          <td>
                            <a class="dropdown-item btn button-primary" style="width: 5px;" data-bs-toggle="modal" data-bs-target="#Ubahpenyakit{{ $p->id_penyakit }}" ><i class="fa-regular fa-pen-to-square" style="color: blue;"></i></a>
                          </td>
                          <td>
                            <a class="dropdown-item btn button-danger" style="width: 5px;" data-bs-toggle="modal" data-bs-target="#hapus{{ $p->id_penyakit }}"><i class="fa-solid fa-trash" style="color: red;"></i></a>
                          </td>
                            <!-- Modal Hapus -->
                          <div class="modal fade" id="hapus{{ $p->id_penyakit }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                            <div class="modal-dialog">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h1 class="modal-title fs-5" id="hapusLabel">Hapus Data Penyakit</h1>
                                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                  Apakah Anda Yakin Ingin Menghapus Data Ini?
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                  <form action="{{ route('hapus_penyakit', $p->id_penyakit) }}" method="POST"
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
                            <div class="modal fade" id="Ubahpenyakit{{ $p->id_penyakit }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="UbahpenyakitLabel">Ubah Data Penyakit</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="{{ route('update_penyakit', $p->id_penyakit) }}"
                                    method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="InputKode" class="form-label">Kode Penyakit</label>
                                                <input type="text" class="form-control" id="kode_penyakit" value="{{ $p->kode_penyakit }}" name="kode_penyakit" readonly>
                                            </div>
                                            <div class="mb-3">
                                                <label for="InputNama" class="form-label">Nama Penyakit</label>
                                                <input type="text" class="form-control" id="nama_penyakit" value="{{ $p->nama_penyakit }}" name="nama_penyakit" required="">
                                            </div>
                                            <div class="mb-3">
                                                <label for="InputSolusi" class="form-label">Solusi</label>
                                                <textarea type="text" class="form-control" id="solusi" value="{{ $p->solusi }}" name="solusi" required=""> {{ $p->solusi }} </textarea>
                                            </div>
                                            <div class="mb-3">
                                              <label for="images" class="form-label">Gambar</label>
                                              <input type="file" class="form-control"  name="images" value="{{asset($p->images)}}">
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
        <div class="modal fade" id="Tambahpenyakit" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="TambahpenyakitLabel">Tambah Data Penyakit</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="/penyakit/simpan" enctype="multipart/form-data">
                @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="InputKode" class="form-label">Kode Penyakit</label>
                            <input type="text" class="form-control" id="kode_penyakit" name="kode_penyakit" required="">
                        </div>
                        <div class="mb-3">
                            <label for="InputNama" class="form-label">Nama Penyakit</label>
                            <input type="text" class="form-control" id="nama_penyakit" name="nama_penyakit" required="" >
                        </div>
                        <div class="mb-3">
                            <label for="InputSolusi" class="form-label">Solusi</label>
                            <textarea type="text" class="form-control" id="solusi" name="solusi" required=""> </textarea>
                        </div>
                        <div class="mb-3">
                          <label for="images" class="form-label">Gambar</label>
                          <input type="file" class="form-control"  name="images" required="">
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


