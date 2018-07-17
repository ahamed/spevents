<?php
/**
* @package     SP Movie Database
* @copyright   Copyright (C) 2010 - 2016 JoomShaper. All rights reserved.
* @license     GNU General Public License version 2 or later.
*/

defined('_JEXEC') or die('Restricted access!');

// Load the method jquery script.
JHtml::_('jquery.framework');

$doc = JFactory::getDocument();
$doc->addStylesheet( JURI::root(true).'/administrator/components/com_spmoviedb/assets/css/spmoviedb.css' );
$doc->addScript( JURI::root(true).'/administrator/components/com_spmoviedb/assets/js/spmoviedb.js' );

// Load FOF
include_once JPATH_LIBRARIES.'/fof/include.php';
if(!defined('FOF_INCLUDED')) {
	JError::raiseError ('500', 'FOF is not installed');

	return;
}

FOFDispatcher::getTmpInstance('com_spmoviedb')->dispatch();