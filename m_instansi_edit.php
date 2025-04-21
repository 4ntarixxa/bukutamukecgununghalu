<?php
include "koneksi.php";

// Ambil ID dari URL
if (isset($_GET['id_instansi'])) {
    $id_instansi = $_GET['id_instansi'];

    // Ambil data instansi berdasarkan ID
    $query = mysqli_query($koneksi, "SELECT * FROM instansi WHERE id_instansi = '$id_instansi'");
    $data = mysqli_fetch_assoc($query);

    if (!$data) {
        echo "<script>alert('Data instansi tidak ditemukan'); window.location.href='index.php?dashboard=instansi';</script>";
        exit;
    }
} else {
    echo "<script>alert('ID instansi tidak ditemukan'); window.location.href='index.php?dashboard=instansi';</script>";
    exit;
}

// Proses update data instansi
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['nama_instansi'])) {
    $nama_instansi = trim($_POST['nama_instansi']);

    if (!empty($nama_instansi)) {
        // Cek apakah nama instansi baru sudah digunakan oleh instansi lain
        $cek = mysqli_query($koneksi, "SELECT * FROM instansi WHERE nama_instansi = '$nama_instansi' AND id_instansi != '$id_instansi'");
        if (mysqli_num_rows($cek) == 0) {
            $update = mysqli_query($koneksi, "UPDATE instansi SET nama_instansi = '$nama_instansi' WHERE id_instansi = '$id_instansi'");
            if ($update) {
                echo '<script type="text/javascript">
                    window.location.href = "index.php?dashboard=instansi&notif=edit-instansi-berhasil";
                </script>';
                exit;
            } else {
                $error = "Gagal mengupdate data.";
            }
        } else {
            $error = "Nama instansi sudah ada.";
        }
    } else {
        $error = "Nama instansi tidak boleh kosong.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Instansi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header bg-warning text-dark">
            <h4>Edit Data Instansi</h4>
        </div>
        <div class="card-body">
            <?php if (isset($error)): ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endif; ?>

            <form method="post">
                <div class="mb-3">
                    <label for="nama_instansi" class="form-label">Nama Instansi</label>
                    <input type="text" class="form-control" id="nama_instansi" name="nama_instansi" value="<?php echo htmlspecialchars($data['nama_instansi']); ?>" required>
                </div>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                <a href="index.php?dashboard=instansi" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
</body>
</html>
