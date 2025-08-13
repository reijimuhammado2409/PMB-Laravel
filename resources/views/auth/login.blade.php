@extends('layouts.app')

@section('content')
<h2 class="text-2xl font-bold mb-4 text-center">Login</h2>

@if (session('success'))
    <div class="bg-green-100 text-green-700 p-2 rounded mb-3">
        {{ session('success') }}
    </div>
@endif

@if ($errors->any())
    <div class="bg-red-100 text-red-700 p-2 rounded mb-3">
        {{ implode('', $errors->all(':message')) }}
    </div>
@endif

<form method="POST" action="{{ route('login') }}" class="space-y-4">
    @csrf
    <div>
        <label class="block text-sm font-medium">Email</label>
        <input type="email" name="email" required
               class="w-full border-gray-300 rounded p-2 focus:ring focus:ring-blue-200">
    </div>
    <div>
        <label class="block text-sm font-medium">Password</label>
        <input type="password" name="password" required
               class="w-full border-gray-300 rounded p-2 focus:ring focus:ring-blue-200">
    </div>
    <button type="submit"
            class="w-full bg-blue-600 text-white p-2 rounded hover:bg-blue-700">
        Login
    </button>
</form>

<p class="text-center text-sm mt-4">
    Belum punya akun?
    <a href="{{ route('register') }}" class="text-blue-600 hover:underline">Daftar</a>
</p>
@endsection
