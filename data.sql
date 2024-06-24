-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 24, 2024 at 09:52 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `final_project`
--

-- --------------------------------------------------------

--
-- Table structure for table `admi`
--

CREATE TABLE `admi` (
  `userName` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `passwrd` varchar(50) NOT NULL,
  `phoneNumber` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admi`
--

INSERT INTO `admi` (`userName`, `email`, `passwrd`, `phoneNumber`) VALUES
('vmd', 'b@gmail.com', 'c4ca4238a0b923820dcc509a6f75849b', 112233445),
('naveen', 'dileebandileeban2001@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', 771234567),
('s.dileeban', 'dileebandileeban746@gmail.com', 'cb3ce9b06932da6faaa7fc70d5b5d2f4', 456221132);

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `userId` int(50) NOT NULL,
  `productId` int(50) NOT NULL,
  `qty` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `prod_name` varchar(50) NOT NULL,
  `prod_des` text NOT NULL,
  `price` int(10) NOT NULL,
  `prod_id` int(11) NOT NULL,
  `prod_qty` int(200) NOT NULL,
  `prod_img` varchar(100) NOT NULL,
  `brand_name` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`prod_name`, `prod_des`, `price`, `prod_id`, `prod_qty`, `prod_img`, `brand_name`) VALUES
('the queens of animation', 'asdnbaa asdbjsa asdnbkj adskj qwehiq fasmf sfnv i hrevhes svrhwer trw', 4455, 26, 3, 'arrivals/psd4  flyer design for cakeshop.jpg', 'apache'),
('the good life', 'asdnbaa asdbjsa asdnbkj adskj qwehiq fasmf sfnv i hrevhes svrhwer trw', 7777, 27, 6, 'arrivals/psd2 biology flyer.jpg', 'apache'),
('the queens of animation', 'ccnbvmb,', 5555, 28, 3, 'arrivals/psd2 biology flyer.jpg', 'pulsar'),
('as', 'excellent', 2222, 29, 3, 'arrivals/psd2 biology flyer.jpg', 'honda'),
('ds', 'excellent', 2222, 30, 3, 'arrivals/psd4  flyer design for cakeshop.jpg', 'honda'),
('dsee', 'excellent', 2222, 31, 3, 'arrivals/psd2 biology flyer.jpg', 'honda'),
('dseed', 'excellent', 2222, 32, 3, 'arrivals/myimage_3.jpg', 'honda'),
('dseedqwe', 'excellent', 2222, 33, 3, 'arrivals/psd4  flyer design for cakeshop.jpg', 'honda'),
('dseedqwevhv', 'excellent', 2222, 34, 3, 'arrivals/psd4  flyer design for cakeshop.jpg', 'hornet');

-- --------------------------------------------------------

--
-- Table structure for table `review`
--

CREATE TABLE `review` (
  `rId` int(50) NOT NULL,
  `reviewerName` text NOT NULL,
  `review` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `review`
--

INSERT INTO `review` (`rId`, `reviewerName`, `review`) VALUES
(0, 'dileeban ', 'cool');

-- --------------------------------------------------------

--
-- Table structure for table `superadmin`
--

CREATE TABLE `superadmin` (
  `userName` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `passwrd` varchar(50) NOT NULL,
  `phoneNumber` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `superadmin`
--

INSERT INTO `superadmin` (`userName`, `email`, `passwrd`, `phoneNumber`) VALUES
('vmd', 'b@gmail.com', 'c4ca4238a0b923820dcc509a6f75849b', 112233445),
('naveen', 'dileebandileeban2001@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', 0);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `userName` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `passwrd` varchar(50) NOT NULL,
  `phoneNumber` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`userName`, `email`, `passwrd`, `phoneNumber`) VALUES
('dileeba', 'b@gmail.com', 'c81e728d9d4c2f636f067f89cc14862c', 778899007),
('dileeb', 'sunil1@gmail.com', 'c4ca4238a0b923820dcc509a6f75849b', 778899007);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admi`
--
ALTER TABLE `admi`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`prod_id`);

--
-- Indexes for table `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`rId`);

--
-- Indexes for table `superadmin`
--
ALTER TABLE `superadmin`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`email`),
  ADD UNIQUE KEY `userName` (`userName`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `prod_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
