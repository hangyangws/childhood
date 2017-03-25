SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

CREATE TABLE IF NOT EXISTS `ch_comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `tolk_id` int(11) NOT NULL,
  `content` varchar(200) NOT NULL,
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE IF NOT EXISTS `ch_fans` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `from_care` int(11) NOT NULL,
  `to_care` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE IF NOT EXISTS `ch_says` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `to_who` int(11) NOT NULL,
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `aggre_num` int(11) NOT NULL DEFAULT '0',
  `com_num` int(11) NOT NULL DEFAULT '0',
  `content` varchar(600) NOT NULL,
  `img` varchar(14) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE IF NOT EXISTS `ch_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `password` varchar(40) NOT NULL,
  `question` varchar(50) NOT NULL,
  `answer` varchar(50) NOT NULL,
  `gender` varchar(1) NOT NULL DEFAULT '3',
  `motto` varchar(50) NOT NULL,
  `loving` char(1) NOT NULL DEFAULT '3',
  `qq` varchar(11) NOT NULL,
  `birthday` varchar(10) NOT NULL,
  `phone` varchar(11) NOT NULL,
  `primary_school` varchar(50) NOT NULL,
  `middle_school` varchar(50) NOT NULL,
  `high_school` varchar(50) NOT NULL,
  `university` varchar(50) NOT NULL,
  `hometown` varchar(60) NOT NULL,
  `profession` varchar(50) NOT NULL,
  `progress` varchar(3) NOT NULL DEFAULT '1',
  `head` char(1) NOT NULL DEFAULT '0',
  `add_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
