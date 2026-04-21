<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <meta name="csrf-token">

  <title>Download - Sistem Pakar Diagnosis Penyakit Ginjal Pada anak Menggunakan Metode AHP dan Certainty Factor</title>
  <meta content="" name="description">
  <meta content="" name="keywords">
</head>
    <body class="font-sans antialiased">
 
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">


            <!-- Page Content -->
            <main>
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
        <div class="bg-info border p-4 rounded bg-white " style="max-width: 1500px;">
          <div class="container justify-content-center align-items-center">
            <h1 class="text-center text-primary mb-4">Diagnosis Penyakit Ginjal Anak</h1>
            <div class="container border">
                <br>
                
                @foreach ($hasildiagnosis as $hasil)
                <p style="font-size: 11px;">ID Diagnosis : {{ $hasil->kode_hasil }} </p>
                @endforeach
                <strong>Hasil Diagnosis</strong>
                <hr>
                @foreach ($penyakit as $p)
                <p class="mb-2">{{ $p->kode_penyakit }}|{{ $p->nama_penyakit }}</p>
                <h2>{{ $p->nama_penyakit }}</h2>
                @foreach ($hasildiagnosis as $hasil)
                <p>Hasil Diagnosis dapat disimpulkan anak mengalami penyakit {{ $hasil->penyakit }} dengan tingkat kepastian yaitu, <b style="font-size: 22px;">{{ intval($hasil->nilai_hasil) }}%</b>.</p>
                @endforeach
                <strong>Solusi atau Saran :</strong>
                <p>{{ $p->solusi }}</p>
                @endforeach
                <div class="container text-center">
                    <div class="row">
                    @if(count($combined) === 0)
                    <div class="col">
                          <br>
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
                          <br>
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
                                    @foreach ($hasildiagnosis as $hasil)
                                    <th scope="row">{{ $loop->iteration}}</th>
                                    <td>{{ $hasil->nilai_hasil }}</td>
                                    @endforeach
                                  </tr>
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
                          <br>
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
                          <br>
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
                                    @foreach ($hasildiagnosis as $hasil)
                                    <td>0.16</td>
                                    {{ $hasil->nilai_hasil }}
                                    @endforeach
                                  </tr>
                                  <tr>
                                    <th scope="row">2</th>
                                    <td>0.7</td>
                                  </tr>
                            @endif

                                </tbody>
                              </table>
                              <div>
                                
                              </div>
                        </div>
                      </div>
                </div>
            </div>
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
            </main>
        </div>
        
    </body>
</html>

