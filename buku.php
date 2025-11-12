<?php include 'config.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Data Buku</title>
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
    <h2>📘 Data Buku Yang Tersedia</h2>
    <table>
    <tr>
        <th>ISBN</th>
        <th>Judul</th>
        <th>Pengarang</th>
        <th>Penerbit</th>
        <th>Tahun Terbit</th>
        <th>Genre Buku</th>
    </tr>
        <?php
        $result = mysqli_query($conn, "SELECT * FROM buku");
        while($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                    <td>{$row['isbn']}</td>
                    <td>{$row['judul']}</td>
                    <td>{$row['pengarang']}</td>
                    <td>{$row['penerbit']}</td>
                    <td>{$row['tahun']}</td>
                    <td>{$row['genre']}</td>
                    </tr>";
        }
        ?>
        </table>
    </section>
    <footer>
    <p>&copy; 2025 Perpustakaan Digital | All Rights Reserved</p>
</footer>

</body>
</html>
