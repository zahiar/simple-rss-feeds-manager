--
-- Table structure for table `rss_feed`
--

CREATE TABLE IF NOT EXISTS `rss_feed` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `url` (`url`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `user_rss_feed`
--

CREATE TABLE IF NOT EXISTS `user_rss_feed` (
  `user_id` int(11) NOT NULL,
  `rss_feed_id` int(11) NOT NULL,
  PRIMARY KEY (`user_id`,`rss_feed_id`),
  KEY `rss_feed_id` (`rss_feed_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `user_rss_feed`
--
ALTER TABLE `user_rss_feed`
  ADD CONSTRAINT `user_rss_feed_ibfk_2` FOREIGN KEY (`rss_feed_id`) REFERENCES `rss_feed` (`id`),
  ADD CONSTRAINT `user_rss_feed_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);
