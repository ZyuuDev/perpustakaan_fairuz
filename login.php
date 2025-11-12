<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Login - Perpustakaan</title>
  <link rel="stylesheet" href="styles/style.css">
</head>
<body class="login-body">

  <div class="login-container">
    <h2>Login</h2>
    <p>Silakan masukkan NIS dan NISN Anda untuk mengakses sistem.</p>
    <form method="POST" action="index.php">
      <input type="text" name="username" placeholder="Masukkan Username" required>
      <input type="password" name="password" placeholder="Masukkan Password" required>
      <button type="submit">Login</button>
    </form>
  </div>

</body>
</html>
