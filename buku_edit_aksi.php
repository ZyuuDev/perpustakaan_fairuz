<?php
include 'config.php';
$id = $_POST['id'];
$judul = $_POST['judul'];
$pengarang = $_POST['pengarang'];
$penerbit = $_POST['penerbit'];
$tahun = $_POST['tahun'];
$genre = $_POST['genre'];

mysqli_query($conn, "UPDATE buku SET judul='$judul', pengarang='$pengarang', penerbit='$penerbit', tahun='$tahun', genre='$genre' WHERE isbn='$id'");
header("location:buku.php");
?>=