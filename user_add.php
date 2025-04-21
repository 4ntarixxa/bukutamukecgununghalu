<?php
include "koneksi.php";

// Menyimpan nilai inputan yang lama
$username_value = isset($_POST['username']) ? $_POST['username'] : '';
$password_value = isset($_POST['password']) ? $_POST['password'] : '';
$password_confirm_value = isset($_POST['password_confirm']) ? $_POST['password_confirm'] : '';
$nama_pengguna_value = isset($_POST['nama_pengguna']) ? $_POST['nama_pengguna'] : '';
$status_value = isset($_POST['status']) ? $_POST['status'] : '';
$jabatan_value = isset($_POST['jabatan']) ? $_POST['jabatan'] : '';

// Variabel pesan error
$pesan_error = "";

// Proses tambah data jika form disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = strtolower($_POST['username']);
    $password_raw = $_POST['password'];
    $password_confirm = $_POST['password_confirm'];
    $nama = $_POST['nama_pengguna'];
    $status = $_POST['status'];
    $jabatan = $_POST['jabatan'];

    // Validasi password
    if ($password_raw !== $password_confirm) {
        $pesan_error = "Password dan Konfirmasi Password tidak cocok.";
    } elseif (strlen($password_raw) < 8) {
        $pesan_error = "Password harus minimal 8 karakter.";
    } elseif (!preg_match('/^[a-zA-Z0-9]+$/', $password_raw)) {
        $pesan_error = "Password tidak boleh mengandung simbol. Hanya huruf dan angka saja.";
    }

    // Validasi username unik
    if (empty($pesan_error)) {
        $cek_username = mysqli_query($koneksi, "SELECT * FROM user WHERE username = '$username'");
        if (mysqli_num_rows($cek_username) > 0) {
            $pesan_error = "Username \"$username\" sudah digunakan.";
        }
    }

    // Jika tidak ada error, simpan data ke database
    if (empty($pesan_error)) {
        $password = md5($password_raw); // Enkripsi password dengan MD5
        $sql = "INSERT INTO user (username, password, nama_pengguna, status, jabatan) VALUES ('$username', '$password', '$nama', '$status', '$jabatan')";
        $query = mysqli_query($koneksi, $sql);

        if ($query) {
            echo "<script>window.location = 'index.php?dashboard=user&notif=add-berhasil';</script>";
        } else {
            $pesan_error = "Gagal menambahkan data.";
        }
    }
}
?>

<div class="card shadow p-4">
  <div class="card-header bg-primary text-white">
    <div class="row">
      <div class="col-md-8">
        <h4 class="card-title mb-0">Tambah Admin</h4>
      </div>
      <div class="col-md-4 text-end">
        <a href="index.php?dashboard=user" class="btn btn-light btn-sm">
          <i class="fas fa-arrow-left me-2"></i> Kembali
        </a>
      </div>
    </div>
  </div>
  <div class="card-body">
    <?php if (!empty($pesan_error)): ?>
      <div class="alert alert-danger"><?= $pesan_error ?></div>
    <?php endif; ?>

    <form method="post">
      <div class="mb-3">
        <label for="username" class="form-label">Username (huruf kecil)</label>
        <input type="text" class="form-control" id="username" name="username" value="<?= $username_value ?>" required>
      </div>

      <div class="mb-3">
        <label for="password" class="form-label">Password Baru (min 8 karakter, tanpa simbol)</label>
        <input type="password" class="form-control" id="password" name="password" value="<?= $password_value ?>" required>
      </div>

      <div class="mb-3">
        <label for="password_confirm" class="form-label">Konfirmasi Password</label>
        <input type="password" class="form-control" id="password_confirm" name="password_confirm" value="<?= $password_confirm_value ?>" required>
      </div>

      <div class="mb-3">
        <label for="nama_pengguna" class="form-label">Nama Pengguna</label>
        <input type="text" class="form-control" id="nama_pengguna" name="nama_pengguna" value="<?= $nama_pengguna_value ?>" required>
      </div>

      <div class="mb-3">
        <label for="status" class="form-label">Status</label>
        <select class="form-select" id="status" name="status" required>
          <option value="aktif" <?= $status_value == 'aktif' ? 'selected' : '' ?>>Aktif</option>
          <option value="tidak-aktif" <?= $status_value == 'tidak-aktif' ? 'selected' : '' ?>>Tidak Aktif</option>
        </select>
      </div>

      <div class="mb-3">
        <label for="jabatan" class="form-label">Jabatan/Peran</label>
        <select class="form-select" id="jabatan" name="jabatan" required>
          <option value="Camat" <?= $jabatan_value == 'Camat' ? 'selected' : '' ?>>Camat</option>
          <option value="Sekretaris Kecamatan (Sekcam)" <?= $jabatan_value == 'Sekretaris Kecamatan (Sekcam)' ? 'selected' : '' ?>>Sekretaris Kecamatan (Sekcam)</option>
          <option value="Operator Kecamatan" <?= $jabatan_value == 'Operator Kecamatan' ? 'selected' : '' ?>>Operator Kecamatan</option>
          <option value="Kasi Pemerintahan" <?= $jabatan_value == 'Kasi Pemerintahan' ? 'selected' : '' ?>>Kasi Pemerintahan</option>
          <option value="Admin Umum" <?= $jabatan_value == 'Admin Umum' ? 'selected' : '' ?>>Admin Umum</option>
        </select>
      </div>

      <div class="text-end">
        <button type="submit" class="btn btn-primary">
          <i class="fas fa-save me-2"></i> Tambah Admin
        </button>
      </div>
    </form>
  </div>
</div>
