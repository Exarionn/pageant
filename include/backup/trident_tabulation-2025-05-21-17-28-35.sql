CREATE TABLE `contestant` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(3) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `sequence` int(11) DEFAULT NULL,
  `name` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `is_finalist` tinyint(1) DEFAULT NULL,
  `category_code` varchar(15) DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `is_both` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

INSERT INTO `contestant` (id, code, sequence, name, is_finalist, category_code, gender, is_both) VALUES ('1', '001', '1', 'ANDREA', '1', 'FE', 'F', '1');

INSERT INTO `contestant` (id, code, sequence, name, is_finalist, category_code, gender, is_both) VALUES ('2', '002', '2', 'LEA', '1', 'FE', 'F', '1');

INSERT INTO `contestant` (id, code, sequence, name, is_finalist, category_code, gender, is_both) VALUES ('3', '003', '3', 'GERLIE', '1', 'MA', 'F', '1');

CREATE TABLE `event` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `event_type` varchar(6) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `event_name` varchar(45) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `event_percentage` varchar(10) DEFAULT NULL,
  `added_by` varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `added_timestamp` timestamp NULL DEFAULT NULL,
  `updated_by` varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `updated_timestamp` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

INSERT INTO `event` (id, code, event_type, event_name, event_percentage, added_by, added_timestamp, updated_by, updated_timestamp) VALUES ('1', '001', 'PR', 'PRODUCTION', '100', '000001', '2024-09-23 17:29:53', '', '');

INSERT INTO `event` (id, code, event_type, event_name, event_percentage, added_by, added_timestamp, updated_by, updated_timestamp) VALUES ('2', '002', 'PR', 'SCHOOL UNIFORM', '100', '000001', '2024-09-23 17:33:09', '', '');

INSERT INTO `event` (id, code, event_type, event_name, event_percentage, added_by, added_timestamp, updated_by, updated_timestamp) VALUES ('3', '003', 'PR', 'FORMAL', '100', '000001', '2024-09-23 17:33:22', '', '');

INSERT INTO `event` (id, code, event_type, event_name, event_percentage, added_by, added_timestamp, updated_by, updated_timestamp) VALUES ('4', '004', 'PR', 'Q AND A', '100', '000001', '2024-09-23 17:33:36', '', '');

INSERT INTO `event` (id, code, event_type, event_name, event_percentage, added_by, added_timestamp, updated_by, updated_timestamp) VALUES ('5', '005', 'F', 'Final Q and A', '100', '000001', '2024-09-23 18:21:20', '000001', '2024-12-16 00:52:32');

CREATE TABLE `event_criteria` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(3) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `criteria_type` varchar(10) DEFAULT NULL,
  `event_code` varchar(45) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `criteria_name` varchar(45) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `percent` varchar(10) DEFAULT NULL,
  `added_by` varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `added_timestamp` timestamp NULL DEFAULT NULL,
  `updated_by` varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `updated_timestamp` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

INSERT INTO `event_criteria` (id, code, criteria_type, event_code, criteria_name, percent, added_by, added_timestamp, updated_by, updated_timestamp) VALUES ('1', '001', 'PR', '001', 'creativity', '10', '000001', '2024-09-23 17:36:25', '000001', '2025-02-10 20:54:57');

INSERT INTO `event_criteria` (id, code, criteria_type, event_code, criteria_name, percent, added_by, added_timestamp, updated_by, updated_timestamp) VALUES ('2', '002', 'PR', '001', 'confidence', '10', '000001', '2024-09-23 17:36:54', '000001', '2025-02-10 20:55:05');

INSERT INTO `event_criteria` (id, code, criteria_type, event_code, criteria_name, percent, added_by, added_timestamp, updated_by, updated_timestamp) VALUES ('3', '003', 'PR', '001', 'verbal appeal', '10', '000001', '2024-09-23 17:37:22', '000001', '2025-02-10 20:55:21');

INSERT INTO `event_criteria` (id, code, criteria_type, event_code, criteria_name, percent, added_by, added_timestamp, updated_by, updated_timestamp) VALUES ('4', '004', 'PR', '001', 'audience impact', '10', '000001', '2024-09-23 17:37:49', '', '');

INSERT INTO `event_criteria` (id, code, criteria_type, event_code, criteria_name, percent, added_by, added_timestamp, updated_by, updated_timestamp) VALUES ('5', '005', 'PR', '002', 'presentation', '10', '000001', '2024-09-23 17:56:24', '', '');

INSERT INTO `event_criteria` (id, code, criteria_type, event_code, criteria_name, percent, added_by, added_timestamp, updated_by, updated_timestamp) VALUES ('6', '006', 'PR', '002', 'confidence', '10', '000001', '2024-09-23 17:57:06', '', '');

INSERT INTO `event_criteria` (id, code, criteria_type, event_code, criteria_name, percent, added_by, added_timestamp, updated_by, updated_timestamp) VALUES ('7', '007', 'PR', '002', 'visual appeal', '10', '000001', '2024-09-23 17:57:32', '', '');

INSERT INTO `event_criteria` (id, code, criteria_type, event_code, criteria_name, percent, added_by, added_timestamp, updated_by, updated_timestamp) VALUES ('8', '008', 'PR', '002', 'audience impact', '10', '000001', '2024-09-23 17:57:45', '', '');

INSERT INTO `event_criteria` (id, code, criteria_type, event_code, criteria_name, percent, added_by, added_timestamp, updated_by, updated_timestamp) VALUES ('9', '009', 'PR', '003', 'creativity', '10', '000001', '2024-09-23 17:58:16', '', '');

INSERT INTO `event_criteria` (id, code, criteria_type, event_code, criteria_name, percent, added_by, added_timestamp, updated_by, updated_timestamp) VALUES ('10', '010', 'PR', '003', 'confidence', '10', '000001', '2024-09-23 17:58:32', '', '');

INSERT INTO `event_criteria` (id, code, criteria_type, event_code, criteria_name, percent, added_by, added_timestamp, updated_by, updated_timestamp) VALUES ('11', '011', 'PR', '003', 'audience impact', '10', '000001', '2024-09-23 17:59:05', '', '');

INSERT INTO `event_criteria` (id, code, criteria_type, event_code, criteria_name, percent, added_by, added_timestamp, updated_by, updated_timestamp) VALUES ('12', '012', 'PR', '004', 'substance', '10', '000001', '2024-09-23 17:59:39', '', '');

INSERT INTO `event_criteria` (id, code, criteria_type, event_code, criteria_name, percent, added_by, added_timestamp, updated_by, updated_timestamp) VALUES ('13', '013', 'PR', '004', 'audience impact', '10', '000001', '2024-09-23 17:59:53', '', '');

INSERT INTO `event_criteria` (id, code, criteria_type, event_code, criteria_name, percent, added_by, added_timestamp, updated_by, updated_timestamp) VALUES ('14', '014', 'F', '005', 'answer', '10', '000001', '2024-09-23 18:21:46', '', '');

INSERT INTO `event_criteria` (id, code, criteria_type, event_code, criteria_name, percent, added_by, added_timestamp, updated_by, updated_timestamp) VALUES ('15', '015', 'F', '005', 'confidence', '10', '000001', '2024-09-23 18:22:03', '', '');

CREATE TABLE `event_score` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(15) DEFAULT NULL,
  `event_type_code` varchar(10) DEFAULT NULL,
  `event_code` varchar(5) DEFAULT NULL,
  `judge_code` varchar(12) DEFAULT NULL,
  `criteria_code` varchar(5) DEFAULT NULL,
  `contestant_code` varchar(5) DEFAULT NULL,
  `score` varchar(15) DEFAULT NULL,
  `category_code` varchar(15) DEFAULT NULL,
  `added_timestamp` timestamp NULL DEFAULT NULL,
  `updated_timestamp` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=841 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

INSERT INTO `event_score` (id, code, event_type_code, event_code, judge_code, criteria_code, contestant_code, score, category_code, added_timestamp, updated_timestamp) VALUES ('722', '000001', 'PR', '001', '000003', '001', '001', '10', 'FE', '2025-02-10 21:05:03', '');

INSERT INTO `event_score` (id, code, event_type_code, event_code, judge_code, criteria_code, contestant_code, score, category_code, added_timestamp, updated_timestamp) VALUES ('723', '000002', 'PR', '001', '000003', '002', '001', '10', 'FE', '2025-02-10 21:05:03', '');

INSERT INTO `event_score` (id, code, event_type_code, event_code, judge_code, criteria_code, contestant_code, score, category_code, added_timestamp, updated_timestamp) VALUES ('724', '000003', 'PR', '001', '000003', '003', '001', '10', 'FE', '2025-02-10 21:05:03', '');

INSERT INTO `event_score` (id, code, event_type_code, event_code, judge_code, criteria_code, contestant_code, score, category_code, added_timestamp, updated_timestamp) VALUES ('725', '000004', 'PR', '001', '000003', '004', '001', '10', 'FE', '2025-02-10 21:05:03', '');

INSERT INTO `event_score` (id, code, event_type_code, event_code, judge_code, criteria_code, contestant_code, score, category_code, added_timestamp, updated_timestamp) VALUES ('726', '000005', 'PR', '001', '000003', '001', '002', '9', 'FE', '2025-02-10 21:05:04', '');

INSERT INTO `event_score` (id, code, event_type_code, event_code, judge_code, criteria_code, contestant_code, score, category_code, added_timestamp, updated_timestamp) VALUES ('727', '000006', 'PR', '001', '000003', '002', '002', '10', 'FE', '2025-02-10 21:05:04', '');

INSERT INTO `event_score` (id, code, event_type_code, event_code, judge_code, criteria_code, contestant_code, score, category_code, added_timestamp, updated_timestamp) VALUES ('728', '000007', 'PR', '001', '000003', '003', '002', '10', 'FE', '2025-02-10 21:05:04', '');

INSERT INTO `event_score` (id, code, event_type_code, event_code, judge_code, criteria_code, contestant_code, score, category_code, added_timestamp, updated_timestamp) VALUES ('729', '000008', 'PR', '001', '000003', '004', '002', '10', 'FE', '2025-02-10 21:05:04', '');

INSERT INTO `event_score` (id, code, event_type_code, event_code, judge_code, criteria_code, contestant_code, score, category_code, added_timestamp, updated_timestamp) VALUES ('730', '000009', 'PR', '001', '000003', '001', '003', '8', 'FE', '2025-02-10 21:05:04', '');

INSERT INTO `event_score` (id, code, event_type_code, event_code, judge_code, criteria_code, contestant_code, score, category_code, added_timestamp, updated_timestamp) VALUES ('731', '000010', 'PR', '001', '000003', '002', '003', '10', 'FE', '2025-02-10 21:05:04', '');

INSERT INTO `event_score` (id, code, event_type_code, event_code, judge_code, criteria_code, contestant_code, score, category_code, added_timestamp, updated_timestamp) VALUES ('732', '000011', 'PR', '001', '000003', '003', '003', '10', 'FE', '2025-02-10 21:05:04', '');

INSERT INTO `event_score` (id, code, event_type_code, event_code, judge_code, criteria_code, contestant_code, score, category_code, added_timestamp, updated_timestamp) VALUES ('733', '000012', 'PR', '001', '000003', '004', '003', '10', 'FE', '2025-02-10 21:05:04', '');

INSERT INTO `event_score` (id, code, event_type_code, event_code, judge_code, criteria_code, contestant_code, score, category_code, added_timestamp, updated_timestamp) VALUES ('734', '000013', 'PR', '002', '000003', '005', '003', '8', 'FE', '2025-02-10 21:05:24', '');

INSERT INTO `event_score` (id, code, event_type_code, event_code, judge_code, criteria_code, contestant_code, score, category_code, added_timestamp, updated_timestamp) VALUES ('735', '000014', 'PR', '002', '000003', '006', '003', '10', 'FE', '2025-02-10 21:05:24', '');

INSERT INTO `event_score` (id, code, event_type_code, event_code, judge_code, criteria_code, contestant_code, score, category_code, added_timestamp, updated_timestamp) VALUES ('736', '000015', 'PR', '002', '000003', '007', '003', '10', 'FE', '2025-02-10 21:05:24', '');

INSERT INTO `event_score` (id, code, event_type_code, event_code, judge_code, criteria_code, contestant_code, score, category_code, added_timestamp, updated_timestamp) VALUES ('737', '000016', 'PR', '002', '000003', '008', '003', '10', 'FE', '2025-02-10 21:05:24', '');

INSERT INTO `event_score` (id, code, event_type_code, event_code, judge_code, criteria_code, contestant_code, score, category_code, added_timestamp, updated_timestamp) VALUES ('738', '000017', 'PR', '002', '000003', '005', '002', '9', 'FE', '2025-02-10 21:05:24', '');

INSERT INTO `event_score` (id, code, event_type_code, event_code, judge_code, criteria_code, contestant_code, score, category_code, added_timestamp, updated_timestamp) VALUES ('739', '000018', 'PR', '002', '000003', '006', '002', '10', 'FE', '2025-02-10 21:05:24', '');

INSERT INTO `event_score` (id, code, event_type_code, event_code, judge_code, criteria_code, contestant_code, score, category_code, added_timestamp, updated_timestamp) VALUES ('740', '000019', 'PR', '002', '000003', '007', '002', '10', 'FE', '2025-02-10 21:05:24', '');

INSERT INTO `event_score` (id, code, event_type_code, event_code, judge_code, criteria_code, contestant_code, score, category_code, added_timestamp, updated_timestamp) VALUES ('741', '000020', 'PR', '002', '000003', '008', '002', '10', 'FE', '2025-02-10 21:05:24', '');

INSERT INTO `event_score` (id, code, event_type_code, event_code, judge_code, criteria_code, contestant_code, score, category_code, added_timestamp, updated_timestamp) VALUES ('742', '000021', 'PR', '002', '000003', '005', '001', '10', 'FE', '2025-02-10 21:05:25', '');

INSERT INTO `event_score` (id, code, event_type_code, event_code, judge_code, criteria_code, contestant_code, score, category_code, added_timestamp, updated_timestamp) VALUES ('743', '000022', 'PR', '002', '000003', '006', '001', '10', 'FE', '2025-02-10 21:05:25', '');

INSERT INTO `event_score` (id, code, event_type_code, event_code, judge_code, criteria_code, contestant_code, score, category_code, added_timestamp, updated_timestamp) VALUES ('744', '000023', 'PR', '002', '000003', '007', '001', '10', 'FE', '2025-02-10 21:05:25', '');

INSERT INTO `event_score` (id, code, event_type_code, event_code, judge_code, criteria_code, contestant_code, score, category_code, added_timestamp, updated_timestamp) VALUES ('745', '000024', 'PR', '002', '000003', '008', '001', '10', 'FE', '2025-02-10 21:05:25', '');

INSERT INTO `event_score` (id, code, event_type_code, event_code, judge_code, criteria_code, contestant_code, score, category_code, added_timestamp, updated_timestamp) VALUES ('746', '000025', 'PR', '003', '000003', '009', '003', '8', 'FE', '2025-02-10 21:05:37', '');

INSERT INTO `event_score` (id, code, event_type_code, event_code, judge_code, criteria_code, contestant_code, score, category_code, added_timestamp, updated_timestamp) VALUES ('747', '000026', 'PR', '003', '000003', '010', '003', '10', 'FE', '2025-02-10 21:05:37', '');

INSERT INTO `event_score` (id, code, event_type_code, event_code, judge_code, criteria_code, contestant_code, score, category_code, added_timestamp, updated_timestamp) VALUES ('748', '000027', 'PR', '003', '000003', '011', '003', '10', 'FE', '2025-02-10 21:05:37', '');

INSERT INTO `event_score` (id, code, event_type_code, event_code, judge_code, criteria_code, contestant_code, score, category_code, added_timestamp, updated_timestamp) VALUES ('749', '000028', 'PR', '003', '000003', '009', '002', '9', 'FE', '2025-02-10 21:05:37', '');

INSERT INTO `event_score` (id, code, event_type_code, event_code, judge_code, criteria_code, contestant_code, score, category_code, added_timestamp, updated_timestamp) VALUES ('750', '000029', 'PR', '003', '000003', '010', '002', '10', 'FE', '2025-02-10 21:05:37', '');

INSERT INTO `event_score` (id, code, event_type_code, event_code, judge_code, criteria_code, contestant_code, score, category_code, added_timestamp, updated_timestamp) VALUES ('751', '000030', 'PR', '003', '000003', '011', '002', '10', 'FE', '2025-02-10 21:05:37', '');

INSERT INTO `event_score` (id, code, event_type_code, event_code, judge_code, criteria_code, contestant_code, score, category_code, added_timestamp, updated_timestamp) VALUES ('752', '000031', 'PR', '003', '000003', '009', '001', '10', 'FE', '2025-02-10 21:05:38', '');

INSERT INTO `event_score` (id, code, event_type_code, event_code, judge_code, criteria_code, contestant_code, score, category_code, added_timestamp, updated_timestamp) VALUES ('753', '000032', 'PR', '003', '000003', '010', '001', '10', 'FE', '2025-02-10 21:05:38', '');

INSERT INTO `event_score` (id, code, event_type_code, event_code, judge_code, criteria_code, contestant_code, score, category_code, added_timestamp, updated_timestamp) VALUES ('754', '000033', 'PR', '003', '000003', '011', '001', '10', 'FE', '2025-02-10 21:05:38', '');

INSERT INTO `event_score` (id, code, event_type_code, event_code, judge_code, criteria_code, contestant_code, score, category_code, added_timestamp, updated_timestamp) VALUES ('755', '000034', 'PR', '004', '000003', '012', '003', '8', 'FE', '2025-02-10 21:05:50', '');

INSERT INTO `event_score` (id, code, event_type_code, event_code, judge_code, criteria_code, contestant_code, score, category_code, added_timestamp, updated_timestamp) VALUES ('756', '000035', 'PR', '004', '000003', '013', '003', '10', 'FE', '2025-02-10 21:05:50', '');

INSERT INTO `event_score` (id, code, event_type_code, event_code, judge_code, criteria_code, contestant_code, score, category_code, added_timestamp, updated_timestamp) VALUES ('757', '000036', 'PR', '004', '000003', '012', '002', '9', 'FE', '2025-02-10 21:05:50', '');

INSERT INTO `event_score` (id, code, event_type_code, event_code, judge_code, criteria_code, contestant_code, score, category_code, added_timestamp, updated_timestamp) VALUES ('758', '000037', 'PR', '004', '000003', '013', '002', '10', 'FE', '2025-02-10 21:05:50', '');

INSERT INTO `event_score` (id, code, event_type_code, event_code, judge_code, criteria_code, contestant_code, score, category_code, added_timestamp, updated_timestamp) VALUES ('759', '000038', 'PR', '004', '000003', '012', '001', '10', 'FE', '2025-02-10 21:05:50', '');

INSERT INTO `event_score` (id, code, event_type_code, event_code, judge_code, criteria_code, contestant_code, score, category_code, added_timestamp, updated_timestamp) VALUES ('760', '000039', 'PR', '004', '000003', '013', '001', '10', 'FE', '2025-02-10 21:05:51', '');

INSERT INTO `event_score` (id, code, event_type_code, event_code, judge_code, criteria_code, contestant_code, score, category_code, added_timestamp, updated_timestamp) VALUES ('761', '000040', 'PR', '001', '000004', '001', '003', '8', 'FE', '2025-02-10 21:06:03', '');

INSERT INTO `event_score` (id, code, event_type_code, event_code, judge_code, criteria_code, contestant_code, score, category_code, added_timestamp, updated_timestamp) VALUES ('762', '000041', 'PR', '001', '000004', '002', '003', '10', 'FE', '2025-02-10 21:06:03', '');

INSERT INTO `event_score` (id, code, event_type_code, event_code, judge_code, criteria_code, contestant_code, score, category_code, added_timestamp, updated_timestamp) VALUES ('763', '000042', 'PR', '001', '000004', '003', '003', '10', 'FE', '2025-02-10 21:06:03', '');

INSERT INTO `event_score` (id, code, event_type_code, event_code, judge_code, criteria_code, contestant_code, score, category_code, added_timestamp, updated_timestamp) VALUES ('764', '000043', 'PR', '001', '000004', '004', '003', '10', 'FE', '2025-02-10 21:06:03', '');

INSERT INTO `event_score` (id, code, event_type_code, event_code, judge_code, criteria_code, contestant_code, score, category_code, added_timestamp, updated_timestamp) VALUES ('765', '000044', 'PR', '001', '000004', '001', '002', '9', 'FE', '2025-02-10 21:06:04', '');

INSERT INTO `event_score` (id, code, event_type_code, event_code, judge_code, criteria_code, contestant_code, score, category_code, added_timestamp, updated_timestamp) VALUES ('766', '000045', 'PR', '001', '000004', '002', '002', '10', 'FE', '2025-02-10 21:06:04', '');

INSERT INTO `event_score` (id, code, event_type_code, event_code, judge_code, criteria_code, contestant_code, score, category_code, added_timestamp, updated_timestamp) VALUES ('767', '000046', 'PR', '001', '000004', '003', '002', '10', 'FE', '2025-02-10 21:06:04', '');

INSERT INTO `event_score` (id, code, event_type_code, event_code, judge_code, criteria_code, contestant_code, score, category_code, added_timestamp, updated_timestamp) VALUES ('768', '000047', 'PR', '001', '000004', '004', '002', '10', 'FE', '2025-02-10 21:06:04', '');

INSERT INTO `event_score` (id, code, event_type_code, event_code, judge_code, criteria_code, contestant_code, score, category_code, added_timestamp, updated_timestamp) VALUES ('769', '000048', 'PR', '001', '000004', '001', '001', '10', 'FE', '2025-02-10 21:06:04', '');

INSERT INTO `event_score` (id, code, event_type_code, event_code, judge_code, criteria_code, contestant_code, score, category_code, added_timestamp, updated_timestamp) VALUES ('770', '000049', 'PR', '001', '000004', '002', '001', '10', 'FE', '2025-02-10 21:06:04', '');

INSERT INTO `event_score` (id, code, event_type_code, event_code, judge_code, criteria_code, contestant_code, score, category_code, added_timestamp, updated_timestamp) VALUES ('771', '000050', 'PR', '001', '000004', '003', '001', '10', 'FE', '2025-02-10 21:06:04', '');

INSERT INTO `event_score` (id, code, event_type_code, event_code, judge_code, criteria_code, contestant_code, score, category_code, added_timestamp, updated_timestamp) VALUES ('772', '000051', 'PR', '001', '000004', '004', '001', '10', 'FE', '2025-02-10 21:06:04', '');

INSERT INTO `event_score` (id, code, event_type_code, event_code, judge_code, criteria_code, contestant_code, score, category_code, added_timestamp, updated_timestamp) VALUES ('773', '000052', 'PR', '002', '000004', '005', '003', '8', 'FE', '2025-02-10 21:06:15', '');

INSERT INTO `event_score` (id, code, event_type_code, event_code, judge_code, criteria_code, contestant_code, score, category_code, added_timestamp, updated_timestamp) VALUES ('774', '000053', 'PR', '002', '000004', '006', '003', '10', 'FE', '2025-02-10 21:06:15', '');

INSERT INTO `event_score` (id, code, event_type_code, event_code, judge_code, criteria_code, contestant_code, score, category_code, added_timestamp, updated_timestamp) VALUES ('775', '000054', 'PR', '002', '000004', '007', '003', '10', 'FE', '2025-02-10 21:06:15', '');

INSERT INTO `event_score` (id, code, event_type_code, event_code, judge_code, criteria_code, contestant_code, score, category_code, added_timestamp, updated_timestamp) VALUES ('776', '000055', 'PR', '002', '000004', '008', '003', '10', 'FE', '2025-02-10 21:06:15', '');

INSERT INTO `event_score` (id, code, event_type_code, event_code, judge_code, criteria_code, contestant_code, score, category_code, added_timestamp, updated_timestamp) VALUES ('777', '000056', 'PR', '002', '000004', '005', '002', '9', 'FE', '2025-02-10 21:06:16', '');

INSERT INTO `event_score` (id, code, event_type_code, event_code, judge_code, criteria_code, contestant_code, score, category_code, added_timestamp, updated_timestamp) VALUES ('778', '000057', 'PR', '002', '000004', '006', '002', '10', 'FE', '2025-02-10 21:06:16', '');

INSERT INTO `event_score` (id, code, event_type_code, event_code, judge_code, criteria_code, contestant_code, score, category_code, added_timestamp, updated_timestamp) VALUES ('779', '000058', 'PR', '002', '000004', '007', '002', '10', 'FE', '2025-02-10 21:06:16', '');

INSERT INTO `event_score` (id, code, event_type_code, event_code, judge_code, criteria_code, contestant_code, score, category_code, added_timestamp, updated_timestamp) VALUES ('780', '000059', 'PR', '002', '000004', '008', '002', '10', 'FE', '2025-02-10 21:06:16', '');

INSERT INTO `event_score` (id, code, event_type_code, event_code, judge_code, criteria_code, contestant_code, score, category_code, added_timestamp, updated_timestamp) VALUES ('781', '000060', 'PR', '002', '000004', '005', '001', '10', 'FE', '2025-02-10 21:06:16', '');

INSERT INTO `event_score` (id, code, event_type_code, event_code, judge_code, criteria_code, contestant_code, score, category_code, added_timestamp, updated_timestamp) VALUES ('782', '000061', 'PR', '002', '000004', '006', '001', '10', 'FE', '2025-02-10 21:06:16', '');

INSERT INTO `event_score` (id, code, event_type_code, event_code, judge_code, criteria_code, contestant_code, score, category_code, added_timestamp, updated_timestamp) VALUES ('783', '000062', 'PR', '002', '000004', '007', '001', '10', 'FE', '2025-02-10 21:06:16', '');

INSERT INTO `event_score` (id, code, event_type_code, event_code, judge_code, criteria_code, contestant_code, score, category_code, added_timestamp, updated_timestamp) VALUES ('784', '000063', 'PR', '002', '000004', '008', '001', '10', 'FE', '2025-02-10 21:06:16', '');

INSERT INTO `event_score` (id, code, event_type_code, event_code, judge_code, criteria_code, contestant_code, score, category_code, added_timestamp, updated_timestamp) VALUES ('785', '000064', 'PR', '003', '000004', '009', '003', '8', 'FE', '2025-02-10 21:06:24', '');

INSERT INTO `event_score` (id, code, event_type_code, event_code, judge_code, criteria_code, contestant_code, score, category_code, added_timestamp, updated_timestamp) VALUES ('786', '000065', 'PR', '003', '000004', '010', '003', '10', 'FE', '2025-02-10 21:06:24', '');

INSERT INTO `event_score` (id, code, event_type_code, event_code, judge_code, criteria_code, contestant_code, score, category_code, added_timestamp, updated_timestamp) VALUES ('787', '000066', 'PR', '003', '000004', '011', '003', '10', 'FE', '2025-02-10 21:06:24', '');

INSERT INTO `event_score` (id, code, event_type_code, event_code, judge_code, criteria_code, contestant_code, score, category_code, added_timestamp, updated_timestamp) VALUES ('788', '000067', 'PR', '003', '000004', '009', '002', '9', 'FE', '2025-02-10 21:06:24', '');

INSERT INTO `event_score` (id, code, event_type_code, event_code, judge_code, criteria_code, contestant_code, score, category_code, added_timestamp, updated_timestamp) VALUES ('789', '000068', 'PR', '003', '000004', '010', '002', '10', 'FE', '2025-02-10 21:06:24', '');

INSERT INTO `event_score` (id, code, event_type_code, event_code, judge_code, criteria_code, contestant_code, score, category_code, added_timestamp, updated_timestamp) VALUES ('790', '000069', 'PR', '003', '000004', '011', '002', '10', 'FE', '2025-02-10 21:06:24', '');

INSERT INTO `event_score` (id, code, event_type_code, event_code, judge_code, criteria_code, contestant_code, score, category_code, added_timestamp, updated_timestamp) VALUES ('791', '000070', 'PR', '003', '000004', '009', '001', '10', 'FE', '2025-02-10 21:06:25', '');

INSERT INTO `event_score` (id, code, event_type_code, event_code, judge_code, criteria_code, contestant_code, score, category_code, added_timestamp, updated_timestamp) VALUES ('792', '000071', 'PR', '003', '000004', '010', '001', '10', 'FE', '2025-02-10 21:06:25', '');

INSERT INTO `event_score` (id, code, event_type_code, event_code, judge_code, criteria_code, contestant_code, score, category_code, added_timestamp, updated_timestamp) VALUES ('793', '000072', 'PR', '003', '000004', '011', '001', '10', 'FE', '2025-02-10 21:06:25', '');

INSERT INTO `event_score` (id, code, event_type_code, event_code, judge_code, criteria_code, contestant_code, score, category_code, added_timestamp, updated_timestamp) VALUES ('794', '000073', 'PR', '004', '000004', '012', '003', '8', 'FE', '2025-02-10 21:06:33', '');

INSERT INTO `event_score` (id, code, event_type_code, event_code, judge_code, criteria_code, contestant_code, score, category_code, added_timestamp, updated_timestamp) VALUES ('795', '000074', 'PR', '004', '000004', '013', '003', '10', 'FE', '2025-02-10 21:06:33', '');

INSERT INTO `event_score` (id, code, event_type_code, event_code, judge_code, criteria_code, contestant_code, score, category_code, added_timestamp, updated_timestamp) VALUES ('796', '000075', 'PR', '004', '000004', '012', '002', '9', 'FE', '2025-02-10 21:06:34', '');

INSERT INTO `event_score` (id, code, event_type_code, event_code, judge_code, criteria_code, contestant_code, score, category_code, added_timestamp, updated_timestamp) VALUES ('797', '000076', 'PR', '004', '000004', '013', '002', '10', 'FE', '2025-02-10 21:06:34', '');

INSERT INTO `event_score` (id, code, event_type_code, event_code, judge_code, criteria_code, contestant_code, score, category_code, added_timestamp, updated_timestamp) VALUES ('798', '000077', 'PR', '004', '000004', '012', '001', '10', 'FE', '2025-02-10 21:06:34', '');

INSERT INTO `event_score` (id, code, event_type_code, event_code, judge_code, criteria_code, contestant_code, score, category_code, added_timestamp, updated_timestamp) VALUES ('799', '000078', 'PR', '004', '000004', '013', '001', '10', 'FE', '2025-02-10 21:06:34', '');

INSERT INTO `event_score` (id, code, event_type_code, event_code, judge_code, criteria_code, contestant_code, score, category_code, added_timestamp, updated_timestamp) VALUES ('800', '000079', 'PR', '001', '000005', '001', '001', '8', 'FE', '2025-02-10 21:07:36', '2025-02-10 21:17:41');

INSERT INTO `event_score` (id, code, event_type_code, event_code, judge_code, criteria_code, contestant_code, score, category_code, added_timestamp, updated_timestamp) VALUES ('801', '000080', 'PR', '001', '000005', '002', '001', '8', 'FE', '2025-02-10 21:07:36', '2025-02-10 21:17:41');

INSERT INTO `event_score` (id, code, event_type_code, event_code, judge_code, criteria_code, contestant_code, score, category_code, added_timestamp, updated_timestamp) VALUES ('802', '000081', 'PR', '001', '000005', '003', '001', '7', 'FE', '2025-02-10 21:07:36', '2025-02-10 21:17:41');

INSERT INTO `event_score` (id, code, event_type_code, event_code, judge_code, criteria_code, contestant_code, score, category_code, added_timestamp, updated_timestamp) VALUES ('803', '000082', 'PR', '001', '000005', '004', '001', '7', 'FE', '2025-02-10 21:07:36', '2025-02-10 21:17:41');

INSERT INTO `event_score` (id, code, event_type_code, event_code, judge_code, criteria_code, contestant_code, score, category_code, added_timestamp, updated_timestamp) VALUES ('804', '000083', 'PR', '001', '000005', '001', '002', '9', 'FE', '2025-02-10 21:07:37', '');

INSERT INTO `event_score` (id, code, event_type_code, event_code, judge_code, criteria_code, contestant_code, score, category_code, added_timestamp, updated_timestamp) VALUES ('805', '000084', 'PR', '001', '000005', '002', '002', '10', 'FE', '2025-02-10 21:07:37', '');

INSERT INTO `event_score` (id, code, event_type_code, event_code, judge_code, criteria_code, contestant_code, score, category_code, added_timestamp, updated_timestamp) VALUES ('806', '000085', 'PR', '001', '000005', '003', '002', '10', 'FE', '2025-02-10 21:07:37', '');

INSERT INTO `event_score` (id, code, event_type_code, event_code, judge_code, criteria_code, contestant_code, score, category_code, added_timestamp, updated_timestamp) VALUES ('807', '000086', 'PR', '001', '000005', '004', '002', '10', 'FE', '2025-02-10 21:07:37', '');

INSERT INTO `event_score` (id, code, event_type_code, event_code, judge_code, criteria_code, contestant_code, score, category_code, added_timestamp, updated_timestamp) VALUES ('808', '000087', 'PR', '001', '000005', '001', '003', '9', 'FE', '2025-02-10 21:07:37', '');

INSERT INTO `event_score` (id, code, event_type_code, event_code, judge_code, criteria_code, contestant_code, score, category_code, added_timestamp, updated_timestamp) VALUES ('809', '000088', 'PR', '001', '000005', '002', '003', '10', 'FE', '2025-02-10 21:07:37', '');

INSERT INTO `event_score` (id, code, event_type_code, event_code, judge_code, criteria_code, contestant_code, score, category_code, added_timestamp, updated_timestamp) VALUES ('810', '000089', 'PR', '001', '000005', '003', '003', '10', 'FE', '2025-02-10 21:07:37', '');

INSERT INTO `event_score` (id, code, event_type_code, event_code, judge_code, criteria_code, contestant_code, score, category_code, added_timestamp, updated_timestamp) VALUES ('811', '000090', 'PR', '001', '000005', '004', '003', '10', 'FE', '2025-02-10 21:07:37', '');

INSERT INTO `event_score` (id, code, event_type_code, event_code, judge_code, criteria_code, contestant_code, score, category_code, added_timestamp, updated_timestamp) VALUES ('812', '000091', 'PR', '002', '000005', '005', '003', '8', 'FE', '2025-02-10 21:07:46', '');

INSERT INTO `event_score` (id, code, event_type_code, event_code, judge_code, criteria_code, contestant_code, score, category_code, added_timestamp, updated_timestamp) VALUES ('813', '000092', 'PR', '002', '000005', '006', '003', '10', 'FE', '2025-02-10 21:07:46', '');

INSERT INTO `event_score` (id, code, event_type_code, event_code, judge_code, criteria_code, contestant_code, score, category_code, added_timestamp, updated_timestamp) VALUES ('814', '000093', 'PR', '002', '000005', '007', '003', '10', 'FE', '2025-02-10 21:07:47', '');

INSERT INTO `event_score` (id, code, event_type_code, event_code, judge_code, criteria_code, contestant_code, score, category_code, added_timestamp, updated_timestamp) VALUES ('815', '000094', 'PR', '002', '000005', '008', '003', '10', 'FE', '2025-02-10 21:07:47', '');

INSERT INTO `event_score` (id, code, event_type_code, event_code, judge_code, criteria_code, contestant_code, score, category_code, added_timestamp, updated_timestamp) VALUES ('816', '000095', 'PR', '002', '000005', '005', '002', '9', 'FE', '2025-02-10 21:07:47', '');

INSERT INTO `event_score` (id, code, event_type_code, event_code, judge_code, criteria_code, contestant_code, score, category_code, added_timestamp, updated_timestamp) VALUES ('817', '000096', 'PR', '002', '000005', '006', '002', '10', 'FE', '2025-02-10 21:07:47', '');

INSERT INTO `event_score` (id, code, event_type_code, event_code, judge_code, criteria_code, contestant_code, score, category_code, added_timestamp, updated_timestamp) VALUES ('818', '000097', 'PR', '002', '000005', '007', '002', '10', 'FE', '2025-02-10 21:07:47', '');

INSERT INTO `event_score` (id, code, event_type_code, event_code, judge_code, criteria_code, contestant_code, score, category_code, added_timestamp, updated_timestamp) VALUES ('819', '000098', 'PR', '002', '000005', '008', '002', '10', 'FE', '2025-02-10 21:07:47', '');

INSERT INTO `event_score` (id, code, event_type_code, event_code, judge_code, criteria_code, contestant_code, score, category_code, added_timestamp, updated_timestamp) VALUES ('820', '000099', 'PR', '002', '000005', '005', '001', '10', 'FE', '2025-02-10 21:07:47', '');

INSERT INTO `event_score` (id, code, event_type_code, event_code, judge_code, criteria_code, contestant_code, score, category_code, added_timestamp, updated_timestamp) VALUES ('821', '000100', 'PR', '002', '000005', '006', '001', '10', 'FE', '2025-02-10 21:07:47', '');

INSERT INTO `event_score` (id, code, event_type_code, event_code, judge_code, criteria_code, contestant_code, score, category_code, added_timestamp, updated_timestamp) VALUES ('822', '000101', 'PR', '002', '000005', '007', '001', '10', 'FE', '2025-02-10 21:07:47', '');

INSERT INTO `event_score` (id, code, event_type_code, event_code, judge_code, criteria_code, contestant_code, score, category_code, added_timestamp, updated_timestamp) VALUES ('823', '000102', 'PR', '002', '000005', '008', '001', '10', 'FE', '2025-02-10 21:07:47', '');

INSERT INTO `event_score` (id, code, event_type_code, event_code, judge_code, criteria_code, contestant_code, score, category_code, added_timestamp, updated_timestamp) VALUES ('824', '000103', 'PR', '003', '000005', '009', '003', '8', 'FE', '2025-02-10 21:07:58', '');

INSERT INTO `event_score` (id, code, event_type_code, event_code, judge_code, criteria_code, contestant_code, score, category_code, added_timestamp, updated_timestamp) VALUES ('825', '000104', 'PR', '003', '000005', '010', '003', '10', 'FE', '2025-02-10 21:07:58', '');

INSERT INTO `event_score` (id, code, event_type_code, event_code, judge_code, criteria_code, contestant_code, score, category_code, added_timestamp, updated_timestamp) VALUES ('826', '000105', 'PR', '003', '000005', '011', '003', '10', 'FE', '2025-02-10 21:07:58', '');

INSERT INTO `event_score` (id, code, event_type_code, event_code, judge_code, criteria_code, contestant_code, score, category_code, added_timestamp, updated_timestamp) VALUES ('827', '000106', 'PR', '003', '000005', '009', '002', '9', 'FE', '2025-02-10 21:07:58', '');

INSERT INTO `event_score` (id, code, event_type_code, event_code, judge_code, criteria_code, contestant_code, score, category_code, added_timestamp, updated_timestamp) VALUES ('828', '000107', 'PR', '003', '000005', '010', '002', '10', 'FE', '2025-02-10 21:07:58', '');

INSERT INTO `event_score` (id, code, event_type_code, event_code, judge_code, criteria_code, contestant_code, score, category_code, added_timestamp, updated_timestamp) VALUES ('829', '000108', 'PR', '003', '000005', '011', '002', '10', 'FE', '2025-02-10 21:07:58', '');

INSERT INTO `event_score` (id, code, event_type_code, event_code, judge_code, criteria_code, contestant_code, score, category_code, added_timestamp, updated_timestamp) VALUES ('830', '000109', 'PR', '003', '000005', '009', '001', '10', 'FE', '2025-02-10 21:07:59', '');

INSERT INTO `event_score` (id, code, event_type_code, event_code, judge_code, criteria_code, contestant_code, score, category_code, added_timestamp, updated_timestamp) VALUES ('831', '000110', 'PR', '003', '000005', '010', '001', '10', 'FE', '2025-02-10 21:07:59', '');

INSERT INTO `event_score` (id, code, event_type_code, event_code, judge_code, criteria_code, contestant_code, score, category_code, added_timestamp, updated_timestamp) VALUES ('832', '000111', 'PR', '003', '000005', '011', '001', '10', 'FE', '2025-02-10 21:07:59', '');

INSERT INTO `event_score` (id, code, event_type_code, event_code, judge_code, criteria_code, contestant_code, score, category_code, added_timestamp, updated_timestamp) VALUES ('833', '000112', 'F', '005', '000005', '014', '002', '9', 'FE', '2025-02-10 21:08:12', '2025-02-10 21:08:59');

INSERT INTO `event_score` (id, code, event_type_code, event_code, judge_code, criteria_code, contestant_code, score, category_code, added_timestamp, updated_timestamp) VALUES ('834', '000113', 'F', '005', '000005', '015', '002', '10', 'FE', '2025-02-10 21:08:12', '2025-02-10 21:08:59');

INSERT INTO `event_score` (id, code, event_type_code, event_code, judge_code, criteria_code, contestant_code, score, category_code, added_timestamp, updated_timestamp) VALUES ('835', '000114', 'F', '005', '000005', '014', '001', '10', 'FE', '2025-02-10 21:08:13', '2025-02-10 21:08:59');

INSERT INTO `event_score` (id, code, event_type_code, event_code, judge_code, criteria_code, contestant_code, score, category_code, added_timestamp, updated_timestamp) VALUES ('836', '000115', 'F', '005', '000005', '015', '001', '10', 'FE', '2025-02-10 21:08:13', '2025-02-10 21:08:59');

INSERT INTO `event_score` (id, code, event_type_code, event_code, judge_code, criteria_code, contestant_code, score, category_code, added_timestamp, updated_timestamp) VALUES ('837', '000116', 'F', '005', '000004', '014', '002', '9', 'FE', '2025-02-10 21:08:38', '');

INSERT INTO `event_score` (id, code, event_type_code, event_code, judge_code, criteria_code, contestant_code, score, category_code, added_timestamp, updated_timestamp) VALUES ('838', '000117', 'F', '005', '000004', '015', '002', '10', 'FE', '2025-02-10 21:08:38', '');

INSERT INTO `event_score` (id, code, event_type_code, event_code, judge_code, criteria_code, contestant_code, score, category_code, added_timestamp, updated_timestamp) VALUES ('839', '000118', 'F', '005', '000004', '014', '001', '10', 'FE', '2025-02-10 21:08:38', '');

INSERT INTO `event_score` (id, code, event_type_code, event_code, judge_code, criteria_code, contestant_code, score, category_code, added_timestamp, updated_timestamp) VALUES ('840', '000119', 'F', '005', '000004', '015', '001', '10', 'FE', '2025-02-10 21:08:38', '');

CREATE TABLE `setting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `condition_final` varchar(10) DEFAULT NULL,
  `pageant_name` varchar(255) DEFAULT NULL,
  `isGeneral` varchar(4) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `cover_photo` varchar(255) DEFAULT NULL,
  `weighted_scoring` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

INSERT INTO `setting` (id, condition_final, pageant_name, isGeneral, logo, cover_photo, weighted_scoring) VALUES ('1', '2', 'MR & MS FRESHMEN 2024_25', '1', 'logo.png', 'pageant-background.png', '0');

CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  `updated_timestamp` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5829 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

INSERT INTO `user` (id, code, username, password, name, types, category, is_both, status, added_by, added_timestamp, updated_by, updated_timestamp) VALUES ('1', '000001', 'trident', 'tri123', 'TRIDENT', 'isSuper', '', '', '1', '', '2022-11-14 14:08:05', '000001', '2023-11-03 19:56:42');

INSERT INTO `user` (id, code, username, password, name, types, category, is_both, status, added_by, added_timestamp, updated_by, updated_timestamp) VALUES ('5805', '000002', 'admin', 'admin123', 'Admin', 'isAdmin', '', '', '1', '', '', '', '');

INSERT INTO `user` (id, code, username, password, name, types, category, is_both, status, added_by, added_timestamp, updated_by, updated_timestamp) VALUES ('5822', '000003', 'j1', 'j1', 'Judge1-NOLI DE CASTRO', 'isJudge', 'FE', '1', '1', '000001', '2024-09-26 08:29:36', '000001', '2025-05-21 15:13:06');

INSERT INTO `user` (id, code, username, password, name, types, category, is_both, status, added_by, added_timestamp, updated_by, updated_timestamp) VALUES ('5823', '000004', 'j2', 'j2', 'Thor Son of Oden', 'isJudge', 'FE', '0', '1', '000001', '2024-12-07 22:02:35', '000001', '2025-02-10 20:01:57');

INSERT INTO `user` (id, code, username, password, name, types, category, is_both, status, added_by, added_timestamp, updated_by, updated_timestamp) VALUES ('5824', '000005', 'j3', 'j3', 'Kratos', 'isJudge', 'FE', '0', '1', '000001', '2024-12-07 22:03:03', '000001', '2025-02-10 20:02:02');

