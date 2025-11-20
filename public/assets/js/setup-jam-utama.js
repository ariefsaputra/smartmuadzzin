// inisialisasi Jam Digital dengan format HH:MM
function startTime() {
    const today = new Date();
    let h = today.getHours();
    let m = today.getMinutes();
    let s = today.getSeconds();
    m = checkTime(m);
    s = checkTime(s);
    document.getElementById('jam-digital').innerHTML =  h + ":" + m;
    setTimeout(startTime, 1000);
}
function checkTime(i) {
    if (i < 10) {i = "0" + i};  // tambahkan angka 0 di depan angka < 10
    return i;
}