<?php
include 'config.php';

$ID_Peminjaman = $_POST['ID_Peminjaman'];
$ID_Anggota    = $_POST['ID_Anggota'];
$isbn          = $_POST['isbn'];
$tgl_pinjam    = $_POST['tgl_pinjam'];
$tgl_kembali   = $_POST['tgl_kembali'];

$query = mysqli_query($conn, "
    INSERT INTO peminjaman 
    (ID_Peminjaman, ID_Anggota, isbn, tgl_pinjam, tgl_kembali)
    VALUES
    ('$ID_Peminjaman', '$ID_Anggota', '$isbn', '$tgl_pinjam', '$tgl_kembali')
");

if ($query) {
    header("location:peminjaman.php");
} else {
    echo "Gagal menyimpan data 😭";
}
