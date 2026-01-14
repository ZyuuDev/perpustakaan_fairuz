<?php
include 'config.php';
$id = $_GET['id'];

mysqli_query($conn, "DELETE FROM pegawai WHERE nip='$id'");
header("location:pegawai.php");
?>