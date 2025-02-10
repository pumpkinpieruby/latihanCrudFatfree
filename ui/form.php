<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

require 'config.php'; // File untuk koneksi ke database

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama'];
    $jabatan = $_POST['jabatan'];
    $jam_keluar = $_POST['jam_keluar'];
    $jam_masuk = $_POST['jam_masuk'];
    $keperluan = $_POST['keperluan'];
    $alasan_pribadi = isset($_POST['alasan_pribadi']) ? $_POST['alasan_pribadi'] : NULL;

    $stmt = $pdo->prepare("INSERT INTO pegawai_keluar (nama, jabatan, jam_keluar, jam_masuk, keperluan, alasan_pribadi) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$nama, $jabatan, $jam_keluar, $jam_masuk, $keperluan, $alasan_pribadi]);

    header('Location: profile.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pegawai Keluar</title>
    <link rel="stylesheet" href="/ui/css/bootstrap.min.css">
    <link href="/ui/css/templatemo-xtra-blog.css" rel="stylesheet">
</head>
<body>
    <?php include 'navbar.php'; ?>
    
    <div class="container mt-5">
        <h2 class="mb-4">Form Pegawai Keluar</h2>
        <hr>
        <form action="" method="POST" class="p-4 border rounded bg-light">
            <div class="mb-3">
                <label for="nama" class="form-label">Nama Pegawai</label>
                <input type="text" class="form-control" id="nama" name="nama" required>
            </div>
            <div class="mb-3">
                <label for="jabatan" class="form-label">Jabatan</label>
                <input type="text" class="form-control" id="jabatan" name="jabatan" required>
            </div>
            <div class="mb-3">
                <label for="jam_keluar" class="form-label">Jam Keluar</label>
                <input type="time" class="form-control" id="jam_keluar" name="jam_keluar" required>
            </div>
            <div class="mb-3">
                <label for="jam_masuk" class="form-label">Jam Masuk</label>
                <input type="time" class="form-control" id="jam_masuk" name="jam_masuk" required>
            </div>
            <div class="mb-3">
                <label for="keperluan" class="form-label">Keperluan Keluar</label>
                <select class="form-control" id="keperluan" name="keperluan" required>
                    <option value="dinas">Dinas</option>
                    <option value="pribadi">Pribadi</option>
                </select>
            </div>
            <div class="mb-3" id="alasanPribadiContainer" style="display: none;">
                <label for="alasan_pribadi" class="form-label">Alasan Keperluan Pribadi</label>
                <input type="text" class="form-control" id="alasan_pribadi" name="alasan_pribadi">
            </div>
            <div class="text-end">
                <button type="submit" class="btn btn-primary">Add</button>
            </div>
        </form>
    </div>

    <script src="/ui/js/jquery.min.js"></script>
    <script src="/ui/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#keperluan').change(function() {
                if ($(this).val() === 'pribadi') {
                    $('#alasanPribadiContainer').show();
                    $('#alasan_pribadi').attr('required', true);
                } else {
                    $('#alasanPribadiContainer').hide();
                    $('#alasan_pribadi').removeAttr('required');
                }
            });
        });
    </script>
</body>
</html>
