<?php
session_start();
include '../../config/config.php';
include '../../config/auth_check.php';
check_access(['admin']);

/* ambil data dari form */
$nip      = $_POST['nip'];
$username = $_POST['username'];
$nama     = $_POST['nama'];
$alamat   = $_POST['alamat'];
$gender   = $_POST['gender'];
$level    = $_POST['level'];

/* query insert */
$query = mysqli_query($conn, "
    INSERT INTO pegawai (nip, username, nama, alamat, gender, level)
    VALUES ('$nip', '$username', '$nama', '$alamat', '$gender', '$level')
");

/* hasil */
if ($query) {
    header("location:../../pegawai.php");
} else {
    echo "Gagal menambahkan data pegawai.<br>";
    echo mysqli_error($conn);
}
