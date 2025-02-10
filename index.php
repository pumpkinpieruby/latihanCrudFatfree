<?php
require 'vendor/autoload.php';

$f3 = \Base::instance();

// Aktifkan debug mode
$f3->set('DEBUG', 3);

// Konfigurasi folder tampilan
$f3->set('UI', 'views/');

// Inisialisasi koneksi database (gunakan variabel global)
$db = new DB\SQL('mysql:host=localhost;dbname=latihancrud', 'root', '');

// Middleware untuk memastikan user login
function authCheck($f3) {
    if (!$f3->exists('SESSION.user')) {
        $f3->reroute('/login');
    }
}

// Halaman Home
$f3->route('GET /home', function($f3) use ($db) {
    authCheck($f3);

    // Ambil data pegawai
    $data = $db->exec('SELECT * FROM pegawai');

    $f3->set('data_pegawai', $data);
    echo Template::instance()->render('home.html');
});

// Halaman Profile
$f3->route('GET /profile', function($f3) use ($db) {
    authCheck($f3);

    // Ambil data user berdasarkan sesi
    $user = $db->exec('SELECT * FROM users WHERE username = ? LIMIT 1', [$f3->get('SESSION.user')]);

    if ($user) {
        $f3->set('user', [
            'email' => $user[0]['email'],
            'phone' => $user[0]['phone'],
            'address' => $user[0]['address'],
            'role' => $user[0]['role'],
            'skills' => explode(',', $user[0]['skills'])
        ]);
    } else {
        $f3->reroute('/logout');
    }

    echo Template::instance()->render('profile.html');
});

// Halaman Form Tambah Data
$f3->route('GET|POST /form', function($f3) use ($db) {
    authCheck($f3);

    if ($f3->VERB == 'POST') {
        // Simpan data pegawai
        $db->exec('INSERT INTO pegawai (nama, jabatan, jam_keluar, jam_masuk, keperluan, alasan_pribadi) VALUES (?, ?, ?, ?, ?, ?)', [
            $f3->get('POST.nama'),
            $f3->get('POST.jabatan'),
            $f3->get('POST.jam_keluar'),
            $f3->get('POST.jam_masuk'),
            $f3->get('POST.keperluan'),
            $f3->get('POST.alasan_pribadi')
        ]);

        $f3->reroute('/home');
    }

    $f3->set('pegawai', [
        'nama' => '',
        'jabatan' => '',
        'jam_keluar' => '',
        'jam_masuk' => '',
        'keperluan' => '',
        'alasan_pribadi' => ''
    ]);

    echo Template::instance()->render('form.html');
});

// Halaman Login
$f3->route('GET|POST /login', function($f3) use ($db) {
    if ($f3->VERB == 'POST') {
        $username = $f3->get('POST.username');
        $password = $f3->get('POST.password');

        // Cek user di database
        $user = $db->exec('SELECT * FROM users WHERE username = ? LIMIT 1', [$username]);

        if ($user && password_verify($password, $user[0]['password'])) {
            $f3->set('SESSION.user', $username);
            $f3->reroute('/home');
        } else {
            $f3->set('SESSION.error', 'Username atau password salah!');
            $f3->reroute('/login');
        }
    }

    echo Template::instance()->render('login.html');
});

// Logout
$f3->route('GET /logout', function($f3) {
    $f3->clear('SESSION');
    $f3->reroute('/login');
});

$f3->run();
