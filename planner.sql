-- phpMyAdmin SQL Dump Dylan Derwael
-- version 3.4.11.1deb2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 14, 2013 at 10:29 AM
-- Server version: 5.5.31
-- PHP Version: 5.4.4-14+deb7u5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `planner`
--
CREATE DATABASE `planner` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `planner`;

-- --------------------------------------------------------

--
-- Table structure for table `Informatie`
--

CREATE TABLE IF NOT EXISTS `Informatie` (
  `intId` int(11) NOT NULL,
  `strDescription` mediumtext NOT NULL,
  `strValue` longtext NOT NULL,
  `strPage` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `aanmeldgegevens`
--

CREATE TABLE IF NOT EXISTS `aanmeldgegevens` (
  `gebruikersID` int(11) NOT NULL AUTO_INCREMENT,
  `gebruikersNaam` varchar(50) NOT NULL,
  `wachtwoord` varchar(30) NOT NULL,
  `gebruikersfunctie` int(11) NOT NULL,
  PRIMARY KEY (`gebruikersID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `afspraken`
--

CREATE TABLE IF NOT EXISTS `afspraken` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `datum` date NOT NULL,
  `klantID` varchar(50) NOT NULL,
  `startTijd` datetime NOT NULL,
  `eindTijd` datetime DEFAULT NULL,
  `omschrijving` varchar(70) DEFAULT NULL,
  `actief` tinyint(1) NOT NULL,
  `gebruikersID` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `klantID` (`klantID`),
  KEY `gebruikersID` (`gebruikersID`),
  KEY `eindTijd` (`eindTijd`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `klanten`
--

CREATE TABLE IF NOT EXISTS `klanten` (
  `klantID` varchar(10) NOT NULL,
  `voornaam` varchar(25) NOT NULL,
  `achternaam` varchar(25) NOT NULL,
  `straat` varchar(50) NOT NULL,
  `huisnummer` varchar(20) NOT NULL,
  `postcode` varchar(10) NOT NULL,
  `gemeente` varchar(50) NOT NULL,
  `telefoon` varchar(30) DEFAULT NULL,
  `gsm` varchar(30) DEFAULT NULL,
  `email` varchar(70) DEFAULT NULL,
  `opmerking` mediumtext,
  PRIMARY KEY (`klantID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `materialen`
--

CREATE TABLE IF NOT EXISTS `materialen` (
  `materiaalID` int(11) NOT NULL AUTO_INCREMENT,
  `afspraakId` int(11) NOT NULL,
  `materiaalNaam` varchar(70) NOT NULL,
  `aantal` double DEFAULT NULL,
  `eenheid` varchar(10) DEFAULT NULL,
  `gebruikerID` int(11) NOT NULL,
  PRIMARY KEY (`materiaalID`),
  KEY `gebruikerID` (`gebruikerID`),
  KEY `afspraakId` (`afspraakId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `afspraken`
--
ALTER TABLE `afspraken`
  ADD CONSTRAINT `afspraken_ibfk_2` FOREIGN KEY (`gebruikersID`) REFERENCES `aanmeldgegevens` (`gebruikersID`) ON UPDATE CASCADE,
  ADD CONSTRAINT `afspraken_ibfk_3` FOREIGN KEY (`klantID`) REFERENCES `klanten` (`klantID`) ON UPDATE CASCADE;

--
-- Constraints for table `materialen`
--
ALTER TABLE `materialen`
  ADD CONSTRAINT `materialen_ibfk_1` FOREIGN KEY (`gebruikerID`) REFERENCES `aanmeldgegevens` (`gebruikersID`) ON UPDATE CASCADE,
  ADD CONSTRAINT `materialen_ibfk_2` FOREIGN KEY (`afspraakId`) REFERENCES `afspraken` (`id`) ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
