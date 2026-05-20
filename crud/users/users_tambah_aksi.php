<?php
session_start();
include '../../config/config.php';
include '../../config/auth_check.php';
check_access(['admin']);
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $role = mysqli_real_escape_string($conn, $_POST['role']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $nomor_hp = mysqli_real_escape_string($conn, $_POST['nomor_hp']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);
    $cek = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");
    if (mysqli_num_rows($cek) > 0) {
        echo "<script>alert('Username sudah terdaftar!'); window.history.back();</script>";
        exit;
    }
    $level_users = ($role == 'anggota') ? 'anggota' : 'pegawai';
    mysqli_begin_transaction($conn);
    try {
        mysqli_query($conn, "INSERT INTO users (username, password, level) VALUES ('$username', '$password', '$level_users')");
        $id_user = mysqli_insert_id($conn);
        if ($level_users == 'anggota') {
            $query_id = mysqli_query($conn, "SELECT MAX(CAST(SUBSTRING(ID_Anggota, 3) AS UNSIGNED)) as max_id FROM anggota");
            $data_id = mysqli_fetch_assoc($query_id);
            $next_id = "AG" . str_pad($data_id['max_id'] + 1, 3, "0", STR_PAD_LEFT);
            mysqli_query($conn, "INSERT INTO anggota (ID_Anggota, Nama, NIS, nisn, Alamat, Nomor_HP, id_user, gender) 
                                 VALUES ('$next_id', '$nama', '$username', '$password', '$alamat', '$nomor_hp', '$id_user', '$gender')");
        } else {
            mysqli_query($conn, "INSERT INTO pegawai (nip, username, nama, alamat, gender, level, id_user, nomor_hp) 
                                 VALUES ('$password', '$username', '$nama', '$alamat', '$gender', '$role', '$id_user', '$nomor_hp')");
        }
        mysqli_commit($conn);
        echo "<script>alert('User berhasil ditambahkan!'); window.location.href='../../users.php';</script>";
    } catch (Exception $e) {
        mysqli_rollback($conn);
        $err = $e->getMessage();
        echo "<script>alert('Gagal menambahkan user: $err'); window.history.back();</script>";
    }
}
?>
