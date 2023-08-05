-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 03, 2023 at 12:26 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `jayga_db_1`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `admin_name` varchar(255) NOT NULL,
  `admin_pass` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `admin_name`, `admin_pass`) VALUES
(1, 'jayga_admin', 'jayga2023+');

-- --------------------------------------------------------

--
-- Table structure for table `amenities`
--

CREATE TABLE `amenities` (
  `listing_id` bigint(20) NOT NULL,
  `wifi` bigint(20) NOT NULL,
  `tv` bigint(20) NOT NULL,
  `kitchen` bigint(20) NOT NULL,
  `washer` bigint(20) NOT NULL,
  `free_parking` bigint(20) NOT NULL,
  `paid_parking` bigint(20) NOT NULL,
  `air_cond` bigint(20) NOT NULL,
  `dedicated_workspace` bigint(20) NOT NULL,
  `pool` bigint(20) NOT NULL,
  `hottub` bigint(20) NOT NULL,
  `patio` bigint(20) NOT NULL,
  `bbq_grill` bigint(20) NOT NULL,
  `outdoor_dining_area` bigint(20) NOT NULL,
  `fire_pit` bigint(20) NOT NULL,
  `gym` bigint(20) NOT NULL,
  `beach_access` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE `booking` (
  `booking_id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `listing_id` bigint(20) NOT NULL,
  `lister_id` bigint(20) NOT NULL,
  `time_flag` bigint(20) DEFAULT NULL,
  `time_id` bigint(20) NOT NULL,
  `all_day_flag` bigint(20) NOT NULL,
  `days_stayed` int(11) DEFAULT NULL,
  `date_enter` date NOT NULL,
  `date_exit` date NOT NULL,
  `pay_amount` bigint(20) NOT NULL,
  `payment_flag` bigint(20) NOT NULL,
  `api_stuff` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lister_dashboard`
--

CREATE TABLE `lister_dashboard` (
  `lister_id` bigint(20) NOT NULL,
  `earnings` bigint(20) NOT NULL,
  `past_booking` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lister_nid`
--

CREATE TABLE `lister_nid` (
  `listing_nid_id` bigint(20) NOT NULL,
  `lister_user_id` varchar(500) NOT NULL,
  `lister_nid_pic_name` varchar(500) NOT NULL,
  `listing_nid_pic_location` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lister_user`
--

CREATE TABLE `lister_user` (
  `lister_id` int(200) NOT NULL,
  `user_id` varchar(500) NOT NULL,
  `lister_name` varchar(500) NOT NULL,
  `lister_email` varchar(255) NOT NULL,
  `lister_phone_num` varchar(255) NOT NULL,
  `lister_nid` varchar(255) NOT NULL,
  `lister_dob` date NOT NULL,
  `lister_address` varchar(255) NOT NULL,
  `platform_tag` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `listing`
--

CREATE TABLE `listing` (
  `listing_id` bigint(200) NOT NULL,
  `lister_id` varchar(500) NOT NULL,
  `lister_name` varchar(500) NOT NULL,
  `guest_num` bigint(20) NOT NULL,
  `bed_num` bigint(20) NOT NULL,
  `bathroom_num` bigint(20) NOT NULL,
  `listing_title` varchar(255) NOT NULL,
  `listing_description` varchar(5000) NOT NULL,
  `full_day_price_set_by_user` bigint(20) NOT NULL,
  `listing_address` varchar(255) NOT NULL,
  `zip_code` bigint(20) NOT NULL,
  `district` varchar(255) NOT NULL,
  `town` varchar(255) NOT NULL,
  `allow_short_stay` int(20) NOT NULL,
  `describe_peaceful` bigint(20) NOT NULL,
  `describe_unique` bigint(20) NOT NULL,
  `describe_familyfriendly` bigint(20) NOT NULL,
  `describe_stylish` bigint(20) NOT NULL,
  `describe_central` bigint(20) NOT NULL,
  `describe_spacious` bigint(20) NOT NULL,
  `bathroom_private` bigint(20) NOT NULL,
  `breakfast_availability` bigint(20) NOT NULL,
  `room_lock` bigint(20) NOT NULL,
  `who_else_might_be_there` bigint(20) NOT NULL,
  `listing_type` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `listing_images`
--

CREATE TABLE `listing_images` (
  `listing_img_id` bigint(20) NOT NULL,
  `listing_id` varchar(500) NOT NULL,
  `lister_id` varchar(500) NOT NULL,
  `listing_filename` varchar(500) NOT NULL,
  `listing_targetlocation` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `restriction`
--

CREATE TABLE `restriction` (
  `listing_id` bigint(20) NOT NULL,
  `indoor_smoke` bigint(20) NOT NULL,
  `host_parties` bigint(20) NOT NULL,
  `pets` bigint(20) NOT NULL,
  `un_vaccinated` bigint(20) NOT NULL,
  `late_night_entry` bigint(20) NOT NULL,
  `unknown_guest` bigint(20) NOT NULL,
  `anything_specific` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `review`
--

CREATE TABLE `review` (
  `review_id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `user_name` bigint(20) NOT NULL,
  `lister_id` bigint(20) NOT NULL,
  `lister_name` bigint(20) NOT NULL,
  `stars` bigint(20) NOT NULL,
  `description` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `review_images`
--

CREATE TABLE `review_images` (
  `review_image_id` bigint(20) NOT NULL,
  `review_id` bigint(20) NOT NULL,
  `review_filename` bigint(20) NOT NULL,
  `review_targetlocation` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `safety_measure`
--

CREATE TABLE `safety_measure` (
  `listing_id` bigint(20) NOT NULL,
  `smoke_alarm` bigint(20) NOT NULL,
  `first_aid_kit` bigint(20) NOT NULL,
  `fire_extinguisher` bigint(20) NOT NULL,
  `CO_alarm` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `time_slot_shortstays`
--

CREATE TABLE `time_slot_shortstays` (
  `time_id` bigint(20) NOT NULL,
  `times` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` varchar(500) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_phone_num` bigint(20) NOT NULL,
  `user_nid` bigint(20) NOT NULL,
  `user_dob` date NOT NULL,
  `user_address` varchar(255) NOT NULL,
  `is_lister` bigint(20) DEFAULT NULL,
  `user_long` int(255) DEFAULT NULL,
  `user_lat` int(255) DEFAULT NULL,
  `platform_tag` int(20) NOT NULL DEFAULT 0 COMMENT '0 for web 1 for app',
  `FCM_token` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_nid`
--

CREATE TABLE `user_nid` (
  `user_nid_id` bigint(20) NOT NULL,
  `user_id` varchar(500) NOT NULL,
  `user_nid_filename` varchar(500) NOT NULL,
  `user_nid_targetlocation` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_pictures`
--

CREATE TABLE `user_pictures` (
  `user_picture_id` bigint(20) NOT NULL,
  `user_id` varchar(500) NOT NULL,
  `user_filename` varchar(500) NOT NULL,
  `user_targetlocation` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `amenities`
--
ALTER TABLE `amenities`
  ADD PRIMARY KEY (`listing_id`);

--
-- Indexes for table `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`booking_id`);

--
-- Indexes for table `lister_dashboard`
--
ALTER TABLE `lister_dashboard`
  ADD PRIMARY KEY (`lister_id`);

--
-- Indexes for table `lister_nid`
--
ALTER TABLE `lister_nid`
  ADD PRIMARY KEY (`listing_nid_id`);

--
-- Indexes for table `lister_user`
--
ALTER TABLE `lister_user`
  ADD PRIMARY KEY (`lister_id`);

--
-- Indexes for table `listing`
--
ALTER TABLE `listing`
  ADD PRIMARY KEY (`listing_id`);

--
-- Indexes for table `listing_images`
--
ALTER TABLE `listing_images`
  ADD PRIMARY KEY (`listing_img_id`);

--
-- Indexes for table `restriction`
--
ALTER TABLE `restriction`
  ADD PRIMARY KEY (`listing_id`);

--
-- Indexes for table `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`review_id`);

--
-- Indexes for table `review_images`
--
ALTER TABLE `review_images`
  ADD PRIMARY KEY (`review_image_id`);

--
-- Indexes for table `safety_measure`
--
ALTER TABLE `safety_measure`
  ADD PRIMARY KEY (`listing_id`);

--
-- Indexes for table `time_slot_shortstays`
--
ALTER TABLE `time_slot_shortstays`
  ADD PRIMARY KEY (`time_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `user_nid`
--
ALTER TABLE `user_nid`
  ADD PRIMARY KEY (`user_nid_id`);

--
-- Indexes for table `user_pictures`
--
ALTER TABLE `user_pictures`
  ADD PRIMARY KEY (`user_picture_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `amenities`
--
ALTER TABLE `amenities`
  MODIFY `listing_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `booking`
--
ALTER TABLE `booking`
  MODIFY `booking_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lister_dashboard`
--
ALTER TABLE `lister_dashboard`
  MODIFY `lister_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lister_nid`
--
ALTER TABLE `lister_nid`
  MODIFY `listing_nid_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- AUTO_INCREMENT for table `lister_user`
--
ALTER TABLE `lister_user`
  MODIFY `lister_id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT for table `listing`
--
ALTER TABLE `listing`
  MODIFY `listing_id` bigint(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `listing_images`
--
ALTER TABLE `listing_images`
  MODIFY `listing_img_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=126;

--
-- AUTO_INCREMENT for table `restriction`
--
ALTER TABLE `restriction`
  MODIFY `listing_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `review`
--
ALTER TABLE `review`
  MODIFY `review_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `review_images`
--
ALTER TABLE `review_images`
  MODIFY `review_image_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `safety_measure`
--
ALTER TABLE `safety_measure`
  MODIFY `listing_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `time_slot_shortstays`
--
ALTER TABLE `time_slot_shortstays`
  MODIFY `time_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_nid`
--
ALTER TABLE `user_nid`
  MODIFY `user_nid_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111;

--
-- AUTO_INCREMENT for table `user_pictures`
--
ALTER TABLE `user_pictures`
  MODIFY `user_picture_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
