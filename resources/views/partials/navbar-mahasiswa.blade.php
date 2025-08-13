<nav class="bg-white border-b border-gray-200 px-4 py-2 flex justify-between items-center">
    <div class="text-lg font-semibold">PMB Online - Mahasiswa</div>
    <div>
        <form action="{{ route('logout') }}" method="POST" class="inline">
            @csrf
            <button type="submit" class="text-red-500 hover:underline">Logout</button>
        </form>
    </div>
</nav>
