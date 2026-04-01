<?php
session_start();
include '../config/config.php';

$username = $_POST['username'];
$password = $_POST['password'];

$query = mysqli_query(
    $conn,
    "SELECT * FROM user 
    WHERE username='$username' AND password='$password'"
);

$data = mysqli_fetch_assoc($query);
$cek = mysqli_num_rows($query);

if ($cek > 0) {
    $_SESSION['login'] = true;
    $_SESSION['id_user'] = $data['id_user'];
    $_SESSION['nama'] = $data['nama'];
    $_SESSION['level'] = $data['level'];

    // redirect sesuai role
    if ($data['level'] == 'admin') {
        header("Location: ../dashboard.php");
    } elseif ($data['level'] == 'petugas') {
        header("Location: ../dashboard.php");
    } elseif ($data['level'] == 'peminjam') {
        header("Location: ../dashboard.php");
    }

} else {
    header("Location: login.php?error=1");
}
?>
