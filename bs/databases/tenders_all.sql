CREATE TABLE IF NOT EXISTS `san_user` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `user_type` tinyint(4) NOT NULL DEFAULT '1',
  `is_deleted` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
INSERT INTO `san_user` (`id`, `username`, `password`,`user_type`) VALUES (1, 'admin', 'admin','6');
CREATE TABLE IF NOT EXISTS `san_toubiao` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '序号',
  `bu_id` int(10) NOT NULL,
  `tb_show_id` int(10) NOT NULL,
  `uid` int(10) NOT NULL DEFAULT '0',
  `project_name` text NOT NULL COMMENT '项目名称',
  `bidding_agent` text NOT NULL COMMENT '招标代理',
  `tenderer` text NOT NULL COMMENT '招标人',
  `specification` text NOT NULL COMMENT '规格型号',
  `transformer_type` text NOT NULL COMMENT '变压器类型',
  `number` text NOT NULL COMMENT '数量',
  `slesman` text NOT NULL COMMENT '业务员',
  `end_time` date NOT NULL COMMENT '开标日期',
  `tender_manager` text NOT NULL COMMENT '标书管理员',
  `respective_regions` text NOT NULL COMMENT '所属区域',
  `respective_provinces` text NOT NULL COMMENT '所属省份',
  `tender_fee` double NOT NULL COMMENT '标书费',
  `bid_bond` double NOT NULL COMMENT '投标保证金',
  `bid` tinytext NOT NULL COMMENT '是否中标',
  `manufacturers` text NOT NULL COMMENT '中标厂家',
  `san_bid_all_price` double DEFAULT '0' COMMENT '三变投标总报价',
  `san_bid_price` double DEFAULT '0' COMMENT '三变中标总价',
  `feedback` tinytext NOT NULL COMMENT '是否反馈',
  `reimbursement` tinytext NOT NULL COMMENT '是否报销',
  `remark` text NOT NULL COMMENT '备注',
  `creat_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `update_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '更新时间',
  `is_deleted` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='投标书' AUTO_INCREMENT=1 ;
CREATE TABLE IF NOT EXISTS `san_zhaobiao` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '序号',
  `uid` int(10) NOT NULL DEFAULT '0',
  `project_name` text NOT NULL COMMENT '项目名称',
  `bidding_agent` text NOT NULL COMMENT '招标代理',
  `tenderer` text NOT NULL COMMENT '招标人',
  `specification` text NOT NULL COMMENT '规格型号',
  `transformer_type` text NOT NULL COMMENT '变压器类型',
  `number` text NOT NULL COMMENT '数量',
  `slesman` text NOT NULL COMMENT '业务员',
  `end_time` date NOT NULL COMMENT '开标日期',
  `tender_manager` text NOT NULL COMMENT '标书管理员',
  `respective_regions` text NOT NULL COMMENT '所属区域',
  `respective_provinces` text NOT NULL COMMENT '所属省份',
  `tender_fee` double NOT NULL COMMENT '标书费',
  `bid_bond` double NOT NULL COMMENT '投标保证金',
  `creat_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `update_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '更新时间',
  `is_deleted` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='招标书' AUTO_INCREMENT=1 ;
CREATE TABLE IF NOT EXISTS `san_uploadfile` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uid` int(10) NOT NULL DEFAULT '0',
  `tb_id` int(10) NOT NULL,
  `file_name` text NOT NULL,
  `path_name` text NOT NULL,
  `remark` text NOT NULL,
  `date_time` datetime NOT NULL,
  `is_deleted` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
CREATE TABLE IF NOT EXISTS `san_backup` (
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
INSERT INTO `san_backup` (`id`, `name`, `start_num`, `max_num`, `is_deleted`, `creat_at`, `from_time`, `to_time`) VALUES
(1, 'default', 1, 1, 1, '2010-11-14 00:00:00', '2010-11-14', '2010-11-14');

DROP TABLE IF EXISTS `san_quote`;
CREATE TABLE `san_quote` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `bu_id` int(10) NOT NULL,
  `tb_show_id` int(10) NOT NULL,
  `uid` int(10) NOT NULL DEFAULT '0',
  `company_name` text ,
  `end_time` date DEFAULT NULL,
  `transformer_type` text ,
  `number` text  COMMENT '',
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
alter table san_zhaobiao  change tender_fee tender_fee  text  default '' not null;  
alter table san_toubiao  change tender_fee tender_fee  text  default '' not null;  
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
ALTER TABLE `san_quote_kaibiao_result` ADD `baoliu` text AFTER `fudian` ;
ALTER TABLE `san_quote_kaibiao_result` ADD `xiafu` text  AFTER `fudian` ;
ALTER TABLE san_zhaobiao ADD `bid_fee` text NOT NULL  AFTER `is_deleted` ;
ALTER TABLE san_zhaobiao ADD `place_fee` text NOT NULL  AFTER `is_deleted` ;
ALTER TABLE san_zhaobiao ADD `skill_fee` text NOT NULL  AFTER `is_deleted` ;
ALTER TABLE san_zhaobiao ADD `bid_fee_value` double NOT NULL  AFTER `bid_fee` ;
ALTER TABLE san_toubiao ADD `bid_fee` text NOT NULL  AFTER `is_deleted` ;
ALTER TABLE san_toubiao ADD `place_fee` text NOT NULL  AFTER `is_deleted` ;
ALTER TABLE san_toubiao ADD `skill_fee` text NOT NULL  AFTER `is_deleted` ;
ALTER TABLE san_toubiao ADD `bid_fee_value` double NOT NULL  AFTER `bid_fee` ;
ALTER TABLE `san_zhaobiao` CHANGE COLUMN `bid_fee_value` `bid_fee_value` TEXT NOT NULL;
ALTER TABLE san_quote_kaibiao_result ADD `ji_zhun_price` double NOT NULL  AFTER `xiafu` ;
ALTER TABLE san_toubiao ADD `bid_valid` text NOT NULL  AFTER `skill_fee` ;
ALTER TABLE san_zhaobiao ADD `bid_valid` text NOT NULL  AFTER `skill_fee` ;

