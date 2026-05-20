<?php
session_start();
include '../../config/config.php';
include '../../config/auth_check.php';
check_access(['admin']);
$nip_lama = $_POST['nip_lama'];
$nip_baru = $_POST['nip'];
$username = $_POST['username'];
$nama     = $_POST['nama'];
$alamat   = $_POST['alamat'];
$gender   = $_POST['gender'];
$level    = $_POST['level'];
$query = mysqli_query($conn, "UPDATE pegawai SET nip='$nip_baru', username='$username', nama='$nama', alamat='$alamat', gender='$gender', level='$level' WHERE nip='$nip_lama'");
if($query) {
    header("location:../../pegawai.php");
} else {
    echo "Gagal mengupdate data: " . mysqli_error($conn);
}
?>