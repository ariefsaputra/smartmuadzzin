<div
  x-show="overlay.active"
  x-transition.opacity
  class="fixed inset-0 z-[9999] text-white overflow-hidden">

  <!-- BACKGROUND GRADIENT (SOLID, NON-TRANSPARAN) -->
  <div class="absolute inset-0 bg-gradient-to-br from-emerald-900 via-slate-900 to-black"></div>

  <!-- VIGNETTE HALUS -->
  <div
    class="absolute inset-0"
    style="
      background: radial-gradient(
        circle at center,
        rgba(255,255,255,0.06) 0%,
        rgba(0,0,0,0.35) 60%,
        rgba(0,0,0,0.75) 100%
      );
    "></div>

  <!-- CONTENT WRAPPER -->
  <div class="relative z-10 w-full h-full flex flex-col justify-center items-center">

    <!-- JAM + TANGGAL (INLINE, TENGAH ATAS) -->
    <div class="absolute top-10 left-1/2 -translate-x-1/2 z-[10000] select-none text-center">

      <!-- JAM -->
      <div class="flex items-end justify-center space-x-3">

        <!-- HH -->
        <span
          class="text-[5.4rem] font-semibold tracking-wider leading-none text-white
           drop-shadow-[0_7px_22px_rgba(0,0,0,0.5)]"
          x-text="$store.clock.nowHHMM.slice(0,2)">
        </span>

        <!-- : -->
        <span
          class="text-[5.4rem] font-light leading-none text-white/55">
          :
        </span>

        <!-- MM -->
        <span
          class="text-[5.4rem] font-semibold tracking-wider leading-none text-white
           drop-shadow-[0_7px_22px_rgba(0,0,0,0.5)]"
          x-text="$store.clock.nowHHMM.slice(3,5)">
        </span>

        <!-- SS -->
        <span
          class="ml-3 mb-3 text-[3.4rem] font-medium leading-none text-teal-200/85"
          x-text="$store.clock.nowSS">
        </span>

      </div>

      <!-- TANGGAL (MASEHI + HIJRIYAH) -->
      <div
        class="mt-3 text-lg md:text-xl font-medium tracking-wide text-white/80 drop-shadow-[0_4px_16px_rgba(0,0,0,0.45)] flex justify-center items-center space-x-4">
        <!-- MASEHI -->
        <span>
          <span x-text="$store.clock.dayName"></span>,
          <span x-text="$store.clock.dateFull"></span>
        </span>

        <!-- SEPARATOR -->
        <span class="opacity-50">|</span>

        <!-- HIJRIYAH -->
        <span class="text-emerald-300/85">
          <?= esc($jadwal['hijriyah'] ?? '') ?>
        </span>
      </div>

    </div>

    <!-- STATE: MENJELANG ADZAN -->
    <template x-if="overlay.state === 'menjelang_adzan'">
      <div class="text-center mt-28 select-none">

        <!-- LABEL -->
        <div class="text-[3rem] uppercase tracking-[0.5em] text-amber-300/90 mb-8">
          Menjelang Adzan
        </div>

        <!-- NAMA SHOLAT -->
        <div
          class="text-[9.5rem]
                font-extrabold
                tracking-wide
                mb-16
                bg-gradient-to-r from-emerald-300 via-teal-300 to-cyan-300
                bg-clip-text text-transparent
                drop-shadow-[0_0_18px_rgba(34,211,238,0.55)]">
          <span x-text="overlay.namaSholat"></span>
        </div>

        <!-- COUNTDOWN -->
        <div
          class="text-[14rem] font-extrabold tracking-[0.18em] leading-none
            text-emerald-300
            drop-shadow-[0_20px_60px_rgba(16,185,129,0.45)] mb-14"
          x-text="overlay.countdown">
        </div>

        <!-- PESAN -->
        <div class="text-[4rem] font-medium text-white/90">
          Bersiaplah untuk melaksanakan sholat
        </div>

      </div>

    </template>

    <!-- STATE: ADZAN -->
    <template x-if="overlay.state === 'adzan'">
      <div class="text-center mt-28 select-none">

        <!-- LABEL -->
        <div class="text-[3rem] uppercase tracking-[0.5em] text-emerald-300/80 mb-8">
          Adzan
        </div>

        <!-- NAMA SHOLAT -->
        <div
          class="text-[9.5rem]
                font-extrabold
                tracking-wide
                mb-16
                bg-gradient-to-r from-emerald-300 via-teal-300 to-cyan-300
                bg-clip-text text-transparent
                drop-shadow-[0_0_18px_rgba(34,211,238,0.55)]">
          <span x-text="overlay.namaSholat"></span>
        </div>

        <!-- PESAN -->
        <div class="text-[4.2rem] font-medium text-white/85">
          Mohon tetap khusyuk mendengarkan adzan
        </div>

      </div>
    </template>



    <!-- STATE: MENJELANG IQAMAH -->
    <template x-if="overlay.state === 'menjelang_iqamah'">
      <div class="text-center mt-28 select-none">

        <!-- LABEL -->
        <div class="text-[3rem] uppercase tracking-[0.5em] text-amber-300/90 mb-8">
          Menuju Iqamah
        </div>

        <!-- COUNTDOWN -->
        <div
          class="text-[14.5rem] font-extrabold tracking-[0.2em] leading-none
                  text-white
                  drop-shadow-[0_24px_70px_rgba(255,255,255,0.25)] mb-16"
          x-text="overlay.countdown">
        </div>

        <!-- PESAN -->
        <div class="text-[4.2rem] font-semibold text-emerald-200">
          Segera rapatkan dan luruskan shaf
        </div>

      </div>

    </template>


    <!-- STATE: SHOLAT BERLANGSUNG -->
    <template x-if="overlay.state === 'sholat_berlangsung'">
      <div class="text-center mt-28 select-none">

        <!-- LABEL -->
        <div class="text-[3rem] uppercase tracking-[0.5em] text-slate-300 mb-8">
          Waktu Sholat
        </div>

        <!-- NAMA SHOLAT -->
        <div
          class="text-[9.5rem]
                font-extrabold
                tracking-wide
                mb-16
                bg-gradient-to-r from-emerald-300 via-teal-300 to-cyan-300
                bg-clip-text text-transparent
                drop-shadow-[0_0_18px_rgba(34,211,238,0.55)]">
          <span x-text="overlay.namaSholat"></span>
        </div>

        <!-- PESAN -->
        <div class="text-[4rem] font-medium text-white/80">
          Harap tenang dan khusyuk dalam sholat
        </div>

      </div>

    </template>

    <!-- JUMAT PRE -->
    <template x-if="overlay.state === 'jumat_pre'">
      <div class="text-center space-y-6">
        <!-- PRE JUMAT -->
        <div class="text-[8.5rem] font-extrabold text-white mb-10">
          Persiapan Sholat Jumat
        </div>

        <div class="text-[4.5rem] text-amber-300 mb-12">
          Menuju Adzan Dzuhur
        </div>

        <div
          class="text-[15rem] font-extrabold tracking-[0.22em]
              text-emerald-300
              drop-shadow-[0_24px_70px_rgba(16,185,129,0.5)]"
          x-text="overlay.countdown">
        </div>
      </div>
    </template>

    <!-- JUMAT ADZAN -->
    <template x-if="overlay.state === 'jumat_adzan'">
      <div class="text-center space-y-6">
        <div class="text-6xl font-extrabold animate-pulse">
          ADZAN JUMAT SEDANG BERLANGSUNG
        </div>
      </div>
    </template>

    <!-- JUMAT SHOLAT -->
    <template x-if="overlay.state === 'jumat_sholat'">
      <div class="text-center space-y-6">
        <div class="text-6xl font-bold animate-pulse">WAKTU SHOLAT JUMAT</div>
        <div class="text-4xl opacity-80">Harap Tenang</div>
      </div>
    </template>

    <!-- STATE: WAKTU SHOLAT -->
    <template x-if="overlay.state === 'waktu_sholat'">
      <div class="text-center space-y-8">
        <!-- LABEL -->
        <div class="text-[3rem] uppercase tracking-[0.5em] text-slate-300 mb-8">
          Waktu Sholat
        </div>

        <!-- NAMA SHOLAT -->
        <div
          class="text-[9.5rem]
                font-extrabold
                tracking-wide
                mb-16
                bg-gradient-to-r from-emerald-300 via-teal-300 to-cyan-300
                bg-clip-text text-transparent
                drop-shadow-[0_0_18px_rgba(34,211,238,0.55)]">
          <span x-text="overlay.namaSholat"></span>
        </div>

        <!-- PESAN -->
        <div class="text-[4rem] font-medium text-white/80">
          Harap tenang dan khusyuk dalam sholat
        </div>

      </div>
    </template>
  </div>
</div>