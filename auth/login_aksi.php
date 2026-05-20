<?php
session_start();
include '../config/config.php';
$username = mysqli_real_escape_string($conn, $_POST['username']);
$password = mysqli_real_escape_string($conn, $_POST['password']);
$query_users = mysqli_query($conn, "SELECT * FROM users WHERE username='$username' AND password='$password'");
if (mysqli_num_rows($query_users) > 0) {
    $user = mysqli_fetch_assoc($query_users);
    $id_user = $user['id_user'];
    $_SESSION['login'] = true;
    $_SESSION['id_user'] = $id_user; 
    if ($user['level'] == 'pegawai') {
        $q_peg = mysqli_query($conn, "SELECT * FROM pegawai WHERE id_user='$id_user'");
        if (mysqli_num_rows($q_peg) > 0) {
            $data = mysqli_fetch_assoc($q_peg);
            $_SESSION['nip'] = $data['nip'];
            $_SESSION['nama'] = $data['nama'];
            $_SESSION['level'] = $data['level']; 
            header("Location: ../dashboard.php");
            exit;
        }
    } else if ($user['level'] == 'anggota') {
        $q_ang = mysqli_query($conn, "SELECT * FROM anggota WHERE id_user='$id_user'");
        if (mysqli_num_rows($q_ang) > 0) {
            $data = mysqli_fetch_assoc($q_ang);
            $_SESSION['id_anggota'] = $data['ID_Anggota'];
            $_SESSION['nama'] = $data['Nama'];
            $_SESSION['level'] = 'peminjam'; 
            header("Location: ../dashboard_peminjam.php");
            exit;
        }
    }
}
echo "<script>
    alert('Username atau Password salah!');
    window.location.href = '../index.php';
</script>";
?>
