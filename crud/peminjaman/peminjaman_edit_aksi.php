<?php
session_start();
include '../../config/config.php';
include '../../config/auth_check.php';
check_access(['admin', 'petugas']);

$id_peminjaman = $_POST['id_peminjaman'];
$tgl_kembali   = $_POST['tgl_kembali'];

// Update tgl_kembali dan ubah status menjadi dikembalikan
$query = mysqli_query($conn, "
    UPDATE peminjaman 
    SET tgl_kembali = '$tgl_kembali', status = 'dikembalikan' 
    WHERE ID_Peminjaman = '$id_peminjaman'
");

if ($query) {
    header("location:../../peminjaman.php");
} else {
    echo "Gagal mengupdate pengembalian: " . mysqli_error($conn);
}
?>
