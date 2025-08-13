@extends('layouts.dashboard-admin')

@section('title', 'Dashboard Admin')

@section('content')
    <h1 class="text-3xl font-bold mb-4">Selamat Datang, {{ Auth::user()->username }}</h1>
    <p class="text-gray-700">Ini adalah halaman dashboard admin PMB Online.</p>
@endsection
