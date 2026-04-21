<x-app-layout>
      <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
    <div class="container-fluid">
    <section class="content">
      <div class="container-fluid">

        <h1>Dashboard</h1>
        <p>Selamat datang, {{ $user->name }}!</p>
        <div class="row">
          <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
              <div class="inner">
                <p>Jumlah Penyakit</p>
                <h3>{{ $hitung_penyakit }}</h3>
              </div>
              <div class="icon">
                <i class="fa-solid fa-virus"></i>
              </div>
            </div>
          </div>



          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <p>Jumlah Gejala</p>
                <h3>{{ $hitung_gejala }}</h3>
              </div>
              <div class="icon">
                <i class="fa-solid fa-list-check"></i>
              </div>
            </div>
          </div>

          

          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                  <p>Jumlah Pengguna</p>
                <h3>{{ $hitung_users }}</h3>
              </div>
              <div class="icon">
                <i class="fa-solid fa-users"></i>
              </div>
            </div>
          </div>

          


          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <p>Jumlah Diagnosis</p>
                <h3>{{ $hitung_diagnosis }}</h3>
              </div>
              <div class="icon">
                <i class="fa-solid fa-rectangle-list "></i>
              </div>
            </div>
          </div>

          
        </div>
        <!-- /.row -->
        <!-- Main row -->
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h3 class="card-title">Tabel Penyakit</h3>
    
                    <div class="card-tools">
                    </div>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body table-responsive p-0" style="height: 300px;">
                    <table class="table table-head-fixed">
                      <thead>
                      <tr>
                        <th scope="col">No</th>
                        <th scope="col">Kode Penyakit</th>
                        <th scope="col">Nama Penyakit</th>
                        <th scope="col">Solusi</th>
                      </tr>
                    </thead>
                    <tbody>
                    @foreach ($penyakit as $p)
                      <tr>
                      <th scope="row">{{ $loop->iteration }}</th>
                          <td>{{ $p->kode_penyakit }}</td>
                          <td>{{ $p->nama_penyakit }}</td>
                          <td>{{ $p->solusi }}</td>
                        @endforeach
                      </tr>
                      </tbody>
                    </table>
                  </div>
                  </div>
                  </div>
                </section>
          </div>

            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h3 class="card-title">Tabel Gejala</h3>
    
                    <div class="card-tools">
                    </div>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body table-responsive p-0" style="height: 300px;">
                    <table class="table table-head-fixed">
                      <thead>
                      <tr>
                        <th scope="col">No</th>
                        <th scope="col">Kode Gejala</th>
                        <th scope="col">Nama Gejala</th>
                        <th scope="col">Jenis</th>
                      </tr>
                    </thead>
                    <tbody>
                    @foreach ($gejala as $g)
                      <tr>
                          <th scope="row">{{ $loop->iteration }}</th>
                          <td>{{ $g->kode_gejala }}</td>
                          <td>{{ $g->nama_gejala }}</td>
                          <td>{{ $g->jenis }}</td>
                    @endforeach
                      </tr>
                      </tbody>
                    </table>
                  </div>
                  </div>
                  </div>
      </div>
    </section>
    </div>
      </div>
    </section>
  </div>

  <footer class="main-footer">
    <strong>Copyright &copy; 2024 <a href="#">Sistem Pakar Ginjal Anak. Created by Lucky Saputra</a>.</strong>
    All rights reserved.
  </footer>

  </main>
</x-app-layout>
