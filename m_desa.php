<?php
include "koneksi.php";

// Proses tambah desa
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['nama_desa'])) {
    $nama_desa = trim($_POST['nama_desa']);
    if (!empty($nama_desa)) {
        $cek = mysqli_query($koneksi, "SELECT * FROM desa WHERE nama_desa = '$nama_desa'");
        if (mysqli_num_rows($cek) == 0) {
            $insert = mysqli_query($koneksi, "INSERT INTO desa (nama_desa) VALUES ('$nama_desa')");
            if ($insert) {
                echo '<script>window.location.href = "index.php?dashboard=desa&notif=add-desa-berhasil";</script>';
                exit;
            }
        } else {
            echo '<script>window.location.href = "index.php?dashboard=desa&notif=desa-sudah-ada";</script>';
            exit;
        }
    }
}

// Notifikasi
$notif_class = '';
$pesan = '';

if (isset($_GET['notif'])) {
    switch ($_GET['notif']) {
        case 'add-desa-berhasil':
            $pesan = '✅ Data desa berhasil ditambahkan!';
            $notif_class = 'success';
            break;
        case 'hapus-desa-berhasil':
            $pesan = '🗑️ Data desa berhasil dihapus!';
            $notif_class = 'success';
            break;
        case 'edit-desa-berhasil':
            $pesan = '✏️ Data desa berhasil diperbarui!';
            $notif_class = 'success';
            break;
        case 'desa-sudah-ada':
            $pesan = '⚠️ Nama desa sudah ada!';
            $notif_class = 'danger';
            break;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Master Data - Desa</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
</head>
<body>

<div class="container py-4">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Master Data Desa</h4>
        </div>

        <div class="card-body">

            <?php if (!empty($pesan)): ?>
                <div id="notif-alert" class="alert alert-<?php echo $notif_class; ?> alert-dismissible fade show" role="alert">
                    <?php echo $pesan; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <div class="row mb-4">
                <!-- Form Tambah Desa -->
                <div class="col-md-6">
                    <h5>Tambah Desa</h5>
                    <form method="post">
                        <div class="mb-3">
                            <label for="nama_desa" class="form-label">Nama Desa</label>
                            <input type="text" class="form-control" id="nama_desa" name="nama_desa" placeholder="Masukkan nama desa..." required>
                        </div>
                        <button type="submit" class="btn btn-info">Tambah Desa</button>
                    </form>
                </div>
            </div>

            <!-- Tabel Desa -->
            <h5>Daftar Desa</h5>
            <div class="table-responsive">
                <table id="desaTable" class="table table-bordered table-hover">
                    <thead class="table-dark text-center">
                        <tr>
                            <th width="10%">ID</th>
                            <th>Nama Desa</th>
                            <th width="20%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query_desa = mysqli_query($koneksi, "
                            SELECT @rownum := @rownum + 1 AS urutan, id_desa, nama_desa 
                            FROM desa, (SELECT @rownum := 0) AS init
                            ORDER BY nama_desa ASC
                        ");

                        while ($data_desa = mysqli_fetch_array($query_desa)) {
                        ?>
                        <tr>
                            <td class="text-center"><?php echo $data_desa['urutan']; ?></td>
                            <td><?php echo $data_desa['nama_desa']; ?></td>
                            <td class="text-center">
                                <a href="index.php?dashboard=desa-edit&id_desa=<?php echo $data_desa['id_desa']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                <a href="m_desa_hapus.php?id_desa=<?php echo $data_desa['id_desa']; ?>" onclick="return confirm('Yakin ingin menghapus desa ini?')" class="btn btn-danger btn-sm">Hapus</a>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

<!-- DataTables & Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    $(document).ready(function () {
        $('#desaTable').DataTable();

        // Auto-dismiss alert after 3 seconds
        setTimeout(function () {
            let alert = document.getElementById('notif-alert');
            if (alert) {
                let bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            }
        }, 3000);
    });
</script>
</body>
</html>
