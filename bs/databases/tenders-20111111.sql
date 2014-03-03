DROP TABLE IF EXISTS `san_quote_kaibiao_result`;
CREATE TABLE `san_quote_kaibiao_result` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tb_id` int(10) NOT NULL DEFAULT '0',
  `uid` int(10) NOT NULL DEFAULT '0',
  `transformer_type` text ,
  `specification` text ,
  `number` text  COMMENT '',
  `fudian` text  COMMENT '',
  `is_deleted` tinyint(4) DEFAULT '0',
  `creat_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `update_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS `san_quote_kaibiao_record`;
CREATE TABLE `san_quote_kaibiao_record` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tb_id` int(10) NOT NULL DEFAULT '0',
  `kb_r_id` int(10) NOT NULL DEFAULT '0',
  `uid` int(10) NOT NULL DEFAULT '0',
  `bid` tinytext,
  `bid_company`  text ,
  `bid_price` double DEFAULT '0',
  `is_deleted` tinyint(4) DEFAULT '0',
  `creat_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `update_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

ALTER TABLE `san_toubiao` ADD `kaibiao_number` INT( 10 ) NOT NULL DEFAULT '0' AFTER `is_deleted` ;