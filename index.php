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
<title>Login - Sistem Informasi Perpustakaan</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<link rel="stylesheet" href="assets/styles/style.css">
<style>
    body {
        font-family: 'Inter', sans-serif;
    }
    /* Custom floating label animation logic via peer classes */
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
</style>
</head>
  <body class="login-body">
    <div class="login-wrapper">
    <!-- Main Login Card -->
      <div class="login-card">
      <!-- Logo and Header -->
        <div class="login-header">
          <div class="login-logo"><span class="material-symbols-outlined" style="font-size: inherit;">auto_stories</span></div>
          <h1 class="login-title">
                    Sistem Informasi Perpustakaan
                </h1>
<p class="login-subtitle">
                    Pegawai: Username + NIP | Anggota: NIS + NISN
                </p>
        </div>
        <!-- Login Form -->
      <form action="auth/login_aksi.php" class="login-form" method="POST">
      <!-- Username Field -->
          <div class="login-form-group">
            <input class="floating-label-input login-input" id="username" name="username" placeholder=" " type="text"/>
<label class="login-label" for="username">
                        Username / NIS
                    </label>
</div>
<!-- Password Field -->
<div class="login-form-group">
    <input
        id="password"
        name="password"
        type="password"
        placeholder=" "
        class="floating-label-input login-input with-icon"
    />

    <label for="password" class="login-label">
        NIP / NISN
    </label>

    <!-- ICON MATA -->
    <span
        id="togglePassword"
        class="material-symbols-outlined login-toggle-password">
        visibility
    </span>
</div>

<!-- Remember Me & Forgot Password -->
<div class="login-remember-row">
<label class="login-remember-label">
<input class="login-checkbox" type="checkbox"/>
<span class="login-remember-text">Ingat saya</span>
</label>
<a class="login-forgot-link" href="#">Lupa Password?</a>
</div>
<!-- Submit Button -->
<button class="login-submit-btn" type="submit">
                    Masuk ke Sistem
                </button>
</form>
<!-- Footer Links -->
<div class="login-footer">
<p>
                    Butuh bantuan? <a class="login-forgot-link" href="#">Hubungi Admin</a>
</p>
</div>
</div>
<!-- Copyright Footer -->
<div class="login-copyright">
            © 2024 Sistem Informasi Perpustakaan. v2.4.0
        </div>
</div>
<!-- Background Decoration -->
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