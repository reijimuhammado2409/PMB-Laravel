@extends('layouts.dashboard-mahasiswa')
@section('title', 'Status Pendaftaran Mahasiswa Baru')

@section('content')

    <h1 class="text-2xl font-bold mb-4">Status Pendaftaran Mahasiswa Baru</h1>

    {{-- @if (session('success'))
        <div class="mb-4 p-3 rounded bg-green-100 text-green-700 border border-green-300">
            {{ session('success') }}
        </div>
    @endif --}}

    <div class="bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-xl font-semibold mb-4">Status Pendaftaran Anda:</h2>

        @if ($mhs == 'pending')
            <span class="px-3 py-1 rounded bg-yellow-100 text-yellow-700 text-sm font-medium">Pending</span>
        @elseif($mhs == 'diterima')
            <span class="px-3 py-1 rounded bg-green-100 text-green-700 text-sm font-medium">Diterima</span>
        @elseif($mhs == 'ditolak')
            <span class="px-3 py-1 rounded bg-red-100 text-red-700 text-sm font-medium">Ditolak</span>
        @elseif ($mhs == null)
            <span class="px-3 py-1 rounded bg-gray-100 text-gray-700 text-sm font-medium">Belum Mendaftar</span>
        @endif


        @if ($mhs == 'pending')
            <p class="mt-4 text-gray-700">Pendaftaran Anda sedang dalam proses verifikasi. Harap tunggu informasi
                selanjutnya.</p>
        @elseif($mhs == 'diterima')
            <p class="mt-4 text-gray-700">Selamat! Pendaftaran Anda telah diterima. Silakan cek email Anda untuk informasi
                lebih lanjut.</p>
        @elseif($mhs == 'ditolak')
            <p class="mt-4 text-gray-700">Maaf, pendaftaran Anda ditolak. Silakan hubungi bagian administrasi untuk informasi
                lebih lanjut.</p>
        @elseif ($mhs == null)
            <p class="mt-4 text-gray-700">Anda belum melakukan pendaftaran. Silakan lakukan pendaftaran untuk mengikuti proses seleksi
                mahasiswa baru.</p>
        @endif
    </div>
@endsection
