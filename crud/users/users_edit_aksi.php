<?php
session_start();
include '../../config/config.php';
include '../../config/auth_check.php';
check_access(['admin']);
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_user = mysqli_real_escape_string($conn, $_POST['id_user']);
    $level = mysqli_real_escape_string($conn, $_POST['level']); 
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']); 
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $cek = mysqli_query($conn, "SELECT * FROM users WHERE username='$username' AND id_user != '$id_user'");
    if (mysqli_num_rows($cek) > 0) {
        echo "<script>alert('Username sudah terdaftar untuk user lain!'); window.history.back();</script>";
        exit;
    }
    mysqli_begin_transaction($conn);
    try {
        if (!empty($password)) {
            mysqli_query($conn, "UPDATE users SET username='$username', password='$password' WHERE id_user='$id_user'");
        } else {
            mysqli_query($conn, "UPDATE users SET username='$username' WHERE id_user='$id_user'");
        }
        if ($level == 'anggota') {
            if (!empty($password)) {
                mysqli_query($conn, "UPDATE anggota SET Nama='$nama', NIS='$username', nisn='$password' WHERE id_user='$id_user'");
            } else {
                mysqli_query($conn, "UPDATE anggota SET Nama='$nama', NIS='$username' WHERE id_user='$id_user'");
            }
        } else { 
            if (!empty($password)) {
                mysqli_query($conn, "UPDATE pegawai SET nama='$nama', username='$username', nip='$password' WHERE id_user='$id_user'");
            } else {
                mysqli_query($conn, "UPDATE pegawai SET nama='$nama', username='$username' WHERE id_user='$id_user'");
            }
        }
        mysqli_commit($conn);
        echo "<script>alert('Profil user berhasil diupdate!'); window.location.href='../../users.php';</script>";
    } catch (Exception $e) {
        mysqli_rollback($conn);
        $err = $e->getMessage();
        echo "<script>alert('Gagal update profil: $err'); window.history.back();</script>";
    }
}
?>
