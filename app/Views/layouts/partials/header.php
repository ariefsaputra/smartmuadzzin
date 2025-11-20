<header class="bg-amber-900 text-white px-6 py-4 flex justify-between items-center shadow-xl">
    <!-- Jam Digital -->
    <div id="jam-digital" class="text-7xl font-bold tracking-widest flex items-center gap-1">
        <span id="jam">00</span>
        <span id="separator">:</span>
        <span id="menit">00</span>
    </div>

    <!-- Nama & Alamat Masjid -->
    <div class="text-center max-w-full">
        <div class="gradient-dynamic backdrop-blur-sm rounded-xl shadow-lg px-4 py-2 border border-amber-500/40 inline-block w-full">
            <!-- Nama Masjid -->
            <h1 class="text-4xl font-bold uppercase tracking-wide text-white drop-shadow-md truncate">
                <?= esc($pengaturan['nama_masjid'] ?? 'Nama Masjid') ?>
            </h1>
            <!-- Alamat Masjid -->
            <div class="mt-1 overflow-hidden whitespace-nowrap relative h-8">
                <p id="alamatMasjid"
                    class="text-xl font-medium text-white/90 inline-block px-4 animate-marquee-on-overflow">
                    <?= esc($pengaturan['alamat'] ?? 'Alamat Masjid') ?>
                </p>
            </div>
        </div>
    </div>

    <!-- Tanggal Masehi & Hijriyah -->
    <div
        x-data="{
            tanggalM: '',
            tanggalH: '<?= esc($jadwal['tanggal_hijriyah'] ?? 'Hijriyah') ?>',
            init() {
                const now = new Date();
                const options = { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' };
                this.tanggalM = now.toLocaleDateString('id-ID', options);
            }
        }"
        x-init="init()"
        class="text-right leading-tight">
        <p x-text="tanggalH" class="text-3xl font-bold"></p>
        <p x-text="tanggalM" class="text-2xl italic text-white/70"></p>
    </div>
</header>