<?php
session_start();
include '../../config/config.php';
include '../../config/auth_check.php';
check_access(['admin']);
$isbn = mysqli_real_escape_string($conn, $_POST['isbn']);
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
mysqli_query($conn, "INSERT INTO buku (isbn, judul, pengarang, penerbit, tahun, genre, stok) VALUES('$isbn', '$judul', '$pengarang', '$penerbit', '$tahun', '$genre', '$stok')");
header("location:../../buku.php?pesan=inputberhasil");