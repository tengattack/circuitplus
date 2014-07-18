--
-- EI INSTALL MAKE SQL DUMP V1.0
-- DO NOT modify this file
--
-- Create: 2013-10-27 1:48
--

DROP TABLE IF EXISTS pre_circuit_feedback;
CREATE TABLE `pre_circuit_feedback` (
  feedback_id mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  user_id mediumint(8) unsigned NOT NULL,
  circuit_id mediumint(8) unsigned NOT NULL DEFAULT '0',
  reply_id mediumint(8) unsigned NOT NULL DEFAULT '0',
  time int(10) unsigned NOT NULL DEFAULT '0',
  content text NOT NULL,
  PRIMARY KEY (feedback_id),
  KEY user_id (user_id),
  KEY circuit_id (circuit_id),
  KEY reply_id (reply_id)
) TYPE=InnoDB;


DROP TABLE IF EXISTS pre_circuit_archive;
CREATE TABLE `pre_circuit_archive` (
  `archive_id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  `circuit_id` mediumint(8) UNSIGNED NOT NULL,
  `user_id` mediumint(8) UNSIGNED NOT NULL,
  `id` CHAR(36) NOT NULL,
  `name` CHAR(255) NOT NULL,
  `author` CHAR(255) NOT NULL,
  `rating` SMALLINT(8) UNSIGNED DEFAULT 0,
  `subclass_id` mediumint(8) UNSIGNED NOT NULL,
  `chassis_id` mediumint(8) UNSIGNED NOT NULL,
  `input` VARCHAR(255) NULL,
  `output` VARCHAR(255) NULL,
  `description` TEXT NULL,
-- #`application` TEXT NULL,
  `result` TEXT NULL,
  `reference` TEXT NULL,
  PRIMARY KEY (`archive_id`) 
-- #KEY 
);

DROP TABLE IF EXISTS pre_codingframe_archive;
CREATE TABLE `pre_codingframe_archive` (
  `archive_id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  `codingframe_id` mediumint(8) UNSIGNED NOT NULL,
  `user_id` mediumint(8) UNSIGNED NOT NULL,
  `state_id` mediumint(8) UNSIGNED NOT NULL,
  `input` VARCHAR(255) NULL,
  `output` VARCHAR(255) NULL,
  `sequence` TEXT NULL,
  PRIMARY KEY (`archive_id`)
);

DROP TABLE IF EXISTS pre_biobrick_archive;
CREATE TABLE `pre_biobrick_archive` (
  `archive_id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  `biobrick_id` mediumint(8) UNSIGNED NOT NULL,
  `user_id` mediumint(8) UNSIGNED NOT NULL,
  `name` CHAR(36) NOT NULL,
  `dnaproperty_id` mediumint(8) UNSIGNED NOT NULL,
-- #`expression_id` mediumint(8) UNSIGNED NOT NULL,
  `function` VARCHAR(255),
  PRIMARY KEY (`archive_id`)
);

DROP TABLE IF EXISTS pre_relationship_archive;
CREATE TABLE `pre_relationship_archive` (
  `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  `type` SMALLINT(8) UNSIGNED NOT NULL,
  `parent_id` mediumint(8) UNSIGNED NOT NULL,
  `child_id` mediumint(8) UNSIGNED NOT NULL,
  `order` mediumint(8) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`)
);