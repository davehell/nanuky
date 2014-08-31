-- Adminer 4.0.3 MySQL dump

SET NAMES utf8;
SET foreign_key_checks = 0;
SET time_zone = '+02:00';
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `author`;
CREATE TABLE `author` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_czech_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

INSERT INTO `author` (`id`, `name`) VALUES
(1,	'Robert Louis Stevenson'),
(2,	'John Ronald Reuel Tolkien');

DROP TABLE IF EXISTS `book`;
CREATE TABLE `book` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `id_author` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_author` (`id_author`),
  CONSTRAINT `book_ibfk_2` FOREIGN KEY (`id_author`) REFERENCES `author` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

INSERT INTO `book` (`id`, `title`, `id_author`) VALUES
(1,	'Ostrov pokladů',	1),
(2,	'Podivný případ Dr. Jekylla a pana Hyda',	1),
(3,	'Černý šíp',	1),
(4,	'Rytíř z Ballantrae',	1),
(5,	'Hobit aneb Cesta tam a zase zpátky',	2),
(7,	'Pán prstenů',	2),
(8,	'Silmarillion',	2);

-- 2014-05-19 03:16:10
