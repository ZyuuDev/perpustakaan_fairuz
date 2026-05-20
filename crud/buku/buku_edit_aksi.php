<?php
session_start();
include '../../config/config.php';
include '../../config/auth_check.php';
check_access(['admin']);
$id = mysqli_real_escape_string($conn, $_POST['id']);
$judul = mysqli_real_escape_string($conn, $_POST['judul']);
$pengarang = mysqli_real_escape_string($conn, $_POST['pengarang']);
$penerbit = mysqli_real_escape_string($conn, $_POST['penerbit']);
$tahun = (int)$_POST['tahun'];
$genre = mysqli_real_escape_string($conn, $_POST['genre']);
$stok = (int)$_POST['stok'];
$current_year = (int)date('Y');
if ($tahun > $current_year) {
    echo "<script>alert('Tahun terbit buku ($tahun) tidak boleh lebih dari tahun saat ini ($current_year)!'); window.history.back();</script>";
    exit;
}
mysqli_query($conn, "UPDATE buku SET judul='$judul', pengarang='$pengarang', penerbit='$penerbit', tahun='$tahun', genre='$genre', stok='$stok' WHERE isbn='$id'");
header("location:../../buku.php");
?>