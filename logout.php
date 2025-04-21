<?php
//session start
session_start();

//hilangkan session yg sudah di set
unset($_SESSION['id_user']);
unset($_SESSION['password']);
unset($_SESSION['nama_pengguna']);
unset($_SESSION['username']);

session_destroy();
echo "<script>
    document.location='index.php';
    </script>";
