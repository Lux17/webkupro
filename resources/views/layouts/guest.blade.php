<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <!-- <meta name="viewport" content="width=device-width, initial-scale=1"> -->
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Sistem Pakar Diagnosis Penyakit Ginjal Pada anak Menggunakan Metode AHP dan Certainty Factor</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link rel="stylesheet" href="{{ asset('assets-admin/dist/css/adminlte.min.css') }}">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous" />
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" />
        <link href="{{ asset('assets/images/logo.png') }}" rel="icon">
        <!-- Scripts -->
        <!-- @vite(['resources/css/app.css', 'resources/js/app.js']) -->
    </head>
    <body>
    <style>
@media (min-width: 769px) {
  .masuk{
    width: 455px;
  }
  .forgot{
    width: 460px; 
    height: 440px;
  }
  .reset{
    width: 480px; 
    height: 590px;
  }
}
</style>
    <section id="masuk" class="bg-light align-items-center " style=" height: 175vh; background-size: cover; background-image: url({{ asset('assets/images/bg-01.jpg') ;}})">
        <div class="container d-flex justify-content-center align-items-center" style="">
                {{ $slot }}
            </div>
        </div>
    </div>              
    </section>

    <script type="text/javascript">
        function password_show_hide() {
          var x = document.getElementById("password");
          var show_eye = document.getElementById("show_eye");
          var hide_eye = document.getElementById("hide_eye");
          hide_eye.classList.remove("d-none");
          if (x.type === "password") {
            x.type = "text";
            show_eye.style.display = "none";
            hide_eye.style.display = "block";
          } else {
            x.type = "password";
            show_eye.style.display = "block";
            hide_eye.style.display = "none";
          }
        }
        function password_show_hide2() {
          var x = document.getElementById("password_confirmation");
          var show_eye = document.getElementById("show_eye2");
          var hide_eye = document.getElementById("hide_eye2");
          hide_eye.classList.remove("d-none");
          if (x.type === "password") {
            x.type = "text";
            show_eye.style.display = "none";
            hide_eye.style.display = "block";
          } else {
            x.type = "password";
            show_eye.style.display = "block";
            hide_eye.style.display = "none";
          }
        }
    </script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    </body>
</html>
