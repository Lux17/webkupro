-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 16, 2024 at 03:50 PM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ginjal`
--

-- --------------------------------------------------------

--
-- Table structure for table `analisa`
--

CREATE TABLE `analisa` (
  `id_analisa` int NOT NULL,
  `idpenyakit` int DEFAULT NULL,
  `gejala` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `jumlah_nilai` double DEFAULT NULL,
  `nilai_prioritas` double DEFAULT NULL,
  `nilai_eigen` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `analisa`
--

INSERT INTO `analisa` (`id_analisa`, `idpenyakit`, `gejala`, `jumlah_nilai`, `nilai_prioritas`, `nilai_eigen`) VALUES
(1297, 4, '20', 1.1891402714, 0.1981900452, 0.990950226),
(1298, 4, '21', 0.5945701357, 0.0990950226, 0.990950226),
(1299, 4, '22', 1.0126696832, 0.1687782805, 1.09705882325),
(1300, 4, '23', 1.1891402714, 0.1981900452, 0.990950226),
(1301, 4, '24', 1.1891402714, 0.1981900452, 0.990950226),
(1302, 4, '25', 0.8253393665, 0.1375565611, 1.16923076935),
(1303, 1, '1', 0.5252608054, 0.0750372579, 0.9004470948),
(1304, 1, '2', 1.3048973577, 0.1864139082, 1.506845695812),
(1305, 1, '3', 2.5268677405, 0.3609811058, 0.95659956938889),
(1306, 1, '4', 0.7816376582, 0.1116625226, 1.3957815325),
(1307, 1, '5', 0.8108148274, 0.1158306896, 1.2162222408),
(1308, 1, '6', 0.5252608054, 0.0750372579, 0.9004470948),
(1309, 1, '7', 0.5252608054, 0.0750372579, 0.9004470948),
(1310, 2, '8', 0.4609808778, 0.0768301463, 0.9219617556),
(1311, 2, '9', 0.6176142982, 0.1029357164, 1.3381643132),
(1312, 2, '10', 0.4609808778, 0.0768301463, 0.9219617556),
(1313, 2, '11', 1.921404824, 0.3202341373, 0.98205114089724),
(1314, 2, '12', 0.6176142982, 0.1029357164, 1.3381643132),
(1315, 2, '13', 1.921404824, 0.3202341373, 0.98205114089724),
(1316, 3, '14', 0.4390676635, 0.0731779439, 0.8781353268),
(1317, 3, '15', 2.6833319121, 0.4472219854, 0.974943928172),
(1318, 3, '16', 0.805057187, 0.1341761978, 1.184775826574),
(1319, 3, '17', 0.4624288632, 0.0770714772, 1.1175364194),
(1320, 3, '18', 0.805057187, 0.1341761978, 1.184775826574),
(1321, 3, '19', 0.805057187, 0.1341761978, 1.184775826574),
(1322, 5, '26', 0.8532467534, 0.1422077922, 0.9954545454),
(1323, 5, '27', 0.8532467534, 0.1422077922, 0.9954545454),
(1324, 5, '28', 0.8532467534, 0.1422077922, 0.9954545454),
(1325, 5, '29', 0.8532467534, 0.1422077922, 0.9954545454),
(1326, 5, '30', 1.1532467534, 0.1922077922, 1.0571428571),
(1327, 5, '31', 1.4337662337, 0.238961039, 1.194805195);

-- --------------------------------------------------------

--
-- Table structure for table `aturan`
--

CREATE TABLE `aturan` (
  `id_aturan` int NOT NULL,
  `gejala_x` int DEFAULT NULL,
  `gejala_y` int DEFAULT NULL,
  `idpenyakit` int DEFAULT NULL,
  `nilai_pakar` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `aturan`
--

INSERT INTO `aturan` (`id_aturan`, `gejala_x`, `gejala_y`, `idpenyakit`, `nilai_pakar`) VALUES
(9765, 0, 0, 2, 1),
(9766, 0, 1, 2, 0.5),
(9767, 0, 2, 2, 1),
(9768, 0, 3, 2, 0.333333),
(9769, 0, 4, 2, 0.5),
(9770, 0, 5, 2, 0.333333),
(9771, 1, 0, 2, 2),
(9772, 1, 1, 2, 1),
(9773, 1, 2, 2, 2),
(9774, 1, 3, 2, 0.2),
(9775, 1, 4, 2, 1),
(9776, 1, 5, 2, 0.2),
(9777, 2, 0, 2, 1),
(9778, 2, 1, 2, 0.5),
(9779, 2, 2, 2, 1),
(9780, 2, 3, 2, 0.333333),
(9781, 2, 4, 2, 0.5),
(9782, 2, 5, 2, 0.333333),
(9783, 3, 0, 2, 3),
(9784, 3, 1, 2, 5),
(9785, 3, 2, 2, 3),
(9786, 3, 3, 2, 1),
(9787, 3, 4, 2, 5),
(9788, 3, 5, 2, 1),
(9789, 4, 0, 2, 2),
(9790, 4, 1, 2, 1),
(9791, 4, 2, 2, 2),
(9792, 4, 3, 2, 0.2),
(9793, 4, 4, 2, 1),
(9794, 4, 5, 2, 0.2),
(9795, 5, 0, 2, 3),
(9796, 5, 1, 2, 5),
(9797, 5, 2, 2, 3),
(9798, 5, 3, 2, 1),
(9799, 5, 4, 2, 5),
(9800, 5, 5, 2, 1),
(9801, 0, 0, 4, 1),
(9802, 0, 1, 4, 2),
(9803, 0, 2, 4, 1),
(9804, 0, 3, 4, 1),
(9805, 0, 4, 4, 1),
(9806, 0, 5, 4, 2),
(9807, 1, 0, 4, 0.5),
(9808, 1, 1, 4, 1),
(9809, 1, 2, 4, 0.5),
(9810, 1, 3, 4, 0.5),
(9811, 1, 4, 4, 0.5),
(9812, 1, 5, 4, 1),
(9813, 2, 0, 4, 1),
(9814, 2, 1, 4, 2),
(9815, 2, 2, 4, 1),
(9816, 2, 3, 4, 1),
(9817, 2, 4, 4, 1),
(9818, 2, 5, 4, 0.5),
(9819, 3, 0, 4, 1),
(9820, 3, 1, 4, 2),
(9821, 3, 2, 4, 1),
(9822, 3, 3, 4, 1),
(9823, 3, 4, 4, 1),
(9824, 3, 5, 4, 2),
(9825, 4, 0, 4, 1),
(9826, 4, 1, 4, 2),
(9827, 4, 2, 4, 1),
(9828, 4, 3, 4, 1),
(9829, 4, 4, 4, 1),
(9830, 4, 5, 4, 2),
(9831, 5, 0, 4, 0.5),
(9832, 5, 1, 4, 1),
(9833, 5, 2, 4, 2),
(9834, 5, 3, 4, 0.5),
(9835, 5, 4, 4, 0.5),
(9836, 5, 5, 4, 1),
(9837, 0, 0, 1, 1),
(9838, 0, 1, 1, 0.5),
(9839, 0, 2, 1, 0.333333),
(9840, 0, 3, 1, 0.5),
(9841, 0, 4, 1, 0.5),
(9842, 0, 5, 1, 1),
(9843, 0, 6, 1, 1),
(9844, 1, 0, 1, 2),
(9845, 1, 1, 1, 1),
(9846, 1, 2, 1, 0.2),
(9847, 1, 3, 1, 4),
(9848, 1, 4, 1, 3),
(9849, 1, 5, 1, 2),
(9850, 1, 6, 1, 2),
(9851, 2, 0, 1, 3),
(9852, 2, 1, 1, 5),
(9853, 2, 2, 1, 1),
(9854, 2, 3, 1, 5),
(9855, 2, 4, 1, 4),
(9856, 2, 5, 1, 3),
(9857, 2, 6, 1, 3),
(9858, 3, 0, 1, 2),
(9859, 3, 1, 1, 0.25),
(9860, 3, 2, 1, 0.2),
(9861, 3, 3, 1, 1),
(9862, 3, 4, 1, 1),
(9863, 3, 5, 1, 2),
(9864, 3, 6, 1, 2),
(9865, 4, 0, 1, 2),
(9866, 4, 1, 1, 0.333333),
(9867, 4, 2, 1, 0.25),
(9868, 4, 3, 1, 1),
(9869, 4, 4, 1, 1),
(9870, 4, 5, 1, 2),
(9871, 4, 6, 1, 2),
(9872, 5, 0, 1, 1),
(9873, 5, 1, 1, 0.5),
(9874, 5, 2, 1, 0.333333),
(9875, 5, 3, 1, 0.5),
(9876, 5, 4, 1, 0.5),
(9877, 5, 5, 1, 1),
(9878, 5, 6, 1, 1),
(9879, 6, 0, 1, 1),
(9880, 6, 1, 1, 0.5),
(9881, 6, 2, 1, 0.333333),
(9882, 6, 3, 1, 0.5),
(9883, 6, 4, 1, 0.5),
(9884, 6, 5, 1, 1),
(9885, 6, 6, 1, 1),
(9886, 0, 0, 3, 1),
(9887, 0, 1, 3, 0.33),
(9888, 0, 2, 3, 0.5),
(9889, 0, 3, 3, 0.5),
(9890, 0, 4, 3, 0.5),
(9891, 0, 5, 3, 0.5),
(9892, 1, 0, 3, 3),
(9893, 1, 1, 3, 1),
(9894, 1, 2, 3, 5),
(9895, 1, 3, 3, 4),
(9896, 1, 4, 3, 5),
(9897, 1, 5, 3, 5),
(9898, 2, 0, 3, 2),
(9899, 2, 1, 3, 0.2),
(9900, 2, 2, 3, 1),
(9901, 2, 3, 3, 3),
(9902, 2, 4, 3, 1),
(9903, 2, 5, 3, 1),
(9904, 3, 0, 3, 2),
(9905, 3, 1, 3, 0.25),
(9906, 3, 2, 3, 0.33),
(9907, 3, 3, 3, 1),
(9908, 3, 4, 3, 0.33),
(9909, 3, 5, 3, 0.33),
(9910, 4, 0, 3, 2),
(9911, 4, 1, 3, 0.2),
(9912, 4, 2, 3, 1),
(9913, 4, 3, 3, 3),
(9914, 4, 4, 3, 1),
(9915, 4, 5, 3, 1),
(9916, 5, 0, 3, 2),
(9917, 5, 1, 3, 0.2),
(9918, 5, 2, 3, 1),
(9919, 5, 3, 3, 3),
(9920, 5, 4, 3, 1),
(9921, 5, 5, 3, 1),
(9966, 0, 0, 5, 1),
(9967, 0, 1, 5, 1),
(9968, 0, 2, 5, 1),
(9969, 0, 3, 5, 1),
(9970, 0, 4, 5, 1),
(9971, 0, 5, 5, 0.5),
(9972, 1, 0, 5, 1),
(9973, 1, 1, 5, 1),
(9974, 1, 2, 5, 1),
(9975, 1, 3, 5, 1),
(9976, 1, 4, 5, 1),
(9977, 1, 5, 5, 0.5),
(9978, 2, 0, 5, 1),
(9979, 2, 1, 5, 1),
(9980, 2, 2, 5, 1),
(9981, 2, 3, 5, 1),
(9982, 2, 4, 5, 1),
(9983, 2, 5, 5, 0.5),
(9984, 3, 0, 5, 1),
(9985, 3, 1, 5, 1),
(9986, 3, 2, 5, 1),
(9987, 3, 3, 5, 1),
(9988, 3, 4, 5, 1),
(9989, 3, 5, 5, 0.5),
(9990, 4, 0, 5, 1),
(9991, 4, 1, 5, 1),
(9992, 4, 2, 5, 1),
(9993, 4, 3, 5, 1),
(9994, 4, 4, 5, 1),
(9995, 4, 5, 5, 2),
(9996, 5, 0, 5, 2),
(9997, 5, 1, 5, 2),
(9998, 5, 2, 5, 2),
(9999, 5, 3, 5, 2),
(10000, 5, 4, 5, 0.5),
(10001, 5, 5, 5, 1);

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('7719a1c782a1ba91c031a682a0a2f8658209adbf', 'i:1;', 1720847823),
('7719a1c782a1ba91c031a682a0a2f8658209adbf:timer', 'i:1720847823;', 1720847823),
('admin@example.com|127.0.0.1', 'i:1;', 1718083566),
('admin@example.com|127.0.0.1:timer', 'i:1718083566;', 1718083566),
('admin@gmail.com|127.0.0.1', 'i:1;', 1725384437),
('admin@gmail.com|127.0.0.1:timer', 'i:1725384437;', 1725384437),
('admin1@gmail.com|127.0.0.1', 'i:2;', 1725384416),
('admin1@gmail.com|127.0.0.1:timer', 'i:1725384416;', 1725384416),
('damnlux19@gmail.com|127.0.0.1', 'i:1;', 1718945451),
('damnlux19@gmail.com|127.0.0.1:timer', 'i:1718945451;', 1718945451),
('damnlux20@gmail.com|127.0.0.1', 'i:2;', 1724087079),
('damnlux20@gmail.com|127.0.0.1:timer', 'i:1724087079;', 1724087079),
('damnlux20@gmail.com|192.168.194.122', 'i:1;', 1722701785),
('damnlux20@gmail.com|192.168.194.122:timer', 'i:1722701785;', 1722701785),
('damnlux21@gmail.com|127.0.0.1', 'i:1;', 1720424417),
('damnlux21@gmail.com|127.0.0.1:timer', 'i:1720424417;', 1720424417),
('damnlux21@gmail.com|192.168.179.172', 'i:1;', 1722669895),
('damnlux21@gmail.com|192.168.179.172:timer', 'i:1722669894;', 1722669894),
('luckysaputraa17@gmail.com|127.0.0.1', 'i:3;', 1718379610),
('luckysaputraa17@gmail.com|127.0.0.1:timer', 'i:1718379609;', 1718379610),
('ss@email|127.0.0.1', 'i:1;', 1718081291),
('ss@email|127.0.0.1:timer', 'i:1718081291;', 1718081291),
('user1@gmail.com|127.0.0.1', 'i:1;', 1725370856),
('user1@gmail.com|127.0.0.1:timer', 'i:1725370856;', 1725370856),
('user1@gmail.com|192.168.13.87', 'i:1;', 1724396839),
('user1@gmail.com|192.168.13.87:timer', 'i:1724396839;', 1724396839);

-- --------------------------------------------------------

--
-- Table structure for table `gejala`
--

CREATE TABLE `gejala` (
  `id_gejala` int NOT NULL,
  `kode_gejala` varchar(15) NOT NULL,
  `nama_gejala` varchar(100) NOT NULL,
  `jenis` varchar(50) DEFAULT NULL,
  `type` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `gejala`
--

INSERT INTO `gejala` (`id_gejala`, `kode_gejala`, `nama_gejala`, `jenis`, `type`) VALUES
(1, 'G1', 'Sering Menangis/Rewel', 'Gagal Ginjal', 1),
(2, 'G2', 'Jumlah Urine sedikit', 'Gagal Ginjal', 1),
(3, 'G3', 'Tidak bisa buang air kecil sama sekali', 'Gagal Ginjal', 3),
(4, 'G4', 'Warna Urine kecoklatan atau pekat', 'Gagal Ginjal', 2),
(5, 'G5', 'Berat badan turun', 'Gagal Ginjal', 1),
(6, 'G6', 'Cepat Lelah', 'Gagal Ginjal', 3),
(7, 'G7', 'Lemas atau Lesu', 'Gagal Ginjal', 3),
(8, 'G1', 'Sering menangis/Rewel', 'Batu Ginjal', 1),
(9, 'G8', 'Rasa nyeri saat buang air kecil', 'Batu Ginjal', 2),
(10, 'G9', 'Sering buang air kecil', 'Batu Ginjal', 1),
(11, 'G10', 'Urine berwarna merah muda atau merah', 'Batu Ginjal', 3),
(12, 'G11', 'Nyeri pada bagian perut bawah', 'Batu Ginjal', 2),
(13, 'G12', 'Adanya batu saat kencing', 'Batu Ginjal', 3),
(14, 'G6', 'Cepat Lelah', 'Kanker Ginjal', 1),
(15, 'G10', 'Urine berwarna merah muda atau merah', 'Kanker Ginjal', 3),
(16, 'G13', 'Kehilangan nafsu makan', 'Kanker Ginjal', 2),
(17, 'G14', 'Pembengkakan Kaki', 'Kanker Ginjal', 3),
(18, 'G15', 'Sesak Nafas', 'Kanker Ginjal', 2),
(19, 'G16', 'Sakit Pada tulang belakang', 'Kanker Ginjal', 2),
(20, 'G8', 'Rasa nyeri saat buang air kecil', 'Infeksi Saluran Kemih(ISK)', 3),
(21, 'G11', 'Nyeri pada bagian perut bawah', 'Infeksi Saluran Kemih(ISK)', 2),
(22, 'G17', 'Demam', 'Infeksi Saluran Kemih(ISK)', 2),
(23, 'G18', 'Sering buang air kecil namun tidak tuntas', 'Infeksi Saluran Kemih(ISK)', 3),
(24, 'G19', 'Buang air kecil terasa panas', 'Infeksi Saluran Kemih(ISK)', 3),
(25, 'G20', 'Nyeri pada pinggang kanan atau kiri/keduanya', 'Infeksi Saluran Kemih(ISK)', 2),
(26, 'G1', 'Sering Menangis/Rewel', 'Bukan Penyakit Ginjal', 0),
(27, 'G6', 'Cepat Lelah', 'Bukan Penyakit Ginjal', 0),
(28, 'G7', 'Lemas atau Lesu', 'Bukan Penyakit Ginjal', 0),
(29, 'G9', 'Sering buang air kecil', 'Bukan Penyakit Ginjal', 0),
(30, 'G13', 'Kehilangan nafsu makan', 'Bukan Penyakit Ginjal', 0),
(31, 'G17', 'Demam', 'Bukan Penyakit Ginjal', 0);

-- --------------------------------------------------------

--
-- Table structure for table `hasil_diagnosis`
--

CREATE TABLE `hasil_diagnosis` (
  `id_hasil` int NOT NULL,
  `idpengguna` int DEFAULT NULL,
  `kode_hasil` varchar(100) DEFAULT NULL,
  `data_diagnosis` longtext,
  `kondisi` longtext,
  `tanggal` date DEFAULT NULL,
  `penyakit` varchar(50) DEFAULT NULL,
  `nilai_hasil` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `hasil_diagnosis`
--

INSERT INTO `hasil_diagnosis` (`id_hasil`, `idpengguna`, `kode_hasil`, `data_diagnosis`, `kondisi`, `tanggal`, `penyakit`, `nilai_hasil`) VALUES
(183, 29, '66b5ddd6c6859', '{\"1\":[\"Gagal Ginjal\",57.281159599999995],\"2\":[\"Batu Ginjal\",7.6830175],\"3\":[\"Kanker Ginjal\",0],\"4\":[\"Infeksi Saluran Kemih(ISK)\",0],\"5\":[\"Bukan Penyakit Ginjal\",14.220779199999999]}', '[[\"0\",\"1\"],[\"1\",\"1\"],[\"2\",\"1\"],[\"3\",\"1\"],[\"4\",\"0\"],[\"5\",\"0\"],[\"6\",\"0\"],[\"7\",\"1\"],[\"8\",\"0\"],[\"9\",\"0\"],[\"10\",\"0\"],[\"11\",\"0\"],[\"12\",\"0\"],[\"13\",\"0\"],[\"14\",\"0\"],[\"15\",\"0\"],[\"16\",\"0\"],[\"17\",\"0\"],[\"18\",\"0\"],[\"19\",\"0\"],[\"20\",\"0\"],[\"21\",\"0\"],[\"22\",\"0\"],[\"23\",\"0\"],[\"24\",\"0\"],[\"25\",\"1\"],[\"26\",\"0\"],[\"27\",\"0\"],[\"28\",\"0\"],[\"29\",\"0\"],[\"30\",\"0\"]]', '2024-08-09', 'Gagal Ginjal', '57.2811596'),
(184, 29, '66b5fa49c98b7', '{\"1\":[\"Gagal Ginjal\",62.229312400000005],\"2\":[\"Batu Ginjal\",7.6830175],\"3\":[\"Kanker Ginjal\",0],\"4\":[\"Infeksi Saluran Kemih(ISK)\",0],\"5\":[\"Bukan Penyakit Ginjal\",14.220779199999999]}', '[[\"0\",\"1\"],[\"1\",\"1\"],[\"2\",\"1\"],[\"3\",\"1\"],[\"4\",\"1\"],[\"5\",\"0\"],[\"6\",\"0\"],[\"7\",\"1\"],[\"8\",\"0\"],[\"9\",\"0\"],[\"10\",\"0\"],[\"11\",\"0\"],[\"12\",\"0\"],[\"13\",\"0\"],[\"14\",\"0\"],[\"15\",\"0\"],[\"16\",\"0\"],[\"17\",\"0\"],[\"18\",\"0\"],[\"19\",\"0\"],[\"20\",\"0\"],[\"21\",\"0\"],[\"22\",\"0\"],[\"23\",\"0\"],[\"24\",\"0\"],[\"25\",\"1\"],[\"26\",\"0\"],[\"27\",\"0\"],[\"28\",\"0\"],[\"29\",\"0\"],[\"30\",\"0\"]]', '2024-08-09', 'Gagal Ginjal', '62.2293124'),
(185, 29, '66c7af9189e1e', '{\"1\":[\"Gagal Ginjal\",48.9006076],\"2\":[\"Batu Ginjal\",43.6494],\"3\":[\"Kanker Ginjal\",51.2106501],\"4\":[\"Infeksi Saluran Kemih(ISK)\",44.4261274],\"5\":[\"Bukan Penyakit Ginjal\",44.1549827]}', '[[\"0\",\"0.8\"],[\"1\",\"0.8\"],[\"2\",\"0.8\"],[\"3\",\"0.2\"],[\"4\",\"0.2\"],[\"5\",\"0.6\"],[\"6\",\"0.2\"],[\"7\",\"0.8\"],[\"8\",\"0.2\"],[\"9\",\"0.8\"],[\"10\",\"0.8\"],[\"11\",\"0.6\"],[\"12\",\"0.2\"],[\"13\",\"0.6\"],[\"14\",\"0.8\"],[\"15\",\"0.6\"],[\"16\",\"0.8\"],[\"17\",\"0.4\"],[\"18\",\"0.2\"],[\"19\",\"0.2\"],[\"20\",\"0.6\"],[\"21\",\"0.4\"],[\"22\",\"0.6\"],[\"23\",\"0.8\"],[\"24\",\"0.8\"],[\"25\",\"0.8\"],[\"26\",\"0.6\"],[\"27\",\"0.2\"],[\"28\",\"0.8\"],[\"29\",\"0.6\"],[\"30\",\"0.4\"]]', '2024-08-22', 'Kanker Ginjal', '51.2106501'),
(186, 29, '66c7b3e5b6be5', '{\"1\":[\"Gagal Ginjal\",4.435007],\"2\":[\"Batu Ginjal\",7.0003684999999995],\"3\":[\"Kanker Ginjal\",4.1078079],\"4\":[\"Infeksi Saluran Kemih(ISK)\",18.4201898],\"5\":[\"Bukan Penyakit Ginjal\",18.420106399999998]}', '[[\"0\",\"0.2\"],[\"1\",\"0\"],[\"2\",\"0\"],[\"3\",\"0\"],[\"4\",\"0\"],[\"5\",\"0.2\"],[\"6\",\"0.2\"],[\"7\",\"0.2\"],[\"8\",\"0.2\"],[\"9\",\"0.2\"],[\"10\",\"0\"],[\"11\",\"0.2\"],[\"12\",\"0\"],[\"13\",\"0.2\"],[\"14\",\"0\"],[\"15\",\"0.2\"],[\"16\",\"0\"],[\"17\",\"0\"],[\"18\",\"0\"],[\"19\",\"0.2\"],[\"20\",\"0.2\"],[\"21\",\"0.2\"],[\"22\",\"0.2\"],[\"23\",\"0.2\"],[\"24\",\"0.2\"],[\"25\",\"0.2\"],[\"26\",\"0.2\"],[\"27\",\"0.2\"],[\"28\",\"0.2\"],[\"29\",\"0.2\"],[\"30\",\"0.2\"]]', '2024-08-22', 'Infeksi Saluran Kemih(ISK)', '18.4201898'),
(187, 29, '66c7b49a5d58a', '{\"1\":[\"Gagal Ginjal\",3.7282781000000003],\"2\":[\"Batu Ginjal\",0],\"3\":[\"Kanker Ginjal\",0],\"4\":[\"Infeksi Saluran Kemih(ISK)\",0],\"5\":[\"Bukan Penyakit Ginjal\",0]}', '[[\"0\",\"0\"],[\"1\",\"0.2\"],[\"2\",\"0\"],[\"3\",\"0\"],[\"4\",\"0\"],[\"5\",\"0\"],[\"6\",\"0\"],[\"7\",\"0\"],[\"8\",\"0\"],[\"9\",\"0\"],[\"10\",\"0\"],[\"11\",\"0\"],[\"12\",\"0\"],[\"13\",\"0\"],[\"14\",\"0\"],[\"15\",\"0\"],[\"16\",\"0\"],[\"17\",\"0\"],[\"18\",\"0\"],[\"19\",\"0\"],[\"20\",\"0\"],[\"21\",\"0\"],[\"22\",\"0\"],[\"23\",\"0\"],[\"24\",\"0\"],[\"25\",\"0\"],[\"26\",\"0\"],[\"27\",\"0\"],[\"28\",\"0\"],[\"29\",\"0\"],[\"30\",\"0\"]]', '2024-08-22', 'Gagal Ginjal', '3.7282781'),
(188, 29, '66c7fd6fd7d1e', '{\"1\":[\"Gagal Ginjal\",53.135],\"2\":[\"Batu Ginjal\",22.346],\"3\":[\"Kanker Ginjal\",22.211],\"4\":[\"Infeksi Saluran Kemih(ISK)\",18.42],\"5\":[\"Bukan Penyakit Ginjal\",38.081]}', '[[\"0\",\"0.8\"],[\"1\",\"0.8\"],[\"2\",\"0.6\"],[\"3\",\"0.6\"],[\"4\",\"0.8\"],[\"5\",\"0.8\"],[\"6\",\"0.8\"],[\"7\",\"0.8\"],[\"8\",\"0.2\"],[\"9\",\"0.2\"],[\"10\",\"0.2\"],[\"11\",\"0.2\"],[\"12\",\"0.2\"],[\"13\",\"0.8\"],[\"14\",\"0.2\"],[\"15\",\"0.2\"],[\"16\",\"0.2\"],[\"17\",\"0.2\"],[\"18\",\"0.2\"],[\"19\",\"0.2\"],[\"20\",\"0.2\"],[\"21\",\"0.2\"],[\"22\",\"0.2\"],[\"23\",\"0.2\"],[\"24\",\"0.2\"],[\"25\",\"0.8\"],[\"26\",\"0.8\"],[\"27\",\"0.8\"],[\"28\",\"0.2\"],[\"29\",\"0.2\"],[\"30\",\"0.2\"]]', '2024-08-23', 'Gagal Ginjal', '53.135'),
(189, 29, '66c7fee1ca1aa', '{\"1\":[\"Gagal Ginjal\",0],\"2\":[\"Batu Ginjal\",4.075],\"3\":[\"Kanker Ginjal\",0],\"4\":[\"Infeksi Saluran Kemih(ISK)\",18.42],\"5\":[\"Bukan Penyakit Ginjal\",4.779]}', '[[\"0\",\"0\"],[\"1\",\"0\"],[\"2\",\"0\"],[\"3\",\"0\"],[\"4\",\"0\"],[\"5\",\"0\"],[\"6\",\"0\"],[\"7\",\"0\"],[\"8\",\"0.2\"],[\"9\",\"0\"],[\"10\",\"0\"],[\"11\",\"0.2\"],[\"12\",\"0\"],[\"13\",\"0\"],[\"14\",\"0\"],[\"15\",\"0\"],[\"16\",\"0\"],[\"17\",\"0\"],[\"18\",\"0\"],[\"19\",\"0.2\"],[\"20\",\"0.2\"],[\"21\",\"0.2\"],[\"22\",\"0.2\"],[\"23\",\"0.2\"],[\"24\",\"0.2\"],[\"25\",\"0\"],[\"26\",\"0\"],[\"27\",\"0\"],[\"28\",\"0\"],[\"29\",\"0\"],[\"30\",\"0.2\"]]', '2024-08-23', 'Infeksi Saluran Kemih(ISK)', '18.42'),
(190, 29, '66c7ff4c5111c', '{\"1\":[\"Gagal Ginjal\",4.435],\"2\":[\"Batu Ginjal\",7],\"3\":[\"Kanker Ginjal\",4.108],\"4\":[\"Infeksi Saluran Kemih(ISK)\",18.42],\"5\":[\"Bukan Penyakit Ginjal\",18.42]}', '[[\"0\",\"0.2\"],[\"1\",\"0\"],[\"2\",\"0\"],[\"3\",\"0\"],[\"4\",\"0\"],[\"5\",\"0.2\"],[\"6\",\"0.2\"],[\"7\",\"0.2\"],[\"8\",\"0.2\"],[\"9\",\"0.2\"],[\"10\",\"0\"],[\"11\",\"0.2\"],[\"12\",\"0\"],[\"13\",\"0.2\"],[\"14\",\"0\"],[\"15\",\"0.2\"],[\"16\",\"0\"],[\"17\",\"0\"],[\"18\",\"0\"],[\"19\",\"0.2\"],[\"20\",\"0.2\"],[\"21\",\"0.2\"],[\"22\",\"0.2\"],[\"23\",\"0.2\"],[\"24\",\"0.2\"],[\"25\",\"0.2\"],[\"26\",\"0.2\"],[\"27\",\"0.2\"],[\"28\",\"0.2\"],[\"29\",\"0.2\"],[\"30\",\"0.2\"]]', '2024-08-23', 'Infeksi Saluran Kemih(ISK)', '18.42'),
(191, 29, '66c800aae772b', '{\"1\":[\"Gagal Ginjal\",58.47],\"2\":[\"Batu Ginjal\",6.15],\"3\":[\"Kanker Ginjal\",5.85],\"4\":[\"Infeksi Saluran Kemih(ISK)\",0],\"5\":[\"Bukan Penyakit Ginjal\",30.39]}', '[[\"0\",\"0.8\"],[\"1\",\"0.8\"],[\"2\",\"0.8\"],[\"3\",\"0.8\"],[\"4\",\"0.8\"],[\"5\",\"0.8\"],[\"6\",\"0.8\"],[\"7\",\"0.8\"],[\"8\",\"0\"],[\"9\",\"0\"],[\"10\",\"0\"],[\"11\",\"0\"],[\"12\",\"0\"],[\"13\",\"0.8\"],[\"14\",\"0\"],[\"15\",\"0\"],[\"16\",\"0\"],[\"17\",\"0\"],[\"18\",\"0\"],[\"19\",\"0\"],[\"20\",\"0\"],[\"21\",\"0\"],[\"22\",\"0\"],[\"23\",\"0\"],[\"24\",\"0\"],[\"25\",\"0.8\"],[\"26\",\"0.8\"],[\"27\",\"0.8\"],[\"28\",\"0\"],[\"29\",\"0\"],[\"30\",\"0\"]]', '2024-08-23', 'Gagal Ginjal', '58.47'),
(192, 31, '66c84d4d68ae5', '{\"1\":[\"Gagal Ginjal\",66.11],\"2\":[\"Batu Ginjal\",66.73],\"3\":[\"Kanker Ginjal\",69.31],\"4\":[\"Infeksi Saluran Kemih(ISK)\",66.71],\"5\":[\"Bukan Penyakit Ginjal\",63.41]}', '[[\"0\",\"0.4\"],[\"1\",\"1\"],[\"2\",\"1\"],[\"3\",\"1\"],[\"4\",\"1\"],[\"5\",\"1\"],[\"6\",\"1\"],[\"7\",\"0.4\"],[\"8\",\"1\"],[\"9\",\"1\"],[\"10\",\"1\"],[\"11\",\"1\"],[\"12\",\"1\"],[\"13\",\"1\"],[\"14\",\"1\"],[\"15\",\"1\"],[\"16\",\"1\"],[\"17\",\"1\"],[\"18\",\"1\"],[\"19\",\"1\"],[\"20\",\"1\"],[\"21\",\"1\"],[\"22\",\"1\"],[\"23\",\"1\"],[\"24\",\"1\"],[\"25\",\"0.4\"],[\"26\",\"1\"],[\"27\",\"1\"],[\"28\",\"1\"],[\"29\",\"1\"],[\"30\",\"1\"]]', '2024-08-23', 'Kanker Ginjal', '69.31'),
(193, 31, '66c84fdbe2ff0', '{\"1\":[\"Gagal Ginjal\",56.27],\"2\":[\"Batu Ginjal\",7.68],\"3\":[\"Kanker Ginjal\",5.85],\"4\":[\"Infeksi Saluran Kemih(ISK)\",0],\"5\":[\"Bukan Penyakit Ginjal\",30.47]}', '[[\"0\",\"1\"],[\"1\",\"1\"],[\"2\",\"0.6\"],[\"3\",\"0.8\"],[\"4\",\"0.8\"],[\"5\",\"0.8\"],[\"6\",\"0.6\"],[\"7\",\"1\"],[\"8\",\"0\"],[\"9\",\"0\"],[\"10\",\"0\"],[\"11\",\"0\"],[\"12\",\"0\"],[\"13\",\"0.8\"],[\"14\",\"0\"],[\"15\",\"0\"],[\"16\",\"0\"],[\"17\",\"0\"],[\"18\",\"0\"],[\"19\",\"0\"],[\"20\",\"0\"],[\"21\",\"0\"],[\"22\",\"0\"],[\"23\",\"0\"],[\"24\",\"0\"],[\"25\",\"1\"],[\"26\",\"0.8\"],[\"27\",\"0.6\"],[\"28\",\"0\"],[\"29\",\"0\"],[\"30\",\"0\"]]', '2024-08-23', 'Gagal Ginjal', '56.27'),
(194, 31, '66d911d082cab', '{\"1\":[\"Gagal Ginjal\",43.07],\"2\":[\"Batu Ginjal\",14.78],\"3\":[\"Kanker Ginjal\",19.75],\"4\":[\"Infeksi Saluran Kemih(ISK)\",16.88],\"5\":[\"Bukan Penyakit Ginjal\",66.72]}', '[[\"0\",\"1\"],[\"1\",\"1\"],[\"2\",\"0\"],[\"3\",\"0\"],[\"4\",\"1\"],[\"5\",\"1\"],[\"6\",\"1\"],[\"7\",\"1\"],[\"8\",\"0\"],[\"9\",\"1\"],[\"10\",\"0\"],[\"11\",\"0\"],[\"12\",\"0\"],[\"13\",\"1\"],[\"14\",\"0\"],[\"15\",\"1\"],[\"16\",\"0\"],[\"17\",\"0\"],[\"18\",\"0\"],[\"19\",\"0\"],[\"20\",\"0\"],[\"21\",\"1\"],[\"22\",\"0\"],[\"23\",\"0\"],[\"24\",\"0\"],[\"25\",\"1\"],[\"26\",\"1\"],[\"27\",\"1\"],[\"28\",\"1\"],[\"29\",\"1\"],[\"30\",\"1\"]]', '2024-09-05', 'Bukan Penyakit Ginjal', '66.72');

-- --------------------------------------------------------

--
-- Table structure for table `kondisi_pengguna`
--

CREATE TABLE `kondisi_pengguna` (
  `id_kondisi` int NOT NULL,
  `kondisi` varchar(25) DEFAULT NULL,
  `nilai` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `kondisi_pengguna`
--

INSERT INTO `kondisi_pengguna` (`id_kondisi`, `kondisi`, `nilai`) VALUES
(1, 'Tidak', 0),
(2, 'Tidak Tahu', 0.2),
(3, 'Kemungkinan', 0.4),
(4, 'Kemungkinan Besar', 0.6),
(5, 'Hampir Pasti', 0.8),
(6, 'Pasti', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_reset_tokens`
--

INSERT INTO `password_reset_tokens` (`email`, `token`, `created_at`) VALUES
('damnlux20@gmail.com', '$2y$12$qLL7XiYErtzCnKtdHT0YVu7ZxX9eK7lCmOjUTy/UzmNjWHhHkskTS', '2024-07-09 02:35:27'),
('luckysaputraa17@gmail.com', '$2y$12$x5sBe3h39wziB.uxsVZzuu0pUnWS6ieNDNJiTtdXN.8ZIPM3sk7hq', '2024-06-30 02:26:41'),
('user1@gmail.com', '$2y$12$mZKrNIgRldGp8Qi4CTENhu9A6cg2PD04L9zdQysDgB99VmomWKVPa', '2024-08-03 08:14:27');

-- --------------------------------------------------------

--
-- Table structure for table `penyakit`
--

CREATE TABLE `penyakit` (
  `id_penyakit` int NOT NULL,
  `kode_penyakit` varchar(20) NOT NULL,
  `nama_penyakit` varchar(100) NOT NULL,
  `images` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `solusi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `penyakit`
--

INSERT INTO `penyakit` (`id_penyakit`, `kode_penyakit`, `nama_penyakit`, `images`, `solusi`) VALUES
(1, 'P1', 'Gagal Ginjal', 'images/1721584720.png', '- Segera Konsultasikan dengan dokter untuk penanganan lebih lanjut, Minum suplemen penambah  zat besi, vitamin B12, asam folat untuk mencegah anemia, Hindari obat-obatan yang dapat merusak ginjal atau meningkatkan risiko kerusakan ginjal lebih lanjut, Membatasi garam dan protein mungkin direkomendasikan untuk membantu menurunkan beban pada ginjal, Cuci darah bila keadaan makin parah.'),
(2, 'P2', 'Batu Ginjal', 'images/1719160538.png', '- Segera Konsultasikan ke dokter untuk pemberian obat, antibiotik dan penghancur batu ginjal (yang diberikan oleh dokter) dan penanganan lebih intensif, Selalu jaga pola hidup sehat anak seperti, makan makanan bergizi, berolahraga secara teratur, dan menjaga berat tubuh ideal, Berikan anak suplemen penambah  zat besi, vitamin B12, asam folat untuk mencegah anemia, Jika diperlukan segera untuk ke rumah sakit untuk melakukan tindakan operasi untuk mengeluarkan batu ginjal.'),
(3, 'P3', 'Kanker Ginjal', 'images/1719160553.png', '- Konsultasi dengan dokter spesialis seperti urolog atau ahli onkologi  evaluasi menyeluruh dan menentukan rencana pengobatan yang sesuai dengan kondisi anak, Berikan dukungan mental dan emosional dari keluarga, teman, dapat membantu Anak mengatasi stres dan kecemasan yang mungkin di alami. Selalu jaga pola hidup sehat anak seperti, makan makanan bergizi, dan berolahraga, Lakukan terapi radiasi, kemoterapi, terapi target atau imunoterapi, Lakukan Cuci darah secara rutin untuk mengeluarkan racun dalam tubuh.'),
(4, 'P4', 'Infeksi Saluran Kemih(ISK)', 'images/1719160581.png', '- Segera Konsultasikan dengan dokter untuk penanganan lebih lanjut, Banyak minum air putih, Gunakan obat pereda demam (dengan resep dokter), Selalu Jaga kebersihan setelah buang air kecil.'),
(5, 'P5', 'Bukan Penyakit Ginjal', 'images/1720879392.jpg', '- Segera Konsultasikan dengan dokter untuk pengecekan penyakit. Selalu jaga pola hidup sehat anak seperti, makan makanan bergizi. Jika gejala semakin memburuk segera untuk ke rumah sakit.');

-- --------------------------------------------------------

--
-- Table structure for table `random_index`
--

CREATE TABLE `random_index` (
  `id_random_index` int NOT NULL,
  `matrix` int NOT NULL,
  `nilai` float NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `random_index`
--

INSERT INTO `random_index` (`id_random_index`, `matrix`, `nilai`) VALUES
(1, 1, 0),
(2, 2, 0),
(3, 3, 0.58),
(4, 4, 0.9),
(5, 5, 1.12),
(6, 6, 1.24),
(7, 7, 1.32),
(8, 8, 1.41),
(9, 9, 1.45),
(10, 10, 1.49),
(11, 11, 1.51),
(12, 12, 1.54),
(13, 13, 1.56),
(14, 14, 1.57),
(15, 15, 1.59);

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('H8WYFfEi4foM6rSqqcMPelTfLA0ME07ySq90TdOK', 31, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoibmpSejRqRkFTN295WXUwdVBwUG53c1Qwdkd4aXZmNUNzNmd5enNaWCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9kaWFnbm9zaXMiO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTozMTtzOjc6ImlzX3VzZXIiO2I6MTt9', 1725502948),
('lgWPNmy6Gh1ti5qlSjksF5GgzlctoOLjpCJR6OEW', 15, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoiMkZhcXZDTnJaVmJiSW03RGZrNlNpa2JwQ0JhMG5VQkE5ZlE0eFJJbiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MTp7aTowO3M6NjoiZGFuZ2VyIjt9czozOiJuZXciO2E6MDp7fX1zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czoyODoiaHR0cDovL2xvY2FsaG9zdDo4MDAwL2dlamFsYSI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE1O3M6ODoiaXNfYWRtaW4iO2I6MTtzOjY6ImRhbmdlciI7czoyOToiRGF0YSBnZWphbGEgYmVyaGFzaWwgZGloYXB1cy4iO30=', 1725385955),
('mCyxgbhPrARLHlYJt72q05azqXudJlKQTHlHr4xN', 15, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiWGVJVnZMcXZnSFZGNTBKQkhMdm5RamFCSzhNQlJJRHZHSDdPb2oweiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9kYXNoYm9hcmQiO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxNTtzOjg6ImlzX2FkbWluIjtiOjE7fQ==', 1726501795);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `rolename` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alamat` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jenis_kelamin` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tgl_lahir` date DEFAULT NULL,
  `no_hp` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `riwayat_penyakit` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `rolename`, `alamat`, `jenis_kelamin`, `tgl_lahir`, `no_hp`, `riwayat_penyakit`, `remember_token`, `updated_at`, `created_at`) VALUES
(1, 'Lucky Saputra', 'luckysaputraa17@gmail.com', NULL, '$2y$12$6a10CQCI2o6zzvzgN5bIwu1IEpgKpk4xPVjhfip7Bnvtry9DPdftO', 'admin', 'sigebang', NULL, NULL, '08818286473', 'ginjal', 'dD2gvSvrfqubqepm9AgyEeYRtKSKxKeBbyKKnw7tPwH3RRxeImQWmi1vwPiV', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(15, 'Admin', 'damnlux17@gmail.com', NULL, '$2y$12$.q7Cp.gnIEexf8oUgDGnvO624uD52DPO9c0qXdWqbXVCEjdGyjucy', 'admin', 'sfff', 'Laki-laki', '2024-06-04', '088172462845', 'sd', 't8vXzEcsNHkZF0NYh7bAciHEHNAP7mjM5BTpETlxtBRfLD9uKYMhpqTXRxux', '2024-08-19 09:58:11', '0000-00-00 00:00:00'),
(25, 'Mentor567', 'admin@example.com4567', NULL, '$2y$12$pv5aOVTC.Q/p0RjVWYOPvuIz2zRYpDal.oIMhaU0M6TZxyZzDfwcW', NULL, NULL, NULL, NULL, '6834567', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(28, 'Pengguna', 'damnlux20@gmail.com', NULL, '$2y$12$suvL7xiHhci3vDNq4UqSUe2FdAMFZttsF/5gBQ3.IO5Qlvq5T.9hO', 'pengguna', 'Cirebon', 'Laki-Laki', '2002-06-04', '089665483923', 'Ginjal', 'IZEZViP3rnvIcv8f5eCYHzPHLX45s6pXQv4v9B8ychzQxYyr2XCPnx8czR0m', '2024-07-28 03:27:32', '0000-00-00 00:00:00'),
(29, 'user1', 'user1@gmail.com', NULL, '$2y$12$IP97DaHnDr9L4Q.fLLnzjupB5F/1Y80CQge8DAqauSn/cK7K1OBgW', 'pengguna', 'Jl. Tuparev', 'Laki-Laki', '2022-06-11', '081234567', 'Penyakit Ginjal', 'nk11qOVZhy2erhxw4pUBBHBY3KF7Wv8pDtzu1cTFbELxZNBJWhKJIC8ap4ma', '2024-07-22 01:29:13', '0000-00-00 00:00:00'),
(31, 'user2', 'user2@gmail.com', NULL, '$2y$12$hImhtYWFj.ZY/O7fFaCXl.cI6ikdGhqsLF1ZtBqn.OGVfUPGDv5Lu', 'pengguna', 'Cirebon', 'Perempuan', '2024-06-11', '089836748534', 'Ginjal', NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(32, 'user3', 'user3@gmail.com', NULL, '$2y$12$1oeUbTJBUcS3xBG72cwQvOJ8E76IsgU9g6QeK.c.tkGNphz2tVf8i', 'pengguna', 'Cirebon', 'Perempuan', '2024-06-12', '087656536333', 'Ginjal', NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(33, 'user4', 'user4@gmail.com', NULL, '$2y$12$73ChLTJlooME33GZiJTCOObqXJk/R5b8WiHi2OCWJi5AD4PTmOzGe', 'pengguna', 'Cirebon', 'Laki-Laki', '2024-06-12', '085655244123', 'Ginjal', NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(34, 'user5', 'user5@gmail.com', NULL, '$2y$12$o/4/e/pW0ilxopfzai/mA.UnEWIJ69u2IQDGAqn7PaLCy1FCecIRO', 'pengguna', 'CIrebon', 'Laki-Laki', '2024-06-11', '887377374', 'Ginjal', NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(35, 'user6', 'user6@gmail.com', NULL, '$2y$12$v/A0iwyEoRjVwD1EcLVA8.YYrZLC20EYxQWpdL.KmWZ/9616ZIW8m', 'pengguna', 'Cirebon', 'Perempuan', '2024-06-11', '8367844', 'Ginjal', NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(37, 'user7', 'user7@gmail.com', NULL, '$2y$12$VH2R.CGrKKjx2tHXGdrC1u/PKwIJInJ5OQ3O7cdyU8vZxx3aQ/hde', 'pengguna', 'Cirebon', 'Laki-Laki', '2024-06-12', '88185555', 'Ginjal', NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(38, 'user8', 'user8@gmail.com', NULL, '$2y$12$UOyq8zeUDymQSEq0wMc4C.cN3idbbW01gn9L2.faKgdQ9Y8mJ2LPG', 'pengguna', 'Cirebon', 'Laki-Laki', '2024-06-04', '82737445', '-', NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(39, 'user9', 'user9@gmail.com', NULL, '$2y$12$ihowboVYIzd5Wowt/w0PwuuhSeaE0SQGfWo33CLn8kc8ozIscH3/O', 'pengguna', 'Cirebon', 'Laki-Laki', '2024-06-12', '88637724', 'Ginjal', NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(40, 'user10', 'user10@gmail.com', NULL, '$2y$12$SZ8CbXNNCszKQfEeiQIZiODzM2FmjAguVVM4VWsvhKUndugEu9eQO', 'pengguna', 'Cirebon', 'Laki-Laki', '2024-06-11', '8773777445', 'Ginjal', NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(41, 'user11', 'user11@gmail.com', NULL, '$2y$12$whIi980XvYkIo0KH1Tz92.b6KZS9ppJXvzubBa87wzP4/PZUnGIXG', 'pengguna', 'Cirebon', 'Laki-Laki', '2024-06-11', '8882344', 'Ginjal', NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(42, 'user12', 'user12@gmail.com', NULL, '$2y$12$AXwzp5FlX1iGV6wDrJ9d0euOa4RnwFZnAeCDA5.cBIjqS1Rro8pqe', 'pengguna', 'Cirebon', 'Laki-Laki', '2024-06-11', '887636634', '-', NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(43, 'user13', 'user13@gmail.com', NULL, '$2y$12$m3bUSp/NU.gRoFZeekz/qOs3AlZ3pj4BSv0U036HyA4tzP/TyAKwi', 'pengguna', 'Cirebon', 'Laki-Laki', '2024-06-06', '888263664', '-', NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(44, 'user14', 'user14@gmail.com', NULL, '$2y$12$TZCL9b0wuNy0iVamIytij.lQtuo7dUT1kXDFMjFcHuxyHzdktz7EK', 'pengguna', 'Cirebon', 'Laki-Laki', '2024-06-05', '8876263455', '-', NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(45, 'user15', 'user15@gmail.com', NULL, '$2y$12$NHYvDk7BcELY/z.rIRBaceI8pdEqtod9lAvFF.9IJwF1coeGPw5kq', 'pengguna', 'Cirebon', 'Laki-Laki', '2024-06-20', '88297394', '-', NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(48, 'Lucky Saputra ', 'admin99@gmail.com', NULL, '$2y$12$8eVyAB8k8I/N9I1C6h3lFukhjorX.GVqywIVW9wqupjABm9.vLxcW', 'pengguna', 'Mundu', 'Laki-laki', '2024-07-05', '088867257334', 'Ginjal', NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(49, 'bot', 'admin54@example.com', NULL, '$2y$12$gUvMgaBzBrWnQoczGVwmCeMhpTm3o77S1F6zcl3inZ9NL2xroY2p.', 'pengguna', 'sigebang', 'Laki-laki', '2024-07-10', '24578899', 'xd', NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(50, 'Mentor', 'admin99@example.com', NULL, '$2y$12$2TaDw9TYoyMMatm09muj6uLmWu9dTTUL7WnYGEwe9l4nLQmzDE1si', 'pengguna', 'ss', 'Laki-laki', '2024-07-11', '34567432', 'r', NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(51, 'Herman', 'herman@gmail.com', NULL, '$2y$12$AdHWoMx0d24S7VawHrR3ROzScoKmWPL96PXW2jY.TlqtliD2Putre', 'pengguna', 'Jl. raya Luwung kecamatan mundu kabupaten cirebon', 'Laki-laki', '2000-02-10', '08812345678', 'Bukan penyakit ginjal', NULL, '2024-07-20 22:07:38', '2024-07-20 22:07:38'),
(52, 'Admin2', 'admin11@gmail.com', NULL, '$2y$12$IRMbJxP1TnG7fpi1dRloj.w/l3Ba7XyS/xmR1ZPcMzxHZa3DtUU8y', 'admin', NULL, NULL, NULL, '0888682737', NULL, 'nsCUWgwUOBdQEMdMzzgTDFi8xFtRaS1m0CDIVOl9orDT4Xt0Q0qjXnSTmboA', '2024-08-23 00:43:06', NULL),
(57, 'tasmini', 'damnlux21@gmail.com', NULL, '$2y$12$Pu.FDEMsAX35F2njmmxXmuRhHCir/T3c67dUZ/zBNpJyBWBg2hzHG', 'pengguna', 'Luwung', 'Laki-laki', '2024-08-15', '8282', 'Jantung', 'nfcrKanvyp1hkfCgjIx6yCzHoCIhcSUGKOxCK7nsriNEi2DhoQiMrzf2gSAh', '2024-08-23 00:44:28', '2024-08-03 00:55:06'),
(61, 'Boni', 'boni@gmail.com', NULL, '$2y$12$s2HqYj0xNCksRiqO0JOWwO3a77rlGCZhgZezC3C7e/v5I8S4U6Z0e', 'pengguna', 'Bandengan', 'Laki-laki', '2024-08-08', '0886255332211', 'Ginjal', NULL, '2024-08-23 00:58:20', '2024-08-23 00:58:20');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `analisa`
--
ALTER TABLE `analisa`
  ADD PRIMARY KEY (`id_analisa`);

--
-- Indexes for table `aturan`
--
ALTER TABLE `aturan`
  ADD PRIMARY KEY (`id_aturan`),
  ADD KEY `idpenyakit` (`idpenyakit`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `gejala`
--
ALTER TABLE `gejala`
  ADD PRIMARY KEY (`id_gejala`);

--
-- Indexes for table `hasil_diagnosis`
--
ALTER TABLE `hasil_diagnosis`
  ADD PRIMARY KEY (`id_hasil`),
  ADD KEY `idpengguna` (`idpengguna`);

--
-- Indexes for table `kondisi_pengguna`
--
ALTER TABLE `kondisi_pengguna`
  ADD PRIMARY KEY (`id_kondisi`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `penyakit`
--
ALTER TABLE `penyakit`
  ADD PRIMARY KEY (`id_penyakit`);

--
-- Indexes for table `random_index`
--
ALTER TABLE `random_index`
  ADD PRIMARY KEY (`id_random_index`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `analisa`
--
ALTER TABLE `analisa`
  MODIFY `id_analisa` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1331;

--
-- AUTO_INCREMENT for table `aturan`
--
ALTER TABLE `aturan`
  MODIFY `id_aturan` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10002;

--
-- AUTO_INCREMENT for table `hasil_diagnosis`
--
ALTER TABLE `hasil_diagnosis`
  MODIFY `id_hasil` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=195;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `aturan`
--
ALTER TABLE `aturan`
  ADD CONSTRAINT `aturan_ibfk_1` FOREIGN KEY (`idpenyakit`) REFERENCES `penyakit` (`id_penyakit`);

--
-- Constraints for table `hasil_diagnosis`
--
ALTER TABLE `hasil_diagnosis`
  ADD CONSTRAINT `hasil_diagnosis_ibfk_1` FOREIGN KEY (`idpengguna`) REFERENCES `users` (`id`);

--
-- Constraints for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD CONSTRAINT `password_reset_tokens_ibfk_1` FOREIGN KEY (`email`) REFERENCES `users` (`email`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
