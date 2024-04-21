UPDATE `wp_options` SET `option_value` = REPLACE(`option_value`, (SELECT distinct `option_value` FROM `wp_options` WHERE `option_name`="siteurl"), "http://localhost");
