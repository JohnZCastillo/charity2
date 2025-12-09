-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 22, 2025 at 02:00 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `charity`
--

-- --------------------------------------------------------

--
-- Table structure for table `about_contents`
--

CREATE TABLE `about_contents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `content` text DEFAULT NULL,
  `items` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`items`)),
  `image` varchar(255) DEFAULT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'text',
  `group` varchar(255) NOT NULL DEFAULT 'general',
  `order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `about_contents`
--

INSERT INTO `about_contents` (`id`, `title`, `content`, `items`, `image`, `type`, `group`, `order`, `created_at`, `updated_at`) VALUES
(1, 'Founding', 'The Missionary of Charity Brothers is an International Religious Family of Pontifical Rights. The Congregation was founded by St. Mother Teresa of Kolkata on September 10, 1946 with more than 100 countries served. The Missionary of Charity Brothers is under the active branch with 68 mission centers operating around the world.', NULL, '/storage/about_images/Q6ZlScrNrx7pmJBsZIsL3yrigy0NGosjgMlcBqol.jpg', 'text', 'general', 7, '2025-06-21 21:31:09', '2025-09-18 23:04:09'),
(3, 'Vision', 'A community of compassionate servants, loving and serving God in the distressing disguise of the poorest of the poor, both materially and spiritually, caring for the unwanted, the unloved and the lonely, recognizing 8n them and restoring to them the dignity as being made in the image and likeness of their creator.', NULL, NULL, 'text', 'vision_mission', 1, '2025-06-21 21:38:14', '2025-09-18 23:04:09'),
(4, 'Mission', 'Our particular mission is to labor for the salvation and sanctification of the poorest of the poor not only in slums but also all over the world whenever they maybe: the poor, abandoned, neglected, the homeless and those who have no one to care for them. The poorest of the poor, materially and spiritually, irrespective of life condition, creed or nationally; the hungry, the thirty, the naked, the homeless, the ignorant, the captives, the crippled, the sick and the dying, destitute, the unloved, the outcasts, all those who are rejected by human society, those who have lost faith and hope in life.', NULL, NULL, 'text', 'vision_mission', 5, '2025-06-21 21:38:34', '2025-09-18 23:04:09'),
(5, 'Home Care Program', 'Education Program\r\nEnroll teachable/educable children to SPED\r\nProvision of education material/toys\r\nField/Educational trips\r\nExposure to different learning fields\r\nHealth Program\r\nMedical\r\nProvision of needed medicines/maintenance medicines\r\nHospitalization\r\nDental\r\nProphylaxis\r\nNutrition\r\nNutrition build-up\r\nProvision of supplementary foods/vitamins\r\nProvision of Basic Needs and Home Care Living\r\nProvision of food, clothing, proper place for sleeping\r\nFacilities for hygiene\r\nSafe and secured environment\r\nRehabilitation Program\r\nPhysical Therapy\r\nOccupational Therapy\r\nSpeech and Language Therapy', NULL, NULL, 'list', 'programs', 11, '2025-06-21 21:39:17', '2025-09-18 23:04:09'),
(6, 'Spiritual Activities', 'Sacramental Rights\r\nBaptism\r\nReconciliation\r\nConfirmation\r\nHoly Eucharist\r\nBurial Services', NULL, NULL, 'list', 'spiritual_activities', 13, '2025-06-21 21:39:45', '2025-09-18 23:04:09'),
(7, 'Objectives', 'To provide temporary shelter to the abandoned special children until such time when they are able to be reunited with their familyor relatives, reintegrated to the community or referred to appropriate agency/ institutions. To provide long term care to special children who are declared abandoned To provide terminal care to abandoned children who have no family and no community to take and are left destitute and dying', NULL, NULL, 'text', 'vision_mission', 9, '2025-06-21 21:51:24', '2025-09-18 23:04:09'),
(8, 'Eligibility', 'Special Children age ranges from 6-12 years old\r\nNeglected and/or totally abandoned children\r\nChildren referred by government and non-government agencies\r\nHospitals with certification of abandonment\r\nMedical abstract and other necessary documents needed submission', NULL, NULL, 'list', 'eligibility', 17, '2025-06-21 22:00:47', '2025-09-18 23:04:10'),
(13, 'Philippine Chapter', 'In the Philippines, the International Missionary of Charity is registered with the Securities and Exchange Commission as Regional Servant of the Missionary Brothers of Charity, Inc., a non-stock, non-government organization. Following the footsteps of Mother Teresa, the Missionary of Charity Brothers continue to provide care and comfort through direct services to the identified poor. One of the residential facilities run by the institution is located in Cavite, the Bukal ng Kapayapaan Home for the Abandoned Special Children.', NULL, '/storage/about_images/t9Tq9etuLdQR0VwDayP7l2hvkIOLJMRGtV91ASto.jpg', 'text', 'general', 3, '2025-08-09 11:49:45', '2025-09-18 23:04:09'),
(15, 'Referral System', NULL, NULL, NULL, 'list', 'referral_system', 15, '2025-08-09 11:54:18', '2025-09-18 23:04:10'),
(16, 'Policies in our Organization', 'Please do not give anything to the children, without the Brother\'s/ Worker\'s permission\nPlease do not take pictures and videos especially the children\nPlease do not use cellphone while inside the ward\nPlease minimize noise; avoid screaming or shouting; set the volume of your sound at reasonable level\nPlease dress modestly\nPlease do not smoke within the presmises\nPlease avoid spending excessive time alone with child/ children away from others\nPlease avoid dating within premises', NULL, '/storage/about_images/u8nQTc79yDxIB0xaleTNqtCBSKxQWQjgvpeBybeQ.jpg', 'list', 'general', 19, '2025-08-09 11:56:54', '2025-09-18 23:07:43');

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `mobile` varchar(255) DEFAULT NULL,
  `status` enum('enabled','disabled') NOT NULL,
  `type` enum('donor','recipient') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id`, `code`, `name`, `email`, `mobile`, `status`, `type`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Brain Trust School', 'braintrustshool@gmail.com', '09754564512', 'enabled', 'donor', '2025-05-04 15:47:59', '2025-09-18 23:34:27'),
(4, 'R1', 'Jenny Javier', 'jennyjavier@gmail.com', 'N/A', 'enabled', 'recipient', '2025-05-04 16:21:13', '2025-05-04 16:21:13'),
(5, 'R2', 'Boy Entino', 'boyentino@gmail.com', 'N/A', 'disabled', 'recipient', '2025-05-04 16:22:03', '2025-05-04 16:22:03'),
(15, '1', 'The Good Guys Community Service', NULL, 'N/A', 'enabled', 'donor', '2025-09-18 23:54:58', '2025-09-18 23:54:58'),
(16, '2', 'Dhang Tormeros', 'bucalshinjen@gmail.com', '09754429037', 'enabled', 'donor', '2025-09-18 23:58:47', '2025-09-18 23:58:47'),
(17, 'R3', 'Apolonio Coliat', NULL, 'N/A', 'enabled', 'recipient', '2025-09-19 00:10:42', '2025-09-19 00:10:42'),
(19, NULL, 'Annhe Bucal', 'shin.annhe@gmail.com', '09754429037', 'enabled', 'donor', '2025-11-16 16:39:54', '2025-11-16 16:39:54');

-- --------------------------------------------------------

--
-- Table structure for table `activity_logs`
--

CREATE TABLE `activity_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `activity` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `activity_logs`
--

INSERT INTO `activity_logs` (`id`, `user_id`, `name`, `activity`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, 'Donated 1 pcs of Del monte Spaghetti Noodles to Jenny Javier', '2025-09-01 01:06:45', '2025-09-01 01:06:45'),
(2, 1, NULL, 'Donated 1 pcs of Olive Oil to Jenny Javier', '2025-09-01 01:06:45', '2025-09-01 01:06:45'),
(3, 1, NULL, 'Visited Dashboard.', '2025-09-01 01:09:35', '2025-09-01 01:09:35'),
(4, 1, NULL, 'Visited Editor page.', '2025-09-01 01:13:00', '2025-09-01 01:13:00'),
(5, 1, NULL, 'About section added.', '2025-09-01 01:13:11', '2025-09-01 01:13:11'),
(6, 1, NULL, 'Visited Editor page.', '2025-09-01 01:13:11', '2025-09-01 01:13:11'),
(7, 1, NULL, 'Visited Editor page.', '2025-09-01 01:13:48', '2025-09-01 01:13:48'),
(8, 1, NULL, 'Visited Editor page.', '2025-09-01 01:14:36', '2025-09-01 01:14:36'),
(9, 1, NULL, 'Visited Editor page.', '2025-09-01 01:15:02', '2025-09-01 01:15:02'),
(10, 1, NULL, 'About section element deleted.', '2025-09-01 01:15:19', '2025-09-01 01:15:19'),
(11, 1, NULL, 'Visited Editor page.', '2025-09-01 01:15:20', '2025-09-01 01:15:20'),
(12, 1, NULL, 'About section added.', '2025-09-01 01:16:04', '2025-09-01 01:16:04'),
(13, 1, NULL, 'Visited Editor page.', '2025-09-01 01:16:04', '2025-09-01 01:16:04'),
(14, 1, NULL, 'About section element deleted.', '2025-09-01 01:16:26', '2025-09-01 01:16:26'),
(15, 1, NULL, 'Visited Editor page.', '2025-09-01 01:16:29', '2025-09-01 01:16:29'),
(16, 1, NULL, 'Visited Editor page.', '2025-09-01 01:16:39', '2025-09-01 01:16:39'),
(17, 1, NULL, 'About section added.', '2025-09-01 01:17:05', '2025-09-01 01:17:05'),
(18, 1, NULL, 'Visited Editor page.', '2025-09-01 01:17:05', '2025-09-01 01:17:05'),
(19, 1, NULL, 'About section updated.', '2025-09-01 01:17:26', '2025-09-01 01:17:26'),
(20, 1, NULL, 'Visited Editor page.', '2025-09-01 01:17:28', '2025-09-01 01:17:28'),
(21, 1, NULL, 'Visited Editor page.', '2025-09-01 01:18:44', '2025-09-01 01:18:44'),
(22, 1, NULL, 'Visited Editor page.', '2025-09-01 01:18:52', '2025-09-01 01:18:52'),
(23, 1, NULL, 'Visited Editor page.', '2025-09-01 01:19:07', '2025-09-01 01:19:07'),
(24, 1, NULL, 'Visited Editor page.', '2025-09-01 01:19:47', '2025-09-01 01:19:47'),
(25, 1, NULL, 'Visited Editor page.', '2025-09-01 01:20:13', '2025-09-01 01:20:13'),
(26, 1, NULL, 'Visited Editor page.', '2025-09-01 01:20:32', '2025-09-01 01:20:32'),
(27, 1, NULL, 'About section added.', '2025-09-01 01:20:54', '2025-09-01 01:20:54'),
(28, 1, NULL, 'Visited Editor page.', '2025-09-01 01:20:55', '2025-09-01 01:20:55'),
(29, 1, NULL, 'About section element deleted.', '2025-09-01 01:21:20', '2025-09-01 01:21:20'),
(30, 1, NULL, 'Visited Editor page.', '2025-09-01 01:21:22', '2025-09-01 01:21:22'),
(31, 1, NULL, 'About section element deleted.', '2025-09-01 01:21:27', '2025-09-01 01:21:27'),
(32, 1, NULL, 'Visited Editor page.', '2025-09-01 01:21:29', '2025-09-01 01:21:29'),
(33, 1, NULL, 'About section added.', '2025-09-01 01:25:48', '2025-09-01 01:25:48'),
(34, 1, NULL, 'Visited Editor page.', '2025-09-01 01:25:49', '2025-09-01 01:25:49'),
(35, 1, NULL, 'About section added.', '2025-09-01 01:26:20', '2025-09-01 01:26:20'),
(36, 1, NULL, 'Visited Editor page.', '2025-09-01 01:26:20', '2025-09-01 01:26:20'),
(37, 1, NULL, 'About section updated.', '2025-09-01 01:26:42', '2025-09-01 01:26:42'),
(38, 1, NULL, 'Visited Editor page.', '2025-09-01 01:26:44', '2025-09-01 01:26:44'),
(39, 1, NULL, 'About section reordered.', '2025-09-01 01:30:31', '2025-09-01 01:30:31'),
(40, 1, NULL, 'About section reordered.', '2025-09-01 01:30:33', '2025-09-01 01:30:33'),
(41, 1, NULL, 'About section updated.', '2025-09-01 01:30:38', '2025-09-01 01:30:38'),
(42, 1, NULL, 'Visited Editor page.', '2025-09-01 01:30:40', '2025-09-01 01:30:40'),
(43, 1, NULL, 'Visited Editor page.', '2025-09-01 01:32:15', '2025-09-01 01:32:15'),
(44, 1, NULL, 'About section element deleted.', '2025-09-01 01:32:21', '2025-09-01 01:32:21'),
(45, 1, NULL, 'Visited Editor page.', '2025-09-01 01:32:23', '2025-09-01 01:32:23'),
(46, 1, NULL, 'Visited Editor page.', '2025-09-01 01:34:00', '2025-09-01 01:34:00'),
(47, 1, NULL, 'About section updated.', '2025-09-01 01:34:15', '2025-09-01 01:34:15'),
(48, 1, NULL, 'Visited Editor page.', '2025-09-01 01:34:16', '2025-09-01 01:34:16'),
(49, 1, NULL, 'About section element deleted.', '2025-09-01 01:34:32', '2025-09-01 01:34:32'),
(50, 1, NULL, 'Visited Editor page.', '2025-09-01 01:34:33', '2025-09-01 01:34:33'),
(51, 1, NULL, 'Visited Editor page.', '2025-09-01 01:34:43', '2025-09-01 01:34:43'),
(52, 1, NULL, 'Visited Editor page.', '2025-09-01 01:38:00', '2025-09-01 01:38:00'),
(53, 1, NULL, 'About section added.', '2025-09-01 01:38:21', '2025-09-01 01:38:21'),
(54, 1, NULL, 'Visited Editor page.', '2025-09-01 01:38:21', '2025-09-01 01:38:21'),
(55, 1, NULL, 'Visited Editor page.', '2025-09-01 01:39:34', '2025-09-01 01:39:34'),
(56, 1, NULL, 'Visited Editor page.', '2025-09-01 01:40:29', '2025-09-01 01:40:29'),
(57, 1, NULL, 'Visited Editor page.', '2025-09-01 01:41:15', '2025-09-01 01:41:15'),
(58, 1, NULL, 'Visited Editor page.', '2025-09-01 01:41:45', '2025-09-01 01:41:45'),
(59, 1, NULL, 'Visited Editor page.', '2025-09-01 01:49:47', '2025-09-01 01:49:47'),
(60, 1, NULL, 'Visited Dashboard.', '2025-09-01 01:49:53', '2025-09-01 01:49:53'),
(62, 1, NULL, 'Visited Dashboard.', '2025-09-01 02:38:35', '2025-09-01 02:38:35'),
(63, 1, NULL, 'Visited Editor page.', '2025-09-01 02:39:58', '2025-09-01 02:39:58'),
(64, 1, NULL, 'Visited Dashboard.', '2025-09-01 02:40:00', '2025-09-01 02:40:00'),
(65, 1, NULL, 'Visited Dashboard.', '2025-09-03 16:05:12', '2025-09-03 16:05:12'),
(66, 1, NULL, 'Visited Dashboard.', '2025-09-03 21:09:11', '2025-09-03 21:09:11'),
(67, 1, NULL, 'Visited Editor page.', '2025-09-03 21:09:40', '2025-09-03 21:09:40'),
(68, 1, NULL, 'About section element deleted.', '2025-09-03 21:09:47', '2025-09-03 21:09:47'),
(69, 1, NULL, 'Visited Editor page.', '2025-09-03 21:09:48', '2025-09-03 21:09:48'),
(70, 1, NULL, 'Visited Dashboard.', '2025-09-10 16:01:29', '2025-09-10 16:01:29'),
(72, 1, NULL, 'Visited Form Builder page.', '2025-09-10 16:08:11', '2025-09-10 16:08:11'),
(73, 1, NULL, 'Visited Editor page.', '2025-09-10 16:08:13', '2025-09-10 16:08:13'),
(74, 1, NULL, 'Visited Dashboard.', '2025-09-10 16:08:21', '2025-09-10 16:08:21'),
(75, 1, NULL, 'Visited Dashboard.', '2025-09-10 17:19:34', '2025-09-10 17:19:34'),
(76, 1, NULL, 'Visited Editor page.', '2025-09-10 17:19:37', '2025-09-10 17:19:37'),
(77, 1, NULL, 'Visited Dashboard.', '2025-09-10 19:03:04', '2025-09-10 19:03:04'),
(78, 1, NULL, 'Visited Dashboard.', '2025-09-10 21:13:34', '2025-09-10 21:13:34'),
(79, 1, NULL, 'Confirmed the donation of Kevin', '2025-09-10 21:25:40', '2025-09-10 21:25:40'),
(80, 1, NULL, 'Confirmed the donation of TESTING', '2025-09-10 21:25:56', '2025-09-10 21:25:56'),
(83, 1, NULL, 'Visited Dashboard.', '2025-09-10 21:38:35', '2025-09-10 21:38:35'),
(84, 1, NULL, 'Visited the Announcement list page.', '2025-09-10 21:38:38', '2025-09-10 21:38:38'),
(85, 1, NULL, 'Visited Inquiry page', '2025-09-10 21:38:40', '2025-09-10 21:38:40'),
(86, 1, NULL, 'Mark as read inquiry of Brain Trust School', '2025-09-10 21:38:42', '2025-09-10 21:38:42'),
(87, 1, NULL, 'Visited Inquiry page', '2025-09-10 21:38:42', '2025-09-10 21:38:42'),
(88, 1, NULL, 'Visited Dashboard.', '2025-09-10 21:38:46', '2025-09-10 21:38:46'),
(89, 1, NULL, 'Visited Inquiry page', '2025-09-11 05:44:50', '2025-09-11 05:44:50'),
(90, 1, NULL, 'Visited Dashboard.', '2025-09-11 11:45:31', '2025-09-11 11:45:31'),
(91, 1, NULL, 'Visited Dashboard.', '2025-09-11 11:49:52', '2025-09-11 11:49:52'),
(92, 1, NULL, 'Confirmed the GCash donation of Annhe Bucal', '2025-09-11 11:51:33', '2025-09-11 11:51:33'),
(93, 1, NULL, 'Confirmed the GCash donation of Annhe Bucal', '2025-09-11 11:54:26', '2025-09-11 11:54:26'),
(94, 1, NULL, 'Confirmed the GCash donation of Annhe Bucal', '2025-09-11 11:56:16', '2025-09-11 11:56:16'),
(95, 1, NULL, 'Visited Dashboard.', '2025-09-14 04:56:34', '2025-09-14 04:56:34'),
(96, 1, NULL, 'Set the donation drive titledMedical Supplies to unaccomplished', '2025-09-14 05:15:42', '2025-09-14 05:15:42'),
(97, 1, NULL, 'Set the donation drive titledMedical Supplies to accomplished', '2025-09-14 05:16:06', '2025-09-14 05:16:06'),
(98, 1, NULL, 'Visited Dashboard.', '2025-09-14 05:16:37', '2025-09-14 05:16:37'),
(99, 1, NULL, 'Visited Dashboard.', '2025-09-14 05:20:42', '2025-09-14 05:20:42'),
(100, 1, NULL, 'Visited Dashboard.', '2025-09-14 05:21:02', '2025-09-14 05:21:02'),
(101, 1, NULL, 'Visited Dashboard.', '2025-09-14 05:23:54', '2025-09-14 05:23:54'),
(102, 1, NULL, 'Visited Dashboard.', '2025-09-14 05:25:03', '2025-09-14 05:25:03'),
(103, 1, NULL, 'Visited Dashboard.', '2025-09-14 05:25:28', '2025-09-14 05:25:28'),
(104, 1, NULL, 'Visited Dashboard.', '2025-09-14 05:27:23', '2025-09-14 05:27:23'),
(105, 1, NULL, 'Visited Dashboard.', '2025-09-14 05:28:03', '2025-09-14 05:28:03'),
(106, 1, NULL, 'Visited Dashboard.', '2025-09-14 05:29:09', '2025-09-14 05:29:09'),
(107, 1, NULL, 'Visited Dashboard.', '2025-09-14 05:30:14', '2025-09-14 05:30:14'),
(108, 1, NULL, 'Visited Dashboard.', '2025-09-14 05:31:03', '2025-09-14 05:31:03'),
(109, 1, NULL, 'Visited Dashboard.', '2025-09-14 05:31:22', '2025-09-14 05:31:22'),
(110, 1, NULL, 'Visited Dashboard.', '2025-09-14 05:31:59', '2025-09-14 05:31:59'),
(111, 1, NULL, 'Visited Dashboard.', '2025-09-14 05:32:55', '2025-09-14 05:32:55'),
(112, 1, NULL, 'Visited Dashboard.', '2025-09-14 05:33:12', '2025-09-14 05:33:12'),
(113, 1, NULL, 'Visited Dashboard.', '2025-09-14 05:35:51', '2025-09-14 05:35:51'),
(114, 1, NULL, 'Visited Dashboard.', '2025-09-14 05:36:12', '2025-09-14 05:36:12'),
(115, 1, NULL, 'Visited Dashboard.', '2025-09-14 06:04:14', '2025-09-14 06:04:14'),
(116, 1, NULL, 'Visited Dashboard.', '2025-09-14 06:05:38', '2025-09-14 06:05:38'),
(117, 1, NULL, 'Visited Dashboard.', '2025-09-14 06:05:52', '2025-09-14 06:05:52'),
(118, 1, NULL, 'Visited Dashboard.', '2025-09-14 06:10:27', '2025-09-14 06:10:27'),
(119, 1, NULL, 'Visited Dashboard.', '2025-09-14 06:12:57', '2025-09-14 06:12:57'),
(120, 1, NULL, 'Visited Dashboard.', '2025-09-14 06:31:57', '2025-09-14 06:31:57'),
(121, 1, NULL, 'Set the donation drive titledMedical Supplies to unaccomplished', '2025-09-14 06:33:35', '2025-09-14 06:33:35'),
(122, 1, NULL, 'Set the donation drive titledMedical Supplies to accomplished', '2025-09-14 06:33:38', '2025-09-14 06:33:38'),
(123, 1, NULL, 'Visited Dashboard.', '2025-09-14 06:33:59', '2025-09-14 06:33:59'),
(124, 1, NULL, 'Visited Dashboard.', '2025-09-14 06:34:24', '2025-09-14 06:34:24'),
(125, 1, NULL, 'Visited Dashboard.', '2025-09-14 06:37:37', '2025-09-14 06:37:37'),
(126, 1, NULL, 'Visited Dashboard.', '2025-09-14 06:39:13', '2025-09-14 06:39:13'),
(127, 1, NULL, 'Set the donation drive titledMedical Supplies to unaccomplished', '2025-09-14 06:39:31', '2025-09-14 06:39:31'),
(128, 1, NULL, 'Set the donation drive titledMedical Supplies to accomplished', '2025-09-14 06:39:34', '2025-09-14 06:39:34'),
(129, 1, NULL, 'Visited Dashboard.', '2025-09-14 06:39:57', '2025-09-14 06:39:57'),
(130, 1, NULL, 'Visited Dashboard.', '2025-09-14 06:40:27', '2025-09-14 06:40:27'),
(131, 1, NULL, 'Set the donation drive titledMedical Supplies to unaccomplished', '2025-09-14 06:41:18', '2025-09-14 06:41:18'),
(132, 1, NULL, 'Set the donation drive titledMedical Supplies to accomplished', '2025-09-14 06:41:20', '2025-09-14 06:41:20'),
(133, 1, NULL, 'Visited Dashboard.', '2025-09-14 06:41:39', '2025-09-14 06:41:39'),
(134, 1, NULL, 'Visited Dashboard.', '2025-09-14 06:42:18', '2025-09-14 06:42:18'),
(135, 1, NULL, 'Visited Dashboard.', '2025-09-18 21:06:34', '2025-09-18 21:06:34'),
(136, 1, NULL, 'Visited Dashboard.', '2025-09-18 21:29:26', '2025-09-18 21:29:26'),
(137, 1, NULL, 'Visited the Announcement list page.', '2025-09-18 22:32:01', '2025-09-18 22:32:01'),
(138, 1, NULL, 'Visited Inquiry page', '2025-09-18 22:32:03', '2025-09-18 22:32:03'),
(139, 1, NULL, 'Visited the Announcement list page.', '2025-09-18 22:32:04', '2025-09-18 22:32:04'),
(140, 1, NULL, 'Deleted an Announcement  page.', '2025-09-18 22:32:09', '2025-09-18 22:32:09'),
(141, 1, NULL, 'Visited the Announcement list page.', '2025-09-18 22:32:09', '2025-09-18 22:32:09'),
(142, 1, NULL, 'Deleted an Announcement  page.', '2025-09-18 22:32:13', '2025-09-18 22:32:13'),
(143, 1, NULL, 'Visited the Announcement list page.', '2025-09-18 22:32:13', '2025-09-18 22:32:13'),
(144, 1, NULL, 'Deleted an Announcement  page.', '2025-09-18 22:32:17', '2025-09-18 22:32:17'),
(145, 1, NULL, 'Visited the Announcement list page.', '2025-09-18 22:32:17', '2025-09-18 22:32:17'),
(146, 1, NULL, 'Visited Inquiry page', '2025-09-18 22:32:19', '2025-09-18 22:32:19'),
(147, 1, NULL, 'Visited Form Builder page.', '2025-09-18 22:32:38', '2025-09-18 22:32:38'),
(148, 1, NULL, 'Visited Dashboard.', '2025-09-18 22:32:42', '2025-09-18 22:32:42'),
(149, 1, NULL, 'Visited Dashboard.', '2025-09-18 22:48:19', '2025-09-18 22:48:19'),
(150, 1, NULL, 'Visited Dashboard.', '2025-09-18 22:51:13', '2025-09-18 22:51:13'),
(151, 1, NULL, 'Visited the Announcement list page.', '2025-09-18 22:59:43', '2025-09-18 22:59:43'),
(152, 1, NULL, 'Visited Dashboard.', '2025-09-18 23:02:02', '2025-09-18 23:02:02'),
(153, 1, NULL, 'Visited Editor page.', '2025-09-18 23:02:04', '2025-09-18 23:02:04'),
(154, 1, NULL, 'Updated elements at Editor page.', '2025-09-18 23:02:53', '2025-09-18 23:02:53'),
(155, 1, NULL, 'Visited Editor page.', '2025-09-18 23:02:53', '2025-09-18 23:02:53'),
(156, 1, NULL, 'About section reordered.', '2025-09-18 23:04:10', '2025-09-18 23:04:10'),
(157, 1, NULL, 'About section updated.', '2025-09-18 23:07:43', '2025-09-18 23:07:43'),
(158, 1, NULL, 'Visited Editor page.', '2025-09-18 23:07:47', '2025-09-18 23:07:47'),
(159, 1, NULL, 'Updated elements at Editor page.', '2025-09-18 23:30:19', '2025-09-18 23:30:19'),
(160, 1, NULL, 'Visited Editor page.', '2025-09-18 23:30:20', '2025-09-18 23:30:20'),
(161, 1, NULL, 'Confirmed the GCash donation of Annhe Bucal', '2025-09-18 23:35:21', '2025-09-18 23:35:21'),
(162, 1, NULL, 'Confirmed the GCash donation of Brain Trust School', '2025-09-18 23:36:00', '2025-09-18 23:36:00'),
(163, 1, NULL, 'Set the donation drive titledHelp for the Poor to accomplished', '2025-09-18 23:36:18', '2025-09-18 23:36:18'),
(164, 1, NULL, 'Set the donation drive titledMedical Needs for abandoned Parents to accomplished', '2025-09-18 23:36:24', '2025-09-18 23:36:24'),
(165, 1, NULL, 'Visited Dashboard.', '2025-09-18 23:36:50', '2025-09-18 23:36:50'),
(166, 1, NULL, 'Visited Dashboard.', '2025-09-18 23:47:13', '2025-09-18 23:47:13'),
(167, 1, NULL, 'Visited the Announcement list page.', '2025-09-19 00:11:35', '2025-09-19 00:11:35'),
(168, 1, NULL, 'Viewed edit Announcement  page.', '2025-09-19 00:11:42', '2025-09-19 00:11:42'),
(169, 1, NULL, 'Visited the Announcement list page.', '2025-09-19 00:11:47', '2025-09-19 00:11:47'),
(170, 1, NULL, 'Visited the Create Announcement  page.', '2025-09-19 00:11:51', '2025-09-19 00:11:51'),
(171, 1, NULL, 'Uploaded File for Announcement.', '2025-09-19 00:17:09', '2025-09-19 00:17:09'),
(172, 1, NULL, 'Uploaded File for Announcement.', '2025-09-19 00:17:39', '2025-09-19 00:17:39'),
(173, 1, NULL, 'Created new Announcement  page.', '2025-09-19 00:17:47', '2025-09-19 00:17:47'),
(174, 1, NULL, 'Visited the Announcement list page.', '2025-09-19 00:17:48', '2025-09-19 00:17:48'),
(175, 1, NULL, 'Viewed edit Announcement  page.', '2025-09-19 00:18:05', '2025-09-19 00:18:05'),
(176, 1, NULL, 'Visited the Announcement list page.', '2025-09-19 00:18:09', '2025-09-19 00:18:09'),
(177, 1, NULL, 'Visited Inquiry page', '2025-09-19 00:18:11', '2025-09-19 00:18:11'),
(178, 1, NULL, 'Mark as read inquiry of Annhe Bucal', '2025-09-19 00:18:21', '2025-09-19 00:18:21'),
(179, 1, NULL, 'Visited Inquiry page', '2025-09-19 00:18:22', '2025-09-19 00:18:22'),
(180, 1, NULL, 'Confirmed the GCash donation of Michael Bucal', '2025-09-19 00:59:27', '2025-09-19 00:59:27'),
(181, 1, NULL, 'Confirmed the GCash donation of Annhe Bucal', '2025-09-19 01:00:36', '2025-09-19 01:00:36'),
(182, 1, NULL, 'Set the donation drive titledHelp for the Poor to unaccomplished', '2025-09-19 01:00:58', '2025-09-19 01:00:58'),
(183, 1, NULL, 'Set the donation drive titledMedical Needs for abandoned Parents to unaccomplished', '2025-09-19 01:01:02', '2025-09-19 01:01:02'),
(184, 1, NULL, 'Visited Editor page.', '2025-09-19 01:02:07', '2025-09-19 01:02:07'),
(185, 1, NULL, 'Visited Form Builder page.', '2025-09-19 01:03:14', '2025-09-19 01:03:14'),
(186, 1, NULL, 'Visited Create Form page.', '2025-09-19 01:03:17', '2025-09-19 01:03:17'),
(187, 1, NULL, 'Created new form, A Little Love for a little one: Registration', '2025-09-19 01:06:59', '2025-09-19 01:06:59'),
(188, 1, NULL, 'Visited Form Builder page.', '2025-09-19 01:07:00', '2025-09-19 01:07:00'),
(189, 1, NULL, 'Viewed a form.', '2025-09-19 01:07:04', '2025-09-19 01:07:04'),
(190, 1, NULL, 'Viewed a form.', '2025-09-19 01:07:09', '2025-09-19 01:07:09'),
(191, 1, NULL, 'Viewed edit form, A Little Love for a little one: Registration', '2025-09-19 01:10:17', '2025-09-19 01:10:17'),
(192, 1, NULL, 'Updated the form.A Little Love for a little one: Registration', '2025-09-19 01:10:33', '2025-09-19 01:10:33'),
(193, 1, NULL, 'Visited Form Builder page.', '2025-09-19 01:10:33', '2025-09-19 01:10:33'),
(194, 1, NULL, 'Viewed a form.', '2025-09-19 01:11:13', '2025-09-19 01:11:13'),
(195, 1, NULL, 'Viewed edit form, A Little Love for a little one: Registration', '2025-09-19 01:11:16', '2025-09-19 01:11:16'),
(196, 1, NULL, 'Updated the form.A Little Love for a little one: Registration', '2025-09-19 01:11:23', '2025-09-19 01:11:23'),
(197, 1, NULL, 'Visited Form Builder page.', '2025-09-19 01:11:24', '2025-09-19 01:11:24'),
(198, 1, NULL, 'Viewed a form.', '2025-09-19 01:11:45', '2025-09-19 01:11:45'),
(199, 1, NULL, 'Deleted a form.', '2025-09-19 01:11:49', '2025-09-19 01:11:49'),
(200, 1, NULL, 'Visited Form Builder page.', '2025-09-19 01:11:50', '2025-09-19 01:11:50'),
(201, 1, NULL, 'Visited Form Builder page.', '2025-09-19 01:11:55', '2025-09-19 01:11:55'),
(202, 1, NULL, 'Visited Create Form page.', '2025-09-19 01:11:59', '2025-09-19 01:11:59'),
(203, 1, NULL, 'Created new form, A Little love for a little one', '2025-09-19 01:14:03', '2025-09-19 01:14:03'),
(204, 1, NULL, 'Visited Form Builder page.', '2025-09-19 01:14:03', '2025-09-19 01:14:03'),
(205, 1, NULL, 'Viewed a form.', '2025-09-19 01:14:06', '2025-09-19 01:14:06'),
(206, 1, NULL, 'Viewed a form.', '2025-09-19 01:14:43', '2025-09-19 01:14:43'),
(207, 1, NULL, 'Viewed Form Responses.', '2025-09-19 01:14:45', '2025-09-19 01:14:45'),
(208, 1, NULL, 'Visited Form Builder page.', '2025-09-19 01:14:53', '2025-09-19 01:14:53'),
(209, 4, NULL, 'Visited Dashboard.', '2025-09-19 01:15:26', '2025-09-19 01:15:26'),
(210, 4, NULL, 'Donated 10 pcs of Biogesic to Apolonio Coliat', '2025-09-19 01:16:11', '2025-09-19 01:16:11'),
(211, 4, NULL, 'Donated 5 pcs of Lucky Me Instant Noodles Chicken to Apolonio Coliat', '2025-09-19 01:16:11', '2025-09-19 01:16:11'),
(212, 4, NULL, 'Visited Dashboard.', '2025-09-19 01:16:45', '2025-09-19 01:16:45'),
(213, 4, NULL, 'Visited Dashboard.', '2025-09-19 01:17:06', '2025-09-19 01:17:06'),
(214, 1, NULL, 'Visited Dashboard.', '2025-11-08 00:10:59', '2025-11-08 00:10:59'),
(215, 1, NULL, 'Visited Dashboard.', '2025-11-08 00:11:35', '2025-11-08 00:11:35'),
(216, 1, NULL, 'Visited Dashboard.', '2025-11-08 00:11:42', '2025-11-08 00:11:42'),
(217, 1, NULL, 'Visited Dashboard.', '2025-11-08 00:19:08', '2025-11-08 00:19:08'),
(218, 1, NULL, 'Visited Dashboard.', '2025-11-08 00:21:13', '2025-11-08 00:21:13'),
(219, 1, NULL, 'Visited Dashboard.', '2025-11-08 00:21:35', '2025-11-08 00:21:35'),
(220, 1, NULL, 'Visited Dashboard.', '2025-11-08 00:26:46', '2025-11-08 00:26:46'),
(221, 1, NULL, 'Visited Dashboard.', '2025-11-08 00:26:59', '2025-11-08 00:26:59'),
(222, 1, NULL, 'Visited the Announcement list page.', '2025-11-08 00:33:35', '2025-11-08 00:33:35'),
(223, 1, NULL, 'Visited Dashboard.', '2025-11-12 21:30:45', '2025-11-12 21:30:45'),
(224, 1, NULL, 'Visited Dashboard.', '2025-11-16 15:43:42', '2025-11-16 15:43:42'),
(225, 1, NULL, 'Visited Dashboard.', '2025-11-16 15:48:25', '2025-11-16 15:48:25'),
(226, 1, NULL, 'Visited Inquiry page', '2025-11-16 15:48:44', '2025-11-16 15:48:44'),
(227, 1, NULL, 'Visited Editor page.', '2025-11-16 15:49:12', '2025-11-16 15:49:12'),
(228, 1, NULL, 'Visited Dashboard.', '2025-11-16 15:50:53', '2025-11-16 15:50:53'),
(229, 1, NULL, 'Visited Dashboard.', '2025-11-16 16:05:46', '2025-11-16 16:05:46'),
(230, 1, NULL, 'Visited Dashboard.', '2025-11-16 16:08:00', '2025-11-16 16:08:00'),
(231, 1, NULL, 'Visited Dashboard.', '2025-11-16 16:10:56', '2025-11-16 16:10:56'),
(232, 1, NULL, 'Visited Dashboard.', '2025-11-16 16:14:07', '2025-11-16 16:14:07'),
(233, 1, NULL, 'Visited Inquiry page', '2025-11-16 16:16:54', '2025-11-16 16:16:54'),
(234, 1, NULL, 'Visited the Announcement list page.', '2025-11-16 16:16:56', '2025-11-16 16:16:56'),
(235, 1, NULL, 'Visited Dashboard.', '2025-11-16 16:40:59', '2025-11-16 16:40:59'),
(236, 1, NULL, 'Visited Dashboard.', '2025-11-16 16:41:16', '2025-11-16 16:41:16'),
(237, 1, NULL, 'Visited Dashboard.', '2025-11-16 23:23:07', '2025-11-16 23:23:07'),
(238, 1, NULL, 'Visited Dashboard.', '2025-11-22 03:49:34', '2025-11-22 03:49:34'),
(239, 1, NULL, 'Visited Dashboard.', '2025-11-22 04:17:47', '2025-11-22 04:17:47'),
(240, 1, NULL, 'Visited the Announcement list page.', '2025-11-22 04:20:16', '2025-11-22 04:20:16'),
(241, 1, NULL, 'Visited Dashboard.', '2025-11-22 04:26:10', '2025-11-22 04:26:10'),
(242, 1, NULL, 'Visited the Announcement list page.', '2025-11-22 04:31:30', '2025-11-22 04:31:30'),
(243, 1, NULL, 'Visited the Create Announcement  page.', '2025-11-22 04:31:39', '2025-11-22 04:31:39'),
(244, 1, NULL, 'Created new Announcement  page.', '2025-11-22 04:32:24', '2025-11-22 04:32:24'),
(245, 1, NULL, 'Visited the Announcement list page.', '2025-11-22 04:32:25', '2025-11-22 04:32:25'),
(246, 1, NULL, 'Set the donation drive titledHelp for the Poor to accomplished', '2025-11-22 04:33:48', '2025-11-22 04:33:48'),
(247, 1, NULL, 'Visited Inquiry page', '2025-11-22 04:39:46', '2025-11-22 04:39:46'),
(248, 1, NULL, 'Visited Dashboard.', '2025-11-22 04:43:03', '2025-11-22 04:43:03');

-- --------------------------------------------------------

--
-- Table structure for table `addresses`
--

CREATE TABLE `addresses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `address` varchar(255) NOT NULL,
  `account_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `addresses`
--

INSERT INTO `addresses` (`id`, `address`, `account_id`, `created_at`, `updated_at`) VALUES
(1, 'N/A', 1, '2025-05-04 15:47:59', '2025-08-17 19:19:53'),
(4, 'N/A', 4, '2025-05-04 16:21:13', '2025-05-04 16:21:13'),
(5, 'N/A', 5, '2025-05-04 16:22:03', '2025-09-18 23:56:10'),
(12, 'N/A', 15, '2025-09-18 23:54:58', '2025-09-18 23:54:58'),
(13, '134A, Indang Road, Barangay Luciano, Trece Martires City, Cavite', 16, '2025-09-18 23:58:47', '2025-09-18 23:58:47'),
(14, 'N/A', 17, '2025-09-19 00:10:42', '2025-09-19 00:10:42'),
(15, 'N/A', 19, '2025-11-16 16:39:54', '2025-11-16 16:39:54');

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

CREATE TABLE `announcements` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `archived` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `announcements`
--

INSERT INTO `announcements` (`id`, `title`, `content`, `user_id`, `archived`, `created_at`, `updated_at`) VALUES
(2, 'Homelessness Support Drive', '<h2><span style=\"color: rgb(57, 65, 70); background-color: rgb(255, 255, 255);\">Create care packages for individuals experiencing homelessness, including essential items such as blankets, socks, non-perishable food items, hygiene products, and gift cards for meals or necessities..</span></h2><p><img src=\"/storage/FyhMUwj0PcIkEdAuk7SDOAOJwt7LPTZIMcq1f5oh.jpg\" style=\"display: block; margin: auto; width: 40%;\"></p><h2><span class=\"ql-size-large\" style=\"background-color: rgb(255, 255, 255); color: rgb(57, 65, 70);\">﻿</span></h2>', 1, 0, '2025-05-04 16:24:28', '2025-08-29 23:06:25'),
(8, 'Sending Love to Everyone', '<p>You can donate any kind of goods, supplies, clothes, medical kits o any amount of cash to help and to give it to everyone who don\'t have their own ways to get it. Every donations will be appreciate by us and also by the one who will receive it.</p><p></p><p><img src=\"/storage/e7DzMrfTfmflsG5ZAXFvQ0t0jgat4xrd7t7es4Dl.jpg\" style=\"display: block; margin: auto;\"></p>', 1, 0, '2025-09-19 00:17:47', '2025-09-19 00:17:47'),
(9, 'Christmas Party', '<p>yhbujhu</p>', 1, 0, '2025-11-22 04:32:24', '2025-11-22 04:32:24');

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `contact` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `type` enum('visit','meeting','asking for help','donation') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `date` date NOT NULL,
  `start` time NOT NULL,
  `end` time NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`id`, `name`, `email`, `contact`, `message`, `type`, `created_at`, `updated_at`, `date`, `start`, `end`, `status`) VALUES
(1, 'Jenny Javier', 'jennyjavier@gmail.com', '09754429037', 'I wish to get appointment to ask for some help', 'asking for help', '2025-05-04 16:27:39', '2025-09-19 00:57:44', '2025-05-22', '09:00:00', '10:00:00', 'undone'),
(4, 'Annhe Bucal', 'shin.annhe@gmail.com', '09754429037', 'I wish to get some time to discuss with you about the activities I wanted to conduct with you and the children', 'meeting', '2025-09-18 23:38:16', '2025-09-19 00:57:59', '2025-09-27', '08:00:00', '11:00:00', 'rescheduled'),
(5, 'Jenny Javier', 'jennyjavier@gmail.com', '09754429037', 'Hoping to get a chance to visit your site and to get bond with the children', 'visit', '2025-09-18 23:40:13', '2025-09-19 00:58:03', '2025-09-30', '14:00:00', '15:00:00', 'done'),
(6, 'Orm Ling', 'ormling@gmail.com', '09754423948', 'I hope you can help me with some medical supplies I need for my parents', 'asking for help', '2025-09-18 23:41:36', '2025-09-19 00:58:08', '2025-10-07', '11:00:00', '13:00:00', 'done'),
(7, 'Brain Trust School', 'braintrustshool@gmail.com', '09754423948', 'Hope to get chance to visit your site and give you some kind of goods and supplies', 'donation', '2025-09-18 23:42:41', '2025-09-19 00:58:10', '2025-10-10', '14:00:00', '15:00:00', 'undone');

-- --------------------------------------------------------

--
-- Table structure for table `appointment_slots`
--

CREATE TABLE `appointment_slots` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `capacity` int(11) NOT NULL,
  `type` enum('am','pm') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `appointment_slot_settings`
--

CREATE TABLE `appointment_slot_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `start` time NOT NULL,
  `end` time NOT NULL,
  `availability` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `block_appointment_slots`
--

CREATE TABLE `block_appointment_slots` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `block_appointment_slots`
--

INSERT INTO `block_appointment_slots` (`id`, `date`, `created_at`, `updated_at`) VALUES
(1, '2025-05-23', '2025-05-04 16:26:12', '2025-05-04 16:26:12'),
(2, '2025-05-14', '2025-05-04 16:26:26', '2025-05-04 16:26:26');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `certificate_templates`
--

CREATE TABLE `certificate_templates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `background_image` varchar(255) NOT NULL,
  `fields` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`fields`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `donations`
--

CREATE TABLE `donations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  `item_id` bigint(20) UNSIGNED NOT NULL,
  `recipient_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `donations`
--

INSERT INTO `donations` (`id`, `quantity`, `item_id`, `recipient_id`, `created_at`, `updated_at`) VALUES
(6, 10, 15, 17, '2025-09-19 01:16:11', '2025-09-19 01:16:11'),
(7, 5, 18, 17, '2025-09-19 01:16:11', '2025-09-19 01:16:11');

-- --------------------------------------------------------

--
-- Table structure for table `donation_drives`
--

CREATE TABLE `donation_drives` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `goal` double NOT NULL,
  `image` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `archived` tinyint(1) NOT NULL DEFAULT 0,
  `status` enum('accomplished','unaccomplished') NOT NULL DEFAULT 'unaccomplished'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `donation_drives`
--

INSERT INTO `donation_drives` (`id`, `title`, `goal`, `image`, `created_at`, `updated_at`, `archived`, `status`) VALUES
(3, 'Help for the Poor', 50000, 'public/UHbufKktx3c23vw9T0wgKKfq2wZr96MpXQVbFK2g.jpg', '2025-09-18 23:32:05', '2025-11-22 04:33:48', 0, 'accomplished'),
(4, 'Medical Needs for abandoned Parents', 10000, 'public/FITqvhprqRqFXBoHkdz1YGDgj3K9haTtWSGD5HHE.jpg', '2025-09-18 23:33:02', '2025-09-19 01:01:02', 0, 'unaccomplished');

-- --------------------------------------------------------

--
-- Table structure for table `donation_drive_data`
--

CREATE TABLE `donation_drive_data` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `from` varchar(255) DEFAULT NULL,
  `amount` double NOT NULL,
  `donation_drive_id` bigint(20) UNSIGNED NOT NULL,
  `confirmed` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `receipt` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `type` enum('gcash','cash') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `donation_drive_data`
--

INSERT INTO `donation_drive_data` (`id`, `from`, `amount`, `donation_drive_id`, `confirmed`, `created_at`, `updated_at`, `receipt`, `email`, `type`) VALUES
(15, 'Annhe Bucal', 500, 3, 1, '2025-09-18 23:33:31', '2025-09-18 23:35:21', NULL, 'shin.annhe@gmail.com', 'gcash'),
(16, 'Brain Trust School', 1000, 4, 1, '2025-09-18 23:34:27', '2025-09-18 23:36:00', NULL, 'braintrustshool@gmail.com', 'gcash'),
(17, 'Michael Bucal', 500, 3, 1, '2025-09-19 00:59:15', '2025-09-19 00:59:27', 'public/TjFWOfiOB5i6NGZ3xva0p8QJXA9nGq59VUuJjFnk.jpg', NULL, 'cash'),
(18, 'Annhe Bucal', 2000, 4, 1, '2025-09-19 01:00:28', '2025-09-19 01:00:36', 'public/gr9daiWPBdvnpSrphkXen1QjZUEXeEa7WcnsZ52q.jpg', 'bucalshinjen@gmail.com', 'gcash'),
(19, 'Annhe Bucal', 100, 3, 0, '2025-11-16 16:39:54', '2025-11-16 16:39:54', NULL, 'shin.annhe@gmail.com', 'gcash');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `location` varchar(255) NOT NULL,
  `start` datetime NOT NULL,
  `end` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `title`, `description`, `location`, `start`, `end`, `created_at`, `updated_at`) VALUES
(1, 'Mental Health Awareness', 'Raise awareness about mental health issues and reduce stigma by hosting events or workshops focused on mental wellness. Collect resources such as self-help books, stress-relief items, information about local counseling services, mindfulness journals, relaxation CDs, coloring books, fidget toys, aromatherapy products, and meditation guides.', 'Cabuco, Trece Martires City', '2025-07-23 08:30:00', '2025-07-23 17:00:00', '2025-05-04 16:35:49', '2025-05-04 16:35:49'),
(2, 'Give Love Everyday', 'Bukal ng Kapayapaan: Home for the Special Children conduct an activity for the residents of Barangay Luciano, Trece Martires City, Cavite', 'Luciano, Trece Martires City, Cavite', '2025-09-19 10:00:00', '2025-09-19 15:30:00', '2025-09-19 00:25:43', '2025-09-19 00:25:43');

-- --------------------------------------------------------

--
-- Table structure for table `event_images`
--

CREATE TABLE `event_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `path` varchar(255) NOT NULL,
  `event_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `event_images`
--

INSERT INTO `event_images` (`id`, `path`, `event_id`, `created_at`, `updated_at`) VALUES
(1, 'public/5AXIOZARZNHZPlxIaRVpMNefI0FBXuuTYskeb7zI.webp', 1, '2025-05-04 16:35:49', '2025-05-04 16:35:49'),
(2, 'public/Nqfsm2LlIhINjJKQPh5I5mlRBUdTX8Kzx8sWAMt3.webp', 1, '2025-08-29 23:28:02', '2025-08-29 23:28:02'),
(3, 'public/0RsmrMfW9MQwXjNsmcQsslcL8SVW398w9ST8JlNC.jpg', 2, '2025-09-19 00:25:43', '2025-09-19 00:25:43'),
(5, 'public/DZk3pdnBeDiZjn0f0d0JxrLFYUwTA9BNOVEZHFl0.jpg', 2, '2025-09-19 00:27:19', '2025-09-19 00:27:19');

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `amount` double NOT NULL,
  `purpose` varchar(255) NOT NULL,
  `receipt` varchar(255) DEFAULT NULL,
  `type` enum('donate','expense') NOT NULL,
  `account_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `forms`
--

CREATE TABLE `forms` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `structure` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`structure`)),
  `response_limit` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `forms`
--

INSERT INTO `forms` (`id`, `title`, `structure`, `response_limit`, `created_at`, `updated_at`) VALUES
(24, 'Sending Love Charity', '[{\"id\":0,\"type\":\"text\",\"label\":\"Full Name\",\"options\":[],\"required\":false,\"maxSize\":null},{\"id\":2,\"type\":\"radio\",\"label\":\"Age\",\"options\":[\"13-17\",\"18-25\",\"26-30\"],\"required\":false,\"maxSize\":null},{\"id\":3,\"type\":\"checkbox\",\"label\":\"\",\"options\":[\"\"],\"required\":false,\"maxSize\":null},{\"id\":4,\"type\":\"select\",\"label\":\"\",\"options\":[\"13-17\",\"18-25\",\"26-30\"],\"required\":false,\"maxSize\":null}]', NULL, '2025-08-17 16:33:11', '2025-08-17 16:33:11'),
(27, 'A Little love for a little one', '[{\"id\":0,\"type\":\"text\",\"label\":\"Full Name\",\"options\":[],\"required\":false,\"maxSize\":null},{\"id\":1,\"type\":\"radio\",\"label\":\"Age\",\"options\":[\"15-20\",\"20-25\",\"26 and above\"],\"required\":false,\"maxSize\":null},{\"id\":2,\"type\":\"checkbox\",\"label\":\"Nationality\",\"options\":[\"Filipino\",\"Nigerian\",\"American\",\"Japanese\"],\"required\":true,\"maxSize\":null},{\"id\":3,\"type\":\"select\",\"label\":\"Status\",\"options\":[\"Single\",\"Widow\",\"Married\",\"Seperate\"],\"required\":true,\"maxSize\":null}]', NULL, '2025-09-19 01:14:03', '2025-09-19 01:14:03');

-- --------------------------------------------------------

--
-- Table structure for table `form_responses`
--

CREATE TABLE `form_responses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `form_id` bigint(20) UNSIGNED NOT NULL,
  `response` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`response`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `form_responses`
--

INSERT INTO `form_responses` (`id`, `form_id`, `response`, `created_at`, `updated_at`) VALUES
(9, 10, '{\"Upload Image\":\"forms\\/testing\\/1751529459_COVER-PHOTO-2024-Deped-1.jpg\",\"AA\":\"A\"}', '2025-07-02 23:57:39', '2025-07-02 23:57:39'),
(10, 10, '{\"Upload Image\":\"forms\\/testing\\/1751529559_Picture1.png\",\"AA\":\"B\"}', '2025-07-02 23:59:19', '2025-07-02 23:59:19'),
(11, 10, '{\"Upload Image\":\"forms\\/testing\\/1751529559_Picture1.png\",\"AA\":\"B\"}', '2025-07-02 23:59:19', '2025-07-02 23:59:19'),
(12, 10, '{\"Upload Image\":\"forms\\/testing\\/1751529567_matatag.png\",\"AA\":\"A\"}', '2025-07-02 23:59:27', '2025-07-02 23:59:27'),
(13, 13, '{\"NAME\":\"K\",\"LETTERS\":[\"D\"],\"AGE\":\"5\",\"Checkboxes\":[\"2\"]}', '2025-07-03 22:18:45', '2025-07-03 22:18:45'),
(14, 13, '{\"NAME\":\"B\",\"LETTERS\":[\"B\"],\"AGE\":\"100\",\"Checkboxes\":[\"4\"]}', '2025-07-03 22:19:01', '2025-07-03 22:19:01'),
(15, 13, '{\"NAME\":\"H\",\"LETTERS\":[\"B\"],\"AGE\":\"10\",\"Checkboxes\":[\"5\"]}', '2025-07-03 22:19:12', '2025-07-03 22:19:12'),
(16, 13, '{\"NAME\":\"fdsdf\",\"LETTERS\":[],\"AGE\":\"1\",\"Checkboxes\":[\"2\"]}', '2025-07-03 22:41:31', '2025-07-03 22:41:31'),
(17, 14, '{\"A\":\"1\"}', '2025-07-03 23:12:07', '2025-07-03 23:12:07'),
(18, 13, '{\"NAME\":\"aaa\",\"LETTERS\":[\"B\"],\"AGE\":\"5\",\"Checkboxes\":[\"1\"]}', '2025-07-03 23:15:30', '2025-07-03 23:15:30'),
(19, 13, '{\"NAME\":\"fdsf\",\"LETTERS\":[\"A\"],\"AGE\":\"1\",\"Checkboxes\":[\"1\"]}', '2025-07-03 23:16:58', '2025-07-03 23:16:58'),
(20, 13, '{\"NAME\":\"fgfd\",\"LETTERS\":[\"A\"],\"AGE\":\"1\",\"Checkboxes\":[\"1\"]}', '2025-07-03 23:17:21', '2025-07-03 23:17:21'),
(21, 13, '{\"NAME\":\"AAAA\",\"LETTERS\":[\"A\"],\"AGE\":\"1\",\"Checkboxes\":[\"1\"]}', '2025-07-03 23:28:03', '2025-07-03 23:28:03'),
(22, 13, '{\"NAME\":\"fdg\",\"LETTERS\":[\"A\"],\"AGE\":\"1\",\"Checkboxes\":[\"1\"]}', '2025-07-03 23:29:07', '2025-07-03 23:29:07'),
(23, 14, '{\"A\":\"gfd\",\"Image Upload\":\"forms\\/testing-a\\/1751614196_COVER-PHOTO-2024-Deped-1.jpg\"}', '2025-07-03 23:29:56', '2025-07-03 23:29:56'),
(24, 14, '{\"A\":\"dfgffg\",\"Image Upload\":\"forms\\/testing-a\\/1751614306_COVER-PHOTO-2024-Deped-1.jpg\"}', '2025-07-03 23:31:46', '2025-07-03 23:31:46'),
(27, 19, '{\"test\":\"1\"}', '2025-08-01 22:52:59', '2025-08-01 22:52:59'),
(28, 20, '{\"Input Name\":\"testing\",\"Gender\":[\"Male\"],\"Nationality\":\"Filipino\"}', '2025-08-01 22:58:38', '2025-08-01 22:58:38'),
(29, 21, '{\"Input your Name\":\"Hello\",\"Letters\":[\"B\"],\"Dropdown sample\":\"D\"}', '2025-08-01 23:03:49', '2025-08-01 23:03:49'),
(30, 24, '{\"Full Name\":\"dfsdf\",\"Age\":\"18-25\",\"\":\"13-17\"}', '2025-08-17 16:39:47', '2025-08-17 16:39:47'),
(31, 27, '{\"Full Name\":\"Annhe Bucal\",\"Age\":\"20-25\",\"Nationality\":[\"Filipino\"],\"Status\":\"Single\"}', '2025-09-19 01:14:32', '2025-09-19 01:14:32');

-- --------------------------------------------------------

--
-- Table structure for table `home_contents`
--

CREATE TABLE `home_contents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `main_title` varchar(255) DEFAULT NULL,
  `system_title` varchar(255) DEFAULT NULL,
  `system_logo` varchar(255) DEFAULT NULL,
  `hero_images` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`hero_images`)),
  `sub_title` text DEFAULT NULL,
  `cta_button` varchar(255) DEFAULT NULL,
  `telephone` varchar(255) DEFAULT NULL,
  `contact_email` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `section_subtitle` varchar(255) DEFAULT NULL,
  `section_title` varchar(255) DEFAULT NULL,
  `section_cards` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`section_cards`)),
  `about_us` longtext DEFAULT NULL,
  `about_title` varchar(255) DEFAULT NULL,
  `about_subtitle` varchar(255) DEFAULT NULL,
  `about_description` longtext DEFAULT NULL,
  `about_images` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`about_images`)),
  `team_title` varchar(255) DEFAULT NULL,
  `mission_cards` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`mission_cards`)),
  `team_members` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`team_members`)),
  `qr_code_path` varchar(255) DEFAULT NULL,
  `additional_sections` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`additional_sections`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `home_contents`
--

INSERT INTO `home_contents` (`id`, `main_title`, `system_title`, `system_logo`, `hero_images`, `sub_title`, `cta_button`, `telephone`, `contact_email`, `address`, `section_subtitle`, `section_title`, `section_cards`, `about_us`, `about_title`, `about_subtitle`, `about_description`, `about_images`, `team_title`, `mission_cards`, `team_members`, `qr_code_path`, `additional_sections`, `created_at`, `updated_at`) VALUES
(1, 'Our Helping to the Special Abandoned Children.', 'Charity', '/storage/logos/WyhWbX9NO7Xsqadzyqtt98xVRqppx2vwiaSCfLOw.png', '[\"\\/storage\\/hero\\/k9SQN4WKwCvPaixo2n4JV4GqlNoNPLqGJepvjCwY.jpg\",\"\\/storage\\/hero\\/52qcHiXFgEmeSi9Eyx7cNFZvj9OoTVQjndAhUJqm.jpg\",\"\\/storage\\/hero\\/qOHggQnOXoG2sml6wWKpRKaWt8uiYcfx0wJKhgEx.jpg\"]', 'Home for the Abandoned Special Children is only a Caring Institution. Processing of Adoption Cases (for referred clients) is the responsibilities and will be done by the Referring Party', 'Donate', '(046) 419-1710', 'mocbcavite@gmail.com', '134A, Indang Road, Barangay Luciano, Trece Martires City, Cavite', 'We Are In A Mission To Help The Abandoned Special Children', 'What we are doing', '[{\"title\":\"Brothers\",\"description\":\"They are the one who manage the charity and helping those special abandoned children to feel loved and cared also to provide a facilities for them to have a home.\"},{\"title\":\"Children\",\"description\":\"The children who have mental, physical and developmental disabilities who are identified as totally abandoned and in need of residential care. They are the one who the brother looking after and give them a tender love and care.\"},{\"title\":\"Donors\",\"description\":\"They are the one who helping the brothers in giving love and care for the children through donating some money and foods.\"}]', NULL, 'We Are In A Mission To Help The Abandoned Special Children', 'About our Charity', 'The Home caters special children ages 6-12 years old. It provides short term/temporary care and long term care for children with mental, physical and developmental disabilities who are identified as totally abandoned and in need of residential care.\r\n\r\nThe facility provide range of encompassing daily activities designed to minimize, rehabilitate, or compensate for loss of independent physical or mental functioning.', '[\"\\/storage\\/about_images\\/eHi1MUrakch2tWHhRafrJT6wHgmuDHG7wU85Om5Z.jpg\",\"\\/storage\\/about_images\\/HBinLREdCCEIozxesvWMy61eqvblImnoJVHl5R9E.jpg\"]', 'Our Brothers are always ready', NULL, '[{\"name\":\"Bro. Gabriel Antigro\",\"image\":\"\\/team\\/1758236573_68cc8f9d57a90.jpeg\"},{\"name\":\"Bro. Rono Wesley\",\"image\":\"\\/team\\/1758236573_68cc8f9d583f1.jpeg\"},{\"name\":\"Bro. Joseph Minh Thuc Dao\",\"image\":\"\\/team\\/1758236573_68cc8f9d58c3c.jpeg\"},{\"name\":\"Bro. Francesco Sarzi\",\"image\":\"\\/team\\/1758236573_68cc8f9d5949a.jpeg\"}]', 'uploads/qrcodes/1756530294_68b2867615cfe.jpg', '[]', '2025-06-21 14:11:04', '2025-09-18 23:30:19');

-- --------------------------------------------------------

--
-- Table structure for table `inquiries`
--

CREATE TABLE `inquiries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `inquiries`
--

INSERT INTO `inquiries` (`id`, `name`, `subject`, `email`, `message`, `is_read`, `created_at`, `updated_at`) VALUES
(1, 'Brain Trust School', 'Donations', 'macedamarkkevin@gmail.com', 'Hi Brothers, a blessed day to you and all the staff and children. we would like to inform you that we, the Brain Trust School is giving some donations like Noodles, Frozen goods, Can goods, Medicines and other supplies we know you needed. Please be inform that we will send this donation to your address, so if there\'s box you will receive please think that it\'s from us but please don\'t be confused or worried that it might be from other donors, we will put the name of the school in the box together with your organization name and your address. Sorry if we can\'t set an appointment as of now, there\'s is some little matters we, the staff of the school need to accomplish and to finish first but after this, we will assure to visit you and the children to have bond and enjoy the day. Please enjoy our little donations and help and please take care always. Hoping the kids will enjoy it.', 1, '2025-06-01 11:53:33', '2025-09-10 21:38:42'),
(4, 'Annhe Bucal', 'Donate', 'shin.annhe@gmail.com', 'Hello and good day Brother Gab. How are you and the kids. I wanted to inform you that I already send the donations from our company via Lalamove and hope to get there as soon as possible. If you need more or something else, don\'t hesitate to send me an email so that I inform my manager and talk about it. Have a wonderful day and take care always.', 1, '2025-09-18 23:46:00', '2025-09-19 00:18:21');

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT 0,
  `status` enum('enabled','disabled') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `item_category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `item_size_id` bigint(20) UNSIGNED DEFAULT NULL,
  `item_gender_id` bigint(20) UNSIGNED DEFAULT NULL,
  `account_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `code`, `name`, `description`, `deleted`, `status`, `created_at`, `updated_at`, `item_category_id`, `item_size_id`, `item_gender_id`, `account_id`) VALUES
(13, '1', 'Golden Bihon', 'A type of thin, translucent noodle made from cornstarch', 0, 'enabled', '2025-09-18 23:48:55', '2025-09-18 23:48:55', 5, NULL, NULL, NULL),
(14, '2', 'Green Cross Soap', 'A brand of germ-protection soap products that kills disease-causing germs, provides long-lasting protection and is often enriched with vitamin e and moisturizers to keep skin soft and smooth', 0, 'enabled', '2025-09-18 23:51:29', '2025-09-18 23:51:29', 6, NULL, NULL, NULL),
(15, '3', 'Biogesic', 'A trusted brand of paracetamol. A medication that is typically used to relieve mild to moderate pain such as headache, backpain, toothache, and reduce fevers caused by illness such as the common cold and flu', 0, 'enabled', '2025-09-18 23:53:58', '2025-09-18 23:53:58', 7, 5, NULL, NULL),
(16, '4', 'Sinandomeng Rice 25 kg', 'A popular, traditional long-grain white rice from the Philippines, known for its delicious aroma, soft, and slightly sticky texture when cooked and is a favorite for everyday meals and dishes like lugaw (porridge) and fried rice', 0, 'enabled', '2025-09-19 00:02:05', '2025-09-19 00:02:05', 5, 6, NULL, 15),
(17, '5', 'Mega Sardines', 'A popular brand of sardines from the Philippines known for their freshness, which is ensured by a 12 hour catch to canning process that preserve natural flavor, texture and nutrients like protein, omega-3s, vitamins and calcium', 0, 'enabled', '2025-09-19 00:05:30', '2025-09-19 00:05:30', 5, 7, NULL, NULL),
(18, '6', 'Lucky Me Instant Noodles Chicken', 'Typically flat noodles with flavor of savory, umami and mild, mimicking a light chicken broth', 0, 'enabled', '2025-09-19 00:09:20', '2025-09-19 00:09:20', 5, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `item_attachments`
--

CREATE TABLE `item_attachments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `file` varchar(255) NOT NULL,
  `item_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `item_categories`
--

CREATE TABLE `item_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `item_categories`
--

INSERT INTO `item_categories` (`id`, `name`, `created_at`, `updated_at`) VALUES
(5, 'goods', '2025-09-18 23:48:55', '2025-09-18 23:48:55'),
(6, 'supplies', '2025-09-18 23:51:29', '2025-09-18 23:51:29'),
(7, 'medicine', '2025-09-18 23:53:58', '2025-09-18 23:53:58');

-- --------------------------------------------------------

--
-- Table structure for table `item_genders`
--

CREATE TABLE `item_genders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `item_sizes`
--

CREATE TABLE `item_sizes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `item_sizes`
--

INSERT INTO `item_sizes` (`id`, `name`, `created_at`, `updated_at`) VALUES
(5, '500 mg', '2025-09-18 23:53:58', '2025-09-18 23:53:58'),
(6, 'Sacks', '2025-09-19 00:02:05', '2025-09-19 00:02:05'),
(7, 'Small Cans', '2025-09-19 00:05:30', '2025-09-19 00:05:30');

-- --------------------------------------------------------

--
-- Table structure for table `item_stock_ins`
--

CREATE TABLE `item_stock_ins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 0,
  `active_quantity` int(11) NOT NULL DEFAULT 0,
  `expiration` date DEFAULT NULL,
  `item_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `item_stock_ins`
--

INSERT INTO `item_stock_ins` (`id`, `quantity`, `active_quantity`, `expiration`, `item_id`, `created_at`, `updated_at`) VALUES
(23, 30, 30, '2025-11-14', 13, '2025-09-18 23:48:55', '2025-09-18 23:48:55'),
(24, 30, 30, '2026-01-24', 14, '2025-09-18 23:51:29', '2025-09-18 23:51:29'),
(25, 150, 140, '2026-04-21', 15, '2025-09-18 23:53:58', '2025-09-19 01:16:11'),
(26, 5, 5, '2025-12-15', 16, '2025-09-19 00:02:05', '2025-09-19 00:02:05'),
(27, 25, 25, '2025-11-29', 17, '2025-09-19 00:05:30', '2025-09-19 00:05:30'),
(28, 60, 55, '2026-02-15', 18, '2025-09-19 00:09:20', '2025-09-19 01:16:11');

-- --------------------------------------------------------

--
-- Table structure for table `item_stock_outs`
--

CREATE TABLE `item_stock_outs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 0,
  `note` varchar(255) DEFAULT NULL,
  `item_id` bigint(20) UNSIGNED NOT NULL,
  `donation_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `item_stock_outs`
--

INSERT INTO `item_stock_outs` (`id`, `quantity`, `note`, `item_id`, `donation_id`, `created_at`, `updated_at`) VALUES
(6, 10, 'Donation', 15, 6, '2025-09-19 01:16:11', '2025-09-19 01:16:11'),
(7, 5, 'Donation', 18, 7, '2025-09-19 01:16:11', '2025-09-19 01:16:11');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2024_08_30_155651_create_items_table', 1),
(5, '2024_08_30_155710_create_item_attachments_table', 1),
(6, '2024_09_03_122540_create_donors_table', 1),
(7, '2024_09_03_123501_create_addresses_table', 1),
(8, '2024_09_04_144321_create_announcements_table', 1),
(9, '2024_09_15_114233_create_events_table', 1),
(10, '2024_09_19_000637_create_donations_table', 1),
(11, '2024_10_02_100313_make-event-datetime', 1),
(12, '2024_10_18_091709_create_inquiries_table', 1),
(13, '2024_10_18_235832_create_appointments_table', 1),
(14, '2024_12_06_111155_create_event_images_table', 1),
(15, '2024_12_06_111305_remove_image_in_event', 1),
(16, '2024_12_07_164020_remove_duration_in_appointments', 1),
(17, '2024_12_07_164353_create_appointment_slots_table', 1),
(18, '2024_12_07_164929_add_appointment_slot_in_appointments', 1),
(19, '2024_12_08_111749_add_user_role_in_users', 1),
(20, '2024_12_08_135906_create_donation_drives_table', 1),
(21, '2024_12_08_135931_create_donation_drive_data_table', 1),
(22, '2025_01_25_182645_create_item_stock_ins_table', 1),
(23, '2025_01_25_182650_create_item_stock_outs_table', 1),
(24, '2025_01_25_183616_remove_stock_in_items', 1),
(25, '2025_01_25_193914_create_item_categories_table', 1),
(26, '2025_01_25_193937_create_item_sizes_table', 1),
(27, '2025_01_25_193948_create_item_genders_table', 1),
(28, '2025_01_25_194135_add_category_in_items', 1),
(29, '2025_01_26_131651_create_block_appointment_slots_table', 1),
(30, '2025_01_26_131938_create_appointment_slot_settings_table', 1),
(31, '2025_01_30_093023_add_image_on_donation', 1),
(32, '2025_01_30_104628_add_archive_on_dontion_drive', 1),
(33, '2025_02_01_185626_add_start_end_on_appointments', 1),
(34, '2025_02_08_161425_update_donation_date', 1),
(35, '2025_02_08_170449_add_appointment_type', 1),
(36, '2025_02_09_172032_create_expenses_table', 1),
(38, '2025_06_21_125807_create_home_contents_table', 2),
(39, '2025_06_21_133940_add_missing_columns_to_home_contents_table', 3),
(40, '2025_06_21_143051_add_another_columns_to_home_contents_table', 4),
(42, '2025_06_22_043520_add_additional_sections_to_home_contents_table', 5),
(44, '2025_06_22_050807_create_about_contents_table', 6),
(45, '2025_06_22_061248_add_about_images_to_home_contents_table', 7),
(46, '2025_06_30_004409_create_certificate_templates_table', 8),
(47, '2025_07_02_002957_create_forms_table', 9),
(48, '2025_07_02_011524_create_form_responses_table', 10),
(49, '2025_07_04_070613_add_limit_to_forms_table', 11),
(50, '2025_08_30_045624_add_qr_code_path_to_home_contents_table', 12),
(51, '2025_08_30_055710_modify_hero_image_to_json_in_home_contents', 13),
(53, '2025_08_30_065724_create_activity_logs_table', 14),
(54, '2025_08_31_075524_add_status_to_appointments_table', 15),
(55, '2025_08_31_082939_add_is_read_to_inquiries_table', 16),
(56, '2025_09_14_130328_add_status_to_donation_drives_table', 17);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('7KVT8aCuqgFBr7y57gXlALXkgzRXS3uNU6Xn8VFR', NULL, '127.0.0.1', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiVmpRYnFBRVZjbnZZR0xPd2puU1hyVWF0YlJrRnA3WmNxR3Vsc09DNyI7czoyMjoiUEhQREVCVUdCQVJfU1RBQ0tfREFUQSI7YTowOnt9czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzg6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9jaGFyaXR5L2Fib3V0LXVzIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czo0MToiaHR0cDovL2xvY2FsaG9zdDo4MDAwL2ludmVudG9yeS9kYXNoYm9hcmQiO319', 1763533010),
('dFr6MAgQ0tvkGq7005iuKpHSU4wNYEuiEKt6CMyI', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiSXNuS0o5QndCVFdlQlFxOUJld2xGQnVueE8wS0RGYXFDdmZpTWl4ViI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzY6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9jaGFyaXR5L2V2ZW50cyI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7czoyMjoiUEhQREVCVUdCQVJfU1RBQ0tfREFUQSI7YTowOnt9fQ==', 1763335876),
('f7yLBxkIGh0JbRhS2Uaqhe2inStLwfIWq6WeNtJa', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoiUW5YZ2Jyc2hBb2NHNmJLQWJid1F1dEU5VVF5RjFpTTVJSHNzVG0xeCI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czo0ODoiaHR0cDovL2xvY2FsaG9zdDo4MDAwL2ludmVudG9yeS9hcHBvaW50bWVudC1zbG90Ijt9czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzc6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9pbnZlbnRvcnkvbG9naW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjIyOiJQSFBERUJVR0JBUl9TVEFDS19EQVRBIjthOjE6e3M6MjY6IjAxS0E3RkpCMjZGMjQ1QktHNU1aWEhORjk1IjtOO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=', 1763335285),
('NnN9g495epkqXMCDU3SDyR6t5DLsSJTvv2M1gsMx', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiNDR4YUs5UkluUEZCOUk3ZHFPdDhGQjBSWlNvT1dnM2JKSDJ2dEkzaCI7czoyMjoiUEhQREVCVUdCQVJfU1RBQ0tfREFUQSI7YTowOnt9czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjk6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9jaGFyaXR5Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1763783190),
('wx8a0KIUpTInvDUxwa8tCERnW0AfyBreY1RntKpJ', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiR1BmQ2JoZGFQY0RHczBHWXZmN2Zzdm1TTEUyYzZLTFM1cmVLeUJlaSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9pbnZlbnRvcnkvZGFzaGJvYXJkIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTtzOjIyOiJQSFBERUJVR0JBUl9TVEFDS19EQVRBIjthOjA6e319', 1763786583),
('ZJaKJlQXofDbM3zVkcbiNqA75NV07evAxJEGYnWQ', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiWjM0alI4SkU2Ujd5cUlQeWhiWXlrVXJvZXd2RXlCQXJIc1J2WmVNWCI7czoyMjoiUEhQREVCVUdCQVJfU1RBQ0tfREFUQSI7YTowOnt9czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjk6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9jaGFyaXR5Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1763783192);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role` enum('staff','admin') NOT NULL,
  `archived` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `role`, `archived`) VALUES
(1, 'admin', 'admin@gmail.com', '2025-05-03 04:27:56', '$2y$12$XDCMHWjix8decJJDDZND1ew.PQK6JrjKxlto2bKS4CPqVTYZ4vkKu', 'NnJ1HPznAqSacO1mNMNd6CkIH9iy7TYpTyRlnXubKJ4qUFxariUEu4vYjev1', NULL, '2025-06-06 09:16:28', 'admin', 0),
(4, 'Annhe Bucal', 'shin.annhe@gmail.com', NULL, '$2y$12$vXnSWXnKm98YZhtp/ouPjerwrAo856w5QX/Ii0geh/svl/tMUh7eO', NULL, '2025-09-19 01:01:51', '2025-09-19 01:01:51', 'staff', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `about_contents`
--
ALTER TABLE `about_contents`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `accounts_email_unique` (`email`),
  ADD UNIQUE KEY `accounts_code_unique` (`code`);

--
-- Indexes for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `activity_logs_user_id_foreign` (`user_id`);

--
-- Indexes for table `addresses`
--
ALTER TABLE `addresses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `addresses_account_id_index` (`account_id`);

--
-- Indexes for table `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `announcements_user_id_index` (`user_id`);

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `appointment_slots`
--
ALTER TABLE `appointment_slots`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `appointment_slots_date_type_unique` (`date`,`type`);

--
-- Indexes for table `appointment_slot_settings`
--
ALTER TABLE `appointment_slot_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `block_appointment_slots`
--
ALTER TABLE `block_appointment_slots`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `certificate_templates`
--
ALTER TABLE `certificate_templates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `donations`
--
ALTER TABLE `donations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `donations_item_id_foreign` (`item_id`),
  ADD KEY `donations_recipient_id_foreign` (`recipient_id`);

--
-- Indexes for table `donation_drives`
--
ALTER TABLE `donation_drives`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `donation_drive_data`
--
ALTER TABLE `donation_drive_data`
  ADD PRIMARY KEY (`id`),
  ADD KEY `donation_drive_data_donation_drive_id_foreign` (`donation_drive_id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `event_images`
--
ALTER TABLE `event_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `event_images_event_id_foreign` (`event_id`);

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `expenses_account_id_foreign` (`account_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `forms`
--
ALTER TABLE `forms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `form_responses`
--
ALTER TABLE `form_responses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `form_responses_form_id_foreign` (`form_id`);

--
-- Indexes for table `home_contents`
--
ALTER TABLE `home_contents`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inquiries`
--
ALTER TABLE `inquiries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `items_code_unique` (`code`),
  ADD KEY `items_item_category_id_foreign` (`item_category_id`),
  ADD KEY `items_item_size_id_foreign` (`item_size_id`),
  ADD KEY `items_item_gender_id_foreign` (`item_gender_id`),
  ADD KEY `items_account_id_foreign` (`account_id`);

--
-- Indexes for table `item_attachments`
--
ALTER TABLE `item_attachments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `item_attachments_item_id_index` (`item_id`);

--
-- Indexes for table `item_categories`
--
ALTER TABLE `item_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `item_genders`
--
ALTER TABLE `item_genders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `item_sizes`
--
ALTER TABLE `item_sizes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `item_stock_ins`
--
ALTER TABLE `item_stock_ins`
  ADD PRIMARY KEY (`id`),
  ADD KEY `item_stock_ins_item_id_foreign` (`item_id`);

--
-- Indexes for table `item_stock_outs`
--
ALTER TABLE `item_stock_outs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `item_stock_outs_item_id_foreign` (`item_id`),
  ADD KEY `item_stock_outs_donation_id_foreign` (`donation_id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `about_contents`
--
ALTER TABLE `about_contents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `activity_logs`
--
ALTER TABLE `activity_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=249;

--
-- AUTO_INCREMENT for table `addresses`
--
ALTER TABLE `addresses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `announcements`
--
ALTER TABLE `announcements`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `appointment_slots`
--
ALTER TABLE `appointment_slots`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `appointment_slot_settings`
--
ALTER TABLE `appointment_slot_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `block_appointment_slots`
--
ALTER TABLE `block_appointment_slots`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `certificate_templates`
--
ALTER TABLE `certificate_templates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `donations`
--
ALTER TABLE `donations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `donation_drives`
--
ALTER TABLE `donation_drives`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `donation_drive_data`
--
ALTER TABLE `donation_drive_data`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `event_images`
--
ALTER TABLE `event_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `forms`
--
ALTER TABLE `forms`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `form_responses`
--
ALTER TABLE `form_responses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `home_contents`
--
ALTER TABLE `home_contents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `inquiries`
--
ALTER TABLE `inquiries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `item_attachments`
--
ALTER TABLE `item_attachments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `item_categories`
--
ALTER TABLE `item_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `item_genders`
--
ALTER TABLE `item_genders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `item_sizes`
--
ALTER TABLE `item_sizes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `item_stock_ins`
--
ALTER TABLE `item_stock_ins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `item_stock_outs`
--
ALTER TABLE `item_stock_outs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD CONSTRAINT `activity_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `addresses`
--
ALTER TABLE `addresses`
  ADD CONSTRAINT `addresses_account_id_foreign` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`);

--
-- Constraints for table `announcements`
--
ALTER TABLE `announcements`
  ADD CONSTRAINT `announcements_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `donations`
--
ALTER TABLE `donations`
  ADD CONSTRAINT `donations_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`),
  ADD CONSTRAINT `donations_recipient_id_foreign` FOREIGN KEY (`recipient_id`) REFERENCES `accounts` (`id`);

--
-- Constraints for table `donation_drive_data`
--
ALTER TABLE `donation_drive_data`
  ADD CONSTRAINT `donation_drive_data_donation_drive_id_foreign` FOREIGN KEY (`donation_drive_id`) REFERENCES `donation_drives` (`id`);

--
-- Constraints for table `event_images`
--
ALTER TABLE `event_images`
  ADD CONSTRAINT `event_images_event_id_foreign` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`);

--
-- Constraints for table `expenses`
--
ALTER TABLE `expenses`
  ADD CONSTRAINT `expenses_account_id_foreign` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`);

--
-- Constraints for table `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `items_account_id_foreign` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`),
  ADD CONSTRAINT `items_item_category_id_foreign` FOREIGN KEY (`item_category_id`) REFERENCES `item_categories` (`id`),
  ADD CONSTRAINT `items_item_gender_id_foreign` FOREIGN KEY (`item_gender_id`) REFERENCES `item_genders` (`id`),
  ADD CONSTRAINT `items_item_size_id_foreign` FOREIGN KEY (`item_size_id`) REFERENCES `item_sizes` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
