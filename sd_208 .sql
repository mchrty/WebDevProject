-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 19, 2023 at 09:48 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sd_208`
--

-- --------------------------------------------------------

--
-- Table structure for table `activities`
--

CREATE TABLE `activities` (
  `activityId` int(11) NOT NULL,
  `activityName` varchar(31) NOT NULL,
  `activityDesc` varchar(255) NOT NULL,
  `activityDate` date NOT NULL,
  `activityTime` time NOT NULL,
  `activityImg` blob DEFAULT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` enum('done','pending') NOT NULL DEFAULT 'pending',
  `activityOwner` varchar(61) NOT NULL,
  `activityLocation` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `activities`
--

INSERT INTO `activities` (`activityId`, `activityName`, `activityDesc`, `activityDate`, `activityTime`, `activityImg`, `createdAt`, `status`, `activityOwner`, `activityLocation`) VALUES
(6, 'My Birthday', 'Nothing but my birthday', '2003-11-27', '00:00:00', 0x75706c6f6164732f6b617a7568612e6a7067, '2023-10-17 16:54:41', 'done', 'marvintenebroso@gmail.com', ''),
(7, 'This is an activity without img', 'To see if my code actually works - _ -', '1111-11-11', '11:11:00', NULL, '2023-10-18 13:10:30', 'pending', 'marvintenebroso@gmail.com', ''),
(8, 'asdasd', 'asdasddsad', '2223-03-23', '00:00:00', NULL, '2023-10-17 16:54:01', 'pending', 'marvintenebroso@gmail.com', ''),
(9, 'WebDev Class', 'WebDev For Tommorow', '2023-10-18', '10:30:00', NULL, '2023-10-18 04:46:57', 'pending', 'marvintenebroso@gmail.com', 'USC Talamban Campus'),
(10, 'Christmas', 'I hope all the people I care about have a merry merry christmas', '2023-12-25', '00:00:00', NULL, '2023-10-17 16:53:54', 'done', 'marvintenebroso@gmail.com', 'Each Respective Scholars Home'),
(11, 'This is jayclark activity', 'this is jayclark activity', '2332-12-31', '00:32:00', NULL, '2023-10-18 04:47:54', 'pending', 'jayclarkanore@gmail.com', 'jayclark'),
(12, 'Tommorow Noon', 'Just Checking Something', '2023-10-19', '12:00:00', NULL, '2023-10-18 14:31:46', 'pending', 'marvintenebroso@gmail.com', 'Tommorow'),
(13, 'New Year', 'New Year', '2024-01-01', '00:00:00', NULL, '2023-10-18 14:00:02', 'pending', 'jayclarkanore@gmail.com', 'Hooomeee'),
(14, 'Summer BBQ', 'Join us for a fun summer BBQ party.', '2023-07-15', '16:00:00', NULL, '2023-10-18 06:30:15', 'pending', 'marvintenebroso@gmail.com', 'Park by the lake'),
(15, 'Movie Night', 'Movie night at my place. Bring your favorite films!', '2023-11-10', '19:00:00', NULL, '2023-10-18 11:15:22', 'pending', 'jayclarkanore@gmail.com', '123 Main Street'),
(16, 'Hiking Trip', 'Let\'s go on an adventurous hike in the mountains.', '2023-08-20', '08:00:00', NULL, '2023-10-18 02:45:37', 'pending', 'marvintenebroso@gmail.com', 'Mountain Trailhead'),
(17, 'Art Exhibition', 'Explore a beautiful art exhibition featuring local artists.', '2023-09-05', '14:30:00', NULL, '2023-10-18 07:20:10', 'done', 'marvintenebroso@gmail.com', 'Downtown Gallery'),
(18, 'Beach Cleanup', 'Join us in cleaning up the local beach for a greener environment.', '2023-07-22', '09:00:00', NULL, '2023-10-18 01:55:28', 'done', 'marvintenebroso@gmail.com', 'Sunset Beach'),
(19, 'Community Potluck', 'Bring a dish and enjoy a community potluck dinner.', '2023-10-08', '18:00:00', NULL, '2023-10-18 10:10:45', 'done', 'jayclarkanore@gmail.com', 'Community Center'),
(20, 'Music Concert', 'Rock concert featuring local bands and artists.', '2023-09-30', '20:00:00', NULL, '2023-10-18 12:25:53', 'pending', 'marvintenebroso@gmail.com', 'City Arena'),
(21, 'Charity Run', 'Participate in a charity run to support a good cause.', '2023-10-30', '07:30:00', NULL, '2023-10-18 00:05:11', 'pending', 'marvintenebroso@gmail.com', 'City Park'),
(22, 'Food Festival', 'Enjoy a variety of cuisines at the local food festival.', '2023-11-15', '12:00:00', NULL, '2023-10-18 04:35:29', 'pending', 'jayclarkanore@gmail.com', 'Downtown Square'),
(23, 'Gardening Workshop', 'Learn gardening tips and tricks from experts.', '2023-08-25', '10:00:00', NULL, '2023-10-18 02:55:42', 'done', 'marvintenebroso@gmail.com', 'Botanical Garden'),
(24, 'To meet', 'Installation Meeting of the Client', '2023-10-20', '15:56:00', NULL, '2023-10-19 06:58:08', 'pending', 'gio@gmail.com', 'Davao'),
(25, 'Celebration', 'Birthday Celebration with my family.', '2023-12-21', '00:00:00', NULL, '2023-10-19 06:59:48', 'pending', 'gio@gmail.com', 'Bohol'),
(26, 'To depart', 'travel bound to south bus terminal for going home', '2023-10-28', '04:30:00', NULL, '2023-10-19 07:02:19', 'pending', 'cha@gmail.com', 'New Era, Mabolo Cebu, Cebu City'),
(27, 'Return to PN Center', 'solo travel to return at New Era, Mabolo Cebu, Passerelles Numeriqués Center', '2023-11-03', '15:00:00', NULL, '2023-10-19 07:05:36', 'pending', 'cha@gmail.com', 'Maloray, Dalaguete, Cebu'),
(28, 'WebDev', 'midterm examination , written and syntax as per the instruction of the professor.', '2023-10-20', '15:31:00', NULL, '2023-10-19 07:07:57', 'pending', 'tela@gmail.com', 'University of San Carlos - Talamban Campus'),
(29, 'Twenty-First', 'I have celebrated my 21st Birthday together with the co-scholars, and it was fun.', '2023-02-06', '20:45:00', NULL, '2023-10-19 07:19:55', 'pending', 'tela@gmail.com', 'San Alberto Carmelites Formation Center, PN Center 2');

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

CREATE TABLE `announcements` (
  `id` int(11) NOT NULL,
  `title` varchar(63) NOT NULL,
  `content` text NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `announcements`
--

INSERT INTO `announcements` (`id`, `title`, `content`, `createdAt`) VALUES
(4, 'asdasd', 'asdasdasd', '2023-10-18 16:00:03'),
(5, 'asdasdsqweqwe', 'qweqwdasfsdg', '2023-10-18 16:00:14'),
(7, 'Java', 'No regular class during midterm exam as what the instructor messaged.', '2023-10-19 07:21:29');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `firstname` varchar(63) NOT NULL,
  `lastname` varchar(63) NOT NULL,
  `emailAddress` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `gender` varchar(20) NOT NULL,
  `password` varchar(63) NOT NULL,
  `role` enum('admin','user') NOT NULL DEFAULT 'user',
  `status` enum('active','inactive') NOT NULL DEFAULT 'inactive'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `emailAddress`, `address`, `gender`, `password`, `role`, `status`) VALUES
(1, 'super', 'admin', 'admin@test.com', 'secret', 'Female', 'admin', 'admin', 'inactive'),
(2, 'Renato', 'Dulog', 'renrendulog@gmail.com', 'Pinamungajan', 'Male', '12345', 'user', 'inactive'),
(3, 'Marvin', 'Tenebroso', 'marvintenebroso@gmail.com', 'Barili', 'Male', 'marvin', 'user', 'inactive'),
(4, 'Jayclark', 'Anore', 'jayclarkanore@gmail.com', 'Lapu Lapu', 'Female', 'jayclark', 'user', 'inactive'),
(5, 'Giovanni', 'Pidere', 'gio@gmail.com', 'Lapu-Lapu', 'Male', 'giov', 'user', 'inactive'),
(6, 'Charity', 'Pidere', 'cha@gmail.com', 'Dalaguete', 'Female', 'pass', 'user', 'inactive'),
(7, 'estela', 'guintaason', 'tela@gmail.com', 'Mabolo', 'Female', 'telay', 'user', 'inactive'),
(8, 'Jhon Britz', 'Tangpos', 'jhon@gmail.com', 'Maloray', 'Others', '0000', 'user', 'inactive'),
(9, 'Jayrenz', 'Tangpos', 'jay@gmail.com', 'Lower Maloray', 'Others', 'ren', 'user', 'inactive');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activities`
--
ALTER TABLE `activities`
  ADD PRIMARY KEY (`activityId`);

--
-- Indexes for table `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activities`
--
ALTER TABLE `activities`
  MODIFY `activityId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `announcements`
--
ALTER TABLE `announcements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
