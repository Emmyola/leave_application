-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 14, 2023 at 01:59 AM
-- Server version: 10.4.20-MariaDB
-- PHP Version: 7.3.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `leave_app_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `company`
--

CREATE TABLE `company` (
  `id` int(11) NOT NULL,
  `description` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `company`
--

INSERT INTO `company` (`id`, `description`) VALUES
(1, 'MQUID INTEGRATED SOLUTION LIMITED'),
(2, 'GROOMING HEALTH MANAGEMENT LIMITED'),
(3, 'CREDITSTAR MICROINSURANCE LIMITED'),
(4, 'SUNLAY INSURANCE BROKERS LIMITED'),
(5, 'STAYSAFE SYSTEM SECURITY LIMITED'),
(6, 'STAYSAFE SYSTEM FACILITIES LIMITED');

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `code` int(11) NOT NULL,
  `description` varchar(50) NOT NULL,
  `company_id` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`code`, `description`, `company_id`) VALUES
(1, 'Adminstrator Officer', '1'),
(2, 'Finance / Accounting', '1'),
(3, 'Admin / Marketer Officer', '3'),
(4, 'Application Support Officer', '1'),
(5, 'Project / Developer Officer', '1'),
(6, 'Human Resouces Management', '3'),
(7, 'Provider Officer', '2'),
(8, 'Provider Head Officer', '2'),
(9, 'Client Service Officer', '2'),
(10, 'Data / Call Center Officer', '2'),
(11, 'Claims Officer', '2'),
(12, 'Cliems Haed Officer', '2'),
(13, 'Medical Unit Officer', '2'),
(14, 'Managing Director', '2'),
(15, 'Executive Director', '2'),
(16, 'logistic Officer (Driver)', '3'),
(17, 'Admin / Marketer Officer', '4'),
(18, 'Credit / Account Officer', '4'),
(19, 'logistic Officer (Driver)', '4'),
(20, 'logistic Officer (Driver)', '5'),
(21, 'Head of Security Officer', '5'),
(22, 'Operative Security Officer', '5'),
(23, 'Maintenance Officer', '6'),
(24, 'Administration / Finance Officer', '6'),
(25, 'Administration Officer', '6'),
(26, 'Janitor Officer (Cleaning)', '6'),
(27, 'logistic Officer (Driver)', '6');

-- --------------------------------------------------------

--
-- Table structure for table `leave_form`
--

CREATE TABLE `leave_form` (
  `id` int(11) NOT NULL,
  `leave_id` varchar(14) NOT NULL,
  `date_created` date NOT NULL,
  `time` time NOT NULL,
  `staff_id` varchar(10) NOT NULL,
  `staff_name` varchar(200) NOT NULL,
  `company` varchar(200) NOT NULL,
  `department` int(11) NOT NULL,
  `leave_type` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `no_of_days` int(11) NOT NULL DEFAULT 0,
  `resumption_date` date NOT NULL,
  `replacement_assign_staff` varchar(200) NOT NULL,
  `purpose_of_leave` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `initiator_action` int(11) NOT NULL,
  `initiator_comments` varchar(255) NOT NULL,
  `verified_staff` int(10) DEFAULT NULL,
  `verified_replacement_staff` int(10) DEFAULT NULL,
  `recommender_action` int(11) DEFAULT NULL,
  `recommender_comments` varchar(255) DEFAULT NULL,
  `approver_action` int(11) DEFAULT NULL,
  `approver_comments` varchar(255) DEFAULT NULL,
  `last_updated_date` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `leave_form`
--

INSERT INTO `leave_form` (`id`, `leave_id`, `date_created`, `time`, `staff_id`, `staff_name`, `company`, `department`, `leave_type`, `start_date`, `end_date`, `no_of_days`, `resumption_date`, `replacement_assign_staff`, `purpose_of_leave`, `status`, `initiator_action`, `initiator_comments`, `verified_staff`, `verified_replacement_staff`, `recommender_action`, `recommender_comments`, `approver_action`, `approver_comments`, `last_updated_date`) VALUES
(1, '1674486022', '2023-01-23', '03:53:46', '5', 'Lee,BRUCE,', '4', 17, 2, '2023-01-24', '2023-01-27', 4, '2023-01-30', '', 'wedding party', 5, 1, 'pls approve.', 0, 0, 2, 'pls approved', 1, 'approved', '0000-00-00 00:00:00'),
(9, '1674741038', '2023-01-26', '01:50:40', '5', 'Lee BRUCE 0', '4', 17, 4, '2023-02-01', '2023-02-22', 22, '2023-02-23', '', 'testing my leave', 2, 1, 'pls save me first', 0, 0, 2, 'ok', 0, 'ok', '0000-00-00 00:00:00'),
(10, 'LEV13186387593', '2023-02-01', '01:21:43', '5', 'Lee BRUCE 0', '4', 17, 3, '2023-02-09', '2023-02-15', 7, '2023-02-16', '', 'wedding party', 5, 1, 'pls approved', 0, 0, 2, 'pls approved.', 1, 'approved record', '0000-00-00 00:00:00'),
(11, 'LEV17755276014', '2023-02-06', '04:56:22', '10', 'Dayo MIKE 07064535487', '3', 6, 5, '2023-02-07', '2023-02-09', 3, '2023-02-10', '', 'okY', 5, 1, 'pls approved', 0, 0, 2, 'recommend pls approved', 1, 'approved', '0000-00-00 00:00:00'),
(12, 'LEV13249780259', '2023-02-10', '10:59:25', '5', 'Lee BRUCE 0', '4', 17, 6, '2023-02-13', '2023-02-15', 3, '2023-02-16', '7', 'testing page', 5, 1, 'ok', 2, 2, 2, 'done', 1, 'Approved', '2023-02-13 16:50:21'),
(13, 'LEV16734334101', '2023-02-10', '16:14:29', '5', 'Lee BRUCE 0', '4', 17, 6, '2023-02-13', '2023-02-15', 3, '2023-02-16', '6', 'testing', 3, 1, 'pls approved', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(14, 'LEV11576367643', '2023-02-14', '12:20:17', '5', 'Lee BRUCE 0', '4', 17, 6, '2023-02-15', '2023-02-17', 3, '2023-02-20', '6', 'ok', 2, 1, 'plaese approved', 2, 2, 2, 'pls approved sir', 0, 'no space for this leave', '2023-02-13 23:37:19');

-- --------------------------------------------------------

--
-- Table structure for table `leave_type`
--

CREATE TABLE `leave_type` (
  `code` int(11) NOT NULL,
  `description` varchar(50) NOT NULL,
  `leave_duration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `leave_type`
--

INSERT INTO `leave_type` (`code`, `description`, `leave_duration`) VALUES
(1, 'Annual (No Paid Leave)', 15),
(2, 'Aduption Leave', 14),
(3, 'Maternity Leave (3 Months)', 90),
(4, 'Examination Leave', 30),
(5, 'Sick Leave', 5),
(6, 'Paternity Leave', 14),
(7, 'Study Leave (1 Week)', 7),
(8, 'Training Leave (1 Week)', 7);

-- --------------------------------------------------------

--
-- Stand-in structure for view `report`
-- (See below for the actual view)
--
CREATE TABLE `report` (
`leave_id` varchar(14)
,`date_created` date
,`time` time
,`staff_id` varchar(10)
,`staff_name` varchar(200)
,`company` varchar(200)
,`department` int(11)
,`leave_type` int(11)
,`start_date` date
,`end_date` date
,`no_of_days` int(11)
,`resumption_date` date
,`replacement_assign_staff` varchar(200)
,`purpose_of_leave` varchar(255)
,`status` int(11)
);

-- --------------------------------------------------------

--
-- Table structure for table `status`
--

CREATE TABLE `status` (
  `code` int(11) NOT NULL,
  `description` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `status`
--

INSERT INTO `status` (`code`, `description`) VALUES
(0, 'New'),
(1, 'Returned for Rework'),
(2, 'Declined'),
(3, 'Awaiting Recommendation'),
(4, 'Recommended/Awaiting Approver Action'),
(5, 'Approved');

-- --------------------------------------------------------

--
-- Table structure for table `userlevelpermissions`
--

CREATE TABLE `userlevelpermissions` (
  `userlevelid` int(11) NOT NULL,
  `tablename` varchar(255) NOT NULL,
  `permission` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `userlevelpermissions`
--

INSERT INTO `userlevelpermissions` (`userlevelid`, `tablename`, `permission`) VALUES
(-2, '{67DBC02E-FD20-415A-8CF5-94DD09C14F7A}department', 0),
(-2, '{67DBC02E-FD20-415A-8CF5-94DD09C14F7A}gender', 0),
(-2, '{67DBC02E-FD20-415A-8CF5-94DD09C14F7A}leave_form', 0),
(-2, '{67DBC02E-FD20-415A-8CF5-94DD09C14F7A}leave_type', 0),
(-2, '{67DBC02E-FD20-415A-8CF5-94DD09C14F7A}status', 0),
(-2, '{67DBC02E-FD20-415A-8CF5-94DD09C14F7A}userlevelpermissions', 0),
(-2, '{67DBC02E-FD20-415A-8CF5-94DD09C14F7A}userlevels', 0),
(-2, '{67DBC02E-FD20-415A-8CF5-94DD09C14F7A}user_profile', 0),
(1, '{67DBC02E-FD20-415A-8CF5-94DD09C14F7A}department', 0),
(1, '{67DBC02E-FD20-415A-8CF5-94DD09C14F7A}gender', 0),
(1, '{67DBC02E-FD20-415A-8CF5-94DD09C14F7A}home.php', 104),
(1, '{67DBC02E-FD20-415A-8CF5-94DD09C14F7A}leave_form', 111),
(1, '{67DBC02E-FD20-415A-8CF5-94DD09C14F7A}leave_type', 0),
(1, '{67DBC02E-FD20-415A-8CF5-94DD09C14F7A}status', 0),
(1, '{67DBC02E-FD20-415A-8CF5-94DD09C14F7A}userlevelpermissions', 0),
(1, '{67DBC02E-FD20-415A-8CF5-94DD09C14F7A}userlevels', 0),
(1, '{67DBC02E-FD20-415A-8CF5-94DD09C14F7A}user_profile', 0),
(2, '{67DBC02E-FD20-415A-8CF5-94DD09C14F7A}department', 0),
(2, '{67DBC02E-FD20-415A-8CF5-94DD09C14F7A}gender', 0),
(2, '{67DBC02E-FD20-415A-8CF5-94DD09C14F7A}home.php', 104),
(2, '{67DBC02E-FD20-415A-8CF5-94DD09C14F7A}leave_form', 108),
(2, '{67DBC02E-FD20-415A-8CF5-94DD09C14F7A}leave_type', 0),
(2, '{67DBC02E-FD20-415A-8CF5-94DD09C14F7A}status', 0),
(2, '{67DBC02E-FD20-415A-8CF5-94DD09C14F7A}userlevelpermissions', 0),
(2, '{67DBC02E-FD20-415A-8CF5-94DD09C14F7A}userlevels', 0),
(2, '{67DBC02E-FD20-415A-8CF5-94DD09C14F7A}user_profile', 0),
(3, '{67DBC02E-FD20-415A-8CF5-94DD09C14F7A}department', 0),
(3, '{67DBC02E-FD20-415A-8CF5-94DD09C14F7A}gender', 0),
(3, '{67DBC02E-FD20-415A-8CF5-94DD09C14F7A}home.php', 104),
(3, '{67DBC02E-FD20-415A-8CF5-94DD09C14F7A}leave_form', 108),
(3, '{67DBC02E-FD20-415A-8CF5-94DD09C14F7A}leave_type', 0),
(3, '{67DBC02E-FD20-415A-8CF5-94DD09C14F7A}status', 0),
(3, '{67DBC02E-FD20-415A-8CF5-94DD09C14F7A}userlevelpermissions', 0),
(3, '{67DBC02E-FD20-415A-8CF5-94DD09C14F7A}userlevels', 0),
(3, '{67DBC02E-FD20-415A-8CF5-94DD09C14F7A}user_profile', 0);

-- --------------------------------------------------------

--
-- Table structure for table `userlevels`
--

CREATE TABLE `userlevels` (
  `userlevelid` int(11) NOT NULL,
  `userlevelname` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `userlevels`
--

INSERT INTO `userlevels` (`userlevelid`, `userlevelname`) VALUES
(-2, 'Anonymous'),
(-1, 'Administrator'),
(0, 'Default'),
(1, 'Officer'),
(2, 'Supervisor'),
(3, 'Human Resource');

-- --------------------------------------------------------

--
-- Table structure for table `user_profile`
--

CREATE TABLE `user_profile` (
  `id` int(11) NOT NULL,
  `staff_id` tinyint(4) NOT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `date_of_birth` date NOT NULL,
  `email` varchar(25) NOT NULL,
  `mobile` varchar(11) NOT NULL,
  `company` varchar(200) DEFAULT NULL,
  `department` varchar(200) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(50) NOT NULL,
  `accesslevel` int(11) NOT NULL DEFAULT 0,
  `status` int(11) NOT NULL DEFAULT 0,
  `profile` mediumtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_profile`
--

INSERT INTO `user_profile` (`id`, `staff_id`, `last_name`, `first_name`, `gender`, `date_of_birth`, `email`, `mobile`, `company`, `department`, `username`, `password`, `accesslevel`, `status`, `profile`) VALUES
(1, 0, 'MIKE', 'Obioso', 'Male', '1990-06-14', 'dalton.chuks@gmail.com', '2147483647', '1', '4', 'dalton', '827ccb0eea8a706c4c34a16891f84e7b', 1, 1, 'a:15:{s:15:\"LoginRetryCount\";i:0;s:20:\"LastBadLoginDateTime\";s:19:\"2023/01/04 11:54:12\";s:23:\"LastPasswordChangedDate\";s:10:\"2022/12/01\";s:8:\"staff_id\";s:1:\"1\";s:9:\"last_name\";s:5:\"chuks\";s:10:\"first_name\";s:6:\"dalton\";s:6:\"gender\";s:4:\"Male\";s:13:\"date_of_birth\";s:10:\"1990-06-14\";s:5:\"email\";s:22:\"dalton.chuks@gmail.com\";s:6:\"mobile\";s:11:\"08033005299\";s:10:\"department\";s:1:\"4\";s:8:\"username\";s:6:\"dalton\";s:11:\"accesslevel\";s:1:\"0\";s:6:\"status\";s:1:\"1\";s:7:\"profile\";N;}'),
(2, 0, 'OKOI', 'Bassey', 'Male', '1992-08-07', 'okoi.bassey@gmail.com', '2147483647', '1', '5', 'okoi', '827ccb0eea8a706c4c34a16891f84e7b', 2, 1, 'a:15:{s:15:\"LoginRetryCount\";i:0;s:20:\"LastBadLoginDateTime\";s:0:\"\";s:23:\"LastPasswordChangedDate\";s:10:\"2022/12/01\";s:8:\"staff_id\";s:1:\"2\";s:9:\"last_name\";s:4:\"OKOI\";s:10:\"first_name\";s:6:\"Bassey\";s:6:\"gender\";s:4:\"Male\";s:13:\"date_of_birth\";s:10:\"1992-08-07\";s:5:\"email\";s:21:\"okoi.bassey@gmail.com\";s:6:\"mobile\";s:11:\"07012458710\";s:10:\"department\";s:1:\"4\";s:8:\"username\";s:4:\"okoi\";s:11:\"accesslevel\";s:1:\"2\";s:6:\"status\";s:1:\"1\";s:7:\"profile\";N;}'),
(3, 0, 'SAMMY', 'Uche', 'Male', '1987-01-13', 'uche.s@gmail.com', '815420235', '1', '5', 'sammily', '827ccb0eea8a706c4c34a16891f84e7b', 3, 1, 'a:16:{s:15:\"LoginRetryCount\";i:0;s:20:\"LastBadLoginDateTime\";s:19:\"2023/01/26 15:39:29\";s:23:\"LastPasswordChangedDate\";s:10:\"2023/01/11\";s:8:\"staff_id\";s:1:\"3\";s:9:\"last_name\";s:5:\"SAMMY\";s:10:\"first_name\";s:4:\"Uche\";s:6:\"gender\";s:4:\"Male\";s:13:\"date_of_birth\";s:10:\"1987-01-13\";s:5:\"email\";s:16:\"uche.s@gmail.com\";s:6:\"mobile\";s:10:\"0815420235\";s:7:\"company\";N;s:10:\"department\";s:1:\"4\";s:8:\"username\";s:7:\"sammily\";s:11:\"accesslevel\";s:1:\"3\";s:6:\"status\";s:1:\"1\";s:7:\"profile\";N;}'),
(4, 0, 'SAM', 'Shayo', 'Female', '2009-06-10', 'shayo@gmail.com', '815420239', '1', '1', 'sammy', '827ccb0eea8a706c4c34a16891f84e7b', 1, 1, 'a:16:{s:15:\"LoginRetryCount\";i:0;s:20:\"LastBadLoginDateTime\";s:19:\"2023/01/06 16:15:24\";s:23:\"LastPasswordChangedDate\";s:10:\"2023/01/04\";s:8:\"staff_id\";s:1:\"4\";s:9:\"last_name\";s:3:\"SAM\";s:10:\"first_name\";s:5:\"Shayo\";s:6:\"gender\";s:6:\"Female\";s:13:\"date_of_birth\";s:10:\"2009-06-10\";s:5:\"email\";s:15:\"shayo@gmail.com\";s:6:\"mobile\";s:10:\"0815420239\";s:7:\"company\";s:1:\"1\";s:10:\"department\";s:1:\"1\";s:8:\"username\";s:5:\"sammy\";s:11:\"accesslevel\";s:1:\"0\";s:6:\"status\";s:1:\"1\";s:7:\"profile\";N;}'),
(5, 0, 'BRUCE', 'Lee', 'Male', '1986-12-29', 'bruce@gmail.com', '0', '4', '17', 'lee', '827ccb0eea8a706c4c34a16891f84e7b', 1, 1, 'a:17:{s:15:\"LoginRetryCount\";i:0;s:20:\"LastBadLoginDateTime\";s:0:\"\";s:23:\"LastPasswordChangedDate\";s:10:\"2023/01/18\";s:8:\"staff_id\";s:1:\"5\";s:9:\"last_name\";s:5:\"BRUCE\";s:10:\"first_name\";s:3:\"Lee\";s:6:\"gender\";s:4:\"Male\";s:13:\"date_of_birth\";s:10:\"1986-12-29\";s:5:\"email\";s:15:\"bruce@gmail.com\";s:6:\"mobile\";N;s:7:\"company\";s:1:\"4\";s:10:\"department\";s:2:\"17\";s:8:\"username\";s:3:\"lee\";s:11:\"accesslevel\";s:1:\"1\";s:6:\"status\";s:1:\"1\";s:7:\"profile\";N;s:2:\"id\";s:1:\"5\";}'),
(6, 0, 'MARK', 'Sunlay', 'Male', '1995-02-01', 'sunlay@gmail.com', '0', '4', '18', 'mark', '827ccb0eea8a706c4c34a16891f84e7b', 2, 1, 'a:16:{s:15:\"LoginRetryCount\";i:0;s:20:\"LastBadLoginDateTime\";s:0:\"\";s:23:\"LastPasswordChangedDate\";s:10:\"2023/01/23\";s:8:\"staff_id\";s:1:\"6\";s:9:\"last_name\";s:4:\"MARK\";s:10:\"first_name\";s:6:\"Sunlay\";s:6:\"gender\";s:4:\"Male\";s:13:\"date_of_birth\";s:10:\"1995-02-01\";s:5:\"email\";s:16:\"sunlay@gmail.com\";s:6:\"mobile\";N;s:7:\"company\";s:1:\"4\";s:10:\"department\";s:2:\"18\";s:8:\"username\";s:4:\"mark\";s:11:\"accesslevel\";s:1:\"2\";s:6:\"status\";s:1:\"1\";s:7:\"profile\";N;}'),
(7, 0, 'MURINE', 'Merit', 'Female', '1988-02-17', 'merit@gmail.com', '0', '4', '17', 'merit', '827ccb0eea8a706c4c34a16891f84e7b', 3, 1, 'a:16:{s:15:\"LoginRetryCount\";i:0;s:20:\"LastBadLoginDateTime\";s:0:\"\";s:23:\"LastPasswordChangedDate\";s:10:\"2023/01/23\";s:8:\"staff_id\";s:1:\"7\";s:9:\"last_name\";s:6:\"MURINE\";s:10:\"first_name\";s:5:\"Merit\";s:6:\"gender\";s:6:\"Female\";s:13:\"date_of_birth\";s:10:\"1988-02-17\";s:5:\"email\";s:15:\"merit@gmail.com\";s:6:\"mobile\";N;s:7:\"company\";s:1:\"4\";s:10:\"department\";s:2:\"17\";s:8:\"username\";s:5:\"merit\";s:11:\"accesslevel\";s:1:\"3\";s:6:\"status\";s:1:\"1\";s:7:\"profile\";N;}'),
(8, 0, 'SEGUN', 'Kadri', '2', '1998-06-09', 'kadri@gmail.com', '2147483647', '3', '3', 'kadri', '827ccb0eea8a706c4c34a16891f84e7b', 2, 1, 'a:16:{s:15:\"LoginRetryCount\";i:0;s:20:\"LastBadLoginDateTime\";s:0:\"\";s:23:\"LastPasswordChangedDate\";s:10:\"2023/01/24\";s:8:\"staff_id\";s:1:\"8\";s:9:\"last_name\";s:5:\"SEGUN\";s:10:\"first_name\";s:5:\"Kadri\";s:6:\"gender\";s:4:\"Male\";s:13:\"date_of_birth\";s:10:\"1998-06-09\";s:5:\"email\";s:15:\"kadri@gmail.com\";s:6:\"mobile\";s:10:\"2147483647\";s:7:\"company\";s:1:\"1\";s:10:\"department\";s:1:\"4\";s:8:\"username\";s:5:\"kadri\";s:11:\"accesslevel\";s:1:\"1\";s:6:\"status\";s:1:\"1\";s:7:\"profile\";N;}'),
(9, 0, 'STANLE', 'Dashi', '1', '1998-02-04', 'oluwatobi275@gmail.com', '2147483647', '3', '6', 'danshi', '827ccb0eea8a706c4c34a16891f84e7b', 3, 1, 'a:16:{s:15:\"LoginRetryCount\";i:0;s:20:\"LastBadLoginDateTime\";s:0:\"\";s:23:\"LastPasswordChangedDate\";s:10:\"2023/02/06\";s:8:\"staff_id\";s:1:\"9\";s:9:\"last_name\";s:6:\"STANLE\";s:10:\"first_name\";s:5:\"Dashi\";s:6:\"gender\";s:1:\"1\";s:13:\"date_of_birth\";s:10:\"1998-02-04\";s:5:\"email\";s:22:\"oluwatobi275@gmail.com\";s:6:\"mobile\";s:11:\"08103674678\";s:7:\"company\";s:1:\"3\";s:10:\"department\";s:1:\"6\";s:8:\"username\";s:6:\"danshi\";s:11:\"accesslevel\";s:1:\"3\";s:6:\"status\";s:1:\"1\";s:7:\"profile\";N;}'),
(10, 0, 'MIKE', 'Dayo', '1', '2001-10-25', 'rose@gmail.com', '2147483647', '3', '6', 'mike', '827ccb0eea8a706c4c34a16891f84e7b', 1, 1, 'a:16:{s:15:\"LoginRetryCount\";i:0;s:20:\"LastBadLoginDateTime\";s:0:\"\";s:23:\"LastPasswordChangedDate\";s:10:\"2023/02/06\";s:8:\"staff_id\";s:2:\"10\";s:9:\"last_name\";s:4:\"MIKE\";s:10:\"first_name\";s:4:\"Dayo\";s:6:\"gender\";s:1:\"1\";s:13:\"date_of_birth\";s:10:\"2001-10-25\";s:5:\"email\";s:14:\"rose@gmail.com\";s:6:\"mobile\";s:11:\"07064535487\";s:7:\"company\";s:1:\"3\";s:10:\"department\";s:1:\"6\";s:8:\"username\";s:4:\"mike\";s:11:\"accesslevel\";s:1:\"1\";s:6:\"status\";s:1:\"1\";s:7:\"profile\";N;}');

-- --------------------------------------------------------

--
-- Structure for view `report`
--
DROP TABLE IF EXISTS `report`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `report`  AS SELECT `leave_form`.`leave_id` AS `leave_id`, `leave_form`.`date_created` AS `date_created`, `leave_form`.`time` AS `time`, `leave_form`.`staff_id` AS `staff_id`, `leave_form`.`staff_name` AS `staff_name`, `leave_form`.`company` AS `company`, `leave_form`.`department` AS `department`, `leave_form`.`leave_type` AS `leave_type`, `leave_form`.`start_date` AS `start_date`, `leave_form`.`end_date` AS `end_date`, `leave_form`.`no_of_days` AS `no_of_days`, `leave_form`.`resumption_date` AS `resumption_date`, `leave_form`.`replacement_assign_staff` AS `replacement_assign_staff`, `leave_form`.`purpose_of_leave` AS `purpose_of_leave`, `leave_form`.`status` AS `status` FROM `leave_form` ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`code`);

--
-- Indexes for table `leave_form`
--
ALTER TABLE `leave_form`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `leave_type`
--
ALTER TABLE `leave_type`
  ADD PRIMARY KEY (`code`);

--
-- Indexes for table `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`code`);

--
-- Indexes for table `userlevelpermissions`
--
ALTER TABLE `userlevelpermissions`
  ADD PRIMARY KEY (`userlevelid`,`tablename`);

--
-- Indexes for table `userlevels`
--
ALTER TABLE `userlevels`
  ADD PRIMARY KEY (`userlevelid`);

--
-- Indexes for table `user_profile`
--
ALTER TABLE `user_profile`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `company`
--
ALTER TABLE `company`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `leave_form`
--
ALTER TABLE `leave_form`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `user_profile`
--
ALTER TABLE `user_profile`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
