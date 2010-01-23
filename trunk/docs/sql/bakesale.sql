DROP TABLE IF EXISTS `bs_cake_sessions`;
CREATE TABLE `bs_cake_sessions` (
  `id` varchar(255) NOT NULL default '',
  `data` text,
  `expires` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB;

#####

DROP TABLE IF EXISTS `bs_brands`;
CREATE TABLE `bs_brands` (
  `id` int(5) NOT NULL auto_increment,
  `active` tinyint(1) NOT NULL default '0',
  `name` varchar(250) NOT NULL default '',
  `created` datetime default NULL,
  `modified` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB ;

#####

DROP TABLE IF EXISTS `bs_categories`;
CREATE TABLE `bs_categories` (
  `id` int(5) NOT NULL auto_increment,
  `parent_id` int(10) NOT NULL default '0',
  `lft` int(10) UNSIGNED DEFAULT NULL,
  `rght` int(10) UNSIGNED DEFAULT NULL,
  `active` tinyint(1) unsigned NOT NULL default '0',
  `sort` int(11) unsigned NOT NULL default '0',
  `name` varchar(250) NOT NULL default '',
  `description` text NOT NULL,
  `images` text NOT NULL,
  `created` datetime default NULL,
  `modified` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB ;

#####

DROP TABLE IF EXISTS `bs_categories_products`;
CREATE TABLE `bs_categories_products` (
  `category_id` int(10) unsigned NOT NULL default '0',
  `product_id` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`product_id`,`category_id`)
) ENGINE=InnoDB;

#####

DROP TABLE IF EXISTS `bs_contents`;
CREATE TABLE `bs_contents` (
  `id` int(5) NOT NULL auto_increment,
  `content_category_id` int(5) NOT NULL default '0',
  `active` tinyint(1) NOT NULL default '1',
  `sort` int(11) unsigned NOT NULL default '0',
  `name` varchar(250) NOT NULL default '',
  `description` text NOT NULL,
  `url` varchar(255) default NULL,
  `images` text default NULL,
  `created` datetime default NULL,
  `modified` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB ;

#####

DROP TABLE IF EXISTS `bs_content_categories`;
CREATE TABLE `bs_content_categories` (
  `id` int(5) NOT NULL auto_increment,
  `parent_id` int(10) NOT NULL default '0',
  `lft` int(10) UNSIGNED DEFAULT NULL,
  `rght` int(10) UNSIGNED DEFAULT NULL,
  `active` tinyint(1) unsigned NOT NULL default '0',
  `name` varchar(250) NOT NULL default '',
  `description` text NOT NULL,
  `created` datetime default NULL,
  `modified` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB ;

#####

DROP TABLE IF EXISTS `bs_countries`;
CREATE TABLE `bs_countries` (
  `id` int(3) NOT NULL auto_increment,
  `active` tinyint(1) NOT NULL default '0',
  `code` char(2) NOT NULL default '',
  `code3` char(3) NOT NULL default '',
  `sort` int(11) NOT NULL default '0',
  `name` varchar(64) NOT NULL default '',
  `created` datetime default NULL,
  `modified` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB ;

#####

DROP TABLE IF EXISTS `bs_countries_shipping_methods`;
CREATE TABLE `bs_countries_shipping_methods` (
  `country_id` int(5) NOT NULL default '0',
  `shipping_method_id` int(5) NOT NULL default '0',
  PRIMARY KEY  (`country_id`,`shipping_method_id`)
) ENGINE=InnoDB;

#####

DROP TABLE IF EXISTS `bs_line_items`;
CREATE TABLE `bs_line_items` (
  `id` int(11) NOT NULL auto_increment,
  `order_id` int(11) default NULL,
  `product_id` int(11) NOT NULL default '0',
  `subproduct_id` int(11) NOT NULL default '0',
  `brand_id` int(11) NOT NULL default '0',
  `product` varchar(255) NOT NULL default '',
  `subproduct` varchar(255) default NULL,
  `quantity` int(11) NOT NULL default '1',
  `price` decimal(19,8) NOT NULL default '0.00000000',
  `created` datetime default NULL,
  `modified` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB ;

#####

DROP TABLE IF EXISTS `bs_orders`;
CREATE TABLE `bs_orders` (
  `id` int(11) NOT NULL auto_increment,
  `account_id` int(11) default NULL,
  `shipping_method_id` int(11) NOT NULL default '0',
  `payment_method_id` int(11) NOT NULL default '0',
  `country_id` int(5) NOT NULL,
  `session` varchar(64) NOT NULL default '',
  `number` int(11) NOT NULL default '0',
  `firstname` varchar(64) NOT NULL default '',
  `lastname` varchar(64) NOT NULL default '',
  `email` varchar(64) NOT NULL default '',
  `phone` varchar(32) NOT NULL default '',
  `address` varchar(64) NOT NULL default '',
  `postcode` varchar(10) NOT NULL default '0',
  `city` varchar(64) NOT NULL default '',
  `state` varchar(255) default NULL,
  `country` varchar(64) NOT NULL default '',
  `s_firstname` varchar(64) NOT NULL,
  `s_lastname` varchar(64) NOT NULL,
  `s_address` varchar(64) NOT NULL,
  `s_postcode` varchar(64) NOT NULL,
  `s_city` varchar(64) NOT NULL,
  `s_state` varchar(64) NOT NULL,
  `s_country` varchar(64) NOT NULL,
  `shipping_method` varchar(100) NOT NULL default '',
  `shipping_price` decimal(19,8) NOT NULL default '0.00000000',
  `payment_method` varchar(100) NOT NULL default '',
  `payment_price` decimal(19,8) NOT NULL default '0.00000000',
  `discount` decimal(19,8) NOT NULL default '0.00000000',
  `state_tax` decimal(6,6) NOT NULL default '0.000000',
  `comments` text,
  `created` datetime default NULL,
  `modified` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB;

#####

DROP TABLE IF EXISTS `bs_payment_methods`;
CREATE TABLE `bs_payment_methods` (
  `id` int(5) NOT NULL auto_increment,
  `active` tinyint(1) unsigned default '0',
  `price` decimal(19,8) NOT NULL default '0.00000000',
  `sort` int(11) NOT NULL default '0',
  `processor` varchar(255) NOT NULL default '',
  `name` varchar(250) NOT NULL default '',
  `created` datetime default NULL,
  `modified` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB ;

#####

DROP TABLE IF EXISTS `bs_products`;
CREATE TABLE `bs_products` (
  `id` int(11) NOT NULL auto_increment,
  `brand_id` int(11) NOT NULL default '0',
  `active` tinyint(1) NOT NULL default '1',
  `cart` tinyint(1) NOT NULL default '1',
  `price` decimal(19,8) NULL default '0.00000000',
  `special_price` decimal(19,8) NULL,
  `quantity` int(10) unsigned default NULL,
  `weight` decimal(19,8) default NULL,
  `name` varchar(250) NOT NULL default '',
  `description` text NOT NULL,
  `images` text NOT NULL,
  `created` datetime default NULL,
  `modified` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB ;

#####

DROP TABLE IF EXISTS `bs_shipping_methods`;
CREATE TABLE `bs_shipping_methods` (
  `id` int(5) unsigned NOT NULL auto_increment,
  `active` tinyint(1) unsigned default '0',
  `sort` int(11) NOT NULL default '0',
  `price` decimal(19,8) NOT NULL default '0.00000000',
  `processor` varchar(255) NOT NULL default '',
  `name` varchar(100) NOT NULL default '',
  `created` datetime default NULL,
  `modified` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB ;

#####

DROP TABLE IF EXISTS `bs_shipping_rules`;
CREATE TABLE `bs_shipping_rules` (
  `id` int(7) NOT NULL auto_increment,
  `shipping_method_id` int(5) NOT NULL default '0',
  `type` varchar(64) NOT NULL default 'weight',
  `min` decimal(19,8) NOT NULL default '0.00000000',
  `max` decimal(19,8) NOT NULL default '0.00000000',
  `price` decimal(19,8) NOT NULL default '0.00000000',
  `created` datetime default NULL,
  `modified` datetime default NULL,
  PRIMARY KEY  (`id`),
  KEY `shipping_method_id` (`shipping_method_id`)
) ENGINE=InnoDB ;

#####

DROP TABLE IF EXISTS `bs_subproducts`;
CREATE TABLE `bs_subproducts` (
  `id` int(11) NOT NULL auto_increment,
  `product_id` int(11) NOT NULL default '0',
  `quantity` int(10) NOT NULL default '0',
  `price` decimal(19,8) NOT NULL default '0.00000000',
  `weight` decimal(19,4) NOT NULL default '0.0000',
  `sort` int(11) NOT NULL default '0',
  `name` varchar(255) NOT NULL default '',
  `created` datetime default NULL,
  `modified` datetime default NULL,
  PRIMARY KEY  (`id`),
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB ;

#####

DROP TABLE IF EXISTS `bs_users`;
CREATE TABLE `bs_users` (
  `id` int(5) NOT NULL auto_increment,
  `shipping_method_id` int(11) NOT NULL default '0',
  `payment_method_id` int(11) NOT NULL default '0',
  `country_id` int(5) NOT NULL,
  `active` tinyint(1) NOT NULL,
  `username` varchar(250) NOT NULL,
  `password` varchar(255) NOT NULL,
  `firstname` varchar(64) NOT NULL default '',
  `lastname` varchar(64) NOT NULL default '',
  `email` varchar(64) NOT NULL default '',
  `phone` varchar(32) NOT NULL default '',
  `address` varchar(64) NOT NULL default '',
  `postcode` varchar(10) NOT NULL default '0',
  `city` varchar(64) NOT NULL default '',
  `state` varchar(2) default NULL,
  `created` datetime default NULL,
  `modified` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB;

#####

DROP TABLE IF EXISTS `bs_user_categories`;
CREATE TABLE `bs_user_categories` (
  `id` int(6) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL,
  `modified` datetime default NULL,
  `created` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB;

#####

DROP TABLE IF EXISTS `bs_user_categories_users`;
CREATE TABLE `bs_user_categories_users` (
  `user_category_id` int(5) NOT NULL,
  `user_id` int(5) NOT NULL
) ENGINE=InnoDB;

#####

DROP TABLE IF EXISTS `bs_discount_codes`;
CREATE TABLE `bs_discount_codes` (
  `id` int(5) NOT NULL auto_increment,
  `active` tinyint(1) NOT NULL default '0',
  `name` varchar(64) NOT NULL,
  `discount` decimal(19,8) NOT NULL,
  `discount_type` int(1) NOT NULL,
  `end_at` datetime default NULL,
  `created` datetime default NULL,
  `modified` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB;
