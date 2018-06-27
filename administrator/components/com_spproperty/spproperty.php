<?php
/**
 * @package     SP Property
 *
 * @copyright   Copyright (C) 2010 - 2016 JoomShaper. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined ('_JEXEC') or die('resticted aceess');

$doc = JFactory::getDocument();
$doc->addStylesheet( JURI::base(true) . '/components/com_spproperty/assets/css/style.css' );

// Load FOF
include_once JPATH_LIBRARIES.'/fof/include.php';
if(!defined('FOF_INCLUDED')) {
	JFactory::getApplication()->enqueueMessage('FOF is not installed', '500');
}

FOFDispatcher::getTmpInstance('com_spproperty')->dispatch();