CREATE TABLE IF NOT EXISTS `screens_uploads` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `extension` varchar(5) NOT NULL,
  `original_name` varchar(150) NOT NULL,
  `width` int(11) NOT NULL,
  `height` int(11) NOT NULL,
  `size` float NOT NULL,
  `views` int(11) NOT NULL DEFAULT '0',
  `hash` varchar(64) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1162 ;

CREATE TABLE IF NOT EXISTS `screens_viewers` (
  `ip` varchar(15) NOT NULL,
  `image_id` int(11) NOT NULL,
  `timestamp` int(11) NOT NULL,
  PRIMARY KEY (`ip`,`image_id`)
) ENGINE=MEMORY DEFAULT CHARSET=latin1;
