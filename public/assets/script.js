// public/assets/script.js
function startClock() {
    const el = document.getElementById('time');
    const h = document.getElementById('hijri');
    function tick() {
        const d = new Date();
        el.innerText = d.toLocaleTimeString('en-GB');
        // simple hijri approximation -> use external lib if needed; here placeholder
        const hijri = new Intl.DateTimeFormat('en-u-ca-islamic', { day: 'numeric', month: 'long', year: 'numeric' }).format(d);
        if (h) h.innerText = hijri;
    }
    tick(); setInterval(tick, 1000);
}

function initSlider() {
    const slides = Array.from(document.querySelectorAll('.slide'));
    if (!slides.length) return;
    let idx = 0;
    function show(i) {
        slides.forEach((s, ii) => {
            s.classList.add('hidden');
            // lazy load
            if (!s.dataset.loaded) {
                const src = s.dataset.src;
                if (s.tagName == 'IMG') { s.src = src; s.dataset.loaded = '1'; }
                if (s.tagName == 'VIDEO') { s.src = src; s.load(); s.dataset.loaded = '1'; }
            }
        });
        const cur = slides[i];
        cur.classList.remove('hidden');
        if (cur.tagName == 'VIDEO') { cur.play().catch(() => { }); }
    }
    show(0);
    setInterval(() => {
        if (slides[idx] && slides[idx].tagName == 'VIDEO') { slides[idx].pause(); }
        idx = (idx + 1) % slides.length;
        show(idx);
    }, 8000);
}

function initCountdown(jadwal) {
    // jadwal: array keys subuh,dzuhur,ashar,maghrib,isya
    if (!jadwal || !jadwal.subuh) return;
    function nextPrayerTime() {
        const now = new Date();
        const times = ['imsak', 'subuh', 'syuruq', 'dhuha', 'dzuhur', 'ashar', 'maghrib', 'isya'];
        for (let t of times) {
            if (!jadwal[t]) continue;
            const dt = new Date(now.toDateString() + ' ' + jadwal[t]);
            if (dt > now) return { name: t, date: dt };
        }
        // next day: subuh tomorrow
        const tomorrow = new Date();
        tomorrow.setDate(tomorrow.getDate() + 1);
        const dt2 = new Date(tomorrow.toDateString() + ' ' + jadwal['subuh']);
        return { name: 'subuh', date: dt2 };
    }
    function tick() {
        const next = nextPrayerTime();
        const now = new Date();
        const diff = next.date - now;
        if (diff <= 0) {
            document.getElementById('countdown').innerText = 'Waktu ' + next.name + ' sedang berlangsung';
            return;
        }
        const h = Math.floor(diff / 3600000);
        const m = Math.floor((diff % 3600000) / 60000);
        const s = Math.floor((diff % 60000) / 1000);
        document.getElementById('countdown').innerText = `Menuju ${next.name.toUpperCase()}: ${h}j ${m}m ${s}s`;
    }
    tick(); setInterval(tick, 1000);
}
