-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 17 Apr 2025 pada 21.45
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_bukutamu`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `desa`
--

CREATE TABLE `desa` (
  `id_desa` int(11) NOT NULL,
  `nama_desa` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `desa`
--

INSERT INTO `desa` (`id_desa`, `nama_desa`) VALUES
(1, 'Bunijaya'),
(2, 'Celak'),
(3, 'Cilangari'),
(4, 'Gununghalu'),
(5, 'Sindangjaya'),
(6, 'Sirnajaya'),
(7, 'Sukasari'),
(8, 'Tamanjaya'),
(9, 'Wargasaluyu​');

-- --------------------------------------------------------

--
-- Struktur dari tabel `instansi`
--

CREATE TABLE `instansi` (
  `id_instansi` int(11) NOT NULL,
  `nama_instansi` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `instansi`
--

INSERT INTO `instansi` (`id_instansi`, `nama_instansi`) VALUES
(1, 'Kantor Pemerintah Desa'),
(2, 'SD Negeri 1 Bunijaya'),
(3, 'SD Negeri 1 Celak'),
(4, 'SD Negeri 1 Cilangari'),
(5, 'SD Negeri 1 Gununghalu'),
(6, 'SD Negeri 1 Sodong (Tamanjaya)'),
(7, 'SD Negeri 2 Bunijaya'),
(8, 'SD Negeri 2 Celak'),
(9, 'SD Negeri 2 Cilangari'),
(10, 'SD Negeri 2 Gununghalu'),
(11, 'SD Negeri 2 Sodong'),
(12, 'Polsek Gununghalu'),
(13, 'Puskesmas'),
(14, 'Koordinator Statistik Kecamatan (KSK)'),
(15, 'Badan Permusyawaratan Desa (BPD)'),
(16, 'Majelis Ulama Indonesia (MUI) Desa'),
(17, 'PKK Desa');

-- --------------------------------------------------------

--
-- Struktur dari tabel `keperluan`
--

CREATE TABLE `keperluan` (
  `id` int(11) NOT NULL,
  `nama_keperluan` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tamu`
--

CREATE TABLE `tamu` (
  `id` int(11) NOT NULL,
  `Tanggal` date NOT NULL,
  `Nama` varchar(100) NOT NULL,
  `Alamat` text NOT NULL,
  `Keperluan` varchar(255) NOT NULL,
  `No_HP` varchar(15) NOT NULL,
  `id_desa` int(11) DEFAULT NULL,
  `id_instansi` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tamu`
--

INSERT INTO `tamu` (`id`, `Tanggal`, `Nama`, `Alamat`, `Keperluan`, `No_HP`, `id_desa`, `id_instansi`) VALUES
(1, '2025-04-17', 'Pak Kades', 'Kp. Pasirjambu', 'Kegiatan', '083829174747', 2, 17);

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama_pengguna` varchar(100) NOT NULL,
  `jabatan` enum('Kepala Desa','Sekretaris Desa','Operator Kecamatan','Kasi Pemerintahan','Admin Umum') NOT NULL,
  `status` enum('aktif','tidak-aktif') NOT NULL DEFAULT 'aktif'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id_user`, `username`, `password`, `nama_pengguna`, `jabatan`, `status`) VALUES
(1, 'raman', 'dfca227007055ab0a55470be0fed8541', 'Ramandika Aja', 'Kepala Desa', 'aktif');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `desa`
--
ALTER TABLE `desa`
  ADD PRIMARY KEY (`id_desa`);

--
-- Indeks untuk tabel `instansi`
--
ALTER TABLE `instansi`
  ADD PRIMARY KEY (`id_instansi`);

--
-- Indeks untuk tabel `keperluan`
--
ALTER TABLE `keperluan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tamu`
--
ALTER TABLE `tamu`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_desa` (`id_desa`),
  ADD KEY `id_instansi` (`id_instansi`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `desa`
--
ALTER TABLE `desa`
  MODIFY `id_desa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `instansi`
--
ALTER TABLE `instansi`
  MODIFY `id_instansi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT untuk tabel `keperluan`
--
ALTER TABLE `keperluan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tamu`
--
ALTER TABLE `tamu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `tamu`
--
ALTER TABLE `tamu`
  ADD CONSTRAINT `tamu_ibfk_1` FOREIGN KEY (`id_desa`) REFERENCES `desa` (`id_desa`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `tamu_ibfk_2` FOREIGN KEY (`id_instansi`) REFERENCES `instansi` (`id_instansi`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
