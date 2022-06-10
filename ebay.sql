-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3307
-- Generation Time: May 28, 2022 at 04:32 AM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ebay`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `Name` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`Name`) VALUES
('Smart Phones'),
('Smart Watches'),
('Earphones'),
('Household'),
('Electronics'),
('Kitchen Appliances'),
('Apparel'),
('Shoes'),
('Watches'),
('Fashion'),
('Toys'),
('Gaming');

-- --------------------------------------------------------

--
-- Table structure for table `credentials`
--

CREATE TABLE `credentials` (
  `Name` varchar(30) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Password` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `credentials`
--



-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `Product Name` varchar(60) NOT NULL,
  `Price` decimal(6,2) NOT NULL,
  `Description` varchar(250) NOT NULL,
  `Username` varchar(30) NOT NULL,
  `Image Folder` varchar(30) NOT NULL,
  `Id` varchar(80) NOT NULL,
  `Shipping` decimal(4,2) NOT NULL,
  `Image Name` varchar(90) NOT NULL,
  `Date` date NOT NULL DEFAULT current_timestamp(),
  `Quantity` int(11) NOT NULL,
  `Category` varchar(40) NOT NULL,
  `Clicks` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`Product Name`, `Price`, `Description`, `Username`, `Image Folder`, `Id`, `Shipping`, `Image Name`, `Date`, `Quantity`, `Category`, `Clicks`) VALUES
('Portrait', '9.54', 'testing7  ', 'Ryzan', 'images/', '06248ff4f31f65a7cffdf7d95b4a4ca3ab48847c', '0.00', '28fa90e689e01ed560fa4b672351459c04a15da5', '2022-01-07', 0, 'Landscape', 2),
('Apple Iphone X', '399.00', 'Iphone X Phone', 'Ryzan', 'images/', '0ce12ad2b245a4119f3416f3845042a43ad911a7', '15.00', '081264120ec6e41b4a7207052780c0b0e78a1a13', '2022-03-07', 0, 'Smart Phones', 1),
('tester10', '44.50', '', 'trollboay', 'images/', '20e04d84ed064d82244f201d9d8fbcbceb1b1694', '0.00', '5acb0d5888aa1d9fba01918648ee92537b4d0a4d', '2022-01-30', 6, '', 3),
('T-Shirt', '4.95', 'testing5 ', 'Ryzan', 'images/', '4f44fe6d8af052ee628a5e0f165db704500f912a', '0.00', 'f0bc85d4cbb70c47ddb27645e2560a6670b5bc08', '2022-01-07', 1, 'Apparel', 2),
('Sweatshirt', '4.45', 'testing9 ', 'Ryzan', 'images/', '715b0e7c72266257eed752f024ad681dd777b22c', '1.75', '7081c3744e5834933fe8ff120d227340b184f17d', '2022-01-20', 4, 'Apparel', 1),
('Shirt', '4.12', 'testing4 ', 'Ryzan', 'images/', '724ea2c89045b39a5cc306b6172753d39dee7a8f', '0.00', '811bbcef134221473ac45763e58a2dde00bfe8dc', '2022-01-07', -2, 'Apparel', 2),
('Barn', '1.25', 'testing8 ', 'Ryzan', 'images/', '790d663aaeceb221658b0c573e316ca57782d55c', '0.30', 'eeebfd4040c27bf5c24bff6ef8fb9c47a3d27ab3', '2022-01-07', 4, 'Toys', 1),
('Apple Iphone 7', '299.00', 'Iphone 7 phone', 'Ryzan', 'images/', '7d30ecc8f12fcb74280c2c3e83b9b514430bfcc6', '12.00', 'b1a2f75968d92daa776ec681f86d4358b760032b', '2022-03-17', 3, 'Smart Phones', 1),
('Blender', '3.99', 'testing1 ', 'Ryzan', 'images/', 'a913c9203d342b831b4f2648f5674d4c36fb1c1d', '2.45', '696dd11730355badbb3adb804a7994ec70dcc015', '2022-01-07', 4, 'Kitchen Appliances', 1),
('Rolex', '5.45', 'Testing2 ', 'Ryzan', 'images/', 'b1c0ebabe5f44cdc94923ee55647f39a365b3936', '3.99', 'a380169c7807c288a1c33dbebd551a0a395f6ccc', '2022-01-07', 4, 'Watches', 1),
('Refrigerator', '8.50', 'testing6 ', 'Ryzan', 'images/', 'cbb9762160a72e6ecd212ae62cb6aa7e79c8ad99', '0.00', '1a8075ef9a3c33a24f7e54cf9a8f57ececb51a7d', '2022-01-07', 4, 'Kitchen Appliances', 1),
('Apple Iphone 9', '350.00', 'Iphone 9 phone', 'Ryzan', 'images/', 'ed9f6eff15035472f22aec0008ec27570e6bb6f8', '15.00', '16a9b54cec10b57f6eaa35d9140ef4f3e1af90eb', '2022-03-17', 5, 'Smart Phones', 1);

-- --------------------------------------------------------

--
-- Table structure for table `product images`
--

CREATE TABLE `product images` (
  `Id` varchar(80) NOT NULL,
  `Img` varchar(90) NOT NULL,
  `Img Folder` varchar(30) NOT NULL,
  `Img Index` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product images`
--

INSERT INTO `product images` (`Id`, `Img`, `Img Folder`, `Img Index`) VALUES
('4f44fe6d8af052ee628a5e0f165db704500f912a', '5a5e6eb5989d019822ba7b52ffd65c0aec409f1f', 'images/', 0),
('724ea2c89045b39a5cc306b6172753d39dee7a8f', 'dadb74a97972e9c86dafd8b321b2289100203c5b', 'images/', 0),
('b1c0ebabe5f44cdc94923ee55647f39a365b3936', '317453118374e004e6bff61f1f6a6d3815c5f5f1', 'images/', 0),
('cbb9762160a72e6ecd212ae62cb6aa7e79c8ad99', '6f2726a20df0d828059592800aa9cb96ae67351c', 'images/', 0),
('cbb9762160a72e6ecd212ae62cb6aa7e79c8ad99', '15bc0cfd79cd7839b2b8a4edcdc267bf310fc8fc', 'images/', 0),
('790d663aaeceb221658b0c573e316ca57782d55c', '45477e0247264d6d765a476e73d6390f252cd497', 'images/', 0),
('715b0e7c72266257eed752f024ad681dd777b22c', 'f791b9e24519804cbca2662ccfc07c2eddbce078', 'images/', 0),
('715b0e7c72266257eed752f024ad681dd777b22c', '5dd750003d9bab265a8848985113917c1dd4ad94', 'images/', 0),
('20e04d84ed064d82244f201d9d8fbcbceb1b1694', '6686a0ab88b77770d1da456e95d4ba41f1813ccf', 'images/', 0),
('7d30ecc8f12fcb74280c2c3e83b9b514430bfcc6', 'd38485d7bcbe629d5d800d28e13767d318a63436', 'images/', 2),
('ed9f6eff15035472f22aec0008ec27570e6bb6f8', 'bbe32287db8a5f842be067443984dd9b8a2201b4', 'images/', 2),
('ed9f6eff15035472f22aec0008ec27570e6bb6f8', '64bed7381fdcf594729688843076d3d0d149bcd6', 'images/', 3);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `credentials`
--
ALTER TABLE `credentials`
  ADD PRIMARY KEY (`Email`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`Id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
