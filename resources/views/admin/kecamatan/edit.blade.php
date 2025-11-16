@extends('layouts.dashboard-admin')
@section('title', 'Edit Kecamatan')

@section('content')
<div class="flex items-center justify-between mb-4">
    <h1 class="text-2xl font-bold">Edit Kecamatan</h1>
    <a href="{{ route('admin.kecamatan.index') }}"
       class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg shadow">
       ← Kembali
    </a>
</div>

{{-- Pesan Error --}}
@if ($errors->any())
<div class="mb-4 p-3 rounded-lg bg-red-100 text-red-800 border border-red-300">
    <ul class="list-disc list-inside text-sm">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

{{-- Form Edit Kecamatan --}}
<div class="bg-white rounded-lg shadow p-6">
    <form action="{{ route('admin.kecamatan.update', $kecamatan->id) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Dropdown Provinsi --}}
        <div class="mb-4">
            <label for="provinsi_id" class="block text-sm font-medium text-gray-700">Provinsi</label>
            <select name="provinsi_id" id="provinsi_id"
                class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm px-3 py-2 focus:ring focus:ring-blue-200" required>
                <option value="">-- Pilih Provinsi --</option>
                @foreach ($provinsi as $item)
                    <option value="{{ $item->id }}" 
                        {{ old('provinsi_id', $kecamatan->kabupaten->provinsi_id ?? '') == $item->id ? 'selected' : '' }}>
                        {{ $item->nama }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Dropdown Kabupaten --}}
        <div class="mb-4">
            <label for="kabupaten_id" class="block text-sm font-medium text-gray-700">Kabupaten/Kota</label>
            <select name="kabupaten_id" id="kabupaten_id"
                class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm px-3 py-2 focus:ring focus:ring-blue-200" required>
                <option value="">-- Pilih Kabupaten/Kota --</option>
                @foreach ($kabupaten as $item)
                    <option value="{{ $item->id }}" 
                        {{ old('kabupaten_id', $kecamatan->kabupaten_id) == $item->id ? 'selected' : '' }}>
                        {{ $item->nama }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Input Nama Kecamatan --}}
        <div class="mb-4">
            <label for="nama" class="block text-sm font-medium text-gray-700">Nama Kecamatan</label>
            <input type="text" name="nama" id="nama"
                   class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm px-3 py-2 focus:ring focus:ring-blue-200"
                   value="{{ old('nama', $kecamatan->nama) }}" required>
        </div>

        {{-- Tombol Update --}}
        <button type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow">
            Update
        </button>
    </form>
</div>

{{-- Script AJAX untuk Dropdown Dinamis --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    const provinsiSelect = document.getElementById('provinsi_id');
    const kabupatenSelect = document.getElementById('kabupaten_id');
    const selectedKabupaten = "{{ old('kabupaten_id', $kecamatan->kabupaten_id) }}";
    const currentProvinsi = "{{ $kecamatan->kabupaten->provinsi_id ?? '' }}";

    function loadKabupaten(provinsiId, callback = null) {
        kabupatenSelect.innerHTML = '<option value="">-- Memuat data... --</option>';

        fetch(`/admin/get-kabupaten/${provinsiId}`)
            .then(response => response.json())
            .then(data => {
                kabupatenSelect.innerHTML = '<option value="">-- Pilih Kabupaten/Kota --</option>';
                data.forEach(item => {
                    const option = document.createElement('option');
                    option.value = item.id;
                    option.textContent = item.nama;
                    kabupatenSelect.appendChild(option);
                });

                if (selectedKabupaten) {
                    kabupatenSelect.value = selectedKabupaten;
                }

                if (callback) callback();
            })
            .catch(error => {
                console.error('Error fetching kabupaten:', error);
                kabupatenSelect.innerHTML = '<option value="">Gagal memuat data</option>';
            });
    }

    // ✅ Saat halaman edit dibuka, langsung load kabupaten berdasarkan provinsi yang tersimpan
    if (currentProvinsi) {
        loadKabupaten(currentProvinsi);
    }

    // ✅ Kalau user ganti provinsi manual
    provinsiSelect.addEventListener('change', function() {
        const provinsiId = this.value;
        if (provinsiId) {
            loadKabupaten(provinsiId);
        } else {
            kabupatenSelect.innerHTML = '<option value="">-- Pilih Kabupaten/Kota --</option>';
        }
    });
});
</script>

@endsection
