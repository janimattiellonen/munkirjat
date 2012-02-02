ALTER TABLE `book` ADD `rating` DOUBLE( 5, 2 ) NOT NULL AFTER `isbn`;
ALTER TABLE `book` ADD INDEX ( `rating` );
ALTER TABLE `book` CHANGE `rating` `rating` DOUBLE( 5, 2 ) NOT NULL DEFAULT '0'
