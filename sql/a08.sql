-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3308
-- Généré le :  jeu. 27 août 2020 à 14:42
-- Version du serveur :  5.7.28
-- Version de PHP :  7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `a08`
--

-- --------------------------------------------------------

--
-- Structure de la table `actors`
--

DROP TABLE IF EXISTS `actors`;
CREATE TABLE IF NOT EXISTS `actors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `last_name` varchar(80) NOT NULL,
  `first_name` varchar(80) NOT NULL,
  `dob` date NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `last_name` (`last_name`,`first_name`,`dob`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `actors`
--

INSERT INTO `actors` (`id`, `last_name`, `first_name`, `dob`, `image`, `created_at`, `modified_at`) VALUES
(1, 'Downey Jr', 'Robert', '1965-04-04', 'robertdowneyjr.jpg', '2020-08-24 11:55:07', NULL),
(2, 'Paltrow', 'Gwyneth', '1972-09-27', 'gwynethpaltrow.jpg', '2020-08-24 12:40:14', NULL),
(5, 'Jackson', 'Samuel', '1948-12-21', 'samueljackson.jpg', '2020-08-24 12:55:39', NULL),
(6, 'Cheadle', 'Don', '1964-11-29', 'doncheadle.jpg', '2020-08-24 12:58:18', NULL),
(7, 'Johansson', 'Scarlett', '1984-11-22', 'scarlettjohansson.jpg', '2020-08-24 13:40:27', NULL),
(8, 'Norton', 'Edward', '1969-08-18', 'edwardnorton.jpg', '2020-08-24 13:44:00', NULL),
(9, 'Tyler', 'Liv', '1977-07-01', 'livtyler.jpg', '2020-08-24 13:46:03', NULL),
(10, 'Roth', 'Tim', '1961-05-14', 'timroth.jpg', '2020-08-24 13:46:53', NULL),
(11, 'Evans', 'Chris', '1981-06-13', 'chrisevans.jpg', '2020-08-24 13:48:24', NULL),
(12, 'Atwell', 'Hayley', '1982-04-05', 'hayleyatwell.jpg', '2020-08-24 13:49:39', NULL),
(13, 'Stan', 'Sebastian', '1982-08-13', 'sebastianstan.jpg', '2020-08-24 13:51:37', NULL),
(14, 'Pratt', 'Chris', '1979-06-21', 'chrispratt.jpg', '2020-08-24 13:55:50', NULL),
(15, 'Saldana', 'Zoe', '1978-06-19', 'zoesaldana.jpg', '2020-08-24 13:57:13', NULL),
(16, 'Bautista', 'Dave', '1969-01-18', 'davebautista.jpg', '2020-08-24 13:58:44', NULL),
(17, 'Ruffalo', 'Mark', '1967-11-22', 'markruffalo.jpg', '2020-08-24 14:01:16', NULL),
(18, 'Hemsworth', 'Chris', '1983-08-11', 'chrishemsworth.jpg', '2020-08-24 14:02:17', NULL),
(19, 'Renner', 'Jeremy', '1971-01-07', 'jeremyrenner.jpg', '2020-08-24 14:04:10', NULL),
(20, 'Portman', 'Natalie', '1981-06-09', 'natalieportman.jpg', '2020-08-24 14:06:50', NULL),
(21, 'Hopkins', 'Anthony', '1937-12-31', 'anthonyhopkins.jpg', '2020-08-24 14:13:50', NULL),
(22, 'Hiddleston', 'Tom', '1981-02-09', 'tomhiddleston.jpg', '2020-08-24 14:15:12', NULL),
(23, 'Blanchett', 'Cate', '1969-05-14', 'cateblanchett.jpg', '2020-08-24 14:22:57', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `actors_movies`
--

DROP TABLE IF EXISTS `actors_movies`;
CREATE TABLE IF NOT EXISTS `actors_movies` (
  `id_actors` int(11) NOT NULL,
  `id_movies` int(11) NOT NULL,
  `role` varchar(80) DEFAULT NULL,
  KEY `actors_actors_movies` (`id_actors`),
  KEY `movies_actors_movies` (`id_movies`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `actors_movies`
--

INSERT INTO `actors_movies` (`id_actors`, `id_movies`, `role`) VALUES
(1, 1, 'Tony Stark/Iron Man'),
(1, 2, 'Tony Stark/Iron Man'),
(1, 3, 'Tony Stark/Iron Man'),
(1, 6, 'Tony Stark/Iron Man'),
(1, 7, 'Tony Stark/Iron Man'),
(1, 8, 'Tony Stark/Iron Man'),
(1, 9, 'Tony Stark/Iron Man'),
(1, 10, 'Tony Stark/Iron Man'),
(1, 13, 'Tony Stark'),
(2, 1, 'Pepper Potts'),
(2, 2, 'Pepper Potts'),
(2, 3, 'Pepper Potts'),
(2, 6, 'Pepper Potts'),
(2, 7, 'Pepper Potts'),
(2, 8, 'Pepper Potts'),
(5, 1, 'Nick Fury'),
(5, 2, 'Nick Fury'),
(5, 6, 'Nick Fury'),
(5, 7, 'Nick Fury'),
(5, 9, 'Nick Fury'),
(5, 11, 'Nick Fury'),
(5, 12, 'Nick Fury'),
(5, 15, 'Nick Fury'),
(6, 3, 'James Rhodes'),
(6, 8, 'James Rhodes/War Machine'),
(6, 7, 'James Rhodes/War Machine'),
(6, 9, 'James Rhodes/Iron Patriot'),
(6, 10, 'Colonel James Rhodes/War Machine'),
(7, 2, 'Natasha Romanoff/La Veuve Noire'),
(7, 6, 'Natasha Romanoff/La Veuve Noire'),
(7, 7, 'Natasha Romanoff/La Veuve Noire'),
(7, 8, 'Natasha Romanoff/La Veuve Noire'),
(7, 9, 'Natasha Romanoff/La Veuve Noire'),
(7, 10, 'Natasha Romanoff/La Veuve Noire'),
(7, 12, 'Natasha Romanoff/La Veuve Noire'),
(8, 13, 'Bruce Banner/Hulk'),
(9, 13, 'Betty Ross'),
(10, 13, 'Emil Blonsky/L\'Abomination'),
(11, 10, 'Steve Rogers/Captain America'),
(11, 11, 'Steve Rogers/Captain America'),
(11, 12, 'Steve Rogers/Captain America'),
(11, 6, 'Steve Rogers/Captain America'),
(11, 7, 'Steve Rogers/Captain America'),
(11, 8, 'Steve Rogers/Captain America'),
(11, 9, 'Steve Rogers/Captain America'),
(11, 17, 'Captain America'),
(12, 7, 'Peggy Carter'),
(12, 9, 'Peggy Carter'),
(12, 11, 'Peggy Carter'),
(12, 12, 'Peggy Carter'),
(13, 7, 'Bucky Barnes/Le Soldat de l\'Hiver'),
(13, 8, 'Bucky Barnes/Le Soldat de l\'Hiver'),
(13, 10, 'Bucky Barnes/Le Soldat de l\'Hiver'),
(13, 12, 'Bucky Barnes/Le Soldat de l\'Hiver'),
(14, 4, 'Peter Quill/Star-Lord'),
(14, 5, 'Peter Quill/Star-Lord'),
(14, 7, 'Peter Quill/Star-Lord'),
(14, 8, 'Peter Quill/Star-Lord'),
(15, 4, 'Gamora'),
(15, 5, 'Gamora'),
(15, 7, 'Gamora'),
(15, 8, 'Gamora'),
(16, 4, 'Drax le Destructeur'),
(16, 5, 'Drax le Destructeur'),
(16, 7, 'Drax'),
(16, 8, 'Drax'),
(17, 3, 'Bruce Banner/Hulk'),
(17, 6, 'Bruce Banner/Hulk'),
(17, 7, 'Bruce Banner/Hulk'),
(17, 8, 'Bruce Banner/Hulk'),
(17, 9, 'Bruce Banner/Hulk'),
(17, 16, 'Bruce Banner/Hulk'),
(18, 6, 'Thor'),
(18, 7, 'Thor'),
(18, 8, 'Thor'),
(18, 9, 'Thor'),
(18, 15, 'Thor'),
(18, 16, 'Thor'),
(18, 17, 'Thor'),
(19, 6, 'Clint Barton/Œil-de-Faucon'),
(19, 7, 'Clint Barton/Œil-de-Faucon'),
(19, 9, 'Clint Barton/Œil-de-Faucon'),
(19, 10, 'Clint Barton/Œil-de-Faucon'),
(19, 15, 'Clint Barton/Œil-de-Faucon'),
(20, 7, 'Jane Foster'),
(20, 15, 'Jane Foster'),
(20, 17, 'Jane Foster'),
(21, 15, 'Odin'),
(21, 16, 'Odin'),
(21, 17, 'Odin'),
(22, 6, 'Loki'),
(22, 7, 'Loki'),
(22, 8, 'Loki'),
(22, 15, 'Loki'),
(22, 16, 'Loki'),
(22, 17, 'Loki'),
(23, 16, 'Hela');

-- --------------------------------------------------------

--
-- Structure de la table `movies`
--

DROP TABLE IF EXISTS `movies`;
CREATE TABLE IF NOT EXISTS `movies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(80) NOT NULL,
  `release_date` date NOT NULL,
  `duration` time DEFAULT NULL,
  `director` varchar(80) DEFAULT NULL,
  `id_phase` tinyint(3) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`,`release_date`),
  KEY `phases_movies` (`id_phase`),
  KEY `movies_images` (`image`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `movies`
--

INSERT INTO `movies` (`id`, `name`, `release_date`, `duration`, `director`, `id_phase`, `image`, `created_at`, `modified_at`) VALUES
(1, 'Iron Man', '2008-04-30', '02:06:00', 'Jon Favreau', 1, 'ironman1.jpg', '2020-07-31 19:36:43', NULL),
(2, 'Iron Man 2', '2010-04-28', '02:04:00', 'Jon Favreau', 1, 'ironman2.jpg', '2020-07-31 19:36:43', NULL),
(3, 'Iron Man 3', '2013-04-19', '02:11:00', 'Shane Black', 2, 'ironman3.jpg', '2020-07-31 19:36:43', NULL),
(4, 'Guardians Of The Galaxy', '2014-08-13', '02:01:00', 'James Gunn', 2, 'gardiens1.jpg', '2020-07-31 19:36:43', NULL),
(5, 'Guardians Of The Galaxy Vol2', '2017-04-26', '02:16:00', 'James Gunn', 3, 'gardiens2.jpg', '2020-07-31 19:36:43', NULL),
(6, 'Avengers', '2012-04-20', '02:23:00', 'Joss Whedon', 1, 'avengers.jpg', '2020-07-31 19:36:43', NULL),
(7, 'Avengers: Endgame', '2019-04-24', '03:01:00', 'Joe Russo, Anthony Russo', 3, 'avengersEG.jpg', '2020-07-31 19:36:43', NULL),
(8, 'Avengers: Infinity War', '2018-04-25', '02:36:00', 'Joe Russo, Anthony Russo', 3, 'avengersIW.jpg', '2020-07-31 19:36:43', NULL),
(9, 'Avengers: L\'Ere d\'Ultron', '2015-04-22', '02:21:00', 'Joss Whedon', 2, 'avengersEU.jpg', '2020-07-31 19:36:43', NULL),
(10, 'Captain America : Civil War', '2016-04-27', '02:27:00', 'Joe Russo, Anthony Russo', 3, 'captainCW.jpg', '2020-07-31 19:36:43', NULL),
(11, 'Captain Amarica : First Avenger', '2011-08-17', '02:04:00', 'Joe Johnston', 1, 'captainFA.jpg', '2020-07-31 19:36:43', NULL),
(12, 'Captain America : Winter Soldier', '2014-03-21', '02:16:00', 'Joe Russo, Anthony Russo', 2, 'captainWS.jpg', '2020-08-04 13:59:03', NULL),
(13, 'The Incredible Hulk', '2008-07-23', '01:52:00', 'Louis Leterrier', 1, 'incredible-hulk.jpg', '2020-08-18 13:34:34', NULL),
(15, 'Thor', '2011-04-27', '01:55:00', 'Kenneth Branagh', 1, 'thor.jpg', '2020-08-24 14:39:34', NULL),
(16, 'Thor : Ragnarok', '2017-10-19', '02:11:00', 'Taika Waititi', 3, 'thorragnarok.jpg', '2020-08-24 14:42:32', NULL),
(17, 'Thor : The Dark World', '2013-10-30', '01:52:00', 'Alan Taylor', 2, 'thortenebres.jpg', '2020-08-24 14:50:49', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `phases`
--

DROP TABLE IF EXISTS `phases`;
CREATE TABLE IF NOT EXISTS `phases` (
  `id` tinyint(3) NOT NULL AUTO_INCREMENT,
  `phase` char(3) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `phase` (`phase`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `phases`
--

INSERT INTO `phases` (`id`, `phase`) VALUES
(1, 'I'),
(2, 'II'),
(3, 'III');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `actors_movies`
--
ALTER TABLE `actors_movies`
  ADD CONSTRAINT `actors_actors_movies` FOREIGN KEY (`id_actors`) REFERENCES `actors` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `movies_actors_movies` FOREIGN KEY (`id_movies`) REFERENCES `movies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `movies`
--
ALTER TABLE `movies`
  ADD CONSTRAINT `phases_movies` FOREIGN KEY (`id_phase`) REFERENCES `phases` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
