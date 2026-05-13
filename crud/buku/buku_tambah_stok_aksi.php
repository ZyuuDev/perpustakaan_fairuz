<?php
session_start();
include '../../config/config.php';
include '../../config/auth_check.php';
check_access(['admin']); // Hanya admin yang bisa tambah stok langsung

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $isbn = mysqli_real_escape_string($conn, $_POST['isbn']);
    $jumlah_tambah = (int)$_POST['jumlah_tambah'];

    if ($jumlah_tambah > 0) {
        // Query to update the stock
        $query = "UPDATE buku SET stok = stok + $jumlah_tambah WHERE isbn = '$isbn'";
        
        if (mysqli_query($conn, $query)) {
            echo "<script>
                alert('Stok buku berhasil ditambahkan!');
                window.location.href = '../../buku.php';
            </script>";
        } else {
            echo "<script>
                alert('Gagal menambahkan stok: " . mysqli_error($conn) . "');
                window.history.back();
            </script>";
        }
    } else {
        echo "<script>
            alert('Jumlah stok yang ditambahkan harus lebih dari 0!');
            window.history.back();
        </script>";
    }
} else {
    header("Location: ../../buku.php");
    exit;
}
?>
