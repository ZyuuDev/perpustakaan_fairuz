<?php
session_start();
include '../../config/config.php';
include '../../config/auth_check.php';
check_access(['admin']);
$id = $_GET['id'];
mysqli_query($conn, "DELETE FROM anggota WHERE ID_Anggota='$id'");
header("location:../../anggota.php");
?>