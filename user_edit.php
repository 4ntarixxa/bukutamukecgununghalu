<?php
include "koneksi.php";

// Ambil ID dari parameter URL
$id = $_GET['id'];

// Query untuk mengambil data admin berdasarkan ID
$pilih = mysqli_query($koneksi, "SELECT * FROM user WHERE id_user='$id'");

// Proses update data jika form disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = strtolower($_POST['username']);
    $password_raw = $_POST['password'];
    $password_confirm = $_POST['password_confirm'];
    $nama = $_POST['nama_pengguna'];
    $status = $_POST['status'];
    $jabatan = $_POST['jabatan'];

    $pesan_error = "";

    // Validasi username unik
    $cek_username = mysqli_query($koneksi, "SELECT * FROM user WHERE username = '$username' AND id_user != '$id'");
    if (mysqli_num_rows($cek_username) > 0) {
        $pesan_error = "Username \"$username\" sudah digunakan.";
    }

    // Validasi password jika diisi
    if (!empty($password_raw)) {
        if ($password_raw !== $password_confirm) {
            $pesan_error = "Password dan Konfirmasi Password tidak cocok.";
        } elseif (strlen($password_raw) < 8) {
            $pesan_error = "Password harus minimal 8 karakter.";
        } elseif (!preg_match('/^[a-zA-Z0-9]+$/', $password_raw)) {
            $pesan_error = "Password tidak boleh mengandung simbol. Hanya huruf dan angka saja.";
        }
    }

    // Jika tidak ada error, simpan data ke database
    if (empty($pesan_error)) {
        if (!empty($password_raw)) {
            $password = md5($password_raw);
            $sql = "UPDATE user SET username='$username', password='$password', nama_pengguna='$nama', status='$status', jabatan='$jabatan' WHERE id_user='$id'";
        } else {
            $sql = "UPDATE user SET username='$username', nama_pengguna='$nama', status='$status', jabatan='$jabatan' WHERE id_user='$id'";
        }

        $query = mysqli_query($koneksi, $sql);

        if ($query) {
            echo "<script>window.location = 'index.php?dashboard=user&notif=edit-berhasil';</script>";
        } else {
            $pesan_error = "Gagal mengupdate data.";
        }
    }
}
?>

<div class="card shadow p-4">
  <div class="card-header bg-primary text-white">
    <div class="row">
      <div class="col-md-8">
        <h4 class="card-title mb-0">Edit Admin</h4>
      </div>
      <div class="col-md-4 text-end">
        <a href="index.php?dashboard=user" class="btn btn-light btn-sm">
          <i class="fas fa-arrow-left me-2"></i> Kembali
        </a>
      </div>
    </div>
  </div>
  <div class="card-body">
    <?php if (!empty($pesan_error)) : ?>
      <div class="alert alert-danger"><?php echo $pesan_error; ?></div>
    <?php endif; ?>

    <form action="" method="post">
      <?php while ($data = mysqli_fetch_array($pilih)) : ?>
        <div class="mb-3">
          <label for="username" class="form-label">Username (huruf kecil)</label>
          <input type="text" class="form-control" id="username" name="username" value="<?= $data['username'] ?>" required>
        </div>

        <div class="mb-3">
          <label for="password" class="form-label">Password Baru (biarkan kosong jika tidak diubah)</label>
          <input type="password" class="form-control" id="password" name="password">
        </div>

        <div class="mb-3">
          <label for="password_confirm" class="form-label">Konfirmasi Password</label>
          <input type="password" class="form-control" id="password_confirm" name="password_confirm">
        </div>

        <div class="mb-3">
          <label for="nama_pengguna" class="form-label">Nama Pengguna</label>
          <input type="text" class="form-control" id="nama_pengguna" name="nama_pengguna" value="<?= $data['nama_pengguna'] ?>" required>
        </div>

        <div class="mb-3">
          <label for="status" class="form-label">Status</label>
          <select class="form-select" id="status" name="status" required>
            <option value="aktif" <?= ($data['status'] == 'aktif') ? 'selected' : '' ?>>Aktif</option>
            <option value="tidak-aktif" <?= ($data['status'] == 'tidak-aktif') ? 'selected' : '' ?>>Tidak Aktif</option>
          </select>
        </div>

        <div class="mb-3">
          <label for="jabatan" class="form-label">Jabatan/Peran</label>
          <select class="form-select" id="jabatan" name="jabatan" required>
            <option value="Kepala Desa" <?= ($data['jabatan'] == 'Kepala Desa') ? 'selected' : '' ?>>Kepala Desa</option>
            <option value="Sekretaris Desa" <?= ($data['jabatan'] == 'Sekretaris Desa') ? 'selected' : '' ?>>Sekretaris Desa</option>
            <option value="Operator Kecamatan" <?= ($data['jabatan'] == 'Operator Kecamatan') ? 'selected' : '' ?>>Operator Kecamatan</option>
            <option value="Kasi Pemerintahan" <?= ($data['jabatan'] == 'Kasi Pemerintahan') ? 'selected' : '' ?>>Kasi Pemerintahan</option>
            <option value="Admin Umum" <?= ($data['jabatan'] == 'Admin Umum') ? 'selected' : '' ?>>Admin Umum</option>
          </select>
        </div>
      <?php endwhile; ?>

      <div class="text-end">
        <button type="submit" class="btn btn-primary">
          <i class="fas fa-save me-2"></i> Simpan Perubahan
        </button>
      </div>
    </form>
  </div>
</div>
