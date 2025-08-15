@extends('layouts.dashboard-admin')
@section('title','Tambah Agama')

@section('content')
<div class="flex items-center justify-between mb-4">
    <h1 class="text-2xl font-bold">Tambah Agama</h1>
    <a href="{{ route('admin.agama.index') }}"
       class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg shadow">
       ← Kembali
    </a>
</div>

@if ($errors->any())
<div class="mb-4 p-3 rounded-lg bg-red-100 text-red-800 border border-red-300">
    <ul class="list-disc list-inside text-sm">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="bg-white rounded-lg shadow p-6">
    <form action="{{ route('admin.agama.store') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label for="nama" class="block text-sm font-medium text-gray-700">Nama Agama</label>
            <input type="text" name="nama" id="nama"
                   class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm px-3 py-2 focus:ring focus:ring-blue-200"
                   value="{{ old('nama') }}" required>
        </div>

        <button type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow">
            Simpan
        </button>
    </form>
</div>
@endsection
