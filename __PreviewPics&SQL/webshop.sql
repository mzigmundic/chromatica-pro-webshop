-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 16, 2020 at 05:54 PM
-- Server version: 10.4.6-MariaDB
-- PHP Version: 7.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `webshop`
--

-- --------------------------------------------------------

--
-- Table structure for table `kategorije`
--

CREATE TABLE `kategorije` (
  `id` int(11) NOT NULL,
  `kategorija` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `nadkategorija` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `kategorije`
--

INSERT INTO `kategorije` (`id`, `kategorija`, `nadkategorija`) VALUES
(22, 'Gitare', 0),
(23, 'Basevi', 0),
(24, 'Klavijature', 0),
(25, 'Bubnjevi', 0),
(26, 'Efekti i miksete', 0),
(28, 'Električne gitare', 22),
(29, 'Akustične gitare', 22),
(30, 'Klasične gitare', 22),
(31, 'Električni basevi', 23),
(32, 'Akustični basevi', 23),
(33, 'Klaviri', 24),
(34, 'Klavijature', 24),
(35, 'Obični bubnjevi', 25),
(36, 'Električni bubnjevi', 25),
(37, 'Dijelovi', 25),
(38, 'Efekti', 26),
(39, 'Miksete', 26),
(45, 'Pojačala', 0),
(46, 'Pojačala za gitaru', 45),
(47, 'Pojačala za bas', 45),
(48, 'Ostalo', 0),
(49, 'Žice', 48),
(50, 'Trzalice', 48),
(51, 'Harmonike', 24);

-- --------------------------------------------------------

--
-- Table structure for table `korisnici`
--

CREATE TABLE `korisnici` (
  `id` int(11) NOT NULL,
  `puno_ime` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `lozinka` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `datum_pridruzivanja` datetime NOT NULL DEFAULT current_timestamp(),
  `posljednja_prijava` datetime NOT NULL,
  `ovlasti` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `korisnici`
--

INSERT INTO `korisnici` (`id`, `puno_ime`, `email`, `lozinka`, `datum_pridruzivanja`, `posljednja_prijava`, `ovlasti`) VALUES
(1, 'Branko Branković', 'brna@gmail.com', '$2y$10$ivVs1UmBhVqSCsx4JvTfc.uqNyeteAr/QT3Mef2BaSyJoRwmnGzIG', '2020-02-07 18:11:47', '2020-02-14 20:27:39', 'admin,urednik'),
(4, 'Slavko Slavković', 'slave@gmail.com', '$2y$10$eavaXvjg7k/NPh1zRixqbO9IOuYrNgOmzDf82BACbYt6Fl8XD.7tO', '2020-02-12 23:39:57', '2020-02-12 23:58:56', 'urednik');

-- --------------------------------------------------------

--
-- Table structure for table `kosarice`
--

CREATE TABLE `kosarice` (
  `id` int(11) NOT NULL,
  `artikli` text COLLATE utf8_unicode_ci NOT NULL,
  `vrijeme_isteka` datetime NOT NULL,
  `placeno` tinyint(4) NOT NULL DEFAULT 0,
  `isporuceno` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `kosarice`
--

INSERT INTO `kosarice` (`id`, `artikli`, `vrijeme_isteka`, `placeno`, `isporuceno`) VALUES
(37, '[{\"id\":\"72\",\"karakteristika\":\"0.85mm\",\"kolicina\":\"1\"},{\"id\":\"74\",\"karakteristika\":\"10s\",\"kolicina\":\"2\"},{\"id\":\"23\",\"karakteristika\":\"Crna\",\"kolicina\":\"1\"}]', '2020-03-14 19:44:18', 1, 1),
(38, '[{\"id\":\"73\",\"karakteristika\":\"9s\",\"kolicina\":1},{\"id\":\"21\",\"karakteristika\":\"Crna\",\"kolicina\":1}]', '2020-03-15 08:21:59', 1, 1),
(39, '[{\"id\":\"24\",\"karakteristika\":\"Boja Drvo\",\"kolicina\":\"1\"}]', '2020-03-15 10:19:48', 1, 0),
(40, '[{\"id\":\"72\",\"karakteristika\":\"0.99mm\",\"kolicina\":\"1\"},{\"id\":\"72\",\"karakteristika\":\"1.35mm\",\"kolicina\":2},{\"id\":\"59\",\"karakteristika\":\"Zelena\",\"kolicina\":\"1\"},{\"id\":\"64\",\"karakteristika\":\"Siva\",\"kolicina\":\"1\"},{\"id\":\"61\",\"karakteristika\":\"Crna\",\"kolicina\":\"1\"}]', '2020-03-15 19:27:05', 1, 1),
(41, '[{\"id\":\"56\",\"karakteristika\":\"Sive\",\"kolicina\":\"1\"},{\"id\":\"72\",\"karakteristika\":\"1.35mm\",\"kolicina\":\"3\"},{\"id\":\"65\",\"karakteristika\":\"Crni\",\"kolicina\":\"1\"},{\"id\":\"36\",\"karakteristika\":\"Boja Drvo\",\"kolicina\":\"1\"}]', '2020-03-15 20:15:29', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `marke`
--

CREATE TABLE `marke` (
  `id` int(11) NOT NULL,
  `marka` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `marke`
--

INSERT INTO `marke` (`id`, `marka`) VALUES
(6, 'Ibanez'),
(7, 'Yamaha'),
(8, 'Fender'),
(9, 'Boss'),
(10, 'Tama'),
(11, 'Korg'),
(12, 'Gibson'),
(13, 'Peavey'),
(14, 'Behringer'),
(15, 'Sony'),
(16, 'Melodija'),
(17, 'Roland'),
(18, 'Line 6'),
(19, 'Marshall');

-- --------------------------------------------------------

--
-- Table structure for table `proizvodi`
--

CREATE TABLE `proizvodi` (
  `id` int(11) NOT NULL,
  `naziv_proizvoda` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `cijena` decimal(10,2) NOT NULL,
  `marka` int(11) NOT NULL,
  `kategorija` int(11) NOT NULL,
  `slika` text COLLATE utf8_unicode_ci NOT NULL,
  `opis` text COLLATE utf8_unicode_ci NOT NULL,
  `istaknuto` tinyint(4) NOT NULL DEFAULT 0,
  `karakteristike` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `proizvodi`
--

INSERT INTO `proizvodi` (`id`, `naziv_proizvoda`, `cijena`, `marka`, `kategorija`, `slika`, `opis`, `istaknuto`, `karakteristike`) VALUES
(21, 'Akustična gitara', '2999.99', 8, 29, '/webshop/slike/proizvodi/18abce35f7ce170715549542230bf2a0.png', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\r\n\r\nBroj pragova: xx\r\n\r\nMasa: xxx g', 1, 'Crna:8,Crvena:10,Boja Drvo:10'),
(22, 'Akustična gitara', '4599.99', 6, 29, '/webshop/slike/proizvodi/1bc3d17bb052d156e0e0ec91a9147bd1.png', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\r\n\r\nBroj pragova: xx\r\n\r\nMasa: xxx g', 1, 'Boja Drvo:10,Crvena:8,Plava:11,Crna:7'),
(23, 'Akustična gitara', '1899.99', 7, 29, '/webshop/slike/proizvodi/7369f60989918ed32dec89973d3b3420.png,/webshop/slike/proizvodi/bc0449a521b75e4c6aeaef1e9c1f46a7.png', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\r\n\r\nBroj pragova: xx\r\n\r\nMasa: xxx g', 0, 'Boja Drvo:7,Crna:8'),
(24, 'Akustična gitara', '2199.99', 6, 29, '/webshop/slike/proizvodi/ede57dd820be57ae406ffca22d77e9d9.png', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\r\n\r\nBroj pragova: xx\r\n\r\nMasa: xxx g', 1, 'Boja Drvo:13,Crna:10'),
(25, 'Električna gitara', '8599.99', 8, 28, '/webshop/slike/proizvodi/701715b6d3d1dc4d230557dbf77b940c.png', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\r\n\r\nBroj pragova: xx\r\n\r\nMasa: xxx g', 1, 'Crna:11,Bijela:8'),
(26, 'Električna gitara', '2599.99', 13, 28, '/webshop/slike/proizvodi/cb4696df28c960e6cf3bac929f8457f8.png', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\r\n\r\nBroj pragova: xx\r\n\r\nMasa: xxx g', 0, 'Plava:17,Crna:12'),
(27, 'Električna gitara', '4899.99', 6, 28, '/webshop/slike/proizvodi/b279db51e2ef67e6bef3727ac4832ce9.png', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\r\n\r\nBroj pragova: xx\r\n\r\nMasa: xxx g', 0, 'Crna:13'),
(28, 'Električna gitara', '3599.99', 7, 28, '/webshop/slike/proizvodi/e5cd02fcd5a3db1b6e4b9d02b5481bdd.png', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\r\n\r\nBroj pragova: xx\r\n\r\nMasa: xxx g', 1, 'Narančasta:11,Plava:14,Zelena:12'),
(29, 'Električna gitara', '6399.99', 6, 28, '/webshop/slike/proizvodi/eee6b8dbbab360ec172a7f061d108243.png', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\r\n\r\nBroj pragova: xx\r\n\r\nMasa: xxx g', 1, 'Crna:14,Bijela:14'),
(30, 'Klasična gitara', '7699.99', 8, 30, '/webshop/slike/proizvodi/7c4b40bf20c3a6ed364e63b286156e43.png', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\r\n\r\nBroj pragova: xx\r\n\r\nMasa: xxx g', 0, 'Boja Drvo:24'),
(32, 'Akustični bas', '4759.99', 8, 32, '/webshop/slike/proizvodi/4359c8a6c4a4846ffaf1dcdf301f6f00.png', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\r\n\r\nBroj pragova: xx\r\n\r\nMasa: xxx g', 1, 'Boja Drvo:15,Crni:11'),
(33, 'Električni bas', '3699.99', 6, 31, '/webshop/slike/proizvodi/fc764598414cc7989f4a73a25226d66b.png', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\r\n\r\nBroj pragova: xx\r\n\r\nMasa: xxx g', 1, 'Crni:14,Bijeli:12'),
(34, 'Električni bas', '4299.99', 8, 31, '/webshop/slike/proizvodi/be2f6675be13d1b5cba58f560b3c1b77.png', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\r\n\r\nBroj pragova: xx\r\n\r\nMasa: xxx g', 1, 'Crni:16,Plavi:11'),
(35, 'Električni bas', '1699.99', 13, 31, '/webshop/slike/proizvodi/258a9932002b890d76bbac5b6ee92f40.png', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\r\n\r\nBroj pragova: xx\r\n\r\nMasa: xxx g', 0, 'Plavi:15,Zeleni:11,Crni:22'),
(36, 'Električni bas', '2399.99', 14, 31, '/webshop/slike/proizvodi/34325420ed1164eff22fca709f6e23fa.png', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\r\n\r\nBroj pragova: xx\r\n\r\nMasa: xxx g', 1, 'Boja Drvo:26'),
(37, 'Električni bas', '3959.99', 6, 31, '/webshop/slike/proizvodi/8da957556f71bbfce6ad23032019d103.png', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\r\n\r\nBroj pragova: xx\r\n\r\nMasa: xxx g', 1, 'Boja Drvo:16,Crveni:15'),
(38, 'Bubnjevi', '6899.99', 10, 35, '/webshop/slike/proizvodi/6fe5f3917912c165ae7a54c05244895f.png', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 1, 'Crni:28'),
(39, 'Bubnjevi', '7899.99', 7, 35, '/webshop/slike/proizvodi/d3d183d9becff6055697bbf0de3f56c5.png', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\r\n', 0, 'Crveni:17,Crni:16'),
(40, 'Bubnjevi', '3899.00', 7, 35, '/webshop/slike/proizvodi/5e169d81c8f2b9409b024c0e813d1c8d.png', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\r\n', 1, 'Plavi:21'),
(41, 'Električni bubnjevi', '8699.99', 15, 36, '/webshop/slike/proizvodi/4cfd87ca2c70b33807c2ae273231b1a1.png', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\r\n', 0, 'Crni:17'),
(42, 'Snare', '799.99', 10, 37, '/webshop/slike/proizvodi/d4566d4039967129fca329d9d59f4a93.png', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\r\n', 1, '14 inča:11,15 inča:14'),
(43, 'Hi-Hat Činele', '689.99', 11, 37, '/webshop/slike/proizvodi/9847f760bd5a7b367ef9f67eefb403c7.png', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\r\n', 1, '13 inča:14'),
(44, 'Ride Činela', '899.99', 9, 37, '/webshop/slike/proizvodi/fbbec1066d17828544d27179ceee3ae2.png', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\r\n', 1, '18 inča:15'),
(45, 'Bas bubanj', '1499.99', 13, 37, '/webshop/slike/proizvodi/22cb361075ba59ccb965005df4c05176.png', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\r\n', 1, '22 inča:15,24 inča:14'),
(46, 'Snare', '759.99', 14, 37, '/webshop/slike/proizvodi/cd49d0c9f80cccb44e41e2176354646d.png', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\r\n', 1, '14 inča:12,13 inča:14'),
(47, 'Crash Činela', '1099.99', 13, 37, '/webshop/slike/proizvodi/804a06cb9f7e839b294bff470471b27c.png', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\r\n', 1, '20 inča:19'),
(48, 'Piano', '19999.99', 12, 33, '/webshop/slike/proizvodi/4509c33ffeb616bf29b50201ed3ea364.png', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\r\n', 1, 'Crni:17'),
(49, 'Pianino', '12999.99', 11, 33, '/webshop/slike/proizvodi/6bd153cacb097cb7f91753ba27c0a50d.png', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\r\n', 1, 'Crni:18,Boja Drvo:15'),
(50, 'Harmonika', '7599.99', 16, 51, '/webshop/slike/proizvodi/e4df63ebf0317c1b4cb830fd2c83eba5.png', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\r\n', 1, 'Zelena:14'),
(51, 'Harmonika', '12599.99', 7, 51, '/webshop/slike/proizvodi/c95af33afe119fa359f13f25c25941c5.png', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\r\n', 1, 'Crvena:15,Crna:19'),
(52, 'Harmonika', '11099.99', 17, 51, '/webshop/slike/proizvodi/e0fa07fcc902fc98cf345cb3ecb2b3ed.png', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\r\n', 1, 'Crna:15,Bijela:12'),
(53, 'Klavijature', '11599.99', 11, 34, '/webshop/slike/proizvodi/80c346f734a8516ddd75cb70555539d3.png', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\r\n', 1, 'Plave:17,Crne:14'),
(54, 'Klavijature', '14599.99', 9, 34, '/webshop/slike/proizvodi/90bd33b2d51e1c04c0131e7353f0e6ae.png', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\r\n', 1, 'Crne:13'),
(55, 'Klavijature', '16599.99', 15, 34, '/webshop/slike/proizvodi/00b27b46e2a9019c84ac54248e83381c.png', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\r\n', 0, 'Crne:16'),
(56, 'Mikseta', '8799.99', 17, 39, '/webshop/slike/proizvodi/3cbed85702f387edb1bcc966d12f9728.png', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\r\n', 1, 'Sive:10'),
(57, 'Mikseta', '5299.99', 14, 39, '/webshop/slike/proizvodi/431ebc7268b49628b94fd6c73c1bd962.png', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\r\n', 0, 'Plave:15,Crne:12'),
(58, 'Mikseta', '2759.99', 7, 39, '/webshop/slike/proizvodi/8d21477ee7e6389ba0295e6bb2e4c6c4.png', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\r\n', 1, 'Boja Drvo:12,Crna:13'),
(59, 'Delay Modeler', '1059.99', 18, 38, '/webshop/slike/proizvodi/00adc1aa3dd2b34d8415b185898e5221.png', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\r\n', 1, 'Zelena:21'),
(60, 'Procesor', '2699.99', 11, 38, '/webshop/slike/proizvodi/2c5ea250eb7d1e6d0035e52923537871.png', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\r\n', 1, 'Crna:16'),
(61, 'Wah-wah', '699.99', 9, 38, '/webshop/slike/proizvodi/d33006b59aa4450e038eabf3f3a800d2.png', '', 0, 'Crna:17'),
(62, 'Chorus', '599.99', 9, 38, '/webshop/slike/proizvodi/57a3a289c017d5b9f290c70eab14a8ee.png', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\r\n', 0, 'Plavi:24'),
(63, 'Distortion Modeler', '399.99', 13, 38, '/webshop/slike/proizvodi/676f9b145db2d3a930fcf594c5f707c2.png', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\r\n', 1, 'Ljubičasti:17'),
(64, 'Metal Distortion', '639.99', 9, 38, '/webshop/slike/proizvodi/654d596378d116abacc9a1893059775e.png', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\r\n', 0, 'Siva:17'),
(65, 'Bas pojačalo', '6799.99', 8, 47, '/webshop/slike/proizvodi/17726b017650be5ca2837a8b8ebc5ed3.png', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\r\n', 1, 'Crni:17'),
(66, 'Bas pojačalo', '5899.99', 17, 47, '/webshop/slike/proizvodi/49e883110bd80c4f1bba828bc1df131b.png', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\r\n', 0, 'Crni:18'),
(67, 'Pojačalo za gitaru', '2899.99', 13, 46, '/webshop/slike/proizvodi/e502e915f1d2b057c81c852b87cfe0ec.png', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\r\n', 1, 'Narančasto:16'),
(68, 'Pojačalo za gitaru', '4699.99', 19, 46, '/webshop/slike/proizvodi/cb43183463cc62fca1caa48914231ab9.png', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\r\n', 1, 'Crno:14'),
(69, 'Pojačalo za gitaru', '12699.99', 19, 46, '/webshop/slike/proizvodi/db743a3d5c6d9ad5be4a07525141792e.png', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\r\n', 1, 'Crno:12'),
(70, 'Pojačalo za gitaru', '4259.99', 17, 46, '/webshop/slike/proizvodi/720561fc6af5ba0e116a2cd92e195409.png', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\r\n', 0, 'Crno:17'),
(71, 'Trzalica', '8.99', 8, 50, '/webshop/slike/proizvodi/dda7e5fb8e6a93d509a78047a3dba103.png', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\r\n', 0, '0.65mm:37,0.99mm:39,1.22:21,1.65mm:28'),
(72, 'Trzalica', '6.99', 14, 50, '/webshop/slike/proizvodi/e1f0279fc1c0a07b47b761aed5e0c1a4.png', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\r\n', 1, '0.49mm:35,0.85mm:39,0.99mm:61,1.35mm:21'),
(73, 'Žice za električnu gitaru', '59.99', 7, 49, '/webshop/slike/proizvodi/a8d5cd1ec37cdbf959bf6cf23608f6a4.png', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\r\n', 1, '9s:53,10s:50,11s:42,12s:32'),
(74, 'Žice za akustičnu gitaru', '65.99', 7, 49, '/webshop/slike/proizvodi/81e51762bf7d8dcfd98074f952c3368a.png', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\r\n', 0, '9s:45,10s:63,11s:28,12s:35'),
(75, 'Žice za bas', '199.99', 7, 49, '/webshop/slike/proizvodi/b4b4f3d373bb07d0d310fb1ec32b2453.png', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\r\n', 0, '45s:22,55s:35,65s:32');

-- --------------------------------------------------------

--
-- Table structure for table `transakcije`
--

CREATE TABLE `transakcije` (
  `id` int(11) NOT NULL,
  `kosarica_id` int(11) NOT NULL,
  `puno_ime` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ulica` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `grad` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `zupanija` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `posta` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `drzava` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ukupna_cijena` decimal(10,2) NOT NULL,
  `porez` decimal(10,2) NOT NULL,
  `ukupna_cijena_s_porezom` decimal(10,2) NOT NULL,
  `opis` text COLLATE utf8_unicode_ci NOT NULL,
  `vrijeme_transakcije` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `transakcije`
--

INSERT INTO `transakcije` (`id`, `kosarica_id`, `puno_ime`, `email`, `ulica`, `grad`, `zupanija`, `posta`, `drzava`, `ukupna_cijena`, `porez`, `ukupna_cijena_s_porezom`, `opis`, `vrijeme_transakcije`) VALUES
(7, 39, 'Marko Markovic', 'mark@gmail.com', 'Kranjska 23', 'Darda', 'Dardsko prigorska', '23423', 'Hrvatska', '1671.99', '528.00', '2199.99', 'Broj artikala: 1', '2020-02-14 10:20:48'),
(8, 40, 'Krcko Krcković', 'krle@gmail.com', 'Trpimirova 12', 'Split', 'Splitsko-neretvansk', '23412', 'Hrvatska', '1839.91', '581.03', '2420.94', 'Broj artikala: 6', '2020-02-14 19:29:06'),
(9, 41, 'Krcko Krcković', 'krle@gmail.com', 'Krckovićeva 99', 'Krckograd', 'Krckovičko-krckovičanska', '41341', 'Kroatija', '13695.91', '4325.03', '18020.94', 'Broj artikala: 6', '2020-02-14 20:27:01');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `kategorije`
--
ALTER TABLE `kategorije`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `korisnici`
--
ALTER TABLE `korisnici`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kosarice`
--
ALTER TABLE `kosarice`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `marke`
--
ALTER TABLE `marke`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `proizvodi`
--
ALTER TABLE `proizvodi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transakcije`
--
ALTER TABLE `transakcije`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `kategorije`
--
ALTER TABLE `kategorije`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `korisnici`
--
ALTER TABLE `korisnici`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `kosarice`
--
ALTER TABLE `kosarice`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `marke`
--
ALTER TABLE `marke`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `proizvodi`
--
ALTER TABLE `proizvodi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT for table `transakcije`
--
ALTER TABLE `transakcije`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
