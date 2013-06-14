-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jun 14, 2013 at 04:09 AM
-- Server version: 5.5.27
-- PHP Version: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `elextric`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `comment_id` int(11) NOT NULL AUTO_INCREMENT,
  `page_id` int(11) NOT NULL,
  `author` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `comment` text COLLATE utf8_unicode_ci NOT NULL,
  `comment_date` datetime NOT NULL,
  PRIMARY KEY (`comment_id`),
  KEY `page_id` (`page_id`,`comment_date`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `n_categories`
--

CREATE TABLE IF NOT EXISTS `n_categories` (
  `cat_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `cat_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `position` tinyint(4) NOT NULL,
  PRIMARY KEY (`cat_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=26 ;

--
-- Dumping data for table `n_categories`
--

INSERT INTO `n_categories` (`cat_id`, `user_id`, `cat_name`, `position`) VALUES
(1, 1, 'Tin tá»©c', 1),
(24, 1, 'TÆ° váº¥n', 4),
(5, 1, 'Giá»›i thiá»‡u', 2),
(15, 1, 'Tuyá»ƒn dá»¥ng', 3),
(25, 1, 'Äá»‘i tÃ¡c', 5);

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE IF NOT EXISTS `pages` (
  `page_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `cat_id` int(11) NOT NULL,
  `page_name` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  `position` tinyint(4) NOT NULL,
  `post_on` datetime NOT NULL,
  PRIMARY KEY (`page_id`),
  KEY `user_id` (`user_id`,`cat_id`,`position`,`post_on`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=19 ;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`page_id`, `user_id`, `cat_id`, `page_name`, `content`, `position`, `post_on`) VALUES
(15, 1, 4, 'eqwewq', 'eqwewqe', 1, '2013-06-13 10:02:59'),
(2, 1, 1, 'bai 2', 'àhgfgjhj', 2, '2013-06-10 00:00:00'),
(11, 1, 1, 'áº¥', 'sÃ¢sS', 1, '2013-06-13 09:54:05'),
(12, 1, 1, 'JHGJH', 'FJJJJ', 5, '2013-06-13 09:54:14'),
(13, 1, 1, 'sáº¥122', 'dÃ¢f', 1, '2013-06-13 09:55:08'),
(14, 1, 4, 'qÆ°qw', 'eqweqw', 1, '2013-06-13 10:02:54'),
(9, 1, 1, 'Lorem ipsum dolor sit ame', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Virtutes timidiores. Lorem ipsum dolor sit amet, consectetur adipisicing elit.', 1, '2013-06-13 08:45:04'),
(10, 1, 1, 'Lorem ipsum dolor sit amet, ', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Virtutes timidiores. Lorem ipsum dolor sit amet, consectetur adipisicing elit.', 1, '2013-06-13 09:04:37'),
(16, 1, 2, 'fsdf', 'sdfhdh', 5, '2013-06-13 10:05:10'),
(17, 1, 16, 'fdg', 'gdf', 1, '2013-06-13 14:05:45'),
(18, 1, 16, 'fdfs', 'fsf', 2, '2013-06-13 14:05:54');

-- --------------------------------------------------------

--
-- Table structure for table `p_categories`
--

CREATE TABLE IF NOT EXISTS `p_categories` (
  `cat_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `cat_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `position` tinyint(4) NOT NULL,
  `image` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`cat_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `pass` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `website` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `yahoo` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `bio` text COLLATE utf8_unicode_ci,
  `avatar` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_level` tinyint(4) NOT NULL,
  `active` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `registration_date` datetime NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `email` (`email`),
  KEY `first_name` (`first_name`,`last_name`,`pass`,`registration_date`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=45 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `first_name`, `last_name`, `email`, `pass`, `website`, `yahoo`, `bio`, `avatar`, `user_level`, `active`, `registration_date`) VALUES
(1, 'Trong', 'Nghia', 'trongnghiahp85@gmail.com', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'cvcot.edu.vn', 'trongnghiahp85', 'Tôi là Đinh Trọng Nghĩa', NULL, 2, NULL, '2013-06-10 00:00:00'),
(44, 'Tran', 'Huong', 'huongtt@vimaru.edu.vn', '7c4a8d09ca3762af61e59520943dc26494f8941b', NULL, NULL, NULL, NULL, 0, NULL, '2013-06-14 16:04:16');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
