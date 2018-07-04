SET foreign_key_checks = 0;

CREATE TABLE `teams` (
	`id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
	`code` varchar(250) NOT NULL,
	`name` varchar(250) NOT NULL,
	PRIMARY KEY (`id`),
	UNIQUE KEY `code` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `teams` (`id`, `code`, `name`) VALUES
(1,	'ARG',	'Argentina'),
(2,	'AUS',	'Australia'),
(3,	'BEL',	'Belgium'),
(4,	'BRA',	'Brazil'),
(5,	'CHE',	'Switzerland'),
(6,	'COL',	'Colombia'),
(7,	'CRI',	'Costa Rica'),
(8,	'DEU',	'Germany'),
(9,	'DNK',	'Denmark'),
(10,	'EGY',	'Egypt'),
(11,	'ENG',	'England'),
(12,	'ESP',	'Spain'),
(13,	'FRA',	'France'),
(14,	'HRV',	'Croatia'),
(15,	'IRN',	'Iran'),
(16,	'ISL',	'Iceland'),
(17,	'JPN',	'Japan'),
(18,	'KOR',	'South Korea'),
(19,	'MAR',	'Morocco'),
(20,	'MEX',	'Mexico'),
(21,	'NGA',	'Nigeria'),
(22,	'PAN',	'Panama'),
(23,	'PER',	'Peru'),
(24,	'POL',	'Poland'),
(25,	'PRT',	'Portugal'),
(26,	'RUS',	'Russia'),
(27,	'SAU',	'Saudi Arabia'),
(28,	'SEN',	'Senegal'),
(29,	'SRB',	'Serbia'),
(30,	'SWE',	'Sweden'),
(31,	'TUN',	'Tunisia'),
(32,	'URY',	'Uruguay');

CREATE TABLE `groups` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`name` varchar(250) NOT NULL,
	PRIMARY KEY (`id`),
	UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `groups` (`id`, `name`) VALUES
(1,	'A'),
(2,	'B'),
(3,	'C'),
(4,	'D'),
(5,	'E'),
(6,	'F'),
(7,	'G'),
(8,	'H');

CREATE TABLE `teams_groups` (
	`id_team` bigint(20) unsigned NOT NULL,
	`id_group` int(11) unsigned NOT NULL,
	`order` int(11) unsigned NOT NULL,
	KEY `id_team` (`id_team`),
	KEY `id_group` (`id_group`),
	UNIQUE KEY `id_team_group` (`id_team`, `id_group`),
	CONSTRAINT `teams_groups_ibfk_1` FOREIGN KEY (`id_team`) REFERENCES `teams` (`id`),
	CONSTRAINT `teams_groups_ibfk_2` FOREIGN KEY (`id_group`) REFERENCES `groups` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `teams_groups` (`id_team`, `id_group`, `order`) VALUES
(10,	1,	1),
(26,	1,	2),
(27,	1,	3),
(32,	1,	4),
(12,	2,	1),
(15,	2,	2),
(19,	2,	3),
(25,	2,	4),
(2,	3,	1),
(9,	3,	2),
(13,	3,	3),
(23,	3,	4),
(1,	4,	1),
(14,	4,	2),
(16,	4,	3),
(21,	4,	4),
(4,	5,	1),
(5,	5,	2),
(7,	5,	3),
(29,	5,	4),
(8,	6,	1),
(18,	6,	2),
(20,	6,	3),
(30,	6,	4),
(3,	7,	1),
(11,	7,	2),
(22,	7,	3),
(31,	7,	4),
(6,	8,	1),
(17,	8,	2),
(24,	8,	3),
(28,	8,	4);

CREATE TABLE `instances` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`name` varchar(250) NOT NULL,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `instances` (`id`, `name`) VALUES
(1,	'Group Phase'),
(2,	'Round of 16'),
(3,	'Quarter-finals'),
(4,	'Semi-finals'),
(5,	'Play-off for third place'),
(6,	'Final');

CREATE TABLE `matches_schedules` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_home_team` bigint(20) unsigned DEFAULT NULL,
  `id_away_team` bigint(20) unsigned DEFAULT NULL,
  `id_instance` int(11) unsigned NOT NULL,
  `id_group` int(11) unsigned DEFAULT NULL,
  `matchday` int(11) unsigned DEFAULT NULL,
  `goals_home` int(11) unsigned DEFAULT NULL COMMENT 'Goals of home team in the match (additional time and extra time included)',
  `goals_away` int(11) unsigned DEFAULT NULL COMMENT 'Goals of away team in the match (additional time and extra time included)',
  `goals_penalties_home` int(11) unsigned DEFAULT NULL COMMENT 'Goals of home team in the penalties round',
  `goals_penalties_away` int(11) unsigned DEFAULT NULL COMMENT 'Goals of away team in the penalties round',
  `result` enum('home', 'draw', 'away') DEFAULT NULL COMMENT 'Final result after the match is over',
  `datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_home_team` (`id_home_team`),
  KEY `id_away_team` (`id_away_team`),
  KEY `id_instance` (`id_instance`),
  KEY `id_group` (`id_group`),
  CONSTRAINT `matches_schedules_ibfk_1` FOREIGN KEY (`id_home_team`) REFERENCES `teams` (`id`),
  CONSTRAINT `matches_schedules_ibfk_2` FOREIGN KEY (`id_away_team`) REFERENCES `teams` (`id`),
  CONSTRAINT `matches_schedules_ibfk_3` FOREIGN KEY (`id_instance`) REFERENCES `instances` (`id`),
  CONSTRAINT `matches_schedules_ibfk_4` FOREIGN KEY (`id_group`) REFERENCES `groups` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `matches_schedules` (`id`, `id_home_team`, `id_away_team`, `id_instance`, `id_group`, `matchday`, `goals_home`, `goals_away`, `result`, `datetime`) VALUES
INSERT INTO `matches_schedules` (`id`, `id_home_team`, `id_away_team`, `id_instance`, `id_group`, `matchday`, `goals_home`, `goals_away`, `result`, `datetime`) VALUES
(1,	26,	27,	1,	1,	1,	0,	0,	NULL,	'2018-06-14 15:00:00'),
(2,	10,	32,	1,	1,	1,	0,	0,	NULL,	'2018-06-15 12:00:00'),
(3,	19,	15,	1,	2,	1,	0,	0,	NULL,	'2018-06-15 15:00:00'),
(4,	25,	12,	1,	2,	1,	0,	0,	NULL,	'2018-06-15 18:00:00'),
(5,	13,	2,	1,	3,	1,	0,	0,	NULL,	'2018-06-16 10:00:00'),
(6,	1,	16,	1,	4,	1,	0,	0,	NULL,	'2018-06-16 13:00:00'),
(7,	23,	9,	1,	3,	1,	0,	0,	NULL,	'2018-06-16 16:00:00'),
(8,	14,	21,	1,	4,	1,	0,	0,	NULL,	'2018-06-16 19:00:00'),
(9,	7,	29,	1,	5,	1,	0,	0,	NULL,	'2018-06-17 12:00:00'),
(10,	8,	20,	1,	6,	1,	0,	0,	NULL,	'2018-06-17 15:00:00'),
(11,	4,	5,	1,	5,	1,	0,	0,	NULL,	'2018-06-17 18:00:00'),
(12,	30,	18,	1,	6,	1,	0,	0,	NULL,	'2018-06-18 12:00:00'),
(13,	3,	22,	1,	7,	1,	0,	0,	NULL,	'2018-06-18 15:00:00'),
(14,	31,	11,	1,	7,	1,	0,	0,	NULL,	'2018-06-18 18:00:00'),
(15,	6,	17,	1,	8,	1,	0,	0,	NULL,	'2018-06-19 12:00:00'),
(16,	24,	28,	1,	8,	1,	0,	0,	NULL,	'2018-06-19 15:00:00'),
(17,	26,	10,	1,	1,	2,	0,	0,	NULL,	'2018-06-19 18:00:00'),
(18,	25,	19,	1,	2,	2,	0,	0,	NULL,	'2018-06-20 12:00:00'),
(19,	32,	27,	1,	1,	2,	0,	0,	NULL,	'2018-06-20 15:00:00'),
(20,	15,	12,	1,	2,	2,	0,	0,	NULL,	'2018-06-20 18:00:00'),
(21,	9,	2,	1,	3,	2,	0,	0,	NULL,	'2018-06-21 12:00:00'),
(22,	13,	23,	1,	3,	2,	0,	0,	NULL,	'2018-06-21 15:00:00'),
(23,	1,	14,	1,	4,	2,	0,	0,	NULL,	'2018-06-21 18:00:00'),
(24,	4,	7,	1,	5,	2,	0,	0,	NULL,	'2018-06-22 12:00:00'),
(25,	21,	16,	1,	4,	2,	0,	0,	NULL,	'2018-06-22 15:00:00'),
(26,	29,	5,	1,	5,	2,	0,	0,	NULL,	'2018-06-22 18:00:00'),
(27,	3,	31,	1,	7,	2,	0,	0,	NULL,	'2018-06-23 12:00:00'),
(28,	18,	20,	1,	6,	2,	0,	0,	NULL,	'2018-06-23 15:00:00'),
(29,	8,	30,	1,	6,	2,	0,	0,	NULL,	'2018-06-23 18:00:00'),
(30,	11,	22,	1,	7,	2,	0,	0,	NULL,	'2018-06-24 12:00:00'),
(31,	17,	28,	1,	8,	2,	0,	0,	NULL,	'2018-06-24 15:00:00'),
(32,	24,	6,	1,	8,	2,	0,	0,	NULL,	'2018-06-24 18:00:00'),
(33,	27,	10,	1,	1,	3,	0,	0,	NULL,	'2018-06-25 14:00:00'),
(34,	32,	26,	1,	1,	3,	0,	0,	NULL,	'2018-06-25 14:00:00'),
(35,	15,	25,	1,	2,	3,	0,	0,	NULL,	'2018-06-25 18:00:00'),
(36,	12,	19,	1,	2,	3,	0,	0,	NULL,	'2018-06-25 18:00:00'),
(37,	2,	23,	1,	3,	3,	0,	0,	NULL,	'2018-06-26 14:00:00'),
(38,	9,	13,	1,	3,	3,	0,	0,	NULL,	'2018-06-26 14:00:00'),
(39,	16,	14,	1,	4,	3,	0,	0,	NULL,	'2018-06-26 18:00:00'),
(40,	21,	1,	1,	4,	3,	0,	0,	NULL,	'2018-06-26 18:00:00'),
(41,	18,	8,	1,	6,	3,	0,	0,	NULL,	'2018-06-27 14:00:00'),
(42,	20,	30,	1,	6,	3,	0,	0,	NULL,	'2018-06-27 14:00:00'),
(43,	29,	4,	1,	5,	3,	0,	0,	NULL,	'2018-06-27 18:00:00'),
(44,	5,	7,	1,	5,	3,	0,	0,	NULL,	'2018-06-27 18:00:00'),
(45,	17,	24,	1,	8,	3,	0,	0,	NULL,	'2018-06-28 14:00:00'),
(46,	28,	6,	1,	8,	3,	0,	0,	NULL,	'2018-06-28 14:00:00'),
(47,	22,	31,	1,	7,	3,	0,	0,	NULL,	'2018-06-28 18:00:00'),
(48,	11,	3,	1,	7,	3,	0,	0,	NULL,	'2018-06-28 18:00:00'),
(49,	NULL,	NULL,	2,	NULL,	NULL,	0,	0,	NULL,	'2018-06-30 14:00:00'),
(50,	NULL,	NULL,	2,	NULL,	NULL,	0,	0,	NULL,	'2018-06-30 18:00:00'),
(51,	NULL,	NULL,	2,	NULL,	NULL,	0,	0,	NULL,	'2018-07-01 14:00:00'),
(52,	NULL,	NULL,	2,	NULL,	NULL,	0,	0,	NULL,	'2018-07-01 18:00:00'),
(53,	NULL,	NULL,	2,	NULL,	NULL,	0,	0,	NULL,	'2018-07-02 14:00:00'),
(54,	NULL,	NULL,	2,	NULL,	NULL,	0,	0,	NULL,	'2018-07-02 18:00:00'),
(55,	NULL,	NULL,	2,	NULL,	NULL,	0,	0,	NULL,	'2018-07-03 14:00:00'),
(56,	NULL,	NULL,	2,	NULL,	NULL,	0,	0,	NULL,	'2018-07-03 18:00:00'),
(57,	NULL,	NULL,	3,	NULL,	NULL,	0,	0,	NULL,	'2018-07-06 14:00:00'),
(58,	NULL,	NULL,	3,	NULL,	NULL,	0,	0,	NULL,	'2018-07-06 18:00:00'),
(59,	NULL,	NULL,	3,	NULL,	NULL,	0,	0,	NULL,	'2018-07-07 14:00:00'),
(60,	NULL,	NULL,	3,	NULL,	NULL,	0,	0,	NULL,	'2018-07-07 18:00:00'),
(61,	NULL,	NULL,	4,	NULL,	NULL,	0,	0,	NULL,	'2018-07-10 18:00:00'),
(62,	NULL,	NULL,	4,	NULL,	NULL,	0,	0,	NULL,	'2018-07-11 18:00:00'),
(63,	NULL,	NULL,	5,	NULL,	NULL,	0,	0,	NULL,	'2018-07-14 14:00:00'),
(64,	NULL,	NULL,	6,	NULL,	NULL,	0,	0,	NULL,	'2018-07-15 15:00:00');

CREATE TABLE matches_predictions (
	`id_match_schedule` bigint(20) unsigned NOT NULL,
	`id_user` bigint(20) unsigned NOT NULL,
	`result` enum('home', 'draw', 'away') NOT NULL,
	KEY `id_match_schedule` (`id_match_schedule`),
	KEY `id_user` (`id_user`),
	UNIQUE KEY `id_match_schedule_user` (`id_match_schedule`, `id_user`),
	CONSTRAINT `matches_predictions_ibfk_1` FOREIGN KEY (`id_match_schedule`) REFERENCES `matches_schedules` (`id`),
	CONSTRAINT `matches_predictions_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `users` (
	`id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
	`nick` varchar(250) DEFAULT NULL,
	`email` varchar(250) NOT NULL,
	`password` varchar(250) DEFAULT NULL,
	`role` int(11) DEFAULT 2,
	PRIMARY KEY (`id`),
	UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE VIEW view_matches AS
	SELECT
		MS.id,
		MS.id_home_team,
		HT.name AS name_home_team,
		HT.code AS code_home_team,
		MS.id_away_team,
		AT.name AS name_away_team,
		AT.code AS code_away_team,
		MS.id_instance,
		I.name AS name_instance,
		MS.id_group,
		G.name AS name_group,
		MS.matchday,
		MS.goals_home,
		MS.goals_away,
		MS.result,
		MS.datetime
	FROM matches_schedules MS
		LEFT JOIN teams HT ON HT.id=MS.id_home_team
		LEFT JOIN teams AT ON AT.id=MS.id_away_team
		LEFT JOIN instances I ON I.id=MS.id_instance
		LEFT JOIN groups G ON G.id=MS.id_group;

SET foreign_key_checks = 1;