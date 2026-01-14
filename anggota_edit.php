<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Data Anggota</title>
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
        <a href="anggota.php">Lihat Semua Data Anggota</a>
        <br>
        <h3>Edit Data Anggota</h3>

        <?php
        include 'config.php';
        $id = $_GET['id'];
        $query_mysql = mysqli_query($conn, "SELECT * FROM anggota WHERE ID_Anggota='$id'");
        while($data = mysqli_fetch_array($query_mysql)){
        ?>
            <form class="form-card" action="anggota_edit_aksi.php" method="post">
                <table>
                    <tr class="form-group">
                        <td>Nama Anggota</td>
                        <td>
                            <input type="hidden" name="id_anggota" value="<?php echo $data['ID_Anggota']?>">
                            <input type="text" name="nama" value="<?php echo $data['Nama']; ?>" required>
                        </td>
                    </tr>
                    <tr class="form-group">
                        <td>NIS</td>
                        <td><input type="text" name="nis" value="<?php echo $data['NIS']; ?>" required></td>
                    </tr>
                    <tr class="form-group">
                        <td>Alamat</td>
                        <td><input type="text" name="alamat" value="<?php echo $data['Alamat']; ?>" required></td>
                    </tr>
                    <tr class="form-group">
                        <td>Nomor HP</td>
                        <td><input type="text" name="nomor_hp" value="<?php echo $data['Nomor_HP']; ?>" required></td>
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