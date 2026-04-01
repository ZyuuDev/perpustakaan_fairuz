<?php
session_start();
include '../../config/config.php';
include '../../config/auth_check.php';
check_access(['admin']);

// Menangkap data yang dikirim dari form
$nip_lama = $_POST['nip_lama'];
$nip_baru = $_POST['nip'];
$nama = $_POST['nama'];
$alamat = $_POST['alamat'];
$gender = $_POST['gender'];

// Update data pegawai berdasarkan NIP lama
$query = mysqli_query($conn, "UPDATE pegawai SET nip='$nip_baru', nama='$nama', alamat='$alamat', gender='$gender' WHERE nip='$nip_lama'");

if($query) {
    // Jika berhasil, balik ke halaman data pegawai
    header("location:../../pegawai.php");
} else {
    echo "Gagal mengupdate data: " . mysqli_error($conn);
}
?>