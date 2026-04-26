<x-app-layout>
  <div class="content-wrapper">
    <div class="content-header">
    <div class="container-fluid">
    <section class="content">
      <div class="container-fluid">
      <div class="container z-1 ">
        <div class="pagetitle mx-3 mb-2">
          <h1>Data kuis</h1>
          <nav>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="#">Admin</a></li>
              <li class="breadcrumb-item active">kuis</li>
            </ol>
          </nav>
        </div>


        <section class="content mb-5">
        <div class="container z-1">
          <div class="col-lg-3 col-6">
              <div class="small-box bg-warning">
                <div class="inner">
                  <p>Jumlah kuis</p>
                  <h3>{{ $hitung_kuis }}</h3>
                </div>
                <div class="icon">
                  <i class="fa-solid fa-list-check"></i>
                </div>
              </div>
            </div>

            <button type="button" class="btn btn-primary mx-2 mb-3" data-bs-toggle="modal" data-bs-target="#Tambahkuis">
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

            <form class="d-flex mx-2" method="get" action="{{ route('search_kuis') }}">
              <input class="form-control me-2" type="text" name="search" placeholder="Cari Nama kuis" aria-label="Search">
              <button class="btn btn-outline-success" type="submit">Cari</button>
            </form>

                  <!-- Tabel simple -->
                  <div class="row my-3">
                    <div class="col-12">
                      <div class="card">
                        <div class="card-header">
                          <h3 class="card-title">Tabel Data kuis</h3>
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
                          <th scope="col">Kode kuis</th>
                          <th scope="col">Mata Pelajaran</th>
                          <th scope="col">Guru</th>
                          <th scope="col">Jumlah Soal</th>
                          <th scope="col">Durasi</th>
                          <th scope="col" colspan="2" class="text-center" >Aksi</th>
                        </tr>
                      </thead>
                      <tbody>
                      @foreach ($kuis as $g)
                        <tr>
                          <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $g->kode_kuis }}</td>
                            <td>{{ $g->id_mapel}}</td>
                            <td>{{ $g->id_guru}}</td>
                            <td></td>
                            <td>{{ $g->durasi}} Menit</td>
                            <td>
                              <a class="dropdown-item btn button-blue" style="width: 5px;" href="{{ route('tambah-kuis', $g->id_kuis) }}" "><i class="fa-solid fa-plus" style="color: black;"></i></a>
                            </td>

                            <td>
                              <a class="dropdown-item btn button-white" style="width: 5px;" href="{{ route('tampil-kuis', $g->kode_kuis) }}" "><i class="fa-solid fa-eye" style="color: black;"></i></a>
                            </td>
                            <td>
                              <a href="{{ route('ubah-kuis', $g->id_kuis) }}" 
                                class="dropdown-item btn button-primary" 
                                style="width: 5px;">
                                <i class="fa-regular fa-pen-to-square" style="color: blue;"></i>
                              </a>
                            </td>
                            <td>
                              <a class="dropdown-item btn button-danger" style="width: 5px;" data-bs-toggle="modal" data-bs-target="#hapus{{ $g->id_kuis }}"><i class="fa-solid fa-trash" style="color: red;"></i></a>
                            </td>
                                      <!-- Modal Hapus -->
                                      <div class="modal fade" id="hapus{{ $g->id_kuis }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                      <div class="modal-dialog">
                                        <div class="modal-content">
                                          <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="hapusLabel">Hapus Data kuis</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                          </div>
                                          <div class="modal-body">
                                            Apakah Anda Yakin Ingin Menghapus Data Ini?
                                          </div>
                                          <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                            <form action="{{ route('hapus_kuis', $g->id_kuis) }}" method="POST"
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

            <!-- Modal Tambah-->
        <div class="modal fade" id="Tambahkuis" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="TambahkuisLabel">Tambah Data Kuis</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="/kuis/simpan" enctype="multipart/form-data">
                @csrf
                    <div class="modal-body">
                        <label for="InputNama" class="form-label ">Kode Kuis</label>
                        <input type="text" class="form-control" id="kode_kuis" value="{{ now()->format('YmdHis') }}" name="kode_kuis" readonly>
                        <div class="mb-3">
                        <label for="InputNama" class="form-label">Guru</label>
                        <select class="form-select form-control" id="id_guru" name="id_guru" required>
                        <option  selected >Pilih..</option>
                        @foreach ($guru as $g)
                        <option value="{{ $g->id }}">{{ $g->name}}</option>
                        @endforeach
                        </select>
                        </div>

                        <div class="mb-3">
                        <label for="InputNama" class="form-label">Mata pelajaran</label>
                        <select class="form-select form-control" id="id_mapel" name="id_mapel" required>
                        <option  selected >Pilih..</option>
                        @foreach ($mapel as $g)
                        <option value="{{ $g->id_mapel }}">{{ $g->nama_mapel}}</option>
                        @endforeach
                        </select>
                        </div>

                        <div class="mb-3">
                        <label for="InputNama" class="form-label">Durasi</label>
                        <select class="form-select form-control" id="durasi" name="durasi" required>
                        <option  selected >Pilih..</option>
                        <option value="5">5 Menit</option>
                        <option value="15">15 Menit</option>
                        <option value="45">45 Menit</option>
                        <option value="60">60 Menit</option>
                        <option value="90">90 Menit</option>
                        <option value="120">120 Menit</option>
                        </select>
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
