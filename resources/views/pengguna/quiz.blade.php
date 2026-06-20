<x-user-layout>

<section id="info" class="bg-light d-flex flex-column min-vh-300">

  <div class="container py-4">

    <!-- Timer -->
    <div class="sticky-top mb-4 mt-5">
        <div class="alert alert-danger text-center shadow-sm">
            <h5 class="mb-0">
                ⏰ Sisa Waktu :
                <span id="timer" class="fw-bold"></span>
            </h5>
        </div>
    </div>

    <form method="POST" action="{{route ('result')}}" id="quizForm">
        @csrf

        <input type="hidden" name="kode_kuis" value="{{ $kode_kuis }}">
        <input type="hidden" name="timestamp" value="{{ now() }}">
        <input type="hidden" name="id_kuis" value="{{ $id_kuis }}">
        <input type="hidden" name="id_mapel" value="{{ $mapel_id }}">

        @foreach($soal as $i => $s)

        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-primary text-white">
                <div class="d-flex align-items-center">
                    <span class="badge bg-light text-primary me-2">
                        {{ $loop->iteration }}
                    </span>
                    <strong>{{ $s->pertanyaan }}</strong>
                </div>
            </div>

            <div class="card-body">

                <input type="hidden"
                       name="jawaban[{{ $i }}][id_soal]"
                       value="{{ $s->id_soal }}">
                <div class="d-grid gap-2">

                    <input type="radio"
                        class="btn-check"
                        name="jawaban[{{ $i }}][pilihan]"
                        id="soal{{ $i }}a"
                        value="a"
                        required>

                    <label class="btn btn-outline-primary text-start"
                        for="soal{{ $i }}a">
                        A. {{ $s->opsi_a }}
                    </label>


                    <input type="radio"
                        class="btn-check"
                        name="jawaban[{{ $i }}][pilihan]"
                        id="soal{{ $i }}b"
                        value="b">

                    <label class="btn btn-outline-primary text-start"
                        for="soal{{ $i }}b">
                        B. {{ $s->opsi_b }}
                    </label>


                    <input type="radio"
                        class="btn-check"
                        name="jawaban[{{ $i }}][pilihan]"
                        id="soal{{ $i }}c"
                        value="c">

                    <label class="btn btn-outline-primary text-start"
                        for="soal{{ $i }}c">
                        C. {{ $s->opsi_c }}
                    </label>


                    <input type="radio"
                        class="btn-check"
                        name="jawaban[{{ $i }}][pilihan]"
                        id="soal{{ $i }}d"
                        value="d">

                    <label class="btn btn-outline-primary text-start"
                        for="soal{{ $i }}d">
                        D. {{ $s->opsi_d }}
                    </label>


                    <input type="radio"
                        class="btn-check"
                        name="jawaban[{{ $i }}][pilihan]"
                        id="soal{{ $i }}e"
                        value="e">

                    <label class="btn btn-outline-primary text-start"
                        for="soal{{ $i }}e">
                        E. {{ $s->opsi_e }}
                    </label>

                </div>
            </div>
        </div>

        @endforeach

        <div class="text-center">
            <button type="submit" class="btn btn-primary btn-lg px-5 shadow">
                Kirim Jawaban
            </button>
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