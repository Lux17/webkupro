<x-app-layout>
  <div class="content-wrapper">
    <div class="content-header">
    <div class="container-fluid">
    <section class="content">
      <div class="container-fluid">
      <div class="container z-1 ">
        <div class="pagetitle mx-3 mb-2">
          <h1>Data Gejala</h1>
          <nav>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="#">Admin</a></li>
              <li class="breadcrumb-item active">Gejala</li>
            </ol>
          </nav>
        </div>


        <section class="content mb-5">
        <div class="container z-1">
          <div class="col-lg-3 col-6">
              <div class="small-box bg-warning">
                <div class="inner">
                  <p>Jumlah Gejala</p>
                  <h3>{{ $hitung_gejala }}</h3>
                </div>
                <div class="icon">
                  <i class="fa-solid fa-list-check"></i>
                </div>
              </div>
            </div>

            <button type="button" class="btn btn-primary mx-2 mb-3" data-bs-toggle="modal" data-bs-target="#Tambahgejala">
              Tambah Data
            </button>

            <!-- notif session -->
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

            <form class="d-flex mx-2" method="get" action="{{ route('search_gejala') }}">
              <input class="form-control me-2" type="text" name="search" placeholder="Cari Nama Gejala" aria-label="Search">
              <button class="btn btn-outline-success" type="submit">Cari</button>
            </form>

                  <!-- Tabel simple -->
                  <div class="row my-3">
                    <div class="col-12">
                      <div class="card">
                        <div class="card-header">
                          <h3 class="card-title">Tabel Data Gejala</h3>
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
                          <th scope="col">Kode Gejala</th>
                          <th scope="col">Nama Gejala</th>
                          <th scope="col">Jenis</th>
                          <th scope="col">Tipe</th>
                          <th scope="col" colspan="2" class="text-center" >Aksi</th>
                        </tr>
                      </thead>
                      <tbody>
                      @foreach ($gejala as $g)
                        <tr>
                          <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $g->kode_gejala }}</td>
                            <td>{{ $g->nama_gejala }}</td>
                            <td>{{ $g->jenis }}</td>
                            <td>
                            @if($g->type == 1)
                              Gejala Ringan
                            @elseif($g->type == 2)
                              Gejala Sedang
                            @elseif($g->type == 3)
                              Gejala Berat
                            @else
                             Bukan Gejala Ginjal
                            @endif
                            </td>
                            <td>
                              <a class="dropdown-item btn button-primary" style="width: 5px;" data-bs-toggle="modal" data-bs-target="#UbahGejala{{ $g->id_gejala }}" ><i class="fa-regular fa-pen-to-square" style="color: blue;"></i></a>
                            </td>
                            <td>
                              <a class="dropdown-item btn button-danger" style="width: 5px;" data-bs-toggle="modal" data-bs-target="#hapus{{ $g->id_gejala }}"><i class="fa-solid fa-trash" style="color: red;"></i></a>
                            </td>
                                      <!-- Modal Hapus -->
                                      <div class="modal fade" id="hapus{{ $g->id_gejala }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                      <div class="modal-dialog">
                                        <div class="modal-content">
                                          <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="hapusLabel">Hapus Data Gejala</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                          </div>
                                          <div class="modal-body">
                                            Apakah Anda Yakin Ingin Menghapus Data Ini?
                                          </div>
                                          <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                            <form action="{{ route('hapus_gejala', $g->id_gejala) }}" method="POST"
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
                                    <div class="modal fade" id="UbahGejala{{ $g->id_gejala }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="UbahGejalaLabel">Ubah Data Gejala</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="{{ route('update_gejala', $g->id_gejala) }}"
                                            method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label for="InputKode" class="form-label">Kode Gejala</label>
                                                    <input type="text" class="form-control" id="kode_gejala" value="{{ $g->kode_gejala }}" name="kode_gejala" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="InputNama" class="form-label">Gejala</label>
                                                    <textarea type="text" class="form-control" id="nama_gejala" value="{{ $g->nama_gejala }}" name="nama_gejala" required> {{ $g->nama_gejala }} </textarea>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="InputNama" class="form-label">Jenis</label>
                                                    <select class="form-select form-control" id="jenis" name="jenis" required>
                                                    <option value="{{ $g->jenis }}" selected>Pilih..</option>
                                                    @foreach ($penyakit as $p)
                                                    <option value="{{ $p->nama_penyakit }}">{{ $p->nama_penyakit }}</option>
                                                    @endforeach
                                                  </select>
                                                </div>
                                                <div class="mb-3">
                                                  <label for="Inputtype" class="form-label">Tipe</label>
                                                  <select class="form-select form-control" id="type" name="type" required>
                                                  <option value="{{ $g->type }}" selected>Pilih..</option>
                                                  <option value="0">Bukan Gejala</option>
                                                  <option value="1">Gejala Ringan</option>
                                                  <option value="2">Gejala Sedang</option>
                                                  <option value="3">Gejala Berat</option>
                                                  </select>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Tutup</button>
                                                <button type="submit"class="btn btn-primary">Ubah</button>
                                            </div>
                                        </form>
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
    
              <!-- Modal Tambah-->
          <div class="modal fade" id="Tambahgejala" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
              <div class="modal-dialog">
              <div class="modal-content">
                  <div class="modal-header">
                      <h1 class="modal-title fs-5" id="TambahGejalaLabel">Tambah Data Gejala</h1>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <form method="POST" action="/gejala/simpan">
                  @csrf
                      <div class="modal-body">
                          <div class="mb-3">
                              <label for="InputKode" class="form-label">Kode Gejala</label>
                              <input type="text" class="form-control" id="kode_gejala" name="kode_gejala" required>
                          </div>
                          <div class="mb-3">
                              <label for="InputNama" class="form-label">Gejala</label>
                              <textarea type="text" class="form-control" id="nama_gejala" name="nama_gejala" required> </textarea>
                          </div>
                          <div class="mb-3">
                            <label for="InputNama" class="form-label">Jenis</label>
                            <select class="form-select form-control" id="jenis" name="jenis" required>
                            <option value="" selected>Pilih..</option>
                            @foreach ($penyakit as $p)
                            <option value="{{ $p->nama_penyakit }}">{{ $p->nama_penyakit }}</option>
                            @endforeach
                            </select>
                          </div>
                          <div class="mb-3">
                            <label for="Inputtype" class="form-label">Tipe</label>
                            <select class="form-select form-control" id="type" name="type" required>
                            <option value="" selected>Pilih..</option>
                            <option value="0">Bukan Gejala</option>
                            <option value="1">Gejala Ringan</option>
                            <option value="2">Gejala Sedang</option>
                            <option value="3">Gejala Berat</option>
                            </select>
                          </div>
                      </div>
                      <div class="modal-footer">
                          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Tutup</button>
                          <button type="submit"  class="btn btn-primary">Simpan</button>
                      </div>
                  </form>
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
