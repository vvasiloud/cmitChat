-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.5.34 - MySQL Community Server (GPL)
-- Server OS:                    Win32
-- HeidiSQL Version:             8.1.0.4545
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping database structure for chatdb
CREATE DATABASE IF NOT EXISTS `chatdb` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_bin */;
USE `chatdb`;


-- Dumping structure for table chatdb.private_chat
CREATE TABLE IF NOT EXISTS `private_chat` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `chat_text` mediumtext COLLATE utf8_bin NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `hasReadListener` enum('Y','N') COLLATE utf8_bin NOT NULL DEFAULT 'N',
  `userid_speaker` int(10) unsigned NOT NULL,
  `userid_listener` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_private_chat_users_2` (`userid_listener`),
  KEY `FK_private_chat_users` (`userid_speaker`),
  CONSTRAINT `FK_private_chat_users` FOREIGN KEY (`userid_speaker`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- Data exporting was unselected.


-- Dumping structure for table chatdb.public_chat
CREATE TABLE IF NOT EXISTS `public_chat` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `chat_text` mediumtext NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `user_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_public_chat_users` (`user_id`),
  CONSTRAINT `FK_public_chat_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table chatdb.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(16) NOT NULL,
  `password` varchar(200) NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `gender` enum('male','female') NOT NULL,
  `type` enum('registered','guest','admin') NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `lastactive` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
