-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Machine: localhost
-- Genereertijd: 29 nov 2013 om 18:46
-- Serverversie: 5.5.16
-- PHP-Versie: 5.3.8

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
-- Tabelstructuur voor tabel `aanmeldgegevens`
--

CREATE TABLE IF NOT EXISTS `aanmeldgegevens` (
  `gebruikersID` int(11) NOT NULL AUTO_INCREMENT,
  `gebruikersNaam` varchar(50) NOT NULL,
  `wachtwoord` varchar(100) NOT NULL,
  `idfunctie` int(11) NOT NULL,
  PRIMARY KEY (`gebruikersID`),
  KEY `idfunctie` (`idfunctie`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Gegevens worden uitgevoerd voor tabel `aanmeldgegevens`
--

INSERT INTO `aanmeldgegevens` (`gebruikersID`, `gebruikersNaam`, `wachtwoord`, `idfunctie`) VALUES
(1, 'kevin.vissers@telenet.be', '9b9824df65f716b71db9f51299346088', 1),
(2, 'bart.bollen@student.khlim.be', '9b9824df65f716b71db9f51299346088', 1),
(3, 'dylan.derwael@student.khlim.be', '37686ba33dd511ea2e2c435eb38e1f94', 2);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `afspraken`
--

CREATE TABLE IF NOT EXISTS `afspraken` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `klantID` int(11) NOT NULL,
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Gegevens worden uitgevoerd voor tabel `afspraken`
--

INSERT INTO `afspraken` (`id`, `klantID`, `startTijd`, `eindTijd`, `omschrijving`, `actief`, `uitgevoerd`, `gebruikersID`, `iduitvoerder`) VALUES
(1, 1, '2013-11-29 16:00:00', '2013-11-29 17:00:00', '', 1, 0, 1, 1),
(2, 1, '2013-11-29 15:00:00', '2013-11-29 16:00:00', 'blablabla', 1, 1, 1, 1),
(3, 2, '2013-11-05 13:00:00', '2013-11-05 19:00:00', 'hihi', 1, 0, 2, 3);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `functiegebruiker`
--

CREATE TABLE IF NOT EXISTS `functiegebruiker` (
  `idfunctie` int(11) NOT NULL AUTO_INCREMENT,
  `functienaam` varchar(25) NOT NULL,
  `userrole` int(11) NOT NULL,
  PRIMARY KEY (`idfunctie`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Gegevens worden uitgevoerd voor tabel `functiegebruiker`
--

INSERT INTO `functiegebruiker` (`idfunctie`, `functienaam`, `userrole`) VALUES
(1, 'super-admin', 3),
(2, 'admin', 2),
(3, 'standaard', 1),
(4, 'bezoeker', 0);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `gemeente`
--

CREATE TABLE IF NOT EXISTS `gemeente` (
  `Idgemeente` int(11) NOT NULL AUTO_INCREMENT,
  `gemeente` varchar(25) NOT NULL,
  `postcode` varchar(8) NOT NULL,
  PRIMARY KEY (`Idgemeente`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Gegevens worden uitgevoerd voor tabel `gemeente`
--

INSERT INTO `gemeente` (`Idgemeente`, `gemeente`, `postcode`) VALUES
(1, 'Schoten', '9000'),
(2, 'Averbode', '3271');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `informatie`
--

CREATE TABLE IF NOT EXISTS `informatie` (
  `intId` int(11) NOT NULL,
  `strDescription` mediumtext NOT NULL,
  `strValue` longtext NOT NULL,
  `strPage` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `klanten`
--

CREATE TABLE IF NOT EXISTS `klanten` (
  `klantID` int(11) NOT NULL AUTO_INCREMENT,
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Gegevens worden uitgevoerd voor tabel `klanten`
--

INSERT INTO `klanten` (`klantID`, `voornaam`, `achternaam`, `straat`, `huisnummer`, `idgemeente`, `telefoon`, `gsm`, `email`, `opmerking`) VALUES
(1, 'Joske', 'Vermeulen', 'Ergens', '122', 1, '', '', '', ''),
(2, 'Jan', 'Jansens', 'Schoolstraat', '3', 2, '', '', '', '');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `materiaallijst`
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
-- Tabelstructuur voor tabel `materialen`
--

CREATE TABLE IF NOT EXISTS `materialen` (
  `materiaalID` int(11) NOT NULL AUTO_INCREMENT,
  `materiaalNaam` varchar(70) NOT NULL,
  PRIMARY KEY (`materiaalID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Beperkingen voor gedumpte tabellen
--

--
-- Beperkingen voor tabel `aanmeldgegevens`
--
ALTER TABLE `aanmeldgegevens`
  ADD CONSTRAINT `aanmeldgegevens_ibfk_2` FOREIGN KEY (`idfunctie`) REFERENCES `functiegebruiker` (`idfunctie`) ON UPDATE CASCADE;

--
-- Beperkingen voor tabel `afspraken`
--
ALTER TABLE `afspraken`
  ADD CONSTRAINT `afspraken_ibfk_2` FOREIGN KEY (`gebruikersID`) REFERENCES `aanmeldgegevens` (`gebruikersID`) ON UPDATE CASCADE,
  ADD CONSTRAINT `afspraken_ibfk_3` FOREIGN KEY (`klantID`) REFERENCES `klanten` (`klantID`) ON UPDATE CASCADE,
  ADD CONSTRAINT `afspraken_ibfk_4` FOREIGN KEY (`iduitvoerder`) REFERENCES `aanmeldgegevens` (`gebruikersID`) ON UPDATE CASCADE;

--
-- Beperkingen voor tabel `klanten`
--
ALTER TABLE `klanten`
  ADD CONSTRAINT `klanten_ibfk_2` FOREIGN KEY (`idgemeente`) REFERENCES `gemeente` (`Idgemeente`) ON UPDATE CASCADE;

--
-- Beperkingen voor tabel `materiaallijst`
--
ALTER TABLE `materiaallijst`
  ADD CONSTRAINT `materiaallijst_ibfk_1` FOREIGN KEY (`afspraakid`) REFERENCES `afspraken` (`id`),
  ADD CONSTRAINT `materiaallijst_ibfk_3` FOREIGN KEY (`materiaalid`) REFERENCES `materialen` (`materiaalID`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
