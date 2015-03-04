-- phpMyAdmin SQL Dump
-- version 3.3.10.4
-- http://www.phpmyadmin.net
--
-- Host: mysql.daniepaul.com
-- Generation Time: Mar 04, 2015 at 12:44 AM
-- Server version: 5.1.56
-- PHP Version: 5.4.37

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `chessgame`
--

-- --------------------------------------------------------

--
-- Table structure for table `chatting`
--

CREATE TABLE IF NOT EXISTS `chatting` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `send_id` int(10) DEFAULT NULL,
  `rec_id` int(10) NOT NULL,
  `text` varchar(200) NOT NULL,
  `datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `room` varchar(200) NOT NULL,
  `Cstatus` char(1) NOT NULL DEFAULT 'N',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `chatting`
--

INSERT INTO `chatting` (`id`, `send_id`, `rec_id`, `text`, `datetime`, `room`, `Cstatus`) VALUES
(4, 2, 0, 'ok', '2015-03-04 00:36:57', '1', 'Y'),
(3, 2, 0, 'test message', '2015-03-04 00:36:48', '1', 'Y'),
(5, 1, 0, 'is it?', '2015-03-04 00:37:10', '1', 'Y'),
(6, 2, 0, 'fine', '2015-03-04 00:37:16', '1', 'Y'),
(7, 1, 0, 'test', '2015-03-04 00:39:25', '1', 'Y');

-- --------------------------------------------------------

--
-- Table structure for table `game`
--

CREATE TABLE IF NOT EXISTS `game` (
  `gameid` int(11) NOT NULL AUTO_INCREMENT,
  `whitePlayer` varchar(10) NOT NULL,
  `blackPlayer` varchar(10) NOT NULL,
  `whiteRequest` varchar(10) NOT NULL DEFAULT 'N',
  `blackRequest` varchar(10) NOT NULL DEFAULT 'N',
  `gameStatus` varchar(10) NOT NULL,
  `datePlayed` datetime NOT NULL,
  `notations` text NOT NULL,
  `won` int(11) NOT NULL,
  PRIMARY KEY (`gameid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `game`
--

INSERT INTO `game` (`gameid`, `whitePlayer`, `blackPlayer`, `whiteRequest`, `blackRequest`, `gameStatus`, `datePlayed`, `notations`, `won`) VALUES
(1, '2', '1', 'X', 'X', 'A', '2015-03-04 00:36:03', 'D2-D4@E7-E5~NB1-A3@QE8-E6~', 0);

-- --------------------------------------------------------

--
-- Table structure for table `log`
--

CREATE TABLE IF NOT EXISTS `log` (
  `logid` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `logtime` datetime NOT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'N',
  PRIMARY KEY (`logid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `log`
--

INSERT INTO `log` (`logid`, `userid`, `logtime`, `status`) VALUES
(1, 2, '2015-02-21 19:09:29', 'Y'),
(2, 1, '2015-02-21 19:09:58', 'Y');

-- --------------------------------------------------------

--
-- Table structure for table `userpoints`
--

CREATE TABLE IF NOT EXISTS `userpoints` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `playedgame` int(11) NOT NULL DEFAULT '0',
  `wongame` int(11) NOT NULL DEFAULT '0',
  `drawgame` int(11) NOT NULL DEFAULT '0',
  `losegame` int(11) NOT NULL DEFAULT '0',
  `points` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `userpoints`
--

INSERT INTO `userpoints` (`id`, `userid`, `playedgame`, `wongame`, `drawgame`, `losegame`, `points`) VALUES
(1, 1, 4, 2, 0, 0, 4),
(2, 2, 4, 0, 0, 2, 0);

-- --------------------------------------------------------

--
-- Table structure for table `userprofile`
--

CREATE TABLE IF NOT EXISTS `userprofile` (
  `userid` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `age` int(11) NOT NULL,
  `gender` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `country` varchar(200) NOT NULL,
  `city` varchar(200) NOT NULL,
  PRIMARY KEY (`userid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `userprofile`
--

INSERT INTO `userprofile` (`userid`, `username`, `password`, `age`, `gender`, `email`, `country`, `city`) VALUES
(1, 'user1', 'user1', 21, 'male', 'test@gmail.com', 'india', 'chennai'),
(2, 'user2', 'user2', 23, 'male', 'vijay@ymail.com', 'india', 'chennai'),
(3, 'user3', 'user2', 25, 'male', 'raj@ymail.co.in', 'india', 'madurai'),
(4, 'star', 'star', 28, 'male', 'star@hotmail.in', 'india', 'kovai');
