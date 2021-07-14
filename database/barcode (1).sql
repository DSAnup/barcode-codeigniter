-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 14, 2021 at 07:17 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `barcode`
--

-- --------------------------------------------------------

--
-- Table structure for table `barcode_info`
--

CREATE TABLE `barcode_info` (
  `id` int(11) NOT NULL,
  `barcode` varchar(150) NOT NULL,
  `manu_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `product_name` varchar(150) NOT NULL,
  `price` varchar(20) NOT NULL,
  `size` varchar(10) NOT NULL,
  `quantity` int(11) NOT NULL,
  `imgname` varchar(250) NOT NULL,
  `ordernumber` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `barcode_info`
--

INSERT INTO `barcode_info` (`id`, `barcode`, `manu_date`, `product_name`, `price`, `size`, `quantity`, `imgname`, `ordernumber`) VALUES
(1, 'SG_A1001_1001', '2021-07-14 17:06:53', '', '', '', 0, '1626282413SG_A1001_1001.png', 'A1001'),
(2, 'SG_A1001_1001', '2021-07-14 17:15:27', '', '', '', 0, '1626282927SG_A1001_1001.png', 'A1001');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barcode_info`
--
ALTER TABLE `barcode_info`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `barcode_info`
--
ALTER TABLE `barcode_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
