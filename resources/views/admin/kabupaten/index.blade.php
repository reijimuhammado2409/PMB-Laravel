@extends('layouts.dashboard-admin')
@section('title','kabupaten')

@section('content')
<div class="flex items-center justify-between mb-4">
    <h1 class="text-2xl font-bold">Kabupaten/Kota</h1>
    <a href="{{ route('admin.kabupaten.create') }}"
       class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow flex items-center space-x-1">
       <span>＋</span><span>Tambah kabupaten</span>
    </a>
</div>

@if (session('success'))
<div class="mb-4 p-3 rounded-lg bg-green-100 text-green-800 border border-green-300">
    {{ session('success') }}
</div>
@endif

{{-- 🔍 Form Pencarian --}}
<form method="GET" action="{{ route('admin.kabupaten.index') }}" class="mb-4 flex space-x-2">
    <input type="text" name="q" value="{{ request('q') }}"
           placeholder="Cari kabupaten / provinsi..."
           class="border border-gray-300 rounded-lg px-3 py-2 w-64 focus:ring focus:ring-blue-200">
    <button type="submit"
            class="bg-gray-800 hover:bg-gray-900 text-white px-4 py-2 rounded-lg shadow">
        Cari
    </button>
    @if(request('q'))
        <a href="{{ route('admin.kabupaten.index') }}"
           class="bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded-lg shadow">
            Reset
        </a>
    @endif
</form>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="min-w-full text-sm">
        <thead class="bg-gray-900 text-white uppercase text-xs tracking-wider">
            <tr>
                <th class="px-6 py-3 text-left w-16">No</th>
                {{-- Sorting Nama kabupaten --}}
                <th class="px-6 py-3 text-left">
                    <a href="{{ route('admin.kabupaten.index', [
                            'sort' => 'nama',
                            'direction' => request('direction') === 'asc' ? 'desc' : 'asc',
                            'q' => request('q')
                        ]) }}" class="flex items-center space-x-1">
                        <span>Nama Kabupaten/Kota</span>
                        @if(request('sort') === 'nama')
                            <span>{{ request('direction') === 'asc' ? '⬆️' : '⬇️' }}</span>
                        @endif
                    </a>
                </th>
                {{-- Sorting provinsi --}}
                <th class="px-6 py-3 text-left">
                    <a href="{{ route('admin.kabupaten.index', [
                            'sort' => 'provinsi_id',
                            'direction' => request('direction') === 'asc' ? 'desc' : 'asc',
                            'q' => request('q')
                        ]) }}" class="flex items-center space-x-1">
                        <span>Provinsi</span>
                        @if(request('sort') === 'provinsi_id')
                            <span>{{ request('direction') === 'asc' ? '⬆️' : '⬇️' }}</span>
                        @endif
                    </a>
                </th>
                <th class="px-6 py-3 text-center w-40">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @forelse ($items as $index => $i)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">{{ $items->firstItem() + $index }}</td>
                    <td class="px-6 py-4">{{ $i->nama }}</td>
                    <td class="px-6 py-4">{{ $i->provinsi->nama ?? '-' }}</td>
                    <td class="px-6 py-4 text-center flex items-center justify-center space-x-2">
                        {{-- Tombol Edit --}}
                        <a href="{{ route('admin.kabupaten.edit',$i) }}"
                           class="inline-flex items-center px-3 py-1 text-xs font-medium text-yellow-700 bg-yellow-100 hover:bg-yellow-200 rounded">
                            ✏️ <span class="ml-1">Edit</span>
                        </a>
                        {{-- Tombol Hapus --}}
                        <form method="POST" action="{{ route('admin.kabupaten.destroy',$i) }}" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                onclick="return confirm('Hapus kabupaten ini?')"
                                class="inline-flex items-center px-3 py-1 text-xs font-medium text-red-700 bg-red-100 hover:bg-red-200 rounded">
                                🗑️ <span class="ml-1">Hapus</span>
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="px-6 py-4 text-center text-gray-500">
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
