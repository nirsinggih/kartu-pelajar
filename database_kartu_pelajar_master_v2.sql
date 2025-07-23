-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 21 Jul 2025 pada 10.27
-- Versi server: 10.3.39-MariaDB-cll-lve
-- Versi PHP: 8.4.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fyxhpdmx_versi-2`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengaturan`
--

CREATE TABLE `pengaturan` (
  `id` int(11) NOT NULL,
  `nama_sekolah` varchar(100) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `kepala_sekolah` varchar(100) DEFAULT NULL,
  `nip_kepala_sekolah` varchar(30) NOT NULL,
  `tanggal_ttd` date DEFAULT NULL,
  `logo` varchar(100) DEFAULT NULL,
  `tanda_tangan` varchar(100) DEFAULT NULL,
  `background` varchar(100) DEFAULT NULL,
  `background_belakang` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data untuk tabel `pengaturan`
--

INSERT INTO `pengaturan` (`id`, `nama_sekolah`, `alamat`, `kepala_sekolah`, `nip_kepala_sekolah`, `tanggal_ttd`, `logo`, `tanda_tangan`, `background`, `background_belakang`) VALUES
(1, 'SD NEGERI BERMUTU', 'Jalan Kebagusan, RT.27 RW.05 Kelurahan Sumberberkah, Kec. Gemahripah', 'Nir Singgih Purwantio, S.Pd.', '198705092021021004', '2025-07-14', 'logo_1753066228.png', 'ttd_1753066228.png', 'bg_1753067414.jpg', 'bg2_1753067767.jpg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `siswa`
--

CREATE TABLE `siswa` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `nis` varchar(20) NOT NULL,
  `nisn` varchar(20) NOT NULL,
  `kelas` varchar(20) DEFAULT NULL,
  `jenis_kelamin` enum('L','P') NOT NULL,
  `tempat_lahir` varchar(50) DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `foto` varchar(100) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data untuk tabel `siswa`
--

INSERT INTO `siswa` (`id`, `nama`, `nis`, `nisn`, `kelas`, `jenis_kelamin`, `tempat_lahir`, `tanggal_lahir`, `foto`, `user_id`) VALUES
(27, 'Eko Prasetyo', '105', '9920005', '6A', 'L', 'Bogor', '2012-01-17', NULL, 28),
(28, 'Fajar Hidayat', '106', '9290006', '6B', 'L', 'Depok', '2012-02-10', NULL, 29),
(29, 'Gita Permata', '107', '9902007', '6B', 'P', 'Surabaya', '2012-03-19', NULL, 30),
(30, 'Hani Maharani', '108', '99022008', '6B', 'P', 'Semarang', '2012-07-21', NULL, 31),
(31, 'Ilham Ramadhan', '109', '9920009', '6B', 'L', 'Yogyakarta', '2012-09-11', NULL, 32),
(32, 'Joko Anwar', '110', '9902010', '6B', 'L', 'Malang', '2012-11-25', NULL, 33),
(34, 'Lia Wulandari', '112', '9290012', '6C', 'P', 'Bekasi', '2012-05-05', NULL, 35),
(35, 'Mila Kartika', '113', '9920013', '6C', 'P', 'Bogor', '2012-06-06', NULL, 36),
(36, 'Nina Sari', '114', '9900214', '6C', 'P', 'Jakarta', '2012-08-08', NULL, 37),
(37, 'Oki Prabowo', '115', '9920015', '6C', 'L', 'Tangerang', '2012-09-09', NULL, 38),
(38, 'Putri Ayu', '116', '9902016', '6D', 'P', 'Depok', '2012-10-10', NULL, 39),
(39, 'Qori Maulida', '117', '9290017', '6D', 'P', 'Surabaya', '2012-11-11', NULL, 40),
(40, 'Rafi Ahmad', '118', '9290018', '6D', 'L', 'Semarang', '2012-12-12', NULL, 41),
(41, 'Siti Nurhaliza', '119', '9920019', '6D', 'P', 'Medan', '2012-04-14', NULL, 42),
(46, 'Dindi Handayani', '4004', '7900004', '6B', 'P', 'Yogyakarta', '2025-07-08', NULL, 47),
(47, 'Ekod Wijaya', '4005', '7900005', '6B', 'L', 'Bekasi', '0000-00-00', NULL, 48),
(49, 'Nir Singgih', '3001', '4900001', '6A', 'L', 'Jakarta', '2019-01-14', NULL, 50),
(50, 'nama siswa 1', '3002', '4900002', '6A', 'L', 'Bandung', '2025-07-04', NULL, 51),
(52, 'nama siswa 3', '3004', '4900004', '6B', 'P', 'Yogyakarta', '0000-00-00', NULL, 53),
(53, 'nama siswa 4', '3005', '4900005', '6B', 'L', 'Bekasi', '0000-00-00', NULL, 54),
(54, 'nama siswa 5', '3006', '4900006', '6B', 'L', 'Bekasi', '0000-00-00', NULL, 55),
(55, 'nama siswa 6', '3007', '4900007', '6B', 'L', 'Bekasi', '0000-00-00', NULL, 56),
(56, 'nama siswa 7', '3008', '4900008', '6B', 'L', 'Bekasi', '0000-00-00', NULL, 57),
(57, 'nama siswa 8', '3009', '4900009', '6B', 'L', 'Bekasi', '0000-00-00', NULL, 58),
(58, 'nama siswa 9', '3010', '4900010', '6B', 'L', 'Bekasi', '0000-00-00', NULL, 59),
(59, 'nama siswa 10', '3011', '4900011', '6B', 'L', 'Bekasi', '0000-00-00', NULL, 60),
(60, 'nama siswa 11', '3012', '4900012', '6B', 'L', 'Bekasi', '0000-00-00', NULL, 61);

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','siswa') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`) VALUES
(1, 'admin', '0192023a7bbd73250516f069df18b500', 'admin'),
(2, '3219876540', '0d68527823d072cda9852b19b96c1d5a', 'siswa'),
(3, '3219876541', 'be79cf677d3412938ea9730af6b2a984', 'siswa'),
(4, '990001', '34ade1ad6d79826b1662cb2983fa054d', 'siswa'),
(5, '990002', 'a3a5288bff9e1c4a339b7c7b1eb46864', 'siswa'),
(6, '990003', 'f54849b5c5e3c62375dbcaa5ebf809b8', 'siswa'),
(7, '990004', '20a1517feba804ce02296d33600fcf23', 'siswa'),
(8, '990005', 'b12a09e8f77c6625fbbd8dc8060de6e1', 'siswa'),
(9, '990006', '99a7ffb95e0dfee84b248929abd3d1e6', 'siswa'),
(10, '990007', '06805869900cc5e0ed26a2aa5b7fba1f', 'siswa'),
(11, '990008', 'b4ec0c90bcf1f8fc542790e0d1a4e903', 'siswa'),
(12, '990009', '36c586828acbeeda9a928adc910fe864', 'siswa'),
(13, '990010', '80ed2ae9ce754f98307a39298f420049', 'siswa'),
(14, '990011', '32939432d153b202023a450f3fa78b92', 'siswa'),
(15, '990012', '885210216cff4143c8af0f00576674ba', 'siswa'),
(16, '990013', '59697dc4a97115dc05e3f7a8365856cf', 'siswa'),
(17, '990014', '9392d08acae0a738ed3892761ab0ea94', 'siswa'),
(18, '990015', 'abcc766da0d38fe68d04dcf203a8cf3e', 'siswa'),
(19, '990016', 'b7656e76efe932daafc2bd2e20611994', 'siswa'),
(20, '990017', '0d2b1d9ed411a06b153c3be527e4fbca', 'siswa'),
(21, '990018', '0ac53b8a9d842a6520d7361d6aee5eb9', 'siswa'),
(22, '990019', 'f087328f042ab10f2eeecab215a268d4', 'siswa'),
(23, '990020', '1df303ad32de2b30394761d34e067e0b', 'siswa'),
(24, '9900201', '8af1de420750ff05359848a32da968c3', 'siswa'),
(25, '9902002', 'ddc37583d7dfed7c3931fc3f3e5ae124', 'siswa'),
(26, '99220003', '7830f68504d1159569158c13077b41c9', 'siswa'),
(27, '9902004', 'e858afc7f3fd34bf9f68ff23f0fc25b3', 'siswa'),
(28, '9920005', 'c46b173516788fe477cb8544b9b33385', 'siswa'),
(29, '9290006', 'a85abd5f7b3c783015ad74e00336235d', 'siswa'),
(30, '9902007', 'f7d0af188129d6df13007a1ac84cf9da', 'siswa'),
(31, '99022008', 'e5006eb6ffd24606f4d530ed0a13a161', 'siswa'),
(32, '9920009', '8ed00e41a021cc261c838268cdd50bc0', 'siswa'),
(33, '9902010', 'b8fa50adf83d17aabbc0234450af9cee', 'siswa'),
(34, '9902011', 'c3318b01fbe398ca828ad8fc9be9697f', 'siswa'),
(35, '9290012', 'cac01e0faf38c199aea975effba0eb7e', 'siswa'),
(36, '9920013', '6d81264841b9167a68dc83c62de9f0d5', 'siswa'),
(37, '9900214', 'ace291b0f8f2301b55c669864ddb58c5', 'siswa'),
(38, '9920015', 'e1eb91f5f81699a222e5866fac12c97a', 'siswa'),
(39, '9902016', '2f76f411fd82d8e9ea829ea517dab7ac', 'siswa'),
(40, '9290017', 'e6d343d924770629c4b6c77efcc2fd73', 'siswa'),
(41, '9290018', '4285bb6ddacdef0e87eade2ab7757441', 'siswa'),
(42, '9920019', '6260f46c67c735f9f13a0c2efcbe4381', 'siswa'),
(43, '9900220', '8c61e2ac9d4db324e59bb1fc2cd4d036', 'siswa'),
(44, '7900001', 'c6e6739b5317341b3ad5b80646a3d70a', 'siswa'),
(45, '7900002', '88630cb2226c6f90e434842b8ae0e0f0', 'siswa'),
(46, '7900003', '4b82bc0867485d42c0c5cd3894057fc0', 'siswa'),
(47, '7900004', 'd3f1551851635e7bb77d567461df902b', 'siswa'),
(48, '7900005', 'bcf458277d7d2abfafdf89ea56d4f69c', 'siswa'),
(49, '3219876542', 'd651b5cac87901a5497e3cdba2c28abc', 'siswa'),
(50, '4900001', '5bf1c8554646a5e45892cca42c50d54b', 'siswa'),
(51, '4900002', 'aa7aa2038d9a18f9bfc9915d97d5da30', 'siswa'),
(52, '4900003', '23d418628369cf40b93151993ec34a4d', 'siswa'),
(53, '4900004', '95f0f5b30a42d93b32ccbc2a0ac36e92', 'siswa'),
(54, '4900005', '106124d58a1dc19d84ff873086c6cf6e', 'siswa'),
(55, '4900006', 'c371c9a6b97e0d3c79993c1f2851c3f7', 'siswa'),
(56, '4900007', '1127ad6cfec012e29bc368faad20a223', 'siswa'),
(57, '4900008', '61da1a8cb0bded0b33b900a02594e319', 'siswa'),
(58, '4900009', 'b0160ee9bfb98dc668ad058d47a16aa3', 'siswa'),
(59, '4900010', 'beed6194936f826d49c49c86cc650f1d', 'siswa'),
(60, '4900011', '6b9e1e340b522724c2d2fb8bb2260430', 'siswa'),
(61, '4900012', 'fd77cf6a57d0f4a538ba516d51d68a57', 'siswa');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `pengaturan`
--
ALTER TABLE `pengaturan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nis` (`nis`),
  ADD UNIQUE KEY `nisn` (`nisn`),
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `siswa`
--
ALTER TABLE `siswa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `siswa`
--
ALTER TABLE `siswa`
  ADD CONSTRAINT `siswa_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
