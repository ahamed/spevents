--
-- table structure for table `#__spevents_events`
--

CREATE TABLE IF NOT EXISTS `#__spevents_events` (
    `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
    `title` VARCHAR(255) NOT NULL,
    `alias` VARCHAR(255) NOT NULL DEFAULT '',
    `description` TEXT,
    `start_date` DATE DEFAULT '0000-00-00',
    `end_date` DATE DEFAULT '0000-00-00',
    `start_time` TIME DEFAULT '00:00:00',
    `end_time` TIME DEFAULT '00:00:00',
    `timezone` VARCHAR(20) NOT NULL DEFAULT '',
    `logo` TEXT,
    `banner` TEXT,
    `organizers` VARCHAR(255) NOT NULL,
    `seats` INT(11) NOT NULL DEFAULT '0',
    `physical_location` TINYINT(3) NOT NULL DEFAULT '0',
    `location` INT(11) NOT NULL,
    `categories` VARCHAR(255) NOT NULL,
    `social_tags` TEXT,
    `url` VARCHAR(255) DEFAULT '',
    `tags` VARCHAR(255) DEFAULT NULL,
    `repeatable` TINYINT(3) DEFAULT '0',
    `recurring` TEXT,
    `registration` TEXT,
    `settings` TEXT,
    `all_day_event` TINYINT(3) NOT NULL DEFAULT '0',
    `tickets` TEXT,
    `gallery` TEXT,
    `hits` INT(11) NOT NULL DEFAULT '0',
    `currency` CHAR(20) NOT NULL DEFAULT '',
    `featured` TINYINT(3) NOT NULL DEFAULT '0',
    `enabled` tinyint(3) NOT NULL DEFAULT '1',
    `language` varchar(255) NOT NULL DEFAULT '*',
    `access` int(5) NOT NULL DEFAULT '1',
    `ordering` int(10) NOT NULL DEFAULT '0',
    `created_by` bigint(20) NOT NULL DEFAULT '0',
    `created_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
    `modified_by` bigint(20) NOT NULL DEFAULT '0',
    `modified_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
    `locked_by` bigint(20) NOT NULL DEFAULT '0',
    `locked_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
    PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;


--
-- table structure for table `#__spevents_tickets`
--

CREATE TABLE IF NOT EXISTS `#__spevents_tickets` (
    `id` BIGINT(20) unsigned NOT NULL AUTO_INCREMENT,
    `title` VARCHAR(255) NOT NULL,
    `alias` VARCHAR(255) NOT NULL DEFAULT '',
    `description` TEXT,
    `price` INT(11) NOT NULL DEFAULT '0',
    `seat` INT(11) DEFAULT '0',
    `max_purchase` INT(11) DEFAULT '0',
    `discount` VARCHAR(255),
    `enabled` tinyint(3) NOT NULL DEFAULT '1',
    `language` varchar(255) NOT NULL DEFAULT '*',
    `access` int(5) NOT NULL DEFAULT '1',
    `ordering` int(10) NOT NULL DEFAULT '0',
    `created_by` bigint(20) NOT NULL DEFAULT '0',
    `created_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
    `modified_by` bigint(20) NOT NULL DEFAULT '0',
    `modified_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
    `locked_by` bigint(20) NOT NULL DEFAULT '0',
    `locked_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
    PRIMARY KEY(`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;


-- 
-- table structure for table `#__spevents_speakers`
--

CREATE TABLE IF NOT EXISTS `#__spevents_speakers`(
    `id` BIGINT(20) unsigned NOT NULL AUTO_INCREMENT,
    `title` VARCHAR(255) NOT NULL,
    `alias` VARCHAR(255) NOT NULL DEFAULT '',
    `designation` VARCHAR(255) NOT NULL,
    `description` TEXT,
    `image` VARCHAR(255) DEFAULT '0',
    `social_links` TEXT,
    `enabled` tinyint(3) NOT NULL DEFAULT '1',
    `language` varchar(255) NOT NULL DEFAULT '*',
    `access` int(5) NOT NULL DEFAULT '1',
    `ordering` int(10) NOT NULL DEFAULT '0',
    `created_by` bigint(20) NOT NULL DEFAULT '0',
    `created_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
    `modified_by` bigint(20) NOT NULL DEFAULT '0',
    `modified_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
    `locked_by` bigint(20) NOT NULL DEFAULT '0',
    `locked_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
    PRIMARY KEY(`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;


--
-- table structure for table `#__spevents_sessions`
--

CREATE TABLE IF NOT EXISTS `#__spevents_sessions`
(
    `id` BIGINT(20) unsigned NOT NULL AUTO_INCREMENT,
    `title` VARCHAR(255) NOT NULL,
    `alias` VARCHAR(255) NOT NULL DEFAULT '',
    `event_id` BIGINT(20) unsigned NOT NULL,
    `date` DATE NOT NULL DEFAULT '0000-00-00',
    `time_from` TIME NOT NULL DEFAULT '00:00:00',
    `time_to` TIME NOT NULL DEFAULT '00:00:00',
    `hall` VARCHAR(255),
    `speakers` TEXT,
    `description` TEXT,
    `enabled` tinyint(3) NOT NULL DEFAULT '1',
    `language` varchar(255) NOT NULL DEFAULT '*',
    `access` int(5) NOT NULL DEFAULT '1',
    `ordering` int(10) NOT NULL DEFAULT '0',
    `created_by` bigint(20) NOT NULL DEFAULT '0',
    `created_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
    `modified_by` bigint(20) NOT NULL DEFAULT '0',
    `modified_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
    `locked_by` bigint(20) NOT NULL DEFAULT '0',
    `locked_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
    PRIMARY KEY(`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

--
-- table structure for table `#__spevents_users`
--

CREATE TABLE IF NOT EXISTS `#__spevents_users` (
    `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
    `user_id` INT(11) NOT NULL,
    `address` TEXT,
    `phone` VARCHAR(20),
    `enabled` tinyint(3) NOT NULL DEFAULT '1',
    `language` varchar(255) NOT NULL DEFAULT '*',
    `access` int(5) NOT NULL DEFAULT '1',
    `ordering` int(10) NOT NULL DEFAULT '0',
    `created_by` bigint(20) NOT NULL DEFAULT '0',
    `created_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
    `modified_by` bigint(20) NOT NULL DEFAULT '0',
    `modified_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
    `locked_by` bigint(20) NOT NULL DEFAULT '0',
    `locked_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
    PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;


--
-- table structure for table `#__spevents_bookings`
--

CREATE TABLE IF NOT EXISTS `#__spevents_bookings` (
    `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
    `user_id` INT(11) NOT NULL,
    `event_id` bigint(20) unsigned NOT NULL,
    `description` TEXT,
    `payment_id` VARCHAR(100) NOT NULL DEFAULT '',
    `invoice_id` VARCHAR(255) NOT NULL DEFAULT '',
    `payment_type` VARCHAR(10) NOT NULL DEFAULT '0',
    `seat_booked` INT(11) NOT NULL DEFAULT '0',
    `sale_price` FLOAT(8,2) NOT NULL DEFAULT '0.0',
    `enabled` tinyint(3) NOT NULL DEFAULT '1',
    `language` varchar(255) NOT NULL DEFAULT '*',
    `access` int(5) NOT NULL DEFAULT '1',
    `ordering` int(10) NOT NULL DEFAULT '0',
    `created_by` bigint(20) NOT NULL DEFAULT '0',
    `created_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
    `modified_by` bigint(20) NOT NULL DEFAULT '0',
    `modified_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
    `locked_by` bigint(20) NOT NULL DEFAULT '0',
    `locked_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
    PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;



--
-- table structure for table `#__spevents_organizers`
--

CREATE TABLE IF NOT EXISTS `#__spevents_organizers` (
    `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
    `title` VARCHAR(255) NOT NULL,
    `alias` VARCHAR(255) NOT NULL DEFAULT '',
    `description` TEXT,
    `phone` VARCHAR(20) NOT NULL DEFAULT '',
    `website` VARCHAR(255),
    `email` VARCHAR(100),
    `logo` TEXT,
    `team_members` TEXT,
    `enabled` tinyint(3) NOT NULL DEFAULT '1',
    `language` varchar(255) NOT NULL DEFAULT '*',
    `access` int(5) NOT NULL DEFAULT '1',
    `ordering` int(10) NOT NULL DEFAULT '0',
    `created_by` bigint(20) NOT NULL DEFAULT '0',
    `created_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
    `modified_by` bigint(20) NOT NULL DEFAULT '0',
    `modified_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
    `locked_by` bigint(20) NOT NULL DEFAULT '0',
    `locked_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
    PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;


--
-- table structure for table `#__spevents_locations`
--

CREATE TABLE IF NOT EXISTS `#__spevents_locations` (
    `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
    `venue_name` VARCHAR(255) NOT NULL,
    `alias` VARCHAR(255) NOT NULL DEFAULT '',
    `description` TEXT,
    `address` TEXT,
    `city` VARCHAR(100) NOT NULL DEFAULT '',
    `country` VARCHAR(30) NOT NULL DEFAULT '',
    `state` VARCHAR(100) NOT NULL DEFAULT '',
    `postal_code` VARCHAR(20) NOT NULL DEFAULT '',
    `phone` VARCHAR(20) NOT NULL DEFAULT '',
    `website` VARCHAR(255) DEFAULT '',
    `image` TEXT,
    `lat_lng` VARCHAR(255) DEFAULT '',
    `enabled` tinyint(3) NOT NULL DEFAULT '1',
    `language` varchar(255) NOT NULL DEFAULT '*',
    `access` int(5) NOT NULL DEFAULT '1',
    `ordering` int(10) NOT NULL DEFAULT '0',
    `created_by` bigint(20) NOT NULL DEFAULT '0',
    `created_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
    `modified_by` bigint(20) NOT NULL DEFAULT '0',
    `modified_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
    `locked_by` bigint(20) NOT NULL DEFAULT '0',
    `locked_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
    PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;



--
-- table structure for table `#__spevents_categories`
--


CREATE TABLE IF NOT EXISTS `#__spevents_categories` (
    `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
    `title` VARCHAR(255) NOT NULL,
    `alias` VARCHAR(255) NOT NULL DEFAULT '',
    `description` TEXT,
    `image` TEXT,
    `enabled` tinyint(3) NOT NULL DEFAULT '1',
    `language` varchar(255) NOT NULL DEFAULT '*',
    `access` int(5) NOT NULL DEFAULT '1',
    `ordering` int(10) NOT NULL DEFAULT '0',
    `created_by` bigint(20) NOT NULL DEFAULT '0',
    `created_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
    `modified_by` bigint(20) NOT NULL DEFAULT '0',
    `modified_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
    `locked_by` bigint(20) NOT NULL DEFAULT '0',
    `locked_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
    PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

--
--  table structure for table `#__spevents_coupons`
--


CREATE TABLE IF NOT EXISTS `#__spevents_coupons` (
    `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
    `title` VARCHAR(255) NOT NULL,
    `alias` VARCHAR(255) NOT NULL DEFAULT '',
    `code` VARCHAR(200) NOT NULL,
    `from` DATE NOT NULL DEFAULT '0000-00-00',
    `to` DATE NOT NULL DEFAULT '0000-00-00',
    `max_usage` INT(11) DEFAULT '0',
    `amount` FLOAT(8,2) DEFAULT '0',
    `type` VARCHAR(100) NOT NULL DEFAULT 'value',
    `description` TEXT,
    `enabled` tinyint(3) NOT NULL DEFAULT '1',
    `language` varchar(255) NOT NULL DEFAULT '*',
    `access` int(5) NOT NULL DEFAULT '1',
    `ordering` int(10) NOT NULL DEFAULT '0',
    `created_by` bigint(20) NOT NULL DEFAULT '0',
    `created_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
    `modified_by` bigint(20) NOT NULL DEFAULT '0',
    `modified_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
    `locked_by` bigint(20) NOT NULL DEFAULT '0',
    `locked_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
    PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;



-- 
--  table structure for table `#__spevents_tags`
--

CREATE TABLE IF NOT EXISTS `#__spevents_tags` (
    `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
    `title` VARCHAR(255) NOT NULL,
    `alias` VARCHAR(255) NOT NULL DEFAULT '',
    `description` TEXT,
    `enabled` tinyint(3) NOT NULL DEFAULT '1',
    `language` varchar(255) NOT NULL DEFAULT '*',
    `access` int(5) NOT NULL DEFAULT '1',
    `ordering` int(10) NOT NULL DEFAULT '0',
    `created_by` bigint(20) NOT NULL DEFAULT '0',
    `created_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
    `modified_by` bigint(20) NOT NULL DEFAULT '0',
    `modified_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
    `locked_by` bigint(20) NOT NULL DEFAULT '0',
    `locked_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
    PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;




--
--  table structure for table `#__spevents_subscriptions`
--


CREATE TABLE IF NOT EXISTS `#__spevents_subscriptions` (
    `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
    `email` VARCHAR(255) NOT NULL,
    `enabled` tinyint(3) NOT NULL DEFAULT '1',
    `language` varchar(255) NOT NULL DEFAULT '*',
    `access` int(5) NOT NULL DEFAULT '1',
    `ordering` int(10) NOT NULL DEFAULT '0',
    `created_by` bigint(20) NOT NULL DEFAULT '0',
    `created_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
    `modified_by` bigint(20) NOT NULL DEFAULT '0',
    `modified_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
    `locked_by` bigint(20) NOT NULL DEFAULT '0',
    `locked_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
    PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;


--
--  table structure for table `#__spevents_orders`
--


CREATE TABLE IF NOT EXISTS `#__spevents_orders` (
    `id` BIGINT(20) unsigned NOT NULL AUTO_INCREMENT,
    `order_id` VARCHAR(255) NOT NULL,
    `customer_id` BIGINT(20) unsigned NOT NULL,
    `price` FLOAT(8,2) NOT NULL DEFAULT '0.0',
    `quantity` INT(11) NOT NULL DEFAULT '1',
    `status` VARCHAR(100),
    `enabled` tinyint(3) NOT NULL DEFAULT '1',
    `language` varchar(255) NOT NULL DEFAULT '*',
    `access` int(5) NOT NULL DEFAULT '1',
    `ordering` int(10) NOT NULL DEFAULT '0',
    `created_by` bigint(20) NOT NULL DEFAULT '0',
    `created_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
    `modified_by` bigint(20) NOT NULL DEFAULT '0',
    `modified_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
    `locked_by` bigint(20) NOT NULL DEFAULT '0',
    `locked_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
    PRIMARY KEY(`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;




--
-- table structure for table `#__spevents_images`
--

CREATE TABLE IF NOT EXISTS `#__spevents_images` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `event_id` bigint(20) unsigned NOT NULL,
  `image` TEXT NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;


