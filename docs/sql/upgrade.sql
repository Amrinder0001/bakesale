ALTER TABLE `contents` ADD `content_category_id` INT( 5 ) NOT NULL DEFAULT '0' AFTER `id` ;

####

ALTER TABLE `orders` ADD `state_tax` DECIMAL( 6, 6 ) NOT NULL DEFAULT '0' AFTER `payment_price` ;

####

ALTER TABLE `orders` ADD `number` INT( 11 ) NOT NULL DEFAULT '0' AFTER `session` ;


####

RENAME TABLE `order_products`  TO `line_items` ;

####

DROP TABLE IF EXISTS `content_categories`;
CREATE TABLE `content_categories` (
  `id` int(5) NOT NULL auto_increment,
  `parent_id` int(11) NOT NULL default '0',
  `lft` int(11) NOT NULL default '0',
  `rght` int(11) NOT NULL default '0',
  `active` tinyint(1) unsigned NOT NULL default '0',
  `temp` tinyint(1) NOT NULL default '0',
  `sort` int(11) unsigned NOT NULL default '0',
  `name` varchar(250) NOT NULL default '',
  `description` text NOT NULL,
  `created` datetime default NULL,
  `modified` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB;

####

ALTER TABLE `orders` ADD `s_firstname` VARCHAR( 64 ) NOT NULL AFTER `country` ,
ADD `s_lastname` VARCHAR( 64 ) NOT NULL AFTER `s_firstname` ,
ADD `s_address` VARCHAR( 64 ) NOT NULL AFTER `s_lastname` ,
ADD `s_postcode` VARCHAR( 64 ) NOT NULL AFTER `s_address` ,
ADD `s_city` VARCHAR( 64 ) NOT NULL AFTER `s_postcode` ,
ADD `s_state` VARCHAR( 64 ) NOT NULL AFTER `s_city` ,
ADD `s_country` VARCHAR( 64 ) NOT NULL AFTER `s_state` ;

####

DROP TABLE `states`;

####

DROP TABLE `shopping_carts`;

####

DROP TABLE `shopping_cart_products`;

####

ALTER TABLE `brands` CHANGE `active` `active` TINYINT( 1 ) NOT NULL DEFAULT '0';

####

ALTER TABLE `categories` CHANGE `active` `active` TINYINT( 1 ) NOT NULL DEFAULT '0';


####

ALTER TABLE `contents` CHANGE `active` `active` TINYINT( 1 ) NOT NULL DEFAULT '0';

####

ALTER TABLE `products` CHANGE `active` `active` TINYINT( 1 ) NOT NULL DEFAULT '0';

####

ALTER TABLE `products` ADD `special_price` DECIMAL( 19, 8 ) NOT NULL AFTER `price` ;

####

ALTER TABLE `categories` ADD `images` TEXT NOT NULL AFTER `description` ;

####

ALTER TABLE `products` ADD `images` TEXT NOT NULL AFTER `description` ;