-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 29, 2024 at 01:23 PM
-- Server version: 10.4.13-MariaDB
-- PHP Version: 7.3.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `quiktrak`
--

-- --------------------------------------------------------

--
-- Table structure for table `jobinspectionanswers`
--

CREATE TABLE `jobinspectionanswers` (
  `jobInspectionAnswersId` int(10) NOT NULL,
  `jobId` int(10) NOT NULL COMMENT 'jobs table jobId',
  `temGroupQueId` int(10) NOT NULL COMMENT 'templategroupquestions table temGroupQueId',
  `temGroupQueOptionId` int(10) NOT NULL COMMENT 'templategroupquestionoptions table temGroupQueOptionId',
  `commentsIfAny` text NOT NULL,
  `status` int(10) NOT NULL DEFAULT 1 COMMENT '1-Enable,0-Disable',
  `createdDate` datetime NOT NULL,
  `createdBy` int(10) NOT NULL,
  `lastModifiedDate` datetime NOT NULL,
  `lastModifiedBy` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `jobinspectionanswers`
--

INSERT INTO `jobinspectionanswers` (`jobInspectionAnswersId`, `jobId`, `temGroupQueId`, `temGroupQueOptionId`, `commentsIfAny`, `status`, `createdDate`, `createdBy`, `lastModifiedDate`, `lastModifiedBy`) VALUES
(1, 1, 1, 1, 'first comment', 1, '2024-11-27 17:05:53', 1, '2024-11-27 17:05:53', 1),
(2, 1, 2, 6, 'Second Comment', 1, '2024-11-27 17:05:53', 1, '2024-11-27 17:05:53', 1);

-- --------------------------------------------------------

--
-- Table structure for table `jobinspectionothersdetails`
--

CREATE TABLE `jobinspectionothersdetails` (
  `jobInspOthDetailsId` int(10) NOT NULL,
  `jobId` int(10) NOT NULL COMMENT 'jobs table jobId',
  `description` text NOT NULL,
  `status` int(10) NOT NULL DEFAULT 1 COMMENT '1-Enable,0-Disable',
  `createdDate` datetime NOT NULL,
  `createdBy` int(10) NOT NULL,
  `lastModifiedDate` datetime NOT NULL,
  `lastModifiedBy` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `jobinspectionothersdetails`
--

INSERT INTO `jobinspectionothersdetails` (`jobInspOthDetailsId`, `jobId`, `description`, `status`, `createdDate`, `createdBy`, `lastModifiedDate`, `lastModifiedBy`) VALUES
(1, 1, 'Other notes here', 1, '2024-11-27 17:05:53', 1, '2024-11-27 17:05:53', 1);

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `jobId` int(10) NOT NULL,
  `title` text NOT NULL,
  `type` int(10) NOT NULL COMMENT '1-Collateral, 2-Equipment,3-Property',
  `address` text NOT NULL,
  `scheduledDateTime` datetime NOT NULL,
  `timezoneId` int(10) NOT NULL COMMENT 'timezones table timezoneId',
  `assignedTo` int(10) NOT NULL,
  `workStatus` int(10) NOT NULL DEFAULT 1 COMMENT '1-Not Started, 2-Inprogess,3-Completed',
  `status` int(10) NOT NULL DEFAULT 1 COMMENT '1-Enable,0-Disable',
  `createdDate` datetime NOT NULL,
  `createdBy` int(10) NOT NULL,
  `lastModifiedDate` datetime NOT NULL,
  `lastModifiedBy` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`jobId`, `title`, `type`, `address`, `scheduledDateTime`, `timezoneId`, `assignedTo`, `workStatus`, `status`, `createdDate`, `createdBy`, `lastModifiedDate`, `lastModifiedBy`) VALUES
(1, 'Job 1 title', 1, 'My local address', '2024-11-28 09:09:07', 1, 5, 2, 1, '2024-11-27 10:08:57', 1, '2024-11-27 17:07:21', 1);

-- --------------------------------------------------------

--
-- Table structure for table `template`
--

CREATE TABLE `template` (
  `templateId` int(10) NOT NULL,
  `type` int(10) NOT NULL COMMENT '1-Collateral, 2-Equipment,3-Property',
  `templateTitle` text NOT NULL,
  `status` int(10) NOT NULL DEFAULT 1 COMMENT '1-Enable,0-Disable',
  `createdDate` datetime NOT NULL,
  `createdBy` int(10) NOT NULL,
  `lastModifiedDate` datetime NOT NULL,
  `lastModifiedBy` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `template`
--

INSERT INTO `template` (`templateId`, `type`, `templateTitle`, `status`, `createdDate`, `createdBy`, `lastModifiedDate`, `lastModifiedBy`) VALUES
(1, 3, 'Property template', 1, '2024-11-27 15:38:44', 1, '2024-11-27 15:38:44', 1);

-- --------------------------------------------------------

--
-- Table structure for table `templategroup`
--

CREATE TABLE `templategroup` (
  `temGroupId` int(10) NOT NULL,
  `templateId` int(10) NOT NULL COMMENT 'template table templateId',
  `groupName` text NOT NULL,
  `displayOrder` int(10) NOT NULL,
  `status` int(10) NOT NULL DEFAULT 1 COMMENT '1-Enable,0-Disable',
  `createdDate` datetime NOT NULL,
  `createdBy` int(10) NOT NULL,
  `lastModifiedDate` datetime NOT NULL,
  `lastModifiedBy` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `templategroup`
--

INSERT INTO `templategroup` (`temGroupId`, `templateId`, `groupName`, `displayOrder`, `status`, `createdDate`, `createdBy`, `lastModifiedDate`, `lastModifiedBy`) VALUES
(1, 1, 'ENTRANCE', 1, 1, '2024-11-27 15:39:18', 1, '2024-11-27 15:39:18', 1),
(2, 1, 'KITCHEN', 2, 1, '2024-11-27 15:39:18', 1, '2024-11-27 15:39:18', 1),
(3, 1, 'BATHROOM', 3, 1, '2024-11-27 15:40:06', 1, '2024-11-27 15:40:06', 1);

-- --------------------------------------------------------

--
-- Table structure for table `templategroupquestionoptions`
--

CREATE TABLE `templategroupquestionoptions` (
  `temGroupQueOptionId` int(10) NOT NULL,
  `temGroupQueId` int(10) NOT NULL COMMENT 'templategroupquestions table temGroupQueId',
  `optionValue` text NOT NULL,
  `displayOrder` int(10) NOT NULL,
  `status` int(10) NOT NULL DEFAULT 1 COMMENT '1-Enable,0-Disable',
  `createdDate` datetime NOT NULL,
  `createdBy` int(10) NOT NULL,
  `lastModifiedDate` datetime NOT NULL,
  `lastModifiedBy` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `templategroupquestionoptions`
--

INSERT INTO `templategroupquestionoptions` (`temGroupQueOptionId`, `temGroupQueId`, `optionValue`, `displayOrder`, `status`, `createdDate`, `createdBy`, `lastModifiedDate`, `lastModifiedBy`) VALUES
(1, 1, 'Excellent', 1, 1, '2024-11-27 15:44:09', 1, '2024-11-27 15:44:09', 1),
(2, 1, 'Good', 2, 1, '2024-11-27 15:44:09', 1, '2024-11-27 15:44:09', 1),
(3, 1, 'Fair', 3, 1, '2024-11-27 15:44:50', 1, '2024-11-27 15:44:50', 1),
(4, 1, 'Poor', 4, 1, '2024-11-27 15:45:12', 1, '2024-11-27 15:45:12', 1),
(5, 2, 'Excellent', 1, 1, '2024-11-27 15:44:09', 1, '2024-11-27 15:44:09', 1),
(6, 2, 'Good', 2, 1, '2024-11-27 15:44:09', 1, '2024-11-27 15:44:09', 1),
(7, 2, 'Fair', 3, 1, '2024-11-27 15:44:50', 1, '2024-11-27 15:44:50', 1),
(8, 2, 'Poor', 4, 1, '2024-11-27 15:45:12', 1, '2024-11-27 15:45:12', 1),
(9, 3, 'Excellent', 1, 1, '2024-11-27 15:44:09', 1, '2024-11-27 15:44:09', 1),
(10, 3, 'Good', 2, 1, '2024-11-27 15:44:09', 1, '2024-11-27 15:44:09', 1),
(11, 3, 'Fair', 3, 1, '2024-11-27 15:44:50', 1, '2024-11-27 15:44:50', 1),
(12, 3, 'Poor', 4, 1, '2024-11-27 15:45:12', 1, '2024-11-27 15:45:12', 1),
(13, 4, 'Excellent', 1, 1, '2024-11-27 15:44:09', 1, '2024-11-27 15:44:09', 1),
(14, 4, 'Good', 2, 1, '2024-11-27 15:44:09', 1, '2024-11-27 15:44:09', 1),
(15, 4, 'Fair', 3, 1, '2024-11-27 15:44:50', 1, '2024-11-27 15:44:50', 1),
(16, 4, 'Poor', 4, 1, '2024-11-27 15:45:12', 1, '2024-11-27 15:45:12', 1),
(17, 5, 'Excellent', 1, 1, '2024-11-27 15:44:09', 1, '2024-11-27 15:44:09', 1),
(18, 5, 'Good', 2, 1, '2024-11-27 15:44:09', 1, '2024-11-27 15:44:09', 1),
(19, 5, 'Fair', 3, 1, '2024-11-27 15:44:50', 1, '2024-11-27 15:44:50', 1),
(20, 5, 'Poor', 4, 1, '2024-11-27 15:45:12', 1, '2024-11-27 15:45:12', 1),
(21, 6, 'Excellent', 1, 1, '2024-11-27 15:44:09', 1, '2024-11-27 15:44:09', 1),
(22, 6, 'Good', 2, 1, '2024-11-27 15:44:09', 1, '2024-11-27 15:44:09', 1),
(23, 6, 'Fair', 3, 1, '2024-11-27 15:44:50', 1, '2024-11-27 15:44:50', 1),
(24, 6, 'Poor', 4, 1, '2024-11-27 15:45:12', 1, '2024-11-27 15:45:12', 1),
(25, 7, 'Excellent', 1, 1, '2024-11-27 15:44:09', 1, '2024-11-27 15:44:09', 1),
(26, 7, 'Good', 2, 1, '2024-11-27 15:44:09', 1, '2024-11-27 15:44:09', 1),
(27, 7, 'Fair', 3, 1, '2024-11-27 15:44:50', 1, '2024-11-27 15:44:50', 1),
(28, 7, 'Poor', 4, 1, '2024-11-27 15:45:12', 1, '2024-11-27 15:45:12', 1),
(29, 8, 'Excellent', 1, 1, '2024-11-27 15:44:09', 1, '2024-11-27 15:44:09', 1),
(30, 8, 'Good', 2, 1, '2024-11-27 15:44:09', 1, '2024-11-27 15:44:09', 1),
(31, 8, 'Fair', 3, 1, '2024-11-27 15:44:50', 1, '2024-11-27 15:44:50', 1),
(32, 8, 'Poor', 4, 1, '2024-11-27 15:45:12', 1, '2024-11-27 15:45:12', 1),
(33, 9, 'Excellent', 1, 1, '2024-11-27 15:44:09', 1, '2024-11-27 15:44:09', 1),
(34, 9, 'Good', 2, 1, '2024-11-27 15:44:09', 1, '2024-11-27 15:44:09', 1),
(35, 9, 'Fair', 3, 1, '2024-11-27 15:44:50', 1, '2024-11-27 15:44:50', 1),
(36, 9, 'Poor', 4, 1, '2024-11-27 15:45:12', 1, '2024-11-27 15:45:12', 1);

-- --------------------------------------------------------

--
-- Table structure for table `templategroupquestions`
--

CREATE TABLE `templategroupquestions` (
  `temGroupQueId` int(10) NOT NULL,
  `question` text NOT NULL,
  `templateGroupId` int(10) NOT NULL COMMENT 'templategroup table temGroupId',
  `displayOrder` int(10) NOT NULL,
  `status` int(10) NOT NULL DEFAULT 1 COMMENT '1-Enable,0-Disable',
  `createdDate` datetime NOT NULL,
  `createdBy` int(10) NOT NULL,
  `lastModifiedDate` datetime NOT NULL,
  `lastModifiedBy` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `templategroupquestions`
--

INSERT INTO `templategroupquestions` (`temGroupQueId`, `question`, `templateGroupId`, `displayOrder`, `status`, `createdDate`, `createdBy`, `lastModifiedDate`, `lastModifiedBy`) VALUES
(1, 'Steps condition', 1, 1, 1, '2024-11-27 15:40:50', 1, '2024-11-27 15:40:50', 1),
(2, 'Roof Condition', 1, 2, 1, '2024-11-27 15:40:50', 1, '2024-11-27 15:40:50', 1),
(3, 'Pathway condition', 1, 3, 1, '2024-11-27 15:42:18', 1, '2024-11-27 15:42:18', 1),
(4, 'Windows', 2, 1, 1, '2024-11-27 15:46:57', 1, '2024-11-27 15:46:57', 1),
(5, 'Wall condition', 2, 2, 1, '2024-11-27 15:46:57', 1, '2024-11-27 15:46:57', 1),
(6, 'Ceiling condition', 2, 3, 1, '2024-11-27 15:47:58', 1, '2024-11-27 15:47:58', 1),
(7, 'Windows', 3, 1, 1, '2024-11-27 15:46:57', 1, '2024-11-27 15:46:57', 1),
(8, 'Wall condition', 3, 2, 1, '2024-11-27 15:46:57', 1, '2024-11-27 15:46:57', 1),
(9, 'Ceiling condition', 3, 3, 1, '2024-11-27 15:47:58', 1, '2024-11-27 15:47:58', 1);

-- --------------------------------------------------------

--
-- Table structure for table `timezones`
--

CREATE TABLE `timezones` (
  `timeZoneId` int(10) NOT NULL,
  `timeZoneName` text NOT NULL,
  `timeZone` text NOT NULL,
  `status` int(10) NOT NULL DEFAULT 1 COMMENT '1-Enable,0-Disable',
  `createdDate` datetime NOT NULL,
  `createdBy` int(10) NOT NULL,
  `lastModifiedDate` datetime NOT NULL,
  `lastModifiedBy` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `timezones`
--

INSERT INTO `timezones` (`timeZoneId`, `timeZoneName`, `timeZone`, `status`, `createdDate`, `createdBy`, `lastModifiedDate`, `lastModifiedBy`) VALUES
(1, 'UK', 'Europe/London', 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(2, 'Mexico', 'Mexico/General', 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0),
(3, 'India', 'Asia/Kolkata', 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userId` int(10) NOT NULL,
  `name` text NOT NULL,
  `email` text NOT NULL,
  `password` text NOT NULL,
  `token` text NOT NULL,
  `status` int(10) NOT NULL DEFAULT 1 COMMENT '1-Enable,0-Disable',
  `createdDate` datetime NOT NULL,
  `createdBy` int(10) NOT NULL,
  `lastModifiedDate` datetime NOT NULL,
  `lastModifiedBy` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userId`, `name`, `email`, `password`, `token`, `status`, `createdDate`, `createdBy`, `lastModifiedDate`, `lastModifiedBy`) VALUES
(1, 'Bharat Kumar', 'bharatkumar506@gmail.com', '', '123', 1, '2024-11-20 18:29:25', 1, '2024-11-20 18:29:25', 1),
(2, 'kumar', 'bharat@gmail.com', '703bf46235d8cf6b9ae877d48d13e1ef', '', 0, '2024-11-22 06:45:08', 1, '2024-11-22 08:15:05', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `jobinspectionanswers`
--
ALTER TABLE `jobinspectionanswers`
  ADD PRIMARY KEY (`jobInspectionAnswersId`);

--
-- Indexes for table `jobinspectionothersdetails`
--
ALTER TABLE `jobinspectionothersdetails`
  ADD PRIMARY KEY (`jobInspOthDetailsId`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`jobId`);

--
-- Indexes for table `template`
--
ALTER TABLE `template`
  ADD PRIMARY KEY (`templateId`);

--
-- Indexes for table `templategroup`
--
ALTER TABLE `templategroup`
  ADD PRIMARY KEY (`temGroupId`);

--
-- Indexes for table `templategroupquestionoptions`
--
ALTER TABLE `templategroupquestionoptions`
  ADD PRIMARY KEY (`temGroupQueOptionId`);

--
-- Indexes for table `templategroupquestions`
--
ALTER TABLE `templategroupquestions`
  ADD PRIMARY KEY (`temGroupQueId`);

--
-- Indexes for table `timezones`
--
ALTER TABLE `timezones`
  ADD PRIMARY KEY (`timeZoneId`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `jobinspectionanswers`
--
ALTER TABLE `jobinspectionanswers`
  MODIFY `jobInspectionAnswersId` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `jobinspectionothersdetails`
--
ALTER TABLE `jobinspectionothersdetails`
  MODIFY `jobInspOthDetailsId` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `jobId` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `template`
--
ALTER TABLE `template`
  MODIFY `templateId` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `templategroup`
--
ALTER TABLE `templategroup`
  MODIFY `temGroupId` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `templategroupquestionoptions`
--
ALTER TABLE `templategroupquestionoptions`
  MODIFY `temGroupQueOptionId` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `templategroupquestions`
--
ALTER TABLE `templategroupquestions`
  MODIFY `temGroupQueId` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `timezones`
--
ALTER TABLE `timezones`
  MODIFY `timeZoneId` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userId` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
