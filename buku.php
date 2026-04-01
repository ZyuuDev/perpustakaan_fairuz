<?php
include 'config/config.php';
include 'config/auth_check.php';
check_access(); // Basic check to ensure logged in
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
        /* Animasi fade untuk modal */
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

<!-- Mobile Menu -->
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
      <div class="mobile-nav-divider"></div>
      <a href="auth/logout.php" style="color: #ef4444;">Logout</a>
    </nav>
  </div>
</div>

<main class="buku-main">
    <div class="buku-header">
        <div>
            <h1>📘 Manajemen Data Buku</h1>
            <p>Kelola koleksi buku perpustakaan secara efisien.</p>
        </div>
        <?php if ($_SESSION['level'] == 'admin'): ?>
        <button onclick="openModal('modalTambah')" class="buku-btn-add">
            <span class="material-icons">add</span>
            TAMBAH BUKU BARU
        </button>
        <?php endif; ?>
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
                        <th class="text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $result = mysqli_query($conn, "SELECT * FROM buku");
                    while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                    <tr>
                        <td class="font-semibold"><?php echo $row['isbn']; ?></td>
                        <td><?php echo $row['judul']; ?></td>
                        <td><?php echo $row['pengarang']; ?></td>
                        <td><?php echo $row['penerbit']; ?></td>
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
                    <?php } ?>
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
                    <input type="text" name="tahun" placeholder="Tahun">
                </div>
                <div style="margin-bottom: 1rem;">
                    <label class="form-group-label">Genre</label>
                    <input type="text" name="genre" placeholder="Genre">
                </div>
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
                    <input type="text" name="tahun" id="edit_tahun">
                </div>
                <div>
                    <label>Genre</label>
                    <input type="text" name="genre" id="edit_genre">
                </div>
            </div>
            <button type="submit">Update Data Buku</button>
            <button type="button" onclick="closeModal('modalEdit')">Batal</button>
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
        
        openModal('modalEdit');
    }
</script>

<footer class="buku-footer">
    <div class="buku-footer-content">
        <p>© 2025 Perpustakaan Digital | All Rights Reserved</p>
    </div>
</footer>

</body>
</html>