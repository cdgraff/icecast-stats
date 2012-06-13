-- Dumping database structure for icecast_stats
CREATE DATABASE IF NOT EXISTS `icecast_stats` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `icecast_stats`;


-- Dumping structure for table icecast_stats.icecast
CREATE TABLE IF NOT EXISTS `icecast` (
  `id` int(11) NOT NULL auto_increment,
  `icecast_id` int(11) NOT NULL,
  `datetime_start` datetime NOT NULL,
  `datetime_end` datetime default NULL,
  `ip` varchar(20) NOT NULL,
  `country_code` varchar(4) default NULL,
  `mount` varchar(60) NOT NULL,
  `duration` int(11) default NULL,
  `agent` varchar(200) default NULL,
  `server` varchar(50) default NULL,
  `port` int(11) default NULL,
  `user` varchar(20) default NULL,
  `pass` varchar(20) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
