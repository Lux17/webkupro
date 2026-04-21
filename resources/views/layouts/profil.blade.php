<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>Sistem Pakar Diagnosis Penyakit Ginjal Pada anak Menggunakan Metode AHP dan Certainty Factor</title>
  <meta content="" name="description">
  <meta content="" name="keywords">


  <link href="{{ asset('assets/images/logo.png') }}" rel="icon">

  <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" />


  <link href="{{ asset('assets/fontawesome-6.5.2/css/fontawesome.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/fontawesome-6.5.2/css/brands.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/fontawesome-6.5.2/css/solid.css') }}" rel="stylesheet" />
  <link rel="stylesheet" href="{{ asset('assets-admin/dist/css/adminlte.min.css') }}">
  <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/simple-datatables/style.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
</head>
    <body class="font-sans antialiased">
 
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
        <script src="{{ asset('assets/vendor/simple-datatables/simple-datatables.js') }}"></script>
        <script src="{{ asset('assets/js/main.js') }}"></script>
        <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    </body>
</html>
