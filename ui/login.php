<?php
session_start();
require 'config.php'; // Pastikan file ini ada dan berisi koneksi database

// Jika sudah login, arahkan ke halaman utama
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

// Cek apakah form dikirim
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Ambil data user dari database
    $stmt = $pdo->prepare("SELECT id, password FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Validasi password
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        header("Location: index.php");
        exit();
    } else {
        $error = "Username atau password salah!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Xtra Blog</title>
    <link rel="stylesheet" href="fontawesome/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/ui/css/bootstrap.min.css">
    <link href="/ui/css/templatemo-xtra-blog.css" rel="stylesheet">
</head>
<body>
    <div class="container-fluid">
        <main class="tm-main d-flex justify-content-center align-items-center" style="height: 100vh;">
            <div class="col-md-6 col-lg-4">
                <h2 class="tm-color-primary text-center">Login</h2>
                
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger"><?= $error ?></div>
                <?php endif; ?>

                <form method="POST" action="" class="tm-contact-form">
                    <div class="form-group">
                        <label for="username" class="tm-color-primary">Nama</label>
                        <input class="form-control" name="username" id="username" type="text" required>
                    </div>
                    <div class="form-group">
                        <label for="password" class="tm-color-primary">Password</label>
                        <input class="form-control" name="password" id="password" type="password" required>
                    </div>
                    <button class="tm-btn tm-btn-primary btn-block" type="submit">Login</button>
                </form>
            </div>
        </main>
    </div>
</body>
</html>
