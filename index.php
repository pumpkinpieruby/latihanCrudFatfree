<?php
require 'vendor/autoload.php';

$f3 = \Base::instance();
$f3->set('UI', 'ui/');

// Redirect ke login jika belum ada sesi
$f3->route('GET /', function($f3) {
    if (!$f3->exists('SESSION.user')) {
        echo \Template::instance()->render('login.php');
    } else {
        $f3->reroute('/home');
    }
});

// Proses login (POST /login)
$f3->route('POST /login', function($f3) {
    $username = $f3->get('POST.username');
    $password = $f3->get('POST.password');

    // Contoh autentikasi (username: admin, password: 1234)
    if ($username === 'admin' && $password === '1234') {
        $f3->set('SESSION.user', [
            'username' => 'admin',
            'email' => 'admin@example.com',
            'phone' => '081234567890',
            'address' => 'Jakarta, Indonesia'
        ]);
        $f3->reroute('/home');
    } else {
        echo "<script>alert('Login gagal! Periksa nama dan password.');</script>";
        echo \Template::instance()->render('login.php');
    }
});

// Halaman utama setelah login
$f3->route('GET /home', function($f3) {
    if (!$f3->exists('SESSION.user')) {
        $f3->reroute('/');
    }
    echo \Template::instance()->render('index.php');
});

// Halaman form (cek sesi)
$f3->route('GET /form', function($f3) {
    if (!$f3->exists('SESSION.user')) {
        $f3->reroute('/');
    }
    echo \Template::instance()->render('form.php');
});

// Halaman profile (cek sesi & kirim data user)
$f3->route('GET /profile', function($f3) {
    if (!$f3->exists('SESSION.user')) {
        $f3->reroute('/');
    }
    
    $f3->set('user', $f3->get('SESSION.user'));
    echo \Template::instance()->render('profile.php');
});

// Logout
$f3->route('GET /logout', function($f3) {
    $f3->clear('SESSION');
    $f3->reroute('/');
});

$f3->run();
