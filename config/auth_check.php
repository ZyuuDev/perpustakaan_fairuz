<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
function check_access($allowed_levels = []) {
    if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
        header("Location: /tablebuku/index.php");
        exit;
    }
    if (!empty($allowed_levels) && !in_array($_SESSION['level'], $allowed_levels)) {
        echo "<script>
                alert('Anda tidak memiliki akses ke halaman ini!');
                window.location.href = '/tablebuku/dashboard.php';
              </script>";
        exit;
    }
}
function get_user_greeting() {
    $nama = $_SESSION['nama'] ?? 'User';
    $level = ucfirst($_SESSION['level'] ?? 'User');
    return "Halo $nama ($level)";
}
function get_current_nip() {
    return $_SESSION['nip'] ?? null;
}
function get_current_id_anggota() {
    return $_SESSION['id_anggota'] ?? null;
}
?>
