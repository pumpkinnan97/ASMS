/*
Navicat MySQL Data Transfer

Source Server         : Mysql
Source Server Version : 50617
Source Host           : localhost:3306
Source Database       : asms

Target Server Type    : MYSQL
Target Server Version : 50617
File Encoding         : 65001

Date: 2016-09-28 00:09:24
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for admin_password_resets
-- ----------------------------
DROP TABLE IF EXISTS `admin_password_resets`;
CREATE TABLE `admin_password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL,
  KEY `admin_password_resets_email_index` (`email`),
  KEY `admin_password_resets_token_index` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of admin_password_resets
-- ----------------------------

-- ----------------------------
-- Table structure for admin_users
-- ----------------------------
DROP TABLE IF EXISTS `admin_users`;
CREATE TABLE `admin_users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `is_super` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否超级管理员',
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `admin_users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of admin_users
-- ----------------------------
INSERT INTO `admin_users` VALUES ('1', 'admin', 'admin@admin.com', '$2y$10$GBKiY/ngDVpe1iHwlTem3e0fbNrnv1sRLGcj4wT1isK0gbzY4oQoC', '1', 'OTum2UOM6z2q1aK42XyeUbFqWhpYJFaP4mTMucfGv1eK6hnsVkGWDoEmMMEK', '2016-06-06 07:45:57', '2016-06-06 07:45:57');
INSERT INTO `admin_users` VALUES ('2', '123', '123@123.com', '$2y$10$vwGqY4syqDoHFd0emGRJkuGK8SoJsK5Q887RJEQBiEdiTX1JjswhW', '0', 'qPZodbKeVPaG5mOyTaTKgNJaNg8aNJWUIcb1Kg4Raf6siGQQT0JIgxUJ8OFZ', '2016-06-06 07:37:46', '2016-06-06 07:37:46');
INSERT INTO `admin_users` VALUES ('3', '124', '124@124.com', '$2y$10$i93aFH3mFfeDAGCRWSESD.XQ6aht7vtl9jRltVWOvtn6FikJ2v4H.', '0', 'j8RAvRsPIW2U2acbHraCEUTBbSBEuRoitPmryhvZE60C6gdAHDDWJdrxMVag', '2016-06-06 07:41:07', '2016-06-06 07:41:07');
INSERT INTO `admin_users` VALUES ('4', '125', '125@125.com', '$2y$10$J3tvmyfoTsuwKaxpLEknweQBcTT2IJhEmOFFHeNMyO2ijvUVwYuwG', '1', 'eqyOu9Q7fBtUBYmWM0lf8P0Ob98jckFivHk5dl7XrBG3saUSotm4igHundhu', '2016-06-06 07:37:14', '2016-06-06 07:37:14');

-- ----------------------------
-- Table structure for admin_user_role
-- ----------------------------
DROP TABLE IF EXISTS `admin_user_role`;
CREATE TABLE `admin_user_role` (
  `admin_user_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`admin_user_id`,`role_id`),
  KEY `admin_user_role_role_id_foreign` (`role_id`),
  CONSTRAINT `admin_user_role_admin_user_id_foreign` FOREIGN KEY (`admin_user_id`) REFERENCES `admin_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `admin_user_role_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of admin_user_role
-- ----------------------------
INSERT INTO `admin_user_role` VALUES ('1', '10');
INSERT INTO `admin_user_role` VALUES ('2', '10');
INSERT INTO `admin_user_role` VALUES ('3', '12');

-- ----------------------------
-- Table structure for allgr_infos
-- ----------------------------
DROP TABLE IF EXISTS `allgr_infos`;
CREATE TABLE `allgr_infos` (
  `ALLGR_code` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `standart_description` varchar(1024) COLLATE utf8_unicode_ci NOT NULL,
  `ise_description` varchar(1024) COLLATE utf8_unicode_ci NOT NULL,
  `achievment_scale` double(8,2) NOT NULL,
  `expected_achievement_scale` double(8,2) NOT NULL,
  `gr_ALLGR_rest_as_weight` double(8,2) NOT NULL DEFAULT '1.00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of allgr_infos
-- ----------------------------
INSERT INTO `allgr_infos` VALUES ('gr_1', 'GR1', '', '具备较完整的软件工程知识结构，能够将数学、自然科学、专业知识用于解决复杂软件系统问题', '0.00', '0.00', '0.00');
INSERT INTO `allgr_infos` VALUES ('gr_10', 'GR10', '', '能够就复杂软件工程问题与业界同行及社会公众进行有效沟通和交流，包括撰写报告和设计文稿、陈述发言、清晰表达或回应指令。并具备一定的国际视野，能够在跨文化背景下进行沟通和交流', '0.00', '0.00', '0.00');
INSERT INTO `allgr_infos` VALUES ('gr_11', 'GR11', '', '具有实际的软件工程项目工作经验及组织管理能力，理解并掌握工程管理原理与经济决策方法，并能跨行业应用', '0.00', '0.00', '0.00');
INSERT INTO `allgr_infos` VALUES ('gr_12', 'GR12', '', '具有自主学习和终身学习的意识，有不断学习和适应发展的能力', '0.00', '0.00', '0.00');
INSERT INTO `allgr_infos` VALUES ('gr_2', 'GR2', '', '能够应用数学、自然科学和工程科学的基本原理，通过文献研究和系统建模，分析复杂软件系统问题，以获得有效结论', '0.00', '0.00', '0.00');
INSERT INTO `allgr_infos` VALUES ('gr_3', 'GR3', '', '能够针对复杂软件工程问题，提出满足需求的总体设计和详细设计方案，并能够在设计环节中体现创新意识，考虑社会、健康、安全、法律、文化以及环境等因素', '0.00', '0.00', '0.00');
INSERT INTO `allgr_infos` VALUES ('gr_4', 'GR4', '', '能够基于算法原理并采用科学方法对复杂软件工程问题进行研究，设计实验方案，分析与解释数据，并通过信息综合得到合理有效的结论', '0.00', '0.00', '0.00');
INSERT INTO `allgr_infos` VALUES ('gr_5', 'GR5', '', '能够针对复杂软件系统，选择与使用合适的开发环境、工具与技术标准，进行模拟和测试，并对输出结果进行分析，得出相应的评估结论', '0.00', '0.00', '0.00');
INSERT INTO `allgr_infos` VALUES ('gr_6', 'GR6', '', '了解一个以上的软件工程应用领域相关技术和背景，能够基于软件工程相关背景知识进行合理分析，评价复杂软件工程对社会、健康、安全、法律以及文化的影响，并理解应承担的责任', '0.00', '0.00', '0.00');
INSERT INTO `allgr_infos` VALUES ('gr_7', 'GR7', '', '能够理解和评价针对软件工程及其相关领域的复杂工程问题对环境、社会可持续发展的影响', '0.00', '0.00', '0.00');
INSERT INTO `allgr_infos` VALUES ('gr_8', 'GR8', '', '具有人文社会科学素养、社会责任感，能够在工程实践中理解并遵守软件行业职业道德和规范，履行责任', '0.00', '0.00', '0.00');
INSERT INTO `allgr_infos` VALUES ('gr_9', 'GR9', '', '参与团队工程项目训练，能够在多学科背景下的团队中承担个体、团队成员以及负责人的角色', '0.00', '0.00', '0.00');

-- ----------------------------
-- Table structure for ccp_infos
-- ----------------------------
DROP TABLE IF EXISTS `ccp_infos`;
CREATE TABLE `ccp_infos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ccp_code` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `course_code` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `is_leaf_ccp` int(11) NOT NULL,
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `standard_score` double NOT NULL,
  `expected_score` double NOT NULL,
  `actual_score` double NOT NULL,
  `level` int(11) NOT NULL,
  `ccp_CO_as_weight` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ccp_GR_as_weight` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of ccp_infos
-- ----------------------------
INSERT INTO `ccp_infos` VALUES ('1', '2014-2015_1_D1000735_ccp', '2014-2015_1_D1000735', '0', '概率论与数理统计', '', '100', '80', '0', '0', '', '');
INSERT INTO `ccp_infos` VALUES ('2', '2014-2015_1_D1000735_ccp_1', '2014-2015_1_D1000735', '0', '期中考试', '', '100', '80', '0', '1', '', '');
INSERT INTO `ccp_infos` VALUES ('3', '2014-2015_1_D1000735_ccp_1_1', '2014-2015_1_D1000735', '0', '判断题', '', '50', '40', '0', '2', '', '');
INSERT INTO `ccp_infos` VALUES ('4', '2014-2015_1_D1000735_ccp_1_1_1', '2014-2015_1_D1000735', '1', '判断题1', '', '10', '10', '0', '3', '', '');
INSERT INTO `ccp_infos` VALUES ('5', '2014-2015_1_D1000735_ccp_1_1_2', '2014-2015_1_D1000735', '1', '判断题2', '', '10', '10', '0', '3', '', '');
INSERT INTO `ccp_infos` VALUES ('6', '2014-2015_1_D1000735_ccp_1_1_3', '2014-2015_1_D1000735', '1', '判断题3', '', '10', '10', '0', '3', '', '');
INSERT INTO `ccp_infos` VALUES ('7', '2014-2015_1_D1000735_ccp_1_1_4', '2014-2015_1_D1000735', '1', '判断题4', '', '10', '10', '0', '3', '', '');
INSERT INTO `ccp_infos` VALUES ('8', '2014-2015_1_D1000735_ccp_1_1_5', '2014-2015_1_D1000735', '1', '判断题5', '', '10', '0', '0', '3', '', '');
INSERT INTO `ccp_infos` VALUES ('9', '2014-2015_1_D1000735_ccp_1_1_6', '2014-2015_1_D1000735', '1', '判断题6', '', '10', '10', '0', '3', '', '');
INSERT INTO `ccp_infos` VALUES ('10', '2014-2015_1_D1000735_ccp_1_1_7', '2014-2015_1_D1000735', '1', '判断题7', '', '10', '10', '0', '3', '', '');
INSERT INTO `ccp_infos` VALUES ('11', '2014-2015_1_D1000735_ccp_1_1_8', '2014-2015_1_D1000735', '1', '判断题8', '', '10', '10', '0', '3', '', '');
INSERT INTO `ccp_infos` VALUES ('12', '2014-2015_1_D1000735_ccp_1_1_9', '2014-2015_1_D1000735', '1', '判断题9', '', '10', '10', '0', '3', '', '');
INSERT INTO `ccp_infos` VALUES ('13', '2014-2015_1_D1000735_ccp_1_1_10', '2014-2015_1_D1000735', '1', '判断题10', '', '10', '0', '0', '3', '', '');
INSERT INTO `ccp_infos` VALUES ('14', '2014-2015_1_D1000735_ccp_1_2', '2014-2015_1_D1000735', '0', '问答题', '', '50', '40', '0', '2', '', '');
INSERT INTO `ccp_infos` VALUES ('15', '2014-2015_1_D1000735_ccp_1_2_1', '2014-2015_1_D1000735', '1', '问答题1', '', '10', '10', '0', '3', '', '');
INSERT INTO `ccp_infos` VALUES ('16', '2014-2015_1_D1000735_ccp_1_2_2', '2014-2015_1_D1000735', '1', '问答题2', '', '10', '10', '0', '3', '', '');
INSERT INTO `ccp_infos` VALUES ('17', '2014-2015_1_D1000735_ccp_1_2_3', '2014-2015_1_D1000735', '1', '问答题3', '', '10', '10', '0', '3', '', '');
INSERT INTO `ccp_infos` VALUES ('18', '2014-2015_1_D1000735_ccp_1_2_4', '2014-2015_1_D1000735', '1', '问答题4', '', '10', '10', '0', '3', '', '');
INSERT INTO `ccp_infos` VALUES ('19', '2014-2015_1_D1000735_ccp_1_2_5', '2014-2015_1_D1000735', '1', '问答题5', '', '10', '0', '0', '3', '', '');
INSERT INTO `ccp_infos` VALUES ('20', '2014-2015_1_D1000735_ccp_1_2_6', '2014-2015_1_D1000735', '1', '问答题6', '', '10', '10', '0', '3', '', '');
INSERT INTO `ccp_infos` VALUES ('21', '2014-2015_1_D1000735_ccp_1_2_7', '2014-2015_1_D1000735', '1', '问答题7', '', '10', '10', '0', '3', '', '');
INSERT INTO `ccp_infos` VALUES ('22', '2014-2015_1_D1000735_ccp_1_2_8', '2014-2015_1_D1000735', '1', '问答题8', '', '10', '10', '0', '3', '', '');
INSERT INTO `ccp_infos` VALUES ('23', '2014-2015_1_D1000735_ccp_1_2_9', '2014-2015_1_D1000735', '1', '问答题9', '', '10', '10', '0', '3', '', '');
INSERT INTO `ccp_infos` VALUES ('24', '2014-2015_1_D1000735_ccp_1_2_10', '2014-2015_1_D1000735', '1', '问答题10', '', '10', '0', '0', '3', '', '');
INSERT INTO `ccp_infos` VALUES ('25', '2014-2015_1_D1000735_ccp_2', '2014-2015_1_D1000735', '0', '期末考试', '', '100', '80', '0', '1', '', '');
INSERT INTO `ccp_infos` VALUES ('26', '2014-2015_1_D1000735_ccp_2_1', '2014-2015_1_D1000735', '0', '选择题', '', '50', '40', '0', '2', '', '');
INSERT INTO `ccp_infos` VALUES ('27', '2014-2015_1_D1000735_ccp_2_1_1', '2014-2015_1_D1000735', '1', '选择题1', '', '10', '10', '0', '3', '', '');
INSERT INTO `ccp_infos` VALUES ('28', '2014-2015_1_D1000735_ccp_2_1_2', '2014-2015_1_D1000735', '1', '选择题2', '', '10', '10', '0', '3', '', '');
INSERT INTO `ccp_infos` VALUES ('29', '2014-2015_1_D1000735_ccp_2_1_3', '2014-2015_1_D1000735', '1', '选择题3', '', '10', '10', '0', '3', '', '');
INSERT INTO `ccp_infos` VALUES ('30', '2014-2015_1_D1000735_ccp_2_1_4', '2014-2015_1_D1000735', '1', '选择题4', '', '10', '10', '0', '3', '', '');
INSERT INTO `ccp_infos` VALUES ('31', '2014-2015_1_D1000735_ccp_2_1_5', '2014-2015_1_D1000735', '1', '选择题5', '', '10', '0', '0', '3', '', '');
INSERT INTO `ccp_infos` VALUES ('32', '2014-2015_1_D1000735_ccp_2_1_6', '2014-2015_1_D1000735', '1', '选择题6', '', '10', '10', '0', '3', '', '');
INSERT INTO `ccp_infos` VALUES ('33', '2014-2015_1_D1000735_ccp_2_1_7', '2014-2015_1_D1000735', '1', '选择题7', '', '10', '10', '0', '3', '', '');
INSERT INTO `ccp_infos` VALUES ('34', '2014-2015_1_D1000735_ccp_2_1_8', '2014-2015_1_D1000735', '1', '选择题8', '', '10', '10', '0', '3', '', '');
INSERT INTO `ccp_infos` VALUES ('35', '2014-2015_1_D1000735_ccp_2_1_9', '2014-2015_1_D1000735', '1', '选择题9', '', '10', '10', '0', '3', '', '');
INSERT INTO `ccp_infos` VALUES ('36', '2014-2015_1_D1000735_ccp_2_1_10', '2014-2015_1_D1000735', '1', '选择题10', '', '10', '0', '0', '3', '', '');
INSERT INTO `ccp_infos` VALUES ('37', '2014-2015_1_D1000735_ccp_2_2', '2014-2015_1_D1000735', '0', '填空题', '', '50', '40', '0', '2', '', '');
INSERT INTO `ccp_infos` VALUES ('38', '2014-2015_1_D1000735_ccp_2_2_1', '2014-2015_1_D1000735', '1', '填空题1', '', '10', '10', '0', '3', '', '');
INSERT INTO `ccp_infos` VALUES ('39', '2014-2015_1_D1000735_ccp_2_2_2', '2014-2015_1_D1000735', '1', '填空题2', '', '10', '10', '0', '3', '', '');
INSERT INTO `ccp_infos` VALUES ('40', '2014-2015_1_D1000735_ccp_2_2_3', '2014-2015_1_D1000735', '1', '填空题3', '', '10', '10', '0', '3', '', '');
INSERT INTO `ccp_infos` VALUES ('41', '2014-2015_1_D1000735_ccp_2_2_4', '2014-2015_1_D1000735', '1', '填空题4', '', '10', '10', '0', '3', '', '');
INSERT INTO `ccp_infos` VALUES ('42', '2014-2015_1_D1000735_ccp_2_2_5', '2014-2015_1_D1000735', '1', '填空题5', '', '10', '0', '0', '3', '', '');
INSERT INTO `ccp_infos` VALUES ('43', '2014-2015_1_D1000735_ccp_3', '2014-2015_1_D1000735', '0', '平时作业', '', '100', '80', '0', '1', '', '');
INSERT INTO `ccp_infos` VALUES ('44', '2014-2015_1_D1000735_ccp_3_1', '2014-2015_1_D1000735', '1', '平时作业1', '', '25', '20', '0', '2', '', '');
INSERT INTO `ccp_infos` VALUES ('45', '2014-2015_1_D1000735_ccp_3_2', '2014-2015_1_D1000735', '1', '平时作业2', '', '25', '20', '0', '2', '', '');
INSERT INTO `ccp_infos` VALUES ('46', '2014-2015_1_D1000735_ccp_3_3', '2014-2015_1_D1000735', '1', '平时作业3', '', '25', '20', '0', '2', '', '');
INSERT INTO `ccp_infos` VALUES ('47', '2014-2015_1_D1000735_ccp_3_4', '2014-2015_1_D1000735', '1', '平时作业4', '', '25', '20', '0', '2', '', '');
INSERT INTO `ccp_infos` VALUES ('48', '2014-2015_1_D1000735_ccp_4', '2014-2015_1_D1000735', '0', '实验', '', '100', '80', '0', '1', '', '');
INSERT INTO `ccp_infos` VALUES ('49', '2014-2015_1_D1000735_ccp_4_1', '2014-2015_1_D1000735', '1', '实验1', '', '25', '20', '0', '2', '', '');
INSERT INTO `ccp_infos` VALUES ('50', '2014-2015_1_D1000735_ccp_4_2', '2014-2015_1_D1000735', '1', '实验2', '', '25', '20', '0', '2', '', '');
INSERT INTO `ccp_infos` VALUES ('51', '2014-2015_1_D1000735_ccp_4_3', '2014-2015_1_D1000735', '1', '实验3', '', '25', '20', '0', '2', '', '');
INSERT INTO `ccp_infos` VALUES ('52', '2014-2015_1_D1000735_ccp_4_4', '2014-2015_1_D1000735', '1', '实验4', '', '25', '20', '0', '2', '', '');
INSERT INTO `ccp_infos` VALUES ('53', '2014-2015_1_0407260_ccp', '2014-2015_1_D1000735', '1', '大学物理II', '', '0', '0', '0', '0', '', '');
INSERT INTO `ccp_infos` VALUES ('54', '2014-2015_1_0407260_ccp', '2014-2015', '1', '大学物理II', '', '0', '0', '0', '0', '', '');
INSERT INTO `ccp_infos` VALUES ('55', '2014-2015_1_0407260_ccp', '2014-2015', '1', '大学物理II', '', '0', '0', '0', '0', '', '');
INSERT INTO `ccp_infos` VALUES ('56', '2014-2015_1_0407260_ccp', '2014-2015', '1', '大学物理II', '', '12', '10', '0', '0', '', '');

-- ----------------------------
-- Table structure for cd_cg
-- ----------------------------
DROP TABLE IF EXISTS `cd_cg`;
CREATE TABLE `cd_cg` (
  `cd_name` varchar(255) NOT NULL,
  `cg_id` varchar(255) NOT NULL,
  PRIMARY KEY (`cd_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cd_cg
-- ----------------------------

-- ----------------------------
-- Table structure for cg_infos
-- ----------------------------
DROP TABLE IF EXISTS `cg_infos`;
CREATE TABLE `cg_infos` (
  `cg_id` int(11) NOT NULL,
  `cg_name` varchar(64) NOT NULL,
  `cg_description` varchar(255) NOT NULL,
  `cg_leader` varchar(255) NOT NULL,
  KEY `cg_id` (`cg_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cg_infos
-- ----------------------------

-- ----------------------------
-- Table structure for cm_cos
-- ----------------------------
DROP TABLE IF EXISTS `cm_cos`;
CREATE TABLE `cm_cos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cm_code` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `co_code` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of cm_cos
-- ----------------------------

-- ----------------------------
-- Table structure for cm_infos
-- ----------------------------
DROP TABLE IF EXISTS `cm_infos`;
CREATE TABLE `cm_infos` (
  `cm_code` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `course_code` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `EN_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(1024) COLLATE utf8_unicode_ci NOT NULL,
  `english_description` varchar(1024) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`cm_code`),
  KEY `course_code` (`course_code`),
  CONSTRAINT `cm_infos_ibfk_1` FOREIGN KEY (`course_code`) REFERENCES `course_infos` (`course_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of cm_infos
-- ----------------------------

-- ----------------------------
-- Table structure for course_infos
-- ----------------------------
DROP TABLE IF EXISTS `course_infos`;
CREATE TABLE `course_infos` (
  `course_code` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `english_name` varchar(1024) COLLATE utf8_unicode_ci NOT NULL,
  `total_hours` int(11) NOT NULL,
  `credit` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `major` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `course_group` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `prerequisite_course` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `english_description` text COLLATE utf8_unicode_ci NOT NULL,
  `co_achievement_scale` double(8,2) NOT NULL,
  `author` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `test_way` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `advice_books` text COLLATE utf8_unicode_ci NOT NULL,
  `edit_date` date NOT NULL,
  `cd_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`course_code`),
  KEY `course_group` (`course_group`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of course_infos
-- ----------------------------
INSERT INTO `course_infos` VALUES ('2014-2015_1_0407260', '大学物理II', '', '96', '6', '学科基础课(必修)', '', '物理', '', '', '', '0.00', '', '', '《轮傻逼的养成计划》', '2016-09-18', '');
INSERT INTO `course_infos` VALUES ('2014-2015_1_0413940', '大学物理Ⅰ', '', '64', '4', '学科基础课(必修)', '', '物理', '', '', '', '0.00', '', '', '《轮傻逼的养成计划》', '2016-09-18', '');
INSERT INTO `course_infos` VALUES ('2014-2015_1_D1000160', '微积分I', '', '96', '6', '学科基础课(必修)', '', '数学', '', '', '', '0.00', '', '', '《轮傻逼的养成计划》', '2016-09-18', '');
INSERT INTO `course_infos` VALUES ('2014-2015_1_D1000250', '微积分II', '', '80', '5', '学科通识课程', '', '数学', '', '', '', '0.00', '', '', '《轮傻逼的养成计划》', '2016-09-18', '');
INSERT INTO `course_infos` VALUES ('2014-2015_1_D1000735', '线性代数与空间解析几何I', '', '64', '4', '学科基础课(必修)', '', '傻逼', '', '', '', '0.00', '', '', '《轮傻逼的养成计划》', '2016-09-18', '');

-- ----------------------------
-- Table structure for co_gr
-- ----------------------------
DROP TABLE IF EXISTS `co_gr`;
CREATE TABLE `co_gr` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `co_code` varchar(255) NOT NULL,
  `gr_code` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of co_gr
-- ----------------------------

-- ----------------------------
-- Table structure for co_infos
-- ----------------------------
DROP TABLE IF EXISTS `co_infos`;
CREATE TABLE `co_infos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `co_code` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `course_code` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `english_description` text COLLATE utf8_unicode_ci NOT NULL,
  `achivement_scale` double(8,2) NOT NULL,
  `expected_scale` double(8,2) NOT NULL,
  `CO_GR_as_weight` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ccp_CO_rest_as_weight` double(8,2) NOT NULL DEFAULT '1.00',
  PRIMARY KEY (`id`),
  KEY `co_code` (`co_code`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of co_infos
-- ----------------------------
INSERT INTO `co_infos` VALUES ('1', '2014-2015_1_D1000735D1000735_co_1', 'D1000735', 'CO1', '建立学生关于工程的基本概念, 了解信息工程的发展历史、核心技术及最新前沿领域', 'Give the students the basic concepts of engineering and the introduction of evolution history, core technologies and state-of-art frontiers of information engineering.', '100.00', '80.00', '{\"GR1\":\"0.25\"}', '0.25');
INSERT INTO `co_infos` VALUES ('2', '2014-2015_1_D1000735D1000735_co_2', 'D1000735', 'CO2', '对信息工程基础知识、系统方法、技术标准等有一个基本了解', 'Gain a preliminary understanding to the fundamental knowledge, system methodology and information technology.', '100.00', '80.00', '{\"GR1\":\"0.25\"}', '0.25');
INSERT INTO `co_infos` VALUES ('3', '2014-2015_1_D1000735D1000735_co_3', 'D1000735', 'CO3', '建立工程系统质量、环境、职业健康、安全的概念和服务意识，理解并遵守工程职业道德和规范', 'Establish the students\' engineering vision, build up their technical background and inspire their interest in this field.', '100.00', '80.00', '{\"GR1\":\"0.25\"}', '0.25');
INSERT INTO `co_infos` VALUES ('4', '2014-2015_1_D1000735D1000735_co_4', 'D1000735', 'CO4', '建立学生的工程意识、培养工程素养，激发专业兴趣，为后续的专业课程学习起到先导作用', 'Serve as a prelude to the rest of program study by triggering student\'s interest in the program.', '100.00', '80.00', '{\"GR1\":\"0.25\"}', '0.25');
INSERT INTO `co_infos` VALUES ('6', '2014-2015-12014-2015_1_D1000735_CO1', '2014-2015_1_D1000735', 'CO1', '好好学习', 'good', '100.00', '100.00', '0.25', '1.00');

-- ----------------------------
-- Table structure for gr_courses
-- ----------------------------
DROP TABLE IF EXISTS `gr_courses`;
CREATE TABLE `gr_courses` (
  `gr_code` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `course_code` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `cs_to_gr_as_weight` double(8,2) NOT NULL,
  PRIMARY KEY (`course_code`,`gr_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of gr_courses
-- ----------------------------

-- ----------------------------
-- Table structure for gr_infos
-- ----------------------------
DROP TABLE IF EXISTS `gr_infos`;
CREATE TABLE `gr_infos` (
  `gr_code` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `standart_description` varchar(1024) COLLATE utf8_unicode_ci NOT NULL,
  `ise_description` varchar(1024) COLLATE utf8_unicode_ci NOT NULL,
  `achievment_scale` double(8,2) NOT NULL,
  `expected_achievement_scale` double(8,2) NOT NULL,
  `gr_ALLGR_weight` double(8,2) NOT NULL,
  `CO_GR_rest_as_weight` double(8,2) NOT NULL DEFAULT '1.00',
  `ccp_GR_rest_as_weight` double(8,2) NOT NULL,
  PRIMARY KEY (`gr_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of gr_infos
-- ----------------------------
INSERT INTO `gr_infos` VALUES ('gr_1_1', 'GR1.1', '', '掌握数学与自然科学知识，能将其应用于复杂软件工程问题的建模和求解', '0.00', '0.00', '0.00', '0.00', '0.00');
INSERT INTO `gr_infos` VALUES ('gr_1_2', 'GR1.2', '', '掌握软件工程、计算机及相关的基础知识，能将其应用于软件工程中的系统架构、网络通信、支撑平台等问题', '0.00', '0.00', '0.00', '0.00', '0.00');
INSERT INTO `gr_infos` VALUES ('gr_1_3', 'GR1.3', '', '理解系统的概念及其在软件工程领域的体现，能对复杂软件工程问题的解决方案进行分析，并尝试改进', '0.00', '0.00', '0.00', '0.00', '0.00');
INSERT INTO `gr_infos` VALUES ('gr_1_4', 'GR1.4', '', '掌握专业知识，能选择恰当的数学模型，能用于描述复杂软件系统，对模型进行推理和求解', '0.00', '0.00', '0.00', '0.00', '0.00');
INSERT INTO `gr_infos` VALUES ('gr_10_1', 'GR10.1', '', '能够撰写报告和设计文稿，清晰阐述复杂软件工程问题', '0.00', '0.00', '0.00', '0.00', '0.00');
INSERT INTO `gr_infos` VALUES ('gr_10_2', 'GR10.2', '', '能够进行陈述发言，清楚表达对复杂软件工程问题的看法与见解', '0.00', '0.00', '0.00', '0.00', '0.00');
INSERT INTO `gr_infos` VALUES ('gr_10_3', 'GR10.3', '', '掌握至少一门外语，能够在跨文化背景下进行沟通和交流', '0.00', '0.00', '0.00', '0.00', '0.00');
INSERT INTO `gr_infos` VALUES ('gr_10_4', 'GR10.4', '', '了解软件工程领域国际发展前沿状况，能够就本专业热点问题表达自己的想法', '0.00', '0.00', '0.00', '0.00', '0.00');
INSERT INTO `gr_infos` VALUES ('gr_11_1', 'GR11.1', '', '具有校外工程实习的经历，并实际参与软件工程项目工作', '0.00', '0.00', '0.00', '0.00', '0.00');
INSERT INTO `gr_infos` VALUES ('gr_11_2', 'GR11.2', '', '熟悉软件工程项目过程，理解工程管理原理与经济决策方法', '0.00', '0.00', '0.00', '0.00', '0.00');
INSERT INTO `gr_infos` VALUES ('gr_11_3', 'GR11.3', '', ' 能够在不同领域综合应用工程管理原理和经济决策方法', '0.00', '0.00', '0.00', '0.00', '0.00');
INSERT INTO `gr_infos` VALUES ('gr_12_1', 'GR12.1', '', '能够认识不断学习的重要性和必要性，具有自主学习和终身学习的意识', '0.00', '0.00', '0.00', '0.00', '0.00');
INSERT INTO `gr_infos` VALUES ('gr_12_2', 'GR12.2', '', '掌握自主学习的方法，了解拓展知识和能力的途径', '0.00', '0.00', '0.00', '0.00', '0.00');
INSERT INTO `gr_infos` VALUES ('gr_12_3', 'GR12.3', '', '能够针对个人或职业发展的需求，采用合适的方法，自主学习，适应发展', '0.00', '0.00', '0.00', '0.00', '0.00');
INSERT INTO `gr_infos` VALUES ('gr_12_4', 'GR12.4', '', '掌握体育锻炼与运动的基本方法，为不断学习提供保障', '0.00', '0.00', '0.00', '0.00', '0.00');
INSERT INTO `gr_infos` VALUES ('gr_2_1', 'GR2.1', '', '能识别和判断复杂软件工程问题的关键环节和参数', '0.00', '0.00', '0.00', '0.00', '0.00');
INSERT INTO `gr_infos` VALUES ('gr_2_2', 'GR2.2', '', '能认识到解决问题有多种方案可选择', '0.00', '0.00', '0.00', '0.00', '0.00');
INSERT INTO `gr_infos` VALUES ('gr_2_3', 'GR2.3', '', '能分析文献寻求可替代的解决方案', '0.00', '0.00', '0.00', '0.00', '0.00');
INSERT INTO `gr_infos` VALUES ('gr_2_4', 'GR2.4', '', '能正确表达一个工程问题的解决方案，并证实方案的合理性', '0.00', '0.00', '0.00', '0.00', '0.00');
INSERT INTO `gr_infos` VALUES ('gr_3_1', 'GR3.1', '', '能够根据用户需求确定设计目标', '0.00', '0.00', '0.00', '0.00', '0.00');
INSERT INTO `gr_infos` VALUES ('gr_3_2', 'GR3.2', '', '能够在安全、环境、法律等约束条件下，通过技术经济评价对设计方案的可行性进行研究', '0.00', '0.00', '0.00', '0.00', '0.00');
INSERT INTO `gr_infos` VALUES ('gr_3_3', 'GR3.3', '', '能够针对复杂软件工程问题，设计满足特定需求的总体设计和详细设计', '0.00', '0.00', '0.00', '0.00', '0.00');
INSERT INTO `gr_infos` VALUES ('gr_3_4', 'GR3.4', '', '能够集成单元过程进行软件系统流程设计，对流程设计方案进行优选，体现创新意识', '0.00', '0.00', '0.00', '0.00', '0.00');
INSERT INTO `gr_infos` VALUES ('gr_4_1', 'GR4.1', '', '能够采用科学的方法对软件系统中的关键环节，设计相应的实验方案，搭建实验环境，开展实验', '0.00', '0.00', '0.00', '0.00', '0.00');
INSERT INTO `gr_infos` VALUES ('gr_4_2', 'GR4.2', '', '能够对实现结果进行分析和解释，并通过信息综合得到合理有效的结论', '0.00', '0.00', '0.00', '0.00', '0.00');
INSERT INTO `gr_infos` VALUES ('gr_5_1', 'GR5.1', '', '掌握获取技术、资源、现代工程工具和信息技术工具的能力', '0.00', '0.00', '0.00', '0.00', '0.00');
INSERT INTO `gr_infos` VALUES ('gr_5_2', 'GR5.2', '', '能够根据软件系统的应用场景，选择合适的开发环境、工具与技术标准进行软件系统的开发', '0.00', '0.00', '0.00', '0.00', '0.00');
INSERT INTO `gr_infos` VALUES ('gr_5_3', 'GR5.3', '', '选择相应的技术工具，针对软件工程及相关领域的复杂工程问题，进行预测和模拟', '0.00', '0.00', '0.00', '0.00', '0.00');
INSERT INTO `gr_infos` VALUES ('gr_6_1', 'GR6.1', '', '掌握至少一个应用领域中软件工程技术的应用方法和应用实践', '0.00', '0.00', '0.00', '0.00', '0.00');
INSERT INTO `gr_infos` VALUES ('gr_6_2', 'GR6.2', '', '能够识别复杂软件工程的解决方案对社会、健康、安全、法律以及文化的影响', '0.00', '0.00', '0.00', '0.00', '0.00');
INSERT INTO `gr_infos` VALUES ('gr_6_3', 'GR6.3', '', '能够评价复杂软件工程的解决方案对社会、健康、安全、法律以及文化的影响，并理解应承担的责任', '0.00', '0.00', '0.00', '0.00', '0.00');
INSERT INTO `gr_infos` VALUES ('gr_7_1', 'GR7.1', '', '能够理解软件工程实践对环境和社会可持续发展的影响', '0.00', '0.00', '0.00', '0.00', '0.00');
INSERT INTO `gr_infos` VALUES ('gr_7_2', 'GR7.2', '', '能够评价软件工程实践对环境和社会可持续发展的影响', '0.00', '0.00', '0.00', '0.00', '0.00');
INSERT INTO `gr_infos` VALUES ('gr_8_1', 'GR8.1', '', '尊重生命、关爱他人、诚信守则，具有人文知识、思辨能力、处事能力和科学精神', '0.00', '0.00', '0.00', '0.00', '0.00');
INSERT INTO `gr_infos` VALUES ('gr_8_2', 'GR8.2', '', '理解社会主义核心价值观，具有推动民族复兴和社会进步的责任感', '0.00', '0.00', '0.00', '0.00', '0.00');
INSERT INTO `gr_infos` VALUES ('gr_8_3', 'GR8.3', '', '具有软件工程系统的质量、环境、职业健康、安全和服务意识，理解并遵守职业道德和规范', '0.00', '0.00', '0.00', '0.00', '0.00');
INSERT INTO `gr_infos` VALUES ('gr_9_1', 'GR9.1', '', '能够与其他学科的成员合作并开展工作', '0.00', '0.00', '0.00', '0.00', '0.00');
INSERT INTO `gr_infos` VALUES ('gr_9_2', 'GR9.2', '', '能够独立完成团队分配的工作，并能胜任团队成员角色，承担相应责任', '0.00', '0.00', '0.00', '0.00', '0.00');
INSERT INTO `gr_infos` VALUES ('gr_9_3', 'GR9.3', '', '能够与团队其他成员有效沟通，听取反馈意见，并综合团队成员的意见，进行合理决策', '0.00', '0.00', '0.00', '0.00', '0.00');
INSERT INTO `gr_infos` VALUES ('gr_9_4', 'GR9.4', '', '具有良好的心理素质和应对突发事件、项目风险与挑战的能力', '0.00', '0.00', '0.00', '0.00', '0.00');

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of migrations
-- ----------------------------
INSERT INTO `migrations` VALUES ('2016_05_28_071439_create_admin_users', '1');
INSERT INTO `migrations` VALUES ('2016_05_28_071720_create_admin_password_resets_table', '1');
INSERT INTO `migrations` VALUES ('2016_05_29_093022_create_course_info_table', '1');
INSERT INTO `migrations` VALUES ('2016_05_29_131442_entrust_base', '1');
INSERT INTO `migrations` VALUES ('2016_05_29_131518_entrust_pivot_admin_user_role', '1');

-- ----------------------------
-- Table structure for password_resets
-- ----------------------------
DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of password_resets
-- ----------------------------

-- ----------------------------
-- Table structure for permissions
-- ----------------------------
DROP TABLE IF EXISTS `permissions`;
CREATE TABLE `permissions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `fid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '菜单父ID',
  `icon` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '图标class',
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `display_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_menu` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否作为菜单显示,[1|0]',
  `sort` tinyint(4) NOT NULL DEFAULT '0' COMMENT '排序',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of permissions
-- ----------------------------
INSERT INTO `permissions` VALUES ('20', '0', 'edit', '#-1456129983', '系统设置', '', '1', '100', '2016-02-22 16:33:03', '2016-02-22 16:33:03');
INSERT INTO `permissions` VALUES ('21', '20', '', 'admin.admin_user.index', '用户权限', '查看后台用户列表', '1', '0', '2016-02-18 15:56:26', '2016-02-18 15:56:26');
INSERT INTO `permissions` VALUES ('22', '20', '', 'admin.admin_user.create', '创建后台用户', '页面', '0', '0', '2016-02-23 11:48:18', '2016-02-23 11:48:18');
INSERT INTO `permissions` VALUES ('35', '0', 'home', 'admin.home', 'Dashboard', '后台首页', '1', '0', '2016-02-22 16:32:40', '2016-02-22 16:32:40');
INSERT INTO `permissions` VALUES ('38', '20', '', 'admin.admin_user.store', '保存新建后台用户', '操作', '0', '0', '2016-02-23 11:48:52', '2016-02-23 11:48:52');
INSERT INTO `permissions` VALUES ('39', '20', '', 'admin.admin_user.destroy', '删除后台用户', '操作', '0', '0', '2016-02-23 11:49:09', '2016-02-23 11:49:09');
INSERT INTO `permissions` VALUES ('40', '20', '', 'admin.admin_user.destory.all', '批量后台用户删除', '操作', '0', '0', '2016-02-23 12:01:01', '2016-02-23 12:01:01');
INSERT INTO `permissions` VALUES ('42', '20', '', 'admin.admin_user.edit', '编辑后台用户', '页面', '0', '0', '2016-02-23 11:48:35', '2016-02-23 11:48:35');
INSERT INTO `permissions` VALUES ('43', '20', '', 'admin.admin_user.update', '保存编辑后台用户', '操作', '0', '0', '2016-02-23 11:50:12', '2016-02-23 11:50:12');
INSERT INTO `permissions` VALUES ('44', '20', '', 'admin.permission.index', '权限管理', '页面', '0', '0', '2016-02-23 11:51:36', '2016-02-23 11:51:36');
INSERT INTO `permissions` VALUES ('45', '20', '', 'admin.permission.create', '新建权限', '页面', '0', '0', '2016-02-23 11:52:16', '2016-02-23 11:52:16');
INSERT INTO `permissions` VALUES ('46', '20', '', 'admin.permission.store', '保存新建权限', '操作', '0', '0', '2016-02-23 11:52:38', '2016-02-23 11:52:38');
INSERT INTO `permissions` VALUES ('47', '20', '', 'admin.permission.edit', '编辑权限', '页面', '0', '0', '2016-02-23 11:53:29', '2016-02-23 11:53:29');
INSERT INTO `permissions` VALUES ('48', '20', '', 'admin.permission.update', '保存编辑权限', '操作', '0', '0', '2016-02-23 11:53:56', '2016-02-23 11:53:56');
INSERT INTO `permissions` VALUES ('49', '20', '', 'admin.permission.destroy', '删除权限', '操作', '0', '0', '2016-02-23 11:54:27', '2016-02-23 11:54:27');
INSERT INTO `permissions` VALUES ('50', '20', '', 'admin.permission.destory.all', '批量删除权限', '操作', '0', '0', '2016-02-23 11:55:17', '2016-02-23 11:55:17');
INSERT INTO `permissions` VALUES ('51', '20', '', 'admin.role.index', '角色管理', '页面', '0', '0', '2016-02-23 11:56:07', '2016-02-23 11:56:07');
INSERT INTO `permissions` VALUES ('52', '20', '', 'admin.role.create', '新建角色', '页面', '0', '0', '2016-02-23 11:56:33', '2016-02-23 11:56:33');
INSERT INTO `permissions` VALUES ('53', '20', '', 'admin.role.store', '保存新建角色', '操作', '0', '0', '2016-02-23 11:57:26', '2016-02-23 11:57:26');
INSERT INTO `permissions` VALUES ('54', '20', '', 'admin.role.edit', '编辑角色', '页面', '0', '0', '2016-02-23 11:58:25', '2016-02-23 11:58:25');
INSERT INTO `permissions` VALUES ('55', '20', '', 'admin.role.update', '保存编辑角色', '操作', '0', '0', '2016-02-23 11:58:50', '2016-02-23 11:58:50');
INSERT INTO `permissions` VALUES ('56', '20', '', 'admin.role.permissions', '角色权限设置', '', '0', '0', '2016-02-23 11:59:26', '2016-02-23 11:59:26');
INSERT INTO `permissions` VALUES ('57', '20', '', 'admin.role.destroy', '角色删除', '操作', '0', '0', '2016-02-23 11:59:49', '2016-02-23 11:59:49');
INSERT INTO `permissions` VALUES ('58', '20', '', 'admin.role.destory.all', '批量删除角色', '', '0', '0', '2016-02-23 12:01:58', '2016-02-23 12:01:58');

-- ----------------------------
-- Table structure for permission_role
-- ----------------------------
DROP TABLE IF EXISTS `permission_role`;
CREATE TABLE `permission_role` (
  `permission_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `permission_role_role_id_foreign` (`role_id`),
  CONSTRAINT `permission_role_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `permission_role_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of permission_role
-- ----------------------------
INSERT INTO `permission_role` VALUES ('20', '10');
INSERT INTO `permission_role` VALUES ('21', '10');
INSERT INTO `permission_role` VALUES ('22', '10');
INSERT INTO `permission_role` VALUES ('35', '10');
INSERT INTO `permission_role` VALUES ('38', '10');
INSERT INTO `permission_role` VALUES ('39', '10');
INSERT INTO `permission_role` VALUES ('40', '10');
INSERT INTO `permission_role` VALUES ('42', '10');
INSERT INTO `permission_role` VALUES ('43', '10');
INSERT INTO `permission_role` VALUES ('44', '10');
INSERT INTO `permission_role` VALUES ('45', '10');
INSERT INTO `permission_role` VALUES ('46', '10');
INSERT INTO `permission_role` VALUES ('47', '10');
INSERT INTO `permission_role` VALUES ('48', '10');
INSERT INTO `permission_role` VALUES ('49', '10');
INSERT INTO `permission_role` VALUES ('50', '10');
INSERT INTO `permission_role` VALUES ('51', '10');
INSERT INTO `permission_role` VALUES ('52', '10');
INSERT INTO `permission_role` VALUES ('53', '10');
INSERT INTO `permission_role` VALUES ('54', '10');
INSERT INTO `permission_role` VALUES ('55', '10');
INSERT INTO `permission_role` VALUES ('56', '10');
INSERT INTO `permission_role` VALUES ('57', '10');
INSERT INTO `permission_role` VALUES ('58', '10');
INSERT INTO `permission_role` VALUES ('20', '12');
INSERT INTO `permission_role` VALUES ('21', '12');
INSERT INTO `permission_role` VALUES ('22', '12');
INSERT INTO `permission_role` VALUES ('35', '12');

-- ----------------------------
-- Table structure for po_infos
-- ----------------------------
DROP TABLE IF EXISTS `po_infos`;
CREATE TABLE `po_infos` (
  `po_code` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `standart_description` varchar(1024) COLLATE utf8_unicode_ci NOT NULL,
  `ise_description` varchar(1024) COLLATE utf8_unicode_ci NOT NULL,
  `achievment_scale` double(8,2) NOT NULL,
  `expected_achievement_scale` double(8,2) NOT NULL,
  PRIMARY KEY (`po_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of po_infos
-- ----------------------------

-- ----------------------------
-- Table structure for roles
-- ----------------------------
DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `display_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of roles
-- ----------------------------
INSERT INTO `roles` VALUES ('10', 'administrator', '系统管理员', '', '2016-02-19 17:59:52', '2016-02-19 17:59:52');
INSERT INTO `roles` VALUES ('12', 'test', '测试狗', '', '2016-02-19 18:00:43', '2016-02-19 18:00:43');

-- ----------------------------
-- Table structure for student_ccps
-- ----------------------------
DROP TABLE IF EXISTS `student_ccps`;
CREATE TABLE `student_ccps` (
  `ccp_code` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `student_id` varchar(13) COLLATE utf8_unicode_ci NOT NULL,
  `score` double(3,2) NOT NULL,
  PRIMARY KEY (`ccp_code`,`student_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of student_ccps
-- ----------------------------

-- ----------------------------
-- Table structure for student_grs
-- ----------------------------
DROP TABLE IF EXISTS `student_grs`;
CREATE TABLE `student_grs` (
  `id` int(11) NOT NULL,
  `student_id` varchar(64) NOT NULL,
  `course` varchar(255) NOT NULL,
  `ccp_GR` varchar(255) NOT NULL,
  `ccp_CO_GR` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of student_grs
-- ----------------------------

-- ----------------------------
-- Table structure for teach_plan
-- ----------------------------
DROP TABLE IF EXISTS `teach_plan`;
CREATE TABLE `teach_plan` (
  `course_code` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `cm` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `teach_hours` int(11) NOT NULL,
  `teach_way` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `teach_requirement` text COLLATE utf8_unicode_ci NOT NULL,
  `teach_content` text COLLATE utf8_unicode_ci NOT NULL,
  KEY `64` (`cm`),
  CONSTRAINT `64` FOREIGN KEY (`cm`) REFERENCES `cm_infos` (`cm_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of teach_plan
-- ----------------------------

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES ('0', '战旭', '123@123.com', '$2y$10$SJvgHBotHZf7GV6soMW1lu1U70fUDlyC0ArhmJqx5TNkVN7mp/cxm', '', '2016-09-22 13:14:35', '2016-09-22 13:14:35');
