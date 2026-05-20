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
    <title>Data Users | LibAdmin</title>
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
                <a class="pegawai-nav-link" href="pegawai.php">Data Pegawai</a>
                <a class="pegawai-nav-link" href="anggota.php">Data Anggota</a>
                <a class="pegawai-nav-link" href="peminjaman.php">Peminjaman</a>
                <a class="pegawai-nav-link active" href="users.php">Data Users</a>
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
      <a href="pegawai.php">Data Pegawai</a>
      <a href="anggota.php">Data Anggota</a>
      <a href="peminjaman.php">Peminjaman</a>
      <a href="users.php" class="active">Data Users</a>
      <div class="mobile-nav-divider"></div>
      <a href="auth/logout.php" style="color: #ef4444;">Logout</a>
    </nav>
  </div>
</div>
<main class="pegawai-main">
    <div class="pegawai-header">
        <div>
            <h1>Kelola Users & Role</h1>
            <p>Atur akun pengguna dan hak akses (role) dalam sistem.</p>
        </div>
        <button onclick="openModal('modalTambahUser')" class="buku-btn-add" style="display: flex; align-items: center; gap: 0.5rem; background: #137fec; color: white; border: none; padding: 0.625rem 1.25rem; border-radius: 0.5rem; font-weight: 600; cursor: pointer;">
            <span class="material-icons">add</span> Tambah User
        </button>
    </div>
    <div class="pegawai-table-wrapper">
        <div class="pegawai-table-container">
            <table class="pegawai-table">
                <thead>
                    <tr>
                        <th class="w-32">Username</th>
                        <th>Nama Lengkap</th>
                        <th class="text-center">Tipe Akun (users)</th>
                        <th class="text-center">Role Spesifik</th>
                        <th class="text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = "
                        SELECT u.*, 
                               COALESCE(a.Nama, p.nama) as nama,
                               COALESCE(p.level, u.level) as role_spesifik,
                               (SELECT COUNT(*) FROM peminjaman WHERE ID_Anggota = a.ID_Anggota) as has_pinjaman
                        FROM users u
                        LEFT JOIN anggota a ON u.id_user = a.id_user
                        LEFT JOIN pegawai p ON u.id_user = p.id_user
                        ORDER BY u.id_user DESC
                    ";
                    $result = mysqli_query($conn, $query);
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                    <tr>
                        <td class="font-semibold"><?php echo $row['username']; ?></td>
                        <td class="font-medium"><?php echo $row['nama']; ?></td>
                        <td class="text-center">
                            <span class="pegawai-badge <?php echo ($row['level'] == 'pegawai') ? 'male' : 'female'; ?>">
                                <?php echo ucfirst($row['level']); ?>
                            </span>
                        </td>
                        <td class="text-center">
                            <span class="peminjaman-badge <?php echo ($row['role_spesifik'] == 'admin') ? 'warning' : 'success'; ?>">
                                <?php echo ucfirst($row['role_spesifik']); ?>
                            </span>
                        </td>
                        <td class="text-right">
                            <div class="actions" style="display: flex; justify-content: flex-end; gap: 0.5rem;">
                                <button 
                                    onclick='openEditProfilModal(<?php echo htmlspecialchars(json_encode($row), ENT_QUOTES, "UTF-8"); ?>)' 
                                    class="pegawai-link-edit" style="background: #3b82f6; border-color: #2563eb; color: white;">Edit Profil</button>
                                <button 
                                    onclick='openEditModal(<?php echo htmlspecialchars(json_encode($row), ENT_QUOTES, "UTF-8"); ?>)' 
                                    class="pegawai-link-edit">Role</button>
                                <a href="crud/users/users_hapus_aksi.php?id=<?php echo $row['id_user']; ?>" 
                                   onclick="return confirm('Apakah Anda yakin ingin menghapus user ini? Profil anggota/pegawai juga akan terhapus permanen.')" 
                                   class="pegawai-link-delete" style="background: #ef4444; color: white; border: 1px solid #dc2626; padding: 0.25rem 0.75rem; border-radius: 0.375rem; text-decoration: none; font-size: 0.875rem;">Hapus</a>
                            </div>
                        </td>
                    </tr>
                    <?php 
                        } 
                    } else {
                        echo "<tr><td colspan='5' class='pegawai-empty'>Belum ada data users.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</main>
<div id="modalTambahUser" class="pegawai-modal">
    <div class="pegawai-modal-overlay" onclick="closeModal('modalTambahUser')"></div>
    <div class="pegawai-modal-content" style="max-height: 90vh; overflow-y: auto;">
        <h2>Tambah User Baru</h2>
        <form action="crud/users/users_tambah_aksi.php" method="post">
            <div style="margin-bottom: 1rem;">
                <label class="form-group-label">Role Akses</label>
                <select name="role" required style="width: 100%; padding: 0.5rem; border: 1px solid #cbd5e1; border-radius: 0.375rem;">
                    <option value="anggota">Anggota Peminjam</option>
                    <option value="petugas">Petugas Perpustakaan</option>
                    <option value="admin">Administrator</option>
                </select>
            </div>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                <div>
                    <label class="form-group-label">Username (NIS/NIP)</label>
                    <input type="text" name="username" required style="width: 100%; padding: 0.5rem; border: 1px solid #cbd5e1; border-radius: 0.375rem;">
                </div>
                <div>
                    <label class="form-group-label">Password (NISN/NIP)</label>
                    <input type="password" name="password" required style="width: 100%; padding: 0.5rem; border: 1px solid #cbd5e1; border-radius: 0.375rem;">
                </div>
            </div>
            <div style="margin-bottom: 1rem;">
                <label class="form-group-label">Nama Lengkap</label>
                <input type="text" name="nama" required style="width: 100%; padding: 0.5rem; border: 1px solid #cbd5e1; border-radius: 0.375rem;">
            </div>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                <div>
                    <label class="form-group-label">Nomor HP</label>
                    <input type="text" name="nomor_hp" style="width: 100%; padding: 0.5rem; border: 1px solid #cbd5e1; border-radius: 0.375rem;">
                </div>
                <div>
                    <label class="form-group-label">Gender</label>
                    <select name="gender" style="width: 100%; padding: 0.5rem; border: 1px solid #cbd5e1; border-radius: 0.375rem;">
                        <option value="Laki-laki">Laki-laki</option>
                        <option value="Perempuan">Perempuan</option>
                    </select>
                </div>
            </div>
            <div style="margin-bottom: 1.5rem;">
                <label class="form-group-label">Alamat Lengkap</label>
                <textarea name="alamat" rows="2" style="width: 100%; padding: 0.5rem; border: 1px solid #cbd5e1; border-radius: 0.375rem; font-family: inherit;"></textarea>
            </div>
            <button type="submit" style="background: #137fec; color: white; padding: 0.75rem; width: 100%; border: none; border-radius: 0.5rem; font-weight: 600;">Simpan User</button>
            <button type="button" onclick="closeModal('modalTambahUser')" style="background: white; color: #64748b; padding: 0.75rem; width: 100%; border: 1px solid #cbd5e1; border-radius: 0.5rem; font-weight: 600; margin-top: 0.5rem;">Batal</button>
        </form>
    </div>
</div>
<div id="modalEditProfil" class="pegawai-modal">
    <div class="pegawai-modal-overlay" onclick="closeModal('modalEditProfil')"></div>
    <div class="pegawai-modal-content" style="max-height: 90vh; overflow-y: auto;">
        <h2>Edit Profil User</h2>
        <form action="crud/users/users_edit_aksi.php" method="post">
            <input type="hidden" name="id_user" id="profil_id_user">
            <input type="hidden" name="level" id="profil_level">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                <div>
                    <label class="form-group-label">Username Baru</label>
                    <input type="text" name="username" id="profil_username" required style="width: 100%; padding: 0.5rem; border: 1px solid #cbd5e1; border-radius: 0.375rem;">
                </div>
                <div>
                    <label class="form-group-label">Password Baru</label>
                    <input type="password" name="password" placeholder="(Kosongkan jika tidak diubah)" style="width: 100%; padding: 0.5rem; border: 1px solid #cbd5e1; border-radius: 0.375rem;">
                </div>
            </div>
            <div style="margin-bottom: 1rem;">
                <label class="form-group-label">Nama Lengkap</label>
                <input type="text" name="nama" id="profil_nama" required style="width: 100%; padding: 0.5rem; border: 1px solid #cbd5e1; border-radius: 0.375rem;">
            </div>
            <button type="submit" style="background: #3b82f6; color: white; padding: 0.75rem; width: 100%; border: none; border-radius: 0.5rem; font-weight: 600;">Update Profil</button>
            <button type="button" onclick="closeModal('modalEditProfil')" style="background: white; color: #64748b; padding: 0.75rem; width: 100%; border: 1px solid #cbd5e1; border-radius: 0.5rem; font-weight: 600; margin-top: 0.5rem;">Batal</button>
        </form>
    </div>
</div>
<div id="modalEdit" class="pegawai-modal">
    <div class="pegawai-modal-overlay" onclick="closeModal('modalEdit')"></div>
    <div class="pegawai-modal-content">
        <h2>Edit Role Pengguna</h2>
        <form action="crud/users/users_edit_role_aksi.php" method="post">
            <input type="hidden" name="id_user" id="edit_id_user">
            <input type="hidden" name="level_saat_ini" id="edit_level_saat_ini">
            <input type="hidden" name="has_pinjaman" id="edit_has_pinjaman">
            <div style="margin-bottom: 1rem;">
                <label class="form-group-label">Username</label>
                <input type="text" id="edit_username" disabled style="background: #f1f5f9; cursor: not-allowed;">
            </div>
            <div style="margin-bottom: 1rem;">
                <label class="form-group-label">Nama</label>
                <input type="text" id="edit_nama" disabled style="background: #f1f5f9; cursor: not-allowed;">
            </div>
            <div style="margin-bottom: 1rem;">
                <label class="form-group-label">Role Baru</label>
                <select name="role_baru" id="edit_role_baru" required>
                    <option value="anggota">Anggota</option>
                    <option value="petugas">Petugas</option>
                    <option value="admin">Admin</option>
                </select>
            </div>
            <div id="warningPinjaman" style="display: none; padding: 1rem; background: #fee2e2; border-left: 4px solid #ef4444; color: #b91c1c; margin-bottom: 1rem; font-size: 0.875rem;">
                <span class="material-icons" style="font-size: 1rem; vertical-align: middle;">error</span> 
                User ini tidak bisa diubah ke Petugas/Admin karena masih memiliki histori peminjaman buku.
            </div>
            <button type="submit" id="btnSubmitRole">Simpan Perubahan Role</button>
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
  document.getElementById('edit_id_user').value = data.id_user;
  document.getElementById('edit_level_saat_ini').value = data.level;
  document.getElementById('edit_has_pinjaman').value = data.has_pinjaman;
  document.getElementById('edit_username').value = data.username;
  document.getElementById('edit_nama').value = data.nama;
  // Set the current role
  let selectRole = document.getElementById('edit_role_baru');
  if (data.role_spesifik === 'admin') selectRole.value = 'admin';
  else if (data.role_spesifik === 'petugas') selectRole.value = 'petugas';
  else selectRole.value = 'anggota';
  // Handle warning logic
  const warning = document.getElementById('warningPinjaman');
  const btnSubmit = document.getElementById('btnSubmitRole');
  selectRole.onchange = function() {
      if (data.level === 'anggota' && (this.value === 'petugas' || this.value === 'admin')) {
          if (parseInt(data.has_pinjaman) > 0) {
              warning.style.display = 'block';
              btnSubmit.disabled = true;
              btnSubmit.style.opacity = '0.5';
              btnSubmit.style.cursor = 'not-allowed';
          } else {
              warning.style.display = 'none';
              btnSubmit.disabled = false;
              btnSubmit.style.opacity = '1';
              btnSubmit.style.cursor = 'pointer';
          }
      } else {
          warning.style.display = 'none';
          btnSubmit.disabled = false;
          btnSubmit.style.opacity = '1';
          btnSubmit.style.cursor = 'pointer';
      }
  };
  // trigger change to apply logic initially
  selectRole.onchange();
  openModal('modalEdit');
}
function openEditProfilModal(data) {
  document.getElementById('profil_id_user').value = data.id_user;
  document.getElementById('profil_level').value = data.level; // anggota/pegawai base level
  document.getElementById('profil_username').value = data.username;
  document.getElementById('profil_nama').value = data.nama;
  openModal('modalEditProfil');
}
</script>
</body>
</html>
