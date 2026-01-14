<?php
include 'config.php';

$ID_Anggota = $_POST['ID_Anggota'];
$Nama   = $_POST['Nama'];
$NIS    = $_POST['NIS'];
$Alamat = $_POST['Alamat'];
$Nomor_HP  = $_POST['Nomor_HP'];

mysqli_query($conn, "
  INSERT INTO anggota (ID_Anggota, Nama, NIS, Alamat, Nomor_HP)
  VALUES ('$ID_Anggota', '$Nama', '$NIS', '$Alamat', '$Nomor_HP')
");

header("location:anggota.php");
