<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>TDCI-IT Equipment Booking System</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Optional: Add Tailwind CSS or Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light text-dark">

    <div class="container d-flex flex-column justify-content-center align-items-center min-vh-100">
        <img src="{{ asset('images/1.png') }}" alt="Logo" style="height: 200px;" class="mb-3">
        <h1 class="display-4 text-center mb-4">TDCI-IT Equipment Booking System</h1>

        <p class="lead text-center mb-4">
            Manage and book available equipment easily and efficiently.

        </p>
        @auth

            <p class="mt-4">Logged in as <strong>{{ auth()->user()->name }}</strong></p>
        @else
            <div class="mt-1">
                <a href="{{ route('login') }}" class="btn btn-outline-secondary me-2">Login</a>
                 <a href="{{ route('register') }}" class="btn btn-outline-success">Register</a>
            </div>
        @endauth
            <div class="mt-3">
           <a href="{{ route('equipment.index') }}" class="btn btn-primary btn-lg">
            View Available Equipment
        </a>
           </div>
    </div>

</body>
</html>
