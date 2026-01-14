<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Pegawai</title>
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
        <a href="pegawai.php">Lihat Semua Data Pegawai</a>
        <br>
        <h3>Edit Data Pegawai</h3>

        <?php
        include 'config.php';
        // Mengambil NIP dari URL
        $id = $_GET['id'];

        $query_mysql = mysqli_query($conn, "SELECT * FROM pegawai WHERE nip='$id'");
        while($data = mysqli_fetch_array($query_mysql)){
        ?>
            <form class="form-card" action="pegawai_edit_aksi.php" method="post">
                <table>
                    <tr class="form-group">
                        <td>Nama</td>
                        <td>
                            <input type="hidden" name="nip" value="<?php echo $data['nip']?>">
                            <input type="text" name="nama" value="<?php echo $data['nama']; ?>" required>
                        </td>
                    </tr>
                    <tr class="form-group">
                        <td>Alamat</td>
                        <td><input type="text" name="alamat" value="<?php echo $data['alamat']; ?>" required></td>
                    </tr>
                    <tr class="form-group">
                        <td>Gender</td>
                        <td>
                            <select name="gender">
                                <option value="Laki-laki" <?php if($data['gender'] == 'Laki-laki') echo 'selected'; ?>>Laki-laki</option>
                                <option value="Perempuan" <?php if($data['gender'] == 'Perempuan') echo 'selected'; ?>>Perempuan</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><input type="submit" value="Simpan Perubahan"></td>
                    </tr>
                </table>
            </form>
        <?php } ?>
    </section>
</body>
</html>