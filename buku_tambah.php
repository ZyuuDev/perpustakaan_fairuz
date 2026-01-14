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
    <h2>Tambah Buku</h2>
    <p>masukkan input buku baru dibawah ini</p>
        <form class="form-card" action="buku_tambah_aksi.php" method="post">
            <div class="form-group">
                <label>Masukkan ISBN</label>
                <input type="text" name="isbn" placeholder="Contoh: 9786020324787">
            </div>

            <div class="form-group">
                <label>Masukkan Judul</label>
                <input type="text" name="judul"  placeholder="Judul buku">
            </div>

            <div class="form-group">
                <label>Masukkan Pengarang</label>
                <input type="text" name="pengarang" placeholder="Nama pengarang">
            </div>

            <div class="form-group">
                <label>Masukkan Penerbit</label>
                <input type="text" name="penerbit" placeholder="Nama penerbit">
            </div>

            <div class="form-group">
                <label>Masukkan Tahun Terbit</label>
                <input type="text" name="tahun" placeholder="2024">
            </div>

            <div class="form-group">
                <label>Masukkan Genre Buku</label>
                <input type="text" name="genre"  placeholder="Fiksi / Non-Fiksi">
            </div>

        <button type="submit" class="btn-submit">Tambah Buku</button>
</form>

    </section>
    <footer>
    <p>&copy; 2025 Perpustakaan Digital | All Rights Reserved</p>
</footer>
</body>
</html>