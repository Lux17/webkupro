<x-app-layout>
  <div class="content-wrapper">

    <div class="content-header">
    <div class="container-fluid">
    <section class="content">
      <div class="container-fluid">
      <div class="container z-1">
        <div class="pagetitle mx-2 mb-2">
          <h1>Data files</h1>
          <nav>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="#">Admin</a></li>
              <li class="breadcrumb-item active">files</li>
            </ol>
          </nav>
        </div>

            <div class="container">
                <div class="row">
                <div class="col-lg-3 col-6">
                  <div class="small-box bg-info">
                    <div class="inner">
                      <p>Jumlah files</p>
                      <h3>{{ $hitung_files }}</h3>
                    </div>
                    <div class="icon">
                      <i class="fa-solid fa-virus"></i>
                    </div>
                  </div>
                </div>
                </div>
            </div>
            <button type="button" class="btn btn-primary mx-2 mb-3" data-bs-toggle="modal" data-bs-target="#Tambahfiles">
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

            <form class="d-flex mx-2" method="get" action="{{ route('search_files') }}">
              <input class="form-control me-2" type="text" name="search" placeholder="Cari Nama files" aria-label="Search">
              <button class="btn btn-outline-success" type="submit">Cari</button>
            </form>
            
                  <!-- Tabel simple -->
                  <div class="row my-3">
                    <div class="col-12">
                      <div class="card">
                        <div class="card-header">
                          <h3 class="card-title">Tabel Data files</h3>
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
                          <th scope="col">Nama Berkas</th>
                          <th scope="col">Path</th>
                          <th scope="col">Nama Akun</th>
                          <th scope="col">Tanggal</th>
                          <th scope="col">Preview</th>
                          <th scope="col" colspan="2" class="text-center">Aksi</th>
                        </tr>
                      </thead>
                      <tbody>
                      @foreach ($files as $p)
                        <tr>
                          <th scope="row">{{ $loop->iteration }}</th>
                          <td>{{ $p->nama_files }}</td>
                          <td>{{ $p->file }} 
                              <button 
                                  type="button"
                                  onclick="copyText('{{ $p->file }}')" 
                                  class="btn btn-sm btn-outline-secondary"
                                  title="Copy Path">
                                  📋
                              </button>

                          </td>
                          <td>{{ $p->id_user }}</td>
                          <td>{{ $p->tgl}}</td>
                          <td><img src="{{ asset($p->file) }}" class="img-thumbnail" style="width:60px; height: 60px" /></td>
                          <td>
                            <a class="dropdown-item btn button-primary" style="width: 5px;" data-bs-toggle="modal" data-bs-target="#Ubahfiles{{ $p->id_files }}" ><i class="fa-regular fa-pen-to-square" style="color: blue;"></i></a>
                          </td>
                          <td>
                            <a class="dropdown-item btn button-danger" style="width: 5px;" data-bs-toggle="modal" data-bs-target="#hapus{{ $p->id_files }}"><i class="fa-solid fa-trash" style="color: red;"></i></a>
                          </td>
                            <!-- Modal Hapus -->
                          <div class="modal fade" id="hapus{{ $p->id_files }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                            <div class="modal-dialog">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h1 class="modal-title fs-5" id="hapusLabel">Hapus Data files</h1>
                                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                  Apakah Anda Yakin Ingin Menghapus Data Ini?
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                  <form action="{{ route('hapus_files', $p->id_files) }}" method="POST"
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
                            <div class="modal fade" id="Ubahfiles{{ $p->id_files }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="UbahfilesLabel">Ubah Data files</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="{{ route('update_files', $p->id_files) }}"
                                    method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                        <div class="modal-body">
                                       <input type="hidden" class="form-control" id="tgl" value="{{ now() }}" name="tgl" readonly>
                                        <div class="mb-3">
                                            <label for="InputNama" class="form-label">Nama files</label>
                                            <input type="text" class="form-control" id="nama_files" name="nama_files" value="{{ $p->nama_files }}" required="" >
                                        </div>
                                        <div class="mb-3">
                                          <label for="file" class="form-label">Berkas/Files</label>
                                          <input type="file" class="form-control"  name="file" required="">
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
        <div class="modal fade" id="Tambahfiles" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="TambahfilesLabel">Tambah Data files</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="/files/simpan" enctype="multipart/form-data">
                @csrf
                    <div class="modal-body">
                        <input type="hidden" class="form-control" id="tgl" value="{{ now() }}" name="tgl" readonly>
                        <div class="mb-3">
                            <label for="InputNama" class="form-label">Nama files</label>
                            <input type="text" class="form-control" id="nama_files" name="nama_files" required="" >
                        </div>
                        <div class="mb-3">
                          <label for="file" class="form-label">Berkas/Files</label>
                          <input type="file" class="form-control"  name="file" required="">
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

<script>
function copyText(text) {
    navigator.clipboard.writeText(text);
}
</script>
  <footer class="main-footer">
    <strong>Copyright &copy; 2024 <a href="#">Sistem Pakar Ginjal Anak. Created by Lucky Saputra</a>.</strong>
    All rights reserved.
  </footer>

  </main>
</x-app-layout>


