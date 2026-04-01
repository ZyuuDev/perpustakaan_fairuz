<?php
session_start();
include '../../config/config.php';
include '../../config/auth_check.php';
check_access(['admin', 'petugas']);

$id_peminjaman = $_POST['id_peminjaman'];
$id_anggota    = $_POST['id_anggota'];
$isbn          = $_POST['isbn'];
$tgl_pinjam    = $_POST['tgl_pinjam'];
$tgl_kembali   = $_POST['tgl_kembali'];

// Jika tgl_kembali kosong, set ke NULL untuk database
$val_tgl_kembali = !empty($tgl_kembali) ? "'$tgl_kembali'" : "NULL";

$query = mysqli_query($conn, "
    INSERT INTO peminjaman 
    (ID_Peminjaman, ID_Anggota, isbn, tgl_pinjam, tgl_kembali, status)
    VALUES
    ('$id_peminjaman', '$id_anggota', '$isbn', '$tgl_pinjam', $val_tgl_kembali, 'dipinjam')
");

if ($query) {
    header("location:../../peminjaman.php");
} else {
    echo "Gagal menyimpan data";
}
?>