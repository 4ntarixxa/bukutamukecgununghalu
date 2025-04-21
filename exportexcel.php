<?php
include "koneksi.php";

// Persiapan untuk eksport ke Excel
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Rekap_Pengunjung_Desa_Bunijaya.xls");
header("Pragma: no-cache");
header("Expires: 0");

$tgl1 = $_GET['tanggala'] ?? '';
$tgl2 = $_GET['tanggalb'] ?? '';

// Query Data dengan JOIN ke desa dan instansi
$tampil = mysqli_query($koneksi, "
    SELECT tamu.*, desa.nama_desa AS desa, instansi.nama_instansi AS instansi
    FROM tamu
    LEFT JOIN desa ON tamu.id_desa = desa.id_desa
    LEFT JOIN instansi ON tamu.id_instansi = instansi.id_instansi
    WHERE Tanggal BETWEEN '$tgl1' AND '$tgl2'
    ORDER BY Tanggal ASC
");

$no = 1;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Rekap Tamu Desa Bunijaya</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; }
        .kop-surat { text-align: center; margin-bottom: 20px; }
        .kop-surat img { width: 80px; height: auto; position: absolute; left: 20px; top: 5px; }
        .kop-surat h2, .kop-surat h3, .kop-surat p { margin: 0; }
        .kop-surat h2 { font-size: 18px; text-transform: uppercase; }
        .kop-surat h3 { font-size: 16px; }
        .kop-surat p { font-size: 14px; }
        hr { border: 1px solid black; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid black; padding: 8px; text-align: center; }
        th { background-color: #f2f2f2; }
        .ttd { width: 100%; margin-top: 50px; text-align: right; }
        .ttd p { margin-bottom: 50px; }
    </style>
</head>
<body>

<!-- Kop Surat -->
<div class="kop-surat">
    <h2>PEMERINTAH GUNUNGHALU</h2>
    <h3>KECAMATAN GUNUNGHALU, KABUPATEN BANDUNG BARAT</h3>
    <p>Alamat:Jl. Raya Pasanggrahan No. 1, Sirnajaya, Gununghalu, Sirnajaya, Bandung Barat</p>
    <p>Telp: 0848 | Email: kecamatangununghalu@gmail.com | Web: kecamatangununghalu.co.id</p>
    <hr>
</div>

<h3>Rekap Tamu Kecamatan Gununghalu</h3>
<p>Periode: <?= htmlspecialchars($tgl1) ?> s.d. <?= htmlspecialchars($tgl2) ?></p>

<!-- Tabel Data -->
<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>Nama</th>
            <th>Alamat</th>
            <th>Desa</th>
            <th>Instansi</th>
            <th>Keperluan</th>
            <th>No HP</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($data = mysqli_fetch_array($tampil)) { ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= htmlspecialchars($data['Tanggal']) ?></td>
                <td><?= htmlspecialchars($data['Nama']) ?></td>
                <td><?= htmlspecialchars($data['Alamat']) ?></td>
                <td><?= htmlspecialchars($data['desa']) ?></td>
                <td><?= htmlspecialchars($data['instansi']) ?></td>
                <td><?= htmlspecialchars(!empty($data['KeperluanLain']) ? $data['KeperluanLain'] : $data['Keperluan']) ?></td>
                <td><?= htmlspecialchars($data['No_HP']) ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<!-- Tanda Tangan -->
<div class="ttd">
    <p>Gununghalu, <?= date("d F Y") ?></p>
    <p><b>Camat Gununghalu</b></p>
    <p style="margin-top: 60px;"><b>______________________</b></p>
</div>

</body>
</html>
