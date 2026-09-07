<?php
$name = $prayer['name'] ?? '';
$time = $prayer['time'] ?? '--:--';
?>
<div
    class="flex min-h-0 flex-1 items-center justify-between overflow-hidden rounded-[clamp(12px,1vw,18px)] border px-[.9vw] py-[.55vh] transition-all duration-300"
    :class='isNextPrayer(<?= esc(json_encode($time), 'attr') ?>)
        ? "border-amber-100 bg-gradient-to-r from-[#fff0be] via-[#ffe5a2] to-[#f6cd75] text-[#152525] shadow-lg"
        : "border-white/25 bg-[#034d50]/45 text-white"'
>
    <div class="flex items-center gap-[.85vw]">
        <div
            class="flex h-[clamp(30px,2.3vw,48px)] w-[clamp(30px,2.3vw,48px)] items-center justify-center text-[clamp(1.3rem,2vw,2.3rem)]"
            :class="isNextPrayer(<?= esc(json_encode($time), 'attr') ?>) ? 'text-[#1d2925]' : '<?= esc($prayer['color'] ?? 'text-amber-300') ?>'"
        ><?= $prayer['icon'] ?? '☀' ?></div>
        <span class="text-[clamp(.9rem,1.4vw,1.55rem)] font-semibold"><?= esc($name) ?></span>
    </div>

    <div class="flex items-center gap-[.8vw]">
        <?php
        //DISPLAY PRAYER TIME HH:MM
        $timeParts = explode(':', $time);
        $hours = $timeParts[0] ?? '--';
        $minutes = $timeParts[1] ?? '--';
        $time = sprintf('%02s:%02s', $hours, $minutes);
        ?>
        <span class="text-[clamp(1.15rem,1.9vw,2rem)] font-extrabold tabular-nums"><?= esc($time) ?></span>
        <div
            x-show='isNextPrayer(<?= esc(json_encode($time), 'attr') ?>)'
            x-cloak
            class="min-w-[clamp(62px,5vw,108px)] border-l border-[#9b762c]/30 pl-[.7vw] text-center leading-none"
        >
            <div class="text-[clamp(.8rem,1.2vw,1.35rem)] font-extrabold tabular-nums" x-text='prayerCountdown(<?= esc(json_encode($time), 'attr') ?>)'></div>
            <div class="mt-1 text-[clamp(.45rem,.6vw,.7rem)] font-bold">lagi</div>
        </div>
    </div>
</div>
