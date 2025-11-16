<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kecamatan;
use App\Models\Kabupaten;
use App\Models\Provinsi;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class KecamatanController extends Controller
{
    public function index(Request $request)
    {
        $query = Kecamatan::with(['kabupaten.provinsi']); // ✅ relasi berantai

        // 🔍 Pencarian
        if ($request->filled('q')) {
            $query->where('nama', 'like', "%{$request->q}%")
                ->orWhereHas('kabupaten', function ($q) use ($request) {
                    $q->where('nama', 'like', "%{$request->q}%")
                      ->orWhereHas('provinsi', function ($p) use ($request) {
                          $p->where('nama', 'like', "%{$request->q}%");
                      });
                });
        }

        // ⬆️⬇️ Sorting
        $sort = $request->get('sort', 'nama');
        $direction = $request->get('direction', 'asc');
        $query->orderBy($sort, $direction);

        $items = $query->paginate(7)->appends($request->all());

        return view('admin.kecamatan.index', compact('items'));
    }

    public function create()
    {
        $provinsi = Provinsi::orderBy('nama')->get(); // ✅ ambil semua provinsi
        return view('admin.kecamatan.create', compact('provinsi'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kabupaten_id' => 'required|exists:kabupaten,id',
            'nama' => 'required|string|max:100|unique:kecamatan,nama',
        ]);

        Kecamatan::create($validated);
        return redirect()->route('admin.kecamatan.index')->with('success', 'Kecamatan berhasil ditambahkan.');
    }

    public function edit(Kecamatan $kecamatan)
    {
        $provinsi = Provinsi::orderBy('nama')->get();

        // Pastikan relasi kabupaten dan provinsi-nya tidak null
        $provinsiId = optional($kecamatan->kabupaten)->provinsi_id;

        if ($provinsiId) {
            $kabupaten = Kabupaten::where('provinsi_id', $provinsiId)
                                ->orderBy('nama')->get();
        } else {
            $kabupaten = collect(); // kalau gak ada relasi, kasih koleksi kosong
        }

        // dd($kecamatan->kabupaten_id, $kecamatan->kabupaten);


        return view('admin.kecamatan.edit', compact('kecamatan', 'provinsi', 'kabupaten'));
    }


    public function update(Request $request, Kecamatan $kecamatan)
    {
        $validated = $request->validate([
            'kabupaten_id' => 'required|exists:kabupaten,id',
            'nama' => [
                'required',
                'string',
                'max:100',
                Rule::unique('kecamatan', 'nama')->ignore($kecamatan->id),
            ],
        ]);

        $kecamatan->update($validated);
        return redirect()->route('admin.kecamatan.index')->with('success', 'Kecamatan berhasil diupdate.');
    }

    public function destroy(Kecamatan $kecamatan)
    {
        $kecamatan->delete();
        return redirect()->route('admin.kecamatan.index')->with('success', 'Kecamatan berhasil dihapus.');
    }

    // ✅ Endpoint AJAX: ambil kabupaten berdasarkan provinsi
    public function getKabupatenByProvinsi($provinsi_id)
    {
        $kabupaten = Kabupaten::where('provinsi_id', $provinsi_id)
                              ->orderBy('nama')
                              ->get(['id', 'nama']);
        return response()->json($kabupaten);
    }

    public function getKecamatanByKabupaten($kabupaten_id)
    {
        $kecamatan = Kecamatan::where('kabupaten_id', $kabupaten_id)
                              ->orderBy('nama')
                              ->get(['id', 'nama']);
        return response()->json($kecamatan);
    }
}
