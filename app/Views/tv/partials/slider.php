<div
    class="
        relative
        w-full
        h-full

        overflow-hidden

        rounded-[clamp(12px,1.5vw,24px)]

        bg-black
    "
>

    <!-- SLIDES -->

    <template x-for="(slide, index) in slides" :key="index">

        <div
            x-show="currentSlide === index"

            x-transition:enter="transition ease-out duration-700"
            x-transition:enter-start="opacity-0 scale-105"
            x-transition:enter-end="opacity-100 scale-100"

            class="absolute inset-0"
        >

            <img
                x-show="slide.type === 'image'"
                :src="slide.url"
                :alt="slide.title ?? ''"

                class="
                    w-full
                    h-full

                    object-cover
                "
            >
            <video x-show="slide.type === 'video'" :src="slide.url" autoplay muted loop class="w-full h-full object-cover"></video>
        </div>

    </template>

    <?php /*
    <!-- LEFT ARROW -->

    <button
        @click="
            currentSlide =
            currentSlide === 0
            ? slides.length - 1
            : currentSlide - 1
        "

        class="
            absolute
            left-[1vw]
            top-1/2
            -translate-y-1/2

            w-[clamp(40px,3vw,64px)]
            h-[clamp(40px,3vw,64px)]

            rounded-full

            bg-black/35
            hover:bg-black/55

            text-white

            flex
            items-center
            justify-center

            text-[clamp(1.5rem,2.5vw,3rem)]
        "
    >
        ‹
    </button>


    <!-- RIGHT ARROW -->

    <button
        @click="
            currentSlide =
            (currentSlide + 1) % slides.length
        "

        class="
            absolute
            right-[1vw]
            top-1/2
            -translate-y-1/2

            w-[clamp(40px,3vw,64px)]
            h-[clamp(40px,3vw,64px)]

            rounded-full

            bg-black/35
            hover:bg-black/55

            text-white

            flex
            items-center
            justify-center

            text-[clamp(1.5rem,2.5vw,3rem)]
        "
    >
        ›
    </button>
    */ ?>

    <!-- INDICATOR -->

    <div
        class="
            absolute
            bottom-[1vw]
            left-1/2
            -translate-x-1/2

            flex
            gap-[.5vw]
        "
    >

        <template
            x-for="(slide, index) in slides"
            :key="index"
        >

            <button
                @click="currentSlide = index"

                class="
                    w-[clamp(8px,.7vw,14px)]
                    h-[clamp(8px,.7vw,14px)]

                    rounded-full

                    transition-all
                "

                :class="
                    currentSlide === index
                    ? 'bg-white scale-125'
                    : 'bg-white/50'
                "
            ></button>

        </template>

    </div>

</div>