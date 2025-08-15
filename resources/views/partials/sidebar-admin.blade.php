<aside 
    x-data="{
        masterOpen: JSON.parse(localStorage.getItem('masterOpen') ?? 'false'),
        camabaOpen: JSON.parse(localStorage.getItem('camabaOpen') ?? 'false'),
        kampusOpen: JSON.parse(localStorage.getItem('kampusOpen') ?? 'false'),
        wilayahOpen: JSON.parse(localStorage.getItem('wilayahOpen') ?? 'false')
    }"
    x-init="
        $watch('masterOpen', value => localStorage.setItem('masterOpen', JSON.stringify(value)));
        $watch('camabaOpen', value => localStorage.setItem('camabaOpen', JSON.stringify(value)));
        $watch('kampusOpen', value => localStorage.setItem('kampusOpen', JSON.stringify(value)));
        $watch('wilayahOpen', value => localStorage.setItem('wilayahOpen', JSON.stringify(value)));
    "
    class="bg-gray-800 text-white w-64 min-h-screen px-4 py-6"
>
    <h2 class="text-xl font-bold mb-6">Admin SideBar</h2>
    <ul class="space-y-1">

        {{-- Dashboard --}}
        <li>
            <a href="{{ route('admin.dashboard') }}"
               class="flex items-center gap-2 py-2 px-3 hover:bg-gray-700 rounded">
                📊 <span>Dashboard</span>
            </a>
        </li>

        {{-- Pengumuman --}}
        <li>
            <a href="#"
               class="flex items-center gap-2 py-2 px-3 hover:bg-gray-700 rounded">
                📢 <span>Pengumuman</span>
            </a>
        </li>

        {{-- Master Data --}}
        <li>
            <button @click="masterOpen = !masterOpen"
                    class="flex items-center justify-between w-full py-2 px-3 hover:bg-gray-700 rounded">
                <span class="flex items-center gap-2">📂 Master Data</span>
                <span x-text="masterOpen ? '▲' : '▼'"></span>
            </button>

            <ul x-show="masterOpen" class="pl-6 mt-1 space-y-1" x-cloak>

                {{-- Data CaMaBa --}}
                <li>
                    <button @click="camabaOpen = !camabaOpen"
                            class="flex items-center justify-between w-full py-2 px-3 hover:bg-gray-700 rounded">
                        <span class="flex items-center gap-2">🧑‍🎓 Data CaMaBa</span>
                        <span x-text="camabaOpen ? '▲' : '▼'"></span>
                    </button>
                    <ul x-show="camabaOpen" class="pl-6 mt-1 space-y-1" x-cloak>
                        <li>
                            <a href="#"
                               class="flex items-center gap-2 py-2 px-3 hover:bg-gray-700 rounded">
                                📄 <span>CaMaBa</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.agama.index') }}"
                               class="flex items-center gap-2 py-2 px-3 hover:bg-gray-700 rounded">
                                🙏 <span>Agama</span>
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- Data Kampus --}}
                <li>
                    <button @click="kampusOpen = !kampusOpen"
                            class="flex items-center justify-between w-full py-2 px-3 hover:bg-gray-700 rounded">
                        <span class="flex items-center gap-2">🏫 Data Kampus</span>
                        <span x-text="kampusOpen ? '▲' : '▼'"></span>
                    </button>
                    <ul x-show="kampusOpen" class="pl-6 mt-1 space-y-1" x-cloak>
                        <li>
                            <a href="{{ route('admin.fakultas.index') }}" class="flex items-center gap-2 py-2 px-3 hover:bg-gray-700 rounded">
                                🎓 <span>Fakultas</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.jurusan.index') }}" class="flex items-center gap-2 py-2 px-3 hover:bg-gray-700 rounded">
                                📚 <span>Jurusan</span>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="flex items-center gap-2 py-2 px-3 hover:bg-gray-700 rounded">
                                💰 <span>UKT</span>
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- Data Wilayah --}}
                <li>
                    <button @click="wilayahOpen = !wilayahOpen"
                            class="flex items-center justify-between w-full py-2 px-3 hover:bg-gray-700 rounded">
                        <span class="flex items-center gap-2">🌍 Data Wilayah</span>
                        <span x-text="wilayahOpen ? '▲' : '▼'"></span>
                    </button>
                    <ul x-show="wilayahOpen" class="pl-6 mt-1 space-y-1" x-cloak>
                        <li>
                            <a href="#" class="flex items-center gap-2 py-2 px-3 hover:bg-gray-700 rounded">
                                🏛 <span>Provinsi</span>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="flex items-center gap-2 py-2 px-3 hover:bg-gray-700 rounded">
                                🏢 <span>Kabupaten</span>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="flex items-center gap-2 py-2 px-3 hover:bg-gray-700 rounded">
                                🏘 <span>Kecamatan</span>
                            </a>
                        </li>
                    </ul>
                </li>

            </ul>
        </li>

    </ul>
</aside>
