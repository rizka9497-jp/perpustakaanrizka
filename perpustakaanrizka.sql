-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 01, 2025 at 02:40 AM
-- Server version: 8.0.30
-- PHP Version: 8.2.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `perpustakaanrizka`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `idadmin` int NOT NULL,
  `nama` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `foto` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`idadmin`, `nama`, `password`, `username`, `foto`) VALUES
(6, 'Mayila', '$2y$10$Bo/EbK0CqA0/q0r0sCYw9.enY.VsH25NF9N1A9M1w0lo2xbeaUijK', 'april.l', '20251028015130_Screenshot 2025-07-29 204312.png'),
(16, 'rizka9', '555', 'rizka7', NULL),
(26, 'rizkaaulia', '88888', 'username', '20251029022521_Screenshot 2025-07-19 205207.png'),
(27, 'Mayila', '7890', 'username', '20251030073315_Screenshot 2025-07-29 204312.png');

-- --------------------------------------------------------

--
-- Table structure for table `buku`
--

CREATE TABLE `buku` (
  `idbuku` int NOT NULL,
  `judul` varchar(255) NOT NULL,
  `pengarang` varchar(100) DEFAULT NULL,
  `tahun_terbit` year DEFAULT NULL,
  `stok` int NOT NULL,
  `idkategori` int DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `idrak` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `buku`
--

INSERT INTO `buku` (`idbuku`, `judul`, `pengarang`, `tahun_terbit`, `stok`, `idkategori`, `foto`, `idrak`) VALUES
(4, 'Sebuah Seni untuk Bersikap Bodo Amat', 'Mark Manson', 2016, 50, 6, 'bodo_amat.jpg', 2),
(10, 'Rich Dad Poor Dad', 'Robert Kiyosaki', 1997, 30, 8, '20251028013428_Screenshot 2025-07-19 203620.png', 6),
(24, 'sikancil', 'yuu', 2009, 3, 6, '20251027035747_Screenshot 2025-07-29 204312.png', 1),
(28, 'jiji', 'iy', 2009, 3, 3, '20251031021046_Gemini_Generated_Image_3oj26c3oj26c3oj2.png', 2);

-- --------------------------------------------------------

--
-- Table structure for table `denda`
--

CREATE TABLE `denda` (
  `iddenda` int NOT NULL,
  `jumlahdenda` decimal(10,2) NOT NULL,
  `statuspembayaran` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `denda`
--

INSERT INTO `denda` (`iddenda`, `jumlahdenda`, `statuspembayaran`) VALUES
(1, '50000.00', 'Belum Lunas'),
(2, '15000.50', 'Lunas'),
(3, '100000.00', 'Dicicil');

-- --------------------------------------------------------

--
-- Table structure for table `detailpeminjaman`
--

CREATE TABLE `detailpeminjaman` (
  `iddetailpeminjaman` int NOT NULL,
  `iddenda` int DEFAULT NULL,
  `idpeminjaman` int NOT NULL,
  `idbuku` int NOT NULL,
  `total` int NOT NULL,
  `tanggalpinjam` date NOT NULL,
  `tanggalkembali` date NOT NULL,
  `tanggaldikembalikan` date NOT NULL,
  `durasipeminjaman` int NOT NULL,
  `jumlahharitelat` int NOT NULL,
  `status` enum('terlambat,tidakterlambat') NOT NULL,
  `keterangan` enum('sudahkembali,belumkembali') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `detailpeminjaman`
--

INSERT INTO `detailpeminjaman` (`iddetailpeminjaman`, `iddenda`, `idpeminjaman`, `idbuku`, `total`, `tanggalpinjam`, `tanggalkembali`, `tanggaldikembalikan`, `durasipeminjaman`, `jumlahharitelat`, `status`, `keterangan`) VALUES
(3, 1, 7, 24, 4, '2025-10-31', '2025-10-05', '2025-10-06', 5, 1, 'terlambat,tidakterlambat', 'sudahkembali,belumkembali');

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `idkategori` int NOT NULL,
  `namakategori` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`idkategori`, `namakategori`) VALUES
(3, 'masalalu'),
(6, 'Kesehatan'),
(8, 'Bisnis'),
(9, 'pelajaran'),
(17, 'non fiksi');

-- --------------------------------------------------------

--
-- Table structure for table `peminjam`
--

CREATE TABLE `peminjam` (
  `idpeminjam` int NOT NULL,
  `namapeminjam` varchar(100) NOT NULL,
  `alamat` text,
  `notelpon` varchar(15) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `peminjam`
--

INSERT INTO `peminjam` (`idpeminjam`, `namapeminjam`, `alamat`, `notelpon`, `foto`) VALUES
(1, 'Rizka Aulia', 'Jl. Kesehatanman', '081234567890', '20251029003253_Screenshot 2025-07-29 204312.png'),
(2, 'Siti Rahayu', 'Komplek Griya Indah Blok B7, Bandung', '085678901234', '20251028035610_Screenshot 2025-07-19 203131.png'),
(3, 'Joko Susilo', 'Perumahan Elok No. 44, Surabaya', '087890123456', '20251029034558_piket.png'),
(4, 'Lina Amelia', 'Gg. Mawar Merah 1A, Yogyakarta', '089012345678', '20251028031636_Screenshot 2025-07-19 210214.png'),
(5, 'Naufal Hafiz', 'Blok Mawar RT 05/RW 02, Bekasi', '081122334455', '20251027051953_Screenshot 2025-07-29 204312.png'),
(8, 'rizka', 'simpang', '0987654321', '20251027045957_Screenshot 2025-07-29 204312.png'),
(10, 'usi', 'lima mungkur', '081122334455', '20251030034649_Screenshot 2025-08-05 123938.png');

-- --------------------------------------------------------

--
-- Table structure for table `peminjaman`
--

CREATE TABLE `peminjaman` (
  `idpeminjaman` int NOT NULL,
  `idpeminjam` int NOT NULL,
  `idadmin` int NOT NULL,
  `idbuku` int NOT NULL,
  `tanggal_pinjam` date NOT NULL DEFAULT (curdate()),
  `tanggal_kembali` date DEFAULT NULL,
  `status` enum('Dipinjam','Dikembalikan') DEFAULT 'Dipinjam',
  `denda` int DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `peminjaman`
--

INSERT INTO `peminjaman` (`idpeminjaman`, `idpeminjam`, `idadmin`, `idbuku`, `tanggal_pinjam`, `tanggal_kembali`, `status`, `denda`) VALUES
(7, 8, 16, 0, '2025-10-31', NULL, 'Dipinjam', 0),
(8, 5, 6, 0, '2025-10-31', NULL, 'Dipinjam', 0);

-- --------------------------------------------------------

--
-- Table structure for table `rak`
--

CREATE TABLE `rak` (
  `Idrak` int NOT NULL,
  `Namarak` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `rak`
--

INSERT INTO `rak` (`Idrak`, `Namarak`) VALUES
(1, 'Rak Novel'),
(2, 'Rak Filsafat'),
(3, 'Rak Psikologi'),
(4, 'Rak Sejarah'),
(5, 'Rak Sains'),
(6, 'Rak Teknologi'),
(7, 'Rak Kesehatan'),
(8, 'Rak Biografi'),
(9, 'Rak Motivasi'),
(10, '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`idadmin`);

--
-- Indexes for table `buku`
--
ALTER TABLE `buku`
  ADD PRIMARY KEY (`idbuku`),
  ADD KEY `idkategori` (`idkategori`),
  ADD KEY `fk_buku_rak` (`idrak`);

--
-- Indexes for table `denda`
--
ALTER TABLE `denda`
  ADD PRIMARY KEY (`iddenda`);

--
-- Indexes for table `detailpeminjaman`
--
ALTER TABLE `detailpeminjaman`
  ADD PRIMARY KEY (`iddetailpeminjaman`),
  ADD KEY `detailpeminjaman_ibfk_1` (`iddenda`),
  ADD KEY `detailpeminjaman_ibfk_2` (`idpeminjaman`),
  ADD KEY `detailpeminjaman_ibfk_3` (`idbuku`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`idkategori`);

--
-- Indexes for table `peminjam`
--
ALTER TABLE `peminjam`
  ADD PRIMARY KEY (`idpeminjam`);

--
-- Indexes for table `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD PRIMARY KEY (`idpeminjaman`),
  ADD KEY `peminjaman_ibfk_1` (`idpeminjam`),
  ADD KEY `peminjaman_ibfk_2` (`idadmin`);

--
-- Indexes for table `rak`
--
ALTER TABLE `rak`
  ADD PRIMARY KEY (`Idrak`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `idadmin` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `buku`
--
ALTER TABLE `buku`
  MODIFY `idbuku` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `denda`
--
ALTER TABLE `denda`
  MODIFY `iddenda` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `detailpeminjaman`
--
ALTER TABLE `detailpeminjaman`
  MODIFY `iddetailpeminjaman` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `idkategori` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `peminjam`
--
ALTER TABLE `peminjam`
  MODIFY `idpeminjam` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `peminjaman`
--
ALTER TABLE `peminjaman`
  MODIFY `idpeminjaman` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `rak`
--
ALTER TABLE `rak`
  MODIFY `Idrak` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `buku`
--
ALTER TABLE `buku`
  ADD CONSTRAINT `buku_ibfk_1` FOREIGN KEY (`idkategori`) REFERENCES `kategori` (`idkategori`),
  ADD CONSTRAINT `fk_buku_rak` FOREIGN KEY (`idrak`) REFERENCES `rak` (`Idrak`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Constraints for table `detailpeminjaman`
--
ALTER TABLE `detailpeminjaman`
  ADD CONSTRAINT `detailpeminjaman_ibfk_1` FOREIGN KEY (`iddenda`) REFERENCES `denda` (`iddenda`) ON DELETE CASCADE ON UPDATE RESTRICT,
  ADD CONSTRAINT `detailpeminjaman_ibfk_2` FOREIGN KEY (`idpeminjaman`) REFERENCES `peminjaman` (`idpeminjaman`) ON DELETE CASCADE ON UPDATE RESTRICT,
  ADD CONSTRAINT `detailpeminjaman_ibfk_3` FOREIGN KEY (`idbuku`) REFERENCES `buku` (`idbuku`) ON DELETE CASCADE ON UPDATE RESTRICT;

--
-- Constraints for table `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD CONSTRAINT `peminjaman_ibfk_1` FOREIGN KEY (`idpeminjam`) REFERENCES `peminjam` (`idpeminjam`) ON DELETE CASCADE ON UPDATE RESTRICT,
  ADD CONSTRAINT `peminjaman_ibfk_2` FOREIGN KEY (`idadmin`) REFERENCES `admin` (`idadmin`) ON DELETE CASCADE ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
