<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Provinsi;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProvinsiController extends Controller
{
    public function index(Request $request)
    {
        $query = Provinsi::query();

        // 🔍 Pencarian
        if ($request->has('q') && $request->q != '') {
            $query->where('nama', 'like', '%' . $request->q . '%');
        }

        // ⬆️⬇️ Sorting
        $sort = $request->get('sort', 'nama'); // default: nama
        $direction = $request->get('direction', 'asc'); // default: asc
        $query->orderBy($sort, $direction);

        $items = $query->paginate(7)->appends($request->all());

        return view('admin.provinsi.index', [
            'items' => $items,
            'title' => 'provinsi',
            'route' => 'provinsi'
        ]);
    }

    public function create()
    {
        return view('admin.provinsi.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:100|unique:provinsi,nama',
        ]);

        Provinsi::create($validated);
        return redirect()->route('admin.provinsi.index')->with('success', 'Provinsi berhasil ditambahkan.');
    }

    public function edit(Provinsi $provinsi)
    {
        return view('admin.provinsi.edit', compact('provinsi'));
    }

    public function update(Request $request, Provinsi $provinsi)
    {
        $validated = $request->validate([
            'nama' => [
                'required',
                'string',
                'max:100',
                Rule::unique('provinsi', 'nama')->ignore($provinsi->id)
            ],
        ]);

        $provinsi->update($validated);
        return redirect()->route('admin.provinsi.index')->with('success', 'Provinsi berhasil diupdate.');
    }

    public function destroy(Provinsi $provinsi)
    {
        $provinsi->delete();
        return redirect()->route('admin.provinsi.index')->with('success', 'Provinsi berhasil dihapus.');
    }
}
