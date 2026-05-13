<?php
session_start();
include '../../config/config.php';
include '../../config/auth_check.php';
check_access(['admin']);

$id_user = mysqli_real_escape_string($conn, $_POST['id_user']);
$level_saat_ini = mysqli_real_escape_string($conn, $_POST['level_saat_ini']); // 'anggota' atau 'pegawai'
$role_baru = mysqli_real_escape_string($conn, $_POST['role_baru']); // 'anggota', 'petugas', atau 'admin'

$target_level = ($role_baru == 'anggota') ? 'anggota' : 'pegawai';

// Begin Transaction
mysqli_begin_transaction($conn);

try {
    if ($level_saat_ini == 'anggota' && $target_level == 'pegawai') {
        // Pindah dari Anggota ke Pegawai
        
        // 1. Cek pinjaman (sudah dicek di frontend, tapi validasi lagi di backend)
        $q_anggota = mysqli_query($conn, "SELECT * FROM anggota WHERE id_user = '$id_user'");
        $anggota = mysqli_fetch_assoc($q_anggota);
        $id_ang = $anggota['ID_Anggota'];
        
        $cek_pinjam = mysqli_query($conn, "SELECT * FROM peminjaman WHERE ID_Anggota = '$id_ang'");
        if (mysqli_num_rows($cek_pinjam) > 0) {
            throw new Exception("Anggota masih memiliki histori peminjaman!");
        }
        
        // 2. Ambil data dari tabel users untuk username (pegawai pakai username table sendiri juga)
        $q_user = mysqli_query($conn, "SELECT * FROM users WHERE id_user = '$id_user'");
        $user = mysqli_fetch_assoc($q_user);
        $username = $user['username'];
        
        // 3. Hapus dari tabel anggota
        mysqli_query($conn, "DELETE FROM anggota WHERE id_user = '$id_user'");
        
        // 4. Insert ke tabel pegawai
        // Gunakan NIS sebagai NIP sementara agar ada nilai primary key
        $nip = $anggota['NIS'];
        $nama = $anggota['Nama'];
        $alamat = $anggota['Alamat'];
        $gender = $anggota['gender'];
        $no_hp = $anggota['Nomor_HP'];
        
        mysqli_query($conn, "INSERT INTO pegawai (nip, username, nama, alamat, gender, level, id_user, nomor_hp) 
                             VALUES ('$nip', '$username', '$nama', '$alamat', '$gender', '$role_baru', '$id_user', '$no_hp')");
                             
        // 5. Update level di tabel users
        mysqli_query($conn, "UPDATE users SET level = 'pegawai' WHERE id_user = '$id_user'");
        
    } else if ($level_saat_ini == 'pegawai' && $target_level == 'anggota') {
        // Pindah dari Pegawai ke Anggota
        
        // 1. Ambil data pegawai
        $q_peg = mysqli_query($conn, "SELECT * FROM pegawai WHERE id_user = '$id_user'");
        $pegawai = mysqli_fetch_assoc($q_peg);
        
        // 2. Hapus dari tabel pegawai
        mysqli_query($conn, "DELETE FROM pegawai WHERE id_user = '$id_user'");
        
        // 3. Generate ID Anggota baru
        $query_id = mysqli_query($conn, "SELECT MAX(CAST(SUBSTRING(ID_Anggota, 3) AS UNSIGNED)) as max_id FROM anggota");
        $data_id = mysqli_fetch_assoc($query_id);
        $next_id = "AG" . str_pad($data_id['max_id'] + 1, 3, "0", STR_PAD_LEFT);
        
        // 4. Insert ke tabel anggota
        $nama = $pegawai['nama'];
        $nis = $pegawai['nip']; // mapping nip ke nis
        $alamat = $pegawai['alamat'];
        $gender = $pegawai['gender'];
        $no_hp = $pegawai['nomor_hp'];
        
        // Ambil password dari users sebagai nisn
        $q_user = mysqli_query($conn, "SELECT * FROM users WHERE id_user = '$id_user'");
        $user = mysqli_fetch_assoc($q_user);
        $nisn = $user['password'];
        
        mysqli_query($conn, "INSERT INTO anggota (ID_Anggota, Nama, NIS, nisn, Alamat, Nomor_HP, id_user, gender) 
                             VALUES ('$next_id', '$nama', '$nis', '$nisn', '$alamat', '$no_hp', '$id_user', '$gender')");
                             
        // 5. Update level di tabel users
        mysqli_query($conn, "UPDATE users SET level = 'anggota' WHERE id_user = '$id_user'");
        
    } else if ($level_saat_ini == 'pegawai' && $target_level == 'pegawai') {
        // Hanya mengubah role spesifik (admin <-> petugas)
        mysqli_query($conn, "UPDATE pegawai SET level = '$role_baru' WHERE id_user = '$id_user'");
    }

    mysqli_commit($conn);
    echo "<script>
        alert('Role berhasil diperbarui!');
        window.location.href = '../../users.php';
    </script>";

} catch (Exception $e) {
    mysqli_rollback($conn);
    $msg = $e->getMessage();
    echo "<script>
        alert('Gagal update role: $msg');
        window.history.back();
    </script>";
}
?>
