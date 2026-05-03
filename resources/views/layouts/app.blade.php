<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'TDCI-IT Booking System')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body class="bg-gray-100 text-gray-800 min-h-screen">
  <nav class="bg-white shadow-md p-4">
    <div class="container mx-auto flex justify-between items-center">
        <div class="flex items-center gap-3">
    <a href="{{ url('/') }}" class="flex items-center gap-2 text-decoration-none">
        <img src="{{ asset('images/1.png') }}" alt="Logo" style="height: 40px;">
        <span class="font-bold text-lg text-dark">TDCI- IT Booking System</span>
    </a>
    @auth
        @unless(Auth::user()->is_admin)
            <a href="{{ url('/') }}" style="padding: 5px 12px;  text-decoration: none; color: black;">
                Home
            </a>
            <a href="{{ route('bookings.index') }}" style="padding: 5px 12px;  text-decoration: none; color: black;">
                Dashboard
            </a>
                <a href="{{ route('equipment.index') }}" style="padding: 5px 12px;  text-decoration: none; color: black;">
                View Equipment
            </a>
        @endunless
    @endauth
@auth
    @if(Auth::user()->is_admin)
        <a href="{{ route('admin.bookings.index') }}"
           style="padding: 6px 12px; ; text-decoration: none; color: black;">
            View Bookings
        </a>
               <a href="{{ route('admin.dashboard') }}"
           style="padding: 6px 12px; ; text-decoration: none; color: black;">
           Equipments
    </a>
        <a href="{{ route('admin.bookings.trashed') }}"
           style="padding: 6px 12px; ; text-decoration: none; color: black;">
            Trashed Bookings
               </a>
    @endif
@endauth

        </div>

            @auth
                <div>
                    Welcome, {{ Auth::user()->name }} |
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="text-red-500">Logout</button>
                    </form>
                </div>
            @endauth
        </div>
    </nav>

    <main class="container mx-auto mt-8">
        @yield('content')
    </main>
</body>
</html>
