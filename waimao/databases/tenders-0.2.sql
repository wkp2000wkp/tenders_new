
DROP TABLE IF EXISTS `san_quote`;
CREATE TABLE `san_quote` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `bu_id` int(10) NOT NULL,
  `tb_show_id` int(10) NOT NULL,
  `uid` int(10) NOT NULL DEFAULT '0',
  `company_name` text ,
  `end_time` date DEFAULT NULL,
  `transformer_type` text ,
  `number` text  COMMENT 'ÊýÁ¿',
  `slesman` text ,
  `tender_manager` text ,
  `specification` text ,
  `attachment` int(10) DEFAULT NULL,
  `remark` text,
  `is_deleted` tinyint(4) DEFAULT '0',
  `creat_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `update_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS `san_quote_uploadfile`;
CREATE TABLE `san_quote_uploadfile` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uid` int(10) NOT NULL DEFAULT '0',
  `quote_id` int(10) NOT NULL,
  `file_name` text NOT NULL,
  `path_name` text NOT NULL,
  `remark` text NOT NULL,
  `date_time` datetime NOT NULL,
  `is_deleted` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
DROP TABLE IF EXISTS `san_quote_backup`;
CREATE TABLE  `san_quote_backup` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `start_num` int(11) NOT NULL,
  `max_num` int(11) NOT NULL,
  `is_deleted` int(11) NOT NULL,
  `creat_at` datetime NOT NULL,
  `from_time` date NOT NULL,
  `to_time` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
INSERT INTO `san_quote_backup` (`id`, `name`, `start_num`, `max_num`, `is_deleted`, `creat_at`, `from_time`, `to_time`) VALUES
(1, 'default', 1, 1, 1, '2010-11-14 00:00:00', '2010-11-14', '2010-11-14');
