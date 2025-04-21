<?php
include "koneksi.php";

if (isset($_GET['id_desa'])) {
    $id_desa = $_GET['id_desa'];

    // Hapus desa
    $hapus = mysqli_query($koneksi, "DELETE FROM desa WHERE id_desa = '$id_desa'");
    if ($hapus) {
        echo "<script>
            window.location.href = 'index.php?dashboard=desa&notif=hapus-desa-berhasil';
        </script>";
    } else {
        echo "<script>
            alert('Gagal menghapus data desa.');
            window.location.href = 'index.php?dashboard=desa';
        </script>";
    }
} else {
    echo "<script>
        alert('ID desa tidak ditemukan.');
        window.location.href = 'index.php?dashboard=desa';
    </script>";
}
?>
