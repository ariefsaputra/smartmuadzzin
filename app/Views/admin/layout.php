<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title><?= $title ?? 'Admin — SMARTMUADZZIN' ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/alpinejs@3" defer></script>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>

    <style>
        body {
            background: #f4f5f7;
            font-family: 'Inter', sans-serif;
        }
        .sidebar {
            background: #ffffff;
            border-right: 1px solid #e5e7eb;
        }
        .sidebar .active {
            background: #e9f0ff;
            color: #2563eb;
            font-weight: 600;
        }
    </style>
</head>

<body class="h-screen flex overflow-hidden">

    <!-- SIDEBAR -->
    <aside class="sidebar w-64 p-6 flex flex-col">
        <div class="mb-10">
            <h1 class="text-2xl font-bold text-gray-800">SMARTMUADZZIN</h1>
            <p class="text-sm text-gray-500 mt-1">Admin Dashboard</p>
        </div>

        <nav class="flex-1">
            <a href="/admin" 
               class="flex items-center gap-3 p-3 rounded-lg mb-2 text-gray-700 hover:bg-gray-100 transition <?= ($active ?? '')=='dashboard' ? 'active' : '' ?>">
                <i class="ph ph-house text-xl"></i> Dashboard
            </a>

            <a href="/admin/jadwal" 
               class="flex items-center gap-3 p-3 rounded-lg mb-2 text-gray-700 hover:bg-gray-100 <?= ($active ?? '')=='jadwal' ? 'active' : '' ?>">
                <i class="ph ph-clock text-xl"></i> Jadwal Sholat
            </a>

            <a href="/admin/media" 
               class="flex items-center gap-3 p-3 rounded-lg mb-2 text-gray-700 hover:bg-gray-100 <?= ($active ?? '')=='media' ? 'active' : '' ?>">
                <i class="ph ph-image text-xl"></i> Media Slider
            </a>

            <a href="/admin/pengumuman" 
               class="flex items-center gap-3 p-3 rounded-lg mb-2 text-gray-700 hover:bg-gray-100 <?= ($active ?? '')=='pengumuman' ? 'active' : '' ?>">
                <i class="ph ph-megaphone-simple text-xl"></i> Pengumuman
            </a>

            <a href="/admin/pengaturan" 
               class="flex items-center gap-3 p-3 rounded-lg mb-2 text-gray-700 hover:bg-gray-100 <?= ($active ?? '')=='pengaturan' ? 'active' : '' ?>">
                <i class="ph ph-gear text-xl"></i> Pengaturan
            </a>
        </nav>

        <div class="mt-auto">
            <a href="/logout" class="flex items-center gap-3 p-3 rounded-lg text-red-600 hover:bg-red-50 transition">
                <i class="ph ph-sign-out text-xl"></i> Logout
            </a>
        </div>
    </aside>

    <!-- CONTENT AREA -->
    <main class="flex-1 overflow-y-auto">

        <!-- TOP BAR -->
        <header class="bg-white px-8 py-4 shadow-sm flex items-center justify-between border-b">
            <div>
                <h2 class="text-2xl font-semibold text-gray-800">
                    <?= $header ?? 'Halaman Admin' ?>
                </h2>
            </div>

            <div class="flex items-center gap-3">
                <div class="text-right">
                    <div class="font-semibold text-gray-700">Administrator</div>
                    <div class="text-xs text-gray-500">SMARTMUADZZIN</div>
                </div>
                <div class="w-10 h-10 bg-gray-300 rounded-full"></div>
            </div>
        </header>

        <!-- PAGE CONTENT -->
        <section class="p-8">
            <?= $this->renderSection('content') ?>
        </section>
    </main>

</body>
</html>
