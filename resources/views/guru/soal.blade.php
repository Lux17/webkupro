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
<div class="container mx-5 mt-3 ">
    <!-- Form -->
    <form method="POST" action="{{route ('hasil')}}">
    @csrf

    <h3>Data Soal Kuis</h3>

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


    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>


</body>
</html>