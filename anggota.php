<?php include 'config.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Anggota</title>
    <link rel="stylesheet" href="styles/style.css">
</head>
<body>
    <nav>
        <div class="logo"> Perpustakaan</div>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="buku.php">Data Buku</a></li>
            <li><a href="pegawai.php">Data Pegawai</a></li>
            <li><a href="peminjaman.php">Data Peminjaman</a>
            <li><a href="anggota.php">Data Anggota</a> </li>
            <li><a href="login.php"><img src="assets/logout.png" alt="logout" width="20px" height="20px"></a></li>            
            <li>
        </ul>
    </nav>

<section class="content">
    <h2>🧍‍♂️ Data Anggota</h2>
    <table>
    <tr>
        <th>ID Anggota</th>
        <th>Nama</th>
        <th>NIS</th>
        <th>Alamat</th>
        <th>No. Telepon</th>
    </tr>
    <?php
      $result = mysqli_query($conn, "SELECT * FROM anggota");
    while($row = mysqli_fetch_assoc($result)) {
        echo "<tr>
                <td>{$row['ID_Anggota']}</td>
                <td>{$row['Nama']}</td>
                <td>{$row['NIS']}</td>
                <td>{$row['Alamat']}</td>
                <td>{$row['Nomor_HP']}</td>
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
