<x-user-layout>

<section class="user-surface d-flex align-items-center">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-7 col-lg-5">
                <div class="card border-0 shadow" style="border-radius:24px;">
                    <div class="card-body text-center p-4 p-md-5">
                        <div style="font-size:3rem; line-height:1;">✅</div>
                        <h2 class="fw-bold mt-2 mb-1">Selamat!</h2>
                        <p class="text-muted mb-3">Nilai kamu untuk kuis ini</p>

                        <div class="display-3 fw-bold text-success mb-3">{{ $nilai2 }}</div>

                        <div class="alert alert-success">
                            <strong>Hebat!</strong><br>
                            Kamu sudah menyelesaikan kuis. Terus semangat belajar!
                        </div>

                        <a href="{{ route('info') }}" class="btn btn-primary px-4">
                            Kembali ke Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

</x-user-layout>
