<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kabupaten;
use App\Models\Provinsi;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class KabupatenController extends Controller
{
    public function index(Request $request)
    {
        $query = Kabupaten::with('provinsi');

        // 🔍 Pencarian
        if ($request->has('q') && $request->q != '') {
            $query->where('nama', 'like', '%' . $request->q . '%')
                  ->orWhereHas('provinsi', function($q) use ($request) {
                      $q->where('nama', 'like', '%' . $request->q . '%');
                  });
        }

        // ⬆️⬇️ Sorting
        $sort = $request->get('sort', 'nama'); // default nama kabupaten
        $direction = $request->get('direction', 'asc'); // default asc
        $query->orderBy($sort, $direction);

        $items = $query->paginate(7)->appends($request->all());

        return view('admin.kabupaten.index', [
            'items' => $items,
            'title' => 'kabupaten',
            'route' => 'kabupaten'
        ]);
    }

    public function create()
    {
        $provinsi = Provinsi::orderBy('nama')->get();
        return view('admin.kabupaten.create', compact('provinsi'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'provinsi_id' => 'required|exists:provinsi,id',
            'nama' => 'required|string|max:100|unique:kabupaten,nama',
        ]);

        Kabupaten::create($validated);
        return redirect()->route('admin.kabupaten.index')->with('success', 'Kabupaten berhasil ditambahkan.');
    }

    public function edit(Kabupaten $kabupaten)
    {
        $provinsi = Provinsi::orderBy('nama')->get();
        return view('admin.kabupaten.edit', compact('kabupaten', 'provinsi'));
    }

    public function update(Request $request, Kabupaten $kabupaten)
    {
        $validated = $request->validate([
            'provinsi_id' => 'required|exists:provinsi,id',
            'nama' => [
                'required',
                'string',
                'max:100',
                Rule::unique('kabupaten','nama')->ignore($kabupaten->id)
            ],
        ]);

        $kabupaten->update($validated);
        return redirect()->route('admin.kabupaten.index')->with('success', 'Kabupaten berhasil diupdate.');
    }

    public function destroy(Kabupaten $kabupaten)
    {
        $kabupaten->delete();
        return redirect()->route('admin.kabupaten.index')->with('success', 'Kabupaten berhasil dihapus.');
    }

    // public function getByProvinsi($provinsi_id)
    // {
    //     return response()->json(
    //         Kabupaten::where('provinsi_id', $provinsi_id)->orderBy('nama')->get()
    //     );
    // }
}
