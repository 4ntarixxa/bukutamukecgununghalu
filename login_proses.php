<?php
session_start();
include 'koneksi.php'; // Pastikan koneksi database sudah benar

// Menangkap data dari form login
$username = $_POST['username'];
$password = md5($_POST['password']); // Enkripsi password dengan MD5

// Cek apakah username dan password cocok
$query = "SELECT * FROM user WHERE username = '$username' AND password = '$password'";
$result = mysqli_query($koneksi, $query);
$user = mysqli_fetch_assoc($result);

// Jika username dan password ditemukan
if ($user) {
    // Cek status user
    if ($user['status'] == 'aktif') {
        // Set session dan arahkan ke halaman utama
        $_SESSION['username'] = $user['username'];
        $_SESSION['id_user'] = $user['id_user'];
        header("Location: index.php");
        exit();
    } else {
        // Jika akun tidak aktif
        $_SESSION['error'] = "Akun Anda sudah tidak aktif.";
        header("Location: login.php");
        exit();
    }
} else {
    // Jika username atau password salah
    $_SESSION['error'] = "Username atau Password salah.";
    header("Location: login.php");
    exit();
}
?>
