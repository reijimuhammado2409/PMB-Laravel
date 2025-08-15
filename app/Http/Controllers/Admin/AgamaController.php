<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Agama;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AgamaController extends Controller
{
    public function index()
    {
        $items = Agama::orderBy('nama')->paginate(7); // <- pakai $items
        return view('admin.agama.index', compact('items'));
    }

    public function create()
    {
        return view('admin.agama.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:50|unique:agama,nama',
        ]);

        Agama::create($validated);
        return redirect()->route('admin.agama.index')->with('success', 'Agama berhasil ditambahkan.');
    }

    public function edit(Agama $agama) // <- route-model binding
    {
        return view('admin.agama.edit', compact('agama'));
    }

    public function update(Request $request, Agama $agama) // <- binding juga di sini
    {
        $validated = $request->validate([
            'nama' => ['required','string','max:50', Rule::unique('agama','nama')->ignore($agama->id)],
        ]);

        $agama->update($validated);
        return redirect()->route('admin.agama.index')->with('success', 'Agama berhasil diupdate.');
    }

    public function destroy(Agama $agama)
    {
        $agama->delete();
        return redirect()->route('admin.agama.index')->with('success', 'Agama berhasil dihapus.');
    }
}
