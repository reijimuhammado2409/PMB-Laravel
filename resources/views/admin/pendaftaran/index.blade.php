@extends('layouts.dashboard-admin')
@section('title','Pendaftaran Mahasiswa')

@section('content')

<div class="flex items-center justify-between mb-4">
    <h1 class="text-2xl font-bold">Pendaftaran Mahasiswa Baru</h1>
</div>

@if (session('success'))
<div class="mb-4 p-3 rounded-lg bg-green-100 text-green-800 border border-green-300">
    {{ session('success') }}
</div>
@endif

{{-- 🔍 Form Pencarian --}}
<form method="GET" action="{{ route('admin.pendaftaran.index') }}" class="mb-4 flex space-x-2">
    <input type="text" name="q" value="{{ request('q') }}"
           placeholder="Cari nama/email..."
           class="border border-gray-300 rounded-lg px-3 py-2 w-64 focus:ring focus:ring-blue-200">
    <button type="submit"
            class="bg-gray-800 hover:bg-gray-900 text-white px-4 py-2 rounded-lg shadow">
        Cari
    </button>

    @if(request('q'))
        <a href="{{ route('admin.pendaftaran.index') }}"
           class="bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded-lg shadow">
            Reset
        </a>
    @endif
</form>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="min-w-full text-sm">
        <thead class="bg-gray-900 text-white uppercase text-xs tracking-wider">
            <tr>
                <th class="px-6 py-3 text-left w-12">No</th>
                <th class="px-6 py-3 text-left">Nama Mahasiswa</th>
                <th class="px-6 py-3 text-left">Email</th>
                <th class="px-6 py-3 text-left">Provinsi</th>
                <th class="px-6 py-3 text-left">Status</th>
                <th class="px-6 py-3 text-center w-60">Aksi</th>
            </tr>
        </thead>

        <tbody class="divide-y divide-gray-200">
            @foreach ($mahasiswa as $index => $mhs)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">{{ $index + 1 }}</td>
                    <td class="px-6 py-4 font-semibold">{{ $mhs->nama_lengkap }}</td>
                    <td class="px-6 py-4">{{ $mhs->email }}</td>
                    <td class="px-6 py-4">
                        {{ $mhs->provinsi->nama ?? '-' }}
                    </td>

                    {{-- Status --}}
                    <td class="px-6 py-4">
                        @if($mhs->status == 'pending')
                            <span class="px-3 py-1 rounded bg-yellow-100 text-yellow-700 text-xs font-medium">Pending</span>
                        @elseif($mhs->status == 'diterima')
                            <span class="px-3 py-1 rounded bg-green-100 text-green-700 text-xs font-medium">Diterima</span>
                        @else
                            <span class="px-3 py-1 rounded bg-red-100 text-red-700 text-xs font-medium">Ditolak</span>
                        @endif
                    </td>

                    {{-- Aksi --}}
                    <td class="px-6 py-4 flex items-center justify-center space-x-2">

                        {{-- 🟡 Edit --}}
                        <a href="{{ route('admin.pendaftaran.edit', $mhs->id) }}"
                           class="inline-flex items-center px-3 py-1 text-xs font-medium text-yellow-700 bg-yellow-100 hover:bg-yellow-200 rounded">
                            ✏️ Edit
                        </a>

                        {{-- 🟢 Approve --}}
                        @if($mhs->status !== 'diterima')
                        <form action="{{ route('admin.pendaftaran.approve', $mhs->id) }}" method="POST">
                            @csrf @method('PUT')
                            <button type="submit"
                                class="inline-flex items-center px-3 py-1 text-xs font-medium text-green-700 bg-green-100 hover:bg-green-200 rounded">
                                ✔️ Terima
                            </button>
                        </form>
                        @endif

                        {{-- 🔴 Reject --}}
                        @if($mhs->status !== 'ditolak')
                        <form action="{{ route('admin.pendaftaran.reject', $mhs->id) }}" method="POST">
                            @csrf @method('PUT')
                            <button type="submit"
                                class="inline-flex items-center px-3 py-1 text-xs font-medium text-red-700 bg-red-100 hover:bg-red-200 rounded">
                                ❌ Tolak
                            </button>
                        </form>
                        @endif

                        {{-- 🗑 Delete --}}
                        <form action="{{ route('admin.pendaftaran.destroy', $mhs->id) }}" 
                              method="POST"
                              onsubmit="return confirm('Hapus data mahasiswa ini?')">
                            @csrf @method('DELETE')
                            <button type="submit"
                                class="inline-flex items-center px-3 py-1 text-xs font-medium text-gray-700 bg-gray-200 hover:bg-gray-300 rounded">
                                🗑️ Hapus
                            </button>
                        </form>

                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection
