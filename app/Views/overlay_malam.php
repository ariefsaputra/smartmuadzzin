<!-- Overlay Malam: tampil otomatis pukul 21.00 - 03.30, menghitung mundur menuju Imsak -->
<div x-show="nightOverlay.active" x-cloak x-transition.opacity class="fixed inset-0 z-[9998] flex flex-col items-center justify-center bg-black text-[#eaf2fb]">

    <!-- Ikon Bulan Sabit dengan efek glow -->
    <svg class="h-[clamp(4rem,9vw,9rem)] w-[clamp(4rem,9vw,9rem)] drop-shadow-[0_0_25px_rgba(173,216,255,0.55)]" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M62 8C40 12 24 32 24 55c0 26 21 42 42 42 8 0 15-1.5 21-4.3-14.4 1-32-8.5-32-33.7 0-22 13-38 8-51z" fill="#cfe6ff"/>
    </svg>

    <!-- Judul MALAM -->
    <div class="mt-[3vh] text-[clamp(1.6rem,3.2vw,3.6rem)] font-extrabold tracking-[.5em]">MALAM</div>
    <div class="mt-[1vh] text-[clamp(.75rem,1.3vw,1.5rem)] font-medium tracking-[.4em] text-[#9fb3c8]">SAATNYA BERISTIRAHAT</div>

    <!-- Garis Pemisah -->
    <div class="mt-[3vh] h-px w-[clamp(3rem,6vw,7rem)] bg-[#9fb3c8]/50"></div>

    <!-- Menuju Imsak -->
    <div class="mt-[3vh] text-[clamp(.7rem,1.2vw,1.3rem)] font-semibold tracking-[.4em] text-[#9fb3c8]">MENUJU IMSAK</div>

    <!-- Countdown -->
    <div class="mt-[1vh] text-[clamp(3.5rem,9vw,9.5rem)] font-extrabold leading-none tracking-tight tabular-nums" x-text="nightOverlay.countdown"></div>

    <!-- Label JAM MENIT DETIK -->
    <div class="mt-[1vh] flex w-[clamp(20rem,38vw,44rem)] justify-between px-[3vw] text-[clamp(.6rem,1vw,1.1rem)] font-semibold tracking-[.4em] text-[#9fb3c8]">
        <span>JAM</span><span>MENIT</span><span>DETIK</span>
    </div>

</div>