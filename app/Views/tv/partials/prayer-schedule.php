<div class="h-full rounded-[clamp(16px,1.5vw,24px)] bg-gradient-to-b from-[#075c5d] via-[#064b4d] to-[#033f42] p-[clamp(8px,.7vw,16px)] shadow-xl ring-1 ring-white/15">
    <div class="h-full flex flex-col justify-between gap-[.55vh]">
        <?php foreach ($prayerTimes ?? [] as $prayer): ?>
            <?= view('tv/partials/prayer-item', ['prayer' => $prayer]) ?>
        <?php endforeach; ?>
    </div>
</div>
