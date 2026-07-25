<x-app-layout>
  <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <section class="content">
          <div class="container-fluid">
            <div class="container z-1">
              <div class="pagetitle mx-2 mb-3">
                <h1>Data Guru</h1>
                <nav>
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Admin</a></li>
                    <li class="breadcrumb-item active">Guru</li>
                  </ol>
                </nav>
              </div>

              <div class="row mb-3">
                <div class="col-lg-3 col-md-6">
                  <div class="ms-stat stat-purple">
                    <div class="icon-wrap"><i class="fas fa-user-graduate"></i></div>
                    <div class="label">Jumlah Guru</div>
                    <div class="value">{{ $hitung_users }}</div>
                  </div>
                </div>
              </div>

              <div class="ms-toolbar mx-2">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#Tambahguru">
                  <i class="fas fa-plus me-1"></i> Tambah Data
                </button>
                <form class="ms-search" method="get" action="{{ route('search_guru') }}">
                  <input class="form-control" type="text" name="search" placeholder="Cari nama guru..." aria-label="Search">
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
                      <h3 class="card-title">Tabel Data Guru</h3>
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
                            <th scope="col">NIP/NUPTK</th>
                            <th scope="col">Nomer HP</th>
                            <th scope="col">Tanggal Lahir</th>
                            <th scope="col">Jenis Kelamin</th>
                            <th scope="col">Alamat</th>
                            <th scope="col" colspan="2" class="text-center">Aksi</th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach ($users as $guru)
                            <tr>
                              <th scope="row">{{ $loop->iteration }}</th>
                              <td>{{ $guru->id }}</td>
                              <td>{{ $guru->name }}</td>
                              <td>
                                {{ $guru->email }}
                                @if ($check->hasVerifiedEmail())
                                  <i class="fa-solid fa-certificate text-primary"></i>
                                @else
                                  <i class="fa-solid fa-certificate text-warning"></i>
                                @endif
                              </td>
                              <td>{{ $guru->nip }}</td>
                              <td>{{ $guru->no_hp }}</td>
                              <td>{{ $guru->tgl_lahir }}</td>
                              <td>{{ $guru->jenis_kelamin }}</td>
                              <td>{{ Str::words($guru->alamat, 3, '...') }}</td>
                              <td>
                                <a class="dropdown-item btn button-primary" style="width: 5px;" data-bs-toggle="modal" data-bs-target="#Ubahguru{{ $guru->id }}" href="#">
                                  <i class="fa-regular fa-pen-to-square" style="color: blue;"></i>
                                </a>
                              </td>
                              <td>
                                <a class="dropdown-item btn button-danger" style="width: 5px;" data-bs-toggle="modal" data-bs-target="#hapus{{ $guru->id }}" href="#">
                                  <i class="fa-solid fa-trash" style="color: red;"></i>
                                </a>
                              </td>
                            </tr>

                            {{-- Modal Hapus --}}
                            <div class="modal fade" id="hapus{{ $guru->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="hapusLabel{{ $guru->id }}" aria-hidden="true">
                              <div class="modal-dialog">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="hapusLabel{{ $guru->id }}">Hapus Data Guru</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                  </div>
                                  <div class="modal-body">
                                    Apakah Anda Yakin Ingin Menghapus Data Ini?
                                  </div>
                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                    <form action="{{ route('hapus_guru', $guru->id) }}" method="POST" style="display: inline-block;">
                                      @csrf
                                      @method('delete')
                                      <button type="submit" class="btn btn-danger">Hapus</button>
                                    </form>
                                  </div>
                                </div>
                              </div>
                            </div>

                            {{-- Modal Ubah --}}
                            <div class="modal fade" id="Ubahguru{{ $guru->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="UbahguruLabel{{ $guru->id }}" aria-hidden="true">
                              <div class="modal-dialog">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="UbahguruLabel{{ $guru->id }}">Ubah Data Guru</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                  </div>
                                  <form action="{{ route('update_guru', $guru->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-body">
                                      <div class="mb-3">
                                        <label for="name{{ $guru->id }}" class="form-label">Nama</label>
                                        <input type="text" class="form-control" id="name{{ $guru->id }}" value="{{ $guru->name }}" name="name" required>
                                      </div>
                                      <div class="mb-3">
                                        <label for="nip{{ $guru->id }}" class="form-label">NIP/NUPTK</label>
                                        <input type="text" class="form-control" id="nip{{ $guru->id }}" value="{{ $guru->nip }}" name="nip" required>
                                      </div>
                                      <div class="mb-3">
                                        <label for="email{{ $guru->id }}" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email{{ $guru->id }}" value="{{ $guru->email }}" name="email" required>
                                      </div>
                                      <label for="password2{{ $guru->id }}" class="form-label">Kata Sandi</label>
                                      <div class="mb-3 input-group">
                                        <input type="password" class="form-control" id="password2{{ $guru->id }}" name="password" required>
                                        <div class="input-group-append">
                                          <span class="input-group-text" onclick="password_show_hide_id('password2{{ $guru->id }}', 'show_eye2{{ $guru->id }}', 'hide_eye2{{ $guru->id }}');">
                                            <i class="mb-2 fas fa-eye" id="show_eye2{{ $guru->id }}"></i>
                                            <i class="mb-2 fas fa-eye-slash d-none" id="hide_eye2{{ $guru->id }}"></i>
                                          </span>
                                        </div>
                                      </div>
                                      <div class="mb-3">
                                        <label for="no_hp{{ $guru->id }}" class="form-label">Nomer HP</label>
                                        <input type="text" class="form-control" id="no_hp{{ $guru->id }}" name="no_hp" value="{{ $guru->no_hp }}" required>
                                      </div>
                                      <div class="mb-3">
                                        <label for="tgl_lahir{{ $guru->id }}" class="form-label">Tanggal Lahir</label>
                                        <input type="date" class="form-control" id="tgl_lahir{{ $guru->id }}" name="tgl_lahir" value="{{ $guru->tgl_lahir }}" required>
                                      </div>
                                      <label for="jenis_kelamin{{ $guru->id }}" class="form-label">Jenis Kelamin</label>
                                      <div class="input-group mb-3">
                                        <select class="form-select form-control" id="jenis_kelamin{{ $guru->id }}" name="jenis_kelamin">
                                          <option value="{{ $guru->jenis_kelamin }}" selected>{{ $guru->jenis_kelamin ?: 'Pilih..' }}</option>
                                          <option value="Laki-Laki">Laki-Laki</option>
                                          <option value="Perempuan">Perempuan</option>
                                        </select>
                                      </div>
                                      <div class="mb-3">
                                        <label for="alamat{{ $guru->id }}" class="form-label">Alamat</label>
                                        <textarea class="form-control" id="alamat{{ $guru->id }}" name="alamat" required>{{ $guru->alamat }}</textarea>
                                      </div>
                                      <input type="hidden" id="rolename{{ $guru->id }}" name="rolename" value="guru">
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
    <div class="modal fade" id="Tambahguru" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="TambahguruLabel" aria-hidden="true">
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
                <label for="name" class="form-label">Nama</label>
                <input type="text" class="form-control" id="name" name="name" required>
              </div>
              <div class="mb-3">
                <label for="nip" class="form-label">NIP/NUPTK</label>
                <input type="text" class="form-control" id="nip" name="nip">
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
                <label for="nomer_hp" class="form-label">Nomer HP</label>
                <input type="text" class="form-control" id="nomer_hp" name="no_hp" required>
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
              <input type="hidden" id="rolename" name="rolename" value="guru" required>
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
