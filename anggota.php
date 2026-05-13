<?php
include 'config/config.php';
include 'config/auth_check.php';
check_access(['admin']);
?>
<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Data Anggota | LibAdmin</title>
    <link rel="stylesheet" href="assets/styles/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="anggota-body">

<nav class="anggota-navbar">
    <div class="anggota-navbar-container">
        <div class="anggota-navbar-left">
            <div class="anggota-brand">
                <div class="anggota-brand-icon">
                    <span class="material-icons">library_books</span>
                </div>
                <span class="anggota-brand-text">Perpustakaan</span>
            </div>
            <div class="anggota-nav-links">
                <a class="anggota-nav-link" href="dashboard.php">Dashboard</a>
                <a class="anggota-nav-link" href="buku.php">Data Buku</a>
                <a class="anggota-nav-link" href="pegawai.php">Data Pegawai</a>
                <a class="anggota-nav-link active" href="anggota.php">Data Anggota</a>
                <a class="anggota-nav-link" href="peminjaman.php">Peminjaman</a>
                <a class="anggota-nav-link" href="users.php">Data Users</a>
            </div>
        </div>
        <div class="anggota-navbar-right">
            <a href="auth/logout.php" class="anggota-logout" title="Logout">
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
      <div class="anggota-brand">
        <div class="anggota-brand-icon">
          <span class="material-icons">library_books</span>
        </div>
        <span class="anggota-brand-text">Menu</span>
      </div>
      <button class="mobile-menu-close" onclick="toggleMobileMenu()">
        <span class="material-icons">close</span>
      </button>
    </div>
    <nav class="mobile-nav">
      <a href="dashboard.php">Dashboard</a>
      <a href="buku.php">Data Buku</a>
      <a href="pegawai.php">Data Pegawai</a>
      <a href="peminjaman.php">Peminjaman</a>
      <a href="anggota.php" class="active">Data Anggota</a>
      <a href="users.php">Data Users</a>
      <div class="mobile-nav-divider"></div>
      <a href="auth/logout.php" style="color: #ef4444;">Logout</a>
    </nav>
  </div>
</div>

<main class="anggota-main">
    <div class="anggota-header">
        <div>
            <h1>Data Anggota</h1>
            <p>Kelola daftar anggota yang terdaftar di perpustakaan.</p>
        </div>
        <div class="anggota-header-actions">
            <button onclick="openModal('modalTambah')" class="anggota-btn-add">
                <span class="material-icons">group_add</span>
                TAMBAH ANGGOTA
            </button>
        </div>
    </div>

    <div class="anggota-table-wrapper">
        <div class="anggota-table-container">
            <table class="anggota-table">
                <thead>
                    <tr>
                        <th>ID Anggota</th>
                        <th>Nama Lengkap</th>
                        <th>NIS</th>
                        <th>NISN</th>
                        <th>Alamat</th>
                        <th>No. Telepon</th>
                        <th class="text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $result = mysqli_query($conn, "SELECT * FROM anggota");
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                    <tr>
                        <td class="font-bold">#<?php echo $row['ID_Anggota']; ?></td>
                        <td class="font-medium"><?php echo $row['Nama']; ?></td>
                        <td class="font-mono"><?php echo $row['NIS']; ?></td>
                        <td class="font-mono"><?php echo $row['nisn']; ?></td>
                        <td class="text-muted"><?php echo $row['Alamat']; ?></td>
                        <td class="text-muted">
                            <div class="anggota-phone-group">
                                <span class="material-icons icon">phone</span>
                                <?php echo $row['Nomor_HP']; ?>
                            </div>
                        </td>
                        <td class="text-right">
                            <div class="actions">
                                <button 
                                    onclick='openEditModal(<?php echo json_encode($row); ?>)' 
                                    class="anggota-link-edit">Edit</button>
                                <a href="crud/anggota/anggota_hapus.php?id=<?php echo $row['ID_Anggota']; ?>" onclick="return confirm('Yakin ingin menghapus anggota ini?')" class="anggota-link-delete">Hapus</a>
                            </div>
                        </td>
                    </tr>
                    <?php 
                        } 
                    } else {
                        echo "<tr><td colspan='7' class='anggota-empty'>Belum ada data anggota.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<!-- Modal Tambah Anggota -->
<div id="modalTambah" class="anggota-modal">
    <div class="anggota-modal-overlay" onclick="closeModal('modalTambah')"></div>
    <div class="anggota-modal-content">
        <h2>Tambah Anggota Baru</h2>
        <form action="crud/anggota/anggota_tambah_aksi.php" method="post">
            <div style="margin-bottom: 1rem;">
                <label class="form-group-label">ID Anggota</label>
                <input type="text" name="id_anggota" placeholder="Misal: AGT001" required>
            </div>
            <div style="margin-bottom: 1rem;">
                <label class="form-group-label">Nama Lengkap</label>
                <input type="text" name="nama" placeholder="Nama Lengkap" required>
            </div>
            <div style="margin-bottom: 1rem;">
                <label class="form-group-label">NIS (sebagai username login)</label>
                <input type="text" name="nis" placeholder="NIS" required>
            </div>
            <div style="margin-bottom: 1rem;">
                <label class="form-group-label">NISN (sebagai password login)</label>
                <input type="text" name="nisn" placeholder="NISN" required>
            </div>
            <div style="margin-bottom: 1rem;">
                <label class="form-group-label">Alamat</label>
                <input type="text" name="alamat" placeholder="Alamat">
            </div>
            <div style="margin-bottom: 1rem;">
                <label class="form-group-label">Nomor HP</label>
                <input type="text" name="nomor_hp" placeholder="Nomor HP">
            </div>
            <button type="submit">Simpan Anggota</button>
        </form>
    </div>
</div>

<!-- Modal Edit Anggota -->
<div id="modalEdit" class="anggota-modal">
    <div class="anggota-modal-overlay" onclick="closeModal('modalEdit')"></div>
    <div class="anggota-modal-content">
        <h2>Edit Data Anggota</h2>
        <form action="crud/anggota/anggota_edit_aksi.php" method="post">
            <input type="hidden" name="id" id="edit_id">
            <div style="margin-bottom: 1rem;">
                <label class="form-group-label">ID Anggota (ID Tetap)</label>
                <input type="text" id="edit_id_display" disabled class="input-readonly">
            </div>
            <div style="margin-bottom: 1rem;">
                <label class="form-group-label">Nama Lengkap</label>
                <input type="text" name="nama" id="edit_nama" placeholder="Nama Lengkap" required>
            </div>
            <div style="margin-bottom: 1rem;">
                <label class="form-group-label">NIS (sebagai username login)</label>
                <input type="text" name="nis" id="edit_nis" placeholder="NIS" required>
            </div>
            <div style="margin-bottom: 1rem;">
                <label class="form-group-label">NISN (sebagai password login)</label>
                <input type="text" name="nisn" id="edit_nisn" placeholder="NISN" required>
            </div>
            <div style="margin-bottom: 1rem;">
                <label class="form-group-label">Alamat</label>
                <input type="text" name="alamat" id="edit_alamat" placeholder="Alamat">
            </div>
            <div style="margin-bottom: 1rem;">
                <label class="form-group-label">Nomor HP</label>
                <input type="text" name="nomor_hp" id="edit_nomor_hp" placeholder="Nomor HP">
            </div>
            <button type="submit">Update Anggota</button>
            <button type="button" onclick="closeModal('modalEdit')" class="btn-cancel">Batal</button>
        </form>
    </div>
</div>

<footer class="anggota-footer">
    <div class="anggota-footer-content">
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
  document.getElementById('edit_id').value = data.ID_Anggota;
  document.getElementById('edit_id_display').value = data.ID_Anggota;
  document.getElementById('edit_nama').value = data.Nama;
  document.getElementById('edit_nis').value = data.NIS;
  document.getElementById('edit_nisn').value = data.nisn;
  document.getElementById('edit_alamat').value = data.Alamat;
  document.getElementById('edit_nomor_hp').value = data.Nomor_HP;
  
  openModal('modalEdit');
}
</script>

</body>
</html>