<?php
session_start();
if (isset($_SESSION['login'])) {
    header("Location: dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html class="light" lang="id"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Register - Sistem Informasi Perpustakaan</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
<link rel="stylesheet" href="assets/styles/style.css">
<style>
    body {
        font-family: 'Inter', sans-serif;
    }
    .floating-label-input:placeholder-shown ~ label {
        transform: translateY(1.2rem) scale(1);
        color: #617589;
    }
    .floating-label-input:focus ~ label,
    .floating-label-input:not(:placeholder-shown) ~ label {
        transform: translateY(-0.5rem) scale(0.85);
        color: #137fec;
        background-color: white;
        padding: 0 4px;
    }
    .dark .floating-label-input:focus ~ label,
    .dark .floating-label-input:not(:placeholder-shown) ~ label {
        background-color: #1a242f;
    }
    .login-wrapper {
        min-height: 100vh;
        padding: 2rem 0;
    }
    .login-card {
        max-width: 500px;
    }
</style>
</head>
  <body class="login-body">
    <div class="login-wrapper">
      <div class="login-card">
        <div class="login-header">
          <div class="login-logo"><span class="material-symbols-outlined" style="font-size: inherit;">person_add</span></div>
          <h1 class="login-title">Registrasi Anggota Baru</h1>
          <p class="login-subtitle">Silakan lengkapi data diri Anda</p>
        </div>

      <form action="auth/register_aksi.php" class="login-form" method="POST">
          <div class="login-form-group">
            <input class="floating-label-input login-input" id="nama" name="nama" placeholder=" " type="text" required/>
            <label class="login-label" for="nama">Nama Lengkap</label>
          </div>

          <div class="login-form-group" style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
              <div style="position: relative;">
                <input class="floating-label-input login-input" id="username" name="username" placeholder=" " type="text" required/>
                <label class="login-label" for="username">Username (NIS)</label>
              </div>
              <div style="position: relative;">
                <input class="floating-label-input login-input" id="nis" name="nis" placeholder=" " type="text" required/>
                <label class="login-label" for="nis">NIP / NIS</label>
              </div>
          </div>

          <div class="login-form-group">
            <input id="password" name="password" type="password" placeholder=" " class="floating-label-input login-input with-icon" required/>
            <label for="password" class="login-label">Password (NISN)</label>
            <span id="togglePassword" class="material-symbols-outlined login-toggle-password">visibility</span>
          </div>

          <div class="login-form-group" style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
              <div style="position: relative;">
                <input class="floating-label-input login-input" id="nomor_hp" name="nomor_hp" placeholder=" " type="text" required/>
                <label class="login-label" for="nomor_hp">No HP</label>
              </div>
              <div style="position: relative;">
                <select class="floating-label-input login-input" id="gender" name="gender" required style="padding-top: 1.25rem; padding-bottom: 0.5rem;">
                    <option value="" disabled selected></option>
                    <option value="Laki-laki">Laki-laki</option>
                    <option value="Perempuan">Perempuan</option>
                </select>
                <label class="login-label" for="gender" style="transform: translateY(-0.5rem) scale(0.85); background: white; padding: 0 4px; color: #137fec;">Gender</label>
              </div>
          </div>

          <div class="login-form-group">
            <input class="floating-label-input login-input" id="alamat" name="alamat" placeholder=" " type="text" required/>
            <label class="login-label" for="alamat">Alamat Lengkap</label>
          </div>

        <button class="login-submit-btn" type="submit">Daftar Sekarang</button>
      </form>

      <div class="login-footer">
        <p>Sudah punya akun? <a class="login-forgot-link" href="index.php">Login di sini</a></p>
      </div>
    </div>
    
    <div class="login-copyright">© 2024 Sistem Informasi Perpustakaan. v2.4.0</div>
  </div>
  
  <div class="login-bg-decoration">
    <div class="login-bg-blob-1"></div>
    <div class="login-bg-blob-2"></div>
  </div>

<script>
const togglePassword = document.getElementById("togglePassword");
const passwordInput = document.getElementById("password");

togglePassword.addEventListener("click", () => {
    const type = passwordInput.getAttribute("type");
    if (type === "password") {
        passwordInput.setAttribute("type", "text");
        togglePassword.textContent = "visibility_off";
    } else {
        passwordInput.setAttribute("type", "password");
        togglePassword.textContent = "visibility";
    }
});
</script>
</body>
</html>
