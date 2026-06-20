<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $materi->title }}</title>
    <link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

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
            <center>
              <div class="my-5 justify-content-center align-items-center " style="width: autopx;">
 


<section style="height: 500px; ">
  

<div class="container mt-5 " >

    <nav class="navbar bg-body-tertiary">
        <div class="container-fluid mt-3 mb-3 mx-5 px-5">
            <a class="btn btn-danger" href="{{ route('materi') }}">Kembali</a>
        </div>
    </nav>
    <div class="container mt-5 mx-5 p-4 border rounded">

    </p>

        <style>
        body{
            background:#f5f5f5;
        }

        .cover{
            height:350px;
            object-fit:cover;
            width:100%;
            border-radius:15px;
        }

        .comic-card{
            background:#fff;
            border-radius:15px;
            box-shadow:0 5px 15px rgba(0,0,0,.08);
            overflow:hidden;
        }

        .episode-item{
            transition:.3s;
            cursor:pointer;
        }

        .episode-item:hover{
            background:#f8f9fa;
            transform:translateX(5px);
        }

        .episode-thumb{
            width:90px;
            height:90px;
            object-fit:cover;
            border-radius:10px;
        }

        .badge-genre{
            background:#00d564;
        }
  
        #description{
            overflow: hidden;
            display: -webkit-box;
            -webkit-box-orient: vertical;
            -webkit-line-clamp: 3;
            transition: .3s;
        }

        #description.show{
            -webkit-line-clamp: unset;
        }

        #toggle{
            cursor: pointer;
        }
    </style>
</head>
<body>

<div class="container py-5">

    <div class="comic-card">

        <!-- Cover -->
        <img src=" {{ asset($materi->img) }}"
             class="img-fluid">

        <div class="p-4">

            <!-- Judul -->
            <h2 class="fw-bold mb-2">
                {{ $materi->title }}
            </h2>

            <!-- Informasi -->
            <div class="mt-3 text-muted">
                <small>
                    📖 {{ $hitung_episode }} Episode
                </small>
            </div>
            <p id="description">
                {{ $materi->deskripsi }}
            </p>

            <a id="toggle" class="text-success fw-bold">
                Lihat Selengkapnya
            </a>
        </div>

    </div>


    <!-- Episode -->
    <div class="mt-5">

        <h3 class="fw-bold mb-4">
            Daftar Episode
        </h3>

<div class="list-group shadow rounded">

    @foreach ($episode as $ep)

        <div class="list-group-item py-3">
            <div class="d-flex justify-content-between align-items-center">

                <!-- Informasi Episode -->
                <a href="#" class="d-flex align-items-center text-decoration-none text-dark flex-grow-1">

                    <img src="{{ asset($ep->img) }}"
                        alt="{{ $ep->nama_eps }}"
                        class="rounded me-3"
                        style="width:80px; height:80px; object-fit:cover;">

                    <div>
                        <h5 class="mb-1 mx-5">
                            Episode {{ $ep->type }} - {{ $ep->nama_eps }}
                        </h5>

                        <small class="text-muted">
                            {{ $ep->tgl }}
                        </small>
                    </div>

                </a>

                <!-- Tombol -->
                <div class="d-flex gap-2 ms-3">

                    <a href="{{ route('tampil-episode', $ep->id_eps) }}"
                        class="btn btn-outline-primary btn-sm">
                        <i class="fa-regular fa-eye" style="color: blue;"></i>
                    </a>

                    <a href="{{ route('ubah-episode', $ep->id_eps) }}"
                        class="btn btn-outline-primary btn-sm">
                        <i class="fa-regular fa-pen-to-square" style="color: blue;"></i>
                    </a>

                    <button
                        class="btn btn-outline-danger btn-sm"
                        data-bs-toggle="modal"
                        data-bs-target="#hapus{{ $ep->id_eps }}">
                        <i class="fa-solid fa-trash"></i>
                    </button>

                </div>

           
            
            <!-- Modal -->
            <div class="modal fade"
                id="hapus{{ $ep->id_eps }}"
                tabindex="-1"
                aria-hidden="true">

                <div class="modal-dialog">
                    <div class="modal-content">

                        <div class="modal-header">
                            <h5 class="modal-title">Hapus Episode</h5>

                            <button type="button"
                                class="btn-close"
                                data-bs-dismiss="modal">
                            </button>
                        </div>

                        <div class="modal-body">
                            Apakah Anda yakin ingin menghapus episode ini?
                        </div>

                        <div class="modal-footer">

                            <button type="button"
                                class="btn btn-secondary"
                                data-bs-dismiss="modal">
                                Batal
                            </button>

                            <form action="{{ route('hapus_episode', $ep->id_eps) }}"
                                method="POST">
                                @csrf
                                @method('DELETE')

                                <button class="btn btn-danger">
                                    Hapus
                                </button>
                            </form>

                        </div>

                    </div>
                </div>

            </div>

        </div>
 </div>



@endforeach

    <div class="list-group shadow-sm rounded-4 mt-4">
            <a href="{{ route('tambah-episode', $materi->id_materi) }}" class="list-group-item list-group-item-action bg-primary">
                <div class="d-flex justify-content-center align-items-center">
                    <h5 class="mb-0 text-white">
                        Tambah Episode
                    </h5>
                </div>
            </a>

    
        </div>

    </div>

</div>
    </div>
    </div>


</div>
</section>



<script>
const desc = document.getElementById('description');
const toggle = document.getElementById('toggle');

toggle.addEventListener('click', function () {

    desc.classList.toggle('show');

    if(desc.classList.contains('show')){
        toggle.innerText = 'Lihat Lebih Sedikit';
    }else{
        toggle.innerText = 'Lihat Selengkapnya';
    }

});
</script>



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