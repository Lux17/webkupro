<x-user-layout>
<style>
      .button-lanjut {
      position: relative;
      transition: all 0.3s ease-in-out;
      box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.2);
      padding-block: 0.5rem;
      padding-inline: 1.25rem;
      background-color: rgb(0 107 179);
      border-radius: 9999px;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      color: #ffff;
      gap: 10px;
      font-weight: bold;
      border: 3px solid #ffffff4d;
      outline: none;
      overflow: hidden;
      font-size: 15px;
    }

    .icon-lanjut {
      width: 24px;
      height: 24px;
      transition: all 0.3s ease-in-out;
    }

    .button-lanjut:hover {
      transform: scale(1.05);
      border-color: #fff9;
    }

    .button-lanjut:hover .icon {
      transform: translate(4px);
    }

    .button-lanjut:hover::before {
      animation: shine 1.5s ease-out infinite;
    }

    .button-lanjut::before {
      content: "";
      position: absolute;
      width: 100px;
      height: 100%;
      background-image: linear-gradient(
        120deg,
        rgba(255, 255, 255, 0) 30%,
        rgba(255, 255, 255, 0.8),
        rgba(255, 255, 255, 0) 70%
      );
      top: 0;
      left: -100px;
      opacity: 0.6;
    }

    @keyframes shine {
      0% {
        left: -100px;
      }

      60% {
        left: 100%;
      }

      to {
        left: 100%;
      }
    }

    .custom-control-input:checked~.custom-control-label::before {
            background-color: #007bff;
            border-color: #007bff;
        }
        .custom-control-input:checked~.custom-control-label::after {
            background-color: #fff;
            border-radius: 50%;
        }
        .custom-radio .custom-control-label::before {
            border-radius: 50%;
        }
        /* Style custom radio buttons */
        .custom-control-label::before {
            width: 1.25rem;
            height: 1.25rem;
        }
        .custom-control-label::after {
            left: 0.3rem;
            top: 0.3rem;
            width: 0.75rem;
            height: 0.75rem;
        }
    </style>

<section id="info" class="bg-light">
        <div class="container">
            <div class="d-flex justify-content-center align-items-center">
                <!-- <ol class="screen-progress-bar clearfix step-1-of-3">
                    <li class="step-1"><span>Informasi Diagnosis</span></li>
                    <li class="step-2"><span>Pertanyaan</span></li>
                    <li class="step-3"><span>Hasil Diagnosis</span></li>
                </ol> -->
            </div>
        </div>
        <div class="bg-info border py-4 my-4 rounded bg-white " style="max-width: auto;">
          <div class="container justify-content-center align-items-center">
          <center>
              <div class="my-5 justify-content-center align-items-center " style="width: auto;">
                <div class="progress ">
                <div class="progress-bar" role="progressbar" style="width: 32%;" aria-valuenow="32" aria-valuemin="0" aria-valuemax="100"></div>
                <div class="progress-bar bg-warning" role="progressbar" style="width: 39%;" aria-valuenow="39" aria-valuemin="0" aria-valuemax="100"></div>
                <div class="progress-bar bg-success" role="progressbar" style="width: 30%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <div class="container mt-2">
                <div class="row ">
                <div class="col">
                <span class="text-primary text-informasi">Informasi Diagnosis</span>
                </div>
                <div class="col">
                <span class="text-warning text-informasi">Pertanyaan</span>
                </div>
                <div class="col">
                <span class="text-success text-informasi">Hasil Diagnosis</span>
                </div>
                </div>
              </div>
            </center>
            <h1 class="text-center text-primary mb-4">Diagnosis Penyakit Ginjal Anak</h1>
            <div class="container border">
                <br>
                
                <strong>Hasil Diagnosis</strong>
                <hr>
                @foreach ($penyakit as $p)
                <p class="mb-2">{{ $p->kode_penyakit }}|{{ $p->nama_penyakit }}</p>
                <h2>{{ $p->nama_penyakit }}</h2>
                <img src="{{ asset($p->images) }}" style="width: 200px; height: 200px;" alt="img-penyakit">
                @foreach ($hasildiagnosis as $hasil)
                <p>Hasil Diagnosis dapat disimpulkan anak mengalami penyakit {{ $hasil->penyakit }} dengan tingkat kepastian yaitu, <b style="font-size: 22px;">{{ number_format($hasil->nilai_hasil,2) }}%</b>.</p>
                @endforeach
                <strong>Solusi atau Saran :</strong>
                <p>{{ $p->solusi }}</p>
                
                <a class="btn btn-primary mb-3" type="submit" href="{{ route('unduh', $hasil->id_hasil) }}">
                  Simpan Hasil
                </a>
                @endforeach
                <div class="container text-center">
                    <div class="row">
                    @if(count($combined) === 0)
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
                                    <th scope="col">Nilai</th>
                                  </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <th scope="row">1</th>
                                    @foreach ($hasil_diagnosis as $hasil)
                                    <td> {{ $hasil->nilai_hasil }}</td>
                                    @endforeach
                                  </tr>
                                </tbody>
                              </table>
                        </div>
                        <div class="col">

                        </div>
                    @else
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
                                  @foreach($penyakit2 as $p)
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
                        @endif
                        </div>
                </div>
            </div>
              <button class="button-lanjut my-3">
                <a href="{{ route('diagnosis') }}"class="text-decoration-none text-white">Kembali</a>
              </button>
          </div>
        </div>
    </section>



    <footer class="footer bg-dark text-white">
      <div class="container text-center">
        <br>
        <span>© Copyright 2024 Sistem Pakar Ginjal Anak. Created by Lucky Saputra</span>
      </div>
      <br>
    </footer>
</x-user-layout>