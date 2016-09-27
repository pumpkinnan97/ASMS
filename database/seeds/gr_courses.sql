
--
-- 转存表中的数据 `gr_courses`
--

INSERT INTO `gr_courses` (`gr_code`, `course_code`, `cs_to_gr_as_weight`) VALUES
('gr_1_1', 'D1000540', 0.20),
('gr_1_1', '0413940,0407260', 0.30),
('gr_1_1', 'D1000735', 0.20),
('gr_1_1', 'D1000160,D1000250', 0.20);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `gr_courses`
--
ALTER TABLE `gr_courses`
 ADD PRIMARY KEY (`course_code`,`gr_code`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
