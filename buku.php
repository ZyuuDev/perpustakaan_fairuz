<?php
include 'config/config.php';
include 'config/auth_check.php';
check_access(['admin', 'petugas']);
?>
<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Data Buku | LibAdmin</title>
    <link rel="stylesheet" href="assets/styles/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"/>
    <style>
        body { font-family: 'Inter', sans-serif; }
        .modal { transition: opacity 0.2s ease-in-out; }
    </style>
</head>
<body class="buku-body">
<nav class="buku-navbar">
    <div class="buku-navbar-container">
        <div class="buku-navbar-left">
            <div class="buku-brand">
                <div class="buku-brand-icon">
                    <span class="material-icons">library_books</span>
                </div>
                <span class="buku-brand-text">Perpustakaan</span>
            </div>
            <div class="buku-nav-links">
                <a class="buku-nav-link" href="dashboard.php">Dashboard</a>
                <a class="buku-nav-link active" href="buku.php">Data Buku</a>
                <?php if ($_SESSION['level'] == 'admin'): ?>
                <a class="buku-nav-link" href="pegawai.php">Data Pegawai</a>
                <a class="buku-nav-link" href="anggota.php">Data Anggota</a>
                <?php endif; ?>
                <?php if ($_SESSION['level'] == 'admin' || $_SESSION['level'] == 'petugas'): ?>
                <a class="buku-nav-link" href="peminjaman.php">Peminjaman</a>
                <?php endif; ?>
                <?php if ($_SESSION['level'] == 'admin'): ?>
                <a class="buku-nav-link" href="users.php">Data Users</a>
                <?php endif; ?>
            </div>
        </div>
        <div style="display: flex; align-items: center; gap: 0.5rem;">
            <a href="auth/logout.php" class="buku-logout"><span class="material-icons">logout</span></a>
            <button class="hamburger" onclick="toggleMobileMenu()">
                <span class="material-icons">menu</span>
            </button>
        </div>
    </div>
</nav>
<div class="mobile-menu" id="mobileMenu">
  <div class="mobile-menu-overlay" onclick="toggleMobileMenu()"></div>
  <div class="mobile-menu-content">
    <div class="mobile-menu-header">
      <div class="buku-brand">
        <div class="buku-brand-icon">
          <span class="material-icons">library_books</span>
        </div>
        <span class="buku-brand-text">Menu</span>
      </div>
      <button class="mobile-menu-close" onclick="toggleMobileMenu()">
        <span class="material-icons">close</span>
      </button>
    </div>
    <nav class="mobile-nav">
      <a href="dashboard.php">Dashboard</a>
      <a href="buku.php" class="active">Data Buku</a>
      <?php if ($_SESSION['level'] == 'admin'): ?>
      <a href="pegawai.php">Data Pegawai</a>
      <a href="anggota.php">Data Anggota</a>
      <?php endif; ?>
      <?php if ($_SESSION['level'] == 'admin' || $_SESSION['level'] == 'petugas'): ?>
      <a href="peminjaman.php">Peminjaman</a>
      <?php endif; ?>
      <?php if ($_SESSION['level'] == 'admin'): ?>
      <a href="users.php">Data Users</a>
      <?php endif; ?>
      <div class="mobile-nav-divider"></div>
      <a href="auth/logout.php" style="color: #ef4444;">Logout</a>
    </nav>
  </div>
</div>
<main class="buku-main">
    <div class="buku-header">
        <div>
            <h1>Data Buku</h1>
            <p>Halaman untuk mengelola data buku perpustakaan.</p>
        </div>
        <?php if ($_SESSION['level'] == 'admin'): ?>
        <button onclick="openModal('modalTambah')" class="buku-btn-add">
            <span class="material-icons">add</span>
            TAMBAH BUKU BARU
        </button>
        <?php endif; ?>
    </div>
    <?php
    $search_buku = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
    ?>
    <div style="margin-bottom: 1.5rem;">
        <form method="GET" action="buku.php" style="display: flex; gap: 0.5rem; max-width: 480px;">
            <input type="text" name="search" placeholder="Cari judul buku, pengarang, penerbit..." 
                   value="<?= htmlspecialchars($search_buku); ?>"
                   style="flex:1; padding: 0.625rem 1rem; border: 1px solid #d1d5db; border-radius: 0.5rem; font-size: 0.875rem; font-family: 'Inter', sans-serif;">
            <button type="submit" class="buku-btn-add" style="padding: 0.625rem 1rem; margin: 0; box-shadow: none;">
                <span class="material-icons" style="font-size: 1.125rem;">search</span>
            </button>
            <?php if (!empty($search_buku)): ?>
            <a href="buku.php" style="display:flex; align-items:center; padding: 0.625rem; color: #ef4444; text-decoration: none; border: 1px solid #fecaca; border-radius: 0.5rem;">
                <span class="material-icons" style="font-size: 1.125rem;">close</span>
            </a>
            <?php endif; ?>
        </form>
    </div>
    <div class="buku-table-wrapper">
        <div class="buku-table-container">
            <table class="buku-table">
                <thead>
                    <tr>
                        <th>ISBN</th>
                        <th>Judul Buku</th>
                        <th>Pengarang</th>
                        <th>Penerbit</th>
                        <th class="text-center">Tahun</th>
                        <th>Genre</th>
                        <th class="text-center">Stok</th>
                        <th class="text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (!empty($search_buku)) {
                        $result = mysqli_query($conn, "SELECT * FROM buku WHERE judul LIKE '%$search_buku%' OR pengarang LIKE '%$search_buku%' OR penerbit LIKE '%$search_buku%' OR isbn LIKE '%$search_buku%' OR genre LIKE '%$search_buku%' ORDER BY judul ASC");
                    } else {
                        $result = mysqli_query($conn, "SELECT * FROM buku ORDER BY judul ASC");
                    }
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                    <tr>
                        <td class="font-semibold"><?php echo $row['isbn']; ?></td>
                        <td><?php echo $row['judul']; ?></td>
                        <td><?php echo $row['pengarang']; ?></td>
                        <td><?php echo $row['penerbit']; ?></td>
                        <td class="text-center text-muted"><?php echo $row['tahun']; ?></td>
                        <td>
                            <span style="background: #f1f5f9; color: #475569; padding: 0.25rem 0.5rem; border-radius: 0.375rem; font-size: 0.75rem; font-weight: 600;">
                                <?php echo $row['genre']; ?>
                            </span>
                        </td>
                        <td class="text-center font-bold <?php echo $row['stok'] > 0 ? 'text-success' : 'text-danger'; ?>" style="<?php echo $row['stok'] > 0 ? 'color: #059669;' : 'color: #dc2626;'; ?>"><?php echo $row['stok']; ?></td>
                        <?php if ($_SESSION['level'] == 'admin'): ?>
                        <td class="text-right">
                            <div class="actions">
                                <button                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        
                                    onclick='openEditModal(<?php echo json_encode($row); ?>)' 
                                    class="buku-link-edit">Edit</button>
                                <a href="crud/buku/buku_hapus.php?id=<?php echo $row['isbn']; ?>" onclick="return confirm('Hapus?')" class="buku-link-delete">Hapus</a>
                            </div>
                        </td>
                        <?php else: ?>
                        <td class="text-right">-</td>
                        <?php endif; ?>
                    </tr>
                    <?php 
                        } 
                    } else {
                        echo "<tr><td colspan='8' style='text-align:center; padding: 2rem; color: #64748b;'>Belum ada data buku.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</main>
<div id="modalTambah" class="buku-modal">
    <div class="buku-modal-overlay" onclick="closeModal('modalTambah')"></div>
    <div class="buku-modal-content">
        <h2>Tambah Buku Baru</h2>
        <form action="crud/buku/buku_tambah_aksi.php" method="post">
            <div style="margin-bottom: 1rem;">
                <label class="form-group-label">ISBN</label>
                <input type="text" name="isbn" placeholder="ISBN (978...)" required>
            </div>
            <div style="margin-bottom: 1rem;">
                <label class="form-group-label">Judul Buku</label>
                <input type="text" name="judul" placeholder="Judul Buku" required>
            </div>
            <div class="form-row">
                <div style="margin-bottom: 1rem;">
                    <label class="form-group-label">Pengarang</label>
                    <input type="text" name="pengarang" placeholder="Pengarang">
                </div>
                <div style="margin-bottom: 1rem;">
                    <label class="form-group-label">Penerbit</label>
                    <input type="text" name="penerbit" placeholder="Penerbit">
                </div>
            </div>
            <div class="form-row">
                <div style="margin-bottom: 1rem;">
                    <label class="form-group-label">Tahun</label>
                    <input type="number" name="tahun" placeholder="Tahun" max="<?= date('Y'); ?>" required>
                </div>
                <div style="margin-bottom: 1rem;">
                    <label class="form-group-label">Genre</label>
                    <select name="genre" required>
                        <option value="Fiksi">Fiksi</option>
                        <option value="Non-Fiksi">Non-Fiksi</option>
                        <option value="Sains & Teknologi">Sains & Teknologi</option>
                        <option value="Sejarah">Sejarah</option>
                        <option value="Sastra">Sastra</option>
                        <option value="Biografi">Biografi</option>
                        <option value="Agama">Agama</option>
                        <option value="Pelajaran">Pelajaran</option>
                        <option value="Komik">Komik</option>
                        <option value="Novel">Novel</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>
                </div>
            </div>
            <div style="margin-bottom: 1rem;">
                <label class="form-group-label">Stok Buku</label>
                <input type="number" name="stok" placeholder="Jumlah Stok" value="0" required min="0">
            </div>
            <button type="submit">Simpan Buku</button>
        </form>
    </div>
</div>
<div id="modalEdit" class="buku-modal">
    <div class="buku-modal-overlay" onclick="closeModal('modalEdit')"></div>
    <div class="buku-modal-content">
        <h2 class="text-primary">Edit Data Buku</h2>
        <form action="crud/buku/buku_edit_aksi.php" method="post">
            <input type="hidden" name="id" id="edit_id">
            <div class="form-group">
                <label>ISBN (ID Tetap)</label>
                <input type="text" id="edit_isbn_display" disabled>
            </div>
            <div class="form-group">
                <label>Judul Buku</label>
                <input type="text" name="judul" id="edit_judul" required>
            </div>
            <div class="form-row">
                <div>
                    <label>Pengarang</label>
                    <input type="text" name="pengarang" id="edit_pengarang">
                </div>
                <div>
                    <label>Penerbit</label>
                    <input type="text" name="penerbit" id="edit_penerbit">
                </div>
            </div>
            <div class="form-row">
                <div>
                    <label>Tahun</label>
                    <input type="number" name="tahun" id="edit_tahun" max="<?= date('Y'); ?>" required>
                </div>
                <div>
                    <label>Genre</label>
                    <select name="genre" id="edit_genre" required>
                        <option value="Fiksi">Fiksi</option>
                        <option value="Non-Fiksi">Non-Fiksi</option>
                        <option value="Sains & Teknologi">Sains & Teknologi</option>
                        <option value="Sejarah">Sejarah</option>
                        <option value="Sastra">Sastra</option>
                        <option value="Biografi">Biografi</option>
                        <option value="Agama">Agama</option>
                        <option value="Pelajaran">Pelajaran</option>
                        <option value="Komik">Komik</option>
                        <option value="Novel">Novel</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>
                </div>
            </div>
            <div class="form-group" style="margin-top: 1rem;">
                <label>Stok Buku</label>
                <input type="number" name="stok" id="edit_stok" required min="0">
            </div>
            <button type="submit" style="margin-top: 1rem;">Update Data Buku</button>
            <button type="button" onclick="closeModal('modalEdit')">Batal</button>
        </form>
    </div>
</div>
<div id="modalTambahStok" class="buku-modal">
    <div class="buku-modal-overlay" onclick="closeModal('modalTambahStok')"></div>
    <div class="buku-modal-content" style="max-width: 400px;">
        <h2 class="text-success" style="color: #059669;">Tambah Stok Buku</h2>
        <p id="tambah_stok_judul" style="font-weight: 600; color: #475569; margin-bottom: 1.5rem;"></p>
        <form action="crud/buku/buku_tambah_stok_aksi.php" method="post">
            <input type="hidden" name="isbn" id="tambah_stok_isbn">
            <div class="form-group" style="margin-bottom: 1.5rem;">
                <label>Jumlah Stok yang Ditambahkan</label>
                <input type="number" name="jumlah_tambah" required min="1" placeholder="Masukkan angka (misal: 10)">
            </div>
            <button type="submit" style="background: #10b981; border-color: #059669;">Simpan Penambahan Stok</button>
            <button type="button" onclick="closeModal('modalTambahStok')" style="background: transparent; color: #64748b; margin-top: 0.5rem; width: 100%; border: none;">Batal</button>
        </form>
    </div>
</div>
<script>
    // Toggle Mobile Menu
    function toggleMobileMenu() {
        const menu = document.getElementById('mobileMenu');
        menu.classList.toggle('show');
    }
    // Buka Modal
    function openModal(id) {
        document.getElementById(id).classList.add('show');
    }
    // Tutup Modal
    function closeModal(id) {
        document.getElementById(id).classList.remove('show');
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
        document.getElementById('edit_stok').value = data.stok;
        openModal('modalEdit');
    }
    function openTambahStokModal(data) {
        document.getElementById('tambah_stok_isbn').value = data.isbn;
        document.getElementById('tambah_stok_judul').innerText = data.judul + " (Stok saat ini: " + data.stok + ")";
        openModal('modalTambahStok');
    }
</script>
<footer class="buku-footer">
    <div class="buku-footer-content">
        <p>© 2025 Perpustakaan Digital | All Rights Reserved</p>
    </div>
</footer>
</body>
</html>