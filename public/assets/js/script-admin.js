// START -- ADMIN PANEL
const adminPanel = document.getElementById('admin-panel');
const btnClose = document.getElementById('btn-close-admin');

btnClose.addEventListener('click', () => {
    adminPanel.classList.add('hidden');
    // ⬇️ Tambahkan reload display utama
    location.reload();
});

// Jika ingin juga bisa di-close pakai tombol ESC
document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape' && !adminPanel.classList.contains('hidden')) {
        adminPanel.classList.add('hidden');
        location.reload();
    }
});

// SIMPAN PENGATURAN INFORMASI MASJID
function loadPengaturan() {
    fetch('/pengaturan/load')
        .then(res => res.json())
        .then(json => {
            if (json.status) {
                const data = json.data;

                // Load umum
                document.getElementById('namaMasjid').value = data.nama_masjid || '';
                document.getElementById('idKota').value = data.id_kota || '';
                document.getElementById('alamatMasjid').value = data.alamat || '';

                // Load durasi per waktu
                const waktu = ['shubuh', 'dzuhur', 'ashar', 'maghrib', 'isya'];
                const jenis = ['adzan', 'iqamah', 'sholat'];

                waktu.forEach(w => {
                    jenis.forEach(j => {
                        const key = `durasi_${w}_${j}`;
                        const el = document.getElementById(key);
                        if (el && data[key]) el.value = data[key];
                    });
                });

            } else {
                alert('Gagal load pengaturan.');
            }
        });
}

function simpanPengaturan() {
    const data = {
        nama_masjid: document.getElementById('namaMasjid').value,
        id_kota: document.getElementById('idKota').value,
        alamat: document.getElementById('alamatMasjid').value,
    };

    ['shubuh', 'dzuhur', 'ashar', 'maghrib', 'isya'].forEach(waktu => {
        ['adzan', 'iqamah', 'sholat'].forEach(jenis => {
            const key = `durasi_${waktu}_${jenis}`;
            data[key] = document.getElementById(key).value;
        });
    });

    fetch('/pengaturan/save', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    })
        .then(res => res.json())
        .then(json => {
            if (json.status) {
                alert('✅ Pengaturan berhasil disimpan!');
            } else {
                alert('❌ Gagal menyimpan pengaturan.');
            }
        });
}

// SYNCRONIZE JADWAL SHOLAT
function syncHariIni() {
    fetch('/jadwal/sync/harian', {
        method: 'POST'
    })
        .then(res => res.json())
        .then(json => alert(json.message));
}

function syncSebulan() {
    fetch('/jadwal/sync/bulanan', {
        method: 'POST'
    })
        .then(res => res.json())
        .then(json => alert(json.message));
}

function syncSetahun() {
    fetch('/jadwal/sync/tahunan', {
        method: 'POST'
    })
        .then(res => res.json())
        .then(json => alert(json.message));
}
// END -- ADMIN PANEL