<?php
session_start();
require 'config.php'; // Pastikan ada koneksi database

// Cek apakah user sudah login, jika tidak arahkan ke login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Ambil data user dari database
$stmt = $pdo->prepare("SELECT username, email, phone, address FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="/ui/css/bootstrap.min.css">
    <link href="/ui/css/templatemo-xtra-blog.css" rel="stylesheet">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Xtra Blog</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="profile.php">Profile</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    
    <!-- Profile Content -->
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-4 text-center">
                <img src="/ui/img/profile.jpg" class="img-fluid rounded-circle" alt="Profile Picture">
                <h3 class="mt-3"><?= htmlspecialchars($user['username']) ?></h3>
                <p class="text-muted">Web Developer</p>
            </div>
            <div class="col-md-8">
                <h2>Profile Information</h2>
                <hr>
                <p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
                <p><strong>Phone:</strong> <?= htmlspecialchars($user['phone']) ?></p>
                <p><strong>Address:</strong> <?= htmlspecialchars($user['address']) ?></p>
                <h3>Skills</h3>
                <ul>
                    <li>HTML, CSS, JavaScript</li>
                    <li>PHP & Laravel</li>
                    <li>Fat-Free Framework</li>
                    <li>MySQL & Database Management</li>
                </ul>
            </div>
        </div>
    </div>
    
    <!-- Logout Button -->
    <div class="container text-center mt-4">
        <a href="logout.php" class="btn btn-danger">Logout</a>
    </div>
    
    <script src="/ui/js/jquery.min.js"></script>
    <script src="/ui/js/bootstrap.bundle.min.js"></script>
</body>
</html>
