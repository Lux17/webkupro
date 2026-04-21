<x-user-layout>

<section id="info" class="bg-light">
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

    .question {
    margin: 5px;
      } 

      .options {
          display: flex;
          gap: 10px;
      } 

      input[type="radio"] {

          display: none;
      }

      .label {
          padding: 10px 20px;
          border: 2px solid #007BFF;
          border-radius: 15px;
          cursor: pointer;
          user-select: none; /* Menghindari teks dipilih */
          display: inline-block;
          transition: background-color 0.3s, color 0.3s;
      }

      input[type="radio"]:checked + .label {
          background-color: #007BFF;
          color: white;
      }

      label:hover {
          background-color: #0056b3;
          color: white;
      } 
    </style>
    <section id="info" class="bg-light">
        <div class="container">
            <div class="d-flex justify-content-center align-items-center">
            </div>
        </div>
        <div class="bg-info border p-4 rounded bg-white " style="max-width: auto;">
          <div class="container justify-content-center align-items-center">
          <center>
              <div class="my-5 justify-content-center align-items-center " style="width: auto;">
                <div class="progress ">
                <div class="progress-bar" role="progressbar" style="width: 32%;" aria-valuenow="32" aria-valuemin="0" aria-valuemax="100"></div>
                <div class="progress-bar bg-warning" role="progressbar" style="width: 39%;" aria-valuenow="39" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <div class="container mt-2">
                <div class="row">
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
            <p>ID Diagnosis: {{ $diagnosa_kode = uniqid(); }}</p>
            @if(session('danger'))
              <div class="alert alert-danger">
            {{ session('danger') }}
              </div>
            @endif
            <p>Dalam 1 minggu terakhir, seberapa sering masalah-masalah berikut ini?<br></p>
            <p>Semua field harus diisi, jadi pastikan untuk memberikan jawaban yang tepat sesuai dengan kondisi mu(anak).</p>
            <form action="{{ route('hasildiagnosis', $diagnosa_kode) }}"method='post' enctype='multipart/form-data' id='gform_01' novalidate>
            @csrf
            @php
                $hasShownPrimaryHeader = false;
                $hasShownWarningHeader = false;
                $hasShownDangerHeader = false;
            @endphp
            @for($i=0; $i < (count($list)); $i++ )
            @if(($list[$i]['type'] == 0 || $list[$i]['type'] == 1) && !$hasShownPrimaryHeader)
                <h4>Dibawah ini terdapat pertanyaan-pertanyaan terkait gejala yang ringan pada penyakit ginjal</h4>
                <h5>Silahkan jawab pertanyaan dibawah:</h5>
                @php
                    $hasShownPrimaryHeader = true; // Set flag untuk header Primary
                @endphp
            @elseif($list[$i]['type'] == 2 && !$hasShownWarningHeader)
                <h4>Dibawah ini terdapat pertanyaan-pertanyaan terkait gejala Sedang pada penyakit ginjal</h4>
                <h5>Silahkan jawab pertanyaan dibawah:</h5>
                @php
                    $hasShownWarningHeader = true; // Set flag untuk header Warning
                @endphp
            @elseif($list[$i]['type'] == 3 && !$hasShownDangerHeader)
            <h4>Dibawah ini terdapat pertanyaan-pertanyaan terkait gejala Berat pada penyakit ginjal</h4>
            <h5>Silahkan jawab pertanyaan dibawah:</h5>
            @php
              $hasShownDangerHeader = true; // Set flag untuk header Warning
            @endphp
            @endif

              @if( $list[$i]['type'] == 0 || $list[$i]['type'] == 1)
              <div  class="question table-responsive ">
                <p>{{ $i+ 1 }}. ({{ $list[$i]['kode_gejala']}}) <span class="badge rounded-pill text-bg-primary">Gejala Ringan</span> Apakah Merasa {{ $list[$i]['nama_gejala'] }}?</p>
                <div class="container text-center mb-3 options" >
                    @foreach ($kondisi as $k)
                      <input class="form-check-input custom-control-input" type="radio" name="kondisi_{{ $list[$i] ['kode_gejala'] }}" id="kondisi_{{ $list[$i]['kode_gejala']  }}_{{ $k->nilai }}" required="required" value="{{ $k->nilai }}"  onchange="document.getElementById('kondisi_{{ $list[$i] ['kode_gejala'] }}_{{ $k->nilai }}').value = this.value ">
                      <label class="form-check-label label span" for="kondisi_{{ $list[$i]['kode_gejala']  }}_{{ $k->nilai }}" style="display: block; font-size: smaller;" required="required">{{ $k->kondisi }}</label>
                  @endforeach
                </div>
              </div>
              @elseif( $list[$i]['type'] == 2)
              <div  class="question table-responsive ">
                <p>{{ $i+ 1 }}. ({{ $list[$i]['kode_gejala']}}) <span class="badge rounded-pill text-bg-warning">Gejala Sedang</span> Apakah Merasa {{ $list[$i]['nama_gejala'] }}?</p>
                <div class="container text-center mb-3 options" >
                    @foreach ($kondisi as $k)
                      <input class="form-check-input custom-control-input" type="radio" name="kondisi_{{ $list[$i] ['kode_gejala'] }}" id="kondisi_{{ $list[$i]['kode_gejala']  }}_{{ $k->nilai }}" required="required" value="{{ $k->nilai }}"  onchange="document.getElementById('kondisi_{{ $list[$i] ['kode_gejala'] }}_{{ $k->nilai }}').value = this.value ">
                      <label class="form-check-label label span" for="kondisi_{{ $list[$i]['kode_gejala']  }}_{{ $k->nilai }}" style="display: block; font-size: smaller;" required="required">{{ $k->kondisi }}</label>
                  @endforeach
                </div>
              </div>
              @else
              <div  class="question table-responsive ">
                <p>{{ $i+ 1 }}. ({{ $list[$i]['kode_gejala']}}) <span class="badge rounded-pill text-bg-danger">Gejala Berat</span> Apakah Merasa {{ $list[$i]['nama_gejala'] }}?</p>
                <div class="container text-center mb-3 options" >
                    @foreach ($kondisi as $k)
                      <input class="form-check-input custom-control-input" type="radio" name="kondisi_{{ $list[$i] ['kode_gejala'] }}" id="kondisi_{{ $list[$i]['kode_gejala']  }}_{{ $k->nilai }}" required="required" value="{{ $k->nilai }}"  onchange="document.getElementById('kondisi_{{ $list[$i] ['kode_gejala'] }}_{{ $k->nilai }}').value = this.value ">
                      <label class="form-check-label label span" for="kondisi_{{ $list[$i]['kode_gejala']  }}_{{ $k->nilai }}" style="display: block; font-size: smaller;" required="required">{{ $k->kondisi }}</label>
                  @endforeach
                </div>
              </div>
              @endif
           @endfor
              </div>
              <input type="hidden" name="kode_diagnosa"  value="{{ $diagnosa_kode }}" >
              <button class="button-lanjut my-3 "	onclick=' if( !jQuery("#gform_01")[0].checkValidity || jQuery("#gform_01")[0].checkValidity()){window["gf_submitting_1"]=true;}  '
              onkeypress='if( event.keyCode == 13 ){ if(window["gf_submitting_1"]){return false;} if( !jQuery("#gform_01")[0].checkValidity || jQuery("#gform_01")[0].checkValidity()){window["gf_submitting_1"]=true;}  jQuery("#gform_01").trigger("submit",[true]); }' />
                <a class="text-decoration-none text-white " >Cek Hasil Diagnosis</a>
                <svg fill="currentColor" viewBox="0 0 24 24" class="icon-lanjut">
                  <path
                    clip-rule="evenodd"
                    d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zm4.28 10.28a.75.75 0 000-1.06l-3-3a.75.75 0 10-1.06 1.06l1.72 1.72H8.25a.75.75 0 000 1.5h5.69l-1.72 1.72a.75.75 0 101.06 1.06l3-3z"
                    fill-rule="evenodd"
                  ></path>
                </svg>
              </button>
            </form>
          </div>
        </div>
    </section>

    

  <!-- Modal Peringatan -->
  <div class="modal fade" id="validationModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exitLabel">Peringatan</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          Peringatan, Harap isi semua pertanyaan.
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Tutup</button>
        </div>
      </div>
    </div>
  </div>
  <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- jQuery (optional for Bootstrap) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<!-- Custom JavaScript for form validation -->
<script>
  // Validasi Sebelum Submit
  function validateForm() {
    // Array untuk simpan hasil validasi
    var validations = [];

    // Validasi pertanyaan
    var questions = document.querySelectorAll('[name^="kondisi_"]');
    questions.forEach(function(question) {
      var checked = document.querySelector('[name="' + question.name + '"]:checked');
      if (!checked) {
        validations.push(false);
      } else {
        validations.push(true);
      }
    });

    // Menampilkan peringatan suruh isi semua
    if (validations.includes(false)) {
          $('#validationModal').modal('show');
          return false;
        }
    return true;
  }

  // buat membaca form
  $('#gform_01').submit(function() {
    return validateForm();
  });
</script>
<!-- Footer -->
    <footer class="footer bg-dark text-white">
      <div class="container text-center">
        <br>
        <span>© Copyright 2024 Sistem Pakar Ginjal Anak. Created by Lucky Saputra</span>
      </div>
      <br>
    </footer>
</x-user-layout>