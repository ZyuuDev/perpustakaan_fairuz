<?php
session_start();
include '../../config/config.php';
include '../../config/auth_check.php';
check_access(['admin']);
if (isset($_GET['id'])) {
    $id_user = mysqli_real_escape_string($conn, $_GET['id']);
    if ($_SESSION['id_user'] == $id_user) {
        echo "<script>alert('Anda tidak bisa menghapus akun Anda sendiri yang sedang aktif!'); window.history.back();</script>";
        exit;
    }
    mysqli_begin_transaction($conn);
    try {
        $q_anggota = mysqli_query($conn, "SELECT ID_Anggota FROM anggota WHERE id_user='$id_user'");
        if (mysqli_num_rows($q_anggota) > 0) {
            $ang = mysqli_fetch_assoc($q_anggota);
            $id_anggota = $ang['ID_Anggota'];
            $cek_pinjam = mysqli_query($conn, "SELECT * FROM peminjaman WHERE ID_Anggota='$id_anggota'");
            if (mysqli_num_rows($cek_pinjam) > 0) {
                throw new Exception("Anggota masih memiliki histori peminjaman buku! Hapus histori terlebih dahulu.");
            }
        }
        mysqli_query($conn, "DELETE FROM anggota WHERE id_user='$id_user'");
        mysqli_query($conn, "DELETE FROM pegawai WHERE id_user='$id_user'");
        $delete_user = mysqli_query($conn, "DELETE FROM users WHERE id_user='$id_user'");
        if (!$delete_user) {
            throw new Exception(mysqli_error($conn));
        }
        mysqli_commit($conn);
        echo "<script>alert('Data user berhasil dihapus permanen!'); window.location.href='../../users.php';</script>";
    } catch (Exception $e) {
        mysqli_rollback($conn);
        $err = $e->getMessage();
        echo "<script>alert('Gagal menghapus user: $err'); window.history.back();</script>";
    }
} else {
    header("Location: ../../users.php");
}
?>
