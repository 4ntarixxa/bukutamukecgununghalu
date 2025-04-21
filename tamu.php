<?php include "koneksi.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Tamu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
</head>
<body>

<!-- NOTIFIKASI -->
<?php if (isset($_GET['notif'])): ?>
    <div class="container mt-3">
        <div id="notif-alert" class="alert alert-success alert-dismissible fade show animate__animated animate__fadeInDown" role="alert">
            <?php if ($_GET['notif'] == "add-berhasil"): ?>
                <strong>Success!</strong> Data Berhasil Ditambahkan!
            <?php elseif ($_GET['notif'] == "edit-berhasil"): ?>
                <strong>Success!</strong> Data Berhasil Diedit!
            <?php elseif ($_GET['notif'] == "delete-berhasil"): ?>
                <strong>Success!</strong> Data Berhasil Dihapus!
            <?php endif; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
<?php endif; ?>
<!-- END NOTIFIKASI -->

<div class="card shadow p-4 mt-4">
    <div class="card-header bg-primary text-white">
        <div class="row">
            <div class="col-md-8">
                <h4 class="card-title mb-0">DATA TAMU</h4>
            </div>
            <div class="col-md-4 text-end">
                <a href="?dashboard=tamu-add" class="btn btn-light btn-sm">
                    <i class="fas fa-plus me-2"></i> Tambah Tamu
                </a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Tanggal</th>
                        <th>Nama</th>
                        <th>Alamat</th>
                        <th>Desa</th>
                        <th>Instansi</th>
                        <th>Keperluan</th>
                        <th>No. HP</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (isset($_GET['cari'])) {
                        $cari = $_GET['cari'];
                        $query = mysqli_query($koneksi, "
                            SELECT tamu.*, desa.nama_desa AS desa, instansi.nama_instansi AS instansi
                            FROM tamu
                            LEFT JOIN desa ON tamu.id_desa = desa.id_desa
                            LEFT JOIN instansi ON tamu.id_instansi = instansi.id_instansi
                            WHERE tamu.Nama LIKE '%$cari%' 
                            OR instansi.nama_instansi LIKE '%$cari%' 
                            OR desa.nama_desa LIKE '%$cari%'
                        ");
                    } else {
                        $query = mysqli_query($koneksi, "
                            SELECT tamu.*, desa.nama_desa AS desa, instansi.nama_instansi AS instansi
                            FROM tamu
                            LEFT JOIN desa ON tamu.id_desa = desa.id_desa
                            LEFT JOIN instansi ON tamu.id_instansi = instansi.id_instansi
                        ");
                    }

                    $no = 1;
                    while ($data = mysqli_fetch_array($query)) :
                    ?>
                        <tr>
                            <td><?php echo $no++; ?></td>
                            <td><?php echo $data['Tanggal']; ?></td>
                            <td><?php echo $data['Nama']; ?></td>
                            <td><?php echo $data['Alamat']; ?></td>
                            <td><?php echo $data['desa']; ?></td>
                            <td><?php echo $data['instansi']; ?></td>
                            <td><?php echo !empty($data['KeperluanLain']) ? $data['KeperluanLain'] : $data['Keperluan']; ?></td>
                            <td><?php echo $data['No_HP']; ?></td>
                            <td>
                                <a href="?dashboard=tamu-edit&id=<?php echo $data['id']; ?>&Nama=<?php echo $data['Nama']; ?>" class="btn btn-warning btn-sm">
                                    <i class="bi bi-pencil-square"></i> Edit
                                </a>
                                <a href="tamu_hapus.php?id=<?php echo $data['id']; ?>" onclick="return confirm('Yakin ingin menghapus Data Tamu ini?')" class="btn btn-danger btn-sm">
                                    <i class="bi bi-trash"></i> Hapus
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="footer mt-4">
        <hr>
        <p class="text-muted">Total Tamu: <?php 
            $result = mysqli_query($koneksi, "SELECT COUNT(*) AS total_tamu FROM tamu");
            $data = mysqli_fetch_assoc($result);
            echo $data['total_tamu'];
        ?></p>
    </div>
</div>

<!-- Bootstrap Bundle dan Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Auto-close dengan animasi -->
<script>
    setTimeout(() => {
        const notif = document.getElementById("notif-alert");
        if (notif) {
            notif.classList.remove("animate__fadeInDown");
            notif.classList.add("animate__fadeOutUp");
            setTimeout(() => {
                const bsAlert = new bootstrap.Alert(notif);
                bsAlert.close();
            }, 800); // tunggu animasi keluar
        }
    }, 3000); // auto close 3 detik
</script>

</body>
</html>
