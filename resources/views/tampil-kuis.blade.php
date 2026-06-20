<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah kuis</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar bg-body-tertiary">
        <div class="container-fluid mt-3 mb-3 mx-5 px-5">
            <a class="btn btn-danger" href="{{ route('kuis') }}">Kembali</a>
        </div>
    </nav>

<div class="container mt-4">

    <h3 class="mb-4">Data Soal Kuis</h3>

    @foreach($soal as $k)

    <div class="card shadow-sm mb-4">
        <div class="card-header">
            <div class="d-flex align-items-center">
                <span class="badge bg-primary me-2">
                    {{ $loop->iteration }}
                </span>

                <strong>{{ $k->pertanyaan }}</strong>
            </div>
        </div>

        <div class="card-body">

            <div class="d-grid gap-2">

                <input type="radio"
                       class="btn-check"
                       name="answers[{{ $k->id_kuis }}]"
                       id="soal{{ $k->id_soal }}a"
                       value="a">

                <label class="btn btn-outline-primary text-start"
                       for="soal{{ $k->id_soal }}a">
                    A. {{ $k->opsi_a }}
                </label>


                <input type="radio"
                       class="btn-check"
                       name="answers[{{ $k->id_kuis }}]"
                       id="soal{{ $k->id_soal }}b"
                       value="b">

                <label class="btn btn-outline-primary text-start"
                       for="soal{{ $k->id_soal }}b">
                    B. {{ $k->opsi_b }}
                </label>


                <input type="radio"
                       class="btn-check"
                       name="answers[{{ $k->id_kuis }}]"
                       id="soal{{ $k->id_soal }}c"
                       value="c">

                <label class="btn btn-outline-primary text-start"
                       for="soal{{ $k->id_soal }}c">
                    C. {{ $k->opsi_c }}
                </label>


                <input type="radio"
                       class="btn-check"
                       name="answers[{{ $k->id_kuis }}]"
                       id="soal{{ $k->id_soal }}d"
                       value="d">

                <label class="btn btn-outline-primary text-start"
                       for="soal{{ $k->id_soal }}d">
                    D. {{ $k->opsi_d }}
                </label>


                <input type="radio"
                       class="btn-check"
                       name="answers[{{ $k->id_kuis }}]"
                       id="soal{{ $k->id_soal }}e"
                       value="e">

                <label class="btn btn-outline-primary text-start"
                       for="soal{{ $k->id_soal }}e">
                    E. {{ $k->opsi_e }}
                </label>

            </div>

            <hr>

            <div>
                <span class="badge bg-success">
                    Jawaban Benar: {{ strtoupper($k->jawaban) }}
                </span>
            </div>

        </div>
    </div>

    @endforeach

</div>
        </tbody>
    </table>
    </div>



    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>


</body>
</html>