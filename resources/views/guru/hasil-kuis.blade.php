<x-guru-layout>
  <div class="content-wrapper">

    <div class="content-header">
    <div class="container-fluid">
    <section class="content">
      <div class="container-fluid">
      <div class="container z-1">
        <div class="pagetitle mx-2 mb-3">
          <h1>Data Nilai Kuis</h1>
          <nav>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ route('dashboard_guru') }}">Guru</a></li>
              <li class="breadcrumb-item active">Nilai Kuis</li>
            </ol>
          </nav>
        </div>

          <div class="ms-hero mb-3" style="padding:1.2rem 1.4rem;">
            <div class="ms-badge">📈 Rekap Nilai</div>
            <h2 class="h4 mb-1">Pantau hasil kuis siswa</h2>
            <p class="mb-0">Pilih kuis untuk menampilkan nilai, lalu ekspor ke Excel jika diperlukan.</p>
          </div>

          <form action="{{ route('search_nilai') }}" method="GET" class="row mb-3 g-2 align-items-end">

              <div class="col-md-5">
                  <label class="form-label">Pilih Kuis</label>
                  <select name="keyword" class="form-select form-control" required>
                      <option value="">-- Pilih Kuis--</option>

                      @foreach($kuis as $k)
                          <option value="{{ $k->id_kuis }}" {{ (string) request('keyword') === (string) $k->id_kuis ? 'selected' : '' }}>
                              {{ $k->nama_kuis }}
                          </option>
                      @endforeach
                  </select>
              </div>

              <div class="col-md-2">
                  <button class="btn btn-primary w-100">
                      Tampilkan
                  </button>
              </div>

              <div class="col-md-3">
                  <button type="button" class="btn btn-success w-100" id="btnExportNilai">
                      <i class="fas fa-file-excel me-1"></i> Export Excel
                  </button>
              </div>

          </form>

      

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


 <div class="card">
  <div class="card-header">
    <h3 class="card-title mb-0">Tabel Nilai Kuis</h3>
  </div>
  <div class="card-body table-responsive p-0">
 <table class="table table-bordered table-striped mb-0" id="tabelNilaiKuis">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Siswa</th>
            <th>Nilai</th>
            <th>Tanggal</th>
            <th>Nama Kuis</th>
        </tr>
    </thead>

    <tbody>

    @forelse($nilai ?? [] as $n)

        <tr>

            <td>{{ $loop->iteration }}</td>

            <td>{{ $n->user->name ?? '-' }}</td>

            <td>{{ $n->skor }}</td>

            <td>{{ $n->timestamp }}</td>

            <td>{{ is_iterable($nama_kuis ?? null) ? ($nama_kuis[0] ?? '-') : ($nama_kuis ?? '-') }}</td>

        </tr>

    @empty

        <tr>
            <td colspan="5" class="text-center">
                Tidak ada data.
            </td>
        </tr>

    @endforelse

    </tbody>

</table>
  </div>
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
    document.getElementById('btnExportNilai')?.addEventListener('click', function () {
      var rows = [];
      document.querySelectorAll('#tabelNilaiKuis tbody tr').forEach(function (tr) {
        var cells = tr.querySelectorAll('td');
        if (cells.length < 5) return;
        if (cells[0].colSpan && parseInt(cells[0].colSpan, 10) > 1) return;
        rows.push({
          No: cells[0].innerText.trim(),
          'Nama Siswa': cells[1].innerText.trim(),
          Nilai: cells[2].innerText.trim(),
          Tanggal: cells[3].innerText.trim(),
          'Nama Kuis': cells[4].innerText.trim()
        });
      });
      if (!rows.length) {
        alert('Tidak ada data nilai untuk diekspor. Pilih kuis terlebih dahulu.');
        return;
      }
      var quizName = rows[0]['Nama Kuis'] || 'kuis';
      var safeName = quizName.replace(/[\\/:*?"<>|]/g, '_');
      ExcelHelper.exportJson(rows, 'Nilai Kuis', 'nilai_' + safeName + '.xlsx');
    });
  </script>

  </main>
</x-guru-layout>


