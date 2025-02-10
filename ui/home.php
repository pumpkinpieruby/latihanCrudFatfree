<?php
session_start();
require 'config.php'; // Pastikan file ini ada dan berisi koneksi database

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Ambil data pegawai keluar dari database
$stmt = $pdo->query("SELECT * FROM pegawai_keluar ORDER BY tanggal DESC");
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xtra Blog</title>
    <link rel="stylesheet" href="fontawesome/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/ui/css/bootstrap.min.css">
    <link href="/ui/css/templatemo-xtra-blog.css" rel="stylesheet">
</head>
<body>

    <?php include 'navbar.php'; ?>

    <!-- Konten -->
    <div class="container mt-5">
        <h1 class="mb-4">Rekap Pegawai Keluar Kantor</h1>
        <a href="form.php" class="btn btn-primary mb-3">Add</a>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Tanggal</th>
                    <th>Jam Keluar</th>
                    <th>Jam Kembali</th>
                    <th>Keperluan</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($data): ?>
                    <?php foreach ($data as $index => $row): ?>
                        <tr>
                            <td><?= $index + 1 ?></td>
                            <td><?= htmlspecialchars($row['nama']) ?></td>
                            <td><?= htmlspecialchars($row['tanggal']) ?></td>
                            <td><?= htmlspecialchars($row['jam_keluar']) ?></td>
                            <td><?= htmlspecialchars($row['jam_masuk']) ?></td>
                            <td><?= htmlspecialchars($row['keperluan']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center">Belum ada data</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</body>
</html>
