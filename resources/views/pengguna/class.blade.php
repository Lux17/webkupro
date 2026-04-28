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


<h5>Daftar Materi</h5>

   <div class="container mt-4">

@foreach ($materi as $m)
    <div class="card mb-3 shadow-sm border-start border-light border-4">
      <div class="card-body d-flex justify-content-between align-items-center">

        <div>
          <h5>{{ $m->title }}</h5>
          <small class="text-muted">
            Tanggal : {{ $m->tgl }} 
          </small>
        </div>

        <div>
          <a href="{{ route('lessons', $m->id_materi) }}" class="btn btn-primary">Lihat</a>
        </div>

      </div>
    </div>
@endforeach

</div>
</section>
<!-- footer -->
<footer class="footer bg-dark text-white">
      <div class="container text-center">
        <br>
        <span>© Copyright 2024 Sistem Pakar Ginjal Anak. Created by Lucky Saputra</span>
      </div>
      <br>
</footer>

</x-user-layout>