<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Materi</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar bg-body-tertiary">
        <div class="container-fluid mt-3 mb-3 mx-5 px-5">
            <a class="btn btn-danger" href="{{ route('materi') }}">Kembali</a>
        </div>
    </nav>

    <!-- Form -->
    <form method="POST" action="/episode/simpan" enctype="multipart/form-data">
        @csrf

        <div class="container mt-5" style="max-width: 1300px;">

            <!-- Judul Materi -->
            <div class="mb-4">
                <label for="InputNama" class="form-label">Nama Episode</label>
                <input type="text" class="form-control" name="nama_eps">
            </div>


            <div class="mb-3">
                <label for="img" class="form-label">Cover</label>
                <input type="file" class="form-control"  name="img" required="">
            </div>

                <div class="mb-3">
                    <label for="InputNama" class="form-label">Episode</label>
                 <select class="form-select form-control" id="type" name="type" required>
                <option  selected >Pilih..</option>
                 <option value="1">Episode 1</option>
                 <option value="2">Episode 2</option>
                 <option value="3">Episode 3</option>
                 <option value="4">Episode 4</option>
                 <option value="5">Episode 5</option>
                 <option value="6">Episode 6</option>
                 <option value="7">Episode 7</option>
                 <option value="8">Episode 8</option>
                 <option value="9">Episode 9</option>
                 <option value="10">Episode 10</option>
                 <option value="11">Episode 11</option>
                 <option value="12">Episode 12</option>
                 <option value="13">Episode 13</option> 
                 <option value="14">Episode 14</option>  
                 <option value="15">Episode 15</option>                         
               </select>
             </div>

            <!-- Editor -->
            <div class="mb-4">
                <label for="InputNama" class="form-label">Materi/isi Episode</label>
                <textarea  id="editor" name="isi_eps"></textarea>
            </div>
            <div>
                <input type="hidden" class="form-control" name="tgl" value="{{ now() }}">
            </div>           
            <div>
                <input type="hidden" class="form-control" name="id_materi" value="{{ $id_materi }}">
            </div>   
            <!-- Button -->
            <div class="mb-5">
                <button type="submit" class="btn btn-primary btn-lg px-5">
                    Simpan
                </button>
            </div>

        </div>
    </form>

    <!-- TinyMCE -->
    <script src="https://cdn.jsdelivr.net/npm/tinymce@6/tinymce.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        tinymce.init({
            selector: '#editor',
            height: 500,
            plugins: 'image link media table code lists',
            toolbar: 'undo redo | styles | bold italic underline | alignleft aligncenter alignright | bullist numlist | image media table | code'
        });
    </script>

</body>
</html>