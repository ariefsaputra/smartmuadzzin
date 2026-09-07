<footer
    class="
        h-[14vh]
        min-h-[80px]

        bg-[#005C5C]

        text-white

        flex
        items-center

        px-[1.5vw]
    "
>

    <div class="w-full flex items-center gap-[1vw]">

        <!-- SOUND ACTIVATION-->
        <div
            class="
                text-[clamp(1.5rem,2.5vw,3rem)]
                shrink-0
            "
        >
            🔊
        </div>

        <!-- TICKER -->

        <div
            class="
                flex-1
                overflow-hidden
                whitespace-nowrap
            "
        >

            <div
                class="
                    text-[clamp(.7rem,1.1vw,1.5rem)]
                "
            >

                <?php
                $running_text = $running_text ?? '';
                ?>
                
                <?= esc($running_text ?: 'Selamat datang di Masjid ' . ($mosque['name'] ?? '')) ?>

            </div>

        </div>


        <div class="hidden h-[9vh] min-w-[clamp(150px,15vw,270px)] border-l border-white/30 pl-[2vw] xl:flex items-center shrink-0">
            <!-- LOGO -->
            <img
                src="<?= base_url('assets/logo-horizontal-2.png') ?>"
                alt="SmartMuadzzin"
                class="h-full w-full object-contain object-right"
            >
        </div>

    </div>

</footer>