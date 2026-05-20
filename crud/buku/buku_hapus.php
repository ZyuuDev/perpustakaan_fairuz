<?php
session_start();
include '../../config/config.php';
include '../../config/auth_check.php';
check_access(['admin']);
$id = $_GET['id'];
mysqli_query($conn, "DELETE FROM buku WHERE isbn='$id'");
header("location:../../buku.php");
?>