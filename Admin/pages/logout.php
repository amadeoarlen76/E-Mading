<?php
// Mulai session (pastikan session_start dipanggil di setiap file yang menggunakan session)
session_start();

// Hapus session
session_destroy();

// Hapus cookie (jika ada)
if (isset($_COOKIE['nama_cookie'])) {
    setcookie('nama_cookie', '', time() - 3600, '/');
}

// Arahkan ke menu login.php
header('Location:../../login.php');
exit();
?>
