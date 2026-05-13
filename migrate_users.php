<?php
include 'config/config.php';

// 1. Create users table
$sql_create_users = "
CREATE TABLE IF NOT EXISTS users (
    id_user INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    level ENUM('anggota', 'pegawai') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
";

if (mysqli_query($conn, $sql_create_users)) {
    echo "Tabel users berhasil dibuat atau sudah ada.<br>";
} else {
    echo "Gagal membuat tabel users: " . mysqli_error($conn) . "<br>";
}

// 2. Alter anggota table
$sql_alter_anggota = "
ALTER TABLE anggota 
ADD COLUMN id_user INT NULL,
ADD COLUMN gender ENUM('Laki-laki', 'Perempuan') DEFAULT 'Laki-laki';
";
if (mysqli_query($conn, $sql_alter_anggota)) {
    echo "Kolom id_user dan gender berhasil ditambahkan ke tabel anggota.<br>";
} else {
    echo "Gagal alter tabel anggota (mungkin kolom sudah ada): " . mysqli_error($conn) . "<br>";
}

// 3. Alter pegawai table
$sql_alter_pegawai = "
ALTER TABLE pegawai 
ADD COLUMN id_user INT NULL,
ADD COLUMN nomor_hp VARCHAR(20) NULL;
";
if (mysqli_query($conn, $sql_alter_pegawai)) {
    echo "Kolom id_user dan nomor_hp berhasil ditambahkan ke tabel pegawai.<br>";
} else {
    echo "Gagal alter tabel pegawai (mungkin kolom sudah ada): " . mysqli_error($conn) . "<br>";
}

// 4. Migrate existing pegawai
$q_pegawai = mysqli_query($conn, "SELECT * FROM pegawai WHERE id_user IS NULL");
if ($q_pegawai) {
    while ($row = mysqli_fetch_assoc($q_pegawai)) {
        $username = mysqli_real_escape_string($conn, $row['username']);
        $password = mysqli_real_escape_string($conn, $row['nip']); // Password is NIP
        $nip = $row['nip'];
        
        $insert_user = "INSERT INTO users (username, password, level) VALUES ('$username', '$password', 'pegawai')";
        if (mysqli_query($conn, $insert_user)) {
            $last_id = mysqli_insert_id($conn);
            mysqli_query($conn, "UPDATE pegawai SET id_user = $last_id WHERE nip = '$nip'");
            echo "Pegawai $username berhasil dimigrasi.<br>";
        } else {
            echo "Gagal migrasi pegawai $username: " . mysqli_error($conn) . "<br>";
        }
    }
}

// 5. Migrate existing anggota
$q_anggota = mysqli_query($conn, "SELECT * FROM anggota WHERE id_user IS NULL");
if ($q_anggota) {
    while ($row = mysqli_fetch_assoc($q_anggota)) {
        $username = mysqli_real_escape_string($conn, $row['NIS']);
        $password = mysqli_real_escape_string($conn, $row['nisn']); // Password is NISN
        $id_anggota = $row['ID_Anggota'];
        
        $insert_user = "INSERT INTO users (username, password, level) VALUES ('$username', '$password', 'anggota')";
        if (mysqli_query($conn, $insert_user)) {
            $last_id = mysqli_insert_id($conn);
            mysqli_query($conn, "UPDATE anggota SET id_user = $last_id WHERE ID_Anggota = '$id_anggota'");
            echo "Anggota $username berhasil dimigrasi.<br>";
        } else {
            echo "Gagal migrasi anggota $username: " . mysqli_error($conn) . "<br>";
        }
    }
}

// 6. Add Foreign Key constraints (Optional but good for integrity)
$sql_fk_anggota = "ALTER TABLE anggota ADD CONSTRAINT fk_anggota_user FOREIGN KEY (id_user) REFERENCES users(id_user) ON DELETE CASCADE";
$sql_fk_pegawai = "ALTER TABLE pegawai ADD CONSTRAINT fk_pegawai_user FOREIGN KEY (id_user) REFERENCES users(id_user) ON DELETE CASCADE";
mysqli_query($conn, $sql_fk_anggota);
mysqli_query($conn, $sql_fk_pegawai);

echo "<h2>Migrasi Selesai!</h2>";
?>
