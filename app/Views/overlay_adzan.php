<div x-show="overlay.active" x-cloak x-transition.opacity class="fixed inset-0 z-[9999] overflow-hidden text-[#fff9e9]">
  <div class="absolute inset-0 bg-cover bg-center" style="background-image: linear-gradient(120deg, rgba(0,59,65,.94), rgba(9,116,111,.72) 45%, rgba(255,146,68,.62)), url('<?= base_url('assets/bg/mosque-bg-spesial.jpg') ?>');"></div>
  <div class="absolute inset-0 bg-slate-950/20"></div>

  <div class="relative h-full px-[3.5vw] py-[4vh]">
    <div class="flex items-start justify-between">
      <div>
        <div class="text-[clamp(.7rem,1.2vw,1.3rem)] font-semibold tracking-[.45em] text-white/75">MASJID</div>
        <div class="mt-1 text-[clamp(1.5rem,2.6vw,3rem)] font-extrabold leading-none"><?= esc($data['nama_masjid'] ?? '') ?></div>
        <div class="mt-2 text-[clamp(.55rem,.9vw,1rem)] tracking-[.28em] text-white/65"><?= esc($data['alamat_masjid'] ?? '') ?></div>
      </div>
      <div class="flex items-center gap-[2vw] text-right">
        <div class="border-r border-white/45 pr-[2vw]">
          <div class="text-[clamp(.8rem,1.3vw,1.5rem)]" x-text="`${$store.clock.dayName}, ${$store.clock.dateFull}`"></div>
          <div class="mt-1 text-[clamp(.65rem,1vw,1.1rem)] text-white/70"><?= esc($jadwal['hijriyah'] ?? '') ?></div>
        </div>
        <div class="text-[clamp(2.5rem,5vw,6rem)] font-extrabold leading-none tabular-nums" x-text="$store.clock.nowHHMM"></div>
      </div>
    </div>

    <div class="absolute inset-x-0 top-[20%] flex flex-col items-center text-center">
      <div x-show="!['waktu_sholat', 'jumat_sholat'].includes(overlay.state)" class="text-[clamp(3rem,6vw,7rem)] leading-none">۩</div>
      <template x-if="overlay.state === 'adzan'">
        <div class="mt-[2vh] flex flex-col items-center">
          <div class="text-[clamp(5rem,10vw,12rem)] font-extrabold leading-none tracking-[.2em]">ADZAN</div>
          <div class="mt-[1vh] text-[clamp(1rem,2vw,2.3rem)] font-medium tracking-[.55em] text-white/90">SEDANG BERKUMANDANG</div>
          <div class="mt-[3vh] h-1 w-[clamp(3rem,6vw,7rem)] rounded-full bg-[#fff9e9]"></div>
          <div class="mt-[3vh] text-[clamp(.8rem,1.4vw,1.6rem)] font-medium tracking-[.5em] text-white/70">MARI MENUJU MASJID</div>
        </div>
      </template>
      <template x-if="['waktu_sholat', 'jumat_sholat'].includes(overlay.state)">
        <div class="mt-[16vh] flex flex-col items-center">
          <div class="text-[clamp(5rem,10vw,12rem)] font-extrabold leading-none tracking-[.2em]">SHOLAT</div>
          <div class="mt-[2vh] text-[clamp(1rem,2vw,2.3rem)] font-medium tracking-[.55em] text-white/90">MARI FOKUS BERIBADAH</div>
        </div>
      </template>
      <template x-if="!['adzan', 'waktu_sholat', 'jumat_sholat'].includes(overlay.state)">
        <div class="flex flex-col items-center">
          <div class="mt-[1vh] text-[clamp(1.5rem,3vw,3.5rem)] font-extrabold tracking-[.35em]" x-text="overlayTitle()"></div>
          <div class="mt-[1vh] text-[clamp(.75rem,1.4vw,1.6rem)] font-medium tracking-[.45em] text-white/65" x-text="overlayMessage()"></div>
          <div x-show="overlay.countdown" class="mt-[3vh] text-[clamp(6rem,13vw,15rem)] font-extrabold leading-none tracking-tight tabular-nums" x-text="overlay.countdown"></div>
          <div x-show="overlay.countdown" class="mt-[1vh] flex w-[clamp(18rem,35vw,42rem)] justify-between px-[3vw] text-[clamp(.6rem,1vw,1.1rem)] font-semibold tracking-[.45em] text-white/60">
            <span>MENIT</span><span>DETIK</span>
          </div>
        </div>
      </template>
    </div>

    <div class="absolute inset-x-0 bottom-[7vh] text-center">
      <template x-if="['waktu_sholat', 'jumat_sholat'].includes(overlay.state)">
        <div>
          <p class="mx-auto max-w-3xl text-[clamp(.75rem,1.15vw,1.35rem)] italic leading-relaxed text-white/75">"Sungguh beruntung orang-orang yang beriman, yaitu mereka yang khusyuk dalam sholatnya."</p>
          <p class="mt-1 text-[clamp(.55rem,.8vw,.9rem)] text-white/55">(QS. Al-Mu'minun: 1-2)</p>
        </div>
      </template>
      <template x-if="!['waktu_sholat', 'jumat_sholat'].includes(overlay.state)">
        <div>
          <p class="mx-auto max-w-3xl text-[clamp(.75rem,1.15vw,1.35rem)] italic leading-relaxed text-white/75">"Dirikanlah shalat, sesungguhnya shalat itu mencegah dari perbuatan keji dan mungkar."</p>
          <p class="mt-1 text-[clamp(.55rem,.8vw,.9rem)] text-white/55">(QS. Al-Ankabut: 45)</p>
        </div>
      </template>
    </div>
  </div>
</div>
