<?php
session_start();
include '../../config/config.php';
include '../../config/auth_check.php';
check_access(['admin']);

$isbn = $_POST['isbn'];
$judul = $_POST['judul'];
$pengarang = $_POST['pengarang'];
$penerbit = $_POST['penerbit'];
$tahun = $_POST['tahun'];
$genre = $_POST['genre'];

mysqli_query($conn, "INSERT INTO buku VALUES('$isbn', '$judul', '$pengarang', '$penerbit', '$tahun', '$genre')");

header("location:../../buku.php?pesan=inputberhasil");