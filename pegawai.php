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
    <title>Data Pegawai | LibAdmin</title>
    <link rel="stylesheet" href="assets/styles/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="pegawai-body">

<nav class="pegawai-navbar">
    <div class="pegawai-navbar-container">
        <div class="pegawai-navbar-left">
            <div class="pegawai-brand">
                <div class="pegawai-brand-icon">
                    <span class="material-icons">library_books</span>
                </div>
                <span class="pegawai-brand-text">Perpustakaan</span>
            </div>
            <div class="pegawai-nav-links">
                <a class="pegawai-nav-link" href="dashboard.php">Dashboard</a>
                <a class="pegawai-nav-link" href="buku.php">Data Buku</a>
                <a class="pegawai-nav-link active" href="pegawai.php">Data Pegawai</a>
                <a class="pegawai-nav-link" href="anggota.php">Data Anggota</a>
                <a class="pegawai-nav-link" href="peminjaman.php">Peminjaman</a>
            </div>
        </div>
        <div class="pegawai-navbar-right">
            <a href="auth/logout.php" class="pegawai-logout" title="Logout">
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
      <div class="pegawai-brand">
        <div class="pegawai-brand-icon">
          <span class="material-icons">library_books</span>
        </div>
        <span class="pegawai-brand-text">Menu</span>
      </div>
      <button class="mobile-menu-close" onclick="toggleMobileMenu()">
        <span class="material-icons">close</span>
      </button>
    </div>
    <nav class="mobile-nav">
      <a href="dashboard.php">Dashboard</a>
      <a href="buku.php">Data Buku</a>
      <a href="pegawai.php" class="active">Data Pegawai</a>
      <a href="anggota.php">Data Anggota</a>
      <a href="peminjaman.php">Peminjaman</a>
      <div class="mobile-nav-divider"></div>
      <a href="auth/logout.php" style="color: #ef4444;">Logout</a>
    </nav>
  </div>
</div>

<main class="pegawai-main">
    <div class="pegawai-header">
        <div>
            <h1>👩‍💼 Manajemen Data Pegawai</h1>
            <p>Kelola informasi staff dan admin perpustakaan.</p>
        </div>
        <div class="pegawai-header-actions">
            <button onclick="openModal('modalTambah')" class="pegawai-btn-add">
                <span class="material-icons">person_add</span>
                TAMBAH PEGAWAI
            </button>
        </div>
    </div>

    <div class="pegawai-table-wrapper">
        <div class="pegawai-table-container">
            <table class="pegawai-table">
                <thead>
                    <tr>
                        <th class="w-32">NIP</th>
                        <th>Nama Pegawai</th>
                        <th>Alamat</th>
                        <th class="text-center">Gender</th>
                        <th class="text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $result = mysqli_query($conn, "SELECT * FROM pegawai");
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                    <tr>
                        <td class="font-semibold"><?php echo $row['nip']; ?></td>
                        <td class="font-medium"><?php echo $row['nama']; ?></td>
                        <td class="text-muted"><?php echo $row['alamat']; ?></td>
                        <td class="text-center">
                            <span class="pegawai-badge <?php echo ($row['gender'] == 'L' || $row['gender'] == 'Laki-laki') ? 'male' : 'female'; ?>">
                                <?php echo $row['gender']; ?>
                            </span>
                        </td>
                        <td class="text-right">
                            <div class="actions">
                                <button 
                                    onclick='openEditModal(<?php echo json_encode($row); ?>)' 
                                    class="pegawai-link-edit">Edit</button>
                                <a href="crud/pegawai/pegawai_hapus.php?id=<?php echo $row['nip']; ?>" onclick="return confirm('Yakin ingin menghapus pegawai ini?')" class="pegawai-link-delete">Hapus</a>
                            </div>
                        </td>
                    </tr>
                    <?php 
                        } 
                    } else {
                        echo "<tr><td colspan='5' class='pegawai-empty'>Belum ada data pegawai.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<!-- Modal Tambah Pegawai -->
<div id="modalTambah" class="pegawai-modal">
    <div class="pegawai-modal-overlay" onclick="closeModal('modalTambah')"></div>
    <div class="pegawai-modal-content">
        <h2>Tambah Pegawai Baru</h2>
        <form action="crud/pegawai/pegawai_tambah_aksi.php" method="post">
            <div style="margin-bottom: 1rem;">
                <label class="form-group-label">NIP</label>
                <input type="text" name="nip" placeholder="NIP" required>
            </div>
            <div style="margin-bottom: 1rem;">
                <label class="form-group-label">Nama Lengkap</label>
                <input type="text" name="nama" placeholder="Nama Lengkap" required>
            </div>
            <div style="margin-bottom: 1rem;">
                <label class="form-group-label">Alamat</label>
                <input type="text" name="alamat" placeholder="Alamat">
            </div>
            <div style="margin-bottom: 1rem;">
                <label class="form-group-label">Gender</label>
                <select name="gender" required>
                    <option value="">Pilih Gender</option>
                    <option value="Laki-laki">Laki-laki</option>
                    <option value="Perempuan">Perempuan</option>
                </select>
            </div>
            <button type="submit">Simpan Pegawai</button>
        </form>
    </div>
</div>

<!-- Modal Edit Pegawai -->
<div id="modalEdit" class="pegawai-modal">
    <div class="pegawai-modal-overlay" onclick="closeModal('modalEdit')"></div>
    <div class="pegawai-modal-content">
        <h2>Edit Data Pegawai</h2>
        <form action="crud/pegawai/pegawai_edit_aksi.php" method="post">
            <input type="hidden" name="nip_lama" id="edit_nip_lama">
            <div style="margin-bottom: 1rem;">
                <label class="form-group-label">NIP (ID Pegawai)</label>
                <input type="text" name="nip" id="edit_nip" placeholder="NIP" required>
            </div>
            <div style="margin-bottom: 1rem;">
                <label class="form-group-label">Nama Lengkap</label>
                <input type="text" name="nama" id="edit_nama_pegawai" placeholder="Nama Lengkap" required>
            </div>
            <div style="margin-bottom: 1rem;">
                <label class="form-group-label">Alamat</label>
                <input type="text" name="alamat" id="edit_alamat_pegawai" placeholder="Alamat">
            </div>
            <div style="margin-bottom: 1rem;">
                <label class="form-group-label">Gender</label>
                <select name="gender" id="edit_gender" required>
                    <option value="Laki-laki">Laki-laki</option>
                    <option value="Perempuan">Perempuan</option>
                </select>
            </div>
            <button type="submit">Update Pegawai</button>
            <button type="button" onclick="closeModal('modalEdit')" class="btn-cancel">Batal</button>
        </form>
    </div>
</div>

<footer class="pegawai-footer">
    <div class="pegawai-footer-content">
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
  document.getElementById('edit_nip_lama').value = data.nip;
  document.getElementById('edit_nip').value = data.nip;
  document.getElementById('edit_nama_pegawai').value = data.nama;
  document.getElementById('edit_alamat_pegawai').value = data.alamat;
  document.getElementById('edit_gender').value = data.gender;
  
  openModal('modalEdit');
}
</script>

</body>
</html>