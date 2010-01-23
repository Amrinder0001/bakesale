INSERT INTO `bs_countries` (`id`, `code`, `code3`, `active`, `sort`, `name`) VALUES (2, 'US', 'USA', 1, 1, 'USA');

#####

INSERT INTO `bs_contents` (`id`, `content_category_id`, `active`, `name`, `description`) VALUES (1, 2, 1, 'Home', '<p>This is the demo of the BakeSale shopping cart. Items you find here have affiliate links on them, and by shopping here, you support the BakeSale project.</p>\r\n<p>The demo installation is here to show-case BakeSale''s features, but if there is something you wonder about, just ask a question in the <a href="http://forum.bakesalehq.com/">forum</a></p>');

#####

INSERT INTO `bs_contents` (`id`, `content_category_id`, `active`, `name`, `description`) VALUES (2, 1, 1, 'Contact information', 'Name\r\n\r\nAddress\r\n\r\nEmail\r\n\r\nPhone number\r\n\r\n');

#####

INSERT INTO `bs_contents` (`id`, `content_category_id`, `active`, `name`, `description`) VALUES (3, 1, 1, 'About us', 'Information about the company');

#####

INSERT INTO `bs_contents` (`id`, `content_category_id`, `active`, `name`, `description`) VALUES (4, 1, 1, 'Privacy', 'Information about the companys privacy policy');

#####

INSERT INTO `bs_contents` (`id`, `content_category_id`, `active`, `name`, `description`) VALUES (5, 2, 1, 'Order confirmation', 'Thank you for your order');

#####

INSERT INTO `bs_contents` (`id`, `content_category_id`, `active`, `name`, `description`) VALUES (6, 2, 1, '404 page', 'We are sorry, but the page you tried to reach is not available.');

#####

INSERT INTO `bs_content_categories` ( `id` , `parent_id` , `active` , `name` , `description`)
VALUES (
NULL , '0', '0', 'Menu', '');

#####

INSERT INTO `bs_content_categories` ( `id` ,  `parent_id` , `active` , `name` , `description`)
VALUES (
NULL , '0', '0', 'Messages', '');

#####

INSERT INTO `bs_user_categories` ( `id` ,  `name`)
VALUES (
1 , 'Admin');
