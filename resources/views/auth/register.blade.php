@extends('layouts.app')

@section('content')
<h2 class="text-2xl font-bold mb-4 text-center">Register</h2>

@if ($errors->any())
    <div class="bg-red-100 text-red-700 p-2 rounded mb-3">
        {{ implode('', $errors->all(':message')) }}
    </div>
@endif

<form method="POST" action="{{ route('register') }}" class="space-y-4">
    @csrf
    <div>
        <label class="block text-sm font-medium">Username</label>
        <input type="text" name="username" required
               class="w-full border-gray-300 rounded p-2 focus:ring focus:ring-blue-200">
    </div>
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
    <div>
        <label class="block text-sm font-medium">Konfirmasi Password</label>
        <input type="password" name="password_confirmation" required
               class="w-full border-gray-300 rounded p-2 focus:ring focus:ring-blue-200">
    </div>
    <button type="submit"
            class="w-full bg-green-600 text-white p-2 rounded hover:bg-green-700">
        Register
    </button>
</form>

<p class="text-center text-sm mt-4">
    Sudah punya akun?
    <a href="{{ route('login') }}" class="text-blue-600 hover:underline">Login</a>
</p>
@endsection
