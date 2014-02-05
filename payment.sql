-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Feb 06, 2013 at 07:36 AM
-- Server version: 5.5.27
-- PHP Version: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `escrow`
--

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE IF NOT EXISTS `payment` (
  `price` int(255) NOT NULL,
  `quantity` int(255) NOT NULL,
  `item` varchar(255) NOT NULL,
  `seller` varchar(255) NOT NULL,
  `buyer` varchar(255) NOT NULL,
  `success_url` varchar(255) NOT NULL,
  `cancel_url` varchar(255) NOT NULL,
  `note` varchar(255) NOT NULL,
  `baggage` varchar(255) NOT NULL,
  `key_data` varchar(255) NOT NULL,
  `pubadd` varchar(255) NOT NULL,
  `privwif` varchar(255) NOT NULL,
  `privkey` varchar(255) NOT NULL,
  `frpin` varchar(255) NOT NULL,
  `buyrel` varchar(255) NOT NULL DEFAULT 'NO',
  `wid` varchar(255) NOT NULL,
  `start` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'When did the payment initiate',
  `confirm` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Is it in our hands?',
  `verifypin` varchar(255) NOT NULL,
  `inhand` varchar(255) NOT NULL DEFAULT 'NO',
  `complete` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'When did the funds release'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
