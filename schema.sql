-- Adminer 3.5.1 MySQL dump

SET NAMES utf8;
SET foreign_key_checks = 0;
SET time_zone = 'SYSTEM';
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `bookings`;
CREATE TABLE `bookings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `institution` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `country` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `address` text COLLATE utf8_czech_ci,
  `room_id` int(11) DEFAULT NULL,
  `price_type_id` int(11) DEFAULT NULL,
  `beds` int(11) NOT NULL DEFAULT '1',
  `start` datetime NOT NULL,
  `end` datetime NOT NULL,
  `email` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `fellow_email` varchar(255) COLLATE utf8_czech_ci DEFAULT NULL,
  `web_price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `token` varchar(255) COLLATE utf8_czech_ci DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `room_id` (`room_id`),
  KEY `price_type_id` (`price_type_id`),
  CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`) ON DELETE CASCADE,
  CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`price_type_id`) REFERENCES `price_types` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;


DROP TABLE IF EXISTS `locations`;
CREATE TABLE `locations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `desc` text COLLATE utf8_czech_ci NOT NULL,
  `deadline` datetime NOT NULL,
  `ord` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

INSERT INTO `locations` (`id`, `name`, `desc`, `deadline`, `ord`) VALUES
(1,	'HAMU',	'Free wifi. No breakfast.<br>\r\nAddress: Tržiště 18, Praha 1 (~5 min on foot)',	'0000-00-00 00:00:00',	NULL),
(2,	'KOMENSKÉHO',	'Student dorms. Wired Internet and breakfast possible (book below).<br>\r\nAddress:  Parléřova 6, Praha 6 (~20 mins on foot or 15 by tram)',	'0000-00-00 00:00:00',	NULL);

DROP TABLE IF EXISTS `locations_price_types`;
CREATE TABLE `locations_price_types` (
  `location_id` int(11) NOT NULL,
  `price_type_id` int(11) NOT NULL,
  KEY `location_id` (`location_id`),
  KEY `price_type_id` (`price_type_id`),
  CONSTRAINT `locations_price_types_ibfk_1` FOREIGN KEY (`location_id`) REFERENCES `locations` (`id`) ON DELETE CASCADE,
  CONSTRAINT `locations_price_types_ibfk_2` FOREIGN KEY (`price_type_id`) REFERENCES `price_types` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

INSERT INTO `locations_price_types` (`location_id`, `price_type_id`) VALUES
(1,	1),
(1,	2),
(2,	3);

DROP TABLE IF EXISTS `meals`;
CREATE TABLE `meals` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `price` decimal(5,2) NOT NULL,
  `original_price` decimal(5,2) NOT NULL,
  `ord` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

INSERT INTO `meals` (`id`, `name`, `price`, `original_price`, `ord`) VALUES
(1,	'Mon 7.9.',	210.12,	206.00,	0),
(2,	'Tue 8.9.',	210.12,	206.00,	0),
(3,	'Wed 9.9.',	210.12,	206.00,	0),
(4,	'Thu 10.9.',	210.12,	206.00,	0),
(5,	'Fri 11.9.',	210.12,	206.00,	0),
(6,	'Sat 12.9.',	210.12,	206.00,	0),
(7,	'I need vegetarian meals.',	0.00,	0.00,	0);

DROP TABLE IF EXISTS `payments`;
CREATE TABLE `payments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `booking_id` int(11) NOT NULL,
  `amountcents` int(11) NOT NULL,
  `currencycode` int(11) NOT NULL,
  `token` varchar(25) COLLATE utf8_czech_ci NOT NULL,
  `currency` varchar(15) COLLATE utf8_czech_ci NOT NULL,
  `status` varchar(10) COLLATE utf8_czech_ci DEFAULT NULL,
  `created` datetime NOT NULL,
  `validation` datetime DEFAULT NULL,
  `confirmation` datetime DEFAULT NULL,
  `rejection` datetime DEFAULT NULL,
  `error` varchar(255) COLLATE utf8_czech_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `booking_id` (`booking_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;


DROP TABLE IF EXISTS `price_types`;
CREATE TABLE `price_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `desc` text COLLATE utf8_czech_ci NOT NULL,
  `ord` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

INSERT INTO `price_types` (`id`, `name`, `desc`, `ord`) VALUES
(1,	'student or lecturer',	'',	1),
(2,	'other',	'',	2),
(3,	'faculty quest',	'pricing available only for people with ISIC card, photocopy required',	0);

DROP TABLE IF EXISTS `prices`;
CREATE TABLE `prices` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `room_id` int(11) NOT NULL,
  `price_type_id` int(11) NOT NULL,
  `price` decimal(5,2) NOT NULL,
  `original_price` decimal(5,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `room_id` (`room_id`),
  KEY `price_type_id` (`price_type_id`),
  CONSTRAINT `prices_ibfk_1` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`) ON DELETE CASCADE,
  CONSTRAINT `prices_ibfk_2` FOREIGN KEY (`price_type_id`) REFERENCES `price_types` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

INSERT INTO `prices` (`id`, `room_id`, `price_type_id`, `price`, `original_price`) VALUES
(1,	1,	1,	418.20,	410.00),
(2,	1,	2,	907.80,	890.00),
(3,	2,	1,	418.20,	410.00),
(4,	2,	2,	907.80,	890.00),
(5,	3,	3,	368.85,	361.62),
(9,	5,	3,	295.11,	289.32);

DROP TABLE IF EXISTS `queries`;
CREATE TABLE `queries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `query` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `ord` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

INSERT INTO `queries` (`id`, `query`, `ord`) VALUES
(1,	' Introductory lectures to machine translation (early morning). ',	0),
(2,	'Research talks and open source tools presentations (late morning). ',	1),
(3,	'Lab sessions that accompany the lectures (afternoon). ',	3),
(4,	'Group projects for \"developers\" (all day, with a break for the talks).',	2);

DROP TABLE IF EXISTS `rooms`;
CREATE TABLE `rooms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `location_id` int(11) NOT NULL,
  `beds` int(11) NOT NULL DEFAULT '1',
  `start` datetime NOT NULL,
  `end` datetime NOT NULL,
  `amount` int(11) NOT NULL DEFAULT '1',
  `amount_left` int(11) NOT NULL,
  `ord` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `location_id` (`location_id`),
  CONSTRAINT `rooms_ibfk_1` FOREIGN KEY (`location_id`) REFERENCES `locations` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

INSERT INTO `rooms` (`id`, `name`, `location_id`, `beds`, `start`, `end`, `amount`, `amount_left`, `ord`) VALUES
(1,	'double room',	1,	2,	'2015-09-02 00:00:00',	'2015-09-13 00:00:00',	4,	8,	0),
(2,	'triple room',	1,	3,	'2015-09-02 00:00:00',	'2015-09-13 00:00:00',	1,	3,	1),
(3,	'single room',	2,	1,	'2015-09-02 00:00:00',	'2015-09-13 00:00:00',	25,	25,	2),
(5,	'double room',	2,	2,	'2015-09-05 00:00:00',	'2015-09-13 00:00:00',	25,	50,	4);

DROP TABLE IF EXISTS `upsells`;
CREATE TABLE `upsells` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `desc` text COLLATE utf8_czech_ci,
  `location_id` int(11) NOT NULL,
  `price` decimal(5,2) NOT NULL,
  `original_price` decimal(5,2) NOT NULL,
  `ord` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `location_id` (`location_id`),
  CONSTRAINT `upsells_ibfk_1` FOREIGN KEY (`location_id`) REFERENCES `locations` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

INSERT INTO `upsells` (`id`, `name`, `desc`, `location_id`, `price`, `original_price`, `ord`) VALUES
(1,	'Breakfast',	'',	2,	82.62,	81.00,	1),
(2,	'Internet via cable',	'Bring your own ethernet (RJ45) cable,<br>\r\nThe service has to be booked with the room\r\notherwise you will get a room without a RJ45 socket.',	2,	3.79,	3.72,	0);

DROP TABLE IF EXISTS `bookings_meals`;
CREATE TABLE `bookings_meals` (
  `booking_id` int(11) NOT NULL,
  `meal_id` int(11) NOT NULL,
  KEY `booking_id` (`booking_id`),
  KEY `meal_id` (`meal_id`),
  CONSTRAINT `bookings_meals_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`),
  CONSTRAINT `bookings_meals_ibfk_2` FOREIGN KEY (`meal_id`) REFERENCES `meals` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;


DROP TABLE IF EXISTS `bookings_queries`;
CREATE TABLE `bookings_queries` (
  `booking_id` int(11) NOT NULL,
  `query_id` int(11) NOT NULL,
  KEY `booking_id` (`booking_id`),
  KEY `query_id` (`query_id`),
  CONSTRAINT `bookings_queries_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`),
  CONSTRAINT `bookings_queries_ibfk_2` FOREIGN KEY (`query_id`) REFERENCES `queries` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;


DROP TABLE IF EXISTS `bookings_upsells`;
CREATE TABLE `bookings_upsells` (
  `booking_id` int(11) NOT NULL,
  `upsell_id` int(11) NOT NULL,
  KEY `booking_id` (`booking_id`),
  KEY `upsell_id` (`upsell_id`),
  CONSTRAINT `bookings_upsells_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE,
  CONSTRAINT `bookings_upsells_ibfk_2` FOREIGN KEY (`upsell_id`) REFERENCES `upsells` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(50) COLLATE utf8_czech_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8_czech_ci DEFAULT NULL,
  `mail` varchar(255) COLLATE utf8_czech_ci DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

INSERT INTO `users` (`id`, `username`, `password`, `mail`, `created`, `modified`) VALUES
(1,	'admin',	'$2a$10$5e1m7701PFCfJCeb7iHVAOWA.GEVrJb8q1CN4TPwtj8/MVj6qeBl6',	NULL,	'2015-06-02 23:46:07',	'2015-06-02 23:46:07'),
(2,	'obo',	'$2a$10$QlIWBa0jMRJbhDnuWN/v5epHcxTzlV.Lf9247yRnmEoN5DkPqgXFu',	NULL,	'2015-06-03 22:18:18',	'2015-06-03 22:18:18');

-- 2015-06-24 22:19:06
