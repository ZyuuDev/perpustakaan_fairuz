<?php
include 'config.php';

// Menangkap data yang dikirim dari form
$nip = $_POST['nip'];
$nama = $_POST['nama'];
$alamat = $_POST['alamat'];
$gender = $_POST['gender'];

// Update data pegawai berdasarkan NIP
$query = mysqli_query($conn, "UPDATE pegawai SET nama='$nama', alamat='$alamat', gender='$gender' WHERE nip='$nip'");

if($query) {
    // Jika berhasil, balik ke halaman data pegawai
    header("location:pegawai.php");
} else {
    echo "Gagal mengupdate data: " . mysqli_error($conn);
}
?>