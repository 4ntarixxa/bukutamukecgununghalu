<?php
include "Koneksi.php";

$id = $_GET['id'];
$query = mysqli_query($koneksi, "DELETE FROM tamu WHERE id='$id'");

if ($query) {
    echo "<script>window.location = 'index.php?dashboard=tamu&notif=delete-berhasil';</script>";
} ?>