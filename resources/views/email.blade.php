@extends('landing.layouts.main')

@section('content')
@include('landing.partials.navbar')

<main class="main">
    <style>
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            background-color: #f8f9fa;
            justify-content: center;
            align-items: center;
        }
        .verification-container {
            background-color: white;
            padding: 2rem;
            border-radius: 0.5rem;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            text-align: center;
        }
        .verification-container img {
            width: 50px;
            margin-bottom: 1rem;
        }
        .verification-container h1 {
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }
        .verification-container p {
            margin-bottom: 1rem;
            color: #6c757d;
        }
        .verification-container .btn-primary {
            width: 100%;
        }
        footer {
            margin-top: auto;
            padding: 1rem;
            background-color: #343a40;
            color: white;
            width: 100%;
            text-align: center;
        }
    </style>
</head>
<body class ="mb-5">
    <br>
    <div class="verification-container border p-4 m-5 my-5 rounded">
    <div class ="align-center text-center my-5">
    <img src="{{ asset('assets/images/logo.png') ;}}" style="height: 60px;" alt="">
    <h5 style="color: #0a44c1;">SP KidneyKids</h5>
        <h1>Verify Your Email Address</h1>
        <p>In order to start using your account, you need to confirm your email address.</p>
        @if (session('message'))
            <div class="alert alert-success" role="alert">
                {{ session('message') }}
            </div>
        @endif
        <form method="POST" action="">
            @csrf
            <button type="submit" class="btn btn-primary">Verify Email Address</button>
        </form>
        <p>If you did not sign up for this account, you can ignore this email and the account will be deleted.</p>
    </div>
</body>
</main>


