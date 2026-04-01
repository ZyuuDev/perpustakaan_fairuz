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
    <title>Data Peminjaman | LibAdmin</title>
    <link rel="stylesheet" href="assets/styles/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols_Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
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

<!-- Mobile Menu -->
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
            <h1>📑 Data Peminjaman Buku</h1>
            <p>Pantau sirkulasi buku yang sedang dipinjam oleh anggota.</p>
        </div>
        <div class="peminjaman-header-actions">
            <button onclick="openModal('modalTambah')" class="peminjaman-btn-add">
                <span class="material-icons">add_circle</span>
                PINJAM BUKU BARU
            </button>
        </div>
    </div>

    <div class="peminjaman-table-wrapper">
        <div class="peminjaman-table-container">
            <table class="peminjaman-table">
                <thead>
                    <tr>
                        <th>ID Pinjam</th>
                        <th>ID Anggota</th>
                        <th>ISBN Buku</th>
                        <th>Tgl Pinjam</th>
                        <th>Tgl Kembali</th>
                        <th class="text-center">Status</th>
                        <th class="text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $result = mysqli_query($conn, "SELECT * FROM peminjaman");
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                    <tr>
                        <td class="font-bold">#<?php echo $row['ID_Peminjaman']; ?></td>
                        <td class="font-medium"><?php echo $row['ID_Anggota']; ?></td>
                        <td class="font-mono"><?php echo $row['isbn']; ?></td>
                        <td class="text-muted">
                            <div class="peminjaman-date-group">
                                <span class="material-icons icon-success">calendar_today</span>
                                <?php echo date('d M Y', strtotime($row['tgl_pinjam'])); ?>
                            </div>
                        </td>
                        <td class="text-muted">
                            <div class="peminjaman-date-group font-semibold">
                                <span class="material-icons icon-danger">event_busy</span>
                                <?php echo ($row['tgl_kembali']) ? date('d M Y', strtotime($row['tgl_kembali'])) : '-'; ?>
                            </div>
                        </td>
                        <td class="text-center">
                            <span class="peminjaman-badge <?php echo ($row['status'] == 'dipinjam') ? 'warning' : 'success'; ?>">
                                <?php echo $row['status']; ?>
                            </span>
                        </td>
                        <td class="text-right">
                            <div class="actions" style="display: flex; gap: 0.5rem; justify-content: flex-end; align-items: center;">
                                <?php if($row['status'] == 'dipinjam'): ?>
                                <button onclick='openEditModal(<?php echo json_encode($row); ?>)' class="peminjaman-btn-add">Kembalikan</button>
                                <?php endif; ?>
                                <a href="crud/peminjaman/peminjaman_hapus.php?id=<?php echo $row['ID_Peminjaman']; ?>" onclick="return confirm('Batalkan transaksi ini?')" class="pegawai-link-delete">Hapus</a>
                            </div>
                        </td>
                    </tr>
                    <?php 
                        } 
                    } else {
                        echo "<tr><td colspan='7' class='peminjaman-empty'>Belum ada transaksi peminjaman.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<!-- Modal Pinjam Buku -->
<div id="modalTambah" class="peminjaman-modal">
    <div class="peminjaman-modal-overlay" onclick="closeModal('modalTambah')"></div>
    <div class="peminjaman-modal-content">
        <h2>Pinjam Buku Baru</h2>
        <?php
        // Auto-generate ID Peminjaman (e.g., A001, A002)
        $query_id = mysqli_query($conn, "SELECT ID_Peminjaman FROM peminjaman WHERE ID_Peminjaman LIKE 'A%' ORDER BY ID_Peminjaman DESC LIMIT 1");
        $last_id = mysqli_fetch_array($query_id);
        
        if ($last_id) {
            $last_num = (int) substr($last_id['ID_Peminjaman'], 1);
            $next_num = $last_num + 1;
            $next_id = "A" . str_pad($next_num, 3, "0", STR_PAD_LEFT);
        } else {
            $next_id = "A001";
        }
        
        // Fetch Members for dropdown
        $members = mysqli_query($conn, "SELECT ID_Anggota, Nama FROM anggota ORDER BY Nama ASC");
        
        // Fetch Books for dropdown
        $books = mysqli_query($conn, "SELECT isbn, judul FROM buku ORDER BY judul ASC");
        ?>
        <form action="crud/peminjaman/peminjaman_tambah_aksi.php" method="post">
            <div style="margin-bottom: 1rem;">
                <label class="form-group-label">ID Peminjaman (Otomatis)</label>
                <input type="text" name="id_peminjaman" value="<?php echo $next_id; ?>" readonly class="input-readonly">
            </div>
            
            <div style="margin-bottom: 1rem;">
                <label class="form-group-label">Pilih Anggota</label>
                <select name="id_anggota" required>
                    <option value="">-- Pilih Anggota --</option>
                    <?php while ($m = mysqli_fetch_array($members)) { ?>
                        <option value="<?php echo $m['ID_Anggota']; ?>"><?php echo $m['Nama'] . " (#" . $m['ID_Anggota'] . ")"; ?></option>
                    <?php } ?>
                </select>
            </div>

            <div style="margin-bottom: 1rem;">
                <label class="form-group-label">Pilih Buku</label>
                <select name="isbn" required>
                    <option value="">-- Pilih Buku --</option>
                    <?php while ($b = mysqli_fetch_array($books)) { ?>
                        <option value="<?php echo $b['isbn']; ?>"><?php echo $b['judul'] . " (" . $b['isbn'] . ")"; ?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="form-row">
                <div style="flex: 1;">
                    <label class="form-group-label">Tgl Pinjam</label>
                    <input type="date" name="tgl_pinjam" value="<?php echo date('Y-m-d'); ?>" required>
                </div>
                <div style="flex: 1;">
                    <label class="form-group-label">Tgl Kembali (Opsional)</label>
                    <input type="date" name="tgl_kembali">
                </div>
            </div>
            <button type="submit">Simpan Peminjaman</button>
        </form>
    </div>
</div>

<!-- Modal Edit/Kembalikan Buku -->
<div id="modalEdit" class="peminjaman-modal">
    <div class="peminjaman-modal-overlay" onclick="closeModal('modalEdit')"></div>
    <div class="peminjaman-modal-content">
        <h2>Pengembalian Buku</h2>
        <form action="crud/peminjaman/peminjaman_edit_aksi.php" method="post">
            <input type="hidden" name="id_peminjaman" id="edit_id">
            
            <div style="margin-bottom: 1rem;">
                <label class="form-group-label">ID Peminjaman</label>
                <input type="text" id="edit_id_display" disabled class="input-readonly">
            </div>

            <div style="margin-bottom: 1rem;">
                <label class="form-group-label">Tanggal Pengembalian</label>
                <input type="date" name="tgl_kembali" id="edit_tgl_kembali" value="<?php echo date('Y-m-d'); ?>" required>
                <p style="font-size: 0.75rem; color: #64748b; margin-top: 0.25rem;">Status akan otomatis berubah menjadi "dikembalikan".</p>
            </div>

            <button type="submit">Proses Pengembalian</button>
            <button type="button" onclick="closeModal('modalEdit')" class="btn-cancel">Batal</button>
        </form>
    </div>
</div>

<footer class="peminjaman-footer">
    <div class="peminjaman-footer-content">
        <p>© 2025 Perpustakaan Digital | All Rights Reserved</p>
    </div>
</footer>

<script>
function toggleMobileMenu() {
  const menu = document.getElementById('mobileMenu');
  menu.classList.toggle('show');
}

function openModal(id) {
  document.getElementById(id).classList.add('show');
}

function closeModal(id) {
  document.getElementById(id).classList.remove('show');
}

function openEditModal(data) {
  document.getElementById('edit_id').value = data.ID_Peminjaman;
  document.getElementById('edit_id_display').value = data.ID_Peminjaman;
  openModal('modalEdit');
}
</script>

</body>
</html>