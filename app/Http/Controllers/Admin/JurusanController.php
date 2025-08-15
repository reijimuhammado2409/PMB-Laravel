<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jurusan;
use App\Models\Fakultas;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class JurusanController extends Controller
{
    public function index()
    {
        $items = Jurusan::with('fakultas')->orderBy('nama')->paginate(7);
        return view('admin.jurusan.index', compact('items'));
    }

    public function create()
    {
        $fakultas = Fakultas::orderBy('nama')->get();
        return view('admin.jurusan.create', compact('fakultas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'fakultas_id' => 'required|exists:fakultas,id',
            'nama' => 'required|string|max:100|unique:jurusan,nama',
        ]);

        Jurusan::create($validated);
        return redirect()->route('admin.jurusan.index')->with('success', 'Jurusan berhasil ditambahkan.');
    }

    public function edit(Jurusan $jurusan)
    {
        $fakultas = Fakultas::orderBy('nama')->get();
        return view('admin.jurusan.edit', compact('jurusan', 'fakultas'));
    }

    public function update(Request $request, Jurusan $jurusan)
    {
        $validated = $request->validate([
            'fakultas_id' => 'required|exists:fakultas,id',
            'nama' => ['required','string','max:100', Rule::unique('jurusan','nama')->ignore($jurusan->id)],
        ]);

        $jurusan->update($validated);
        return redirect()->route('admin.jurusan.index')->with('success', 'Jurusan berhasil diupdate.');
    }

    public function destroy(Jurusan $jurusan)
    {
        $jurusan->delete();
        return redirect()->route('admin.jurusan.index')->with('success', 'Jurusan berhasil dihapus.');
    }
}
