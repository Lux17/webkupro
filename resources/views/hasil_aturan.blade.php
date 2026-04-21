<x-profil-layout>
    
    <section class="main-content mb-5">
      <div class="container z-1">
        <div class="pagetitle">
          <h1>Hasil Data Aturan</h1>
          <nav>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="#">Admin</a></li>
              <li class="breadcrumb-item active">Aturan</li>
              <li class="breadcrumb-item active">Hasil Aturan</li>
            </ol>
          </nav>
        </div>
        <div class="container">
          <h4>Tabel Perbandingan Berpasangan</h4>
        <table border="1" class="table table-hover ">
            <thead>
                <tr>
                    <th>Gejala</th>
                    @for ($i = 0; $i < count($jmlmnk); $i++)
                        <th>
                          <center>
                          {{$gejala2[$i]}}
                          </center>
                          </th>
                      @endfor
                    
                </tr>
            </thead>
            <tbody>
              <center>
                @for ($i = 0; $i < count($jmlmnk); $i++)
                    <tr>
                        <td>
                          
                          <center>{{$gejala2[$i]}}</center>
                        </td>

                        @for ($j = 0; $j < count($jmlmnk); $j++)
                            <td>
                                @if ($i == $j)
                                <center>
                                <input type="hidden" value="1" id="input-{{ $i }}-{{ $j }}" class="comparison-input form-control" name="comparison[{{ $i }}][{{ $j }}]" readonly required>
                                  <p>1</p>
                                </center>
                                @else
                                
                                <input type="number"   max="9" step="0.000000001" id="input-{{ $i }}-{{ $j }}" class="comparison-input form-control" value="{{ $comparisons[ $i ][ $j ] }}" readonly required>
                                @endif
                            </td>
                        @endfor

                    </tr>
                @endfor

              </center>
                </tbody>
          </table>

          <h4>Tabel Normalisasi</h4>
          <table border="1" class="table table-hover ">
            <thead>
                <tr>
                    <th>Gejala</th>
                    @for ($i = 0; $i < count($jmlmnk); $i++)
                        <th>
                          <center>
                          {{$gejala2[$i]}}
                          </center>
                          </th>
                      @endfor
                    
                </tr>
            </thead>
            <tbody>
              <center>
                @for ($i = 0; $i < count($jmlmnk); $i++)
                    <tr>
                        <td>
                          
                          <center>{{$gejala2[$i]}}</center>
                        </td>

                        @for ($j = 0; $j < count($jmlmnk); $j++)
                            <td>
                                @if ($i == $j)
                                <center>
                                <input type="number"  id="input-{{ $i }}-{{ $j }}" class="comparison-input form-control" value="{{number_format($matrikb[ $i ][ $j ],5) }}" readonly  required>
                                
                                </center>
                                @else
                                <input type="number"   max="9" step="0.000000001" id="input-{{ $i }}-{{ $j }}" class="comparison-input form-control" value="{{ number_format($matrikb[ $i ][ $j ],5)  }}"  readonly required>
                                @endif
                            </td>
                        @endfor

                    </tr>
                @endfor

              </center>
                </tbody>
          </table>

                <div class="my-1 mb-1 mx-2 table-responsive">
                <table border="1" class="table table-hover">
                  <tr>
                    <th>Gejala</th>
                    <th>Jumlah</th>
                    <th>Nilai Prioritas</th>
                    <th>Nilai Eigen</th>
                  </tr>
                  <tr>
                  <tr>
                    
                </tr>
                  @for ($j = 0; $j < count($jmlmnk); $j++)
                      <td>{{$gejala2[$j]}}</td>

                      <td>{{ $jmlmnk[$j] }}</td>

                      <td>{{ number_format($pv[$j],10) }}</td>

                      <td>{{ number_format($arr_eigen[$j],9)}}</td>
                    </tr>
                  @endfor
                </tabel>
                </div>
                </div>

                
            <div class="container">
              <div class="my-2 mb-5 mx-2 table-responsive">
                <table border="1" class="table table-hover">
                  <tr>
                    <th>Hasil Perhitungan</th> 
                    <th></th>
                  </tr>
                  <tr>
                    <td>Jumlah total Nilai Eigen</td>
                    <td>{{ $jmlh_eigen}}</td>
                  </tr>
                  <tr>
                    <td>Consistency Index(CI)</td>
                    <td>{{ $CI}}</td>
                  </tr>
                  <tr>
                  <td>Random Index(RI)</td>
                  @foreach($RI as $ri)
                  <td>{{ $ri -> nilai}}</td>
                  @endforeach
                  </tr>
                  <tr>
                  <td>Consistency Ratio(CR)</td>
                  <td>{{ $CR}}</td>
                  </tr>
                </table>
              </div>

              @if($CR <= 0.1 && $CR >= 0)
              <div class="alert alert-success">
                <h3>Data Konsisten dan Berhasil disimpan</h3>
                </div>
              @else()
                <div class="alert alert-danger">
                <h3>Data Tidak Konsisten dan Tidak disimpan</h3>
                <p>Silahkan kembali dan Ulangi!!!</p>
                </div>
              @endif
         
              <a type="submit"  class="btn btn-primary" href="{{ route('aturan') }}">Kembali</a>
            


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
  </section>
  <footer class="footer bg-dark text-white">
      <div class="container text-center">
        <br>
        <span>© Copyright 2024 Sistem Pakar Ginjal Anak. Created by Lucky Saputra</span>
      </div>
      <br>
  </footer>

</x-profil-layout>