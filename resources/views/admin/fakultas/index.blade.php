@extends('layouts.dashboard-admin')
@section('title','fakultas')

@section('content')
<div class="flex items-center justify-between mb-4">
    <h1 class="text-2xl font-bold">Fakultas</h1>
    <a href="{{ route('admin.fakultas.create') }}"
       class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow flex items-center space-x-1">
       <span>＋</span><span>Tambah Fakultas</span>
    </a>
</div>

@if (session('success'))
<div class="mb-4 p-3 rounded-lg bg-green-100 text-green-800 border border-green-300">
    {{ session('success') }}
</div>
@endif

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="min-w-full text-sm">
        <thead class="bg-gray-900 text-white uppercase text-xs tracking-wider">
            <tr>
                <th class="px-6 py-3 text-left w-16">No</th>
                <th class="px-6 py-3 text-left">Nama Fakultas</th>
                <th class="px-6 py-3 text-center w-40">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @forelse ($items as $index => $i)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">{{ $items->firstItem() + $index }}</td>
                    <td class="px-6 py-4">{{ $i->nama }}</td>
                    <td class="px-6 py-4 text-center flex items-center justify-center space-x-2">
                        {{-- Tombol Edit --}}
                        <a href="{{ route('admin.fakultas.edit',$i) }}"
                           class="inline-flex items-center px-3 py-1 text-xs font-medium text-yellow-700 bg-yellow-100 hover:bg-yellow-200 rounded">
                            ✏️ <span class="ml-1">Edit</span>
                        </a>
                        {{-- Tombol Hapus --}}
                        <form method="POST" action="{{ route('admin.fakultas.destroy',$i) }}" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                onclick="return confirm('Hapus fakultas ini?')"
                                class="inline-flex items-center px-3 py-1 text-xs font-medium text-red-700 bg-red-100 hover:bg-red-200 rounded">
                                🗑️ <span class="ml-1">Hapus</span>
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="px-6 py-4 text-center text-gray-500">
                        Tidak ada data.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- Pagination --}}
<div class="mt-4">
    {{ $items->links() }}
</div>
@endsection
