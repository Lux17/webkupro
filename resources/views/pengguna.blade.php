<x-app-layout>
  <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <section class="content">
          <div class="container-fluid">
            <div class="container z-1">
              <div class="pagetitle mx-2 mb-3">
                <h1>Data Siswa</h1>
                <nav>
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Admin</a></li>
                    <li class="breadcrumb-item active">Siswa</li>
                  </ol>
                </nav>
              </div>

              <div class="row mb-3">
                <div class="col-lg-3 col-md-6">
                  <div class="ms-stat stat-orange">
                    <div class="icon-wrap"><i class="fa-solid fa-users"></i></div>
                    <div class="label">Jumlah Siswa</div>
                    <div class="value">{{ $hitung_users }}</div>
                  </div>
                </div>
              </div>

              <div class="ms-toolbar mx-2">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#Tambahpengguna">
                  <i class="fas fa-plus me-1"></i> Tambah Data
                </button>
                <form class="ms-search" method="get" action="{{ route('search_users') }}">
                  <input class="form-control" type="text" name="search" placeholder="Cari nama siswa..." aria-label="Search">
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

              <div class="row my-3">
                <div class="col-12">
                  <div class="card">
                    <div class="card-header">
                      <h3 class="card-title">Tabel Data Pengguna</h3>
                      <div class="card-tools">
                        <div class="input-group input-group-sm" style="width: 150px;"></div>
                      </div>
                    </div>
                    <div class="card-body table-responsive p-0">
                      <table class="table table-hover table-head-fixed">
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
                            <th scope="col" colspan="2" class="text-center">Aksi</th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach ($users as $pengguna)
                            <tr>
                              <th scope="row">{{ $loop->iteration }}</th>
                              <td>{{ $pengguna->id }}</td>
                              <td>{{ $pengguna->name }}</td>
                              <td>
                                {{ $pengguna->email }}
                                @if ($check->hasVerifiedEmail())
                                  <i class="fa-solid fa-certificate text-primary"></i>
                                @else
                                  <i class="fa-solid fa-certificate text-warning"></i>
                                @endif
                              </td>
                              <td>{{ $pengguna->nisn }}</td>
                              <td>{{ $pengguna->kelas->nama_kelas ?? '-' }}</td>
                              <td>{{ $pengguna->tgl_lahir }}</td>
                              <td>{{ $pengguna->jenis_kelamin }}</td>
                              <td>{{ Str::words($pengguna->alamat, 3, '...') }}</td>
                              <td>
                                <a class="dropdown-item btn button-primary" style="width: 5px;" data-bs-toggle="modal" data-bs-target="#Ubahpengguna{{ $pengguna->id }}" href="#">
                                  <i class="fa-regular fa-pen-to-square" style="color: blue;"></i>
                                </a>
                              </td>
                              <td>
                                <a class="dropdown-item btn button-danger" style="width: 5px;" data-bs-toggle="modal" data-bs-target="#hapus{{ $pengguna->id }}" href="#">
                                  <i class="fa-solid fa-trash" style="color: red;"></i>
                                </a>
                              </td>
                            </tr>

                            {{-- Modal Hapus --}}
                            <div class="modal fade" id="hapus{{ $pengguna->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="hapusLabel{{ $pengguna->id }}" aria-hidden="true">
                              <div class="modal-dialog">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="hapusLabel{{ $pengguna->id }}">Hapus Data Pengguna</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                  </div>
                                  <div class="modal-body">
                                    Apakah Anda Yakin Ingin Menghapus Data Ini?
                                  </div>
                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                    <form action="{{ route('hapus_users', $pengguna->id) }}" method="POST" style="display: inline-block;">
                                      @csrf
                                      @method('delete')
                                      <button type="submit" class="btn btn-danger">Hapus</button>
                                    </form>
                                  </div>
                                </div>
                              </div>
                            </div>

                            {{-- Modal Ubah --}}
                            <div class="modal fade" id="Ubahpengguna{{ $pengguna->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="UbahpenggunaLabel{{ $pengguna->id }}" aria-hidden="true">
                              <div class="modal-dialog">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="UbahpenggunaLabel{{ $pengguna->id }}">Ubah Data Siswa</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                  </div>
                                  <form action="{{ route('update_users', $pengguna->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-body">
                                      <div class="mb-3">
                                        <label for="name{{ $pengguna->id }}" class="form-label">Nama</label>
                                        <input type="text" class="form-control" id="name{{ $pengguna->id }}" value="{{ $pengguna->name }}" name="name" required>
                                      </div>
                                      <div class="mb-3">
                                        <label for="nisn{{ $pengguna->id }}" class="form-label">NISN</label>
                                        <input type="text" class="form-control" id="nisn{{ $pengguna->id }}" value="{{ $pengguna->nisn }}" name="nisn" required>
                                      </div>
                                      <div class="mb-3">
                                        <label for="email{{ $pengguna->id }}" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email{{ $pengguna->id }}" value="{{ $pengguna->email }}" name="email" required>
                                      </div>
                                      <label for="password2{{ $pengguna->id }}" class="form-label">Kata Sandi</label>
                                      <div class="mb-3 input-group">
                                        <input type="password" class="form-control" id="password2{{ $pengguna->id }}" name="password" required>
                                        <div class="input-group-append">
                                          <span class="input-group-text" onclick="password_show_hide_id('password2{{ $pengguna->id }}', 'show_eye2{{ $pengguna->id }}', 'hide_eye2{{ $pengguna->id }}');">
                                            <i class="mb-2 fas fa-eye" id="show_eye2{{ $pengguna->id }}"></i>
                                            <i class="mb-2 fas fa-eye-slash d-none" id="hide_eye2{{ $pengguna->id }}"></i>
                                          </span>
                                        </div>
                                      </div>
                                      <div class="mb-3">
                                        <label for="tgl_lahir{{ $pengguna->id }}" class="form-label">Tanggal Lahir</label>
                                        <input type="date" class="form-control" id="tgl_lahir{{ $pengguna->id }}" name="tgl_lahir" value="{{ $pengguna->tgl_lahir }}" required>
                                      </div>
                                      <label for="jenis_kelamin{{ $pengguna->id }}" class="form-label">Jenis Kelamin</label>
                                      <div class="input-group mb-3">
                                        <select class="form-select form-control" id="jenis_kelamin{{ $pengguna->id }}" name="jenis_kelamin">
                                          <option value="{{ $pengguna->jenis_kelamin }}" selected>{{ $pengguna->jenis_kelamin ?: 'Pilih..' }}</option>
                                          <option value="Laki-Laki">Laki-Laki</option>
                                          <option value="Perempuan">Perempuan</option>
                                        </select>
                                      </div>
                                      <div class="mb-3">
                                        <label for="id_kelas{{ $pengguna->id }}" class="form-label">Kelas</label>
                                        <select class="form-select form-control" id="id_kelas{{ $pengguna->id }}" name="id_kelas">
                                          <option value="{{ $pengguna->id_kelas }}" selected>Pilih..</option>
                                          @foreach ($kelas as $k)
                                            <option value="{{ $k->id_kelas }}" @selected($pengguna->id_kelas == $k->id_kelas)>{{ $k->nama_kelas }}</option>
                                          @endforeach
                                        </select>
                                      </div>
                                      <div class="mb-3">
                                        <label for="alamat{{ $pengguna->id }}" class="form-label">Alamat</label>
                                        <textarea class="form-control" id="alamat{{ $pengguna->id }}" name="alamat" required>{{ $pengguna->alamat }}</textarea>
                                      </div>
                                      <input type="hidden" id="rolename{{ $pengguna->id }}" name="rolename" value="pengguna">
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
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
      </div>
    </div>

    {{-- Modal Keluar --}}
    <div class="modal fade" id="exit" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exitLabel" aria-hidden="true">
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
            <a type="button" class="btn btn-danger" href="../index.html">Keluar</a>
          </div>
        </div>
      </div>
    </div>

    {{-- Modal Tambah --}}
    <div class="modal fade" id="Tambahpengguna" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="TambahpenggunaLabel" aria-hidden="true">
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
                <label for="name" class="form-label">Nama</label>
                <input type="text" class="form-control" id="name" name="name" required>
              </div>
              <div class="mb-3">
                <label for="nisn" class="form-label">NISN/NIS</label>
                <input type="text" class="form-control" id="nisn" name="nisn">
              </div>
              <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
              </div>
              <label for="password" class="form-label">Kata Sandi</label>
              <div class="mb-3 input-group">
                <input type="password" class="form-control" id="password" name="password" required>
                <div class="input-group-append">
                  <span class="input-group-text" onclick="password_show_hide();">
                    <i class="mb-2 fas fa-eye" id="show_eye"></i>
                    <i class="mb-2 fas fa-eye-slash d-none" id="hide_eye"></i>
                  </span>
                </div>
              </div>
              <div class="mb-3">
                <label for="tgl_lahir" class="form-label">Tanggal Lahir</label>
                <input type="date" class="form-control" id="tgl_lahir" name="tgl_lahir" required>
              </div>
              <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
              <div class="input-group mb-3">
                <select class="form-select form-control" id="jenis_kelamin" name="jenis_kelamin" required>
                  <option value="" selected>Pilih..</option>
                  <option value="Laki-Laki">Laki-Laki</option>
                  <option value="Perempuan">Perempuan</option>
                </select>
              </div>
              <div class="mb-3">
                <label for="id_kelas" class="form-label">Kelas</label>
                <select class="form-select form-control" id="id_kelas" name="id_kelas" required>
                  <option value="" selected>Pilih..</option>
                  @foreach ($kelas as $k)
                    <option value="{{ $k->id_kelas }}">{{ $k->nama_kelas }}</option>
                  @endforeach
                </select>
              </div>
              <input type="hidden" id="rolename" name="rolename" value="pengguna" required>
              <div class="mb-3">
                <label for="alamat" class="form-label">Alamat</label>
                <textarea class="form-control" id="alamat" name="alamat" required></textarea>
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

    <footer class="main-footer">
      <strong>Copyright &copy; 2026 MendungSTEM<a href="#">  Created by Susanti</a>.</strong>
      All rights reserved.
    </footer>
  </div>

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

    function password_show_hide_id(inputId, showId, hideId) {
      var x = document.getElementById(inputId);
      var show_eye = document.getElementById(showId);
      var hide_eye = document.getElementById(hideId);
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
