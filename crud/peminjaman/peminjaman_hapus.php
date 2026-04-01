<?php
session_start();
include '../../config/config.php';
include '../../config/auth_check.php';
check_access(['admin', 'petugas']);
$id = $_GET['id'];
mysqli_query($conn, "DELETE FROM peminjaman WHERE ID_Peminjaman='$id'");
header("location:../../peminjaman.php");
?>
