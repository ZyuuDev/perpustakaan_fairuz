<?php include 'config/config.php';
include 'config/auth_check.php';
check_access(); // Basic check to ensure logged in
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

<!-- Mobile Menu -->
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
      <div class="mobile-nav-divider"></div>
      <a href="auth/logout.php" style="color: #ef4444;">Logout</a>
    </nav>
  </div>
</div>

<main class="dashboard-container">
  <section class="dashboard-hero">
    <div class="dashboard-hero-content">
      <h1><?= get_user_greeting(); ?></h1>
      <p>
        Sistem informasi perpustakaan digital terintegrasi.
        Pantau semua aktivitas buku, pegawai, dan anggota di sini.
      </p>
      <?php if ($_SESSION['level'] == 'admin' || $_SESSION['level'] == 'petugas'): ?>
      <a href="peminjaman.php" class="dashboard-btn dashboard-btn-primary">
        <span class="material-icons">add_chart</span>
        Kelola Peminjaman
      </a>
      <?php endif; ?>
    </div>
    <span class="dashboard-hero-bg-icon material-icons">auto_stories</span>
  </section>

  <section class="dashboard-card-grid">
    <div class="dashboard-card">
      <div class="dashboard-card-header amber">
        <span class="material-icons">info</span>
        <h3>Informasi Staff</h3>
      </div>
      <p class="dashboard-card-text italic">
        "Ingin meminjam buku? Silakan hubungi staff perpustakaan yang sedang bertugas."
      </p>
    </div>

    <div class="dashboard-card">
      <div class="dashboard-card-header emerald">
        <span class="material-icons">tips_and_updates</span>
        <h3>Instruksi Menu</h3>
      </div>
      <p class="dashboard-card-text">
        Gunakan navigasi di bagian atas untuk mengelola data buku, melihat daftar pegawai,
        atau mencatat peminjaman baru.
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
