@extends('layouts.dashboard-mahasiswa')

@section('title', 'Dashboard Mahasiswa')

@section('content')
    <h1 class="text-3xl font-bold mb-4">Halo, {{ Auth::user()->username }}</h1>
    <p class="text-gray-700">Ini adalah halaman dashboard mahasiswa PMB Online.</p>
@endsection
