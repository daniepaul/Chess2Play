-- phpMyAdmin SQL Dump
-- version 2.11.3
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 24, 2009 at 05:16 AM
-- Server version: 5.0.51
-- PHP Version: 5.2.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `chess`
--

-- --------------------------------------------------------

--
-- Table structure for table `chatting`
--

CREATE TABLE `chatting` (
  `id` int(10) NOT NULL auto_increment,
  `send_id` int(10) default NULL,
  `rec_id` int(10) NOT NULL,
  `text` varchar(200) NOT NULL,
  `datetime` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `room` varchar(200) NOT NULL,
  `Cstatus` char(1) NOT NULL default 'N',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `chatting`
--


-- --------------------------------------------------------

--
-- Table structure for table `game`
--

CREATE TABLE `game` (
  `gameid` int(11) NOT NULL auto_increment,
  `whitePlayer` varchar(10) NOT NULL,
  `blackPlayer` varchar(10) NOT NULL,
  `whiteRequest` varchar(10) NOT NULL default 'N',
  `blackRequest` varchar(10) NOT NULL default 'N',
  `gameStatus` varchar(10) NOT NULL,
  `datePlayed` datetime NOT NULL,
  `won` int(11) NOT NULL,
  PRIMARY KEY  (`gameid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `game`
--


-- --------------------------------------------------------

--
-- Table structure for table `log`
--

CREATE TABLE `log` (
  `logid` int(11) NOT NULL auto_increment,
  `userid` int(11) NOT NULL,
  `logtime` datetime NOT NULL,
  `status` varchar(10) NOT NULL default 'N',
  PRIMARY KEY  (`logid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `log`
--


-- --------------------------------------------------------

--
-- Table structure for table `userpoints`
--

CREATE TABLE `userpoints` (
  `id` int(11) NOT NULL auto_increment,
  `userid` int(11) NOT NULL,
  `playedgame` int(11) NOT NULL default '0',
  `wongame` int(11) NOT NULL default '0',
  `drawgame` int(11) NOT NULL default '0',
  `losegame` int(11) NOT NULL default '0',
  `points` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `userpoints`
--


-- --------------------------------------------------------

--
-- Table structure for table `userprofile`
--

CREATE TABLE `userprofile` (
  `userid` int(11) NOT NULL auto_increment,
  `username` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `age` int(11) NOT NULL,
  `gender` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `country` varchar(200) NOT NULL,
  `city` varchar(200) NOT NULL,
  PRIMARY KEY  (`userid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `userprofile`
--

INSERT INTO `userprofile` (`userid`, `username`, `password`, `age`, `gender`, `email`, `country`, `city`) VALUES
(1, 'test', 'test', 21, 'male', 'test@gmail.com', 'india', 'chennai'),
(2, 'vijay', 'vijay', 23, 'male', 'vijay@ymail.com', 'india', 'chennai'),
(3, 'raj', 'raj', 25, 'male', 'raj@ymail.co.in', 'india', 'madurai'),
(4, 'star', 'star', 28, 'male', 'star@hotmail.in', 'india', 'kovai');
