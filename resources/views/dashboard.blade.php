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
                <p>Jumlah Kelas</p>
                <h3>{{ $hitung_kelas }}</h3>
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
                <p>Jumlah Kuis</p>
                <h3>{{ $hitung_kuis }}</h3>
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
                  <p>Jumlah Siswa</p>
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
                <p>Jumlah Guru</p>
                <h3>{{ $hitung_guru }}</h3>
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

              </div>
            </div>
      </div>
    </section>
    </div>
      </div>
    </section>
  </div>

  <footer class="main-footer">
    <strong>Copyright &copy; 2026 <a href="#">Created</a>.</strong>
    All rights reserved.
  </footer>

  </main>
</x-app-layout>
