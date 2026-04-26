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
    <h3>Data Soal Kuis</h3>

    <table >
    @foreach($soal as $k)
     <tbody>

            <tr>
                <td style="width: 50px;">{{ $loop->iteration }}</td>
                <td>{{ $k->pertanyaan }}</td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <label>
                        <input type="radio" name="answers[{{ $k->id_kuis }}]" value="a" required>
                        A. {{ $k->opsi_a }}
                    </label><br>
                </td>
            </tr>
            
            
            <tr>
                <td></td>
                <td>
                        <input type="radio" name="answers[{{ $k->id_kuis }}]" value="b">
                        B. {{ $k->opsi_b }}
                </td>
            </tr>

            <tr>
                <td></td>
                <td>
                    <label>
                        <input type="radio" name="answers[{{ $k->id_kuis }}]" value="c">
                        C. {{ $k->opsi_c }}
                    </label><br>
                </td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <label>
                        <input type="radio" name="answers[{{ $k->id_kuis }}]" value="d">
                            D. {{ $k->opsi_d }}
                    </label><br>
                </td>
            </tr>


            <tr>
                <td></td>
                <td>
                    <label>
                        <input type="radio" name="answers[{{ $k->id_kuis }}]" value="e">
                        E. {{ $k->opsi_e }}
                        </label>
                </td>

            </tr>
            <tr>
                <td></td>
                <td>
                 <label for="LabelInput" class="form-label ">Jawaban Benar: </label>
                  <p >{{ $k->jawaban }} </p>
                </td>

            </tr>


    
            @endforeach
        </tbody>
    </table>
    </div>



    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>


</body>
</html>