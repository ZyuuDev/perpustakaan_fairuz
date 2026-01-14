<?php include 'config.php'; ?>
<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Data Buku | LibAdmin</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"/>
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
                },
            },
        }
    </script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        /* Animasi fade untuk modal */
        .modal { transition: opacity 0.2s ease-in-out; }
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
                <a class="px-4 py-2 text-sm font-medium text-slate-500 hover:text-primary transition-colors" href="index.php">Dashboard</a>
                <a class="px-4 py-2 text-sm font-bold text-primary border-b-2 border-primary" href="buku.php">Data Buku</a>
                <a class="px-4 py-2 text-sm font-medium text-slate-500 hover:text-primary transition-colors" href="pegawai.php">Data Pegawai</a>
                <a class="px-4 py-2 text-sm font-medium text-slate-500 hover:text-primary transition-colors" href="peminjaman.php">Peminjaman</a>
                <a class="px-4 py-2 text-sm font-medium text-slate-500 hover:text-primary transition-colors" href="anggota.php">Data Anggota</a>
            </div>
        </div>
        <a href="login.php" class="p-2 text-red-500 hover:bg-red-50 rounded-full"><span class="material-icons">logout</span></a>
    </div>
</nav>

<main class="max-w-[1440px] mx-auto px-6 py-8">
    <div class="mb-8 flex flex-col md:flex-row md:items-end justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900 dark:text-white">📘 Manajemen Data Buku</h1>
            <p class="text-slate-500 dark:text-slate-400 mt-1">Kelola koleksi buku perpustakaan secara efisien.</p>
        </div>
        <button onclick="openModal('modalTambah')" class="flex items-center gap-2 bg-primary hover:bg-primary/90 text-white font-bold py-2.5 px-5 rounded-lg shadow-lg transition-all active:scale-95">
            <span class="material-icons text-sm">add</span>
            TAMBAH BUKU BARU
        </button>
    </div>

    <div class="bg-white dark:bg-slate-900 rounded-xl shadow-sm overflow-hidden border border-slate-200 dark:border-slate-800">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-[#0f172a] text-white">
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-left">ISBN</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-left">Judul Buku</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-left">Pengarang</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-left">Penerbit</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    <?php
                    $result = mysqli_query($conn, "SELECT * FROM buku");
                    while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                    <tr class="hover:bg-primary/5 transition-colors">
                        <td class="px-6 py-4 text-sm font-semibold"><?php echo $row['isbn']; ?></td>
                        <td class="px-6 py-4 text-sm"><?php echo $row['judul']; ?></td>
                        <td class="px-6 py-4 text-sm"><?php echo $row['pengarang']; ?></td>
                        <td class="px-6 py-4 text-sm"><?php echo $row['penerbit']; ?></td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex justify-end gap-3">
                                <button 
                                    onclick='openEditModal(<?php echo json_encode($row); ?>)' 
                                    class="text-primary hover:underline font-bold text-sm">Edit</button>
                                <a href="buku_hapus.php?id=<?php echo $row['isbn']; ?>" onclick="return confirm('Hapus?')" class="text-rose-600 hover:underline font-bold text-sm">Hapus</a>
                            </div>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<div id="modalTambah" class="hidden fixed inset-0 z-[100] flex items-center justify-center p-4">
    <div class="fixed inset-0 bg-black/50 backdrop-blur-sm" onclick="closeModal('modalTambah')"></div>
    <div class="relative bg-white dark:bg-slate-900 w-full max-w-md rounded-2xl shadow-2xl p-8">
        <h2 class="text-xl font-bold mb-6">Tambah Buku Baru</h2>
        <form action="buku_tambah_aksi.php" method="post" class="space-y-4">
            <input type="text" name="isbn" placeholder="ISBN (978...)" class="w-full border rounded-lg p-2.5 bg-transparent" required>
            <input type="text" name="judul" placeholder="Judul Buku" class="w-full border rounded-lg p-2.5 bg-transparent" required>
            <div class="grid grid-cols-2 gap-4">
                <input type="text" name="pengarang" placeholder="Pengarang" class="w-full border rounded-lg p-2.5 bg-transparent">
                <input type="text" name="penerbit" placeholder="Penerbit" class="w-full border rounded-lg p-2.5 bg-transparent">
            </div>
            <div class="grid grid-cols-2 gap-4">
                <input type="text" name="tahun" placeholder="Tahun" class="w-full border rounded-lg p-2.5 bg-transparent">
                <input type="text" name="genre" placeholder="Genre" class="w-full border rounded-lg p-2.5 bg-transparent">
            </div>
            <button type="submit" class="w-full bg-primary text-white font-bold py-3 rounded-lg shadow-lg">Simpan Buku</button>
        </form>
    </div>
</div>

<div id="modalEdit" class="hidden fixed inset-0 z-[100] flex items-center justify-center p-4">
    <div class="fixed inset-0 bg-black/50 backdrop-blur-sm" onclick="closeModal('modalEdit')"></div>
    <div class="relative bg-white dark:bg-slate-900 w-full max-w-md rounded-2xl shadow-2xl p-8">
        <h2 class="text-xl font-bold mb-6 text-primary">Edit Data Buku</h2>
        <form action="buku_edit_aksi.php" method="post" class="space-y-4">
            <input type="hidden" name="id" id="edit_id">
            
            <div class="space-y-1">
                <label class="text-xs font-bold text-slate-400 uppercase">ISBN (ID Tetap)</label>
                <input type="text" id="edit_isbn_display" class="w-full border rounded-lg p-2.5 bg-slate-100 dark:bg-slate-800" disabled>
            </div>
            
            <div class="space-y-1">
                <label class="text-xs font-bold text-slate-400 uppercase">Judul Buku</label>
                <input type="text" name="judul" id="edit_judul" class="w-full border rounded-lg p-2.5 bg-transparent" required>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="text-xs font-bold text-slate-400 uppercase">Pengarang</label>
                    <input type="text" name="pengarang" id="edit_pengarang" class="w-full border rounded-lg p-2.5 bg-transparent">
                </div>
                <div>
                    <label class="text-xs font-bold text-slate-400 uppercase">Penerbit</label>
                    <input type="text" name="penerbit" id="edit_penerbit" class="w-full border rounded-lg p-2.5 bg-transparent">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="text-xs font-bold text-slate-400 uppercase">Tahun</label>
                    <input type="text" name="tahun" id="edit_tahun" class="w-full border rounded-lg p-2.5 bg-transparent">
                </div>
                <div>
                    <label class="text-xs font-bold text-slate-400 uppercase">Genre</label>
                    <input type="text" name="genre" id="edit_genre" class="w-full border rounded-lg p-2.5 bg-transparent">
                </div>
            </div>
            <button type="submit" class="w-full bg-primary text-white font-bold py-3 rounded-lg shadow-lg">Update Data Buku</button>
            <button type="button" onclick="closeModal('modalEdit')" class="w-full text-slate-400 text-sm mt-2">Batal</button>
        </form>
    </div>
</div>

<script>
    // Buka Modal
    function openModal(id) {
        document.getElementById(id).classList.remove('hidden');
    }

    // Tutup Modal
    function closeModal(id) {
        document.getElementById(id).classList.add('hidden');
    }

    // Fungsi Khusus Edit Modal untuk Mengisi Data Otomatis
    function openEditModal(data) {
        document.getElementById('edit_id').value = data.isbn;
        document.getElementById('edit_isbn_display').value = data.isbn;
        document.getElementById('edit_judul').value = data.judul;
        document.getElementById('edit_pengarang').value = data.pengarang;
        document.getElementById('edit_penerbit').value = data.penerbit;
        document.getElementById('edit_tahun').value = data.tahun;
        document.getElementById('edit_genre').value = data.genre;
        
        openModal('modalEdit');
    }
</script>

<footer class="mt-12 py-8 border-t border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900/50">
    <div class="max-w-[1440px] mx-auto px-6 text-sm text-slate-500 text-center">
        <p>© 2025 Perpustakaan Digital | All Rights Reserved</p>
    </div>
</footer>

</body>
</html>