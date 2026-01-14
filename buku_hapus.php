<?php
include 'config.php';
$id = $_GET['id'];

mysqli_query($conn, "DELETE FROM buku WHERE isbn='$id'");
header("location:buku.php");
?>