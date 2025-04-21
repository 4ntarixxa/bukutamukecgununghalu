<?php include "koneksi.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Data Admin</title>
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
        <h4 class="card-title mb-0">DATA ADMIN</h4>
      </div>
      <div class="col-md-4 text-end">
        <a href="index.php?dashboard=user-add" class="btn btn-light btn-sm">
          <i class="fas fa-plus me-2"></i> Tambah Admin
        </a>
      </div>
    </div>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-hover table-bordered">
        <thead class="table-dark text-center">
          <tr>
            <th>No</th>
            <th>Username</th>
            <th>Nama Pengguna</th>
            <th>Jabatan</th>
            <th>Status</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php
          if (isset($_GET['cari'])) {
            $cari = $_GET['cari'];
            $query = mysqli_query($koneksi, "SELECT * FROM user WHERE id_user LIKE '%$cari%' OR username LIKE '%$cari%' OR nama_pengguna LIKE '%$cari%' OR jabatan LIKE '%$cari%'");
          } else {
            $query = mysqli_query($koneksi, "SELECT * FROM user ORDER BY id_user ASC");
          }

          $no = 1;
          while ($data = mysqli_fetch_array($query)) :
          ?>
            <tr class="text-center">
              <td><?= $no++ ?></td>
              <td><?= $data['username'] ?></td>
              <td><?= $data['nama_pengguna'] ?></td>
              <td><?= $data['jabatan'] ?></td>
              <td>
                <?php if ($data['status'] == 'aktif') : ?>
                  <span class="badge bg-success">Aktif</span>
                <?php else : ?>
                  <span class="badge bg-secondary">Tidak Aktif</span>
                <?php endif; ?>
              </td>
              <td>
                <a href="?dashboard=user-edit&id=<?= $data['id_user'] ?>&nama_pengguna=<?= $data['nama_pengguna'] ?>" class="text-white btn btn-sm btn-warning me-2">
                  <i class="fas fa-edit me-1"></i> Edit
                </a>
                <a href="user_hapus.php?id=<?= $data['id_user'] ?>" onclick="return confirm('Yakin ingin menghapus Data Admin ini?')" class="btn btn-sm btn-danger">
                  <i class="fas fa-trash me-1"></i> Hapus
                </a>
              </td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </div>
  <div class="card-footer bg-light">
    <small class="text-muted">Total Admin: <?= mysqli_num_rows($query) ?></small>
  </div>
</div>

<!-- JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
  // Auto dismiss after 3 seconds
  setTimeout(() => {
    const notif = document.getElementById("notif-alert");
    if (notif) {
      notif.classList.remove("animate__fadeInDown");
      notif.classList.add("animate__fadeOutUp");
      setTimeout(() => {
        const bsAlert = new bootstrap.Alert(notif);
        bsAlert.close();
      }, 800); // tunggu efek animasi keluar
    }
  }, 3000);
</script>

</body>
</html>
