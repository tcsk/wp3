SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;


DROP TABLE IF EXISTS `auth_assignment`;
CREATE TABLE IF NOT EXISTS `auth_assignment` (
  `item_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`item_name`,`user_id`),
  KEY `afp2_idx-auth_assignment-user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `auth_assignment` (`item_name`, `user_id`, `created_at`) VALUES
('admin', '1', 1557776957),
('admin', '11', 1558150589),
('admin', '6', 1557832970),
('admin', '7', 1557841607),
('teacher', '3', 1558185801),
('teacher', '9', 1558029847);

DROP TABLE IF EXISTS `auth_item`;
CREATE TABLE IF NOT EXISTS `auth_item` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `type` smallint(6) NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `rule_name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `data` blob,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`),
  KEY `rule_name` (`rule_name`),
  KEY `afp2_idx-auth_item-type` (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`) VALUES
('addCardPair', 2, 'Create new card pair', NULL, NULL, 1557776957, 1557776957),
('addUser', 2, 'Create new user', NULL, NULL, 1557776957, 1557776957),
('admin', 1, NULL, NULL, NULL, 1557776957, 1557776957),
('removeCardPair', 2, 'Remove card pair', NULL, NULL, 1557776957, 1557776957),
('removeUser', 2, 'Remove user', NULL, NULL, 1557776957, 1557776957),
('teacher', 1, NULL, NULL, NULL, 1557776957, 1557776957),
('updateCardPair', 2, 'Update card pair', NULL, NULL, 1557776957, 1557776957),
('updateUser', 2, 'Update user', NULL, NULL, 1557776957, 1557776957);

DROP TABLE IF EXISTS `auth_item_child`;
CREATE TABLE IF NOT EXISTS `auth_item_child` (
  `parent` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `child` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `auth_item_child` (`parent`, `child`) VALUES
('admin', 'addUser'),
('admin', 'removeUser'),
('admin', 'teacher'),
('admin', 'updateUser'),
('teacher', 'addCardPair'),
('teacher', 'removeCardPair'),
('teacher', 'updateCardPair');

DROP TABLE IF EXISTS `auth_rule`;
CREATE TABLE IF NOT EXISTS `auth_rule` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `data` blob,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS `course`;
CREATE TABLE IF NOT EXISTS `course` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `team` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `subject_id` int(11) UNSIGNED NOT NULL,
  `instructor_id` int(11) UNSIGNED NOT NULL,
  `semester_id` int(4) UNSIGNED NOT NULL,
  `created_by` int(11) UNSIGNED NOT NULL,
  `updated_by` int(11) UNSIGNED DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_course_user1_idx` (`created_by`),
  KEY `fk_course_user2_idx` (`updated_by`),
  KEY `fk_course_subject1_idx` (`subject_id`),
  KEY `fk_course_semester1_idx` (`semester_id`),
  KEY `fk_course_instructor1_idx` (`instructor_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS `file`;
CREATE TABLE IF NOT EXISTS `file` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `filename` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `course_id` int(11) UNSIGNED NOT NULL,
  `uploaded_at` datetime NOT NULL,
  `created_by` int(11) UNSIGNED NOT NULL,
  `updated_by` int(11) UNSIGNED DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_file_course1_idx` (`course_id`),
  KEY `fk_file_user1_idx` (`created_by`),
  KEY `fk_file_user2_idx` (`updated_by`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS `instructor`;
CREATE TABLE IF NOT EXISTS `instructor` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(99) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(99) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_by` int(11) UNSIGNED NOT NULL,
  `updated_by` int(11) UNSIGNED DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_instructor_user1_idx` (`created_by`),
  KEY `fk_instructor_user2_idx` (`updated_by`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS `migration`;
CREATE TABLE IF NOT EXISTS `migration` (
  `version` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS `scedule`;
CREATE TABLE IF NOT EXISTS `scedule` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `deadline` datetime NOT NULL,
  `course_id` int(10) UNSIGNED NOT NULL,
  `created_by` int(11) UNSIGNED NOT NULL,
  `updated_by` int(11) UNSIGNED DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_scedule_user1_idx` (`created_by`),
  KEY `fk_scedule_user2_idx` (`updated_by`),
  KEY `fk_scedule_course1_idx` (`course_id`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS `semester`;
CREATE TABLE IF NOT EXISTS `semester` (
  `id` int(4) UNSIGNED NOT NULL AUTO_INCREMENT,
  `semester` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `created_by` int(11) UNSIGNED NOT NULL,
  `updated_by` int(11) UNSIGNED DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_semester_user1_idx` (`created_by`),
  KEY `fk_semester_user2_idx` (`updated_by`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS `subject`;
CREATE TABLE IF NOT EXISTS `subject` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `code` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `created_by` int(11) UNSIGNED NOT NULL,
  `updated_by` int(11) UNSIGNED DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_subject_user_idx` (`created_by`),
  KEY `fk_subject_user1_idx` (`updated_by`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(99) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `user` (`id`, `username`, `email`, `password`) VALUES
(1, 'admin', 'admin@example.com', '$2y$10$rW5kEq82zwHM6mztQs5cY.DZagjwJlrT69tRObkj31e0IaRzCH.em'),
(2, 'diák', 'diak@example.com', '$2y$10$XCkendsObg5.fiQ86QyLH.hY/q6Jusr3jkzZHdw8Zw7YPyfNMMq9e'),
(3, 'szerkesztő', 'szerkeszto@example.com', '$2y$10$3FjmQBWT3A3L918Gq.PR2uOC3jk36ZZ0l.LX3Sf1XH4t5YJf2c/Ou');


ALTER TABLE `auth_assignment`
  ADD CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `auth_item`
  ADD CONSTRAINT `auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE;

ALTER TABLE `auth_item_child`
  ADD CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `course`
  ADD CONSTRAINT `fk_course_instructor1` FOREIGN KEY (`instructor_id`) REFERENCES `instructor` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_course_semester1` FOREIGN KEY (`semester_id`) REFERENCES `semester` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_course_subject1` FOREIGN KEY (`subject_id`) REFERENCES `subject` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_course_user1` FOREIGN KEY (`created_by`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_course_user2` FOREIGN KEY (`updated_by`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE `file`
  ADD CONSTRAINT `fk_file_course1` FOREIGN KEY (`course_id`) REFERENCES `course` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_file_user1` FOREIGN KEY (`created_by`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_file_user2` FOREIGN KEY (`updated_by`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE `instructor`
  ADD CONSTRAINT `fk_instructor_user1` FOREIGN KEY (`created_by`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_instructor_user2` FOREIGN KEY (`updated_by`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE `scedule`
  ADD CONSTRAINT `fk_scedule_course1` FOREIGN KEY (`course_id`) REFERENCES `course` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_scedule_user1` FOREIGN KEY (`created_by`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_scedule_user2` FOREIGN KEY (`updated_by`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE `semester`
  ADD CONSTRAINT `fk_semester_user1` FOREIGN KEY (`created_by`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_semester_user2` FOREIGN KEY (`updated_by`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE `subject`
  ADD CONSTRAINT `fk_subject_user` FOREIGN KEY (`created_by`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_subject_user1` FOREIGN KEY (`updated_by`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
