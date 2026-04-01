<?php
session_start();
include '../../config/config.php';
include '../../config/auth_check.php';
check_access(['admin']);

// Menangkap data dari form
$id_anggota = $_POST['id'];
$nama       = $_POST['nama'];
$nis        = $_POST['nis'];
$alamat     = $_POST['alamat'];
$nomor_hp   = $_POST['nomor_hp'];

// Update database (pastikan nama kolom sesuai gambar: ID_Anggota, Nama, NIS, Alamat, Nomor_HP)
$query = mysqli_query($conn, "UPDATE anggota SET 
    Nama='$nama', 
    NIS='$nis', 
    Alamat='$alamat', 
    Nomor_HP='$nomor_hp' 
    WHERE ID_Anggota='$id_anggota'");

if($query) {
    header("location:../../anggota.php");
} else {
    echo "Gagal mengupdate data anggota: " . mysqli_error($conn);
}
?>