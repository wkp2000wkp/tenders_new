ALTER TABLE tenders_waimao.san_toubiao ADD `bid_valid` text NOT NULL  AFTER `skill_fee` ;
ALTER TABLE tenders_waimao.san_zhaobiao ADD `bid_valid` text NOT NULL  AFTER `skill_fee` ;
ALTER TABLE tenders_waimao.san_toubiao ADD `currency` text NOT NULL  AFTER `skill_fee` ;
ALTER TABLE tenders_waimao.san_zhaobiao ADD `currency` text NOT NULL  AFTER `skill_fee` ;
ALTER TABLE tenders_waimao.san_toubiao ADD `other_currency` text NOT NULL  AFTER `skill_fee` ;
ALTER TABLE tenders_waimao.san_zhaobiao ADD `other_currency` text NOT NULL  AFTER `skill_fee` ;
alter table tenders_waimao.san_zhaobiao drop column place_fee;
alter table tenders_waimao.san_toubiao drop column place_fee;