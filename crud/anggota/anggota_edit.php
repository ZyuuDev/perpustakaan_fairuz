<?php
include '../../config/config.php';
include '../../config/auth_check.php';
check_access(['admin']);
$id = $_GET['id'];
$data = mysqli_query($conn, "SELECT * FROM anggota WHERE ID_Anggota='$id'");
$row = mysqli_fetch_array($data);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Anggota | Perpustakaan</title>
    <link rel="stylesheet" href="../../assets/styles/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet"/>
</head>
<body class="anggota-body">
    <div class="anggota-modal show" style="display: flex; align-items: center; justify-content: center;">
        <div class="anggota-modal-content" style="position: relative; transform: none; box-shadow: 0 10px 25px rgba(0,0,0,0.1);">
            <h2 style="margin-bottom: 1.5rem;">Edit Data Anggota</h2>
            <form action="anggota_edit_aksi.php" method="post">
                <input type="hidden" name="id" value="<?php echo $row['ID_Anggota']; ?>">
                
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; color: #64748b;">Nama Lengkap</label>
                    <input type="text" name="nama" value="<?php echo $row['Nama']; ?>" required style="width: 100%; padding: 0.75rem; border: 1px solid #e2e8f0; border-radius: 0.5rem;">
                </div>
                
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; color: #64748b;">NIS</label>
                    <input type="text" name="nis" value="<?php echo $row['NIS']; ?>" required style="width: 100%; padding: 0.75rem; border: 1px solid #e2e8f0; border-radius: 0.5rem;">
                </div>
                
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; color: #64748b;">Alamat</label>
                    <input type="text" name="alamat" value="<?php echo $row['Alamat']; ?>" style="width: 100%; padding: 0.75rem; border: 1px solid #e2e8f0; border-radius: 0.5rem;">
                </div>
                
                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; color: #64748b;">Nomor HP</label>
                    <input type="text" name="nomor_hp" value="<?php echo $row['Nomor_HP']; ?>" style="width: 100%; padding: 0.75rem; border: 1px solid #e2e8f0; border-radius: 0.5rem;">
                </div>
                
                <div style="display: flex; gap: 1rem;">
                    <button type="submit" style="flex: 1; padding: 0.75rem; background: #2563eb; color: white; border: none; border-radius: 0.5rem; font-weight: 600; cursor: pointer;">Update Data</button>
                    <a href="../../anggota.php" style="flex: 1; padding: 0.75rem; background: #f1f5f9; color: #475569; border: none; border-radius: 0.5rem; font-weight: 600; text-align: center; text-decoration: none;">Batal</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
