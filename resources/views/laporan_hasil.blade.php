<x-user-layout>
    
<main id="main" class="main">
    <section class="main-content mb-5">
      <div class="container z-1">

    <section id="info" class="bg-light">
        <div class="bg-info border p-4 rounded bg-white " style="max-width: 1500px;">
          <div class="container justify-content-center align-items-center">
            <h1 class="text-center text-primary mb-4">Hasil Diagnosis Penyakit Ginjal Anak</h1>
            <div class="card mb-4" style="width: 23rem;">
                  <div class="card-body">
                    <h5 class="card-title">Data Pengguna</h5>
                    <div class="row">
                      @foreach($find_user as $f)
                      <div class="col-6">Nama</div>
                      <div class="col-6">{{ $f->name }}</div>
                      <div class="col-6">tanggal Lahir</div>
                      <div class="col-6">{{ $f->tgl_lahir}}</div>
                      <div class="col-6">Jenis Kelamin</div>
                      <div class="col-6">{{ $f->jenis_kelamin }}</div>
                      <div class="col-6">Alamat</div>
                      <div class="col-6">{{ $f->alamat }}</div>
                      <div class="col-6">Nomer HP</div>
                      <div class="col-6">{{ $f->no_hp }}</div>
                      <div class="col-6">Riwayat Penyakit</div>
                      <div class="col-6">{{ $f->riwayat_penyakit }}</div>
                      @endforeach
                    </div>
                  </div>
            </div>
            <div class="container border">
                <br>
                <strong>Hasil Diagnosis</strong>
                <hr>
                @foreach ($penyakit as $p)
                <p class="mb-2">{{ $p->kode_penyakit }}|{{ $p->nama_penyakit }}</p>
                <h2>{{ $p->nama_penyakit }}</h2>
                <img src="{{ asset($p->images) }}" style="width: 200px; height: 200px;" alt="img-penyakit">
                @foreach ($hasil_diagnosis as $hasil)
                <p>Hasil Diagnosis dapat disimpulkan anak mengalami penyakit {{ $hasil->penyakit }} dengan tingkat kepastian yaitu, <b style="font-size: 22px;">{{ intval($hasil->nilai_hasil) }}%</b>.</p>
                @endforeach
                <strong>Saran</strong>
                <p>{{ $p->solusi }}</p>
                
                <a class="btn btn-primary mb-3" type="submit" href="{{ route('unduh', $hasil->id_hasil) }}">
                  Simpan Hasil
                </a>
                @endforeach
                <div class="container text-center">
                    <div class="row">
                        <div class="col">
                            <table class="table table-hover border border-primary">
                                <thead>
                                  <tr>
                                    <th scope="col" colspan="3">Pakar</th>
                                  </tr>
                                  <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Gejala</th>
                                    <th scope="col">Nilai Bobot</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  @foreach ($combined as $index => $data)                              
                                
                                  <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    @foreach($penyakit as $p)
                                    <td>{{ $data['gejala'] }} |  {{ $p->kode_penyakit }} </td>
                                    @endforeach
                                    <td>{{ $data['analis'] }} </td>
                                  </tr>
                                 
                                  @endforeach
                                <!-- </tr> -->
                                </tbody>
                              </table>
                        </div>
                        <div class="col">
                            <table class="table table-hover border border-warning">
                                <thead>
                                  <tr>
                                    <th scope="col" colspan="3">Pengguna</th>
                                  </tr>
                                  <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Gejala</th>
                                    <th scope="col">Nilai</th>
                                  </tr>
                                </thead>
                                <tbody>
                      
                                  @foreach ($lihat_user as $input)    
                                  <tr>
                                      <th scope="row">{{ $loop->iteration }}</th>
                                    
                                      <td>{{ $input['gejala'] }} </td>
                                      <td>{{ $input['kondisi'] }} </td>
                                    </tr>
                                    @endforeach
                                    
                                </tbody>
                              </table>
                        </div>
                        <div class="col">
                            <table class="table table-hover border border-info">
                                <thead>
                                  <tr>
                                    <th scope="col" colspan="3">Hasil</th>
                                  </tr>
                                  <tr>
                                  <th scope="col">No</th>
                                    <th scope="col">Penyakit</th>
                                    <th scope="col">Nilai</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  @foreach ($top3 as $hasil)
                                <tr>
                                  <th scope="row">{{ $loop->iteration }}</th>
                                    <td> {{ $hasil[0] }}</td>
                                    <td> {{ number_format($hasil[1],2)}}</td>
                                  </tr>
                                  @endforeach
                                </tbody>
                              </table>
                        </div>
                      </div>
                </div>
            </div>
              <div class="mt-4">
                <a href="{{ route('laporan') }}" class="btn btn-primary">Kembali</a>
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
          <a type="button"  class="btn btn-danger" href="index.html">Keluar</a>
        </div>
      </div>
    </div>
  </div>

  </main>
  
  <footer class="footer bg-dark text-white">
      <div class="container text-center">
        <br>
        <span>© Copyright 2024 Sistem Pakar Ginjal Anak. Created by Lucky Saputra</span>
      </div>
      <br>
    </footer>
</x-user-layout>