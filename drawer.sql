-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 17, 2017 at 04:51 PM
-- Server version: 5.5.54-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `orm`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `author_id` tinyint(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `content` varchar(300) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `author_id_2` (`author_id`),
  KEY `post_id` (`post_id`),
  KEY `author_id_3` (`author_id`),
  KEY `author_id_4` (`author_id`),
  KEY `author_id_5` (`author_id`),
  KEY `author_id_6` (`author_id`),
  KEY `author_id` (`author_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `author_id`, `post_id`, `created_at`, `updated_at`, `content`) VALUES
(1, 9, 4, '2017-05-16 14:05:34', NULL, 'Un commentaire à propos de stache'),
(2, 10, 14, '2017-05-16 16:31:07', NULL, 'Sup'' guyz ??!'),
(4, 10, 4, '2017-05-16 17:23:18', NULL, 'Super !'),
(5, 10, 8, '2017-05-17 12:18:03', NULL, 'smurf smurf');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE IF NOT EXISTS `posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `author_id` tinyint(4) NOT NULL,
  `drawing_src` char(24) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(70) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `nb_comments` int(11) NOT NULL DEFAULT '0',
  `rating_avg` tinyint(4) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `author_id` (`author_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=15 ;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `author_id`, `drawing_src`, `title`, `description`, `nb_comments`, `rating_avg`, `created_at`, `updated_at`) VALUES
(1, 3, 'xQPtTPcJqoIIa5nbWFKh.png', 'One', 'One above one for eternity', 0, NULL, '2017-05-04 16:58:07', NULL),
(2, 4, 'ToO0ClREGB9Lag5mR3JB.png', 'Aiku', 'verdure, \r\nprairie, \r\nhirondelle, ''BANG !!''', 0, NULL, '0000-00-00 00:00:00', NULL),
(3, 4, 'ubdklLfM2cMaTJi5wSkx.png', 'this is art', 'very much beauteefull ! ', 0, NULL, '2017-05-12 15:10:54', NULL),
(4, 4, '5RsUOnfNGvpaGCv2oKOq.png', 'Bluestache', 'want some ?', 2, NULL, '2017-05-12 16:20:14', NULL),
(5, 4, 'HXJgrqDpO5FG2G3Ii3pC.png', 'Tu m''reconnais ?', 'L''histoire d''un écrivain qui perd la boule...', 0, NULL, '2017-05-12 16:24:00', NULL),
(6, 9, '7ciivH4HsG10SQDKcbO2.png', 'sur la paille', 'chic', 0, NULL, '2017-05-12 16:49:03', NULL),
(8, 9, 'q96cjA4uj7M4UwDkef1B.png', 'Big Smurf', 'Who''s your daddy ??', 1, NULL, '2017-05-15 11:27:28', '2017-05-17 12:18:03'),
(14, 9, 'w6JL4x0KUQobwbTGdQax.png', 'Cup', '.... on grass with fire in it', 1, NULL, '2017-05-15 16:07:03', '2017-05-17 15:14:29');

-- --------------------------------------------------------

--
-- Table structure for table `ratings`
--

CREATE TABLE IF NOT EXISTS `ratings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `post_id` int(11) NOT NULL,
  `author_id` tinyint(4) NOT NULL,
  `rating` int(1) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `post_id` (`post_id`,`author_id`),
  KEY `author_id` (`author_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `dob` date NOT NULL,
  `password` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=11 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `dob`, `password`, `created_at`, `updated_at`) VALUES
(1, 'Toto', 'monkeyjojo@bananamail.com', '1987-02-19', 'ilovechipmunk', '2017-05-04 10:58:00', '2017-05-04 11:41:26'),
(2, 'bobby', 'sixxkiller@youpi.fr', '1969-03-18', 'iloverebels', '2017-05-04 11:39:10', NULL),
(3, 'JohnDoe', 'MrNobody@domaine.com', '1988-09-21', '$2y$10$MfJ.rWEg7e7axfMSZCzg1OjfFtZiPZQz4N5HKFclohQN1qBqovv3.', '2017-05-04 13:08:12', NULL),
(4, 'BobBelcher', 'jm@domaine.com', '1970-01-11', '$2y$10$ncXiVh0qH4zrGR3IgJeIU.djbnuOfCOa7BDjeV9.0p6Ofa.0P6hRO', '2017-05-04 14:21:49', '2017-05-04 16:17:51'),
(5, 'JeanMouloud', 'jm@domaine.com', '1970-01-11', '$2y$10$obp9lN8GG86.AOi/EONBG..vB.fMkp/m4WmFIk7FQzUIU07WyZYIu', '2017-05-04 14:23:31', NULL),
(6, 'Micchella Jell-o', 'mikela@jelly.com', '1975-05-21', '$2y$10$eoVewDqKEYSUNra4ICrHbOdaREN25On.DWsttTjliBm1oGQR2uQqu', '2017-05-04 14:40:42', NULL),
(7, 'Jokari', 'jok@ari.com', '2013-04-05', '$2y$10$cNS7UojKtJTUP1iaG6U8VuA/R60Eg/0lot3JCIz/My04kBNNlu4US', '0000-00-00 00:00:00', NULL),
(8, 'LeGarsSimple', 'simplemind@krtrkmail.nt', '1986-05-06', '$2y$10$OlSLpYLylpYFK.8jD5zpcuHOCeuWSTkaRxAoIuci8bahkhomKZ8HC', '0000-00-00 00:00:00', NULL),
(9, 'GuyGroggy', 'guyg@gmail.com', '1964-03-05', '$2y$10$G.Oxh9aXB5ZhWOrgM/fx7.MH/PoRLhCJDQAEKjmomQsjIK87ZwkP2', '0000-00-00 00:00:00', '2017-05-17 15:05:21'),
(10, 'Erika', 'eri@k.com', '1997-07-05', '$2y$10$VwAj06nz/r/QkdLSyaYZfu.KoWsSGlAvPwM5T1AFmqlFYXPEIthoG', '2017-05-16 16:30:34', NULL);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comments_ibfk_3` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `ratings`
--
ALTER TABLE `ratings`
  ADD CONSTRAINT `ratings_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ratings_ibfk_2` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
