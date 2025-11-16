@extends('layouts.dashboard-mahasiswa')
@section('title', 'Pendaftaran Mahasiswa Baru')

@section('content')

<h1 class="text-2xl font-bold mb-4">Form Pendaftaran Mahasiswa Baru</h1>

@if (session('success'))
    <div class="mb-4 p-3 rounded bg-green-100 text-green-700 border border-green-300">
        {{ session('success') }}
    </div>
@endif

@if ($errors->any())
    <div class="mb-4 p-3 bg-red-100 text-red-700 rounded border border-red-300">
        <ul class="list-disc ml-5 text-sm">
            @foreach ($errors->all() as $e)
                <li>{{ $e }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('mahasiswa.pendaftaran.store') }}" method="POST" enctype="multipart/form-data"
      class="bg-white p-6 rounded-lg shadow-md space-y-4">

    @csrf

    {{-- Nama --}}
    <div>
        <label class="font-medium">Nama Lengkap</label>
        <input type="text" name="nama_lengkap" class="w-full border rounded px-3 py-2"
               value="{{ old('nama_lengkap') }}" required>
    </div>

    {{-- Tempat & Tanggal lahir --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="font-medium">Tempat Lahir</label>
            <input type="text" name="tempat_lahir" class="w-full border rounded px-3 py-2"
                   value="{{ old('tempat_lahir') }}" required>
        </div>

        <div>
            <label class="font-medium">Tanggal Lahir</label>
            <input type="date" name="tanggal_lahir" class="w-full border rounded px-3 py-2"
                   value="{{ old('tanggal_lahir') }}" required>
        </div>
    </div>

    {{-- Jenis Kelamin --}}
    <div>
        <label class="font-medium">Jenis Kelamin</label>
        <select name="jenis_kelamin" class="w-full border rounded px-3 py-2" required>
            <option value="">-- Pilih --</option>
            <option value="Laki-laki">Laki-laki</option>
            <option value="Perempuan">Perempuan</option>
        </select>
    </div>

    {{-- Agama --}}
    <div>
        <label class="font-medium">Agama</label>
        <select name="agama_id" class="w-full border rounded px-3 py-2" required>
            <option value="">-- Pilih Agama --</option>
            @foreach($agama as $a)
                <option value="{{ $a->id }}">{{ $a->nama }}</option>
            @endforeach
        </select>
    </div>

    {{-- Alamat KTP --}}
    <div>
        <label class="font-medium">Alamat KTP</label>
        <textarea name="alamat_ktp" class="w-full border rounded px-3 py-2" required>{{ old('alamat_ktp') }}</textarea>
    </div>

    {{-- Alamat Sekarang --}}
    <div>
        <label class="font-medium">Alamat Sekarang</label>
        <textarea name="alamat_sekarang" class="w-full border rounded px-3 py-2" required>{{ old('alamat_sekarang') }}</textarea>
    </div>

    {{-- Provinsi - Kabupaten - Kecamatan --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div>
            <label class="font-medium">Provinsi</label>
            <select name="provinsi_id" id="provinsi" class="w-full border rounded px-3 py-2" required>
                <option value="">-- Pilih Provinsi --</option>
                @foreach($provinsi as $p)
                    <option value="{{ $p->id }}">{{ $p->nama }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="font-medium">Kabupaten</label>
            <select name="kabupaten_id" id="kabupaten" class="w-full border rounded px-3 py-2" required>
                <option value="">-- Pilih Kabupaten --</option>
            </select>
        </div>

        <div>
            <label class="font-medium">Kecamatan</label>
            <select name="kecamatan_id" id="kecamatan" class="w-full border rounded px-3 py-2" required>
                <option value="">-- Pilih Kecamatan --</option>
            </select>
        </div>
    </div>

    {{-- No HP --}}
    <div>
        <label class="font-medium">No HP</label>
        <input type="number" name="no_hp" class="w-full border rounded px-3 py-2"
               value="{{ old('no_hp') }}" required>
    </div>

    {{-- Email --}}
    <div>
        <label class="font-medium">Email Aktif</label>
        <input type="email" name="email" class="w-full border rounded px-3 py-2"
               value="{{ old('email') }}" required>
    </div>

    {{-- Status Menikah --}}
    <div>
        <label class="font-medium">Status Menikah</label>
        <select name="status_menikah" class="w-full border rounded px-3 py-2" required>
            <option value="">-- Pilih --</option>
            <option value="Belum_Menikah">Belum Menikah</option>
            <option value="Menikah">Menikah</option>
            <option value="Duda">Duda</option>
            <option value="Janda">Janda</option>
        </select>
    </div>

    {{-- Kewarganegaraan --}}
    <div>
        <label class="font-medium">Kewarganegaraan</label>
        <select name="kewarganegaraan" class="w-full border rounded px-3 py-2" required>
            <option value="">-- Pilih --</option>
            <option value="WNI_Asli">WNI Asli</option>
            <option value="WNI_Keturunan">WNI Keturunan</option>
            <option value="WNA">WNA</option>
        </select>
    </div>

    {{-- Negara Asal --}}
    <div>
        <label class="font-medium">Negara Asal (Jika WNA)</label>
        <input type="text" name="negara_asal" class="w-full border rounded px-3 py-2"
               value="{{ old('negara_asal') }}">
    </div>

    {{-- Foto --}}
    <div>
        <label class="font-medium">Upload Foto</label>
        <input type="file" name="foto" class="w-full border rounded px-3 py-2">
    </div>

    <button type="submit"
            class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium">
        Kirim Pendaftaran
    </button>

</form>

{{-- AJAX Dropdown Kabupaten & Kecamatan --}}
<script>
document.getElementById('provinsi').addEventListener('change', function() {
    fetch('/mahasiswa/get-kabupaten/' + this.value)
        .then(response => response.json())
        .then(data => {
            let kab = document.getElementById('kabupaten');
            kab.innerHTML = '<option value="">-- Pilih Kabupaten --</option>';
            data.forEach(row => {
                kab.innerHTML += `<option value="${row.id}">${row.nama}</option>`;
            });
        });
});

document.getElementById('kabupaten').addEventListener('change', function() {
    fetch('/mahasiswa/get-kecamatan/' + this.value)
        .then(response => response.json())
        .then(data => {
            let kab = document.getElementById('kecamatan');
            kab.innerHTML = '<option value="">-- Pilih Kecamatan --</option>';
            data.forEach(row => {
                kab.innerHTML += `<option value="${row.id}">${row.nama}</option>`;
            });
        });
});
</script>

@endsection
