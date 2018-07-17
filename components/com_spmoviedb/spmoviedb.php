<?php
/**
 * @package     SP Movie Databse
 *
 * @copyright   Copyright (C) 2010 - 2016 JoomShaper. All rights reserved.
 * @license     GNU General Public License version 2 or later.
 */

defined('_JEXEC') or die('Restricted Access');

//include helper file
require_once JPATH_COMPONENT . '/helpers/helper.php';

//includes js and css
$doc = JFactory::getDocument();
$doc->addStylesheet( JURI::root(true) . '/components/com_spmoviedb/assets/css/spmoviedb-common.css' );
$doc->addStylesheet( JURI::root(true) . '/components/com_spmoviedb/assets/css/spmoviedb-font.css' );
$doc->addStylesheet( JURI::root(true) . '/components/com_spmoviedb/assets/css/spmoviedb.css' );

// Load FOF
include_once JPATH_LIBRARIES.'/fof/include.php';
if(!defined('FOF_INCLUDED')) {
	JError::raiseError ('500', 'FOF is not installed');

	return;
}

FOFDispatcher::getTmpInstance('com_spmoviedb')->dispatch();