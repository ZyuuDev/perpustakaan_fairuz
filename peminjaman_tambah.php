<?php
include 'config.php';

/* ambil data anggota */
$dataAnggota = mysqli_query($conn, "SELECT ID_Anggota, nama FROM anggota");

/* ambil data buku */
$dataBuku = mysqli_query($conn, "SELECT isbn, judul FROM buku");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Peminjaman</title>
    <link rel="stylesheet" href="styles/style.css">
</head>
<body>
<nav>
    <div class="logo">📚 Perpustakaan</div>
    <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="buku.php">Data Buku</a></li>
        <li><a href="pegawai.php">Data Pegawai</a></li>
        <li><a href="peminjaman.php">Data Peminjaman</a></li>
        <li><a href="anggota.php">Data Anggota</a></li>
        <li><a href="login.php"><img src="assets/logout.png" alt="logout" width="20px" height="20px"></a></li>
    </ul>
  </nav>
<section class="content">
    <h2>Tambah Data Peminjaman</h2>

    <form class="form-card" action="peminjaman_tambah_aksi.php" method="post">

        <!-- ID PEMINJAMAN -->
        <div class="form-group">
            <label>ID Peminjaman</label>
            <input type="text" name="ID_Peminjaman" placeholder="P001" required>
        </div>

        <!-- PILIH ANGGOTA -->
        <div class="form-group">
            <label>Pilih Anggota</label>
            <select name="ID_Anggota" required>
                <option value="">-- Pilih Anggota --</option>
                <?php while ($a = mysqli_fetch_assoc($dataAnggota)) { ?>
                    <option value="<?= $a['ID_Anggota']; ?>">
                        <?= $a['ID_Anggota']; ?> - <?= $a['nama']; ?>
                    </option>
                <?php } ?>
            </select>
        </div>

        <!-- PILIH BUKU -->
        <div class="form-group">
            <label>Pilih Buku</label>
            <select name="isbn" required>
                <option value="">-- Pilih Buku --</option>
                <?php while ($b = mysqli_fetch_assoc($dataBuku)) { ?>
                    <option value="<?= $b['isbn']; ?>">
                        <?= $b['isbn']; ?> - <?= $b['judul']; ?>
                    </option>
                <?php } ?>
            </select>
        </div>

        <!-- TANGGAL -->
        <div class="form-group">
            <label>Tanggal Pinjam</label>
            <input type="date" name="tgl_pinjam" required>
        </div>

        <div class="form-group">
            <label>Tanggal Kembali</label>
            <input type="date" name="tgl_kembali" required>
        </div>

        <button type="submit" class="btn-submit">Simpan</button>
    </form>
</section>
<footer>
    <p>&copy; 2025 Perpustakaan Digital | All Rights Reserved</p>
</footer>
</body>
</html>
