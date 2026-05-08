<x-user-layout>

<section id="info" class="bg-light d-flex flex-column min-vh-300">
<style>
    .card-class {
      border-radius: 12px;
      overflow: hidden;
      transition: 0.3s;
    }

    .card-class:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 20px rgba(0,0,0,0.1);
    }

    .card-header-custom {
      color: white;
      padding: 15px;
      height: 120px;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
    }
    .card-body small {
      color: gray;
    }

    .bg-blue { background: #2c7be5; }
    .bg-green { background: #20c997; }
    .bg-orange { background: #f59f00; }

    .card-footer {
      background: white;
      border-top: none;
      display: flex;
      justify-content: space-between;
    }
  </style>
    
        <div class="container">
          </div>
          <div class="d-flex justify-content-center align-items-center ">
          </div>
        <div class="bg-info border p-4 rounded bg-white " style="max-width: auto;">
          <div class="container justify-content-center align-items-center">
          
              <div class="my-5 justify-content-center align-items-center " style="width: autopx;">
 


<section style="height: 500px; ">

<div class="alert alert-danger">
    Sisa Waktu :
    <span id="timer"></span>
</div>

<div class="container mx-5 mt-3 ">
    <!-- Form -->
      <form method="POST" action="{{route ('result')}}" id="quizForm">
      @csrf



      <table >
          <input type="hidden" name="kode_kuis" value="{{ $kode_kuis }}">
      @foreach($soal as $i => $s)
      <tbody>

              <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ $s->pertanyaan }}</td>
              </tr>
                
              <tr>
                  <td></td>
                  <td>
                      <input type="hidden" name="jawaban[{{ $i }}][id_soal]" value="{{ $s->id_soal }}">
                      <input type="hidden" name="id_kuis" value="{{ $id_kuis }}">
                      <input type="hidden" name="id_mapel" value="{{ $mapel_id }}">
                      <label>
                          <input type="radio" name="jawaban[{{ $i }}][pilihan]" value="a" required>
                          A. {{ $s->opsi_a }}
                      </label><br>
                  </td>
              </tr>
              
              
              <tr>
                  <td></td>
                  <td>
                          <input type="radio" name="jawaban[{{ $i }}][pilihan]" value="b">
                          B. {{ $s->opsi_b }}
                  </td>
              </tr>

              <tr>
                  <td></td>
                  <td>
                      <label>
                          <input type="radio" name="jawaban[{{ $i }}][pilihan]" value="c">
                          C. {{ $s->opsi_c }}
                      </label><br>
                  </td>
              </tr>
              <tr>
                  <td></td>
                  <td>
                      <label>
                          <input type="radio" name="jawaban[{{ $i }}][pilihan]" value="d">
                              D. {{ $s->opsi_d }}
                      </label><br>
                  </td>
              </tr>


              <tr>
                  <td></td>
                  <td>
                      <label>
                          <input type="radio" name="jawaban[{{ $i }}][pilihan]" value="e">
                          E. {{ $s->opsi_e }}
                          </label>
                  </td>

              </tr>


      
              @endforeach
          </tbody>
      </table>



              <br>
      <button type="submit" class="btn btn-primary">Kirim Jawaban</button>
      </div>

        </div>
    </form>


  </div>
</section>
<!-- footer -->
<!-- <footer class="footer bg-dark text-white">
      <div class="container text-center">
        <br>
            <strong>Copyright &copy; 2026 MendungSTEM<a href="#">  Created by Susanti</a>.</strong>
      </div>
      <br>
</footer> -->

<script>

document.addEventListener("DOMContentLoaded", function () {

    const endTime = {{ $endTime }};

    const timer = document.getElementById('timer');

    const form = document.getElementById('quizForm');

    const countdown = setInterval(function () {

        const now = new Date().getTime();

        const distance = endTime - now;

        if (distance <= 0) {

            clearInterval(countdown);

            timer.innerHTML = "00:00";

            alert("Waktu habis!");

            form.submit();

            return;
        }

        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));

        const seconds = Math.floor((distance % (1000 * 60)) / 1000);

        timer.innerHTML =
            String(minutes).padStart(2, '0') +
            ":" +
            String(seconds).padStart(2, '0');

    }, 1000);

});

</script>

</x-user-layout>