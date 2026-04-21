<x-app-layout>
  <div class="content-wrapper">

    <div class="content-header">
    <div class="container-fluid">
    <section class="content">
      <div class="container z-1">
      <div class="pagetitle mb-2 mx-3">
          <h1>Data Siswa</h1>
          <nav>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="#">Admin</a></li>
              <li class="breadcrumb-item active">Siswa</li>
            </ol>
          </nav>
        </div>
        <div class="container">
        <div class="col-lg-3 col-6">
            <!-- small box -->
              <div class="small-box bg-success">
                <div class="inner">
                    <p>Jumlah Siswa</p>
                  <h3>{{ $hitung_users }}</h3>
                </div>
                <div class="icon">
                  <i class="fa-solid fa-users"></i>
                </div>
              </div>
            </div>
            </div>
            <button type="button" class="btn btn-primary mx-2 mb-3" data-bs-toggle="modal" data-bs-target="#Tambahpengguna">
              Tambah Data
          </button>

          <!-- Session/Notif -->
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

          <form class="d-flex mx-2" method="get" action="{{ route('search_users') }}">
              <input class="form-control me-2" type="text" name="search" placeholder="Cari Nama Siswa" aria-label="Search">
              <button class="btn btn-outline-success" type="submit">Cari</button>
            </form>

            <div class = "container">
                  <!-- Tabel simple -->
                  <div class="row my-3">
                    <div class="col-12">
                      <div class="card">
                        <div class="card-header">
                          <h3 class="card-title">Tabel Data Pengguna</h3>
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
                            <th scope="col">ID</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Email</th>
                            <th scope="col">NISN</th>
                            <th scope="col">Kelas</th>
                            <th scope="col">Tanggal Lahir</th>
                            <th scope="col">Jenis Kelamin</th>
                            <th scope="col">Alamat</th>
                            <th scope="col" colspan="3">Aksi</th>
                          </tr>
                        </thead>
                        <tbody>
                        @foreach ($users as $pengguna)
                          <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $pengguna->id }}</td>
                            <td>{{ $pengguna->name }}</td>
                            <td>{{ $pengguna->email }}
                              @if ($check->hasVerifiedEmail()) 
                              <i class="fa-solid fa-certificate text-primary"></i>
                              @else
                              <i class="fa-solid fa-certificate text-warning"></i>
                              @endif
                            </td>
                            <td>{{ $pengguna->nisn }}</td>
                            <td>{{ $pengguna->kelas->nama_kelas ?? '-' }}</td>
                            <td>{{ $pengguna->tgl_lahir }}</td>
                            <td>{{ $pengguna->jenis_kelamin}}</td>
                            <td>{{ Str::words($pengguna->alamat , 3, '...') }}</td>
                            <td>
                              <a class="dropdown-item btn button-primary" style="width: 5px;" data-bs-toggle="modal" data-bs-target="#Ubahpengguna{{ $pengguna->id }}" href="#"><i class="fa-regular fa-pen-to-square" style="color: blue;"></i></a>
                            </td>
                            <td>
                              <a class="dropdown-item btn button-danger" style="width: 5px;" data-bs-toggle="modal" data-bs-target="#hapus{{ $pengguna->id }}" href="#"><i class="fa-solid fa-trash" style="color: red;"></i></a>
                            </td>
                            <td></td>
                          
                              <!-- Modal Hapus -->
                              <div class="modal fade" id="hapus{{ $pengguna->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                              <div class="modal-dialog">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="hapusLabel">Hapus Data Pengguna</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                  </div>
                                  <div class="modal-body">
                                    Apakah Anda Yakin Ingin Menghapus Data Ini?
                                  </div>
                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                    <form action="{{ route('hapus_users', $pengguna->id) }}" method="POST"
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
                            <div class="modal fade" id="Ubahpengguna{{ $pengguna->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="UbahpenggunaLabel">Ubah Data Siswa</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="{{ route('update_users', $pengguna->id) }}"
                                    method="POST">
                                    @csrf
                                    @method('PUT')
                                        <div class="modal-body">
                                          <div class="mb-3">
                                            <label for="InputNama" class="form-label">Nama</label>
                                            <input type="text" class="form-control" id="name" value="{{ $pengguna->name }}" name="name" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="InputNama" class="form-label">NISN</label>
                                            <input type="text" class="form-control" id="nisn" value="{{ $pengguna->nisn }}" name="nisn" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="InputEmail" class="form-label">Email</label>
                                            <input type="email" class="form-control" id="email" value="{{ $pengguna->email }}" name="email" required>
                                        </div>
                                        <label for="katasandi" class="form-label">Kata Sandi</label>
                                        <div class="mb-3 input-group">
                                          <input type="password" class="form-control" id="password2" aria-describedby="passwordHelpInline" data-toggle="password" name="password" required>
                                          <div class= "input-group-append">
                                          <span class="input-group-text" onclick="password_show_hide2();">
                                                <i class="mb-2 fas fa-eye" id="show_eye2"></i>
                                                <i class="mb-2 fas fa-eye-slash d-none" id="hide_eye2"></i>
                                          </span>
                                          </div>
                                        </div>
                                        <div class="mb-3">
                                          <label for="Inputlahir" class="form-label">Tanggal Lahir</label>
                                          <input type="date" class="form-control" id="tgl_lahir" name="tgl_lahir" value="{{ $pengguna->tgl_lahir }}" required>
                                        </div>
                                        <label for="Inputlahir" class="form-label">Jenis Kelamin</label>
                                        <div class="input-group mb-3">
                                          <select class="form-select form-control" id="jenis_kelamin" name="jenis_kelamin" >
                                            <option value="{{ $pengguna->jenis_kelamin }}" selected >Pilih..</option>
                                            <option value="Laki-Laki">Laki-Laki</option>
                                            <option value="Perempuan">Perempuan</option>
                                          </select>
                                        </div>
                                        <div class="mb-3">
                                          <label for="InputNama" class="form-label">Kelas</label>
                                          <select class="form-select form-control" id="id_kelas" name="id_kelas" >
                                              <option value="{{ $pengguna->id_kelas }}" selected >Pilih..</option>
                                              @foreach ($kelas as $k)
                                              <option value="{{ $k->id_kelas }}">{{ $k->nama_kelas }}</option>
                                              @endforeach
                                              </select>
                                        </div>
                                        <div class="mb-3">
                                          <label for="Inputalamat" class="form-label">Alamat</label>
                                          <textarea type="text" class="form-control" value="{{ $pengguna->alamat }}" id="alamat" name="alamat" required>{{ $pengguna->alamat }} </textarea>
                                      </div>
                                      <div class="mb-3">
                                          <input type="hidden" class="form-control" id="rolename" name="rolename" value="pengguna"> 
                                      </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Tutup</button>
                                        <button type="submit" class="btn btn-primary">Ubah</button>
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
        <div class="modal fade" id="Tambahpengguna" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="TambahpenggunaLabel">Tambah Data Siswa</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="/users/simpan">
                @csrf
                  <div class="modal-body">
                    <div class="mb-3">
                      <label for="InputNama" class="form-label">Nama</label>
                      <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                  </div>
                  <div class="modal-body">
                    <div class="mb-3">
                      <label for="InputNisn" class="form-label">NISN/NIS</label>
                      <input type="text" class="form-control" id="nisn" name="nisn" >
                  </div>
                  <div class="mb-3">
                      <label for="InputEmail" class="form-label">Email</label>
                      <input type="email" class="form-control" id="email" name="email" required>
                  </div>
                  <label for="katasandi" class="form-label">Kata Sandi</label>
                  <div class="mb-3 input-group">
                    <input type="password" class="form-control" id="password" aria-describedby="passwordHelpInline" data-toggle="password" name="password" required>
                    <div class= "input-group-append">
                    <span class="input-group-text" onclick="password_show_hide();">
                          <i class="mb-2 fas fa-eye" id="show_eye"></i>
                          <i class="mb-2 fas fa-eye-slash d-none" id="hide_eye"></i>
                    </span>
                    </div>
                  </div>
                  <div class="mb-3">
                    <label for="Inputlahir" class="form-label">Tanggal Lahir</label>
                    <input type="date" class="form-control form-control" id="tgl_lahir" name="tgl_lahir" required>
                  </div>
                  <label for="Inputlahir" class="form-label">Jenis Kelamin</label>
                  <div class="input-group mb-3">
                    <select class="form-select form-control" id="jenis_kelamin" name="jenis_kelamin" required>
                      <option value="" selected>Pilih..</option>
                      <option value="Laki-Laki">Laki-Laki</option>
                      <option value="Perempuan">Perempuan</option>
                    </select>
                  </div>
                  <div class="mb-3">
                    <label for="InputNama" class="form-label">Kelas</label>
                     <select class="form-select form-control" id="id_kelas" name="id_kelas" required>
                        <option selected>Pilih..</option>
                        @foreach ($kelas as $k)
                        <option value="{{ $k->id_kelas }}">{{ $k->nama_kelas }}</option>
                        @endforeach
                        </select>
                  </div>
                  <div class="mb-3">
                    <input type="hidden" class="form-control" id="rolename" name="rolename" value="pengguna"  required> 
                    </div>
                    <div class="mb-3">
                      <label for="Inputalamat" class="form-label">Alamat</label>
                      <textarea type="text" class="form-control" id="alamat" name="alamat" required> </textarea>
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

    
    <script>

    function password_show_hide() {
    var x = document.getElementById("password");
    var show_eye = document.getElementById("show_eye");
    var hide_eye = document.getElementById("hide_eye");
    hide_eye.classList.remove("d-none");
    if (x.type === "password") {
      x.type = "text";
      show_eye.style.display = "none";
      hide_eye.style.display = "block";
    } else {
      x.type = "password";
      show_eye.style.display = "block";
      hide_eye.style.display = "none";
    }
  }


  function password_show_hide2() {
    var x = document.getElementById("password2");
    var show_eye = document.getElementById("show_eye2");
    var hide_eye = document.getElementById("hide_eye2");
    hide_eye.classList.remove("d-none");
    if (x.type === "password") {
      x.type = "text";
      show_eye.style.display = "none";
      hide_eye.style.display = "block";
    } else {
      x.type = "password";
      show_eye.style.display = "block";
      hide_eye.style.display = "none";
    }
  }
    </script>
</x-app-layout>