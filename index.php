<?php include 'config.php'; ?>
<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Dashboard | LibAdmin</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#137fec",
                        "background-light": "#f6f7f8",
                        "background-dark": "#101922",
                    },
                    fontFamily: {
                        "display": ["Inter"]
                    },
                    borderRadius: {"DEFAULT": "0.25rem", "lg": "0.5rem", "xl": "0.75rem", "full": "9999px"},
                },
            },
        }
    </script>
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-background-light dark:bg-background-dark font-display text-slate-800 dark:text-slate-200 min-h-screen">

<nav class="sticky top-0 z-50 bg-white dark:bg-slate-900 border-b border-slate-200 dark:border-slate-800 shadow-sm">
    <div class="max-w-[1440px] mx-auto px-6 h-16 flex items-center justify-between">
        <div class="flex items-center gap-8">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 bg-primary rounded flex items-center justify-center text-white">
                    <span class="material-icons text-xl">library_books</span>
                </div>
                <span class="font-bold text-xl tracking-tight text-slate-900 dark:text-white uppercase">Perpustakaan</span>
            </div>
            <div class="hidden md:flex items-center gap-1">
                <a class="px-4 py-2 text-sm font-bold text-primary border-b-2 border-primary" href="index.php">Dashboard</a>
                <a class="px-4 py-2 text-sm font-medium text-slate-500 hover:text-primary dark:text-slate-400 dark:hover:text-primary transition-colors" href="buku.php">Data Buku</a>
                <a class="px-4 py-2 text-sm font-medium text-slate-500 hover:text-primary dark:text-slate-400 dark:hover:text-primary transition-colors" href="pegawai.php">Data Pegawai</a>
                <a class="px-4 py-2 text-sm font-medium text-slate-500 hover:text-primary dark:text-slate-400 dark:hover:text-primary transition-colors" href="peminjaman.php">Peminjaman</a>
                <a class="px-4 py-2 text-sm font-medium text-slate-500 hover:text-primary dark:text-slate-400 dark:hover:text-primary transition-colors" href="anggota.php">Data Anggota</a>
            </div>
        </div>
        <div class="flex items-center gap-4">
            <a href="login.php" class="p-2 text-red-500 hover:bg-red-50 rounded-full transition-colors" title="Logout">
                <span class="material-icons text-xl">logout</span>
            </a>
        </div>
    </div>
</nav>

<main class="max-w-[1440px] mx-auto px-6 py-8">
    <div class="mb-8">
        <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-primary to-[#0c58a8] p-8 md:p-12 text-white shadow-xl">
            <div class="relative z-10">
                <h1 class="text-3xl md:text-5xl font-black mb-4 tracking-tight">Selamat Datang, Admin</h1>
                <p class="text-white/80 text-lg font-medium max-w-2xl leading-relaxed">
                    Sistem informasi perpustakaan digital terintegrasi. Pantau semua aktivitas buku, pegawai, dan anggota di sini.
                </p>
                <div class="mt-8">
                    <a href="peminjaman.php" class="inline-flex items-center gap-2 bg-white text-primary px-6 py-3 rounded-lg font-bold hover:bg-slate-50 transition-all shadow-lg">
                        <span class="material-icons">add_chart</span>
                        Kelola Peminjaman
                    </a>
                </div>
            </div>
            <span class="material-icons absolute -right-4 -bottom-4 text-[200px] text-white/10 rotate-12">auto_stories</span>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8">
        <div class="p-6 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl shadow-sm">
            <div class="flex items-center gap-4 mb-4">
                <div class="w-10 h-10 bg-amber-100 text-amber-600 rounded-lg flex items-center justify-center">
                    <span class="material-icons">info</span>
                </div>
                <h3 class="font-bold text-lg">Informasi Staff</h3>
            </div>
            <p class="text-slate-600 dark:text-slate-400 text-sm italic">
                "Ingin meminjam buku? Silakan hubungi staff perpustakaan yang sedang bertugas."
            </p>
        </div>

        <div class="p-6 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl shadow-sm">
            <div class="flex items-center gap-4 mb-4">
                <div class="w-10 h-10 bg-emerald-100 text-emerald-600 rounded-lg flex items-center justify-center">
                    <span class="material-icons">tips_and_updates</span>
                </div>
                <h3 class="font-bold text-lg">Instruksi Menu</h3>
            </div>
            <p class="text-slate-600 dark:text-slate-400 text-sm">
                Gunakan navigasi di bagian atas untuk mengelola data buku, melihat daftar pegawai, atau mencatat peminjaman baru.
            </p>
        </div>
    </div>
</main>

<footer class="mt-auto py-8 border-t border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900/50">
    <div class="max-w-[1440px] mx-auto px-6 flex flex-col md:flex-row justify-between items-center gap-4 text-sm text-slate-500">
        <p>© 2025 Perpustakaan Digital | All Rights Reserved</p>
    </div>
</footer>

</body>
</html>