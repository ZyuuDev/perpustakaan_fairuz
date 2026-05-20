<?php
session_start();
include '../../config/config.php';
include '../../config/auth_check.php';
check_access(['admin', 'petugas']);
$id_peminjaman = $_POST['id_peminjaman'];
$tgl_kembali   = date('Y-m-d');
$data_pinjam = mysqli_query($conn, "SELECT isbn FROM peminjaman WHERE ID_Peminjaman = '$id_peminjaman'");
$row_pinjam = mysqli_fetch_assoc($data_pinjam);
$update = mysqli_query($conn, "UPDATE peminjaman SET status = 'dikembalikan', tgl_kembali = '$tgl_kembali' WHERE ID_Peminjaman = '$id_peminjaman'");
if ($update) {
    mysqli_query($conn, "UPDATE buku SET stok = stok + 1 WHERE isbn = '{$row_pinjam['isbn']}'");
}
header("Location: ../../peminjaman.php");
exit;
?>
