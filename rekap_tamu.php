<?php
include "koneksi.php";
?>

<!-- NOTIFIKASI -->
<?php if (isset($_GET['notif'])) : ?>
    <?php if ($_GET['notif'] == "add-berhasil") : ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> Data Berhasil Ditambahkan!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    <?php if ($_GET['notif'] == "edit-berhasil") : ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> Data Berhasil Diedit!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    <?php if ($_GET['notif'] == "delete-berhasil") : ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> Data Berhasil Dihapus!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
<?php endif; ?>
<!-- NOTIFIKASI -->

<div class="card shadow p-4">
    <div class="card-header bg-primary text-white">
        <div class="row">
            <div class="col-md-4">
                <h4 class="card-title mb-0">REKAP DATA TAMU</h4>
            </div>
            <div class="col-md-6">
                <form method="get" action="">
                    <div class="row g-3">
                        <div class="col">
                            <input type="date" class="form-control" name="tgl1" required>
                            <input type="hidden" name="dashboard" value="rekap">
                            <input type="hidden" name="cari">
                        </div>
                        <div class="col">
                            <input type="date" class="form-control" name="tgl2" required>
                        </div>
                        <div class="col">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-search me-2"></i> Tampilkan
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-2 text-end">
                <a href="index.php?dashboard=tamu" class="btn btn-light me-2">
                    <i class="fas fa-arrow-left me-2"></i> Kembali
                </a>
                <a href="exportexcel_today.php" class="btn btn-light">
                    <i class="fas fa-file-export me-2"></i> Export Hari Ini
                </a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <?php if (isset($_GET['cari'])) : ?>
            <?php
            $tgl1 = $_GET['tgl1'];
            $tgl2 = $_GET['tgl2'];
            if (empty($tgl1) || empty($tgl2)) : ?>
                <div class="alert alert-warning text-center">
                    <strong>Peringatan!</strong> Pastikan tanggal diisi.
                </div>
            <?php else : ?>
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
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $tampil = mysqli_query($koneksi, "
                                SELECT tamu.*, desa.nama_desa AS desa, instansi.nama_instansi AS instansi
                                FROM tamu
                                LEFT JOIN desa ON tamu.id_desa = desa.id_desa
                                LEFT JOIN instansi ON tamu.id_instansi = instansi.id_instansi
                                WHERE Tanggal BETWEEN '$tgl1' AND '$tgl2'
                            ");
                            while ($data = mysqli_fetch_array($tampil)) :
                            ?>
                                <tr>
                                    <td><?= $data['id'] ?></td>
                                    <td><?= $data['Tanggal'] ?></td>
                                    <td><?= $data['Nama'] ?></td>
                                    <td><?= $data['Alamat'] ?></td>
                                    <td><?= $data['desa'] ?></td>
                                    <td><?= $data['instansi'] ?></td>
                                    <td><?= !empty($data['KeperluanLain']) ? $data['KeperluanLain'] : $data['Keperluan'] ?></td>
                                    <td><?= $data['No_HP'] ?></td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
                <div class="text-center mt-4">
                    <a href="exportexcel.php?tanggala=<?= $tgl1 ?>&tanggalb=<?= $tgl2 ?>" class="btn btn-primary">
                        <i class="fas fa-file-export me-2"></i> Export Data Excel
                    </a>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</div>
