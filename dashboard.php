<?php include 'config/config.php';
include 'config/auth_check.php';
check_access(); 
if ($_SESSION['level'] == 'peminjam') {
    header("Location: dashboard_peminjam.php");
    exit;
}
?>
<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Dashboard | LibAdmin</title>
    <link rel="stylesheet" href="assets/styles/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <style>
        body { font-family: 'Inter', sans-serif; }
        .dashboard-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2.5rem;
            margin-top: 2.5rem;
            position: relative;
        }
        .dashboard-hero {
            position: relative;
            background-color: var(--primary);
            color: #fff;
            padding: 3rem;
            border-radius: 0.5rem;
        }
        .dashboard-hero-content h1 {
            font-size: 2.5rem;
            margin-bottom: 0.5rem;
        }
        .dashboard-hero-content p {
            max-width: 600px;
            font-size: 1rem;
        }
        .stat-card {
            background: white;
            border-radius: 1rem;
            padding: 1.5rem;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            display: flex;
            align-items: center;
            gap: 1.25rem;
            border: 1px solid var(--border);
            animation: slideUp 0.4s ease-out both;
        }
        .stat-icon {
            width: 56px;
            height: 56px;
            border-radius: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-size: 1.5rem;
        }
        .stat-icon.primary { background: #e0f2fe; color: #0284c7; }
        .stat-icon.success { background: #dcfce7; color: #16a34a; }
        .stat-icon.warning { background: #fef9c3; color: #ca8a04; }
        .stat-icon.danger { background: #fee2e2; color: #dc2626; }
        .stat-info h3 { font-size: 2rem; font-weight: 800; margin: 0; color: #0f172a; line-height: 1; }
        .stat-info p { font-size: 0.875rem; color: #64748b; margin: 0.25rem 0 0 0; font-weight: 500; }
        .dashboard-hero-content { position: relative; z-index: 2; }
    </style>
</head>
<body class="app light">
<nav class="dashboard-navbar">
    <div class="dashboard-navbar-container">
    <div class="dashboard-navbar-left">
        <div class="dashboard-brand">
        <div class="dashboard-brand-icon">
            <span class="material-icons">library_books</span>
        </div>
        <span class="dashboard-brand-text">Perpustakaan</span>
        </div>
    <div class="dashboard-nav-links">
        <a class="dashboard-nav-link active" href="dashboard.php">Dashboard</a>
        <a class="dashboard-nav-link" href="buku.php">Data Buku</a>
        <?php if ($_SESSION['level'] == 'admin'): ?>
        <a class="dashboard-nav-link" href="pegawai.php">Data Pegawai</a>
        <a class="dashboard-nav-link" href="anggota.php">Data Anggota</a>
        <?php endif; ?>
        <?php if ($_SESSION['level'] == 'admin' || $_SESSION['level'] == 'petugas'): ?>
        <a class="dashboard-nav-link" href="peminjaman.php">Peminjaman</a>
        <?php endif; ?>
        <?php if ($_SESSION['level'] == 'admin'): ?>
        <a class="dashboard-nav-link" href="users.php">Data Users</a>
        <?php endif; ?>
      </div>
    </div>
    <div style="display: flex; align-items: center; gap: 0.5rem;">
      <a href="auth/logout.php" class="dashboard-logout-btn" title="Logout">
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
      <div class="dashboard-brand">
        <div class="dashboard-brand-icon">
          <span class="material-icons">library_books</span>
        </div>
        <span class="dashboard-brand-text">Menu</span>
      </div>
      <button class="mobile-menu-close" onclick="toggleMobileMenu()">
        <span class="material-icons">close</span>
      </button>
    </div>
    <nav class="mobile-nav">
      <a href="dashboard.php" class="active">Dashboard</a>
      <a href="buku.php">Data Buku</a>
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
<main class="dashboard-container">
  <section class="dashboard-hero">
    <div class="dashboard-hero-content">
      <h1>Selamat Datang, <?= $_SESSION['nama'] ?? 'User' ?></h1>
      <p>
        Sistem Informasi Perpustakaan. Anda login sebagai <?php echo ucfirst($_SESSION['level']); ?>.
      </p>
      <?php if ($_SESSION['level'] == 'admin' || $_SESSION['level'] == 'petugas'): ?>
      <div style="margin-top: 1rem; display: flex; gap: 0.5rem;">
          <a href="peminjaman.php" class="dashboard-btn dashboard-btn-primary">
            Kelola Peminjaman
          </a>
          <a href="buku.php" class="dashboard-btn" style="background: rgba(255,255,255,0.2); color: white;">
            Data Buku
          </a>
      </div>
      <?php endif; ?>
    </div>
  </section>
  <?php
    $c_buku = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(stok) as t FROM buku"))['t'] ?? 0;
    $c_pinjam = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as t FROM peminjaman WHERE status='dipinjam'"))['t'] ?? 0;
    $c_anggota = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as t FROM anggota"))['t'] ?? 0;
    $c_pegawai = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as t FROM pegawai"))['t'] ?? 0;
  ?>
  <div class="dashboard-stats">
      <div class="stat-card" style="animation-delay: 0.1s;">
          <div class="stat-icon primary"><span class="material-icons">menu_book</span></div>
          <div class="stat-info">
              <h3><?= $c_buku ?></h3>
              <p>Total Stok Buku</p>
          </div>
      </div>
      <div class="stat-card" style="animation-delay: 0.2s;">
          <div class="stat-icon warning"><span class="material-icons">swap_horiz</span></div>
          <div class="stat-info">
              <h3><?= $c_pinjam ?></h3>
              <p>Sedang Dipinjam</p>
          </div>
      </div>
      <?php if($_SESSION['level'] == 'admin'): ?>
      <div class="stat-card" style="animation-delay: 0.3s;">
          <div class="stat-icon success"><span class="material-icons">people</span></div>
          <div class="stat-info">
              <h3><?= $c_anggota ?></h3>
              <p>Total Anggota</p>
          </div>
      </div>
      <div class="stat-card" style="animation-delay: 0.4s;">
          <div class="stat-icon danger"><span class="material-icons">badge</span></div>
          <div class="stat-info">
              <h3><?= $c_pegawai ?></h3>
              <p>Total Pegawai</p>
          </div>
      </div>
      <?php endif; ?>
  </div>
  <section class="dashboard-card-grid">
    <div class="dashboard-card" style="border-top: 4px solid var(--primary);">
      <div class="dashboard-card-header">
        <span class="material-icons" style="background: #e0f2fe; color: #0284c7;">info</span>
        <h3 style="margin:0; font-size:1.125rem;">Informasi Sistem</h3>
      </div>
      <p class="dashboard-card-text">
        Selalu pastikan untuk mengecek stok buku yang tersedia sebelum menyetujui peminjaman. Stok akan otomatis berkurang ketika buku dipinjam, dan otomatis bertambah ketika buku dikembalikan.
      </p>
    </div>
    <div class="dashboard-card" style="border-top: 4px solid #10b981;">
      <div class="dashboard-card-header">
        <span class="material-icons" style="background: #d1fae5; color: #059669;">tips_and_updates</span>
        <h3 style="margin:0; font-size:1.125rem;">Akses Role Anda</h3>
      </div>
      <p class="dashboard-card-text">
        Anda login sebagai <strong><?= ucfirst($_SESSION['level']) ?></strong>. 
        <?php if($_SESSION['level'] == 'admin'): ?>
            Anda memiliki akses penuh untuk menambah, mengedit, dan menghapus seluruh data sistem.
        <?php else: ?>
            Anda dapat melihat data buku serta mengelola penuh proses peminjaman dan pengembalian.
        <?php endif; ?>
      </p>
    </div>
  </section>
</main>
<footer class="dashboard-footer">
  <p>© 2025 Perpustakaan Digital | All Rights Reserved</p>
</footer>
<script>
function toggleMobileMenu() {
  const menu = document.getElementById('mobileMenu');
  menu.classList.toggle('show');
}
</script>
</body>
</html>
