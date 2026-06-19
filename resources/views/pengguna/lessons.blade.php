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
            <center>
              <div class="my-5 justify-content-center align-items-center " style="width: autopx;">
 


<section style="height: 500px; ">
  

<div class="container mt-5 " >

    <nav class="navbar bg-body-tertiary">
        <div class="container-fluid mt-3 mb-3 mx-5 px-5">
            <a class="btn btn-danger" href="{{ route('info') }}">Kembali</a>
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
        <img src=" {{ asset($materi->img_materi)}}"
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

        <div class="list-group shadow-sm rounded-4">
        @foreach ($episode as $ep)
            <a href="{{ route('tampil-episode', $ep->id_eps) }}" class="list-group-item list-group-item-action episode-item">
                <div class="d-flex align-items-center">

                    <img src="{{ asset($ep->img) }} "
                         class="episode-thumb me-3">

                    <div class="flex-grow-1">
                        <h5 class="mb-1">
                          Episode {{ $ep->type }} - {{ $ep->nama_eps }}
                        </h5>

                        <small class="text-muted">
                           {{ $ep->tgl }}
                        </small>
                    </div>

                </div>
            </a>

        @endforeach
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

  <!-- <footer class="main-footer">
    <strong>Copyright &copy; 2026 MendungSTEM<a href="#">  Created by Susanti</a>.</strong>
    All rights reserved.
  </footer> -->

</x-user-layout>