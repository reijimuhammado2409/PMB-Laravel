<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Admin')</title>
    @vite('resources/css/app.css')

    {{-- Alpine.js untuk dropdown dan interaksi sidebar --}}
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://unpkg.com/alpinejs" defer></script>
</head>
<body class="bg-gray-100 text-gray-900 flex flex-col min-h-screen">

    {{-- Navbar Admin --}}
    @include('partials.navbar-admin')

    <div class="flex flex-1">
        {{-- Sidebar Admin --}}
        @include('partials.sidebar-admin')

        <main class="flex-1 p-6">
            @yield('content')
        </main>
    </div>

    @include('partials.footer')
</body>
</html>
