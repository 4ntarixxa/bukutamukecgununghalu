<?php
include "koneksi.php";

// Persiapan untuk eksport ke Excel
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Rekap_Pengunjung_Harian.xls");
header("Pragma: no-cache");
header("Expires: 0");

date_default_timezone_set('Asia/Jakarta');
$tanggal_hari_ini = date('Y-m-d');

// Query Data dengan join ke desa dan instansi
$tampil = mysqli_query($koneksi, "
    SELECT tamu.*, desa.nama_desa AS desa, instansi.nama_instansi AS instansi
    FROM tamu
    LEFT JOIN desa ON tamu.id_desa = desa.id_desa
    LEFT JOIN instansi ON tamu.id_instansi = instansi.id_instansi
    WHERE Tanggal = '$tanggal_hari_ini'
");

$no = 1;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Rekap Tamu Hari ini</title>
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
        .garis-tangan { margin-top: 70px; border-bottom: 1px solid black; width: 200px; text-align: center; margin-left: auto; }
    </style>
</head>
<body>

<!-- Kop Surat -->
<div class="kop-surat">
    <h2>PEMERINTAH GUNUNGHALU</h2>
    <h3>KECAMATAN GUNUNGHALU, KABUPATEN BANDUNG BARAT</h3>
    <p>Alamat: Jl. Raya Pasanggrahan No. 1, Sirnajaya, Gununghalu, Bandung Barat</p>
    <p>Telp: 0848 | Email: kecamatangununghalu@gmail.com | Web: kecamatangununghalu.co.id</p>
    <hr>
</div>

<h3>Rekap Tamu Hari Ini</h3>
<p>Tanggal: <?= date('d F Y') ?></p>

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
    <p><b>Camat Kecamatan Gununghalu</b></p>
    <div class="garis-tangan"></div>
</div>

</body>
</html>
