@extends('layouts.dashboard-admin')
@section('title', 'Tambah Kecamatan')

@section('content')
<div class="flex items-center justify-between mb-4">
    <h1 class="text-2xl font-bold">Tambah Kecamatan</h1>
    <a href="{{ route('admin.kecamatan.index') }}"
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
    <form action="{{ route('admin.kecamatan.store') }}" method="POST">
        @csrf

        {{-- Pilih Provinsi --}}
        <div class="mb-4">
            <label for="provinsi_id" class="block text-sm font-medium text-gray-700">Pilih Provinsi</label>
            <select name="provinsi_id" id="provinsi_id"
                    class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm px-3 py-2 focus:ring focus:ring-blue-200"
                    required>
                <option value="">-- Pilih Provinsi --</option>
                @foreach($provinsi as $p)
                    <option value="{{ $p->id }}">{{ $p->nama }}</option>
                @endforeach
            </select>
        </div>

        {{-- Pilih Kabupaten --}}
        <div class="mb-4">
            <label for="kabupaten_id" class="block text-sm font-medium text-gray-700">Pilih Kabupaten/Kota</label>
            <select name="kabupaten_id" id="kabupaten_id"
                    class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm px-3 py-2 focus:ring focus:ring-blue-200"
                    required>
                <option value="">-- Pilih Kabupaten/Kota --</option>
            </select>
        </div>

        {{-- Nama kecamatan --}}
        <div class="mb-4">
            <label for="nama" class="block text-sm font-medium text-gray-700">Nama Kecamatan</label>
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

{{-- Script AJAX --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    const provinsiSelect = document.getElementById('provinsi_id');
    const kabupatenSelect = document.getElementById('kabupaten_id');

    provinsiSelect.addEventListener('change', function() {
        const provinsiId = this.value;
        kabupatenSelect.innerHTML = '<option value="">Loading...</option>';

        if (provinsiId) {
            fetch(`/admin/get-kabupaten/${provinsiId}`)
                .then(response => response.json())
                .then(data => {
                    kabupatenSelect.innerHTML = '<option value="">-- Pilih Kabupaten/Kota --</option>';
                    data.forEach(kab => {
                        const opt = document.createElement('option');
                        opt.value = kab.id;
                        opt.textContent = kab.nama;
                        kabupatenSelect.appendChild(opt);
                    });
                });
        } else {
            kabupatenSelect.innerHTML = '<option value="">-- Pilih Kabupaten/Kota --</option>';
        }
    });
});
</script>
@endsection
