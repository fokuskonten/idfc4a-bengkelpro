-- ========================================================
-- FOKUSKONTEN OFFICIAL DATABASE SCHEME
-- SKU: IDFC4A | Aplikasi: BengkelPro
-- Kurasi & Distribusi: FokusKonten Digital (fokuskonten.my.id)
-- Kompatibilitas: MySQL 5.7+ / MariaDB 10.4+ / XAMPP / Laragon
-- ========================================================

-- Engine: MySQL 5.7+ / MariaDB 10.4+
-- Charset: utf8mb4 / Engine: InnoDB
-- Status: Production Clean Dump

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_bengkel`
--

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE `barang` (
  `id_brg` int(11) NOT NULL,
  `nama_brg` varchar(100) NOT NULL,
  `id_kate` int(11) DEFAULT NULL,
  `harga` int(15) NOT NULL,
  `img` varchar(255) DEFAULT NULL,
  `stok` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`id_brg`, `nama_brg`, `id_kate`, `harga`, `img`, `stok`) VALUES
(6, 'X-TEN 10W30 MATIC 0.8L', 40, 50000, 'x-ten-oil-xtmatic-10w30-2.jpg', 87);

-- --------------------------------------------------------

--
-- Table structure for table `detail_pembelian`
--

CREATE TABLE `detail_pembelian` (
  `id_pembelian` int(11) NOT NULL,
  `id_barang` int(11) DEFAULT NULL,
  `jumlah` int(11) DEFAULT NULL,
  `total` int(10) DEFAULT NULL,
  `tgl` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `detail_pembelian`
--

INSERT INTO `detail_pembelian` (`id_pembelian`, `id_barang`, `jumlah`, `total`, `tgl`) VALUES
(6, 6, 5, 250000, '2024-04-13'),
(7, 6, 2, 100000, '2024-04-12'),
(8, 6, 1, 50000, '2024-04-13');

-- --------------------------------------------------------

--
-- Table structure for table `detail_penjualan`
--

CREATE TABLE `detail_penjualan` (
  `id_penjualan` int(11) NOT NULL,
  `id_barang` int(11) NOT NULL,
  `tgl` date DEFAULT NULL,
  `jumlah` int(11) NOT NULL,
  `total` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `detail_penjualan`
--

INSERT INTO `detail_penjualan` (`id_penjualan`, `id_barang`, `tgl`, `jumlah`, `total`) VALUES
(24, 6, '2024-04-13', 5, 250000),
(25, 6, '2024-04-12', 4, 200000),
(26, 6, '2024-04-13', 5, 250000);

-- --------------------------------------------------------

--
-- Table structure for table `detail_service`
--

CREATE TABLE `detail_service` (
  `id_service` int(11) NOT NULL,
  `id_barang` int(11) DEFAULT NULL,
  `jumlah` int(11) DEFAULT NULL,
  `keterangan` varchar(100) NOT NULL,
  `total_harga_jasa` int(10) NOT NULL,
  `total_harga` int(10) NOT NULL,
  `tgl` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `detail_service`
--

INSERT INTO `detail_service` (`id_service`, `id_barang`, `jumlah`, `keterangan`, `total_harga_jasa`, `total_harga`, `tgl`) VALUES
(25, 6, 5, 'service ringan dan ganti oli', 20000, 270000, '2024-04-13'),
(26, 6, 4, 'ganti oli matic', 30000, 230000, '2024-04-12');

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id_kate` int(11) NOT NULL,
  `nama_kate` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id_kate`, `nama_kate`) VALUES
(36, 'busi'),
(37, 'radiator'),
(38, 'suspensi'),
(39, 'ecu'),
(40, 'oli'),
(41, 'gardan'),
(44, 'gardan'),
(46, 'ban');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id_transaksi` int(11) NOT NULL,
  `no_transaksi` varchar(10) NOT NULL,
  `jenis` enum('pembelian','penjualan','service') DEFAULT NULL,
  `id_detail_pembelian` int(11) DEFAULT NULL,
  `id_detail_penjualan` int(11) DEFAULT NULL,
  `id_detail_service` int(11) DEFAULT NULL,
  `tgl_transaksi` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id_transaksi`, `no_transaksi`, `jenis`, `id_detail_pembelian`, `id_detail_penjualan`, `id_detail_service`, `tgl_transaksi`) VALUES
(25, 'SRV-661abb', 'service', NULL, 24, 25, '2024-04-13'),
(26, 'SRV-661abc', 'service', NULL, 25, 26, '2024-04-12'),
(27, 'PMB-661abc', 'pembelian', 6, NULL, NULL, '2024-04-12'),
(28, 'PMB-661abc', 'pembelian', 7, NULL, NULL, '2023-03-13'),
(29, 'PMB-661abe', 'pembelian', 8, NULL, NULL, '2024-04-12'),
(30, 'PNJ-661ac3', 'penjualan', NULL, 26, NULL, '2024-04-12');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `email` varchar(80) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `level` enum('admin','pegawai') DEFAULT 'pegawai'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `username`, `password`, `email`, `fullname`, `alamat`, `level`) VALUES
(7, 'admin', '$2y$10$GId7CUsffP1ppW9isruzcuhgrdu3SovknHS5JRV8aGEkpbxfXKZli', 'admin@fokuskonten.my.id', 'admin', 'kedaton', 'admin'),
(8, 'da', '$2y$10$GId7CUsffP1ppW9isruzcuhgrdu3SovknHS5JRV8aGEkpbxfXKZli', 'sda@dasda', 'sda', 'sdas', 'pegawai');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id_brg`),
  ADD KEY `id_kate` (`id_kate`);

--
-- Indexes for table `detail_pembelian`
--
ALTER TABLE `detail_pembelian`
  ADD PRIMARY KEY (`id_pembelian`),
  ADD KEY `id_barang` (`id_barang`);

--
-- Indexes for table `detail_penjualan`
--
ALTER TABLE `detail_penjualan`
  ADD PRIMARY KEY (`id_penjualan`),
  ADD KEY `id_barang` (`id_barang`);

--
-- Indexes for table `detail_service`
--
ALTER TABLE `detail_service`
  ADD PRIMARY KEY (`id_service`),
  ADD KEY `id_barang` (`id_barang`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_kate`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id_transaksi`),
  ADD KEY `id_detail_pembelian` (`id_detail_pembelian`),
  ADD KEY `id_detail_penjualan` (`id_detail_penjualan`),
  ADD KEY `id_detail_service` (`id_detail_service`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `barang`
--
ALTER TABLE `barang`
  MODIFY `id_brg` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `detail_pembelian`
--
ALTER TABLE `detail_pembelian`
  MODIFY `id_pembelian` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `detail_penjualan`
--
ALTER TABLE `detail_penjualan`
  MODIFY `id_penjualan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `detail_service`
--
ALTER TABLE `detail_service`
  MODIFY `id_service` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id_kate` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id_transaksi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `barang`
--
ALTER TABLE `barang`
  ADD CONSTRAINT `barang_ibfk_1` FOREIGN KEY (`id_kate`) REFERENCES `kategori` (`id_kate`);

--
-- Constraints for table `detail_pembelian`
--
ALTER TABLE `detail_pembelian`
  ADD CONSTRAINT `detail_pembelian_ibfk_1` FOREIGN KEY (`id_barang`) REFERENCES `barang` (`id_brg`);

--
-- Constraints for table `detail_penjualan`
--
ALTER TABLE `detail_penjualan`
  ADD CONSTRAINT `detail_penjualan_ibfk_1` FOREIGN KEY (`id_barang`) REFERENCES `barang` (`id_brg`);

--
-- Constraints for table `detail_service`
--
ALTER TABLE `detail_service`
  ADD CONSTRAINT `detail_service_ibfk_1` FOREIGN KEY (`id_barang`) REFERENCES `barang` (`id_brg`);

--
-- Constraints for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `transaksi_ibfk_1` FOREIGN KEY (`id_detail_pembelian`) REFERENCES `detail_pembelian` (`id_pembelian`),
  ADD CONSTRAINT `transaksi_ibfk_2` FOREIGN KEY (`id_detail_penjualan`) REFERENCES `detail_penjualan` (`id_penjualan`),
  ADD CONSTRAINT `transaksi_ibfk_3` FOREIGN KEY (`id_detail_service`) REFERENCES `detail_service` (`id_service`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
