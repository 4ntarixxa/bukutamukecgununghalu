<?php
include "koneksi.php";

if (isset($_GET['id_instansi'])) {
    $id_instansi = $_GET['id_instansi'];

    // Hapus instansi
    $hapus = mysqli_query($koneksi, "DELETE FROM instansi WHERE id_instansi = '$id_instansi'");
    if ($hapus) {
        echo "<script>
            window.location.href = 'index.php?dashboard=instansi&notif=hapus-instansi-berhasil';
        </script>";
    } else {
        echo "<script>
            alert('Gagal menghapus data instansi.');
            window.location.href = 'index.php?dashboard=instansi';
        </script>";
    }
} else {
    echo "<script>
        alert('ID instansi tidak ditemukan.');
        window.location.href = 'index.php?dashboard=instansi';
    </script>";
}
?>
