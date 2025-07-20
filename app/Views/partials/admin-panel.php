<div id="admin-panel" x-data="{ showAdmin: false, activeTab: 'masjid' }">
    <!-- Tombol Setting -->
    <a href="#" @click="showAdmin = true; loadPengaturan()"
        class="fixed top-1/2 right-0 transform -translate-y-1/2 translate-x-1/2 bg-blue-600 hover:bg-blue-700 text-white rounded-l-full px-3 py-2 shadow-md z-50">
        ⚙️
    </a>

    <!-- Panel -->
    <div x-show="showAdmin" x-transition class="fixed inset-0 bg-white z-50 overflow-auto" style="display: none;">
        <!-- Header -->
        <div class="bg-blue-700 text-white px-6 py-4 flex justify-between items-center shadow">
            <h2 class="text-xl font-bold">Pengaturan TV Masjid</h2>
            <button id="btn-close-admin" @click="showAdmin = false" class="text-white text-2xl">✖</button>
        </div>

        <!-- Tabs -->
        <div class="border-b bg-gray-100 px-6">
            <nav class="flex space-x-4 pt-4">
                <template x-for="tab in ['masjid', 'jadwal', 'durasi']">
                    <button :class="activeTab === tab ? 'border-b-4 border-blue-600 text-blue-700 font-bold' : 'text-gray-600'"
                        @click="activeTab = tab"
                        class="pb-3 px-2 capitalize">
                        <span x-text="tab === 'masjid' ? '🏠 Masjid' : tab === 'jadwal' ? '🕒 Jadwal Sholat' : '⏱ Durasi'"></span>
                    </button>
                </template>
            </nav>
        </div>

        <!-- Konten Tab -->
        <div class="p-6 space-y-6">
            <!-- Tab Masjid -->
            <div x-show="activeTab === 'masjid'" x-transition>
                <h3 class="text-lg font-semibold mb-2">Informasi Masjid</h3>
                <div class="space-y-4">
                    <input type="text" class="w-full border rounded px-3 py-2" placeholder="Masjid Al-Falah" id="namaMasjid">
                    <input type="text" class="w-full border rounded px-3 py-2" placeholder="3273" id="idKota">
                    <textarea class="w-full border rounded px-3 py-2" rows="3" placeholder="Jl. Cibogo No. 25, Bandung" id="alamatMasjid"></textarea>
                    <button onclick="simpanPengaturan()" class="bg-green-600 text-white px-4 py-2 rounded">💾 Simpan Pengaturan</button>
                </div>
            </div>

            <!-- Tab Jadwal -->
            <div x-show="activeTab === 'jadwal'" x-transition>
                <h3 class="text-lg font-semibold mb-2">Sinkronisasi Jadwal Sholat</h3>
                <div class="space-y-4">
                    <button onclick="syncHariIni()" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded w-full">🔄 Sinkron Hari Ini</button>
                    <button onclick="syncSebulan()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded w-full">📅 Sinkron Bulan Ini</button>
                    <button onclick="syncSetahun()" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded w-full">📆 Sinkron 1 Tahun</button>
                    <div class="mt-4 bg-gray-100 p-4 rounded border text-sm text-gray-700">
                        <strong>Status:</strong> Jadwal terakhir diupdate <span id="lastUpdate">-</span>
                    </div>
                </div>
            </div>

            <!-- Tab Durasi -->
            <div x-show="activeTab === 'durasi'" x-transition>
                <h3 class="text-lg font-semibold mb-2">Pengaturan Durasi per Waktu Sholat</h3>
                <template x-for="waktu in ['shubuh', 'dzuhur', 'ashar', 'maghrib', 'isya']">
                    <div class="border p-4 rounded-md bg-gray-50 mb-4">
                        <h4 class="font-bold capitalize mb-2" x-text="waktu"></h4>
                        <div class="grid grid-cols-3 gap-4">
                            <input :id="'durasi_' + waktu + '_adzan'" type="number" class="w-full border rounded px-2 py-1" placeholder="Adzan (detik)">
                            <input :id="'durasi_' + waktu + '_iqamah'" type="number" class="w-full border rounded px-2 py-1" placeholder="Iqamah (detik)">
                            <input :id="'durasi_' + waktu + '_sholat'" type="number" class="w-full border rounded px-2 py-1" placeholder="Sholat (detik)">
                        </div>
                    </div>
                </template>
                <button onclick="simpanPengaturan()" class="bg-green-600 text-white px-4 py-2 rounded">💾 Simpan Pengaturan</button>
            </div>
        </div>
    </div>
</div>