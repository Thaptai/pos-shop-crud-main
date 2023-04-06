-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 07, 2022 at 07:47 AM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `6212231004`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`) VALUES
(3, 'Toy'),
(4, 'Snack'),
(5, 'Food'),
(6, 'Weapon'),
(7, 'Picture/Image');

-- --------------------------------------------------------

--
-- Table structure for table `history`
--

CREATE TABLE `history` (
  `id` int(10) UNSIGNED NOT NULL,
  `totalPrice` varchar(20) NOT NULL,
  `paid` varchar(20) NOT NULL,
  `products` longtext NOT NULL,
  `time` varchar(50) NOT NULL,
  `user` varchar(100) NOT NULL,
  `email` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `history`
--

INSERT INTO `history` (`id`, `totalPrice`, `paid`, `products`, `time`, `user`, `email`) VALUES
(2, '3415800', '3500000', '[{\"id\":\"10\",\"name\":\"ภาพธรรมชาติ\",\"price\":\"10000\",\"remain\":\"14\",\"img\":\"vu4z6Ztbqg.jpeg\",\"count\":1},{\"id\":\"12\",\"name\":\"My team\",\"price\":\"1500000\",\"remain\":\"28\",\"img\":\"8zaF155SyY.jpg\",\"count\":2},{\"id\":\"14\",\"name\":\"Jigsaw logo\",\"price\":\"100000\",\"remain\":\"871\",\"img\":\"qOPmPpBsf0.png\",\"count\":4},{\"id\":\"15\",\"name\":\"event banner\",\"price\":\"5000\",\"remain\":\"10\",\"img\":\"bj81jP1JQ0.png\",\"count\":1},{\"id\":\"16\",\"name\":\"Authentication banner\",\"price\":\"200\",\"remain\":\"88\",\"img\":\"50jM8onZLX.png\",\"count\":4}]', '2022-02-07 12:09:30 PM', '', ''),
(3, '200000', '200000', '[{\"id\":\"14\",\"name\":\"Jigsaw logo\",\"price\":\"100000\",\"remain\":\"867\",\"img\":\"qOPmPpBsf0.png\",\"count\":2}]', '2022-02-07 12:18:24 PM', '', ''),
(5, '13350800', '14000000', '[{\"id\":\"6\",\"name\":\"House\",\"price\":\"2900000\",\"remain\":\"9\",\"img\":\"fgSjLJFbAn.png\",\"count\":4},{\"id\":\"8\",\"name\":\"Wolf Picture\",\"price\":\"75400\",\"remain\":\"1\",\"img\":\"P8LFNA6VE0.png\",\"count\":2},{\"id\":\"12\",\"name\":\"My team\",\"price\":\"1500000\",\"remain\":\"24\",\"img\":\"8zaF155SyY.jpg\",\"count\":1},{\"id\":\"14\",\"name\":\"Jigsaw logo\",\"price\":\"100000\",\"remain\":\"859\",\"img\":\"qOPmPpBsf0.png\",\"count\":1}]', '2022-02-21 03:49:02 AM', '', ''),
(6, '2900000', '3000000', '[{\"id\":\"6\",\"name\":\"House\",\"price\":\"2900000\",\"remain\":\"5\",\"img\":\"cb1fEVvXk8.png\",\"category\":\"Weapon\",\"count\":1}]', '2022-02-28 10:53:51 AM', 'Frame', ''),
(7, '2900000', '3000000', '[{\"id\":\"6\",\"name\":\"House\",\"price\":\"2900000\",\"remain\":\"3\",\"img\":\"cb1fEVvXk8.png\",\"category\":\"Weapon\",\"count\":1}]', '2022-02-28 11:04:17 AM', '', ''),
(8, '75400', '100000', '[{\"id\":\"8\",\"name\":\"Wolf Picture\",\"price\":\"75400\",\"remain\":\"7\",\"img\":\"P8LFNA6VE0.png\",\"category\":\"\",\"count\":1}]', '2022-02-28 11:06:19 AM', 'Frame', ''),
(9, '85400', '100000', '[{\"id\":\"8\",\"name\":\"Wolf Picture\",\"price\":\"75400\",\"remain\":\"6\",\"img\":\"P8LFNA6VE0.png\",\"category\":\"\",\"count\":1},{\"id\":\"10\",\"name\":\"ภาพธรรมชาติ\",\"price\":\"10000\",\"remain\":\"13\",\"img\":\"vu4z6Ztbqg.jpeg\",\"category\":\"Picture/Image\",\"count\":1}]', '2022-03-07 03:35:35 AM', 'Frame', ''),
(10, '75400', '100000', '[{\"id\":\"8\",\"name\":\"Wolf Picture\",\"price\":\"75400\",\"remain\":\"5\",\"img\":\"P8LFNA6VE0.png\",\"category\":\"\",\"count\":1}]', '2022-03-07 04:02:28 AM', 'Frame', 'gfd7812548965@gmail.com'),
(11, '75400', '1000000', '[{\"id\":\"8\",\"name\":\"Wolf Picture\",\"price\":\"75400\",\"remain\":\"4\",\"img\":\"P8LFNA6VE0.png\",\"category\":\"\",\"count\":1}]', '2022-03-07 04:03:25 AM', 'Frame', 'gfd7812548965@gmail.com'),
(12, '10000', '20000', '[{\"id\":\"10\",\"name\":\"ภาพธรรมชาติ\",\"price\":\"10000\",\"remain\":\"12\",\"img\":\"vu4z6Ztbqg.jpeg\",\"category\":\"Picture/Image\",\"count\":1}]', '2022-03-07 04:07:49 AM', 'Frame', 'gfd7812548965@gmail.com'),
(13, '10000', '10000', '[{\"id\":\"10\",\"name\":\"ภาพธรรมชาติ\",\"price\":\"10000\",\"remain\":\"11\",\"img\":\"vu4z6Ztbqg.jpeg\",\"category\":\"Picture/Image\",\"count\":1}]', '2022-03-07 04:08:51 AM', 'Frame', 'gfd7812548965@gmail.com'),
(14, '10000', '10000', '[{\"id\":\"10\",\"name\":\"ภาพธรรมชาติ\",\"price\":\"10000\",\"remain\":\"10\",\"img\":\"vu4z6Ztbqg.jpeg\",\"category\":\"Picture/Image\",\"count\":1}]', '2022-03-07 04:10:52 AM', 'Frame', 'gfd7812548965@gmail.com'),
(15, '10000', '12000', '[{\"id\":\"10\",\"name\":\"ภาพธรรมชาติ\",\"price\":\"10000\",\"remain\":\"9\",\"img\":\"vu4z6Ztbqg.jpeg\",\"category\":\"Picture/Image\",\"count\":1}]', '2022-03-07 05:03:16 AM', 'Frame', 'gfd7812548965@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` varchar(10) NOT NULL,
  `remain` int(10) NOT NULL,
  `img` varchar(200) NOT NULL,
  `category` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `name`, `price`, `remain`, `img`, `category`) VALUES
(6, 'House', '2900000', 2, 'cb1fEVvXk8.png', 'Weapon'),
(8, 'Wolf Picture', '75400', 3, 'P8LFNA6VE0.png', ''),
(10, 'ภาพธรรมชาติ', '10000', 8, 'vu4z6Ztbqg.jpeg', 'Picture/Image'),
(11, 'Smart man', '1500', 1, 'GdnHA1cKgm.jpeg', ''),
(12, 'My team', '1500000', 23, '8zaF155SyY.jpg', ''),
(14, 'Jigsaw logo', '100000', 858, 'qOPmPpBsf0.png', ''),
(15, 'event banner', '5000', 9, 'bj81jP1JQ0.png', ''),
(16, 'Authentication banner', '200', 84, '50jM8onZLX.png', '');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `email`, `password`) VALUES
(1, 'Frame', 'gfd7812548965@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `history`
--
ALTER TABLE `history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `history`
--
ALTER TABLE `history`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
