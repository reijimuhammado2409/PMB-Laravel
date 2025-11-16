<aside class="bg-gray-800 text-white w-64 min-h-screen px-4 py-6">
    <h2 class="text-xl font-bold mb-6">Menu Mahasiswa</h2>
    <ul>
        <li><a href="{{ route('mahasiswa.dashboard') }}" class="block py-2 px-3 hover:bg-gray-700 rounded">Dashboard</a>
        </li>
        <li><a href="{{ route('mahasiswa.pendaftaran.create') }}"
                class="block py-2 px-3 hover:bg-gray-700 rounded">Pendaftaran</a></li>
        <li><a href="#" class="block py-2 px-3 hover:bg-gray-700 rounded">Status Penerimaan</a></li>
    </ul>
</aside>
