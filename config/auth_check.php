<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Check if user is logged in and has the required level
 * @param array $allowed_levels List of allowed levels, e.g., ['admin', 'petugas']
 */
function check_access($allowed_levels = []) {
    if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
        header("Location: /tablebuku/index.php");
        exit;
    }

    if (!empty($allowed_levels) && !in_array($_SESSION['level'], $allowed_levels)) {
        // Unauthorized access
        echo "<script>
                alert('Anda tidak memiliki akses ke halaman ini!');
                window.location.href = '/tablebuku/dashboard.php';
              </script>";
        exit;
    }
}

/**
 * Get display name/role for greeting
 */
function get_user_greeting() {
    $nama = $_SESSION['nama'] ?? 'User';
    $level = ucfirst($_SESSION['level'] ?? 'User');
    return "Halo $nama ($level)";
}
?>
