<?php
include 'config.php';

/* ambil data dari form */
$nip    = $_POST['nip'];
$nama   = $_POST['nama'];
$alamat = $_POST['alamat'];
$gender = $_POST['gender'];

/* query insert */
$query = mysqli_query($conn, "
    INSERT INTO pegawai (nip, nama, alamat, gender)
    VALUES ('$nip', '$nama', '$alamat', '$gender')
");

/* hasil */
if ($query) {
    header("location:pegawai.php");
} else {
    echo "Gagal menambahkan data pegawai 😭<br>";
    echo mysqli_error($koneksi);
}
