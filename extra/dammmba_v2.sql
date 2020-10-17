-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 17, 2020 at 10:59 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dammmba_v2`
--

-- --------------------------------------------------------

--
-- Table structure for table `branch`
--

CREATE TABLE `branch` (
  `branch_id` int(11) NOT NULL,
  `branch` char(200) NOT NULL,
  `branch_location` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `branch`
--

INSERT INTO `branch` (`branch_id`, `branch`, `branch_location`) VALUES
(1, 'DMB-Bacolod', 'Bry. 1 Bacolod City'),
(2, 'DMB-Sagay', 'sagay city');

-- --------------------------------------------------------

--
-- Table structure for table `landholdings`
--

CREATE TABLE `landholdings` (
  `id` int(11) NOT NULL,
  `municipality` char(50) DEFAULT NULL,
  `barangay` varchar(100) DEFAULT NULL,
  `landholdings_name` varchar(300) DEFAULT NULL,
  `landowner_name` varchar(300) DEFAULT NULL,
  `title_number` varchar(50) DEFAULT NULL,
  `lot_number` varchar(50) DEFAULT NULL,
  `lot_area` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `landholdings`
--

INSERT INTO `landholdings` (`id`, `municipality`, `barangay`, `landholdings_name`, `landowner_name`, `title_number`, `lot_number`, `lot_area`) VALUES
(1, 'Bacolod', 'Banago', 'HDA. San Mateo', 'Jeosette Batallones', 'tn-000001', 'ln-000001', 500),
(2, 'Bacolod', '1', 'HDA. Latab', 'Jonatan Ryan', 'tn-00140', 'ln-01152', 500),
(3, 'Sagay', 'Poblacion 1', 'HDA. Claro Artalles', 'Gina Artalles', 'tn-00012', 'lt-10001', 352),
(4, 'Sagay', 'Poblacion 1', 'HDA. Claro 2', 'Gina Artalles', 'tn-00013', 'lt-10003', 400),
(5, 'Sagay', 'Brgy. 1', 'HDA Alleg', 'Dino Arroyo', 'tn-00112', 'lt-105220', 580),
(6, 'Sagay', 'Poblacion 1', 'HDA Claro 3', 'Gina Artalles', 'tn-00014', 'lt-100065', 875);

-- --------------------------------------------------------

--
-- Table structure for table `landholding_crops`
--

CREATE TABLE `landholding_crops` (
  `crop_id` int(11) NOT NULL,
  `landholding_id` int(11) NOT NULL,
  `lot_area` float DEFAULT NULL,
  `average_patubas` float DEFAULT NULL,
  `irrigated` tinyint(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `login_history`
--

CREATE TABLE `login_history` (
  `activity_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date_recorded` datetime NOT NULL,
  `activity` varchar(100) NOT NULL,
  `description` varchar(999) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `monthly_dues`
--

CREATE TABLE `monthly_dues` (
  `id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `dues_record_id` int(11) NOT NULL,
  `amount` float NOT NULL,
  `due_date` date NOT NULL,
  `balance` float NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `monthly_dues_record`
--

CREATE TABLE `monthly_dues_record` (
  `id` int(11) NOT NULL,
  `month` int(11) NOT NULL,
  `year` int(11) NOT NULL,
  `date_added` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `monthly_dues_record`
--

INSERT INTO `monthly_dues_record` (`id`, `month`, `year`, `date_added`) VALUES
(1, 10, 2020, '2020-10-11 00:28:33');

-- --------------------------------------------------------

--
-- Table structure for table `organization`
--

CREATE TABLE `organization` (
  `id` int(11) NOT NULL,
  `landholdings_id` int(11) NOT NULL,
  `organization_name` varchar(300) DEFAULT NULL,
  `acroname` char(30) DEFAULT NULL,
  `municipality` char(50) DEFAULT NULL,
  `address` varchar(300) DEFAULT NULL,
  `registration_number` varchar(30) DEFAULT NULL,
  `registration_agency` varchar(300) DEFAULT NULL,
  `date_registered` date DEFAULT NULL,
  `accridited_number` varchar(100) DEFAULT NULL,
  `date_accridited` date DEFAULT NULL,
  `for_registration` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `organization`
--

INSERT INTO `organization` (`id`, `landholdings_id`, `organization_name`, `acroname`, `municipality`, `address`, `registration_number`, `registration_agency`, `date_registered`, `accridited_number`, `date_accridited`, `for_registration`) VALUES
(1, 1, 'Pro Active Farmer', 'PAR', 'Bacolod', 'blk 3 lot 1 San Mateo', 'rn-000001', 'DAR', '2020-09-17', 'accn-000001', '2020-09-17', 0),
(2, 3, 'Galapan Farmer Group', 'GFG', 'Bago', 'Brgy Mabalok', 'rn-001244', 'Department of Agreculture', '1997-07-07', '', '0000-00-00', 0),
(3, 3, 'Gapan Fisherman Assoc', 'GFA', 'Sagay', 'Brgy Mabalok', 'rts-092223', 'BFAR', '2018-06-13', '', '0000-00-00', 0),
(4, 6, 'Himalay Farmer Assoc', 'HIFAS', 'Cadiz', 'Bgry Malaya', 'gg-swen1234', 'DENR', '2020-07-30', '', '0000-00-00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `organization_member`
--

CREATE TABLE `organization_member` (
  `id` int(11) NOT NULL,
  `organization_id` int(11) NOT NULL,
  `member_name` varchar(100) DEFAULT NULL,
  `gender` char(20) DEFAULT NULL,
  `position` int(11) NOT NULL DEFAULT 0,
  `membership_fee` float DEFAULT NULL,
  `address` varchar(300) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `organization_member`
--

INSERT INTO `organization_member` (`id`, `organization_id`, `member_name`, `gender`, `position`, `membership_fee`, `address`) VALUES
(1, 1, 'Janet Lim', 'Female', 1, 500, 'block 2 lot 8 ,Brgy Bagol');

-- --------------------------------------------------------

--
-- Table structure for table `organization_member_position`
--

CREATE TABLE `organization_member_position` (
  `position_id` int(11) NOT NULL,
  `position_name` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `organization_member_position`
--

INSERT INTO `organization_member_position` (`position_id`, `position_name`) VALUES
(1, 'President'),
(20, 'Member');

-- --------------------------------------------------------

--
-- Table structure for table `payment_record`
--

CREATE TABLE `payment_record` (
  `payment_id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `payment_source` char(100) DEFAULT NULL,
  `amount_paid` float NOT NULL,
  `date_paid` date NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `redirect`
--

CREATE TABLE `redirect` (
  `redirect_id` int(11) NOT NULL,
  `source_url` varchar(500) NOT NULL,
  `redirect_url` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `routes`
--

CREATE TABLE `routes` (
  `route_id` int(11) NOT NULL,
  `route` varchar(300) NOT NULL,
  `file_name` varchar(100) NOT NULL,
  `function` varchar(100) NOT NULL,
  `maintenance` tinyint(4) NOT NULL DEFAULT 0,
  `require_login` tinyint(4) NOT NULL DEFAULT 0,
  `is_backend` int(11) NOT NULL DEFAULT 0,
  `require_user_role` int(11) NOT NULL DEFAULT 0,
  `allow_user_role` varchar(300) DEFAULT NULL,
  `allow_user_maintenance` varchar(300) DEFAULT NULL,
  `role_read` varchar(300) DEFAULT NULL,
  `role_write` varchar(300) DEFAULT NULL,
  `role_delete` varchar(300) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `routes`
--

INSERT INTO `routes` (`route_id`, `route`, `file_name`, `function`, `maintenance`, `require_login`, `is_backend`, `require_user_role`, `allow_user_role`, `allow_user_maintenance`, `role_read`, `role_write`, `role_delete`) VALUES
(1, '/', 'system_home', '_init', 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(2, '/login', 'system_login', '_login', 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(3, '/api/login', 'system_login', '_apiLogin', 0, 0, 1, 0, NULL, NULL, NULL, NULL, NULL),
(4, '/api/logout', 'system_login', '_logout', 0, 0, 1, 0, NULL, NULL, NULL, NULL, NULL),
(5, '/profile', 'client', '_profile', 0, 1, 0, 0, NULL, '1', NULL, NULL, NULL),
(6, '/admin', 'client_admin', '_dashboard', 1, 1, 0, 1, '1', NULL, NULL, NULL, NULL),
(7, '/api/apiLogoutGateway', 'system_pages', '_logoutGateway', 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(8, '/developer', 'admin_dashboard', '_dashboard', 1, 1, 0, 1, '1', '1,3', NULL, NULL, NULL),
(9, '/login/reset_password', 'system_login', '_forgot_password', 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(10, '/landholding', 'landholding', '_init', 0, 0, 0, 0, NULL, NULL, '1', '1', NULL),
(11, '/assetlist', 'client', '_assets', 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(12, '/developer/helper/plugin', 'admin_dashboard', '_helper', 0, 1, 0, 1, '1', NULL, NULL, NULL, NULL),
(13, '/developer/helper/user', 'admin_dashboard', '_user', 0, 1, 0, 1, '1', NULL, NULL, NULL, NULL),
(14, '/developer/helper/routes', 'admin_dashboard', '_routes', 0, 1, 0, 1, '1', NULL, NULL, NULL, NULL),
(15, '/organization', 'organization', '_init', 0, 0, 0, 0, NULL, NULL, '1', '1', '1'),
(16, '/admin/user', 'client_admin', '_user', 0, 1, 0, 0, '1', NULL, NULL, '1', '1'),
(17, '/api/admin/getUser', 'client_admin', '_api_get_user', 0, 0, 1, 1, '1', NULL, NULL, NULL, NULL),
(18, '/api/admin/addUser', 'client_admin', '_api_add_user', 0, 0, 1, 0, NULL, NULL, NULL, NULL, NULL),
(19, '/api/landholding/addlh', 'landholding', '_api_add_lh', 0, 0, 1, 0, NULL, NULL, NULL, NULL, NULL),
(20, '/api/organization/addOrg', 'organization', '_api_add_org', 0, 0, 1, 0, NULL, NULL, NULL, NULL, NULL),
(21, '/api/admin/deleteUser', 'client_admin', '_api_delete_user', 0, 0, 1, 0, NULL, NULL, NULL, NULL, NULL),
(22, '/organization/member', 'organization', '_member', 0, 0, 0, 0, NULL, NULL, NULL, '1', NULL),
(23, '/api/monthly_dues', 'client_admin', '_test', 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `server_settings`
--

CREATE TABLE `server_settings` (
  `server_function` varchar(500) NOT NULL,
  `server_value` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `server_settings`
--

INSERT INTO `server_settings` (`server_function`, `server_value`) VALUES
('maintenance', 0),
('status', 0),
('lock', 0),
('gateway', 1),
('themer', 0),
('chat', 0);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(300) DEFAULT NULL,
  `name` char(50) DEFAULT NULL,
  `email` varchar(300) NOT NULL,
  `profile_picture` varchar(500) NOT NULL DEFAULT '/app-assets/images/biohazard--v1.png',
  `profile_banner` varchar(500) DEFAULT '/app-assets/images/gallery/profile-bg.png',
  `user_role` int(11) NOT NULL DEFAULT 20,
  `status` tinyint(11) NOT NULL DEFAULT 0,
  `last_login` datetime DEFAULT NULL,
  `secret_question` varchar(500) NOT NULL,
  `secret_answer` varchar(500) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `theme_id` int(11) NOT NULL DEFAULT 0,
  `template_setting` varchar(500) NOT NULL,
  `template_enable` int(11) NOT NULL DEFAULT 0,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `username`, `password`, `name`, `email`, `profile_picture`, `profile_banner`, `user_role`, `status`, `last_login`, `secret_question`, `secret_answer`, `branch_id`, `theme_id`, `template_setting`, `template_enable`, `date_created`) VALUES
(1, 'ripcris', 'LxeIEcqKRRwsENP6Av3t9A==', 'Vladimir Bargayo', 'ripcris10@gmail.com', '/app-assets/images/biohazard--v1.png', '/app-assets/images/gallery/profile-bg.png', 1, 0, NULL, '', '', 1, 0, 'menu_selection:normal,menu_collapsed:0,menu_color:gradient-green-teal,footer_color:gradient-green-teal,navebar_color:gradient-green-teal,sidebar_mode:sidenav-dark', 1, '2020-10-11 00:29:50'),
(2, 'member', 'LxeIEcqKRRwsENP6Av3t9A==', 'Karen Bukon', 'member@webdeveloper.com', '/app-assets/images/biohazard--v1.png', '/app-assets/images/gallery/profile-bg.png', 20, 0, NULL, '', '', 2, 0, '', 0, '2020-10-11 00:29:50'),
(5, 'admin', 'LxeIEcqKRRwsENP6Av3t9A==', 'Super Admin', 'Admin@webdeveloper.com', '/app-assets/images/biohazard--v1.png', '/app-assets/images/gallery/profile-bg.png', 1, 0, '2020-10-06 00:00:00', '', '', 1, 0, '', 0, '2020-10-11 00:29:50'),
(6, 'admin1', 'LxeIEcqKRRwsENP6Av3t9A==', 'Admin Vladimir', 'admin1@gmail.com', '/app-assets/images/biohazard--v1.png', '/app-assets/images/gallery/profile-bg.png', 1, 0, NULL, '', '', 1, 0, '', 0, '2020-10-11 00:29:50'),
(7, 'admin2', 'LxeIEcqKRRwsENP6Av3t9A==', 'Admin Vladimir', 'admin2@gmail.com', '/app-assets/images/biohazard--v1.png', '/app-assets/images/gallery/profile-bg.png', 1, 0, NULL, '', '', 1, 0, '', 0, '2020-10-11 00:29:50'),
(8, 'admin3', 'LxeIEcqKRRwsENP6Av3t9A==', 'Admin Vladimir', 'admin3@gmail.com', '/app-assets/images/biohazard--v1.png', '/app-assets/images/gallery/profile-bg.png', 1, 0, NULL, '', '', 1, 0, '', 0, '2020-10-11 00:29:50'),
(9, 'admin4', 'LxeIEcqKRRwsENP6Av3t9A==', 'Admin Vladimir', 'admin4@gmail.com', '/app-assets/images/biohazard--v1.png', '/app-assets/images/gallery/profile-bg.png', 1, 0, NULL, '', '', 1, 0, '', 0, '2020-10-11 00:29:50');

-- --------------------------------------------------------

--
-- Table structure for table `user_gateway`
--

CREATE TABLE `user_gateway` (
  `gateway_id` int(11) NOT NULL,
  `gateway_key` varchar(300) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `developer` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_gateway`
--

INSERT INTO `user_gateway` (`gateway_id`, `gateway_key`, `branch_id`, `developer`) VALUES
(1, 'LxeIEcqKRRwsENP6Av3t9A==', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_role`
--

CREATE TABLE `user_role` (
  `role_id` int(11) NOT NULL,
  `role_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_role`
--

INSERT INTO `user_role` (`role_id`, `role_name`) VALUES
(1, 'Admin'),
(20, 'Member');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `branch`
--
ALTER TABLE `branch`
  ADD PRIMARY KEY (`branch_id`);

--
-- Indexes for table `landholdings`
--
ALTER TABLE `landholdings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `landholding_crops`
--
ALTER TABLE `landholding_crops`
  ADD PRIMARY KEY (`crop_id`),
  ADD KEY `landholding_id` (`landholding_id`);

--
-- Indexes for table `login_history`
--
ALTER TABLE `login_history`
  ADD PRIMARY KEY (`activity_id`);

--
-- Indexes for table `monthly_dues`
--
ALTER TABLE `monthly_dues`
  ADD PRIMARY KEY (`id`),
  ADD KEY `member_id` (`member_id`),
  ADD KEY `dues_record_id` (`dues_record_id`);

--
-- Indexes for table `monthly_dues_record`
--
ALTER TABLE `monthly_dues_record`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `organization`
--
ALTER TABLE `organization`
  ADD PRIMARY KEY (`id`),
  ADD KEY `landholdings_id` (`landholdings_id`);

--
-- Indexes for table `organization_member`
--
ALTER TABLE `organization_member`
  ADD PRIMARY KEY (`id`),
  ADD KEY `organization_id` (`organization_id`),
  ADD KEY `position` (`position`);

--
-- Indexes for table `organization_member_position`
--
ALTER TABLE `organization_member_position`
  ADD PRIMARY KEY (`position_id`);

--
-- Indexes for table `payment_record`
--
ALTER TABLE `payment_record`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `member_id` (`member_id`);

--
-- Indexes for table `redirect`
--
ALTER TABLE `redirect`
  ADD PRIMARY KEY (`redirect_id`);

--
-- Indexes for table `routes`
--
ALTER TABLE `routes`
  ADD PRIMARY KEY (`route_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `branch_id` (`branch_id`),
  ADD KEY `user_role` (`user_role`);

--
-- Indexes for table `user_gateway`
--
ALTER TABLE `user_gateway`
  ADD PRIMARY KEY (`gateway_id`),
  ADD KEY `branch` (`branch_id`);

--
-- Indexes for table `user_role`
--
ALTER TABLE `user_role`
  ADD PRIMARY KEY (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `branch`
--
ALTER TABLE `branch`
  MODIFY `branch_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `landholdings`
--
ALTER TABLE `landholdings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `landholding_crops`
--
ALTER TABLE `landholding_crops`
  MODIFY `crop_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `login_history`
--
ALTER TABLE `login_history`
  MODIFY `activity_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `monthly_dues`
--
ALTER TABLE `monthly_dues`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `monthly_dues_record`
--
ALTER TABLE `monthly_dues_record`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `organization`
--
ALTER TABLE `organization`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `organization_member`
--
ALTER TABLE `organization_member`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `organization_member_position`
--
ALTER TABLE `organization_member_position`
  MODIFY `position_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `payment_record`
--
ALTER TABLE `payment_record`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `redirect`
--
ALTER TABLE `redirect`
  MODIFY `redirect_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `routes`
--
ALTER TABLE `routes`
  MODIFY `route_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `user_gateway`
--
ALTER TABLE `user_gateway`
  MODIFY `gateway_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user_role`
--
ALTER TABLE `user_role`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `landholding_crops`
--
ALTER TABLE `landholding_crops`
  ADD CONSTRAINT `landholding_crops_ibfk_1` FOREIGN KEY (`landholding_id`) REFERENCES `landholdings` (`id`);

--
-- Constraints for table `monthly_dues`
--
ALTER TABLE `monthly_dues`
  ADD CONSTRAINT `monthly_dues_ibfk_1` FOREIGN KEY (`id`) REFERENCES `organization_member` (`id`),
  ADD CONSTRAINT `monthly_dues_ibfk_2` FOREIGN KEY (`dues_record_id`) REFERENCES `monthly_dues_record` (`id`);

--
-- Constraints for table `organization`
--
ALTER TABLE `organization`
  ADD CONSTRAINT `organization_ibfk_2` FOREIGN KEY (`landholdings_id`) REFERENCES `landholdings` (`id`);

--
-- Constraints for table `organization_member`
--
ALTER TABLE `organization_member`
  ADD CONSTRAINT `organization_member_ibfk_2` FOREIGN KEY (`organization_id`) REFERENCES `organization` (`id`),
  ADD CONSTRAINT `organization_member_ibfk_3` FOREIGN KEY (`position`) REFERENCES `organization_member_position` (`position_id`);

--
-- Constraints for table `payment_record`
--
ALTER TABLE `payment_record`
  ADD CONSTRAINT `payment_record_ibfk_1` FOREIGN KEY (`member_id`) REFERENCES `organization_member` (`id`);

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`branch_id`),
  ADD CONSTRAINT `user_ibfk_2` FOREIGN KEY (`user_role`) REFERENCES `user_role` (`role_id`);

--
-- Constraints for table `user_gateway`
--
ALTER TABLE `user_gateway`
  ADD CONSTRAINT `user_gateway_ibfk_1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`branch_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
