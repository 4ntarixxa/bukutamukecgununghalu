<?php
include "koneksi.php";

$id = $_GET['id'] ?? null;

if ($id) {
    $pilih = mysqli_query($koneksi, "SELECT * FROM tamu WHERE id='$id'");
    $data = mysqli_fetch_assoc($pilih);
} else {
    echo "<script>alert('ID tidak ditemukan!'); window.location.href='index.php?dashboard=tamu';</script>";
    exit;
}

$errorNoHP = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $Tanggal = $_POST['Tanggal'];
    $Nama = $_POST['Nama'];
    $Alamat = $_POST['Alamat'];
    $Keperluan = ($_POST['Keperluan'] === 'Isi Sendiri') ? $_POST['KeperluanLain'] : $_POST['Keperluan'];
    $No_HP = $_POST['No_HP'];
    $id_desa = $_POST['id_desa'];
    $id_instansi = $_POST['id_instansi'];

    // Validasi nomor HP
    if (!ctype_digit($No_HP)) {
        $errorNoHP = "Maaf, nomor HP tidak boleh mengandung huruf.";
    } elseif (strlen($No_HP) < 10 || strlen($No_HP) > 13) {
        $errorNoHP = "Nomor HP harus memiliki panjang antara 10 hingga 13 digit.";
    } elseif (substr($No_HP, 0, 2) !== "08") {
        $errorNoHP = "Nomor HP harus diawali dengan '08'.";
    } else {
        // Jika validasi lolos
        $sql = "UPDATE tamu SET Tanggal='$Tanggal', Nama='$Nama', Alamat='$Alamat', Keperluan='$Keperluan', No_HP='$No_HP', id_desa='$id_desa', id_instansi='$id_instansi' WHERE id='$id'";
        $query = mysqli_query($koneksi, $sql);

        if ($query) {
            echo "<script>window.location = 'index.php?dashboard=tamu&notif=edit-berhasil';</script>";
            exit;
        } else {
            echo "<script>alert('Gagal memperbarui data!');</script>";
        }
    }
}

// Ambil data desa dan instansi
$desa = mysqli_query($koneksi, "SELECT * FROM desa");
$instansi = mysqli_query($koneksi, "SELECT * FROM instansi");
?>

<div class="card shadow p-4">
  <div class="card-header bg-primary text-white">
    <div class="row">
      <div class="col-md-8">
        <h4 class="card-title mb-0">Edit Tamu - <?php echo htmlspecialchars($data['Nama']); ?></h4>
      </div>
      <div class="col-md-4 text-end">
        <a href="index.php?dashboard=tamu" class="btn btn-light btn-sm">
          <i class="fas fa-arrow-left me-2"></i> Kembali
        </a>
      </div>
    </div>
  </div>
  <div class="card-body">
    <form action="" method="post" onsubmit="return validateForm()">
      <div class="mb-3">
        <label for="Tanggal" class="form-label">Tanggal</label>
        <input type="date" class="form-control" id="Tanggal" name="Tanggal" value="<?php echo htmlspecialchars($data['Tanggal']); ?>" required>
      </div>
      <div class="mb-3">
        <label for="Nama" class="form-label">Nama</label>
        <input type="text" class="form-control" id="Nama" name="Nama" value="<?php echo htmlspecialchars($data['Nama']); ?>" required>
      </div>
      <div class="mb-3">
        <label for="Alamat" class="form-label">Alamat</label>
        <input type="text" class="form-control" id="Alamat" name="Alamat" value="<?php echo htmlspecialchars($data['Alamat']); ?>" required>
      </div>
      
      <!-- Tambah Desa -->
      <div class="mb-3">
        <label for="id_desa" class="form-label">Desa</label>
        <select name="id_desa" id="id_desa" class="form-select" required>
          <option value="">-- Pilih Desa --</option>
          <?php while ($d = mysqli_fetch_assoc($desa)) { ?>
            <option value="<?php echo $d['id_desa']; ?>" <?php echo ($d['id_desa'] == $data['id_desa']) ? 'selected' : ''; ?>>
              <?php echo $d['nama_desa']; ?>
            </option>
          <?php } ?>
        </select>
      </div>

      <!-- Tambah Instansi -->
      <div class="mb-3">
        <label for="id_instansi" class="form-label">Instansi</label>
        <select name="id_instansi" id="id_instansi" class="form-select" required>
          <option value="">-- Pilih Instansi --</option>
          <?php while ($i = mysqli_fetch_assoc($instansi)) { ?>
            <option value="<?php echo $i['id_instansi']; ?>" <?php echo ($i['id_instansi'] == $data['id_instansi']) ? 'selected' : ''; ?>>
              <?php echo $i['nama_instansi']; ?>
            </option>
          <?php } ?>
        </select>
      </div>

      <div class="mb-3">
        <label for="Keperluan" class="form-label">Keperluan</label>
        <select class="form-select" id="Keperluan" name="Keperluan" required onchange="toggleKeperluanLain()">
          <?php
          $keperluanList = [
            "Urusan Administrasi Kependudukan", "Perizinan dan Surat Keterangan", "Pengaduan Masyarakat",
            "Rapat dan Koordinasi", "Bantuan Sosial", "Pernikahan dan Urusan Keagamaan",
            "Kegiatan Masyarakat", "Isi Sendiri"
          ];
          foreach ($keperluanList as $item) {
              $selected = ($data['Keperluan'] === $item) ? "selected" : "";
              echo "<option value='$item' $selected>$item</option>";
          }
          ?>
        </select>
      </div>
      <div class="mb-3 <?php echo ($data['Keperluan'] === 'Isi Sendiri') ? '' : 'd-none'; ?>" id="keperluanLainDiv">
        <label for="KeperluanLain" class="form-label">Keperluan Lainnya</label>
        <input type="text" class="form-control" id="KeperluanLain" name="KeperluanLain"
          value="<?php echo ($data['Keperluan'] === 'Isi Sendiri') ? htmlspecialchars($data['Keperluan']) : ''; ?>"
          placeholder="Masukkan keperluan lainnya">
      </div>
      <div class="mb-3">
        <label for="No_HP" class="form-label">No. HP</label>
        <input type="text" class="form-control <?php echo $errorNoHP ? 'is-invalid' : ''; ?>" id="No_HP" name="No_HP" value="<?php echo htmlspecialchars($data['No_HP']); ?>" required>
        <?php if ($errorNoHP): ?>
          <div class="invalid-feedback"><?php echo $errorNoHP; ?></div>
        <?php endif; ?>
      </div>
      <button type="submit" class="btn btn-info w-100">
        <i class="bi bi-save"></i> Simpan Perubahan
      </button>
    </form>
  </div>
</div>

<script>
function toggleKeperluanLain() {
    var keperluan = document.getElementById("Keperluan").value;
    var keperluanLainDiv = document.getElementById("keperluanLainDiv");
    var keperluanLainInput = document.getElementById("KeperluanLain");

    if (keperluan === "Isi Sendiri") {
        keperluanLainDiv.classList.remove("d-none");
        keperluanLainInput.setAttribute("required", "required");
    } else {
        keperluanLainDiv.classList.add("d-none");
        keperluanLainInput.removeAttribute("required");
        keperluanLainInput.value = "";
    }
}

function validateForm() {
    let noHpField = document.getElementById("No_HP");
    let noHp = noHpField.value.trim();
    noHpField.classList.remove("is-invalid");

    if (!/^\d+$/.test(noHp)) {
        alert("Maaf, nomor HP tidak boleh mengandung huruf.");
        noHpField.classList.add("is-invalid");
        return false;
    }

    if (noHp.length < 10 || noHp.length > 13) {
        alert("Nomor HP harus memiliki panjang antara 10 hingga 13 digit.");
        noHpField.classList.add("is-invalid");
        return false;
    }

    if (!noHp.startsWith("08")) {
        alert("Nomor HP harus diawali dengan '08'.");
        noHpField.classList.add("is-invalid");
        return false;
    }

    return true;
}

toggleKeperluanLain();
</script>
