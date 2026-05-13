<?php
include 'config/config.php';
include 'config/auth_check.php';
check_access(['peminjam']);

$id_anggota = $_SESSION['id_anggota'];
$nama = $_SESSION['nama'];

// Riwayat peminjaman berdasarkan ID anggota yang login (INNER JOIN)
$search_riwayat = isset($_GET['search_riwayat']) ? mysqli_real_escape_string($conn, $_GET['search_riwayat']) : '';
$query_riwayat = "SELECT p.ID_Peminjaman, b.judul, p.tgl_pinjam, p.tgl_kembali, p.status
                  FROM peminjaman p
                  JOIN buku b ON p.isbn = b.isbn
                  WHERE p.ID_Anggota = '$id_anggota'";
if (!empty($search_riwayat)) {
    $query_riwayat .= " AND (b.judul LIKE '%$search_riwayat%' OR p.ID_Peminjaman LIKE '%$search_riwayat%')";
}
$query_riwayat .= " ORDER BY p.ID_Peminjaman DESC";
$result_riwayat = mysqli_query($conn, $query_riwayat);
?>
<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Riwayat Peminjaman | Perpustakaan</title>
    <link rel="stylesheet" href="assets/styles/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"/>
    <style>
        body { font-family: 'Inter', sans-serif; background: #f8fafc; }
        .search-container { background: white; padding: 1.5rem; border-radius: 1rem; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); margin-bottom: 2rem; border: 1px solid #e5e7eb; }
        .search-bar { display: flex; gap: 0.75rem; max-width: 600px; }
        .search-bar input { flex: 1; padding: 0.75rem 1rem; border: 2px solid #e2e8f0; border-radius: 0.75rem; font-size: 0.875rem; font-family: 'Inter', sans-serif; outline: none; transition: border-color 0.2s; }
        .search-bar input:focus { border-color: #137fec; }
        .search-bar button { display: flex; align-items: center; justify-content: center; padding: 0 1.25rem; background: #137fec; color: white; border: none; border-radius: 0.75rem; cursor: pointer; font-weight: 600; transition: background 0.2s; }
        .search-bar button:hover { background: #0c58a8; }
        .clear-link { display: flex; align-items: center; justify-content: center; padding: 0 1rem; color: #ef4444; text-decoration: none; border: 2px solid #fecaca; border-radius: 0.75rem; background: #fef2f2; }
        .riwayat-wrapper { background: white; border-radius: 1rem; border: 1px solid #e2e8f0; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); }
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
                <a class="peminjaman-nav-link" href="buku_peminjam.php">Cari Buku</a>
                <a class="peminjaman-nav-link active" href="riwayat_peminjaman.php">Riwayat Peminjaman</a>
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
      <a href="buku_peminjam.php">Cari Buku</a>
      <a href="riwayat_peminjaman.php" class="active">Riwayat Peminjaman</a>
      <div class="mobile-nav-divider"></div>
      <a href="auth/logout.php" style="color: #ef4444;">Logout</a>
    </nav>
  </div>
</div>

<main class="peminjaman-main">
    <div class="peminjaman-header" style="margin-bottom: 2rem;">
        <div>
            <h1>Riwayat Peminjaman</h1>
            <p>Daftar buku yang dipinjam dan dikembalikan.</p>
        </div>
    </div>

    <!-- Search Section -->
    <div class="search-container">
        <form method="GET" action="riwayat_peminjaman.php" class="search-bar">
            <input type="text" name="search_riwayat" placeholder="Cari ID transaksi atau judul buku..." 
                   value="<?= htmlspecialchars($search_riwayat); ?>">
            <button type="submit">
                <span class="material-icons" style="margin-right: 0.5rem; font-size: 1.25rem;">search</span> Cari
            </button>
            <?php if (!empty($search_riwayat)): ?>
            <a href="riwayat_peminjaman.php" class="clear-link" title="Hapus pencarian">
                <span class="material-icons">close</span>
            </a>
            <?php endif; ?>
        </form>
    </div>

    <!-- Tabel Riwayat -->
    <div class="riwayat-wrapper">
        <div class="peminjaman-table-container" style="box-shadow: none;">
            <table class="peminjaman-table">
                <thead>
                    <tr style="background: #f8fafc;">
                        <th>No</th>
                        <th>ID Transaksi</th>
                        <th>Judul Buku</th>
                        <th>Tgl Pinjam</th>
                        <th>Tgl Kembali</th>
                        <th class="text-center">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $no = 1;
                    if ($result_riwayat && mysqli_num_rows($result_riwayat) > 0) {
                        while ($row = mysqli_fetch_assoc($result_riwayat)) :
                    ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td class="font-bold">#<?= $row['ID_Peminjaman']; ?></td>
                        <td class="font-medium" style="color: #0f172a;"><?= $row['judul']; ?></td>
                        <td class="text-muted">
                            <div class="peminjaman-date-group">
                                <span class="material-icons icon-success">calendar_today</span>
                                <?= date('d M Y', strtotime($row['tgl_pinjam'])); ?>
                            </div>
                        </td>
                        <td class="text-muted">
                            <div class="peminjaman-date-group">
                                <span class="material-icons icon-danger">event_busy</span>
                                <?= ($row['tgl_kembali']) ? date('d M Y', strtotime($row['tgl_kembali'])) : '<span style="color:#ef4444; font-style:italic;">Belum dikembalikan</span>'; ?>
                            </div>
                        </td>
                        <td class="text-center">
                            <span class="peminjaman-badge <?= ($row['status'] == 'dipinjam') ? 'warning' : 'success'; ?>">
                                <?= ($row['status'] == 'dipinjam') ? 'Sedang Dipinjam' : 'Dikembalikan'; ?>
                            </span>
                        </td>
                    </tr>
                    <?php 
                        endwhile;
                    } else {
                        echo "<tr><td colspan='6' style='text-align:center; padding: 3rem; color: #64748b;'>Belum ada data riwayat peminjaman.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
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
