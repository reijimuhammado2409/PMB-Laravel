<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Fakultas;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class FakultasController extends Controller
{
    public function index(Request $request)
    {
        $query = Fakultas::query();

        // 🔍 Pencarian
        if ($request->has('q') && $request->q != '') {
            $query->where('nama', 'like', '%' . $request->q . '%');
        }

        // ⬆️⬇️ Sorting
        $sort = $request->get('sort', 'nama'); // default: nama
        $direction = $request->get('direction', 'asc'); // default: asc
        $query->orderBy($sort, $direction);

        $items = $query->paginate(7)->appends($request->all());

        return view('admin.fakultas.index', [
            'items' => $items,
            'title' => 'fakultas',
            'route' => 'fakultas'
        ]);
    }

    public function create()
    {
        return view('admin.fakultas.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:100|unique:fakultas,nama',
        ]);

        Fakultas::create($validated);
        return redirect()->route('admin.fakultas.index')->with('success', 'Fakultas berhasil ditambahkan.');
    }

    public function edit(Fakultas $fakultas)
    {
        return view('admin.fakultas.edit', compact('fakultas'));
    }

    public function update(Request $request, Fakultas $fakultas)
    {
        $validated = $request->validate([
            'nama' => [
                'required',
                'string',
                'max:100',
                Rule::unique('fakultas', 'nama')->ignore($fakultas->id)
            ],
        ]);

        $fakultas->update($validated);
        return redirect()->route('admin.fakultas.index')->with('success', 'Fakultas berhasil diupdate.');
    }

    public function destroy(Fakultas $fakultas)
    {
        $fakultas->delete();
        return redirect()->route('admin.fakultas.index')->with('success', 'Fakultas berhasil dihapus.');
    }
}
