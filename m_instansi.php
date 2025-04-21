<?php
include "koneksi.php";

// Proses tambah instansi
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['nama_instansi'])) {
    $nama_instansi = trim($_POST['nama_instansi']);
    if (!empty($nama_instansi)) {
        $cek = mysqli_query($koneksi, "SELECT * FROM instansi WHERE nama_instansi = '$nama_instansi'");
        if (mysqli_num_rows($cek) == 0) {
            $insert = mysqli_query($koneksi, "INSERT INTO instansi (nama_instansi) VALUES ('$nama_instansi')");
            if ($insert) {
                echo '<script>window.location.href = "index.php?dashboard=instansi&notif=add-instansi-berhasil";</script>';
                exit;
            }
        } else {
            echo '<script>window.location.href = "index.php?dashboard=instansi&notif=instansi-sudah-ada";</script>';
            exit;
        }
    }
}

// Notifikasi
$notif_class = '';
$pesan = '';

if (isset($_GET['notif'])) {
    switch ($_GET['notif']) {
        case 'add-instansi-berhasil':
            $pesan = '✅ Data instansi berhasil ditambahkan!';
            $notif_class = 'success';
            break;
        case 'hapus-instansi-berhasil':
            $pesan = '🗑️ Data instansi berhasil dihapus!';
            $notif_class = 'success';
            break;
        case 'edit-instansi-berhasil':
            $pesan = '✏️ Data instansi berhasil diperbarui!';
            $notif_class = 'success';
            break;
        case 'instansi-sudah-ada':
            $pesan = '⚠️ Nama instansi sudah ada!';
            $notif_class = 'danger';
            break;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Master Data Instansi</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
</head>
<body>

<div class="container py-4">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Master Data Instansi</h4>
        </div>

        <div class="card-body">

            <?php if (!empty($pesan)): ?>
                <div id="notif-alert" class="alert alert-<?php echo $notif_class; ?> alert-dismissible fade show" role="alert">
                    <?php echo $pesan; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <div class="row mb-4">
                <!-- Form Tambah Instansi -->
                <div class="col-md-6">
                    <h5>Tambah Instansi</h5>
                    <form method="post">
                        <div class="mb-3">
                            <label for="nama_instansi" class="form-label">Nama Instansi</label>
                            <input type="text" class="form-control" id="nama_instansi" name="nama_instansi" placeholder="Masukkan nama instansi..." required>
                        </div>
                        <button type="submit" class="btn btn-info">Tambah Instansi</button>
                    </form>
                </div>
            </div>

            <!-- Tabel Instansi -->
            <h5>Daftar Instansi</h5>
            <div class="table-responsive">
                <table id="instansiTable" class="table table-bordered table-hover">
                    <thead class="table-dark text-center">
                        <tr>
                            <th width="10%">ID</th>
                            <th>Nama Instansi</th>
                            <th width="20%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query_instansi = mysqli_query($koneksi, "
                            SELECT @rownum := @rownum + 1 AS urutan, id_instansi, nama_instansi 
                            FROM instansi, (SELECT @rownum := 0) AS init 
                            ORDER BY nama_instansi ASC
                        ");
                        while ($data_instansi = mysqli_fetch_array($query_instansi)) {
                        ?>
                            <tr>
                                <td class="text-center"><?php echo $data_instansi['urutan']; ?></td>
                                <td><?php echo $data_instansi['nama_instansi']; ?></td>
                                <td class="text-center">
                                    <a href="index.php?dashboard=instansi-edit&id_instansi=<?php echo $data_instansi['id_instansi']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                    <a href="m_instansi_hapus.php?id_instansi=<?php echo $data_instansi['id_instansi']; ?>" onclick="return confirm('Yakin ingin menghapus instansi ini?')" class="btn btn-danger btn-sm">Hapus</a>
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
        $('#instansiTable').DataTable();

        // Auto dismiss alert after 3 seconds
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
