CREATE TABLE IF NOT EXISTS `#__rrlogin_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `rrlogin_id` varchar(150) NOT NULL,
  `provider` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `rrlogin_id` (`rrlogin_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1
