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

  <link rel="preconnect" href="https://fonts.bunny.net">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous" />
  <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" />
  <script src="{{ asset('assets/jquery/jquery.mina7a0.js?ver=3.6.1') }} "></script>
  <script src="{{ asset('assets/jquery/jquery-migrate.mind617.js?ver=3.3.2') }} "></script>

</head>

    <body class="font-sans antialiased">
    <style>
    @media (max-width: 768px) {
    .text-informasi{
        font-size: 8px;
    }

    }
    </style>
        <div class="min-h-screen">
            <livewire:user.navigation />
            <!-- Header -->
            @if (isset($header))
                <header class="bg-white ">
                    <div >
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
        
        @livewireScripts
        <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    </body>
</html>
