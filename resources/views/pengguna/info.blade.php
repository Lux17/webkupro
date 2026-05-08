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

@php
  $colors = ['bg-blue', 'bg-green', 'bg-orange'];
@endphp


<div class="row g-4 mt-5">
  @forelse ($mapel as $m)

      @php
      $color = $colors[array_rand($colors)];
    @endphp

    <div class="col-md-4">
      <a href="{{ route('class', $m->id_mapel) }}" class="text-decoration-none text-dark">
        <div class="card card-class h-100">

          <div class="card-header-custom  {{ $color }} ">
            <div>
              <h5>{{ $m->nama_mapel }}</h5>
              <small>{{ $m->kelas->nama_kelas ?? '-' }}</small>
            </div>
          </div>

          <div class="card-body">
            <p><strong>{{ $m->guru->name ?? '-' }}</strong></p>
          </div>

          <div class="card-footer"></div>

        </div>
      </a>
    </div>

      @empty

    <div class="col-12 text-center">
      <div class="alert alert-info">
        Tidak ada data mapel
      </div>
    </div>
  @endforelse
</div>
</div>

<hr>
<h5>Daftar Kuis</h5>

   <div class="container mt-4">

   @foreach ($mapel as $n)

  @forelse ($n->kuis as $k)

    <div class="card mb-3 shadow-sm border-start border-secondary border-4">
      <div class="card-body d-flex justify-content-between align-items-center">

        <div>
          <h5>{{ $k->kode_kuis }}</h5>
          <small class="text-muted">
            {{ $n->kelas->nama_kelas ?? '-' }} - Durasi: {{ $k->durasi }} Menit
          </small>
        </div>

        <div>
          <a href="{{ route('quiz', $k->kode_kuis) }}" class="btn btn-primary">Mulai</a>
        </div>

      </div>
    </div>

  @empty
    {{-- kosongin biar ga spam --}}
  @endforelse

@endforeach


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

</x-user-layout>