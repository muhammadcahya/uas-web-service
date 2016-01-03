-- phpMyAdmin SQL Dump
-- version 4.0.9
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 04, 2016 at 06:49 AM
-- Server version: 5.5.34
-- PHP Version: 5.4.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `uas`
--

-- --------------------------------------------------------

--
-- Table structure for table `laptops`
--

CREATE TABLE IF NOT EXISTS `laptops` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `brand` varchar(10) DEFAULT NULL,
  `model` varchar(30) DEFAULT NULL,
  `release_year` year(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `laptops`
--

INSERT INTO `laptops` (`id`, `brand`, `model`, `release_year`) VALUES
(1, 'Asus', 'X200', 2014),
(2, 'Lenovo ', 'E10', 2015),
(3, 'Asus', 'S200E', 2015),
(4, 'Toshiba', ' C800', 2013),
(5, 'Lenovo', 'S20', 2014),
(6, 'Dell', '3442', 2015),
(7, 'HP', 'D016TU', 2015),
(8, 'Acer', 'ES1-111', 2014),
(9, 'HP ', 'R236TX', 2015),
(10, 'Acer', 'Z1401', 2014);

-- --------------------------------------------------------

--
-- Table structure for table `parts`
--

CREATE TABLE IF NOT EXISTS `parts` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `laptop_id` int(3) DEFAULT NULL,
  `part_category` int(3) DEFAULT NULL,
  `part_number` int(11) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `parts_to_laptop` (`laptop_id`),
  KEY `parts_to_category` (`part_category`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `parts`
--

INSERT INTO `parts` (`id`, `laptop_id`, `part_category`, `part_number`, `description`) VALUES
(1, 1, 1, 11001, 'Part keyboard for laptop'),
(2, 1, 2, 11002, 'Part LCD Protector for laptop'),
(3, 1, 3, 11003, 'Part MousePad for laptop'),
(4, 1, 4, 11004, 'Part USB Port for laptop'),
(5, 2, 5, 21001, 'Part Fan for laptop'),
(6, 2, 6, 21002, 'Part Keyboard Protector laptop'),
(7, 3, 1, 31001, 'Part keyboard for laptop'),
(8, 4, 7, 41001, 'Part RAM for laptop'),
(9, 5, 8, 51001, 'Part Cooler for laptop'),
(10, 5, 9, 51002, 'Part webcam for laptop'),
(11, 5, 10, 51003, 'Part charge cable for laptop'),
(12, 6, 6, 61001, 'Part Keyboard Protector laptop'),
(13, 7, 6, 71001, 'Part Keyboard Protector laptop'),
(14, 8, 3, 81001, 'Part MousePad for laptop'),
(15, 9, 2, 91001, 'Part LCD Protector for laptop'),
(16, 9, 6, 91001, 'Part Keyboard Protector laptop'),
(17, 10, 5, 10001, 'Part Fan for laptop');

-- --------------------------------------------------------

--
-- Table structure for table `parts_categories`
--

CREATE TABLE IF NOT EXISTS `parts_categories` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `categories_name` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `parts_categories`
--

INSERT INTO `parts_categories` (`id`, `categories_name`) VALUES
(1, 'keyboard'),
(2, 'lcd protector'),
(3, 'mouse pad'),
(4, 'usb port'),
(5, 'fan'),
(6, 'keyboard protector'),
(7, 'ram'),
(8, 'cooler'),
(9, 'webcam'),
(10, 'charger cable');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `parts`
--
ALTER TABLE `parts`
  ADD CONSTRAINT `parts_to_category` FOREIGN KEY (`part_category`) REFERENCES `parts_categories` (`id`),
  ADD CONSTRAINT `parts_to_laptop` FOREIGN KEY (`laptop_id`) REFERENCES `laptops` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
