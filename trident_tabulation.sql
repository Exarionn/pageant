-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 21, 2025 at 05:29 PM
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
-- Database: `trident_tabulation`
--

-- --------------------------------------------------------

--
-- Table structure for table `contestant`
--

CREATE TABLE `contestant` (
  `id` int(11) NOT NULL,
  `code` varchar(3) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `sequence` int(11) DEFAULT NULL,
  `name` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `is_finalist` tinyint(1) DEFAULT NULL,
  `category_code` varchar(15) DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `is_both` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `contestant`
--

INSERT INTO `contestant` (`id`, `code`, `sequence`, `name`, `is_finalist`, `category_code`, `gender`, `is_both`) VALUES
(1, '001', 1, 'ANDREA', 1, 'FE', 'F', 1),
(2, '002', 2, 'LEA', 1, 'FE', 'F', 1),
(3, '003', 3, 'GERLIE', 1, 'MA', 'F', 1);

-- --------------------------------------------------------

--
-- Table structure for table `event`
--

CREATE TABLE `event` (
  `id` int(11) NOT NULL,
  `code` varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `event_type` varchar(6) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `event_name` varchar(45) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `event_percentage` varchar(10) DEFAULT NULL,
  `added_by` varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `added_timestamp` timestamp NULL DEFAULT NULL,
  `updated_by` varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `updated_timestamp` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `event`
--

INSERT INTO `event` (`id`, `code`, `event_type`, `event_name`, `event_percentage`, `added_by`, `added_timestamp`, `updated_by`, `updated_timestamp`) VALUES
(1, '001', 'PR', 'PRODUCTION', '100', '000001', '2024-09-23 09:29:53', NULL, NULL),
(2, '002', 'PR', 'SCHOOL UNIFORM', '100', '000001', '2024-09-23 09:33:09', NULL, NULL),
(3, '003', 'PR', 'FORMAL', '100', '000001', '2024-09-23 09:33:22', NULL, NULL),
(4, '004', 'PR', 'Q AND A', '100', '000001', '2024-09-23 09:33:36', NULL, NULL),
(5, '005', 'F', 'Final Q and A', '100', '000001', '2024-09-23 10:21:20', '000001', '2024-12-15 16:52:32');

-- --------------------------------------------------------

--
-- Table structure for table `event_criteria`
--

CREATE TABLE `event_criteria` (
  `id` int(11) NOT NULL,
  `code` varchar(3) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `criteria_type` varchar(10) DEFAULT NULL,
  `event_code` varchar(45) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `criteria_name` varchar(45) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `percent` varchar(10) DEFAULT NULL,
  `added_by` varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `added_timestamp` timestamp NULL DEFAULT NULL,
  `updated_by` varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `updated_timestamp` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `event_criteria`
--

INSERT INTO `event_criteria` (`id`, `code`, `criteria_type`, `event_code`, `criteria_name`, `percent`, `added_by`, `added_timestamp`, `updated_by`, `updated_timestamp`) VALUES
(1, '001', 'PR', '001', 'creativity', '10', '000001', '2024-09-23 09:36:25', '000001', '2025-02-10 12:54:57'),
(2, '002', 'PR', '001', 'confidence', '10', '000001', '2024-09-23 09:36:54', '000001', '2025-02-10 12:55:05'),
(3, '003', 'PR', '001', 'verbal appeal', '10', '000001', '2024-09-23 09:37:22', '000001', '2025-02-10 12:55:21'),
(4, '004', 'PR', '001', 'audience impact', '10', '000001', '2024-09-23 09:37:49', NULL, NULL),
(5, '005', 'PR', '002', 'presentation', '10', '000001', '2024-09-23 09:56:24', NULL, NULL),
(6, '006', 'PR', '002', 'confidence', '10', '000001', '2024-09-23 09:57:06', NULL, NULL),
(7, '007', 'PR', '002', 'visual appeal', '10', '000001', '2024-09-23 09:57:32', NULL, NULL),
(8, '008', 'PR', '002', 'audience impact', '10', '000001', '2024-09-23 09:57:45', NULL, NULL),
(9, '009', 'PR', '003', 'creativity', '10', '000001', '2024-09-23 09:58:16', NULL, NULL),
(10, '010', 'PR', '003', 'confidence', '10', '000001', '2024-09-23 09:58:32', NULL, NULL),
(11, '011', 'PR', '003', 'audience impact', '10', '000001', '2024-09-23 09:59:05', NULL, NULL),
(12, '012', 'PR', '004', 'substance', '10', '000001', '2024-09-23 09:59:39', NULL, NULL),
(13, '013', 'PR', '004', 'audience impact', '10', '000001', '2024-09-23 09:59:53', NULL, NULL),
(14, '014', 'F', '005', 'answer', '10', '000001', '2024-09-23 10:21:46', NULL, NULL),
(15, '015', 'F', '005', 'confidence', '10', '000001', '2024-09-23 10:22:03', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `event_score`
--

CREATE TABLE `event_score` (
  `id` int(11) NOT NULL,
  `code` varchar(15) DEFAULT NULL,
  `event_type_code` varchar(10) DEFAULT NULL,
  `event_code` varchar(5) DEFAULT NULL,
  `judge_code` varchar(12) DEFAULT NULL,
  `criteria_code` varchar(5) DEFAULT NULL,
  `contestant_code` varchar(5) DEFAULT NULL,
  `score` varchar(15) DEFAULT NULL,
  `category_code` varchar(15) DEFAULT NULL,
  `added_timestamp` timestamp NULL DEFAULT NULL,
  `updated_timestamp` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `event_score`
--

INSERT INTO `event_score` (`id`, `code`, `event_type_code`, `event_code`, `judge_code`, `criteria_code`, `contestant_code`, `score`, `category_code`, `added_timestamp`, `updated_timestamp`) VALUES
(722, '000001', 'PR', '001', '000003', '001', '001', '10', 'FE', '2025-02-10 13:05:03', NULL),
(723, '000002', 'PR', '001', '000003', '002', '001', '10', 'FE', '2025-02-10 13:05:03', NULL),
(724, '000003', 'PR', '001', '000003', '003', '001', '10', 'FE', '2025-02-10 13:05:03', NULL),
(725, '000004', 'PR', '001', '000003', '004', '001', '10', 'FE', '2025-02-10 13:05:03', NULL),
(726, '000005', 'PR', '001', '000003', '001', '002', '9', 'FE', '2025-02-10 13:05:04', NULL),
(727, '000006', 'PR', '001', '000003', '002', '002', '10', 'FE', '2025-02-10 13:05:04', NULL),
(728, '000007', 'PR', '001', '000003', '003', '002', '10', 'FE', '2025-02-10 13:05:04', NULL),
(729, '000008', 'PR', '001', '000003', '004', '002', '10', 'FE', '2025-02-10 13:05:04', NULL),
(730, '000009', 'PR', '001', '000003', '001', '003', '8', 'FE', '2025-02-10 13:05:04', NULL),
(731, '000010', 'PR', '001', '000003', '002', '003', '10', 'FE', '2025-02-10 13:05:04', NULL),
(732, '000011', 'PR', '001', '000003', '003', '003', '10', 'FE', '2025-02-10 13:05:04', NULL),
(733, '000012', 'PR', '001', '000003', '004', '003', '10', 'FE', '2025-02-10 13:05:04', NULL),
(734, '000013', 'PR', '002', '000003', '005', '003', '8', 'FE', '2025-02-10 13:05:24', NULL),
(735, '000014', 'PR', '002', '000003', '006', '003', '10', 'FE', '2025-02-10 13:05:24', NULL),
(736, '000015', 'PR', '002', '000003', '007', '003', '10', 'FE', '2025-02-10 13:05:24', NULL),
(737, '000016', 'PR', '002', '000003', '008', '003', '10', 'FE', '2025-02-10 13:05:24', NULL),
(738, '000017', 'PR', '002', '000003', '005', '002', '9', 'FE', '2025-02-10 13:05:24', NULL),
(739, '000018', 'PR', '002', '000003', '006', '002', '10', 'FE', '2025-02-10 13:05:24', NULL),
(740, '000019', 'PR', '002', '000003', '007', '002', '10', 'FE', '2025-02-10 13:05:24', NULL),
(741, '000020', 'PR', '002', '000003', '008', '002', '10', 'FE', '2025-02-10 13:05:24', NULL),
(742, '000021', 'PR', '002', '000003', '005', '001', '10', 'FE', '2025-02-10 13:05:25', NULL),
(743, '000022', 'PR', '002', '000003', '006', '001', '10', 'FE', '2025-02-10 13:05:25', NULL),
(744, '000023', 'PR', '002', '000003', '007', '001', '10', 'FE', '2025-02-10 13:05:25', NULL),
(745, '000024', 'PR', '002', '000003', '008', '001', '10', 'FE', '2025-02-10 13:05:25', NULL),
(746, '000025', 'PR', '003', '000003', '009', '003', '8', 'FE', '2025-02-10 13:05:37', NULL),
(747, '000026', 'PR', '003', '000003', '010', '003', '10', 'FE', '2025-02-10 13:05:37', NULL),
(748, '000027', 'PR', '003', '000003', '011', '003', '10', 'FE', '2025-02-10 13:05:37', NULL),
(749, '000028', 'PR', '003', '000003', '009', '002', '9', 'FE', '2025-02-10 13:05:37', NULL),
(750, '000029', 'PR', '003', '000003', '010', '002', '10', 'FE', '2025-02-10 13:05:37', NULL),
(751, '000030', 'PR', '003', '000003', '011', '002', '10', 'FE', '2025-02-10 13:05:37', NULL),
(752, '000031', 'PR', '003', '000003', '009', '001', '10', 'FE', '2025-02-10 13:05:38', NULL),
(753, '000032', 'PR', '003', '000003', '010', '001', '10', 'FE', '2025-02-10 13:05:38', NULL),
(754, '000033', 'PR', '003', '000003', '011', '001', '10', 'FE', '2025-02-10 13:05:38', NULL),
(755, '000034', 'PR', '004', '000003', '012', '003', '8', 'FE', '2025-02-10 13:05:50', NULL),
(756, '000035', 'PR', '004', '000003', '013', '003', '10', 'FE', '2025-02-10 13:05:50', NULL),
(757, '000036', 'PR', '004', '000003', '012', '002', '9', 'FE', '2025-02-10 13:05:50', NULL),
(758, '000037', 'PR', '004', '000003', '013', '002', '10', 'FE', '2025-02-10 13:05:50', NULL),
(759, '000038', 'PR', '004', '000003', '012', '001', '10', 'FE', '2025-02-10 13:05:50', NULL),
(760, '000039', 'PR', '004', '000003', '013', '001', '10', 'FE', '2025-02-10 13:05:51', NULL),
(761, '000040', 'PR', '001', '000004', '001', '003', '8', 'FE', '2025-02-10 13:06:03', NULL),
(762, '000041', 'PR', '001', '000004', '002', '003', '10', 'FE', '2025-02-10 13:06:03', NULL),
(763, '000042', 'PR', '001', '000004', '003', '003', '10', 'FE', '2025-02-10 13:06:03', NULL),
(764, '000043', 'PR', '001', '000004', '004', '003', '10', 'FE', '2025-02-10 13:06:03', NULL),
(765, '000044', 'PR', '001', '000004', '001', '002', '9', 'FE', '2025-02-10 13:06:04', NULL),
(766, '000045', 'PR', '001', '000004', '002', '002', '10', 'FE', '2025-02-10 13:06:04', NULL),
(767, '000046', 'PR', '001', '000004', '003', '002', '10', 'FE', '2025-02-10 13:06:04', NULL),
(768, '000047', 'PR', '001', '000004', '004', '002', '10', 'FE', '2025-02-10 13:06:04', NULL),
(769, '000048', 'PR', '001', '000004', '001', '001', '10', 'FE', '2025-02-10 13:06:04', NULL),
(770, '000049', 'PR', '001', '000004', '002', '001', '10', 'FE', '2025-02-10 13:06:04', NULL),
(771, '000050', 'PR', '001', '000004', '003', '001', '10', 'FE', '2025-02-10 13:06:04', NULL),
(772, '000051', 'PR', '001', '000004', '004', '001', '10', 'FE', '2025-02-10 13:06:04', NULL),
(773, '000052', 'PR', '002', '000004', '005', '003', '8', 'FE', '2025-02-10 13:06:15', NULL),
(774, '000053', 'PR', '002', '000004', '006', '003', '10', 'FE', '2025-02-10 13:06:15', NULL),
(775, '000054', 'PR', '002', '000004', '007', '003', '10', 'FE', '2025-02-10 13:06:15', NULL),
(776, '000055', 'PR', '002', '000004', '008', '003', '10', 'FE', '2025-02-10 13:06:15', NULL),
(777, '000056', 'PR', '002', '000004', '005', '002', '9', 'FE', '2025-02-10 13:06:16', NULL),
(778, '000057', 'PR', '002', '000004', '006', '002', '10', 'FE', '2025-02-10 13:06:16', NULL),
(779, '000058', 'PR', '002', '000004', '007', '002', '10', 'FE', '2025-02-10 13:06:16', NULL),
(780, '000059', 'PR', '002', '000004', '008', '002', '10', 'FE', '2025-02-10 13:06:16', NULL),
(781, '000060', 'PR', '002', '000004', '005', '001', '10', 'FE', '2025-02-10 13:06:16', NULL),
(782, '000061', 'PR', '002', '000004', '006', '001', '10', 'FE', '2025-02-10 13:06:16', NULL),
(783, '000062', 'PR', '002', '000004', '007', '001', '10', 'FE', '2025-02-10 13:06:16', NULL),
(784, '000063', 'PR', '002', '000004', '008', '001', '10', 'FE', '2025-02-10 13:06:16', NULL),
(785, '000064', 'PR', '003', '000004', '009', '003', '8', 'FE', '2025-02-10 13:06:24', NULL),
(786, '000065', 'PR', '003', '000004', '010', '003', '10', 'FE', '2025-02-10 13:06:24', NULL),
(787, '000066', 'PR', '003', '000004', '011', '003', '10', 'FE', '2025-02-10 13:06:24', NULL),
(788, '000067', 'PR', '003', '000004', '009', '002', '9', 'FE', '2025-02-10 13:06:24', NULL),
(789, '000068', 'PR', '003', '000004', '010', '002', '10', 'FE', '2025-02-10 13:06:24', NULL),
(790, '000069', 'PR', '003', '000004', '011', '002', '10', 'FE', '2025-02-10 13:06:24', NULL),
(791, '000070', 'PR', '003', '000004', '009', '001', '10', 'FE', '2025-02-10 13:06:25', NULL),
(792, '000071', 'PR', '003', '000004', '010', '001', '10', 'FE', '2025-02-10 13:06:25', NULL),
(793, '000072', 'PR', '003', '000004', '011', '001', '10', 'FE', '2025-02-10 13:06:25', NULL),
(794, '000073', 'PR', '004', '000004', '012', '003', '8', 'FE', '2025-02-10 13:06:33', NULL),
(795, '000074', 'PR', '004', '000004', '013', '003', '10', 'FE', '2025-02-10 13:06:33', NULL),
(796, '000075', 'PR', '004', '000004', '012', '002', '9', 'FE', '2025-02-10 13:06:34', NULL),
(797, '000076', 'PR', '004', '000004', '013', '002', '10', 'FE', '2025-02-10 13:06:34', NULL),
(798, '000077', 'PR', '004', '000004', '012', '001', '10', 'FE', '2025-02-10 13:06:34', NULL),
(799, '000078', 'PR', '004', '000004', '013', '001', '10', 'FE', '2025-02-10 13:06:34', NULL),
(800, '000079', 'PR', '001', '000005', '001', '001', '8', 'FE', '2025-02-10 13:07:36', '2025-02-10 13:17:41'),
(801, '000080', 'PR', '001', '000005', '002', '001', '8', 'FE', '2025-02-10 13:07:36', '2025-02-10 13:17:41'),
(802, '000081', 'PR', '001', '000005', '003', '001', '7', 'FE', '2025-02-10 13:07:36', '2025-02-10 13:17:41'),
(803, '000082', 'PR', '001', '000005', '004', '001', '7', 'FE', '2025-02-10 13:07:36', '2025-02-10 13:17:41'),
(804, '000083', 'PR', '001', '000005', '001', '002', '9', 'FE', '2025-02-10 13:07:37', NULL),
(805, '000084', 'PR', '001', '000005', '002', '002', '10', 'FE', '2025-02-10 13:07:37', NULL),
(806, '000085', 'PR', '001', '000005', '003', '002', '10', 'FE', '2025-02-10 13:07:37', NULL),
(807, '000086', 'PR', '001', '000005', '004', '002', '10', 'FE', '2025-02-10 13:07:37', NULL),
(808, '000087', 'PR', '001', '000005', '001', '003', '9', 'FE', '2025-02-10 13:07:37', NULL),
(809, '000088', 'PR', '001', '000005', '002', '003', '10', 'FE', '2025-02-10 13:07:37', NULL),
(810, '000089', 'PR', '001', '000005', '003', '003', '10', 'FE', '2025-02-10 13:07:37', NULL),
(811, '000090', 'PR', '001', '000005', '004', '003', '10', 'FE', '2025-02-10 13:07:37', NULL),
(812, '000091', 'PR', '002', '000005', '005', '003', '8', 'FE', '2025-02-10 13:07:46', NULL),
(813, '000092', 'PR', '002', '000005', '006', '003', '10', 'FE', '2025-02-10 13:07:46', NULL),
(814, '000093', 'PR', '002', '000005', '007', '003', '10', 'FE', '2025-02-10 13:07:47', NULL),
(815, '000094', 'PR', '002', '000005', '008', '003', '10', 'FE', '2025-02-10 13:07:47', NULL),
(816, '000095', 'PR', '002', '000005', '005', '002', '9', 'FE', '2025-02-10 13:07:47', NULL),
(817, '000096', 'PR', '002', '000005', '006', '002', '10', 'FE', '2025-02-10 13:07:47', NULL),
(818, '000097', 'PR', '002', '000005', '007', '002', '10', 'FE', '2025-02-10 13:07:47', NULL),
(819, '000098', 'PR', '002', '000005', '008', '002', '10', 'FE', '2025-02-10 13:07:47', NULL),
(820, '000099', 'PR', '002', '000005', '005', '001', '10', 'FE', '2025-02-10 13:07:47', NULL),
(821, '000100', 'PR', '002', '000005', '006', '001', '10', 'FE', '2025-02-10 13:07:47', NULL),
(822, '000101', 'PR', '002', '000005', '007', '001', '10', 'FE', '2025-02-10 13:07:47', NULL),
(823, '000102', 'PR', '002', '000005', '008', '001', '10', 'FE', '2025-02-10 13:07:47', NULL),
(824, '000103', 'PR', '003', '000005', '009', '003', '8', 'FE', '2025-02-10 13:07:58', NULL),
(825, '000104', 'PR', '003', '000005', '010', '003', '10', 'FE', '2025-02-10 13:07:58', NULL),
(826, '000105', 'PR', '003', '000005', '011', '003', '10', 'FE', '2025-02-10 13:07:58', NULL),
(827, '000106', 'PR', '003', '000005', '009', '002', '9', 'FE', '2025-02-10 13:07:58', NULL),
(828, '000107', 'PR', '003', '000005', '010', '002', '10', 'FE', '2025-02-10 13:07:58', NULL),
(829, '000108', 'PR', '003', '000005', '011', '002', '10', 'FE', '2025-02-10 13:07:58', NULL),
(830, '000109', 'PR', '003', '000005', '009', '001', '10', 'FE', '2025-02-10 13:07:59', NULL),
(831, '000110', 'PR', '003', '000005', '010', '001', '10', 'FE', '2025-02-10 13:07:59', NULL),
(832, '000111', 'PR', '003', '000005', '011', '001', '10', 'FE', '2025-02-10 13:07:59', NULL),
(833, '000112', 'F', '005', '000005', '014', '002', '9', 'FE', '2025-02-10 13:08:12', '2025-02-10 13:08:59'),
(834, '000113', 'F', '005', '000005', '015', '002', '10', 'FE', '2025-02-10 13:08:12', '2025-02-10 13:08:59'),
(835, '000114', 'F', '005', '000005', '014', '001', '10', 'FE', '2025-02-10 13:08:13', '2025-02-10 13:08:59'),
(836, '000115', 'F', '005', '000005', '015', '001', '10', 'FE', '2025-02-10 13:08:13', '2025-02-10 13:08:59'),
(837, '000116', 'F', '005', '000004', '014', '002', '9', 'FE', '2025-02-10 13:08:38', NULL),
(838, '000117', 'F', '005', '000004', '015', '002', '10', 'FE', '2025-02-10 13:08:38', NULL),
(839, '000118', 'F', '005', '000004', '014', '001', '10', 'FE', '2025-02-10 13:08:38', NULL),
(840, '000119', 'F', '005', '000004', '015', '001', '10', 'FE', '2025-02-10 13:08:38', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `setting`
--

CREATE TABLE `setting` (
  `id` int(11) NOT NULL,
  `condition_final` varchar(10) DEFAULT NULL,
  `pageant_name` varchar(255) DEFAULT NULL,
  `isGeneral` varchar(4) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `cover_photo` varchar(255) DEFAULT NULL,
  `weighted_scoring` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `setting`
--

INSERT INTO `setting` (`id`, `condition_final`, `pageant_name`, `isGeneral`, `logo`, `cover_photo`, `weighted_scoring`) VALUES
(1, '2', 'MR & MS FRESHMEN 2024_25', '1', 'logo.png', 'pageant-background.png', 0);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `code` varchar(16) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `username` varchar(90) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `types` varchar(45) CHARACTER SET latin1 COLLATE latin1_bin DEFAULT NULL,
  `category` varchar(15) DEFAULT NULL,
  `is_both` tinyint(1) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `added_by` varchar(16) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `added_timestamp` timestamp NULL DEFAULT NULL,
  `updated_by` varchar(16) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `updated_timestamp` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `code`, `username`, `password`, `name`, `types`, `category`, `is_both`, `status`, `added_by`, `added_timestamp`, `updated_by`, `updated_timestamp`) VALUES
(1, '000001', 'trident', 'tri123', 'TRIDENT', 'isSuper', NULL, NULL, 1, '', '2022-11-14 06:08:05', '000001', '2023-11-03 11:56:42'),
(5805, '000002', 'admin', 'admin123', 'Admin', 'isAdmin', NULL, NULL, 1, NULL, NULL, NULL, NULL),
(5822, '000003', 'j1', 'j1', 'Judge1-NOLI DE CASTRO', 'isJudge', 'FE', 1, 1, '000001', '2024-09-26 00:29:36', '000001', '2025-05-21 07:13:06'),
(5823, '000004', 'j2', 'j2', 'Thor Son of Oden', 'isJudge', 'FE', 0, 1, '000001', '2024-12-07 14:02:35', '000001', '2025-02-10 12:01:57'),
(5824, '000005', 'j3', 'j3', 'Kratos', 'isJudge', 'FE', 0, 1, '000001', '2024-12-07 14:03:03', '000001', '2025-02-10 12:02:02');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `contestant`
--
ALTER TABLE `contestant`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `event`
--
ALTER TABLE `event`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `event_criteria`
--
ALTER TABLE `event_criteria`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `event_score`
--
ALTER TABLE `event_score`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `setting`
--
ALTER TABLE `setting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `contestant`
--
ALTER TABLE `contestant`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `event`
--
ALTER TABLE `event`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `event_criteria`
--
ALTER TABLE `event_criteria`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `event_score`
--
ALTER TABLE `event_score`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=841;

--
-- AUTO_INCREMENT for table `setting`
--
ALTER TABLE `setting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5829;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
