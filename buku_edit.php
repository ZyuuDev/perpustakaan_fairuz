<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EDit Data BUku</title>
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
    <a href="buku.php">Lihat Semua Data Buku</a>

    <br>
    <h3>Edit Data Buku</h3>

    <?php
    include 'config.php';
    $id = $_GET['id'];

    $query_mysql = mysqli_query($conn,"SELECT * FROM buku WHERE isbn='$id'");
    while($data = mysqli_fetch_array($query_mysql)){
        ?>
        <form class="form-card" action="buku_edit_aksi.php" method="post">
            <table>
                <tr class="form-group">
                    <td>Judul</td>
                    <td>
                        <input type="hidden" name="id" value="<?php echo $data['isbn']?>">
                        <input type="text" name="judul" value="<?php echo $data['judul']; ?>">
                    </td>
                </tr>
                <tr class="form-group">
                    <td>Pengarang</td>
                    <td><input type="text" name="pengarang" value="<?php echo $data['pengarang']; ?>"></td>
                </tr>
                <tr class="form-group">
                    <td>Penerbit</td>
                    <td><input type="text" name="penerbit" value="<?php echo $data['penerbit']; ?>"></td>
                </tr>
                <tr class="form-group">
                    <td>Tahun Terbit</td>
                    <td><input type="text" name="tahun" value="<?php echo $data['tahun']; ?>"></td>
                </tr>
                <tr class="form-group">
                    <td>Genre Buku</td>
                    <td><input type="text" name="genre" value="<?php echo $data['genre']; ?>"></td>
                </tr>
                <tr>
                    <td></td>
                    <td><input type="submit" value="Simpan"></td>
                </tr>
            </table>
        </form>
    <?php } ?>
  </section>
    
</body>
</html>