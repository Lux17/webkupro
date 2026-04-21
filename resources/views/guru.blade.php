<x-app-layout>
  <div class="content-wrapper">

    <div class="content-header">
    <div class="container-fluid">
    <section class="content">
      <div class="container z-1">
      <div class="pagetitle mb-2 mx-3">
          <h1>Data Guru</h1>
          <nav>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="#">Admin</a></li>
              <li class="breadcrumb-item active">Guru</li>
            </ol>
          </nav>
        </div>
        <div class="container">
        <div class="col-lg-3 col-6">
            <!-- small box -->
              <div class="small-box bg-success">
                <div class="inner">
                    <p>Jumlah Guru</p>
                  <h3>{{ $hitung_users }}</h3>
                </div>
                <div class="icon">
                  <i class="fa-solid fa-users"></i>
                </div>
              </div>
            </div>
            </div>
            <button type="button" class="btn btn-primary mx-2 mb-3" data-bs-toggle="modal" data-bs-target="#Tambahguru">
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

          <form class="d-flex mx-2" method="get" action="{{ route('search_guru') }}">
              <input class="form-control me-2" type="text" name="search" placeholder="Cari Nama Guru" aria-label="Search">
              <button class="btn btn-outline-success" type="submit">Cari</button>
            </form>

            <div class = "container">
                  <!-- Tabel simple -->
                  <div class="row my-3">
                    <div class="col-12">
                      <div class="card">
                        <div class="card-header">
                          <h3 class="card-title">Tabel Data Guru</h3>
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
                            <th scope="col">NIP/NUPTK</th>
                            <th scope="col">Nomer HP</th>
                            <th scope="col">Tanggal Lahir</th>
                            <th scope="col">Jenis Kelamin</th>
                            <th scope="col">Alamat</th>
                            <th scope="col" colspan="3">Aksi</th>
                          </tr>
                        </thead>
                        <tbody>
                        @foreach ($users as $guru)
                          <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $guru->id }}</td>
                            <td>{{ $guru->name }}</td>
                            <td>{{ $guru->email }}
                              @if ($check->hasVerifiedEmail()) 
                              <i class="fa-solid fa-certificate text-primary"></i>
                              @else
                              <i class="fa-solid fa-certificate text-warning"></i>
                              @endif
                            </td>
                            <td>{{ $guru->nip }}</td>
                             <td>{{ $guru->no_hp }}</td>
                            <td>{{ $guru->tgl_lahir }}</td>
                            <td>{{ $guru->jenis_kelamin}}</td>
                            <td>{{ Str::words($guru->alamat , 3, '...') }}</td>
                            <td>
                              <a class="dropdown-item btn button-primary" style="width: 5px;" data-bs-toggle="modal" data-bs-target="#Ubahguru{{ $guru->id }}" href="#"><i class="fa-regular fa-pen-to-square" style="color: blue;"></i></a>
                            </td>
                            <td>
                              <a class="dropdown-item btn button-danger" style="width: 5px;" data-bs-toggle="modal" data-bs-target="#hapus{{ $guru->id }}" href="#"><i class="fa-solid fa-trash" style="color: red;"></i></a>
                            </td>
                            <td></td>
                          
                              <!-- Modal Hapus -->
                              <div class="modal fade" id="hapus{{ $guru->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                              <div class="modal-dialog">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="hapusLabel">Hapus Data guru</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                  </div>
                                  <div class="modal-body">
                                    Apakah Anda Yakin Ingin Menghapus Data Ini?
                                  </div>
                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                    <form action="{{ route('hapus_guru', $guru->id) }}" method="POST"
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
                            <div class="modal fade" id="Ubahguru{{ $guru->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="UbahguruLabel">Ubah Data Guru</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="{{ route('update_guru', $guru->id) }}"
                                    method="POST">
                                    @csrf
                                    @method('PUT')
                                        <div class="modal-body">
                                          <div class="mb-3">
                                            <label for="InputNama" class="form-label">Nama</label>
                                            <input type="text" class="form-control" id="name" value="{{ $guru->name }}" name="name" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="InputNama" class="form-label">NIP/NUPTK</label>
                                            <input type="text" class="form-control" id="nip" value="{{ $guru->nip }}" name="nip" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="InputEmail" class="form-label">Email</label>
                                            <input type="email" class="form-control" id="email" value="{{ $guru->email }}" name="email" required>
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
                                        <label for="InputSandi" class="form-label">Nomer HP</label>
                                        <input type="text" class="form-control" id="nomer_hp" name="no_hp"  value="{{ $guru->no_hp }}" required > 
                                         </div>
                                        <div class="mb-3">
                                          <label for="Inputlahir" class="form-label">Tanggal Lahir</label>
                                          <input type="date" class="form-control" id="tgl_lahir" name="tgl_lahir" value="{{ $guru->tgl_lahir }}" required>
                                        </div>
                                        <label for="Inputlahir" class="form-label">Jenis Kelamin</label>
                                        <div class="input-group mb-3">
                                          <select class="form-select form-control" id="jenis_kelamin" name="jenis_kelamin" >
                                            <option value="{{ $guru->jenis_kelamin }}" selected >Pilih..</option>
                                            <option value="Laki-Laki">Laki-Laki</option>
                                            <option value="Perempuan">Perempuan</option>
                                          </select>
                                        </div>
                                        <div class="mb-3">
                                          <label for="Inputalamat" class="form-label">Alamat</label>
                                          <textarea type="text" class="form-control" value="{{ $guru->alamat }}" id="alamat" name="alamat" required>{{ $guru->alamat }} </textarea>
                                      </div>
                                      <div class="mb-3">
                                          <input type="hidden" class="form-control" id="rolename" name="rolename" value="guru"> 
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
        <div class="modal fade" id="Tambahguru" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="TambahguruLabel">Tambah Data Guru</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="/guru/simpan">
                @csrf
                  <div class="modal-body">
                    <div class="mb-3">
                      <label for="InputNama" class="form-label">Nama</label>
                      <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                  </div>
                  <div class="modal-body">
                    <div class="mb-3">
                      <label for="InputNisn" class="form-label">NIP/NUPTK</label>
                      <input type="text" class="form-control" id="nip" name="nip" >
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
                    <label for="InputSandi" class="form-label">Nomer HP</label>
                    <input type="text" class="form-control" id="nomer_hp" name="no_hp"  required > 
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
                    <input type="hidden" class="form-control" id="rolename" name="rolename" value="guru"  required> 
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