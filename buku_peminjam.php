<?php
include 'config/config.php';
include 'config/auth_check.php';
check_access(['peminjam']);

$nama = $_SESSION['nama'];
$search_buku = isset($_GET['search_buku']) ? mysqli_real_escape_string($conn, $_GET['search_buku']) : '';

if (!empty($search_buku)) {
    $result_buku = mysqli_query($conn, "SELECT * FROM buku WHERE judul LIKE '%$search_buku%' OR pengarang LIKE '%$search_buku%' OR genre LIKE '%$search_buku%' ORDER BY judul ASC");
} else {
    $result_buku = mysqli_query($conn, "SELECT * FROM buku ORDER BY judul ASC");
}
?>
<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Cari Buku | Perpustakaan</title>
    <link rel="stylesheet" href="assets/styles/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"/>
    <style>
        body { font-family: 'Inter', sans-serif; background: #f8fafc; }
        .search-container { background: white; padding: 2rem; border-radius: 1rem; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); margin-bottom: 2rem; border: 1px solid #e5e7eb; }
        .search-bar { display: flex; gap: 0.75rem; max-width: 600px; }
        .search-bar input { flex: 1; padding: 0.875rem 1.25rem; border: 2px solid #e2e8f0; border-radius: 0.75rem; font-size: 1rem; font-family: 'Inter', sans-serif; outline: none; transition: border-color 0.2s; }
        .search-bar input:focus { border-color: #137fec; }
        .search-bar button { display: flex; align-items: center; justify-content: center; padding: 0 1.5rem; background: #137fec; color: white; border: none; border-radius: 0.75rem; cursor: pointer; font-weight: 600; transition: background 0.2s; }
        .search-bar button:hover { background: #0c58a8; }
        .clear-link { display: flex; align-items: center; justify-content: center; padding: 0 1rem; color: #ef4444; text-decoration: none; border: 2px solid #fecaca; border-radius: 0.75rem; background: #fef2f2; }
        .book-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 1.5rem; }
        .book-card { background: white; border: 1px solid #e2e8f0; border-radius: 1rem; padding: 1.5rem; transition: all 0.2s; position: relative; overflow: hidden; animation: slideUp 0.4s ease-out both; }
        .book-card:hover { border-color: #137fec; box-shadow: 0 10px 15px -3px rgba(19, 127, 236, 0.1); transform: translateY(-4px); }
        .book-card h4 { font-size: 1.125rem; font-weight: 700; color: #0f172a; margin: 0 0 0.75rem 0; line-height: 1.4; }
        .book-meta { font-size: 0.875rem; color: #64748b; line-height: 1.6; }
        .book-meta span { display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.25rem; }
        .book-meta .material-icons { font-size: 1rem; color: #94a3b8; }
        .book-stok { display: inline-flex; align-items: center; gap: 0.375rem; padding: 0.375rem 0.875rem; border-radius: 9999px; font-size: 0.8125rem; font-weight: 700; margin-top: 1rem; }
        .book-stok.available { background: #dcfce7; color: #16a34a; }
        .book-stok.empty { background: #fee2e2; color: #dc2626; }
    </style>
</head>
<body class="peminjaman-body">

<nav class="peminjaman-navbar">
    <div class="peminjaman-navbar-container">
        <div class="peminjaman-navbar-left">
            <div class="peminjaman-brand">
                <div class="peminjaman-brand-icon">
                    <span class="material-icons">local_library</span>
                </div>
                <span class="peminjaman-brand-text">Perpus Anggota</span>
            </div>
            <div class="peminjaman-nav-links">
                <a class="peminjaman-nav-link" href="dashboard_peminjam.php">Dashboard</a>
                <a class="peminjaman-nav-link active" href="buku_peminjam.php">Cari Buku</a>
                <a class="peminjaman-nav-link" href="riwayat_peminjaman.php">Riwayat Peminjaman</a>
            </div>
        </div>
        <div class="peminjaman-navbar-right">
            <span style="font-size: 0.875rem; color: #64748b; font-weight: 500; margin-right: 0.5rem;">
                <?= htmlspecialchars($nama); ?>
            </span>
            <a href="auth/logout.php" class="peminjaman-logout" title="Logout">
                <span class="material-icons">logout</span>
            </a>
            <button class="hamburger" onclick="toggleMobileMenu()">
                <span class="material-icons">menu</span>
            </button>
        </div>
    </div>
</nav>

<!-- Mobile Menu -->
<div class="mobile-menu" id="mobileMenu">
  <div class="mobile-menu-overlay" onclick="toggleMobileMenu()"></div>
  <div class="mobile-menu-content">
    <div class="mobile-menu-header">
      <div class="peminjaman-brand">
        <div class="peminjaman-brand-icon">
          <span class="material-icons">local_library</span>
        </div>
        <span class="peminjaman-brand-text">Menu</span>
      </div>
      <button class="mobile-menu-close" onclick="toggleMobileMenu()">
        <span class="material-icons">close</span>
      </button>
    </div>
    <nav class="mobile-nav">
      <a href="dashboard_peminjam.php">Dashboard</a>
      <a href="buku_peminjam.php" class="active">Cari Buku</a>
      <a href="riwayat_peminjaman.php">Riwayat Peminjaman</a>
      <div class="mobile-nav-divider"></div>
      <a href="auth/logout.php" style="color: #ef4444;">Logout</a>
    </nav>
  </div>
</div>

<main class="peminjaman-main">
    <div class="peminjaman-header" style="margin-bottom: 2rem;">
        <div>
            <h1>Daftar Buku</h1>
            <p>Silahkan cari buku yang tersedia.</p>
        </div>
    </div>

    <!-- Search Section -->
    <div class="search-container">
        <form method="GET" action="buku_peminjam.php" class="search-bar">
            <input type="text" name="search_buku" placeholder="Ketik judul buku, pengarang, penerbit, atau genre..." 
                   value="<?= htmlspecialchars($search_buku); ?>" autofocus>
            <button type="submit">
                <span class="material-icons" style="margin-right: 0.5rem;">search</span> Cari
            </button>
            <?php if (!empty($search_buku)): ?>
            <a href="buku_peminjam.php" class="clear-link" title="Hapus pencarian">
                <span class="material-icons">close</span>
            </a>
            <?php endif; ?>
        </form>
    </div>

    <?php if (!empty($search_buku)): ?>
    <p style="font-size: 1rem; color: #64748b; margin-bottom: 1.5rem; font-weight: 500;">
        Hasil pencarian untuk: <strong style="color: #0f172a;">"<?= htmlspecialchars($search_buku); ?>"</strong> 
        <span style="background: #e2e8f0; padding: 0.25rem 0.5rem; border-radius: 999px; font-size: 0.75rem; margin-left: 0.5rem;"><?= mysqli_num_rows($result_buku); ?> ditemukan</span>
    </p>
    <?php endif; ?>

    <!-- Grid Buku -->
    <div class="book-grid">
        <?php 
        if (mysqli_num_rows($result_buku) > 0) {
            $delay = 0;
            while ($buku = mysqli_fetch_assoc($result_buku)) : 
        ?>
        <div class="book-card" style="animation-delay: <?= ($delay % 10) * 0.05; ?>s;">
            <h4><?= htmlspecialchars($buku['judul']); ?></h4>
            <div class="book-meta">
                <span><span class="material-icons">person</span> <?= htmlspecialchars($buku['pengarang']); ?></span>
                <span><span class="material-icons">business</span> <?= htmlspecialchars($buku['penerbit']); ?> (<?= htmlspecialchars($buku['tahun']); ?>)</span>
                <span><span class="material-icons">label</span> <?= htmlspecialchars($buku['genre']); ?></span>
                <span><span class="material-icons">qr_code</span> ISBN: <?= htmlspecialchars($buku['isbn']); ?></span>
            </div>
            <?php if ($buku['stok'] > 0): ?>
            <span class="book-stok available"><span class="material-icons" style="font-size: 1rem;">check_circle</span> Stok: <?= $buku['stok']; ?></span>
            <?php else: ?>
            <span class="book-stok empty"><span class="material-icons" style="font-size: 1rem;">cancel</span> Sedang Dipinjam</span>
            <?php endif; ?>
        </div>
        <?php 
            $delay++;
            endwhile;
        } else {
            echo '<div style="grid-column: 1/-1; text-align: center; padding: 4rem 2rem; background: white; border-radius: 1rem; border: 1px dashed #cbd5e1;">
                    <span class="material-icons" style="font-size: 3rem; color: #cbd5e1; margin-bottom: 1rem;">menu_book</span>
                    <h3 style="color: #334155; margin: 0 0 0.5rem 0;">Buku tidak ditemukan</h3>
                    <p style="color: #64748b; margin: 0;">Coba gunakan kata kunci lain untuk mencari buku.</p>
                  </div>';
        }
        ?>
    </div>
</main>

<footer class="peminjaman-footer" style="margin-top: 4rem;">
    <div class="peminjaman-footer-content">
        <p>&copy; 2025 Perpustakaan Digital | All Rights Reserved</p>
    </div>
</footer>

<script>
function toggleMobileMenu() {
    document.getElementById('mobileMenu').classList.toggle('show');
}
</script>

</body>
</html>
