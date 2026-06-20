<x-app-layout>
  <div class="content-wrapper">

    <div class="content-header">
    <div class="container-fluid">
    <section class="content">
      <div class="container-fluid">
      <div class="container z-1">
        <div class="pagetitle mx-2 mb-2">
          <h1>Data Nilai Kuis</h1>
          <nav>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="#">Admin</a></li>
              <li class="breadcrumb-item active">Nilai Kuis</li>
            </ol>
          </nav>
        </div>

            <div class="container">

            </div>
          <form action="{{ route('search_nilai') }}" method="GET" class="row mb-3">

              <div class="col-md-4">
                  <select name="keyword" class="form-select form-control" required>
                      <option value="">-- Pilih Kuis--</option>

                      @foreach($kuis as $k)
                          <option value="{{ $k->id_kuis }}">
                              {{ $k->nama_kuis }}
                          </option>
                      @endforeach
                  </select>
              </div>

              <div class="col-md-2">
                  <button class="btn btn-primary">
                      Pilih
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


 <table class="table table-bordered">
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

            <td>{{ $n->user->name }}</td>

            <td>{{ $n->skor }}</td>

            <td>{{ $n->timestamp }}</td>

            <td>{{ $nama_kuis }}</td>

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

  </main>
</x-app-layout>


