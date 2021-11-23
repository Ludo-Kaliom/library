-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mar. 23 nov. 2021 à 14:14
-- Version du serveur :  5.7.31
-- Version de PHP : 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `library`
--

-- --------------------------------------------------------

--
-- Structure de la table `admin`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `FullName` varchar(100) DEFAULT NULL,
  `AdminEmail` varchar(120) DEFAULT NULL,
  `UserName` varchar(100) NOT NULL,
  `Password` varchar(100) NOT NULL,
  `updationDate` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `admin`
--

INSERT INTO `admin` (`id`, `FullName`, `AdminEmail`, `UserName`, `Password`, `updationDate`) VALUES
(1, 'Admin', 'admin@admin.com', 'Admin', '21232f297a57a5a743894a0e4a801fc3', '2021-11-23 13:55:32');

-- --------------------------------------------------------

--
-- Structure de la table `tblauthors`
--

DROP TABLE IF EXISTS `tblauthors`;
CREATE TABLE IF NOT EXISTS `tblauthors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `AuthorName` varchar(159) DEFAULT NULL,
  `creationDate` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `UpdationDate` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `tblauthors`
--

INSERT INTO `tblauthors` (`id`, `AuthorName`, `creationDate`, `UpdationDate`) VALUES
(1, 'Guillaume Mussot', '2017-07-08 12:49:09', '2021-09-14 14:07:14'),
(2, 'Michel Bussi', '2017-07-08 14:30:23', '2021-07-23 08:43:21'),
(3, 'Marc Levy', '2017-07-08 14:35:08', '2021-07-23 08:43:40'),
(4, 'Françoise Bourdin', '2017-07-08 14:35:21', '2021-07-23 08:44:00'),
(5, 'Gilles Legardinier', '2017-07-08 14:35:36', '2021-07-23 08:44:25'),
(9, 'Agnès Martin', '2017-07-08 15:22:03', '2021-07-23 08:44:50'),
(10, 'Annie Ernaux', '2021-06-23 12:39:10', '2021-07-23 08:46:20'),
(11, 'Anthony Boulanger', '2021-09-06 14:49:54', '2021-09-06 14:49:54'),
(12, 'Jean Bury', '2021-09-06 14:51:21', '2021-09-06 14:51:21'),
(15, 'Kevin Kiffer', '2021-09-07 06:33:12', '2021-10-15 07:49:06'),
(16, 'Kaliom Geefker', '2021-09-14 12:27:20', '2021-09-14 12:27:20');

-- --------------------------------------------------------

--
-- Structure de la table `tblbooks`
--

DROP TABLE IF EXISTS `tblbooks`;
CREATE TABLE IF NOT EXISTS `tblbooks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `BookName` varchar(255) DEFAULT NULL,
  `CatId` int(11) DEFAULT NULL,
  `AuthorId` int(11) DEFAULT NULL,
  `ISBNNumber` int(11) DEFAULT NULL,
  `BookPrice` int(11) DEFAULT NULL,
  `RegDate` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `UpdationDate` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `Image` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=72 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `tblbooks`
--

INSERT INTO `tblbooks` (`id`, `BookName`, `CatId`, `AuthorId`, `ISBNNumber`, `BookPrice`, `RegDate`, `UpdationDate`, `Image`) VALUES
(1, 'La jeune fille et la nuit', 4, 1, 222333, 21, '2017-07-08 20:04:55', '2021-08-06 15:37:08', NULL),
(15, 'Les vertes prairies', 22, 15, 2147483647, 15, '2021-09-07 13:39:04', '2021-09-07 13:39:04', NULL),
(23, 'Les joies du PHP', 5, 11, 989898, 9889, '2021-09-08 11:53:55', '2021-11-23 14:00:18', NULL),
(27, 'Le Joug des Corbeaux', 22, 11, 454545, 10, '2021-09-14 12:24:11', '2021-09-14 12:24:11', NULL),
(28, 'La Justice du Bourreau', 22, 16, 1111111, 10, '2021-09-14 14:09:26', '2021-09-14 14:09:59', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `tblcategory`
--

DROP TABLE IF EXISTS `tblcategory`;
CREATE TABLE IF NOT EXISTS `tblcategory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `CategoryName` varchar(150) DEFAULT NULL,
  `Status` int(11) DEFAULT NULL,
  `CreationDate` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `UpdationDate` timestamp NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `tblcategory`
--

INSERT INTO `tblcategory` (`id`, `CategoryName`, `Status`, `CreationDate`, `UpdationDate`) VALUES
(4, 'Romantique', 1, '2017-07-04 18:35:25', '2021-07-15 09:37:02'),
(5, 'Technologie', 0, '2017-07-04 18:35:39', '2021-08-06 15:31:23'),
(6, 'Science', 1, '2017-07-04 18:35:55', '2021-08-06 15:31:10'),
(7, 'Management', 1, '2017-07-04 18:36:16', '2021-06-23 12:45:41'),
(8, 'Thriller', 1, '2021-07-26 09:08:35', '0000-00-00 00:00:00'),
(22, 'Fantasy', 1, '2021-09-03 07:52:19', '2021-09-06 14:33:10'),
(23, 'Dark Fantasy', 1, '2021-09-14 12:20:21', '2021-09-14 14:05:15'),
(24, 'Science-fiction', 1, '2021-09-14 14:08:15', '2021-09-14 14:08:25'),
(26, 'Post Apo', 0, '2021-09-16 07:27:25', '2021-09-16 07:27:25');

-- --------------------------------------------------------

--
-- Structure de la table `tblissuedbookdetails`
--

DROP TABLE IF EXISTS `tblissuedbookdetails`;
CREATE TABLE IF NOT EXISTS `tblissuedbookdetails` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `BookId` int(11) DEFAULT NULL,
  `ReaderID` varchar(150) DEFAULT NULL,
  `IssuesDate` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `ReturnDate` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `ReturnStatus` int(11) DEFAULT NULL,
  `fine` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `tblissuedbookdetails`
--

INSERT INTO `tblissuedbookdetails` (`id`, `BookId`, `ReaderID`, `IssuesDate`, `ReturnDate`, `ReturnStatus`, `fine`) VALUES
(1, 1, 'SID002', '2017-07-15 06:09:47', '2017-07-15 11:15:20', 1, 0),
(2, 1, 'SID002', '2017-07-15 06:12:27', '2017-07-15 11:15:23', 1, 5),
(3, 3, 'SID002', '2017-07-15 06:13:40', NULL, 0, NULL),
(4, 3, 'SID002', '2017-07-15 06:23:23', '2017-07-15 11:22:29', 1, 2),
(5, 1, 'SID009', '2017-07-15 10:59:26', NULL, 0, NULL),
(6, 3, 'SID011', '2017-07-15 18:02:55', NULL, 0, NULL),
(7, 1, 'SID011', '2021-07-16 13:59:23', NULL, 0, NULL),
(8, 1, 'SID010', '2021-07-20 08:41:34', NULL, 0, NULL),
(9, 3, 'SID012', '2021-07-20 08:44:53', NULL, 0, NULL),
(10, 1, 'SID012', '2021-07-20 08:47:07', NULL, 0, NULL),
(11, 222333, 'SID009', '2021-07-20 08:51:15', NULL, 0, NULL),
(12, 222333, 'SID009', '2021-07-20 09:53:27', NULL, 0, NULL),
(13, 222333, 'SID014', '2021-07-21 14:49:46', '2021-07-21 22:00:00', 1, NULL),
(14, 222333, 'SID017', '2021-07-29 14:14:15', '2021-08-04 22:00:00', 1, NULL),
(15, 222333, 'SID022', '2021-07-30 07:40:06', NULL, 0, NULL),
(16, 222333, 'SID001', '2021-08-06 15:20:20', NULL, 0, NULL),
(17, 222333, 'SID021', '2021-08-06 15:22:22', '2021-09-13 08:41:35', 1, NULL),
(20, 222333, 'SID024', '2021-09-10 09:38:17', NULL, 1, NULL),
(21, 3333333, 'SID024', '2021-09-10 09:38:54', NULL, 0, NULL),
(22, 222333, 'SID024', '2021-09-10 09:50:17', NULL, 0, NULL),
(23, 222333, 'SID024', '2021-09-13 06:46:45', NULL, 0, NULL),
(24, 222333, 'SID024', '2021-09-13 06:47:03', NULL, 0, NULL),
(25, 222333, 'SID024', '2021-09-13 08:06:31', '2021-09-13 08:34:28', 1, NULL),
(26, 2147483647, 'SID024', '2021-09-13 08:35:48', NULL, 0, NULL),
(27, 222334, 'SID024', '2021-09-13 12:22:32', NULL, 0, NULL),
(28, 0, 'SID024Ã Ã Ã Ã§Ã§', '2021-09-13 12:30:23', NULL, 0, NULL),
(29, 0, 'SID02445454554', '2021-09-13 12:31:19', NULL, 0, NULL),
(30, 222333, 'SID024', '2021-09-13 12:32:08', NULL, 0, NULL),
(31, 222333, 'SID024', '2021-09-13 12:32:15', NULL, 1, NULL),
(32, 5555555, 'SID024', '2021-09-14 07:01:36', NULL, 0, NULL),
(33, 3333333, 'SID021', '2021-09-14 12:02:06', '2021-09-13 22:00:00', 1, NULL),
(34, 3333333, 'SID021', '2021-09-14 12:03:00', '2021-09-13 22:00:00', 1, NULL),
(35, 1111111, 'SID024', '2021-09-14 14:10:48', '2021-09-13 22:00:00', 1, NULL),
(36, 1111111, 'SID025', '2021-09-16 07:31:08', NULL, 0, NULL),
(37, 989898, 'SID026', '2021-11-23 14:01:29', NULL, 0, NULL),
(38, 454545, 'SID026', '2021-11-23 14:01:56', NULL, 0, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `tblreaders`
--

DROP TABLE IF EXISTS `tblreaders`;
CREATE TABLE IF NOT EXISTS `tblreaders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ReaderId` varchar(100) DEFAULT NULL,
  `FullName` varchar(120) DEFAULT NULL,
  `EmailId` varchar(120) DEFAULT NULL,
  `MobileNumber` char(11) DEFAULT NULL,
  `Password1` varchar(120) DEFAULT NULL,
  `Status` int(11) DEFAULT NULL,
  `RegDate` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `UpdateDate` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `tblreaders`
--

INSERT INTO `tblreaders` (`id`, `ReaderId`, `FullName`, `EmailId`, `MobileNumber`, `Password1`, `Status`, `RegDate`, `UpdateDate`) VALUES
(1, 'SID017', 'Eric Perkins', 'eperkins0@cnbc.com', '06060606', '29988429c481f219b8c5ba8c071440e1', 2, '2021-07-23 10:38:53', '2021-07-26 07:01:39'),
(2, 'SID018', 'Daniel Flores', 'dflores1@so-net.ne.jp', '07070707', 'aa47f8215c6f30a0dcdb2a36a9f4168e', 2, '2021-07-23 10:40:07', '2021-09-13 13:38:14'),
(3, 'SID019', 'Gregory Hayes', 'ghayes2@w3.org', '006080808', 'e73d1f05badaf94997bb3e886144f5f9', 2, '2021-07-23 10:41:18', '2021-09-14 14:11:15'),
(4, 'SID020', 'Michelle Dunn', 'mdunnc@twitter.com', '06123456', '2345f10bb948c5665ef91f6773b3e455', 1, '2021-07-23 10:42:20', '2021-09-16 07:31:54'),
(5, 'SID021', 'Kaliom test', 'test@gmail.com', '06060606', '2e3817293fc275dbee74bd71ce6eb056', 2, '2021-07-28 12:12:04', '2021-09-14 13:58:03'),
(6, 'SID024', 'Kaliom', 'Kaliom.Geefker@gmail.com', '06060606', 'c20ad4d76fe97759aa27a0c99bff6710', 0, '2021-08-26 07:44:37', '2021-09-14 14:11:10'),
(7, 'SID025', 'Kaliom test4', 'Kaliom3.Geefker@gmail.com', '0606060619', '777bbb7869ae8193249f8ff7d3e59afe', 1, '2021-09-14 14:52:39', '2021-09-16 07:35:07'),
(9, 'SID026', 'User', 'User@user.com', '0606060606', '8f9bfe9d1345237cb3b2b205864da075', 1, '2021-11-23 13:49:46', NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
