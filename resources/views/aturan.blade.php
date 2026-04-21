<x-app-layout>
  <style>
    table {
    width: 100%;
    border-collapse: collapse;
}

th, td {
    padding: 8px;
    text-align: left;
    border: 1px solid #ddd;
}

@media screen and (max-width: 600px) {
    table, thead, tbody, th, td, tr {
        display: block;
    }
    
    thead tr {
        display: none;
    }
    
    tr {
        margin-bottom: 15px;
    }
    
    td {
        display: flex;
        justify-content: space-between;
        padding-left: 50%;
        position: relative;
    }
    
    td:before {
        content: attr(data-label);
        position: absolute;
        left: 0;
        width: 50%;
        padding-left: 15px;
        font-weight: bold;
    }
}

  </style>
  <div class="content-wrapper bg-white">

    <div class="content-header">
    <div class="container-fluid">
    <section class="content">
      <div class="container-fluid">
      <div class="container z-1">
      <div class="pagetitle">
          <h1>Data Aturan</h1>
          <nav>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="#">Admin</a></li>
              <li class="breadcrumb-item active">Aturan</li>
            </ol>
          </nav>
        </div>

        <div class="container">
        <div class="list-Gejala my-2 mb-5 mx-2 table-responsive">
              </div>
                <div class="row">
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
                  <div class="input-group mb-3 mx-3">
                    <label for="Inputpenyakit" class="form-label mb-0"><h5>Jenis Penyakit</h5></label>
                  </div>
                  <hr>
                    <div class="input-group mb-3">
                    <form class="d-flex mx-2" method="get" action="{{ route('cari_aturan') }}">
                      <select class="form-select form-control mx-2" id="nama_penyakit" name="nama_penyakit" required >
                          <option value="" selected>Pilih..</option>
                          @foreach ($penyakit as $p)
                          <option value="{{ $p->nama_penyakit }}">{{ $p->nama_penyakit }}</option>
                        @endforeach
                      </select>
                      <button class="btn btn-outline-success" type="submit">Cari</button>
                    </form>
                  </div>
                  <div class="row">
                  <div class="col">
                  <div class="mb-3">
                    <p></p>
                    @foreach ($cari_penyakit as $cari)
                    <input type="hidden" class="form-control" value="{{ $cari->nama_penyakit }}" >
                    @endforeach
                  </div>
              </div>
        </div>

<!-- Tampil Tabel nilai pakar -->
@if($pilih === 1 )
  <div class="my-4 mb-5 mx-1 table-responsive bg-white rounded">
  <div class="mb-3">
  <p></p>
  @foreach ($cari_penyakit as $cari)
  <input type="text" class="form-control" value="{{ $cari->nama_penyakit }}" disabled>
  @endforeach
  </div>
    <form method="POST" action="/aturan/simpan">
  <h5>Tabel Nilai Pakar</h5>
  <hr>
  @csrf

  <!-- ketika data aturan 0 atau tidak ada maka tampil tabel ini -->
  @if(count($tampil_aturan) === 0 )
      @foreach ($cari_penyakit as $cari)
        <input type="hidden" class="form-control" id="idpenyakit" value="{{ $cari->id_penyakit }}" name="idpenyakit" >
      @endforeach
      <!-- Tabel pakar(Simpan) -->
      <table border="1" class="table table-hover ">
                <thead>
                    <tr>
                        <th>Gejala</th>
                        @foreach ($gejala as $g)
                            <th>
                              <input type="hidden" name="gejala_x" value="{{ $g->kode_gejala }}">
                              <center>
                                {{ $g->kode_gejala }}
                              </center>
                              </th>
                          @endforeach
                    </tr>
                </thead>
                <tbody>
                  <center>
                    @for ($i = 0; $i < $hitung_gejala; $i++)
                        <tr>
                            <td>
                              <center>{{$gejala2[$i]}}</center>
                            </td>
                            @for ($j = 0; $j < $hitung_gejala; $j++)
                                <td>
                                    @if ($i == $j)
                                    <center>
                                    <input type="number" value="1" id="input-{{ $i }}-{{ $j }}" class="comparison-input form-control bg-secondary" name="comparison[{{ $i }}][{{ $j }}]" readonly required>
                                    </center>
                                    @else
                                    <input type="number"   max="9" step="0.000000001" id="input-{{ $i }}-{{ $j }}" class="comparison-input form-control" name="comparison[{{ $i }}][{{ $j }}]"  required>
                                    @endif
                                </td>
                            @endfor
                        </tr>
                    @endfor
                    <tr>
                    </tr>
                  </center>
                </tbody>
        </table>

        <button type="submit" class="btn btn-primary mx-2 mb-3" >
          Simpan
        </button>

              <!-- Tabel Gejala (Simpan) -->
              <div class="list-Gejala my-4 mb-5 mx-2 table-responsive">
                    <h5>Tabel Gejala</h5>
                    <hr>
                    <table class="table table-hover ">
                        <thead>
                            <tr>
                              <th scope="col">No</th>
                              <th scope="col">Kode Gejala</th>
                              <th scope="col">Nama Gejala</th>
                              <th scope="col">Jenis Penyakit</th>
                          
                            </tr>
                          </thead>
                          <tbody>
                          @foreach ($gejala as $g)
                            <tr>
                              <th scope="row">{{ $loop->iteration }}</th>
                                <td>{{ $g->kode_gejala }}</td>
                                <td>{{ $g->nama_gejala }}</td>
                                <td>{{ $g->jenis }}</td>
                               
                              </th>
                          @endforeach
                                </tr>
                          </tbody>
                    </table>
                </div>

  <!-- Ketika ada data aturan -->
  @else
          @foreach ($cari_penyakit as $cari)
            <input type="hidden" class="form-control" id="idpenyakit" value="{{ $cari->id_penyakit }}" name="idpenyakit" >
          @endforeach

          <!-- Tabel Nilai Pakar(Update) -->
          <table border="1" class="table table-hover ">
            <thead>
                <tr>
                    <th>Gejala</th>
                    @foreach ($gejala as $g)
                        <th>
                          <input type="hidden" name="gejala_x" value="{{ $g->kode_gejala }}">
                          <center>
                            {{ $g->kode_gejala }}
                          </center>
                      </th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
              <center>
                @for ($i = 0; $i < $hitung_gejala; $i++)
                    <tr>
                        <td>
                          <input type="hidden" name="gejala_y" value="{{ $g->kode_gejala }}" >
                          <center>{{$gejala2[$i]}}</center>
                        </td>

                        @for ($j = 0; $j < $hitung_gejala; $j++)
                            <td>
                              @if ($i == $j)
                                <center>
                                <input type="number" value="1" id="input-{{ $i }}-{{ $j }}" class="comparison-input form-control bg-secondary" name="comparison[{{ $i }}][{{ $j }}]" readonly required>
                                </center>
                              @else
                                <input type="number" value="{{ $group[ $i ][ $j ]}}" max="9" step="0.000000001" id="input-{{ $i }}-{{ $j }}" class="comparison-input form-control" name="comparison[{{ $i }}][{{ $j }}]"   required>  
                              @endif
                            </td>
                        @endfor
                    </tr>
                @endfor
                <tr></tr>
              </center>
            </tbody>
          </table> 

            <button type="submit" class="btn btn-primary mx-2 mb-3" >
              Simpan
            </button>

              <!-- Tabel Gejala(Update) -->
              <div class="list-Gejala my-4 mb-5 mx-2 table-responsive">
                <h5>Tabel Gejala</h5>
                <hr>
                <table class="table table-hover ">
                    <thead>
                        <tr>
                          <th scope="col">No</th>
                          <th scope="col">Kode Gejala</th>
                          <th scope="col">Nama Gejala</th>
                          <th scope="col">Jenis Penyakit</th>
                         
                        </tr>
                    </thead>
                      <tbody>
                        @foreach ($gejala as $g)
                          <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                              <td>{{ $g->kode_gejala }}</td>
                              <td>{{ $g->nama_gejala }}</td>
                              <td>{{ $g->jenis }}</td>
                              
                            </th>
                        @endforeach
                            </tr>
                      </tbody>
                </table>
              </div>
          @endif
          </form>
          </div>


      <!-- Ketika belum pilih penyakit -->
      @else
      <div class="card my-4 mx-2">
        <div class="card-header">
          Panduan Aturan
        </div>
        <div class="card-body">
          <blockquote >
            <ul>
              <li>Pilih Penyakit yang sesuai dari list yang telah ada, kemudian klik "Cari".</li>
              <li>Masukkan nilai bobot untuk setiap gejala yang ada. Nilai bobot ini harus sesuai dengan tingkat kepastian dan pengalaman pakar dalam mendiagnosis gejala tersebut.</li>
              <li>Setelah semua nilai bobot dimasukkan, klik tombol "Simpan" untuk menyimpan data.</li>
              <li><strong> Catatan:</strong> Jika nilai bobot yang dimasukkan tidak konsisten, data tidak akan disimpan. Konsistensi nilai bobot sangat penting untuk memastikan akurasi diagnosis.</li>
            
            </ul>
            
          </blockquote>
        </div>
      </div>
      @endif
  </section>
      

  </section>


  <script>

        // Script untuk otomatis hitung ditabel nilai pakar

        document.addEventListener('DOMContentLoaded', function () {
            // Ambil semua input elements dengan class 'comparison-input'
            const inputs = document.querySelectorAll('.comparison-input');
           
            // Fungsi untuk memperbarui total pada setiap kolom
            function updateColumnTotal(col) {
                let total = 1;
                document.querySelectorAll(`input[id^='input-'][id$='-${col}']`).forEach(input => {
                    total += parseFloat(input.value);
                });
                document.getElementById(`total-${col}`).innerText = total.toFixed(2);
            }

            // Tambahkan event listener untuk setiap input element
            inputs.forEach(input => {
                input.addEventListener('input', function () {
                    // Ambil id dari input yang diubah
                    const id = this.id;
                    // Pisahkan id untuk mendapatkan indeks i dan j
                    const [prefix, i, j] = id.split('-');

                    // Hitung nilai kebalikan
                    const reciprocalValue = 1 / parseFloat(this.value);

                    // Dapatkan input yang berpasangan
                    const reciprocalInput = document.getElementById(`input-${j}-${i}`);
                    
                    // Perbarui nilai input yang berpasangan
                    if (reciprocalInput) {
                        reciprocalInput.value = reciprocalValue.toFixed(9); // Menggunakan toFixed(2) untuk membatasi desimal
                    }
                    // Perbarui total pada kolom yang diubah
                    updateColumnTotal(j);

                    // Perbarui total pada kolom yang berpasangan
                    updateColumnTotal(i);
                });

            });
                // Inisialisasi total untuk setiap kolom pada awalnya
                for (let j = 0; j < {{$hitung_gejala}}; j++) {
                updateColumnTotal(j);
              }
        });

    </script>
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
</x-app-layout>


