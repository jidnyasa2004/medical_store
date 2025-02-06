-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 24, 2025 at 08:51 PM
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
-- Database: `webdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `credential`
--

CREATE TABLE `credential` (
  `u_id` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(20) NOT NULL,
  `user_type` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `credential`
--

INSERT INTO `credential` (`u_id`, `username`, `email`, `password`, `user_type`) VALUES
(1, 'abc', 'abc@gmail.com', '1234', 'user'),
(2, 'jid', 'jidnyasapatil474@gmail.com', '1234', 'user'),
(3, 'jidnyasa', 'jidnyasap2004@gmail.com', '12345', 'user'),
(4, 'admin', 'jidnyasapatil474@gmail.com', '1111', 'admin'),
(5, 'admin', 'admin@gmail.com', '1111', 'admin'),
(6, 'admin', 'admin@gmail.com', '11111', NULL),
(7, 'admin', 'admin@gmail.com', '1111', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `c_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `contact` varchar(15) NOT NULL,
  `address` text NOT NULL,
  `email` varchar(255) NOT NULL,
  `u_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `medicines`
--

CREATE TABLE `medicines` (
  `med_id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `description` varchar(50) NOT NULL,
  `type` varchar(20) NOT NULL,
  `quantity` int(10) NOT NULL,
  `exp_date` date NOT NULL,
  `mfg_date` date NOT NULL,
  `price` int(20) NOT NULL,
  `image_path` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `medicines`
--

INSERT INTO `medicines` (`med_id`, `name`, `description`, `type`, `quantity`, `exp_date`, `mfg_date`, `price`, `image_path`) VALUES
(11, ' Sinarest New Strip Of 15 Tabl', 'Sinarest New Tablet is a medication used to treat ', 'tablet', 45, '2026-01-06', '2023-01-02', 45, NULL),
(12, ' Dolo 650mg Strip Of 15 Tablet', 'Dolo 650 tablets relieve pain, fever, headaches, t', 'tablet', 23, '2027-11-17', '2025-01-23', 33, NULL),
(13, 'Evion 400mg Strip Of 10 Capsul', 'Evion 400 capsule is a vitamin supplement. Evion 4', 'tablet', 34, '2025-12-23', '2024-11-28', 34, NULL),
(14, 'New Saridon Strip Of 10 Tablet', 'Saridon is a remedy for Headache trusted since 193', 'tablet', 60, '2027-07-26', '2025-01-23', 50, NULL),
(16, 'Himalaya Koflet H Orange Flavo', ' Relief From Cough & Sore Throat Strip Of 6 Lozeng', 'tablet', 41, '2027-10-23', '2025-01-23', 35, 'uploads/himalayakoflet.webp'),
(17, ' Pentaloc 40mg Strip Of 15 Tab', 'Pentaloc tablet is a medicine used to reduce acid ', 'tablet', 50, '2027-05-05', '2025-01-23', 130, 'uploads/pentaloc.webp'),
(18, 'Cheston Cold New Formula Strip', 'Cheston Cold tablet is a combination medicine used', 'tablet', 48, '2027-11-23', '2024-07-10', 60, 'uploads/cheston.webp'),
(19, 'Cetrizine Bottle Of 60ml Syrup', 'Cetirizine is an antihistamine that is used to tre', 'syrup', 50, '2026-10-21', '2024-05-07', 43, 'uploads/cetrizine_bottle.webp'),
(20, 'Zerodol Sp Strip Of 10 Tablets', 'edical Description\r\nZerodol-SP tablet is a pain-re', 'tablet', 40, '2027-05-04', '2023-02-04', 140, 'uploads/zerodol_sp.webp'),
(21, ' Myospaz Forte Strip Of 10 Tab', 'Myospaz forte tablet is used for the symptomatic t', 'tablet', 50, '2025-05-11', '2022-12-11', 351, 'uploads/myospaz.webp'),
(22, 'Moktel Strip Of 15 Tablets', 'Moktel tablet is a health supplement containing es', 'tablet', 50, '2026-12-10', '2023-02-01', 207, 'uploads/moktel.webp'),
(23, 'Shelcal 500mg Strip Of 15 Tabl', 'Shelcal 500 Tablet is a vitamin and mineral supple', 'tablet', 40, '2026-03-03', '2023-01-01', 145, 'uploads/shelcal500.webp'),
(24, 'Martifur Mr 100mg Strip Of 10 ', 'Martifur MR 100 mg tablet is used for the treatmen', 'tablet', 50, '2026-12-12', '2022-04-02', 212, 'uploads/martifur.webp'),
(25, 'Drotin Ds 80mg Strip Of 15 Tab', 'Drotin DS tablets help relieve muscle spasms in th', 'tablet', 50, '2027-12-10', '2025-01-23', 250, 'uploads/drotin.webp');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `order_date` date NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `no_of_items` int(11) NOT NULL,
  `med_id` int(11) NOT NULL,
  `date_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `customer_name`, `order_date`, `total_amount`, `no_of_items`, `med_id`, `date_time`) VALUES
(1, 'suji', '2025-01-23', 56.00, 1, 11, '2025-01-23 10:31:47');

-- --------------------------------------------------------

--
-- Table structure for table `stock`
--

CREATE TABLE `stock` (
  `stock_id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `description` varchar(20) NOT NULL,
  `type` varchar(20) NOT NULL,
  `quantity` int(20) NOT NULL,
  `med_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `stock`
--

INSERT INTO `stock` (`stock_id`, `name`, `description`, `type`, `quantity`, `med_id`) VALUES
(2, 'paracetamol', 'used for headache', 'tablet', 35, 25),
(3, '', '', 'tablet', 20, 20),
(4, '', '', 'tablet', 10, 23),
(5, '', '', 'tablet', 20, 24),
(6, '', '', 'syrup', 30, 19);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `credential`
--
ALTER TABLE `credential`
  ADD PRIMARY KEY (`u_id`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`c_id`);

--
-- Indexes for table `medicines`
--
ALTER TABLE `medicines`
  ADD PRIMARY KEY (`med_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `stock`
--
ALTER TABLE `stock`
  ADD PRIMARY KEY (`stock_id`),
  ADD KEY `fk_med_id` (`med_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `credential`
--
ALTER TABLE `credential`
  MODIFY `u_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `c_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `medicines`
--
ALTER TABLE `medicines`
  MODIFY `med_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `stock`
--
ALTER TABLE `stock`
  MODIFY `stock_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `stock`
--
ALTER TABLE `stock`
  ADD CONSTRAINT `fk_med_id` FOREIGN KEY (`med_id`) REFERENCES `medicines` (`med_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
