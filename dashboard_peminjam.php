<?php
include 'config/config.php';
include 'config/auth_check.php';
check_access(['peminjam']);
$id_anggota = $_SESSION['id_anggota'];
$nama = $_SESSION['nama'];
$count_pinjam = mysqli_query($conn, "SELECT COUNT(*) as total FROM peminjaman WHERE ID_Anggota = '$id_anggota' AND status = 'dipinjam'");
$stat_pinjam = mysqli_fetch_assoc($count_pinjam)['total'];
$count_total = mysqli_query($conn, "SELECT COUNT(*) as total FROM peminjaman WHERE ID_Anggota = '$id_anggota'");
$stat_total = mysqli_fetch_assoc($count_total)['total'];
$count_buku = mysqli_query($conn, "SELECT COUNT(*) as total FROM buku WHERE stok > 0");
$stat_buku = mysqli_fetch_assoc($count_buku)['total'];
$buku_rekomendasi = mysqli_query($conn, "SELECT * FROM buku WHERE stok > 0 ORDER BY judul ASC LIMIT 4");
?>
<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Dashboard Anggota | Perpustakaan</title>
    <link rel="stylesheet" href="assets/styles/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"/>
    <style>
        body { font-family: 'Inter', sans-serif; }
        .anggota-dashboard-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2.5rem;
            margin-top: 2.5rem;
        }
        .stat-card {
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 1rem;
            padding: 1.5rem;
            display: flex;
            align-items: center;
            gap: 1.25rem;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
            animation: slideUp 0.4s ease-out both;
        }
        .stat-card:nth-child(2) { animation-delay: 0.1s; }
        .stat-card:nth-child(3) { animation-delay: 0.2s; }
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
        .stat-icon.blue { background: #dbeafe; color: #2563eb; }
        .stat-icon.amber { background: #fef3c7; color: #d97706; }
        .stat-icon.emerald { background: #d1fae5; color: #059669; }
        .stat-info h3 { font-size: 1.75rem; font-weight: 800; margin: 0; color: #0f172a; line-height: 1; }
        .stat-info p { font-size: 0.875rem; color: #64748b; margin: 0.25rem 0 0 0; font-weight: 500; }
        .section-title { font-size: 1.25rem; font-weight: 700; color: #0f172a; margin: 0 0 1rem 0; display: flex; align-items: center; gap: 0.5rem; }
        .book-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 1rem; }
        .book-card {
            background: white; border: 1px solid #e5e7eb; border-radius: 0.75rem; padding: 1.25rem;
            transition: all 0.2s;
        }
        .book-card:hover { border-color: #137fec; box-shadow: 0 4px 12px rgba(19, 127, 236, 0.15); transform: translateY(-2px); }
        .book-card h4 { font-size: 1rem; font-weight: 700; color: #0f172a; margin: 0 0 0.5rem 0; }
        .book-card .book-meta { font-size: 0.8125rem; color: #64748b; line-height: 1.6; }
        .book-card .book-meta span { display: block; }
        .quick-actions { display: flex; gap: 1rem; margin-top: 1.5rem; }
        .btn-quick {
            display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.75rem 1.5rem;
            border-radius: 0.5rem; font-weight: 600; text-decoration: none; font-size: 0.875rem;
        }
        .btn-quick.primary { background: white; color: #137fec; border: none; }
        .btn-quick.secondary { background: rgba(255,255,255,0.2); color: white; border: 1px solid rgba(255,255,255,0.4); }
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
                <a class="peminjaman-nav-link active" href="dashboard_peminjam.php">Dashboard</a>
                <a class="peminjaman-nav-link" href="buku_peminjam.php">Cari Buku</a>
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
      <a href="dashboard_peminjam.php" class="active">Dashboard</a>
      <a href="buku_peminjam.php">Cari Buku</a>
      <a href="riwayat_peminjaman.php">Riwayat Peminjaman</a>
      <div class="mobile-nav-divider"></div>
      <a href="auth/logout.php" style="color: #ef4444;">Logout</a>
    </nav>
  </div>
</div>
<main class="peminjaman-main">
    <div style="background-color: #137fec; color: white; padding: 2rem; border-radius: 0.5rem; margin-bottom: 2rem;">
        <div>
            <h1 style="font-size: 1.8rem; margin: 0 0 0.5rem 0;">Selamat Datang, <?= htmlspecialchars($nama); ?></h1>
            <p style="margin: 0; font-size: 1rem;">
                Halaman profil anggota perpustakaan.
            </p>
            <div class="quick-actions">
                <a href="buku_peminjam.php" class="btn-quick primary">
                    Cari Buku
                </a>
                <a href="riwayat_peminjaman.php" class="btn-quick secondary">
                    Riwayat Peminjaman
                </a>
            </div>
        </div>
    </div>
    <div class="anggota-dashboard-stats">
        <div class="stat-card">
            <div class="stat-icon amber">
                <span class="material-icons">auto_stories</span>
            </div>
            <div class="stat-info">
                <h3><?= $stat_pinjam; ?></h3>
                <p>Buku Sedang Dipinjam</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon blue">
                <span class="material-icons">history</span>
            </div>
            <div class="stat-info">
                <h3><?= $stat_total; ?></h3>
                <p>Total Peminjaman</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon emerald">
                <span class="material-icons">library_books</span>
            </div>
            <div class="stat-info">
                <h3><?= $stat_buku; ?></h3>
                <p>Buku Tersedia di Perpus</p>
            </div>
        </div>
    </div>
    <div style="margin-top: 2rem;">
        <h2 class="section-title">
            Buku Tersedia
        </h2>
        <div class="book-grid">
            <?php 
            if (mysqli_num_rows($buku_rekomendasi) > 0) {
                while ($buku = mysqli_fetch_assoc($buku_rekomendasi)) : 
            ?>
            <div class="book-card">
                <h4><?= htmlspecialchars($buku['judul']); ?></h4>
                <div class="book-meta">
                    <span style="display: flex; align-items: center; gap: 0.25rem;"><span class="material-icons" style="font-size: 1rem;">person</span> <?= htmlspecialchars($buku['pengarang']); ?></span>
                    <span style="display: flex; align-items: center; gap: 0.25rem;"><span class="material-icons" style="font-size: 1rem;">label</span> <?= htmlspecialchars($buku['genre']); ?> (<?= htmlspecialchars($buku['tahun']); ?>)</span>
                </div>
            </div>
            <?php 
                endwhile;
            } else {
                echo '<p style="color: #64748b;">Belum ada rekomendasi buku.</p>';
            }
            ?>
        </div>
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
