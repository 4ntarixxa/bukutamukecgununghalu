<?php
include "koneksi.php";

// Ambil ID dari URL
if (isset($_GET['id_desa'])) {
    $id_desa = $_GET['id_desa'];

    // Ambil data desa berdasarkan ID
    $query = mysqli_query($koneksi, "SELECT * FROM desa WHERE id_desa = '$id_desa'");
    $data = mysqli_fetch_assoc($query);

    if (!$data) {
        echo "<script>alert('Data desa tidak ditemukan'); window.location.href='index.php?dashboard=desa';</script>";
        exit;
    }
} else {
    echo "<script>alert('ID desa tidak ditemukan'); window.location.href='index.php?dashboard=desa';</script>";
    exit;
}

// Proses update data desa
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['nama_desa'])) {
    $nama_desa = trim($_POST['nama_desa']);

    if (!empty($nama_desa)) {
        // Cek apakah nama desa baru sudah digunakan oleh desa lain
        $cek = mysqli_query($koneksi, "SELECT * FROM desa WHERE nama_desa = '$nama_desa' AND id_desa != '$id_desa'");
        if (mysqli_num_rows($cek) == 0) {
            $update = mysqli_query($koneksi, "UPDATE desa SET nama_desa = '$nama_desa' WHERE id_desa = '$id_desa'");
            if ($update) {
                echo '<script type="text/javascript">
                    window.location.href = "index.php?dashboard=desa&notif=edit-desa-berhasil";
                </script>';
                exit;
            } else {
                $error = "Gagal mengupdate data.";
            }
        } else {
            $error = "Nama desa sudah ada.";
        }
    } else {
        $error = "Nama desa tidak boleh kosong.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Desa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header bg-warning text-dark">
            <h4>Edit Data Desa</h4>
        </div>
        <div class="card-body">
            <?php if (isset($error)): ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endif; ?>

            <form method="post">
                <div class="mb-3">
                    <label for="nama_desa" class="form-label">Nama Desa</label>
                    <input type="text" class="form-control" id="nama_desa" name="nama_desa" value="<?php echo htmlspecialchars($data['nama_desa']); ?>" required>
                </div>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                <a href="index.php?dashboard=desa" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
</body>
</html>

