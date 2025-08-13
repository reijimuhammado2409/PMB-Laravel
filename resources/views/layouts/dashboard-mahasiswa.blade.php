<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Mahasiswa')</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 text-gray-900 flex flex-col min-h-screen">

    {{-- Navbar Mahasiswa --}}
    @include('partials.navbar-mahasiswa')

    <div class="flex flex-1">
        {{-- Sidebar Mahasiswa --}}
        @include('partials.sidebar-mahasiswa')

        <main class="flex-1 p-6">
            @yield('content')
        </main>
    </div>

    @include('partials.footer')
</body>
</html>
