<?php
session_start();
include '../config/config.php';
$nama = mysqli_real_escape_string($conn, $_POST['nama']);
$username = mysqli_real_escape_string($conn, $_POST['username']);
$nis = mysqli_real_escape_string($conn, $_POST['nis']);
$password = mysqli_real_escape_string($conn, $_POST['password']); 
$nomor_hp = mysqli_real_escape_string($conn, $_POST['nomor_hp']);
$gender = mysqli_real_escape_string($conn, $_POST['gender']);
$alamat = mysqli_real_escape_string($conn, $_POST['alamat']);
$cek_user = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");
if (mysqli_num_rows($cek_user) > 0) {
    echo "<script>
        alert('Username (NIS) sudah terdaftar!');
        window.history.back();
    </script>";
    exit;
}
$query_id = mysqli_query($conn, "SELECT MAX(CAST(SUBSTRING(ID_Anggota, 3) AS UNSIGNED)) as max_id FROM anggota");
$data_id = mysqli_fetch_assoc($query_id);
$max_id = $data_id['max_id'];
$next_id = "AG" . str_pad($max_id + 1, 3, "0", STR_PAD_LEFT);
mysqli_begin_transaction($conn);
try {
    $sql_user = "INSERT INTO users (username, password, level) VALUES ('$username', '$password', 'anggota')";
    mysqli_query($conn, $sql_user);
    $id_user = mysqli_insert_id($conn);
    $sql_anggota = "INSERT INTO anggota (ID_Anggota, Nama, NIS, nisn, Alamat, Nomor_HP, id_user, gender) 
                    VALUES ('$next_id', '$nama', '$nis', '$password', '$alamat', '$nomor_hp', $id_user, '$gender')";
    mysqli_query($conn, $sql_anggota);
    mysqli_commit($conn);
    echo "<script>
        alert('Registrasi berhasil! Silakan login.');
        window.location.href = '../index.php';
    </script>";
} catch (Exception $e) {
    mysqli_rollback($conn);
    echo "<script>
        alert('Terjadi kesalahan saat registrasi. Coba lagi.');
        window.history.back();
    </script>";
}
?>
