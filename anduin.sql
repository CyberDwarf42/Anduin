-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 05, 2024 at 01:50 AM
-- Server version: 8.3.0
-- PHP Version: 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `anduin`
--

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

DROP TABLE IF EXISTS `customer`;
CREATE TABLE IF NOT EXISTS `customer` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `Name` varchar(50) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `StreetAddress` varchar(70) NOT NULL,
  `City` varchar(40) NOT NULL,
  `State` varchar(2) NOT NULL,
  `ZipCode` int NOT NULL,
  `PhoneNumber` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `customer`
--


-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

DROP TABLE IF EXISTS `inventory`;
CREATE TABLE IF NOT EXISTS `inventory` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `Name` varchar(30) NOT NULL,
  `Description` varchar(100) NOT NULL,
  `QtyOnHand` int NOT NULL,
  `QtyCommitted` int NOT NULL,
  `Price` float NOT NULL,
  `ImagePath` varchar(400) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`ID`, `Name`, `Description`, `QtyOnHand`, `QtyCommitted`, `Price`, `ImagePath`) VALUES
(1, 'New York Strip', 'average weight 1lb', 4, 0, 16, '/Anduin/Images/New York Strip.jpg'),
(3, 'Brisket', 'average weight 3.5lb', 4, 0, 40, '/Anduin/Images/BeefBrisket.jpg'),
(4, 'Bone in Rib Steak', 'average weight 1.65lb', 4, 0, 26, '/Anduin/Images/BoneinRibSteak.jpeg'),
(6, 'Sirloin Tip Steak', 'average weight 1.45 lb', 3, 0, 35.99, '/Anduin/Images/SirloinTipSteak.jpg'),
(7, 'Ranch Steak', 'average weight 1lb', 5, 0, 13, '/Anduin/Images/ranchsteak.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `lineitems`
--

DROP TABLE IF EXISTS `lineitems`;
CREATE TABLE IF NOT EXISTS `lineitems` (
  `Line` int NOT NULL AUTO_INCREMENT,
  `Item` int NOT NULL,
  `Qty` int NOT NULL,
  `OrderID` int DEFAULT NULL,
  PRIMARY KEY (`Line`),
  KEY `Item` (`Item`),
  KEY `OrderID` (`OrderID`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `lineitems`
--


-- --------------------------------------------------------

--
-- Table structure for table `orderids`
--

DROP TABLE IF EXISTS `orderids`;
CREATE TABLE IF NOT EXISTS `orderids` (
  `OrderID` int NOT NULL AUTO_INCREMENT,
  `Customer` int NOT NULL,
  `picked` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`OrderID`),
  KEY `Customer` (`Customer`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `orderids`
--

--
-- Constraints for dumped tables
--

--
-- Constraints for table `lineitems`
--
ALTER TABLE `lineitems`
  ADD CONSTRAINT `ItemInfo` FOREIGN KEY (`Item`) REFERENCES `inventory` (`ID`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `OrderInfo` FOREIGN KEY (`OrderID`) REFERENCES `orderids` (`OrderID`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `orderids`
--
ALTER TABLE `orderids`
  ADD CONSTRAINT `CustomerInfo` FOREIGN KEY (`Customer`) REFERENCES `customer` (`ID`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
