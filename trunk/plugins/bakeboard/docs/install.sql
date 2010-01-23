CREATE TABLE `bs_forums` (
  `id` int(5) NOT NULL auto_increment,
  `sort` int(11) unsigned NOT NULL default '0',
  `name` varchar(250) collate utf8_bin NOT NULL default '',
  `description` text collate utf8_bin NOT NULL,
  `created` datetime default NULL,
  `modified` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB;