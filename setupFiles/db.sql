-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 25, 2013 at 04:27 PM
-- Server version: 5.1.44
-- PHP Version: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `alacakTakip`
--

-- --------------------------------------------------------

--
-- Table structure for table `ayarlar`
--

DROP TABLE IF EXISTS `ayarlar`;
CREATE TABLE IF NOT EXISTS `ayarlar` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `key` varchar(255) COLLATE utf8_turkish_ci NOT NULL,
  `value` varchar(255) COLLATE utf8_turkish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci AUTO_INCREMENT=8 ;

--
-- Dumping data for table `ayarlar`
--

INSERT INTO `ayarlar` (`id`, `key`, `value`) VALUES
(1, 'sahip', 'Onur Çelik'),
(2, 'sifre', '12345'),
(3, 'db_adi', 'alacakTakip'),
(4, 'db_user', 'root'),
(5, 'db_pass', ''),
(7, 'email', 'onurcelik@me.com'),
(6, 'db_host', 'localhost');

-- --------------------------------------------------------

--
-- Table structure for table `islemler`
--

DROP TABLE IF EXISTS `islemler`;
CREATE TABLE IF NOT EXISTS `islemler` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `musteri_id` varchar(255) COLLATE utf8_turkish_ci NOT NULL,
  `tarih` varchar(255) COLLATE utf8_turkish_ci NOT NULL,
  `aciklama` varchar(255) COLLATE utf8_turkish_ci NOT NULL,
  `tutar` varchar(255) COLLATE utf8_turkish_ci NOT NULL,
  `tip` varchar(255) COLLATE utf8_turkish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci AUTO_INCREMENT=18 ;

--
-- Dumping data for table `islemler`
--

INSERT INTO `islemler` (`id`, `musteri_id`, `tarih`, `aciklama`, `tutar`, `tip`) VALUES
(1, '1', '10/01/2013', 'cam balkon yapildi', '1500', '0'),
(2, '1', '10/02/2013', 'Nesrine Odeme', '500', '1'),
(3, '1', '10/03/2013', 'Ayseye Odenen', '325', '1'),
(4, '1', '10/04/2013', 'Camlar onarildi', '480', '0'),
(11, '1', '10/05/2013', 'Banka havalesi', '100', '1'),
(17, '1', '10/20/2013', 'odeme yapildi..', '55', '1');

-- --------------------------------------------------------

--
-- Table structure for table `musteriler`
--

DROP TABLE IF EXISTS `musteriler`;
CREATE TABLE IF NOT EXISTS `musteriler` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `isimsoyisim` varchar(255) COLLATE utf8_turkish_ci NOT NULL,
  `adres` varchar(255) COLLATE utf8_turkish_ci NOT NULL,
  `telefon1` varchar(255) COLLATE utf8_turkish_ci NOT NULL,
  `telefon2` varchar(255) COLLATE utf8_turkish_ci NOT NULL,
  `telefon3` varchar(255) COLLATE utf8_turkish_ci NOT NULL,
  `hesap_durumu` int(2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci AUTO_INCREMENT=28 ;

--
-- Dumping data for table `musteriler`
--

INSERT INTO `musteriler` (`id`, `isimsoyisim`, `adres`, `telefon1`, `telefon2`, `telefon3`, `hesap_durumu`) VALUES
(1, 'Onur Çelik', 'onurcelik adress', '05397048108', 'tel 2', 'tel 3', 1),
(27, 'Hedeler Hedesi', 'Hede Sok. Hede Apt No : hede, HEDE', '1234', '5678', '9101112', 0);
