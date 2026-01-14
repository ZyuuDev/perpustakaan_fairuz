<?php include 'config.php'; ?>
<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Data Peminjaman | LibAdmin</title>
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
                <a class="px-4 py-2 text-sm font-medium text-slate-500 hover:text-primary dark:text-slate-400 dark:hover:text-primary transition-colors" href="index.php">Dashboard</a>
                <a class="px-4 py-2 text-sm font-medium text-slate-500 hover:text-primary dark:text-slate-400 dark:hover:text-primary transition-colors" href="buku.php">Data Buku</a>
                <a class="px-4 py-2 text-sm font-medium text-slate-500 hover:text-primary dark:text-slate-400 dark:hover:text-primary transition-colors" href="pegawai.php">Data Pegawai</a>
                <a class="px-4 py-2 text-sm font-bold text-primary border-b-2 border-primary" href="peminjaman.php">Peminjaman</a>
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
    <div class="mb-8 flex flex-col md:flex-row md:items-end justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900 dark:text-white">📑 Data Peminjaman Buku</h1>
            <p class="text-slate-500 dark:text-slate-400 mt-1">Pantau sirkulasi buku yang sedang dipinjam oleh anggota.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="peminjaman_tambah.php" class="flex items-center gap-2 bg-primary hover:bg-primary/90 text-white font-bold py-2.5 px-5 rounded-lg shadow-lg transition-all active:scale-95">
                <span class="material-icons text-sm">add_circle</span>
                PINJAM BUKU BARU
            </a>
        </div>
    </div>

    <div class="bg-white dark:bg-slate-900 rounded-xl shadow-sm overflow-hidden border border-slate-200 dark:border-slate-800">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-[#0f172a] dark:bg-slate-950 text-white">
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider">ID Pinjam</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider">ID Anggota</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider">ISBN Buku</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider">Tgl Pinjam</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider">Tgl Kembali</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    <?php
                    $result = mysqli_query($conn, "SELECT * FROM peminjaman");
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                    <tr class="hover:bg-primary/5 dark:hover:bg-primary/10 transition-colors bg-white dark:bg-slate-900">
                        <td class="px-6 py-4 text-sm font-bold text-primary">#<?php echo $row['ID_Peminjaman']; ?></td>
                        <td class="px-6 py-4 text-sm font-medium text-slate-900 dark:text-white"><?php echo $row['ID_Anggota']; ?></td>
                        <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400 font-mono"><?php echo $row['isbn']; ?></td>
                        <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400">
                            <div class="flex items-center gap-2">
                                <span class="material-icons text-xs text-emerald-500">calendar_today</span>
                                <?php echo date('d M Y', strtotime($row['tgl_pinjam'])); ?>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400">
                            <div class="flex items-center gap-2 font-semibold">
                                <span class="material-icons text-xs text-rose-500">event_busy</span>
                                <?php echo date('d M Y', strtotime($row['tgl_kembali'])); ?>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400 px-3 py-1 rounded-full text-[10px] font-black uppercase">
                                Dipinjam
                            </span>
                        </td>
                    </tr>
                    <?php 
                        } 
                    } else {
                        echo "<tr><td colspan='6' class='px-6 py-4 text-center text-slate-500'>Belum ada transaksi peminjaman.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<footer class="mt-12 py-8 border-t border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900/50">
    <div class="max-w-[1440px] mx-auto px-6 text-center md:text-left">
        <p class="text-sm text-slate-500">© 2025 Perpustakaan Digital | All Rights Reserved</p>
    </div>
</footer>

</body>
</html>