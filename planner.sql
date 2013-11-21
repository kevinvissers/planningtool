-- phpMyAdmin SQL Dump Dylan Derwael
-- version 3.4.11.1deb2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 21, 2013 at 10:54 AM
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
  `idfunctie` int(11) NOT NULL,
  PRIMARY KEY (`gebruikersID`),
  KEY `idfunctie` (`idfunctie`)
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
  `uitgevoerd` tinyint(1) NOT NULL DEFAULT '0',
  `gebruikersID` int(11) NOT NULL,
  `iduitvoerder` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `klantID` (`klantID`),
  KEY `gebruikersID` (`gebruikersID`),
  KEY `eindTijd` (`eindTijd`),
  KEY `iduitvoerder` (`iduitvoerder`),
  KEY `iduitvoerder_2` (`iduitvoerder`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `functiegebruiker`
--

CREATE TABLE IF NOT EXISTS `functiegebruiker` (
  `idfunctie` int(11) NOT NULL AUTO_INCREMENT,
  `functienaam` varchar(25) NOT NULL,
  `userrole` int(11) NOT NULL,
  PRIMARY KEY (`idfunctie`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `gemeente`
--

CREATE TABLE IF NOT EXISTS `gemeente` (
  `Idgemeente` int(11) NOT NULL AUTO_INCREMENT,
  `gemeente` varchar(25) NOT NULL,
  `postcode` varchar(8) NOT NULL,
  PRIMARY KEY (`Idgemeente`)
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
  `idgemeente` int(11) NOT NULL,
  `telefoon` varchar(30) DEFAULT NULL,
  `gsm` varchar(30) DEFAULT NULL,
  `email` varchar(70) DEFAULT NULL,
  `opmerking` mediumtext,
  PRIMARY KEY (`klantID`),
  KEY `idgemeente` (`idgemeente`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `materiaallijst`
--

CREATE TABLE IF NOT EXISTS `materiaallijst` (
  `idMateriaalLijst` int(11) NOT NULL AUTO_INCREMENT,
  `afspraakid` int(11) DEFAULT NULL,
  `materiaalid` int(11) DEFAULT NULL,
  `aantal` int(11) DEFAULT NULL,
  `eenheid` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`idMateriaalLijst`),
  KEY `afspraakid` (`afspraakid`,`materiaalid`),
  KEY `afspraakid_2` (`afspraakid`,`materiaalid`),
  KEY `materiaalid` (`materiaalid`),
  KEY `materiaalid_2` (`materiaalid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `materialen`
--

CREATE TABLE IF NOT EXISTS `materialen` (
  `materiaalID` int(11) NOT NULL AUTO_INCREMENT,
  `materiaalNaam` varchar(70) NOT NULL,
  PRIMARY KEY (`materiaalID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `aanmeldgegevens`
--
ALTER TABLE `aanmeldgegevens`
  ADD CONSTRAINT `aanmeldgegevens_ibfk_2` FOREIGN KEY (`idfunctie`) REFERENCES `functiegebruiker` (`idfunctie`) ON UPDATE CASCADE;

--
-- Constraints for table `afspraken`
--
ALTER TABLE `afspraken`
  ADD CONSTRAINT `afspraken_ibfk_2` FOREIGN KEY (`gebruikersID`) REFERENCES `aanmeldgegevens` (`gebruikersID`) ON UPDATE CASCADE,
  ADD CONSTRAINT `afspraken_ibfk_3` FOREIGN KEY (`klantID`) REFERENCES `klanten` (`klantID`) ON UPDATE CASCADE,
  ADD CONSTRAINT `afspraken_ibfk_4` FOREIGN KEY (`iduitvoerder`) REFERENCES `aanmeldgegevens` (`gebruikersID`) ON UPDATE CASCADE;

--
-- Constraints for table `klanten`
--
ALTER TABLE `klanten`
  ADD CONSTRAINT `klanten_ibfk_2` FOREIGN KEY (`idgemeente`) REFERENCES `gemeente` (`Idgemeente`) ON UPDATE CASCADE;

--
-- Constraints for table `materiaallijst`
--
ALTER TABLE `materiaallijst`
  ADD CONSTRAINT `materiaallijst_ibfk_3` FOREIGN KEY (`materiaalid`) REFERENCES `materialen` (`materiaalID`),
  ADD CONSTRAINT `materiaallijst_ibfk_1` FOREIGN KEY (`afspraakid`) REFERENCES `afspraken` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
