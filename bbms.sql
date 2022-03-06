-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 15, 2021 at 02:47 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 8.0.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bbms`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `name` varchar(30) NOT NULL,
  `email` varchar(30) NOT NULL,
  `pass` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`name`, `email`, `pass`) VALUES
('shanto', 'ms.shanto1234@gmail.com', '$2y$10$pk/ktKgc7liQRTM5mjKaI.Z4I7.GRjasbEjCtCgvetgSFtH5ihB2K'),
('sakib', 'sakib@gmail.com', '$2y$10$HU8d4HgMafGwL/K7zMM.Vu57kKjfhGMQWztarw1.gJQ.nmka59Uha'),
('shimanto', 'shimanto@gmail.com', '$2y$10$pjUHeAp1.vqKmaiUdEWeTONIyTSb0AjLOORNfaOj7.5fCe7aIDOL2');

-- --------------------------------------------------------

--
-- Table structure for table `bill`
--

CREATE TABLE `bill` (
  `receipt_no` int(10) NOT NULL,
  `bloodgroup` varchar(3) NOT NULL,
  `email` varchar(30) NOT NULL,
  `unit` int(5) NOT NULL,
  `price` int(5) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `bill`
--

INSERT INTO `bill` (`receipt_no`, `bloodgroup`, `email`, `unit`, `price`, `date`) VALUES
(1, 'A+', 'shanto@gmail.com', 1, 100, '2021-08-19'),
(2, 'B+', 'shanto@gmail.com', 1, 100, '2021-08-19'),
(3, 'B+', 'shanto@gmail.com', 1, 100, '2021-08-19'),
(4, 'A-', 'qwe@qwe', 1, 300, '2021-08-25'),
(5, 'A-', 'qwe@qwe', 1, 450, '2021-08-25'),
(6, 'AB+', 'ewrdsfs@sdf', 1, 800, '2021-08-25'),
(16, 'A+', 'shanto@gmail.com', 1, 100, '2021-08-26'),
(18, 'A+', 'shimanto@gmail.com', 2, 200, '2021-08-26'),
(19, 'A+', 'ms.shanto1234@gmail.com', 1, 100, '2021-08-26'),
(20, 'A+', 'shimanto@gmail.com', 2, 200, '2021-08-28');

-- --------------------------------------------------------

--
-- Table structure for table `blood`
--

CREATE TABLE `blood` (
  `blood_id` int(10) NOT NULL,
  `bloodgroup` varchar(3) NOT NULL,
  `price` int(5) NOT NULL,
  `info` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `blood`
--

INSERT INTO `blood` (`blood_id`, `bloodgroup`, `price`, `info`) VALUES
(1, 'A+', 100, 'Can donate blood to A+ and AB+ and recive blood from A+, A-, O+ and O-'),
(2, 'A-', 150, 'Can donate blood to A- and AB- and receive blood from A+, A-, O+ and O-'),
(3, 'B+', 200, 'Can donate blood to B+ and AB+ and receive blood from B+, O+'),
(4, 'B-', 250, 'Can donate blood to B- and AB-  and receive blood from B-, O-'),
(5, 'O+', 300, 'Can donate blood to all people  and receive blood from O+'),
(6, 'O-', 350, 'Can donate blood to all people  and receive blood from O-'),
(7, 'AB+', 400, 'Can donate blood to A+, B+ and AB+  and receive blood from AB+, O+'),
(8, 'AB-', 450, 'Can donate blood to A-, B- and AB-  and receive blood from AB-, O-');

-- --------------------------------------------------------

--
-- Table structure for table `blood-request`
--

CREATE TABLE `blood-request` (
  `booking_id` int(10) NOT NULL,
  `user_mail` varchar(30) NOT NULL,
  `blood_group` varchar(3) NOT NULL,
  `unit` int(1) NOT NULL,
  `price` int(10) NOT NULL,
  `req_date` date NOT NULL,
  `req_expire_date` date NOT NULL,
  `status` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `blood-request`
--

INSERT INTO `blood-request` (`booking_id`, `user_mail`, `blood_group`, `unit`, `price`, `req_date`, `req_expire_date`, `status`) VALUES
(1, 'shimanto@gmail.com', 'A+', 2, 200, '2021-08-11', '2021-09-25', 'paid'),
(8, 'ms.shanto1234@gmail.com', 'A+', 1, 100, '2021-08-26', '0000-00-00', 'paid'),
(9, 'sakib@gmail.com', 'AB+', 1, 400, '2021-09-05', '2022-02-02', 'unpaid');

-- --------------------------------------------------------

--
-- Table structure for table `bloodstock`
--

CREATE TABLE `bloodstock` (
  `bagid` int(15) NOT NULL,
  `donorname` varchar(30) NOT NULL,
  `email` varchar(30) NOT NULL,
  `mobilenumber` int(11) NOT NULL,
  `bloodgroup` varchar(3) NOT NULL,
  `storedate` date NOT NULL,
  `expirydate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `bloodstock`
--

INSERT INTO `bloodstock` (`bagid`, `donorname`, `email`, `mobilenumber`, `bloodgroup`, `storedate`, `expirydate`) VALUES
(1, 'shanto', 'ms.shanto1234@gmail.com', 1792157755, 'B+', '2021-08-14', '2022-05-14'),
(2, 'sakib', 'sakib@gmail.com', 123498756, 'O+', '2021-08-20', '2021-08-20'),
(3, 'shimanto', 'shimanto@gmail.com', 123456, 'A+', '2021-09-09', '2021-11-12'),
(4, 'fardin', 'fardin@gmail.com', 1232123, 'A-', '2021-04-06', '2021-08-08'),
(5, 'rakib', 'rakib@gmail.com', 1796385, 'B-', '2021-03-02', '2021-05-05'),
(6, 'mehdi', 'mehdi@gmail.com', 17845231, 'AB+', '2021-12-06', '2022-06-02'),
(7, 'rahim', 'rahim@gmail.com', 1982351, 'AB-', '2021-01-03', '2021-09-09'),
(8, 'shohan', 'shohan@gmail.com', 8712045, 'AB+', '2021-03-07', '2021-08-15'),
(9, 'saif', 'saif@gmail.com', 1234129852, 'B+', '2021-03-18', '2022-06-18'),
(10, 'rafi', 'rafi@gmail.com', 21323499, 'O-', '2021-08-25', '0202-02-25');

-- --------------------------------------------------------

--
-- Table structure for table `donor-reg`
--

CREATE TABLE `donor-reg` (
  `name` varchar(30) NOT NULL,
  `email` varchar(30) NOT NULL,
  `birthday` date NOT NULL,
  `bloodgroup` varchar(5) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `mobilenumber` int(20) NOT NULL,
  `city` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `donor-reg`
--

INSERT INTO `donor-reg` (`name`, `email`, `birthday`, `bloodgroup`, `gender`, `mobilenumber`, `city`) VALUES
('jamal', 'jamal@gmail.com', '1991-01-02', 'A+', 'Male', 123423, 'gulshan'),
('juel', 'juel@gmail.com', '1998-06-08', 'A+', 'Male', 424254, 'ashkona'),
('korim', 'korim@gmail.com', '1991-02-02', 'O-', 'Male', 123234, 'badda'),
('mithu', 'mithu@gmail.com', '1995-02-03', 'A+', 'Male', 213234234, 'uttara'),
('mithun', 'mithun@gmail.com', '1991-07-09', 'B+', 'Male', 123456789, 'uttara'),
('shanto', 'ms.shanto1234@gmail.com', '1997-09-16', 'B+', 'Male', 1792157755, 'uttara'),
('nupur', 'nupur@gmail.com', '1999-04-05', 'A-', 'Female', 2341256, 'uttara'),
('pranto', 'pranto@gmail.com', '2003-02-04', 'B+', 'Male', 2147483647, 'uttara'),
('rahim', 'rahim@gmail.com', '1999-03-06', 'O+', 'Male', 1232343454, 'gulshan'),
('rakib', 'rakib@gmail.com', '1997-03-09', 'B-', 'Male', 234123234, 'tongi'),
('rakib', 'rakibsarkar@gmail.com', '1998-03-03', 'AB+', 'Male', 1231232434, 'gazipur'),
('raya', 'raya@gmail.com', '1991-02-05', 'O-', 'Female', 123434545, 'ashkona'),
('sadia', 'sadia@gmail.com', '1996-08-02', 'A+', 'Female', 155332211, 'gulshan'),
('sakib', 'sakib@gmail.com', '1997-07-09', 'O-', 'Male', 2123451273, 'bonosree'),
('shamim', 'shanmim@gmail.com', '1988-09-08', 'AB-', 'Male', 234123, 'gazipur'),
('shimanto', 'shimanto@gmail.com', '1999-04-05', 'B+', 'Male', 1732123234, 'bonosree');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `name` varchar(30) NOT NULL,
  `email` varchar(30) NOT NULL,
  `pass` varchar(260) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`name`, `email`, `pass`) VALUES
('shanto', 'ms.shanto1234@gmail.com', '$2y$10$X5EACUNqJQTDVRrnhtVyj.KlXazzkKNVQchiZFk5IGDwglIsAkAym'),
('sakib', 'sakib@gmail.com', '$2y$10$GhvMvbNYoGbzec2FJYgW7.VNTjFDcY.sZx/i/DkJeZ12RWa5wZeC6'),
('shimanto', 'shimanto@gmail.com', '$2y$10$59i.53qGSxP1l0d4A3i02Oh3ZaWiWAnluyDjYjjKrCTKaJ6Y3w.EG');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `bill`
--
ALTER TABLE `bill`
  ADD PRIMARY KEY (`receipt_no`);

--
-- Indexes for table `blood`
--
ALTER TABLE `blood`
  ADD PRIMARY KEY (`blood_id`),
  ADD UNIQUE KEY `bloodgroup` (`bloodgroup`);

--
-- Indexes for table `blood-request`
--
ALTER TABLE `blood-request`
  ADD PRIMARY KEY (`booking_id`),
  ADD UNIQUE KEY `user_mail` (`user_mail`);

--
-- Indexes for table `bloodstock`
--
ALTER TABLE `bloodstock`
  ADD PRIMARY KEY (`bagid`);

--
-- Indexes for table `donor-reg`
--
ALTER TABLE `donor-reg`
  ADD PRIMARY KEY (`email`),
  ADD UNIQUE KEY `mobilenumber` (`mobilenumber`) USING BTREE;

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bill`
--
ALTER TABLE `bill`
  MODIFY `receipt_no` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `blood-request`
--
ALTER TABLE `blood-request`
  MODIFY `booking_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `bloodstock`
--
ALTER TABLE `bloodstock`
  MODIFY `bagid` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
