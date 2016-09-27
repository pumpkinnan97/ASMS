
--
-- 转存表中的数据 `co_infos`
--

INSERT INTO `co_infos` (`co_code`, `course_code`, `name`, `description`, `english_description`, `achivement_scale`, `expected_achievement_scale`, `CO_GR_weight`, `ccp_CO_rest_weight`) VALUES
('D1000735_co_1', 'D1000735', 'CO1', '建立学生关于工程的基本概念, 了解信息工程的发展历史、核心技术及最新前沿领域', 'Give the students the basic concepts of engineering and the introduction of evolution history, core technologies and state-of-art frontiers of information engineering.', 100.00, 80.00, '{"GR1":"0.25"}',0.25),
('D1000735_co_2', 'D1000735', 'CO2', '对信息工程基础知识、系统方法、技术标准等有一个基本了解', 'Gain a preliminary understanding to the fundamental knowledge, system methodology and information technology.', 100.00, 80.00,'{"GR1":"0.25"}',0.25),
('D1000735_co_3', 'D1000735', 'CO3', '建立工程系统质量、环境、职业健康、安全的概念和服务意识，理解并遵守工程职业道德和规范', 'Establish the students'' engineering vision, build up their technical background and inspire their interest in this field.', 100.00, 80.00,'{"GR1":"0.25"}',0.25),
('D1000735_co_4', 'D1000735', 'CO4', '建立学生的工程意识、培养工程素养，激发专业兴趣，为后续的专业课程学习起到先导作用', 'Serve as a prelude to the rest of program study by triggering student''s interest in the program.', 100.00, 80.00,'{"GR1":"0.25"}',0.25);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `co_infos`
--
ALTER TABLE `co_infos`
 ADD PRIMARY KEY (`co_code`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
