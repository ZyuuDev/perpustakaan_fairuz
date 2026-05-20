<?php
session_start();
include '../../config/config.php';
include '../../config/auth_check.php';
check_access(['admin', 'petugas']);
$id_peminjaman = $_POST['id_peminjaman'];
$id_anggota    = $_POST['id_anggota'];
$isbn          = $_POST['isbn'];
$tgl_pinjam    = $_POST['tgl_pinjam'];
$nip_petugas   = $_SESSION['nip']; 
$status        = 'dipinjam';
$cek_stok = mysqli_query($conn, "SELECT stok FROM buku WHERE isbn = '$isbn'");
$data_buku = mysqli_fetch_assoc($cek_stok);
if ($data_buku['stok'] <= 0) {
    echo "<script>
        alert('Stok buku habis! Tidak bisa meminjam.');
        window.location.href = '../../peminjaman.php';
    </script>";
    exit;
}
$query = "INSERT INTO peminjaman 
          (ID_Peminjaman, ID_Anggota, isbn, nip_petugas, tgl_pinjam, status)
          VALUES
          ('$id_peminjaman', '$id_anggota', '$isbn', '$nip_petugas', '$tgl_pinjam', '$status')";
if (mysqli_query($conn, $query)) {
    mysqli_query($conn, "UPDATE buku SET stok = stok - 1 WHERE isbn = '$isbn'");
    header("Location: ../../peminjaman.php");
    exit;
} else {
    echo "Gagal menyimpan peminjaman: " . mysqli_error($conn);
}
?>
