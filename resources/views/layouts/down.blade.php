<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>Download - Sistem Pakar Diagnosis Penyakit Ginjal Pada anak Menggunakan Metode AHP dan Certainty Factor</title>
  <meta content="" name="description">
  <meta content="" name="keywords">
</head>
    <body class="font-sans antialiased">
 
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">


            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
        
    </body>
</html>
