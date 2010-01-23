
CREATE TABLE `bs_locales` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `code` char(2) NOT NULL default '',
  `code3` char(3) NOT NULL default '',
  `lang_attribute` char(2) NOT NULL,
  `direction` char(3) NOT NULL,
  `name` varchar(255) NOT NULL default '',
  `translators` text,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `code_2` (`code`),
  UNIQUE KEY `code3` (`code3`),
  KEY `code` (`code`)
) ENGINE=InnoDB;

CREATE TABLE `bs_msgids` (
  `id` int(11) NOT NULL auto_increment,
  `user_id` int(11) default NULL,
  `locale_id` int(11) NOT NULL default '0',
  `msgstr_id` int(11) NOT NULL default '0',
  `text` varchar(255) character set latin1 NOT NULL default '',
  `ip` varchar(255) collate utf8_bin NOT NULL,
  `created` datetime default NULL,
  `modified` datetime default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `locale_id` (`locale_id`,`msgstr_id`),
  KEY `text` (`text`)
) ENGINE=InnoDB;


CREATE TABLE `bs_msgstr_group` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `sort` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB;



CREATE TABLE `bs_msgstrs` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `msgstr_group_id` int(11) NOT NULL default '0',
  `active` tinyint(2) NOT NULL,
  `define` varchar(255) NOT NULL default '',
  `msgstr` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `sort` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB;
