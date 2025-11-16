<?php

namespace App\Http\Controllers\MahaSiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Mahasiswa;
use App\Models\Agama;
use App\Models\Provinsi;
use App\Models\Kabupaten;
use App\Models\Kecamatan;

class MahasiswaController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | BAGIAN MAHASISWA (USER BIASA)
    |--------------------------------------------------------------------------
    */

    // Tampilkan form pendaftaran
    public function create()
    {
        return view('mahasiswa.pendaftaran.create', [
            'agama' => Agama::all(),
            'provinsi' => Provinsi::all()
        ]);
    }

    // Simpan data pendaftaran
    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap'     => 'required',
            'tempat_lahir'     => 'required',
            'tanggal_lahir'    => 'required|date',
            'jenis_kelamin'    => 'required',
            'agama_id'         => 'required',
            'alamat_ktp'       => 'required',
            'alamat_sekarang'  => 'required',
            'provinsi_id'      => 'required',
            'kabupaten_id'     => 'required',
            'kecamatan_id'     => 'required',
            'no_hp'            => 'required',
            'email'            => 'required|email',
            'status_menikah'   => 'required',
            'kewarganegaraan'  => 'required',
            'negara_asal'      => 'nullable',
            'foto'             => 'nullable|image|max:2048'
        ]);

        $data = $request->all();

        $data['user_id'] = Auth::id();
        $data['status'] = 'pending';

        // Upload foto
        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('foto_mahasiswa', 'public');
        }

        Mahasiswa::create($data);

        return redirect()->route('mahasiswa.pendaftaran.status')
            ->with('success', 'Pendaftaran berhasil dikirim!');
    }

    // Cek status pendaftaran
    public function status()
    {
        $mhs = Mahasiswa::where('user_id', Auth::id())->first();

        return view('mahasiswa.pendaftaran.status', compact('mhs'));
    }

    /*
    |--------------------------------------------------------------------------
    | BAGIAN ADMIN
    |--------------------------------------------------------------------------
    */

    // Tampilkan semua pendaftar
    public function index()
    {
        $mahasiswa = Mahasiswa::with(['agama', 'provinsi', 'kabupaten'])->get();

        return view('admin.pendaftaran.index', compact('mahasiswa'));
    }

    // Form edit data mahasiswa
    public function edit($id)
    {
        $mhs = Mahasiswa::findOrFail($id);

        return view('admin.pendaftaran.edit', [
            'mhs' => $mhs,
            'agama' => Agama::all(),
            'provinsi' => Provinsi::all(),
            'kabupaten' => Kabupaten::where('provinsi_id', $mhs->provinsi_id)->get(),
            'kecamatan' => Kecamatan::where('kecamatan_id', $mhs->kecamatan_id)->get()
        ]);
    }

    // Update data mahasiswa
    public function update(Request $request, $id)
    {
        $mhs = Mahasiswa::findOrFail($id);

        $data = $request->all();

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('foto_mahasiswa', 'public');
        }

        $mhs->update($data);

        return redirect()->route('admin.pendaftaran.index')
            ->with('success', 'Data mahasiswa berhasil diperbarui.');
    }

    // Hapus pendaftar
    public function destroy($id)
    {
        $mhs = Mahasiswa::findOrFail($id);
        $mhs->delete();

        return redirect()->route('admin.pendaftaran.index')
            ->with('success', 'Data berhasil dihapus.');
    }

    // Approve pendaftar
    public function approve($id)
    {
        $mhs = Mahasiswa::findOrFail($id);
        $mhs->update(['status' => 'diterima']);

        return redirect()->route('admin.pendaftaran.index')
            ->with('success', 'Mahasiswa telah diterima.');
    }

    // Reject pendaftar
    public function reject($id)
    {
        $mhs = Mahasiswa::findOrFail($id);
        $mhs->update(['status' => 'ditolak']);

        return redirect()->route('admin.pendaftaran.index')
            ->with('success', 'Mahasiswa telah ditolak.');
    }
}
