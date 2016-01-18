CREATE TABLE `users_obituaries` (
  `obituaries_id` int(10) unsigned NOT NULL auto_increment,
  `obituaries_uid` int(11) unsigned NOT NULL default '0',
  `obituaries_date` date NOT NULL,
  `obituaries_photo` varchar(255) NOT NULL,
  `obituaries_description` text NOT NULL,
  `obituaries_survivors` text NOT NULL,
  `obituaries_service` text NOT NULL,
  `obituaries_memorial` text NOT NULL,
  `obituaries_firstname` varchar(150) NOT NULL,
  `obituaries_lastname` varchar(150) NOT NULL,
  `obituaries_comments` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`obituaries_id`),
  KEY `obituaries_lastname` (`obituaries_lastname`),
  KEY `obituaries_date` (`obituaries_date`),
  KEY `obituaries_uid` (`obituaries_uid`)
) ENGINE=MyISAM;
