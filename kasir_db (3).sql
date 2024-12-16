-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 16, 2024 at 04:23 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kasir_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `exchange_history`
--

CREATE TABLE `exchange_history` (
  `id` int(11) NOT NULL,
  `member_id` int(11) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `points_used` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `exchange_history`
--

INSERT INTO `exchange_history` (`id`, `member_id`, `item_id`, `quantity`, `points_used`, `created_at`) VALUES
(1, 1, 1, 2, 200, '2024-12-14 13:16:11'),
(2, 13, 2, 2, 500, '2024-12-15 05:13:05'),
(3, 4, 2, 5, 1250, '2024-12-15 07:55:05'),
(4, 16, 2, 2, 500, '2024-12-16 02:51:44'),
(5, 17, 1, 1, 100, '2024-12-16 02:59:33'),
(6, 17, 2, 1, 250, '2024-12-16 02:59:42');

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `name`, `price`, `stock`) VALUES
(1, 'Rokok Elektrik A', '150000.00', 6),
(2, 'Rokok Elektrik B', '200000.00', 3),
(3, 'Liquid Rasa Mangga', '50000.00', 35),
(4, 'Liquid Rasa Anggur', '60000.00', 68),
(5, 'Aksesoris Rokok Elektrik', '75000.00', 0),
(6, 'Liquid Rasa Mie Ayam', '25000.00', 3),
(7, 'Rokok Ironman', '99000.00', 16),
(8, 'Hexohm REV G', '3000000.00', 4),
(10, 'Centaurus E40', '320000.00', 12),
(11, 'wulan', '1000.00', 3),
(12, 'ini barang baruu', '12000.00', 5),
(13, 'ban truk', '45000.00', 0),
(14, 'Pulse Aio V2', '900000.00', 18),
(15, 'Centaurus B60', '450000.00', 0),
(16, 'Centaurus B80', '520000.00', 17),
(17, 'Pulse Aio Mini Kit', '750000.00', 19),
(18, 'TRML T200  Limitid Inverse', '575000.00', 83),
(19, 'TRML T200', '550000.00', 19),
(20, 'Liquit Pisang terbaruuu', '20000.00', 15),
(21, 'liquid terbaruuuu sekarang', '20000.00', 100);

-- --------------------------------------------------------

--
-- Table structure for table `limit_items`
--

CREATE TABLE `limit_items` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `points_required` int(11) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `limit_items`
--

INSERT INTO `limit_items` (`id`, `name`, `points_required`, `description`, `created_at`) VALUES
(1, 'Voucher Diskon 10%', 100, 'Voucher diskon 10% untuk pembelian berikutnya', '2024-12-14 13:13:02'),
(2, 'T-shirt Merch', 250, 'T-shirt eksklusif dengan logo perusahaan', '2024-12-14 13:13:02'),
(3, 'Kopi Gratis', 50, 'Gratis satu cangkir kopi di kafe kami', '2024-12-14 13:13:02');

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE `members` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `points` int(11) DEFAULT 0,
  `total_points` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`id`, `name`, `phone`, `email`, `points`, `total_points`, `created_at`) VALUES
(4, 'Hanifah', '085268668045', 'tutu@gmail.com', 18810, 20060, '2024-12-14 09:12:48'),
(6, 'Nailah', '08364657356', 'nailahamelia@gmail.com', 298, 298, '2024-12-14 09:20:12'),
(7, 'Tari R', '0987', 'terserah@gmail.com', 1260, 1260, '2024-12-14 11:40:05'),
(8, 'John Doe', '08123456789', 'john@example.com', 150, 500, '2024-12-15 04:20:11'),
(9, 'Wulan', '08234567890', 'wuwu@example.com', 120, 700, '2024-12-15 04:20:11'),
(10, 'Ganjar', '08345678901', 'g4njr@example.com', 110, 350, '2024-12-15 04:20:11'),
(11, 'Ayang', '08456789012', 'Ky@example.com', 95, 300, '2024-12-15 04:20:11'),
(12, 'Charlie Davis', '08567890123', 'charlie@example.com', 85, 280, '2024-12-15 04:20:11'),
(13, 'Rico satya ', '0888', 'licocatya@gmail.com', 5825, 6325, '2024-12-15 04:42:54'),
(15, 'Anak baru coyy', '09876543', 'haha@gmail.com', 0, 0, '2024-12-15 08:49:56'),
(16, 'Tarii baruuu', '0987654321', 'tari@gmail.com', 1225, 1725, '2024-12-16 02:49:14'),
(17, 'ricoo', '089651309', 'ricooo@gmail.com', 225, 575, '2024-12-16 02:58:25');

-- --------------------------------------------------------

--
-- Table structure for table `pending_items`
--

CREATE TABLE `pending_items` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` int(11) NOT NULL,
  `stock` int(11) NOT NULL,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pending_items`
--

INSERT INTO `pending_items` (`id`, `name`, `price`, `stock`, `status`) VALUES
(11, 'Thelema M200 Chaostopus Edition', 550000, 2, 'pending'),
(12, 'Thelema Quest', 450000, 20, 'pending'),
(13, 'Foom X Weird Genius', 180000, 20, 'pending'),
(14, 'Foom X Prediksi', 180000, 20, 'pending'),
(15, 'Nitrous Zaion AIO', 990000, 20, 'pending'),
(16, 'Kapas Merah', 50000, 10, 'pending'),
(25, 'Lemari Baju 5 pintu', 750000, 5, 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `point_exchange_history`
--

CREATE TABLE `point_exchange_history` (
  `id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `transaction_id` int(11) NOT NULL,
  `points_earned` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `point_exchange_history`
--

INSERT INTO `point_exchange_history` (`id`, `member_id`, `transaction_id`, `points_earned`, `created_at`) VALUES
(7, 13, 41, '575.00', '2024-12-15 05:12:36'),
(8, 13, 42, '5750.00', '2024-12-15 07:49:40'),
(9, 16, 43, '1725.00', '2024-12-16 02:50:49'),
(10, 4, 44, '60.00', '2024-12-16 02:56:49'),
(11, 6, 45, '198.00', '2024-12-16 02:57:50'),
(12, 17, 46, '575.00', '2024-12-16 02:59:07');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock` int(11) NOT NULL,
  `image_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `stock`, `image_url`) VALUES
(1, 'WHY V2 Strawberry', '140000.00', 10, './asset/product/1.png'),
(2, 'Coffeemel by Emkay', '150000.00', 5, './asset/product/2.png'),
(4, 'Apple Fuji 60ML', '130000.00', 15, './asset/product/3.png'),
(5, 'Smok RPM 2', '170000.00', 50, './asset/product/4.png'),
(6, 'WHY Banana Cream', '140000.00', 30, './asset/product/5.png'),
(7, 'Fuel Tutti Frutti Salt', '110000.00', 25, './asset/product/6.png'),
(8, 'CMW Bule Bolu', '150000.00', 40, './asset/product/7.png'),
(16, 'Billet Box Blue', '6400000.00', 2, './asset/product/8.png'),
(17, 'Choco Boo Snack', '145000.00', 23, './asset/product/9.png'),
(18, 'WHY V2 Strawberry', '140000.00', 10, './asset/product/1.png'),
(19, 'Coffeemel by Emkay', '150000.00', 5, './asset/product/2.png'),
(20, 'Apple Fuji 60ML', '130000.00', 15, './asset/product/3.png'),
(21, 'Smok RPM 2', '170000.00', 50, './asset/product/4.png'),
(22, 'WHY Banana Cream', '140000.00', 30, './asset/product/5.png'),
(23, 'Fuel Tutti Frutti Salt', '110000.00', 25, './asset/product/6.png'),
(24, 'CMW Bule Bolu', '150000.00', 40, './asset/product/7.png'),
(25, 'Billet Box Blue', '6400000.00', 2, './asset/product/8.png'),
(26, 'Choco Boo Snack', '145000.00', 23, './asset/product/9.png');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `member_id` int(11) DEFAULT NULL,
  `total` decimal(10,2) NOT NULL,
  `payment_method` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `cash_given` decimal(10,2) DEFAULT NULL,
  `change_amount` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `member_id`, `total`, `payment_method`, `created_at`, `cash_given`, `change_amount`) VALUES
(2, NULL, '275000.00', 'tunai', '2024-12-04 16:52:54', '300000.00', '0.00'),
(3, NULL, '275000.00', 'tunai', '2024-12-02 16:54:45', '300000.00', '0.00'),
(4, NULL, '135000.00', 'tunai', '2023-12-04 16:59:41', '150000.00', '0.00'),
(5, NULL, '235000.00', 'non-tunai', '2024-12-04 17:01:12', '0.00', '0.00'),
(6, NULL, '450000.00', 'tunai', '2024-12-05 01:14:32', '500000.00', '0.00'),
(7, NULL, '225000.00', 'tunai', '2024-10-05 02:24:34', '300000.00', '0.00'),
(8, NULL, '475000.00', 'tunai', '2024-12-05 03:45:12', '500000.00', '0.00'),
(10, NULL, '199000.00', 'tunai', '2024-12-05 11:35:00', '300000.00', '0.00'),
(11, NULL, '1540000.00', 'tunai', '2024-12-05 12:01:24', '2000000.00', '0.00'),
(12, NULL, '6460000.00', 'tunai', '2024-12-05 12:12:13', '7000000.00', '0.00'),
(13, NULL, '695000.00', 'tunai', '2024-12-05 12:16:28', '1000000.00', '0.00'),
(14, NULL, '75000.00', 'tunai', '2024-12-05 12:23:01', '100000.00', '0.00'),
(15, NULL, '60000.00', 'tunai', '2024-12-05 12:31:10', '100000.00', '0.00'),
(16, NULL, '335000.00', 'tunai', '2024-12-05 12:55:12', '0.00', '0.00'),
(17, NULL, '335000.00', 'tunai', '2024-09-05 12:55:37', '400000.00', '0.00'),
(18, NULL, '324000.00', 'tunai', '2024-12-05 14:52:13', '350000.00', '0.00'),
(19, NULL, '2500000.00', 'tunai', '2024-12-06 03:51:47', '2500000.00', '0.00'),
(20, NULL, '1000.00', 'non-tunai', '2024-12-06 04:36:31', '0.00', '0.00'),
(21, NULL, '450000.00', 'tunai', '2024-12-06 12:55:12', '500000.00', '0.00'),
(22, NULL, '3000000.00', 'tunai', '2024-09-07 03:46:09', '3000000.00', '0.00'),
(23, NULL, '4785000.00', '', '2024-12-07 05:11:26', '0.00', '0.00'),
(24, NULL, '4180000.00', 'tunai', '2024-12-07 05:37:45', '4500000.00', '0.00'),
(25, NULL, '4180000.00', 'tunai', '2024-12-07 05:39:23', '4500000.00', '0.00'),
(26, NULL, '2180000.00', 'tunai', '2022-12-07 05:42:24', '4500000.00', '0.00'),
(27, NULL, '2180000.00', 'tunai', '2024-12-07 05:44:51', '4500000.00', '0.00'),
(28, NULL, '1071000.00', 'tunai', '2024-12-07 05:45:48', '1100000.00', '0.00'),
(29, NULL, '850000.00', 'tunai', '2024-12-07 11:02:59', '850000.00', '0.00'),
(30, NULL, '900000.00', 'tunai', '2024-12-07 11:37:59', '1000000.00', '0.00'),
(31, NULL, '750000.00', 'tunai', '2024-12-07 11:47:32', '800000.00', '0.00'),
(32, NULL, '99000.00', 'tunai', '2024-12-07 13:16:34', '100000.00', '0.00'),
(33, NULL, '3100000.00', 'tunai', '2024-12-10 05:38:21', '3500000.00', '0.00'),
(34, NULL, '100000.00', 'tunai', '2024-12-10 05:42:46', '1000000.00', '0.00'),
(35, NULL, '3175000.00', 'tunai', '2024-12-11 12:22:25', '3200000.00', '0.00'),
(36, NULL, '720000.00', 'tunai', '2024-12-12 04:28:30', '800000.00', '0.00'),
(37, NULL, '60000.00', '', '2024-12-14 01:30:43', '0.00', '0.00'),
(38, NULL, '1025000.00', 'tunai', '2024-12-14 01:42:31', '1100000.00', '0.00'),
(39, NULL, '575000.00', 'tunai', '2024-12-14 02:09:54', '600000.00', '0.00'),
(40, NULL, '575000.00', 'tunai', '2024-12-14 04:07:23', '600000.00', '0.00'),
(41, NULL, '575000.00', 'tunai', '2024-12-14 15:40:55', '600000.00', '0.00'),
(42, NULL, '5750000.00', 'tunai', '2024-12-15 07:49:06', '6000000.00', '0.00'),
(43, NULL, '1725000.00', 'tunai', '2024-12-16 02:50:32', '2000000.00', '0.00'),
(44, NULL, '60000.00', 'tunai', '2024-12-16 02:55:48', '100000.00', '0.00'),
(45, NULL, '198000.00', 'tunai', '2024-12-16 02:57:30', '200000.00', '0.00'),
(46, NULL, '575000.00', 'tunai', '2024-12-16 02:58:42', '99999999.99', '0.00'),
(47, NULL, '3000000.00', 'tunai', '2024-12-16 03:04:34', '99999999.99', '0.00');

-- --------------------------------------------------------

--
-- Table structure for table `transaction_details`
--

CREATE TABLE `transaction_details` (
  `id` int(11) NOT NULL,
  `transaction_id` int(11) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `subtotal` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaction_details`
--

INSERT INTO `transaction_details` (`id`, `transaction_id`, `item_id`, `quantity`, `subtotal`) VALUES
(4, 2, 2, 1, '200000.00'),
(5, 2, 5, 1, '75000.00'),
(6, 3, 2, 1, '200000.00'),
(7, 3, 5, 1, '75000.00'),
(8, 4, 4, 1, '60000.00'),
(9, 4, 5, 1, '75000.00'),
(10, 5, 4, 1, '60000.00'),
(11, 5, 3, 2, '100000.00'),
(12, 5, 5, 1, '75000.00'),
(13, 6, 1, 3, '450000.00'),
(14, 7, 3, 2, '100000.00'),
(15, 7, 6, 5, '125000.00'),
(17, 8, 5, 5, '375000.00'),
(19, 10, 3, 1, '50000.00'),
(20, 10, 6, 2, '50000.00'),
(21, 10, 7, 1, '99000.00'),
(22, 11, 5, 1, '75000.00'),
(23, 11, 5, 1, '75000.00'),
(24, 11, 10, 2, '640000.00'),
(25, 11, 1, 5, '750000.00'),
(26, 12, 4, 1, '60000.00'),
(27, 12, 8, 2, '6000000.00'),
(28, 12, 3, 5, '250000.00'),
(29, 12, 5, 2, '150000.00'),
(30, 13, 5, 1, '75000.00'),
(31, 13, 10, 1, '320000.00'),
(32, 13, 1, 2, '300000.00'),
(33, 14, 5, 1, '75000.00'),
(34, 15, 4, 1, '60000.00'),
(35, 16, 2, 1, '200000.00'),
(36, 16, 5, 1, '75000.00'),
(37, 16, 4, 1, '60000.00'),
(38, 17, 2, 1, '200000.00'),
(39, 17, 5, 1, '75000.00'),
(40, 17, 4, 1, '60000.00'),
(41, 18, 5, 3, '225000.00'),
(42, 18, 7, 1, '99000.00'),
(43, 19, 3, 50, '2500000.00'),
(44, 20, 11, 1, '1000.00'),
(45, 21, 1, 3, '450000.00'),
(46, 22, 1, 20, '3000000.00'),
(47, 23, 8, 1, '3000000.00'),
(48, 23, 14, 1, '900000.00'),
(49, 23, 10, 1, '320000.00'),
(50, 23, 13, 1, '45000.00'),
(51, 23, 16, 1, '520000.00'),
(52, 24, 4, 1, '60000.00'),
(53, 24, 10, 1, '320000.00'),
(54, 24, 15, 4, '1800000.00'),
(55, 24, 2, 10, '2000000.00'),
(56, 25, 4, 1, '60000.00'),
(57, 25, 10, 1, '320000.00'),
(58, 25, 15, 4, '1800000.00'),
(59, 25, 2, 10, '2000000.00'),
(60, 26, 4, 1, '60000.00'),
(61, 26, 10, 1, '320000.00'),
(62, 26, 15, 4, '1800000.00'),
(63, 27, 4, 1, '60000.00'),
(64, 27, 10, 1, '320000.00'),
(65, 27, 15, 4, '1800000.00'),
(66, 28, 11, 1, '1000.00'),
(67, 28, 16, 1, '520000.00'),
(68, 28, 19, 1, '550000.00'),
(69, 29, 15, 1, '450000.00'),
(70, 29, 2, 2, '400000.00'),
(71, 30, 1, 6, '900000.00'),
(72, 31, 1, 5, '750000.00'),
(73, 32, 7, 1, '99000.00'),
(74, 33, 3, 2, '100000.00'),
(75, 33, 8, 1, '3000000.00'),
(76, 34, 20, 5, '100000.00'),
(77, 35, 15, 2, '900000.00'),
(78, 35, 17, 1, '750000.00'),
(79, 35, 18, 1, '575000.00'),
(80, 35, 14, 1, '900000.00'),
(81, 35, 3, 1, '50000.00'),
(82, 36, 2, 1, '200000.00'),
(83, 36, 16, 1, '520000.00'),
(84, 37, 4, 1, '60000.00'),
(85, 38, 15, 1, '450000.00'),
(86, 38, 18, 1, '575000.00'),
(87, 39, 18, 1, '575000.00'),
(88, 40, 18, 1, '575000.00'),
(89, 41, 18, 1, '575000.00'),
(90, 42, 18, 10, '5750000.00'),
(91, 43, 18, 3, '1725000.00'),
(92, 44, 4, 1, '60000.00'),
(93, 45, 7, 1, '99000.00'),
(94, 45, 7, 1, '99000.00'),
(95, 46, 18, 1, '575000.00'),
(96, 47, 8, 1, '3000000.00');

-- --------------------------------------------------------

--
-- Table structure for table `transaction_items`
--

CREATE TABLE `transaction_items` (
  `id` int(11) NOT NULL,
  `transaction_id` int(11) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `subtotal` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `exchange_history`
--
ALTER TABLE `exchange_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `limit_items`
--
ALTER TABLE `limit_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `phone` (`phone`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `pending_items`
--
ALTER TABLE `pending_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `point_exchange_history`
--
ALTER TABLE `point_exchange_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `member_id` (`member_id`),
  ADD KEY `transaction_id` (`transaction_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaction_details`
--
ALTER TABLE `transaction_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transaction_id` (`transaction_id`),
  ADD KEY `item_id` (`item_id`);

--
-- Indexes for table `transaction_items`
--
ALTER TABLE `transaction_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transaction_id` (`transaction_id`),
  ADD KEY `item_id` (`item_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `exchange_history`
--
ALTER TABLE `exchange_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `limit_items`
--
ALTER TABLE `limit_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `members`
--
ALTER TABLE `members`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `pending_items`
--
ALTER TABLE `pending_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `point_exchange_history`
--
ALTER TABLE `point_exchange_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `transaction_details`
--
ALTER TABLE `transaction_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97;

--
-- AUTO_INCREMENT for table `transaction_items`
--
ALTER TABLE `transaction_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `point_exchange_history`
--
ALTER TABLE `point_exchange_history`
  ADD CONSTRAINT `point_exchange_history_ibfk_1` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`),
  ADD CONSTRAINT `point_exchange_history_ibfk_2` FOREIGN KEY (`transaction_id`) REFERENCES `transactions` (`id`);

--
-- Constraints for table `transaction_details`
--
ALTER TABLE `transaction_details`
  ADD CONSTRAINT `transaction_details_ibfk_1` FOREIGN KEY (`transaction_id`) REFERENCES `transactions` (`id`),
  ADD CONSTRAINT `transaction_details_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`);

--
-- Constraints for table `transaction_items`
--
ALTER TABLE `transaction_items`
  ADD CONSTRAINT `transaction_items_ibfk_1` FOREIGN KEY (`transaction_id`) REFERENCES `transactions` (`id`),
  ADD CONSTRAINT `transaction_items_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
