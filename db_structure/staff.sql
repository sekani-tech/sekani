-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 14, 2020 at 02:45 PM
-- Server version: 10.1.16-MariaDB
-- PHP Version: 7.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sekani_admin`
--

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `id` int(100) NOT NULL,
  `int_id` int(100) DEFAULT NULL,
  `user_id` int(100) DEFAULT NULL,
  `int_name` varchar(50) DEFAULT NULL,
  `username` varchar(25) DEFAULT NULL,
  `display_name` varchar(25) DEFAULT NULL,
  `email` varchar(30) DEFAULT NULL,
  `first_name` varchar(30) DEFAULT NULL,
  `last_name` varchar(30) DEFAULT NULL,
  `description` longtext,
  `address` longtext,
  `date_joined` date DEFAULT NULL,
  `employee_status` varchar(20) DEFAULT NULL,
  `org_role` varchar(30) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `img` longtext
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`id`, `int_id`, `user_id`, `int_name`, `username`, `display_name`, `email`, `first_name`, `last_name`, `description`, `address`, `date_joined`, `employee_status`, `org_role`, `phone`, `img`) VALUES
(1, 6, 2, 'Dally', 'sam', 'sam', 'sam@gmail.com', 'sam', 'sam', 'something', 'something', '2020-02-24', 'Employed', 'CEO', '08162399', 'https://somewhere'),
(2, 7, 1, 'Sekani Systems', 'robot', 'robot test', 'robot@gmail.com', 'robot', 'test', 'something', 'something', '2020-02-24', NULL, 'OWNER', '08162399614', 'https://url'),
(7, 9, 16, 'Dally', 'flint123', 'flint', 'test@gmail.com', 'test', 'test', 'test', 'test', '2020-02-26', 'Employed', 'CEO', '98262', 'https://location'),
(8, 6, 17, 'Dally', 'clerk', 'front desk clerk', 'cler@gmail.com', 'clerk', 'clerk', 'clerk', 'clerk', '2020-02-26', 'Decommissioned', 'FRONT DESK CLERK', '0901267384', 'https://url'),
(9, 6, 18, 'Dally', 'teston', 'teston', 'teston@gmail.com', 'test', 'testton', 'testtest', 'testt', '2020-02-26', 'Employed', 'FRONT DESK CLERK', '08162399614', 'ss'),
(10, 9, 42, 'danels global', 'BMOHAMMED', 'Mohammed, Bashir', NULL, 'Bashir', 'Mohammed', NULL, NULL, '2018-12-12', NULL, NULL, NULL, NULL),
(11, 9, 43, 'danels global', 'MAKANDE', 'Akande, Mosi', NULL, 'Mosi', 'Akande', NULL, NULL, '2018-12-12', NULL, NULL, NULL, NULL),
(12, 9, 44, 'danels global', 'OLILIAN', 'Lilian, Ogochukwu', NULL, 'Ogochukwu', 'Lilian', NULL, NULL, '2019-02-19', NULL, NULL, NULL, NULL),
(13, 9, 40, 'danels global', 'PMR', 'Mr, Peter', NULL, 'Peter', 'Mr', NULL, NULL, '2019-02-19', NULL, NULL, NULL, NULL),
(14, 9, 41, 'danels global', 'FUMOGBAI', 'Umogbai, Favour', NULL, 'Favour', 'Umogbai', NULL, NULL, '2019-02-19', NULL, NULL, NULL, NULL),
(15, 9, 39, 'danels global', 'GENEH', 'Eneh, Grace ', NULL, 'Grace ', 'Eneh', NULL, NULL, '2019-02-19', NULL, NULL, NULL, NULL),
(16, 9, 38, 'danels global', 'FIBEKWE', 'Ibekwe, Faith', NULL, 'Faith', 'Ibekwe', NULL, NULL, '2019-02-19', NULL, NULL, NULL, NULL),
(17, 9, 37, 'danels global', 'EABDUL', 'Abdul, Emmanuel', NULL, 'Emmanuel', 'Abdul', NULL, NULL, '2019-02-19', NULL, NULL, NULL, NULL),
(18, 9, 36, 'danels global', 'TABUO', 'Abuo, Thomas', NULL, 'Thomas', 'Abuo', NULL, NULL, '2019-02-19', NULL, NULL, NULL, NULL),
(19, 9, 35, 'danels global', 'JAGADA', 'Agada, Jerry', NULL, 'Jerry', 'Agada', NULL, NULL, '2019-02-19', NULL, NULL, NULL, NULL),
(20, 9, 34, 'danels global', 'MAKHILE', 'Akhile, Mercy', NULL, 'Mercy', 'Akhile', NULL, NULL, '2019-02-19', NULL, NULL, NULL, NULL),
(21, 9, 33, 'danels global', 'AAKPAN', 'Akpan, Alice', NULL, 'Alice', 'Akpan', NULL, NULL, '2019-02-19', NULL, NULL, NULL, NULL),
(22, 9, 32, 'danels global', 'FBINTA', 'Binta, Fatima', NULL, 'Fatima', 'Binta', NULL, NULL, '2019-02-19', NULL, NULL, NULL, NULL),
(23, 9, 31, 'danels global', 'JBIODU', 'Biodu, Joseph', NULL, 'Joseph', 'Biodu', NULL, NULL, '2019-02-19', NULL, NULL, NULL, NULL),
(24, 9, 30, 'danels global', 'BEKONG', 'Ekong, Blessing', NULL, 'Blessing', 'Ekong', NULL, NULL, '2019-02-19', NULL, NULL, NULL, NULL),
(25, 9, 29, 'danels global', 'EFALETI', 'Faleti, Emmanuel', NULL, 'Emmanuel', 'Faleti', NULL, NULL, '2019-02-19', NULL, NULL, NULL, NULL),
(26, 9, 28, 'danels global', 'FIMOUKHUEDE', 'Imoukhuede, Felix', NULL, 'Felix', 'Imoukhuede', NULL, NULL, '2019-02-19', NULL, NULL, NULL, NULL),
(27, 9, 27, 'danels global', 'CKATO', 'Kato, Christine', NULL, 'Christine', 'Kato', NULL, NULL, '2019-02-19', NULL, NULL, NULL, NULL),
(28, 9, 26, 'danels global', 'OOCHE', 'Oche, Oche', NULL, 'Oche', 'Oche', NULL, NULL, '2019-02-19', NULL, NULL, NULL, NULL),
(29, 9, 25, 'danels global', 'OOJORO', 'Ojoro, Onyeche', NULL, 'Onyeche', 'Ojoro', NULL, NULL, '2019-02-19', NULL, NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`),
  ADD KEY `int_id_staff` (`int_id`),
  ADD KEY `user_id_staff` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `staff`
--
ALTER TABLE `staff`
  ADD CONSTRAINT `int_id_staff` FOREIGN KEY (`int_id`) REFERENCES `institutions` (`int_id`),
  ADD CONSTRAINT `user_id_staff` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
