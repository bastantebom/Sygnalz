-- phpMyAdmin SQL Dump
-- version 3.4.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 10, 2012 at 04:18 PM
-- Server version: 5.1.53
-- PHP Version: 5.3.9

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
--
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_campaign`
--

CREATE TABLE IF NOT EXISTS `tbl_campaign` (
  `campaign_id` int(100) unsigned NOT NULL AUTO_INCREMENT,
  `campaign_credit` varchar(50) NOT NULL,
  `campaign_date_created` date NOT NULL,
  `campaign_desc` text NOT NULL,
  PRIMARY KEY (`campaign_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `tbl_campaign`
--

INSERT INTO `tbl_campaign` (`campaign_id`, `campaign_credit`, `campaign_date_created`, `campaign_desc`) VALUES
(1, '20', '2012-02-19', 'Twitter Re-Tweets'),
(2, '10', '2012-02-19', 'Facebook Likes'),
(3, '20', '2012-02-19', 'Google +1'),
(4, '20', '2012-02-19', 'Bookmarks'),
(5, '10', '2012-02-19', 'Youtube Video Views'),
(6, '10', '2012-02-19', 'Youtube Video Ratings'),
(7, '10', '2012-02-19', 'Youtube Channel Subscribers'),
(8, '300', '2012-02-19', 'Blog Commenting');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_customer`
--

CREATE TABLE IF NOT EXISTS `tbl_customer` (
  `customer_id` int(11) NOT NULL AUTO_INCREMENT,
  `plan_id` int(11) NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  `customer_credit` int(11) NOT NULL,
  `plan_started` text NOT NULL,
  `plan_end` text NOT NULL,
  PRIMARY KEY (`customer_id`),
  KEY `FK_tbl_customer_1` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `tbl_customer`
--

INSERT INTO `tbl_customer` (`customer_id`, `plan_id`, `user_id`, `customer_credit`, `plan_started`, `plan_end`) VALUES
(1, 1, 48, 14950, '1331297596', '1333889596');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_notification`
--

CREATE TABLE IF NOT EXISTS `tbl_notification` (
  `note_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `note_message` text NOT NULL,
  `note_status` int(11) NOT NULL,
  `extra` text,
  `extra2` text,
  `task_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`note_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=299 ;

--
-- Dumping data for table `tbl_notification`
--

INSERT INTO `tbl_notification` (`note_id`, `user_id`, `note_message`, `note_status`, `extra`, `extra2`, `task_id`) VALUES
(262, 50, 'Your monthly credit and number of days to expired has been reset', 1, '1331290094', '0', 0),
(263, 50, 'Your monthly credit and number of days to expired has been reset', 1, '1331290094', '0', 0),
(264, 50, 'Your monthly credit and number of days to expired has been reset', 1, '1331290094', '0', 0),
(265, 50, 'Your monthly credit and number of days to expired has been reset', 1, '1331290095', '0', 0),
(266, 50, 'Your monthly credit and number of days to expired has been reset', 1, '1331290095', '0', 0),
(267, 50, 'Your monthly credit and number of days to expired has been reset', 1, '1331290095', '0', 0),
(268, 50, 'Your monthly credit and number of days to expired has been reset', 1, '1331290095', '0', 0),
(269, 50, 'Your monthly credit and number of days to expired has been reset', 1, '1331290095', '0', 0),
(270, 50, 'Your monthly credit and number of days to expired has been reset', 1, '1331290095', '0', 0),
(271, 50, 'Your monthly credit and number of days to expired has been reset', 1, '1331290095', '0', 0),
(272, 50, 'Your monthly credit and number of days to expired has been reset', 1, '1331290095', '0', 0),
(273, 50, 'Your monthly credit and number of days to expired has been reset', 1, '1331290095', '0', 0),
(274, 50, 'Your monthly credit and number of days to expired has been reset', 1, '1331290095', '0', 0),
(275, 50, 'Your monthly credit and number of days to expired has been reset', 1, '1331290095', '0', 0),
(276, 50, 'Your monthly credit and number of days to expired has been reset', 1, '1331290095', '0', 0),
(277, 50, 'Your monthly credit and number of days to expired has been reset', 1, '1331290095', '0', 0),
(278, 50, 'Your monthly credit and number of days to expired has been reset', 1, '1331290095', '0', 0),
(279, 50, 'Your monthly credit and number of days to expired has been reset', 1, '1331290095', '0', 0),
(280, 50, 'Your monthly credit and number of days to expired has been reset', 1, '1331290095', '0', 0),
(281, 50, 'Your monthly credit and number of days to expired has been reset', 1, '1331290095', '0', 0),
(282, 50, 'Your monthly credit and number of days to expired has been reset', 1, '1331290095', '0', 0),
(283, 50, 'Your monthly credit and number of days to expired has been reset', 1, '1331290095', '0', 0),
(284, 50, 'Your monthly credit and number of days to expired has been reset', 1, '1331290095', '0', 0),
(285, 48, 'Task is grab by ', 1, '1331297660', '47', 1),
(286, 48, 'Task is grab by ', 1, '1331297788', '47', 1),
(287, 48, 'Task is grab by ', 1, '1331298184', '47', 1),
(288, 48, 'Task is grab by ', 1, '1331298305', '47', 1),
(289, 48, 'Task is grab by ', 1, '1331298412', '47', 1),
(290, 48, 'Task is grab by ', 1, '1331301663', '47', 2),
(291, 48, 'Has an Issue, Please fixed it! See on Message area for details. created by ', 1, '1331308931', '47', 1),
(292, 47, 'Issue has been Approved! ', 1, '1331308931', '0', 1),
(293, 48, 'Has an Issue, Please fixed it! See on Message area for details. created by ', 1, '1331309134', '47', 1),
(294, 47, 'Issue has been Approved! ', 1, '1331309134', '0', 1),
(295, 48, 'Has an Issue, Please fixed it! See on Message area for details. created by ', 1, '1331352279', '47', 1),
(296, 47, 'Issue has been Approved! ', 1, '1331352279', '0', 1),
(297, 48, 'Has an Issue, Please fixed it! See on Message area for details. created by ', 1, '1331352347', '47', 1),
(298, 47, 'Issue has been Approved! ', 1, '1331352347', '0', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_payment`
--

CREATE TABLE IF NOT EXISTS `tbl_payment` (
  `payment_id` int(11) NOT NULL AUTO_INCREMENT,
  `payment_vendor` int(11) NOT NULL,
  `payment_fromcustomer` int(11) NOT NULL,
  `payment_number` int(11) NOT NULL,
  `payment_priceaction` double NOT NULL,
  `payment_start` text NOT NULL,
  `payment_end` text NOT NULL,
  `payment_total` double NOT NULL,
  `payment_status` int(11) NOT NULL,
  `payment_approver` int(11) NOT NULL,
  `payment_extra` text NOT NULL,
  PRIMARY KEY (`payment_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_plan`
--

CREATE TABLE IF NOT EXISTS `tbl_plan` (
  `plan_id` int(11) NOT NULL AUTO_INCREMENT,
  `plan_credit` text NOT NULL,
  PRIMARY KEY (`plan_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `tbl_plan`
--

INSERT INTO `tbl_plan` (`plan_id`, `plan_credit`) VALUES
(1, '15000'),
(2, '20000'),
(3, '32000'),
(4, '49000'),
(5, '65000 '),
(6, '99000 '),
(7, '165000 '),
(8, '332000'),
(9, '500000'),
(10, '833000'),
(11, '1333000');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_problem`
--

CREATE TABLE IF NOT EXISTS `tbl_problem` (
  `problem_id` int(11) NOT NULL AUTO_INCREMENT,
  `task_id` int(11) NOT NULL,
  `problem_from` int(11) NOT NULL,
  `problem_to` int(11) NOT NULL,
  `problem_state` int(11) NOT NULL,
  `problem_message` text NOT NULL,
  `problem_date` text NOT NULL,
  PRIMARY KEY (`problem_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `tbl_problem`
--

INSERT INTO `tbl_problem` (`problem_id`, `task_id`, `problem_from`, `problem_to`, `problem_state`, `problem_message`, `problem_date`) VALUES
(1, 1, 47, 48, 1, 'test', '1331299650'),
(2, 2, 47, 48, 1, 'Test 2', '1331301673');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_task`
--

CREATE TABLE IF NOT EXISTS `tbl_task` (
  `task_id` int(11) NOT NULL AUTO_INCREMENT,
  `campaign_id` int(11) NOT NULL,
  `url` varchar(50) NOT NULL,
  `task_credit` int(10) unsigned NOT NULL,
  `start_count` bigint(20) DEFAULT NULL,
  `end_count` bigint(20) DEFAULT NULL,
  `customer_id` int(11) NOT NULL,
  `vendor_id` int(11) DEFAULT NULL,
  `transaction_id` int(11) DEFAULT NULL,
  `date_created` bigint(20) NOT NULL,
  `task_status` int(11) NOT NULL,
  `extra` int(11) DEFAULT NULL,
  `extra2` int(11) DEFAULT NULL,
  PRIMARY KEY (`task_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `tbl_task`
--

INSERT INTO `tbl_task` (`task_id`, `campaign_id`, `url`, `task_credit`, `start_count`, `end_count`, `customer_id`, `vendor_id`, `transaction_id`, `date_created`, `task_status`, `extra`, `extra2`) VALUES
(1, 1, 'qwqw', 20, 100, 0, 48, 47, 0, 1331297644, 4, 0, 0),
(2, 1, 'www', 20, 11, 0, 48, 47, 0, 1331301652, 4, 0, 0),
(5, 2, 'jaysonilagan.com', 10, 0, 0, 48, 0, 0, 1331394528, 1, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE IF NOT EXISTS `tbl_user` (
  `userid` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `fullname` varchar(100) NOT NULL,
  `screenname` varchar(20) NOT NULL,
  `emailadd` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `usertype` int(5) unsigned NOT NULL,
  `phonenumber` varchar(20) NOT NULL,
  `initial` int(2) NOT NULL,
  `user_set` text,
  PRIMARY KEY (`userid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=49 ;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`userid`, `fullname`, `screenname`, `emailadd`, `username`, `password`, `usertype`, `phonenumber`, `initial`, `user_set`) VALUES
(28, 'Jayson Ilagan', '', 'jayson.vergara.ilagan@gmail.com', 'jayson', '9eef6a1f927654f24801f58fe67bb1d4', 1, '111', 1, ''),
(46, 'Charles Heflin', '', 'charlesheflin@gmail.com', 'charles', 'a5410ee37744c574ba5790034ea08f79', 1, '1', 1, ''),
(47, 'Roy Guzman', '', 'y@y.com', 'roy', '415290769594460e2e485922904f345d', 2, '987', 1, '1'),
(48, 'Juan Dela Cruz', '', 'x@x.com', 'juan', '9dd4e461268c8034f5c8564e155c67a6', 3, '1512', 1, '1');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_usertype`
--

CREATE TABLE IF NOT EXISTS `tbl_usertype` (
  `usertypeid` int(100) NOT NULL AUTO_INCREMENT,
  `usertypedesc` varchar(20) NOT NULL,
  PRIMARY KEY (`usertypeid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `tbl_usertype`
--

INSERT INTO `tbl_usertype` (`usertypeid`, `usertypedesc`) VALUES
(1, 'Admin'),
(2, 'Vendor'),
(3, 'Customer');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_vendor`
--

CREATE TABLE IF NOT EXISTS `tbl_vendor` (
  `vendor_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `vendor_expertise` text NOT NULL,
  `vendor_priceaction` float NOT NULL,
  `date_created` text NOT NULL,
  `extra` text NOT NULL,
  PRIMARY KEY (`vendor_id`),
  KEY `FK_tbl_vendor_1` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `tbl_vendor`
--

INSERT INTO `tbl_vendor` (`vendor_id`, `user_id`, `vendor_expertise`, `vendor_priceaction`, `date_created`, `extra`) VALUES
(1, 47, 'a:1:{i:1;s:1:"1";}', 0.02, '1331297614', '');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_customer`
--
ALTER TABLE `tbl_customer`
  ADD CONSTRAINT `FK_tbl_customer_1` FOREIGN KEY (`user_id`) REFERENCES `tbl_user` (`userid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_vendor`
--
ALTER TABLE `tbl_vendor`
  ADD CONSTRAINT `FK_tbl_vendor_1` FOREIGN KEY (`user_id`) REFERENCES `tbl_user` (`userid`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
