<?php
include 'config.php';
$id = $_GET['id'];

mysqli_query($conn, "DELETE FROM anggota WHERE ID_Anggota='$id'");
header("location:anggota.php");
?>