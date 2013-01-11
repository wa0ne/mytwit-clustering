-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 11, 2013 at 06:31 PM
-- Server version: 5.5.16
-- PHP Version: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `mytwit`
--

-- --------------------------------------------------------

--
-- Table structure for table `centroid`
--

CREATE TABLE IF NOT EXISTS `centroid` (
  `id3` int(11) NOT NULL AUTO_INCREMENT,
  `x` float NOT NULL,
  `y` float NOT NULL,
  PRIMARY KEY (`id3`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- Table structure for table `follower`
--

CREATE TABLE IF NOT EXISTS `follower` (
  `id` varchar(32) NOT NULL,
  `name` varchar(100) NOT NULL,
  `screen_name` varchar(100) NOT NULL,
  `followers_count` int(11) NOT NULL,
  `friends_count` int(11) NOT NULL,
  `statuses_count` int(11) NOT NULL,
  `location` varchar(100) NOT NULL,
  `profile_image_url` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `follower2`
--

CREATE TABLE IF NOT EXISTS `follower2` (
  `id` varchar(32) NOT NULL,
  `id2` varchar(32) NOT NULL,
  `name` varchar(100) NOT NULL,
  `screen_name` varchar(100) NOT NULL,
  `followers_count` int(11) NOT NULL,
  `friends_count` int(11) NOT NULL,
  `statuses_count` int(11) NOT NULL,
  `location` varchar(100) NOT NULL,
  `profile_image_url` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `following`
--

CREATE TABLE IF NOT EXISTS `following` (
  `id` varchar(32) NOT NULL,
  `name` varchar(100) NOT NULL,
  `screen_name` varchar(100) NOT NULL,
  `followers_count` int(11) NOT NULL DEFAULT '0',
  `friends_count` int(11) NOT NULL DEFAULT '0',
  `statuses_count` int(11) NOT NULL DEFAULT '0',
  `location` varchar(100) NOT NULL,
  `profile_image_url` varchar(255) NOT NULL,
  `common_followers_count` int(11) NOT NULL DEFAULT '0',
  `common_friends_count` int(11) NOT NULL DEFAULT '0',
  `similarity_followers` float NOT NULL DEFAULT '0',
  `similarity_friends` float NOT NULL DEFAULT '0',
  `cluster` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `following2`
--

CREATE TABLE IF NOT EXISTS `following2` (
  `id` varchar(32) NOT NULL,
  `id2` varchar(32) NOT NULL,
  `name` varchar(100) NOT NULL,
  `screen_name` varchar(100) NOT NULL,
  `followers_count` int(11) NOT NULL,
  `friends_count` int(11) NOT NULL,
  `statuses_count` int(11) NOT NULL,
  `location` varchar(100) NOT NULL,
  `profile_image_url` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` varchar(32) NOT NULL,
  `name` varchar(100) NOT NULL,
  `screen_name` varchar(100) NOT NULL,
  `followers_count` int(11) NOT NULL,
  `friends_count` int(11) NOT NULL,
  `statuses_count` int(11) NOT NULL,
  `location` varchar(100) NOT NULL,
  `profile_image_url` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
