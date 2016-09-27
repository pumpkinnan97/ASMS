-- phpMyAdmin SQL Dump
-- version 4.2.12deb2+deb8u1build0.15.04.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 2016-06-05 19:43:03
-- 服务器版本： 5.6.28-0ubuntu0.15.04.1
-- PHP Version: 5.6.4-4ubuntu6.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `rbac`
--

-- --------------------------------------------------------

--
-- 表的结构 `course_info`
--


--
-- 转存表中的数据 `course_info`
--

INSERT INTO `course_infos` (`course_code`, `name`, `english_name`, `total_hours`, `credit`, `type`, `major`,  `course_group`,`prerequisite_course`, `description`, `english_description`, `co_achievement_scale`,`author`,`test_way`,`advice_books`,`edit_date`) VALUES
('0407260', '大学物理II', '', 96, '6', '学科基础课(必修)', '', '物理', '', '', '',0.00,'','','《轮傻逼的养成计划》','2016-09-18'),
('0413940', '大学物理Ⅰ', '', 64, '4', '学科基础课(必修)', '', '物理', '', '','', 0.00,'','','《轮傻逼的养成计划》','2016-09-18'),
('D1000160', '微积分I', '', 96, '6', '学科基础课(必修)', '', '数学', '', '','', 0.00,'','','《轮傻逼的养成计划》','2016-09-18'),
('D1000250', '微积分II', '', 80, '5', '学科通识课程', '', '数学', '', '','', 0.00,'','','《轮傻逼的养成计划》','2016-09-18'),
('D1000540', '线性代数与空间解析几何I', '', 64, '4', '学科基础课(必修)', '', '傻逼', '','', '', 0.00,'','','《轮傻逼的养成计划》','2016-09-18'),
('D1000735', '概率论与数理统计', '', 56, '4', '学科通识课程', '', '傻逼','', '', '', 0.00,'','','《轮傻逼的养成计划》','2016-09-18');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `course_info`
--
ALTER TABLE `course_infos`
 ADD PRIMARY KEY (`course_code`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
