<?php
session_start();
include 'config/config.php';
include 'config/auth_check.php';
check_access(['admin', 'petugas']);
$buku = mysqli_query($conn, "SELECT isbn, judul, stok FROM buku WHERE stok > 0 ORDER BY judul ASC");
$anggota = mysqli_query($conn, "SELECT ID_Anggota, Nama FROM anggota ORDER BY Nama ASC");
$query_id = mysqli_query($conn, "SELECT ID_Peminjaman FROM peminjaman WHERE ID_Peminjaman LIKE 'A%' ORDER BY ID_Peminjaman DESC LIMIT 1");
$last_id = mysqli_fetch_array($query_id);
if ($last_id) {
    $last_num = (int) substr($last_id['ID_Peminjaman'], 1);
    $next_num = $last_num + 1;
    $next_id = "A" . str_pad($next_num, 3, "0", STR_PAD_LEFT);
} else {
    $next_id = "A001";
}
?>
<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Form Peminjaman | LibAdmin</title>
    <link rel="stylesheet" href="assets/styles/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"/>
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="peminjaman-body">
<nav class="peminjaman-navbar">
    <div class="peminjaman-navbar-container">
        <div class="peminjaman-navbar-left">
            <div class="peminjaman-brand">
                <div class="peminjaman-brand-icon">
                    <span class="material-icons">library_books</span>
                </div>
                <span class="peminjaman-brand-text">Perpustakaan</span>
            </div>
            <div class="peminjaman-nav-links">
                <a class="peminjaman-nav-link" href="dashboard.php">Dashboard</a>
                <a class="peminjaman-nav-link" href="buku.php">Data Buku</a>
                <?php if ($_SESSION['level'] == 'admin'): ?>
                <a class="peminjaman-nav-link" href="pegawai.php">Data Pegawai</a>
                <a class="peminjaman-nav-link" href="anggota.php">Data Anggota</a>
                <?php endif; ?>
                <a class="peminjaman-nav-link active" href="peminjaman.php">Peminjaman</a>
            </div>
        </div>
        <div class="peminjaman-navbar-right">
            <a href="auth/logout.php" class="peminjaman-logout" title="Logout">
                <span class="material-icons">logout</span>
            </a>
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
      <div class="peminjaman-brand">
        <div class="peminjaman-brand-icon">
          <span class="material-icons">library_books</span>
        </div>
        <span class="peminjaman-brand-text">Menu</span>
      </div>
      <button class="mobile-menu-close" onclick="toggleMobileMenu()">
        <span class="material-icons">close</span>
      </button>
    </div>
    <nav class="mobile-nav">
      <a href="dashboard.php">Dashboard</a>
      <a href="buku.php">Data Buku</a>
      <?php if ($_SESSION['level'] == 'admin'): ?>
      <a href="pegawai.php">Data Pegawai</a>
      <a href="anggota.php">Data Anggota</a>
      <?php endif; ?>
      <a href="peminjaman.php" class="active">Peminjaman</a>
      <div class="mobile-nav-divider"></div>
      <a href="auth/logout.php" style="color: #ef4444;">Logout</a>
    </nav>
  </div>
</div>
<main class="peminjaman-main">
    <div class="peminjaman-header">
        <div>
            <h1>Form Peminjaman Baru</h1>
            <p>Masukkan data transaksi peminjaman.</p>
        </div>
        <div>
            <a href="peminjaman.php" class="peminjaman-btn-add">
                <span class="material-icons">arrow_back</span>
                Kembali ke Data Peminjaman
            </a>
        </div>
    </div>
    <div style="max-width: 560px;">
        <div class="peminjaman-table-wrapper" style="padding: 2rem;">
            <form action="crud/peminjaman/simpan_peminjaman.php" method="POST">
                <div style="margin-bottom: 1.25rem;">
                    <label class="form-group-label">ID Peminjaman (Otomatis)</label>
                    <input type="text" name="id_peminjaman" value="<?= $next_id; ?>" readonly 
                           class="input-readonly"
                           style="width:100%; padding: 0.625rem; border: 1px solid #d1d5db; border-radius: 0.5rem; background: #f1f5f9; font-family: 'Inter', sans-serif;">
                </div>
                <div style="margin-bottom: 1.25rem;">
                    <label class="form-group-label">Judul Buku</label>
                    <select name="isbn" required style="width:100%; padding: 0.625rem; border: 1px solid #d1d5db; border-radius: 0.5rem; font-family: 'Inter', sans-serif;">
                        <option value="">-- Pilih Buku --</option>
                        <?php while ($cek_buku = mysqli_fetch_assoc($buku)) : ?>
                            <option value="<?= $cek_buku['isbn']; ?>">
                                <?= $cek_buku['judul']; ?> (Stok: <?= $cek_buku['stok']; ?>)
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div style="margin-bottom: 1.25rem;">
                    <label class="form-group-label">Nama Peminjam</label>
                    <select name="id_anggota" required style="width:100%; padding: 0.625rem; border: 1px solid #d1d5db; border-radius: 0.5rem; font-family: 'Inter', sans-serif;">
                        <option value="">-- Pilih Peminjam --</option>
                        <?php while ($cek_anggota = mysqli_fetch_assoc($anggota)) : ?>
                            <option value="<?= $cek_anggota['ID_Anggota']; ?>">
                                <?= $cek_anggota['Nama']; ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div style="margin-bottom: 1.25rem;">
                    <label class="form-group-label">Tanggal Mulai</label>
                    <input type="date" name="tgl_pinjam" value="<?= date('Y-m-d'); ?>" required
                           style="width:100%; padding: 0.625rem; border: 1px solid #d1d5db; border-radius: 0.5rem; font-family: 'Inter', sans-serif;">
                </div>
                <button type="submit" 
                        style="width:100%; background: var(--primary, #137fec); color: white; font-weight: 700; padding: 0.75rem; border-radius: 0.5rem; border: none; cursor: pointer; font-size: 0.9375rem; font-family: 'Inter', sans-serif;">
                    Simpan Peminjaman
                </button>
            </form>
        </div>
    </div>
</main>
<footer class="peminjaman-footer">
    <div class="peminjaman-footer-content">
        <p>&copy; 2025 Perpustakaan Digital | All Rights Reserved</p>
    </div>
</footer>
<script>
function toggleMobileMenu() {
  const menu = document.getElementById('mobileMenu');
  menu.classList.toggle('show');
}
</script>
</body>
</html>
