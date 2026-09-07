<header
    class="
        h-[13vh]
        min-h-[90px]
        max-h-[150px]

        bg-[#005C5C]
        text-white

        flex
        items-center

        px-[2vw]
    "
>

    <div class="w-full flex items-center justify-between">

        <!-- CLOCK -->
        <div class="flex items-center gap-[1.5vw]">

            <div
                class="
                    text-[clamp(2.5rem,4vw,5rem)]
                    font-bold
                    tracking-tight
                    leading-none
                "
                x-text="
                    now.toLocaleTimeString('id-ID', {
                        hour12: false
                    })
                "
            ></div>

            <div class="h-[5vh] w-px bg-white/40"></div>

            <div>

                <div
                    class="
                        text-[clamp(.9rem,1.5vw,1.6rem)]
                        font-medium
                    "
                >
                    <span x-text="formatDate(now)"></span>
                </div>

                <div
                    class="
                        text-[clamp(.7rem,1.2vw,1.3rem)]
                        text-white/75
                    "
                >
                    <?= esc($dateHijriyah ?? '') ?>
                </div>

            </div>

        </div>


        <!-- MOSQUE -->
        <div class="flex items-center gap-[1vw]">

            <div>

                <div
                    class="
                        text-[clamp(1.2rem,2vw,2.2rem)]
                        font-bold
                    "
                >
                    <?= esc($mosque['name'] ?? 'Masjid Al Ukhuwwah') ?>
                </div>

                <div
                    class="
                        text-[clamp(.8rem,1.3vw,1.4rem)]
                        text-white/80
                    "
                >
                    <?= esc($mosque['address'] ?? 'Griya Saluyu, Bandung') ?>
                </div>

            </div>

        </div>

    </div>

</header>