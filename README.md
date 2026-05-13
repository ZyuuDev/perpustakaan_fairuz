# Sistem Informasi Perpustakaan Digital

Aplikasi web modern berbasis PHP dan MySQL untuk mengelola operasional perpustakaan secara efisien dan tersentralisasi. Sistem ini memisahkan hak akses antara **Admin**, **Petugas**, dan **Anggota** (Peminjam), serta memiliki fitur keamanan dan manajemen relasional yang lengkap.

## 🌟 Fitur Utama

### 1. Manajemen Hak Akses (Role-Based Access) terpusat
- **Admin**: Akses penuh ke seluruh sistem CRUD (Buku, Pegawai, Anggota, Peminjaman, Data Users & Role).
- **Petugas**: Hanya bisa mengelola data Buku dan melayani proses Peminjaman/Pengembalian.
- **Anggota**: Hanya bisa melihat daftar buku yang tersedia dan riwayat peminjaman pribadinya.
- *Login Tersentralisasi:* Menggunakan satu tabel `users` utama untuk keamanan dan kemudahan pengelolaan sesi login. Anggota login menggunakan NIS (Username) dan NISN (Password), sedangkan Pegawai menggunakan Username & NIP.

### 2. Manajemen Pengguna Lanjutan
- **Registrasi Mandiri:** Fitur pendaftaran untuk anggota baru.
- **Kelola Role (Admin):** Admin dapat mengubah level akun (misalnya, Anggota yang dipromosikan menjadi Petugas).
- **Safe Role Transfer:** Mencegah terjadinya kerusakan database akibat perubahan role secara tiba-tiba (Mengeblok pemindahan anggota menjadi petugas apabila yang bersangkutan masih memiliki status peminjaman buku yang belum dikembalikan).

### 3. Manajemen Inventaris Buku
- Operasi CRUD dasar untuk data buku (ISBN, Judul, Pengarang, Penerbit, Tahun, Genre).
- **Tambah Stok Instan:** Fitur khusus Admin untuk menambah stok buku langsung tanpa masuk ke form edit kompleks.

### 4. Transaksi Peminjaman Otomatis
- Pencatatan peminjaman dan pengembalian otomatis berdasar tanggal.
- Pembuatan kode riwayat ID Peminjaman (misal A001, A002) otomatis secara _auto-increment_ dengan format kustom.
- Buku yang dipinjam akan otomatis mengurangi stok buku, dan akan bertambah kembali ketika buku dikembalikan.

## 🚀 Panduan Instalasi & Persiapan

1. **Persiapan Database:**
   - Siapkan database di phpMyAdmin (XAMPP/Laragon).
   - Import file `perpus_fairuz.sql` awal jika Anda baru memulai dari struktur lama.
2. **Setup Proyek:**
   - Clone/Copy seluruh file *repository* ini ke dalam folder lokal `htdocs` (XAMPP) atau `www` (Laragon).
   - Pastikan server Apache dan MySQL sudah berjalan.
3. **Konfigurasi Database:**
   - Sesuaikan *username* dan *password* database MySQL pada file `config/config.php`.
4. **MIGRASI DATABASE TERPUSAT (Penting):**
   - **Wajib Dijalankan Sekali!** Buka browser Anda dan akses skrip migrasi ini:
     `http://localhost/namafolder/migrate_users.php`
   - Ini bertujuan untuk membuat tabel `users` dan memindahkan semua kredensial login (anggota & pegawai) ke dalamnya.
   - Hapus file `migrate_users.php` setelah berhasil untuk menjaga keamanan.
5. **Jalankan Aplikasi:**
   - Akses aplikasi utama melalui: `http://localhost/namafolder/index.php`

## 🖥️ Tampilan Antarmuka

Aplikasi dirancang responsif dan estetik mengadopsi standar modern (Glassmorphism & Material Icons):
- Mendukung layar Mobile (Hamburger Menu slide-out).
- Navigasi khusus dan penyesuaian fungsional berdasar jenis sesi login.

<p align="center">
  <img src="https://i.ibb.co.com/8nw8Nh3R/Screenshot-2026-02-01-214742.png" alt="Preview Tampilan">
</p>

## 📞 Kontak & Dukungan

Jika Anda memiliki pertanyaan, menemui *error/bug*, atau memerlukan perbaikan masalah (*troubleshooting*), silakan hubungi pengembang utama di:
- **Email:** zyuudev@gmail.com
- **Instagram:** [@nndaaaaxy_](https://instagram.com/nndaaaaxy_)
