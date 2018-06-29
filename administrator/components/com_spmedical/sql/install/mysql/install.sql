/**
* @package com_spmedical
* @author JoomShaper http://www.joomshaper.com
* @copyright Copyright (c) 2010 - 2018 JoomShaper
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/

-- Create syntax for TABLE '#__spmedical_departments'
CREATE TABLE IF NOT EXISTS `#__spmedical_departments` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `asset_id` int(11) DEFAULT NULL,
  `title` varchar(255) NOT NULL DEFAULT '',
  `alias` varchar(50) NOT NULL DEFAULT '',
  `icon_image` varchar(100) DEFAULT NULL,
  `icon` varchar(100) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `description` text NOT NULL,
  `treatments` text NOT NULL,
  `investigations` text,
  `others_services` text NOT NULL,
  `published` tinyint(1) NOT NULL DEFAULT '1',
  `access` int(5) NOT NULL DEFAULT '1',
  `language` char(7) NOT NULL DEFAULT '*',
  `ordering` int(10) NOT NULL DEFAULT '0',
  `created_by` bigint(20) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_by` bigint(20) NOT NULL DEFAULT '0',
  `modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `checked_out` bigint(20) NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Create syntax for TABLE '#__spmedical_specialists'
CREATE TABLE IF NOT EXISTS `#__spmedical_specialists` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `asset_id` int(11) DEFAULT NULL,
  `title` varchar(255) NOT NULL DEFAULT '',
  `alias` varchar(50) NOT NULL DEFAULT '',
  `designation` varchar(100) DEFAULT NULL,
  `department_id` int(11) NOT NULL,
  `gender` char(1) NOT NULL,
  `specialitist_on` varchar(100) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `description` text NOT NULL,
  `experiences` text NOT NULL,
  `awards_honers` text,
  `educations` text NOT NULL,
  `visiting_times` text,
  `email` varchar(100) DEFAULT '',
  `phone` varchar(55) DEFAULT NULL,
  `socials` text,
  `website` varchar(155) DEFAULT NULL,
  `published` tinyint(1) NOT NULL DEFAULT '1',
  `access` int(5) NOT NULL DEFAULT '1',
  `language` char(7) NOT NULL DEFAULT '*',
  `ordering` int(10) NOT NULL DEFAULT '0',
  `created_by` bigint(20) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_by` bigint(20) NOT NULL DEFAULT '0',
  `modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `checked_out` bigint(20) NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `specialitist_on` (`specialitist_on`),
  KEY `title` (`title`),
  KEY `alias` (`alias`),
  KEY `department_id` (`department_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- Create syntax for TABLE '#__spmedical_appointments'
CREATE TABLE IF NOT EXISTS `#__spmedical_appointments` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `asset_id` int(11) DEFAULT NULL,
  `patient_name` varchar(155) NOT NULL DEFAULT '',
  `patient_phone` varchar(50) NOT NULL DEFAULT '',
  `patient_email` varchar(100) DEFAULT NULL,
  `appintment_date` date DEFAULT NULL,
  `appintment_time` time DEFAULT '00:00:00',
  `patient_note` text NOT NULL,
  `specialist_id` int(11) NOT NULL,
  `department_id` int(11) DEFAULT NULL,
  `visitorip` int(10) UNSIGNED NOT NULL,
  `published` tinyint(1) NOT NULL DEFAULT '1',
  `ordering` int(10) NOT NULL DEFAULT '0',
  `created_by` bigint(20) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_by` bigint(20) NOT NULL DEFAULT '0',
  `modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `checked_out` bigint(20) NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
