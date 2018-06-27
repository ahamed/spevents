<?php

/**
 * @package     SP Property
 *
 * @copyright   Copyright (C) 2010 - 2016 JoomShaper. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined ('_JEXEC') or die('resticted aceess');

//helper & model
$com_helper 		= JPATH_BASE . '/components/com_spproperty/helpers/helper.php';

if ( file_exists($com_helper) ) {
    require_once($com_helper);
} else {
	echo '<p class="alert alert-warning">' . JText::_('COM_SPPROPERTY_COMPONENT_NOT_INSTALLED_OR_MISSING_FILE') . '</p>';
	return;
}


JHtml::_('jquery.framework');
$doc = JFactory::getDocument();

// Include JS

// Include CSS files
$doc->addStylesheet( JURI::root(true) . '/components/com_spproperty/assets/css/spproperty-structure.css' );
$doc->addStylesheet( JURI::root(true) . '/components/com_spproperty/assets/css/style.css' );
$doc->addStylesheet( JURI::root(true) . '/components/com_spproperty/assets/css/font-awesome.min.css' );


// Load FOF
include_once JPATH_LIBRARIES.'/fof/include.php';

if(!defined('FOF_INCLUDED')) {
	JFactory::getApplication()->enqueueMessage('FOF is not installed', '500');
}

FOFDispatcher::getTmpInstance('com_spproperty')->dispatch();