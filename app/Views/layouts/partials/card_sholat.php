<div class="absolute bottom-0 w-full px-6 py-4 bg-black/20 z-10">
    <div class="grid grid-cols-8 gap-3">
        <!-- Card Imsak -->
        <div data-sholat="imsak" data-warna="blue-600"
            class="rounded-xl px-4 py-4 text-center shadow-lg bg-white text-black border-b-4 border-blue-600 transition-all duration-300">
            <h2 class="text-xl font-semibold">Imsak</h2>
            <p class="text-4xl font-bold"><?= substr($jadwal['imsak'], 0, 5) ?></p>
        </div>

        <!-- Card Subuh -->
        <div data-sholat="subuh" data-warna="green-600"
            class="rounded-xl px-4 py-4 text-center shadow-lg bg-white text-black border-b-4 border-green-600 transition-all duration-300">
            <h2 class="text-xl font-semibold">Shubuh</h2>
            <p class="text-4xl font-bold"><?= substr($jadwal['subuh'], 0, 5) ?></p>
        </div>

        <!-- Card Syuruq -->
        <div data-sholat="syuruq" data-warna="red-600"
            class="rounded-xl px-4 py-4 text-center shadow-lg bg-white text-black border-b-4 border-red-600 transition-all duration-300">
            <h2 class="text-xl font-semibold">Syuruq</h2>
            <p class="text-4xl font-bold"><?= substr($jadwal['syuruq'], 0, 5) ?></p>
        </div>

        <!-- Card Dhuha -->
        <div data-sholat="dhuha" data-warna="yellow-600"
            class="rounded-xl px-4 py-4 text-center shadow-lg bg-white text-black border-b-4 border-yellow-600 transition-all duration-300">
            <h2 class="text-xl font-semibold">Dhuha</h2>
            <p class="text-4xl font-bold"><?= substr($jadwal['dhuha'], 0, 5) ?></p>
        </div>

        <!-- Card Dzuhur -->
        <div data-sholat="dzuhur" data-warna="purple-600"
            class="rounded-xl px-4 py-4 text-center shadow-lg bg-white text-black border-b-4 border-purple-600 transition-all duration-300">
            <h2 class="text-xl font-semibold">Dzuhur</h2>
            <p class="text-4xl font-bold"><?= substr($jadwal['dzuhur'], 0, 5) ?></p>
        </div>

        <!-- Card Ashar -->
        <div data-sholat="ashar" data-warna="pink-600"
            class="rounded-xl px-4 py-4 text-center shadow-lg bg-white text-black border-b-4 border-pink-600 transition-all duration-300">
            <h2 class="text-xl font-semibold">Ashar</h2>
            <p class="text-4xl font-bold"><?= substr($jadwal['ashar'], 0, 5) ?></p>
        </div>

        <!-- Card Maghrib -->
        <div data-sholat="maghrib" data-warna="indigo-600"
            class="rounded-xl px-4 py-4 text-center shadow-lg bg-white text-black border-b-4 border-indigo-600 transition-all duration-300">
            <h2 class="text-xl font-semibold">Maghrib</h2>
            <p class="text-4xl font-bold"><?= substr($jadwal['maghrib'], 0, 5) ?></p>
        </div>

        <!-- Card Isya -->
        <div data-sholat="isya" data-warna="teal-600"
            class="rounded-xl px-4 py-4 text-center shadow-lg bg-white text-black border-b-4 border-teal-600 transition-all duration-300">
            <h2 class="text-xl font-semibold">Isya'</h2>
            <p class="text-4xl font-bold"><?= substr($jadwal['isya'], 0, 5) ?></p>
        </div>
    </div>
</div>