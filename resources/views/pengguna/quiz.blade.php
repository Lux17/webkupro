<x-user-layout>

<section class="user-surface">
  <div class="container" style="max-width: 920px;">

    <div class="quiz-timer-bar mb-4">
        ⏰ Sisa Waktu :
        <span id="timer" class="fw-bold">--:--</span>
    </div>

    <div class="ms-hero mb-4" style="padding:1.25rem 1.4rem;">
      <div class="ms-badge">📝 Mode Kuis</div>
      <h2 class="h4 mb-1">Kerjakan dengan teliti</h2>
      <p class="mb-0">Pilih satu jawaban untuk setiap soal. Jawaban akan otomatis terkirim saat waktu habis.</p>
    </div>

    <form method="POST" action="{{ route('result') }}" id="quizForm">
        @csrf

        <input type="hidden" name="kode_kuis" value="{{ $kode_kuis }}">
        <input type="hidden" name="timestamp" value="{{ now() }}">
        <input type="hidden" name="id_kuis" value="{{ $id_kuis }}">
        <input type="hidden" name="id_mapel" value="{{ $mapel_id }}">

        @foreach($soal as $i => $s)
        <div class="quiz-question-card">
            <div class="q-head d-flex align-items-start gap-2">
                <span class="badge bg-light text-primary">{{ $loop->iteration }}</span>
                <span>{{ $s->pertanyaan }}</span>
            </div>

            <div class="q-body">
                <input type="hidden"
                       name="jawaban[{{ $i }}][id_soal]"
                       value="{{ $s->id_soal }}">

                <div class="d-grid gap-2">
                    @foreach (['a' => $s->opsi_a, 'b' => $s->opsi_b, 'c' => $s->opsi_c, 'd' => $s->opsi_d, 'e' => $s->opsi_e] as $key => $opsi)
                        @if(filled($opsi))
                            <input type="radio"
                                class="btn-check"
                                name="jawaban[{{ $i }}][pilihan]"
                                id="soal{{ $i }}{{ $key }}"
                                value="{{ $key }}"
                                {{ $key === 'a' ? 'required' : '' }}>

                            <label class="btn quiz-option-label"
                                for="soal{{ $i }}{{ $key }}">
                                <strong class="me-1">{{ strtoupper($key) }}.</strong> {{ $opsi }}
                            </label>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
        @endforeach

        <div class="text-center pb-4">
            <button type="submit" class="btn btn-primary btn-lg px-5">
                Kirim Jawaban
            </button>
        </div>
    </form>

  </div>
</section>

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
