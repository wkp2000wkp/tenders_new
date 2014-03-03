ALTER TABLE tenders.san_zhaobiao ADD `bid_fee` text NOT NULL  AFTER `is_deleted` ;
ALTER TABLE tenders.san_zhaobiao ADD `place_fee` text NOT NULL  AFTER `is_deleted` ;
ALTER TABLE tenders.san_zhaobiao ADD `skill_fee` text NOT NULL  AFTER `is_deleted` ;
ALTER TABLE tenders.san_zhaobiao ADD `bid_fee_value` double NOT NULL  AFTER `bid_fee` ;
ALTER TABLE tenders.san_toubiao ADD `bid_fee` text NOT NULL  AFTER `is_deleted` ;
ALTER TABLE tenders.san_toubiao ADD `place_fee` text NOT NULL  AFTER `is_deleted` ;
ALTER TABLE tenders.san_toubiao ADD `skill_fee` text NOT NULL  AFTER `is_deleted` ;
ALTER TABLE tenders.san_toubiao ADD `bid_fee_value` double NOT NULL  AFTER `bid_fee` ;