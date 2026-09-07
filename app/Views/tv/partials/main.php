<section
    class="
        h-[73vh] p-[1vw] grid grid-cols-1
        lg:grid-cols-[minmax(0,7fr)_minmax(300px,3fr)] gap-[1vw]
    "
>
    <div class="min-w-0 min-h-0 relative">
        <div
            x-show="mode === 1"
            x-cloak
            class="w-full h-full rounded-[clamp(12px,1.5vw,24px)] bg-cover bg-center flex flex-col items-center justify-center text-white shadow-lg"
            style="background-image: linear-gradient(rgba(0,40,40,.55), rgba(0,20,20,.7)), url('<?= base_url('assets/bg/mosque-bg-spesial.jpg') ?>');"
        >
            <div class="text-[clamp(3rem,10vw,10rem)] font-extrabold tracking-tight" x-text="formatTime(now)"></div>
            <div class="mt-[1vh] text-center text-[clamp(1rem,2vw,2rem)]">
                <span x-text="formatDay(now)"></span>, <span x-text="formatDate(now)"></span>
                <span class="mx-3 opacity-60">|</span>
                <span class="text-teal-200"><?= esc($dateHijriyah ?? '') ?></span>
            </div>
            <div class="mt-[4vh] text-[clamp(1.3rem,3vw,3rem)] font-bold"><?= esc($mosque['name'] ?? '') ?></div>
            <div class="text-[clamp(.8rem,1.4vw,1.4rem)] text-white/80"><?= esc($mosque['address'] ?? '') ?></div>
        </div>

        <div x-show="mode === 2" x-cloak class="w-full h-full">
            <?= $this->include('tv/partials/slider') ?>
        </div>

        <div
            x-show="mode === 3"
            x-cloak
            class="w-full h-full rounded-[clamp(12px,1.5vw,24px)] bg-slate-900 text-white flex items-center justify-center p-[4vw] shadow-lg"
        >
            <div class="w-full text-center">
                <h1 class="text-[clamp(2rem,5vw,5rem)] font-extrabold" x-text="currentAnnouncement.judul"></h1>
                <template x-if="currentAnnouncement.kategori === 'keuangan_jumat'">
                    <table class="mt-8 w-full text-left text-[clamp(1rem,2vw,2rem)]">
                        <template x-for="row in announcementRows()" :key="row.label">
                            <tr class="border-b border-white/20">
                                <th class="py-3" x-text="row.label"></th>
                                <td class="py-3 text-right" x-text="row.value"></td>
                            </tr>
                        </template>
                    </table>
                </template>
                <div
                    x-show="currentAnnouncement.kategori !== 'keuangan_jumat'"
                    class="mt-8 text-[clamp(1.2rem,2.5vw,2.5rem)] whitespace-pre-line"
                    x-text="currentAnnouncement.isi"
                ></div>
            </div>
        </div>
    </div>

    <aside class="min-w-0 min-h-0">
        <?= $this->include('tv/partials/prayer-schedule') ?>
    </aside>
</section>
