-- Adminer 4.2.5 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `cron_job`;
CREATE TABLE `cron_job` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL DEFAULT '',
  `is_last` tinyint(4) NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `followers_free`;
CREATE TABLE `followers_free` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `seeder_username` varchar(255) NOT NULL,
  `user_id` varchar(255) NOT NULL DEFAULT '',
  `screen_name` varchar(255) NOT NULL DEFAULT '',
  `name` varchar(255) NOT NULL DEFAULT '',
  `lang` varchar(255) NOT NULL DEFAULT '',
  `location` varchar(255) NOT NULL DEFAULT '',
  `geo_enabled` tinyint(4) NOT NULL,
  `time_zone` varchar(255) NOT NULL DEFAULT '',
  `utc_offset` varchar(255) NOT NULL DEFAULT '',
  `created_at` datetime NOT NULL,
  `followers_count` int(11) NOT NULL,
  `friends_count` int(11) NOT NULL,
  `favourites_count` int(11) NOT NULL,
  `statuses_count` int(11) NOT NULL,
  `retweet_count` int(11) NOT NULL,
  `default_profile_image` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `followers_used`;
CREATE TABLE `followers_used` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL DEFAULT '',
  `user_id` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- 2017-01-25 21:20:02
