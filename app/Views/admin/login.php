<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Masuk Admin — SMARTMUADZZIN</title>
    <script src="<?= site_url('assets/js/tailwindcss.js') ?>"></script>
</head>
<body class="min-h-screen bg-slate-100 flex items-center justify-center p-6">
    <main class="w-full max-w-md rounded-xl bg-white p-8 shadow-lg">
        <h1 class="text-2xl font-bold text-slate-800">SMARTMUADZZIN</h1>
        <p class="mt-1 text-slate-600">Masuk ke panel administrasi</p>

        <?php if ($message = session()->getFlashdata('error')): ?>
            <p class="mt-5 rounded bg-red-50 p-3 text-sm text-red-700"><?= esc($message) ?></p>
        <?php endif ?>

        <form action="<?= site_url('admin/login') ?>" method="post" class="mt-6 space-y-4">
            <?= csrf_field() ?>
            <div>
                <label for="username" class="block text-sm font-medium text-slate-700">Username</label>
                <input id="username" name="username" autocomplete="username" required class="mt-1 w-full rounded border border-slate-300 p-2">
            </div>
            <div>
                <label for="password" class="block text-sm font-medium text-slate-700">Password</label>
                <input id="password" name="password" type="password" autocomplete="current-password" required class="mt-1 w-full rounded border border-slate-300 p-2">
            </div>
            <button class="w-full rounded bg-blue-600 px-4 py-2 font-medium text-white hover:bg-blue-700">Masuk</button>
        </form>
    </main>
</body>
</html>
