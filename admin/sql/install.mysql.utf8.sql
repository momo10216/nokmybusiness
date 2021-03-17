CREATE TABLE IF NOT EXISTS `#__nok_mybusiness_customers` (
  `id` integer NOT NULL auto_increment,
  `number` varchar(25) default NULL,
  `title` varchar(25) default NULL,
  `firstname` varchar(50) default NULL,
  `name` varchar(50) NOT NULL default '',
  `birthname` varchar(50) default NULL,
  `address` varchar(100) default NULL,
  `city` varchar(50) NOT NULL default '',
  `zip` varchar(10) default NULL,
  `state` varchar(100) default NULL,
  `country` varchar(100) NOT NULL default '',
  `telephone` varchar(25) default NULL,
  `mobile` varchar(25) default NULL,
  `url` varchar(255) default NULL,
  `email` varchar(255) default NULL,
  `user_id` integer default NULL,
  `description` text default NULL,
  `birthday` date default NULL,
  `status` ENUM('INACTIVE', 'ACTIVE') NOT NULL default 'INACTIVE',
  `custom1` varchar(255) default NULL,
  `custom2` varchar(255) default NULL,
  `custom3` varchar(255) default NULL,
  `custom4` varchar(255) default NULL,
  `custom5` varchar(255) default NULL,
  `createdby` varchar(50) NOT NULL default '',
  `createddate` datetime NOT NULL default current_timestamp,
  `modifiedby` varchar(50) NOT NULL default '',
  `modifieddate` datetime NOT NULL default current_timestamp,
  PRIMARY KEY  (`id`),
  KEY `idx_user_id` (`user_id`),
  KEY `idx_remote` (`name`,`firstname`,`address`,`city`,`birthday`)
)  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `#__nok_mybusiness_products` (
  `id` integer NOT NULL auto_increment,
  `catid` int(11) NOT NULL DEFAULT '0',
  `name` varchar(100) NOT NULL default '',
  `number` varchar(100) NOT NULL default '',
  `shorttext` text NULL default NULL,
  `description` text NULL default NULL,
  `picture` varchar(255) NULL default NULL,
  `power` integer NULL default NULL,
  `dimensions` varchar(100) NULL default NULL,
  `protection` varchar(100) NULL default NULL,
  `price` float NULL default NULL,
  `vat` float NULL default NULL,
  `stock` integer NULL default NULL,
  `published` int(1) NOT NULL default 0,
  `status` ENUM('INACTIVE', 'ACTIVE') NOT NULL default 'INACTIVE',
  `createdby` varchar(50) NOT NULL default '',
  `createddate` datetime NOT NULL default current_timestamp,
  `modifiedby` varchar(50) NOT NULL default '',
  `modifieddate` datetime NOT NULL default current_timestamp,
  PRIMARY KEY  (`id`),
  KEY `idx_remote` (`number`)
)  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*
CREATE TABLE IF NOT EXISTS `#__nok_mybusiness_orders` (
  `id` integer NOT NULL auto_increment,
  `customer_id` integer NOT NULL,
  `date` date NOT NULL default CURDATE(),
  `status` varchar(50) NOT NULL default '',
  `createdby` varchar(50) NOT NULL default '',
  `createddate` datetime NOT NULL default current_timestamp,
  `modifiedby` varchar(50) NOT NULL default '',
  `modifieddate` datetime NOT NULL default current_timestamp,
  PRIMARY KEY  (`id`),
  KEY `idx_customer_id` (`customer_id`),
  KEY `idx_remote` (`person_id`,`job`,`begin`)
)  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `#__nok_mybusiness_order_items` (
  `id` integer NOT NULL auto_increment,
  `order_id` integer NOT NULL,
  `product_id` integer NOT NULL,
  `createdby` varchar(50) NOT NULL default '',
  `createddate` datetime NOT NULL default current_timestamp,
  `modifiedby` varchar(50) NOT NULL default '',
  `modifieddate` datetime NOT NULL default current_timestamp,
  PRIMARY KEY  (`id`),
  KEY `idx_order_id` (`order_id`),
  KEY `idx_product_id` (`product_id`),
  KEY `idx_remote` (`person_id`,`job`,`begin`)
)  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `#__nok_mybusiness_templates` (
  `id` integer NOT NULL auto_increment,
  `content` text default NULL,
  `status` ENUM('INACTIVE', 'ACTIVE') NOT NULL default 'INACTIVE',
  `createdby` varchar(50) NOT NULL default '',
  `createddate` datetime NOT NULL default current_timestamp,
  `modifiedby` varchar(50) NOT NULL default '',
  `modifieddate` datetime NOT NULL default current_timestamp,
  PRIMARY KEY  (`id`),
  KEY `idx_order_id` (`order_id`),
  KEY `idx_product_id` (`product_id`),
  KEY `idx_remote` (`person_id`,`job`,`begin`)
)  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
*/
