<x-app-layout>
  <div class="content-wrapper">
    <div class="content-header">
    <div class="container-fluid">
    <section class="content">
      <div class="container-fluid">
      <div class="container z-1 ">
        <div class="pagetitle mx-3 mb-3">
          <h1>Data Kuis</h1>
          <nav>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Admin</a></li>
              <li class="breadcrumb-item active">Kuis</li>
            </ol>
          </nav>
        </div>


        <section class="content mb-5">
        <div class="container z-1">
          <div class="row mb-3">
            <div class="col-lg-3 col-md-6">
              <div class="ms-stat stat-blue">
                <div class="icon-wrap"><i class="fa-solid fa-list-check"></i></div>
                <div class="label">Jumlah Kuis</div>
                <div class="value">{{ $hitung_kuis }}</div>
              </div>
            </div>
          </div>

            <div class="ms-toolbar mx-2">
              <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#Tambahkuis">
                  <i class="fas fa-plus me-1"></i> Tambah Data
              </button>
              <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#ExportSoalKuis">
                  <i class="fas fa-file-excel me-1"></i> Export Excel Soal
              </button>
              <button type="button" class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#UploadExcelKuis">
                  <i class="fas fa-upload me-1"></i> Upload Excel Soal
              </button>
              <button type="button" class="btn btn-outline-secondary" id="btnTemplateSoal">
                  <i class="fas fa-download me-1"></i> Template Soal
              </button>
            </div>

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
                          <table class="table table-head-fixed" id="tabelKuis">
                        <thead>
                        <tr>
                          <th scope="col">No</th>
                          <th scope="col">Nama Kuis</th>
                          <th scope="col">Kode kuis</th>
                          <th scope="col">Mata Pelajaran</th>
                          <th scope="col">Guru</th>
                          <th scope="col">Durasi</th>
                          <th scope="col" colspan="4" class="text-center" >Aksi</th>
                        </tr>
                      </thead>
                      <tbody>
                      @foreach ($kuis as $g)
                        <tr data-id-kuis="{{ $g->id_kuis }}"
                            data-kode-kuis="{{ $g->kode_kuis }}"
                            data-id-mapel="{{ $g->id_mapel }}"
                            data-id-guru="{{ $g->id_guru }}"
                            data-durasi="{{ $g->durasi }}"
                            data-nama-kuis="{{ $g->nama_kuis }}">
                          <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $g->nama_kuis }}</td>
                            <td>{{ $g->kode_kuis }}</td>
                            <td>{{ $g->mapel->nama_mapel }}</td>
                            <td>{{ $g->guru->name ?? '-' }}</td>
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
                                            <h1 class="modal-title fs-5" id="hapusLabel">Hapus Data Kuis</h1>
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
                        <label for="InputNama" class="form-label ">Nama Kuis</label>
                        <input type="text" class="form-control" id="nama_kuis" name="nama_kuis">
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

            <!-- Modal Upload Excel Soal -->
            <div class="modal fade" id="UploadExcelKuis" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h1 class="modal-title fs-5">Upload Excel Soal Kuis</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <div class="alert alert-info small">
                      Format kolom: <strong>pertanyaan, opsi_a, opsi_b, opsi_c, opsi_d, opsi_e, jawaban</strong>.
                      Nilai jawaban gunakan a/b/c/d/e. File diproses di browser lalu dikirim ke endpoint simpan soal yang sudah ada.
                    </div>
                    <div class="mb-3">
                      <label class="form-label">Pilih Kuis Tujuan</label>
                      <select id="uploadTargetKuis" class="form-select form-control" required>
                        <option value="">-- Pilih Kuis --</option>
                        @foreach ($kuis as $g)
                          <option value="{{ $g->id_kuis }}"
                                  data-kode-kuis="{{ $g->kode_kuis }}"
                                  data-id-mapel="{{ $g->id_mapel }}"
                                  data-id-guru="{{ $g->id_guru }}"
                                  data-durasi="{{ $g->durasi }}">
                            {{ $g->nama_kuis }} ({{ $g->kode_kuis }})
                          </option>
                        @endforeach
                      </select>
                    </div>
                    <div class="mb-3">
                      <label class="form-label">File Excel (.xlsx / .xls / .csv)</label>
                      <input type="file" id="uploadExcelFile" class="form-control" accept=".xlsx,.xls,.csv">
                    </div>
                    <div id="uploadExcelStatus" class="small text-muted"></div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-success" id="btnProsesUploadExcel">
                      <i class="fas fa-upload me-1"></i> Proses & Simpan
                    </button>
                  </div>
                </div>
              </div>
            </div>

            <!-- Modal Export Soal -->
            <div class="modal fade" id="ExportSoalKuis" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h1 class="modal-title fs-5">Export Soal Kuis ke Excel</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <div class="mb-3">
                      <label class="form-label">Pilih Kuis</label>
                      <select id="exportTargetKuis" class="form-select form-control" required>
                        <option value="">-- Pilih Nama / Kode Kuis --</option>
                        @foreach ($kuis as $g)
                          <option value="{{ $g->kode_kuis }}">{{ $g->nama_kuis }} ({{ $g->kode_kuis }})</option>
                        @endforeach
                      </select>
                    </div>
                    <div id="exportSoalStatus" class="small text-muted"></div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-success" id="btnProsesExportSoal">
                      <i class="fas fa-file-excel me-1"></i> Export
                    </button>
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

  <script src="https://cdn.jsdelivr.net/npm/xlsx@0.18.5/dist/xlsx.full.min.js"></script>
  <script src="{{ asset('assets/js/excel-helper.js') }}"></script>
  <script>
    document.getElementById('btnProsesExportSoal')?.addEventListener('click', async function () {
      var select = document.getElementById('exportTargetKuis');
      var statusEl = document.getElementById('exportSoalStatus');
      var kodeKuis = select?.value;

      if (!kodeKuis) {
        alert('Pilih kuis terlebih dahulu.');
        return;
      }

      statusEl.textContent = 'Memuat data soal...';
      try {
        var resp = await fetch('{{ url("kuis/soal-by-kode") }}/' + encodeURIComponent(kodeKuis), {
          headers: { 'Accept': 'application/json' }
        });
        if (!resp.ok) throw new Error('Gagal memuat data soal.');
        var soalList = await resp.json();

        if (!soalList || !soalList.length) {
          statusEl.textContent = 'Tidak ada soal untuk kuis ini.';
          alert('Tidak ada soal ditemukan untuk kuis yang dipilih.');
          return;
        }

        var rows = soalList.map(function (s, idx) {
          return {
            No: idx + 1,
            Pertanyaan: s.pertanyaan || '',
            'Opsi A': s.opsi_a || '',
            'Opsi B': s.opsi_b || '',
            'Opsi C': s.opsi_c || '',
            'Opsi D': s.opsi_d || '',
            'Opsi E': s.opsi_e || '',
            Jawaban: s.jawaban || ''
          };
        });

        var selectedText = select.options[select.selectedIndex].text.replace(/[^a-zA-Z0-9_\- ]/g, '_').substring(0, 50);
        ExcelHelper.exportJson(rows, 'Soal Kuis', 'soal_' + selectedText + '.xlsx');

        statusEl.textContent = 'Berhasil! ' + rows.length + ' soal diekspor.';
        bootstrap.Modal.getInstance(document.getElementById('ExportSoalKuis'))?.hide();
      } catch (err) {
        console.error(err);
        statusEl.textContent = 'Gagal memproses export.';
        alert('Gagal mengambil data soal.');
      }
    });

    document.getElementById('btnTemplateSoal')?.addEventListener('click', function () {
      ExcelHelper.downloadTemplateSoal('template_soal_kuis.xlsx');
    });

    document.getElementById('btnProsesUploadExcel')?.addEventListener('click', async function () {
      var select = document.getElementById('uploadTargetKuis');
      var fileInput = document.getElementById('uploadExcelFile');
      var statusEl = document.getElementById('uploadExcelStatus');
      var option = select?.options[select.selectedIndex];

      if (!select?.value) {
        alert('Pilih kuis tujuan terlebih dahulu.');
        return;
      }
      if (!fileInput?.files?.length) {
        alert('Pilih file Excel terlebih dahulu.');
        return;
      }

      statusEl.textContent = 'Membaca file Excel...';
      try {
        var json = await ExcelHelper.readFileAsJson(fileInput.files[0]);
        var questions = ExcelHelper.parseSoalRows(json);
        if (!questions.length) {
          statusEl.textContent = 'Tidak ada baris soal valid.';
          alert('Tidak ada soal valid. Pastikan kolom pertanyaan terisi.');
          return;
        }
        statusEl.textContent = 'Mengirim ' + questions.length + ' soal ke server...';
        ExcelHelper.submitSoalToEndpoint(
          '{{ route('tambah-soal') }}',
          {
            kode_kuis: option.dataset.kodeKuis,
            id_mapel: option.dataset.idMapel,
            id_guru: option.dataset.idGuru,
            durasi: option.dataset.durasi
          },
          questions,
          '{{ csrf_token() }}'
        );
      } catch (err) {
        console.error(err);
        statusEl.textContent = 'Gagal memproses file.';
        alert('Gagal memproses file Excel.');
      }
    });
  </script>

  </main>
</x-app-layout>
