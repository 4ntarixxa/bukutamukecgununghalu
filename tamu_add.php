<?php
include "koneksi.php";

// Ambil data desa
$query_desa = mysqli_query($koneksi, "SELECT * FROM desa");
$data_desa = [];
while ($row = mysqli_fetch_assoc($query_desa)) {
    $data_desa[] = $row;
}

// Ambil data instansi
$query_instansi = mysqli_query($koneksi, "SELECT * FROM instansi");
$data_instansi = [];
while ($row = mysqli_fetch_assoc($query_instansi)) {
    $data_instansi[] = $row;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $Tanggal = $_POST['Tanggal'];
    $Nama = $_POST['Nama'];
    $id_desa = $_POST['id_desa'];
    $id_instansi = $_POST['id_instansi'];
    $Kampung = $_POST['Kampung'];
    $Alamat = "$Kampung"; // Alamat hanya kampung, desa dihubungkan lewat id_desa
    $Keperluan = ($_POST['Keperluan'] === 'Isi Sendiri') ? $_POST['KeperluanLain'] : $_POST['Keperluan'];
    $No_HP = $_POST['No_HP'];

    // Validasi no HP
    if (!preg_match('/^08[0-9]{8,11}$/', $No_HP)) {
        echo "<script>alert('Format No. HP tidak valid! Harus diawali 08 dan panjang 10-13 digit.');</script>";
    } else {
        $sql = "INSERT INTO tamu (Tanggal, Nama, Alamat, Keperluan, No_HP, id_desa, id_instansi)
                VALUES ('$Tanggal', '$Nama', '$Alamat', '$Keperluan', '$No_HP', '$id_desa', '$id_instansi')";
        $query = mysqli_query($koneksi, $sql);

        if ($query) {
            echo "<script>window.location = '?dashboard=tamu&notif=add-berhasil';</script>";
        } else {
            echo "<script>alert('Gagal menambahkan data!');</script>";
        }
    }
}
?>

<div class="card shadow p-4">
    <div class="card-header bg-primary text-white">
        <div class="row">
            <div class="col-md-8">
                <h4 class="card-title mb-0">Menambah Data Tamu</h4>
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
                <input type="date" class="form-control" id="Tanggal" name="Tanggal" value="<?php echo date('Y-m-d'); ?>" required>
            </div>

            <div class="mb-3">
                <label for="Nama" class="form-label">Nama</label>
                <input type="text" class="form-control" id="Nama" name="Nama" required>
            </div>

            <div class="mb-3">
                <label for="id_desa" class="form-label">Desa</label>
                <select name="id_desa" id="id_desa" class="form-select" required onchange="updateKampungList()">
                    <option value="">-- Pilih Desa --</option>
                    <?php foreach ($data_desa as $desa): ?>
                        <option value="<?= $desa['id_desa'] ?>"><?= $desa['nama_desa'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="Kampung" class="form-label">Kampung</label>
                <input list="daftarKampung" class="form-control" id="Kampung" name="Kampung" required>
                <datalist id="daftarKampung"></datalist>
            </div>

            <div class="mb-3">
                <label for="id_instansi" class="form-label">Instansi</label>
                <select name="id_instansi" id="id_instansi" class="form-select" required>
                    <option value="">-- Pilih Instansi --</option>
                    <?php foreach ($data_instansi as $instansi): ?>
                        <option value="<?= $instansi['id_instansi'] ?>"><?= $instansi['nama_instansi'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="Keperluan" class="form-label">Keperluan</label>
                <select class="form-select" id="Keperluan" name="Keperluan" required onchange="toggleKeperluanLain()">
                    <option value="Urusan">Urusan Administrasi Kependudukan</option>
                    <option value="Perizinan">Perizinan dan Surat Keterangan</option>
                    <option value="Pengaduan">Pengaduan Masyarakat</option>
                    <option value="Rapat">Rapat dan Koordinasi</option>
                    <option value="Bantuan">Bantuan Sosial</option>
                    <option value="Pernikahan">Pernikahan dan Urusan Keagamaan</option>
                    <option value="Kegiatan">Kegiatan Masyarakat</option>
                    <option value="Isi Sendiri">Isi Sendiri</option>
                </select>
            </div>

            <div class="mb-3 d-none" id="keperluanLainDiv">
                <label for="KeperluanLain" class="form-label">Keperluan Lainnya</label>
                <input type="text" class="form-control" id="KeperluanLain" name="KeperluanLain" placeholder="Masukkan keperluan lainnya">
            </div>

            <div class="mb-3">
                <label for="No_HP" class="form-label">No. HP</label>
                <input type="text" class="form-control" id="No_HP" name="No_HP" required placeholder="Contoh: 081234567890">
            </div>

            <button type="submit" class="btn btn-info w-100">
                <i class="bi bi-plus-circle"></i> Tambah Tamu
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
        var keperluan = document.getElementById("Keperluan").value;
        var keperluanLainInput = document.getElementById("KeperluanLain").value.trim();
        var noHp = document.getElementById("No_HP").value.trim();

        if (keperluan === "Isi Sendiri" && keperluanLainInput === "") {
            alert("Harap isi keperluan lainnya!");
            return false;
        }

        var noHpPattern = /^08[0-9]{8,11}$/;
        if (!noHpPattern.test(noHp)) {
            alert("Nomor HP tidak valid! Harus diawali 08 dan terdiri dari 10-13 digit angka.");
            return false;
        }

        return true;
    }

    const dataKampung = {
        "1": ["Kp. Ciharendong", "Kp. Puncak", "Kp. Sukalaksana"],
        "2": ["Kp. Pasirjambu", "Kp. Cibunut", "Kp. Cikaret"],
        "3": ["Kp. Sukatani", "Kp. Cibeureum"],
        "4": ["Kp. Cibitung", "Kp. Gununghalu"],
        "5": ["Kp. Sukamulya", "Kp. Babakan"],
        "6": ["Kp. Sukarasa", "Kp. Sirnajaya"],
        "7": ["Kp. Cijambu", "Kp. Sukasari"],
        "8": ["Kp. Cikawari", "Kp. Taman"],
        "9": ["Kp. Sukasari", "Kp. Rancabali"]
    };

    function updateKampungList() {
        const desaId = document.getElementById("id_desa").value;
        const kampungList = document.getElementById("daftarKampung");

        kampungList.innerHTML = "";

        if (dataKampung[desaId]) {
            dataKampung[desaId].forEach(kp => {
                const option = document.createElement("option");
                option.value = kp;
                kampungList.appendChild(option);
            });
        }
    }
</script>
