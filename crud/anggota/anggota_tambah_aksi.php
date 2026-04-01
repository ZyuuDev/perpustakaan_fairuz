<?php
session_start();
include '../../config/config.php';
include '../../config/auth_check.php';
check_access(['admin']);

$id_anggota = $_POST['id_anggota'];
$nama   = $_POST['nama'];
$nis    = $_POST['nis'];
$alamat = $_POST['alamat'];
$nomor_hp  = $_POST['nomor_hp'];

mysqli_query($conn, "
  INSERT INTO anggota (ID_Anggota, Nama, NIS, Alamat, Nomor_HP)
  VALUES ('$id_anggota', '$nama', '$nis', '$alamat', '$nomor_hp')
");

header("location:../../anggota.php");
