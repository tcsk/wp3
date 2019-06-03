SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;


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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `scedule` (`id`, `title`, `description`, `deadline`, `course_id`, `created_by`, `updated_by`) VALUES
(1, 'Konzultáció', 'Lorem…', '2019-02-23 00:00:00', 3, 1, 1),
(2, 'Beadandó feladat', 'Lorem ipsum delor sit…', '2019-04-28 00:00:00', 3, 1, 1),
(3, '1. ZH', 'Lorem ipsum delor…', '2019-05-10 00:00:00', 3, 1, 1),
(4, '2. ZH', 'Lorem ipsum…', '2019-05-10 00:00:00', 3, 1, 1);


ALTER TABLE `scedule`
  ADD CONSTRAINT `fk_scedule_course1` FOREIGN KEY (`course_id`) REFERENCES `course` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_scedule_user1` FOREIGN KEY (`created_by`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_scedule_user2` FOREIGN KEY (`updated_by`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
