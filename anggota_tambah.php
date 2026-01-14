<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
    <h2>Tambah Anggota Perpustakaan</h2>
    <p>masukkan input anggota baru dibawah ini</p>
        <form class="form-card" action="anggota_tambah_aksi.php" method="post">
            <div class="form-group">
                <label>Masukkan ID Anggota</label>
                <input type="text" name="ID_Anggota" placeholder="Contoh: A001">
            </div>

            <div class="form-group">
                <label>Masukkan Nama</label>
                <input type="text" name="Nama"  placeholder="Arrasyd Nanda">
            </div>

            <div class="form-group">
                <label>Masukkan NIS</label>
                <input type="text" name="NIS" placeholder="Nama pengarang">
            </div>

            <div class="form-group">
                <label>Masukkan Alamat</label>
                <input type="text" name="Alamat" placeholder="Bantul, Yogyakartat">
            </div>

            <div class="form-group">
                <label>NO HP</label>
                <input type="text" name="Nomor_HP" placeholder="089187654321">
            </div>

        <button type="submit" class="btn-submit">Tambah Buku</button>
</form>

    </section>
    <footer>
    <p>&copy; 2025 Perpustakaan Digital | All Rights Reserved</p>
</footer>
</body>
</html>