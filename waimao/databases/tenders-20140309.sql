
ALTER TABLE san_toubiao ADD `currency_bid_fee` text NOT NULL  AFTER `bid_fee` ;
ALTER TABLE san_toubiao ADD `other_currency_bid_fee` text NOT NULL  AFTER `bid_fee` ;
ALTER TABLE san_zhaobiao ADD `currency_bid_fee` text NOT NULL  AFTER `bid_fee` ;
ALTER TABLE san_zhaobiao ADD `other_currency_bid_fee` text NOT NULL  AFTER `bid_fee` ;

ALTER TABLE san_toubiao ADD `currency_bid_bond` text NOT NULL  AFTER `bid_bond` ;
ALTER TABLE san_toubiao ADD `other_currency_bid_bond` text NOT NULL  AFTER `bid_bond` ;
ALTER TABLE san_zhaobiao ADD `currency_bid_bond` text NOT NULL  AFTER `bid_bond` ;
ALTER TABLE san_zhaobiao ADD `other_currency_bid_bond` text NOT NULL  AFTER `bid_bond` ;



ALTER TABLE san_quote_kaibiao_result ADD `currency_ji_zhun_price` text NOT NULL  AFTER `ji_zhun_price` ;
ALTER TABLE san_quote_kaibiao_result ADD `other_currency_ji_zhun_price` text NOT NULL  AFTER `ji_zhun_price` ;
