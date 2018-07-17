<?php
/**
 * @package		SP Movie Database
 * @subpackage	mod_spmoviedb_search
 * @copyright	Copyright (C) 2010 - 2016 JoomShaper. All rights reserved.
 * @license		GNU General Public License version 2 or later; 
 */

// no direct access
defined('_JEXEC') or die;

// Load the method jquery script.
JHtml::_('jquery.framework');

require_once __DIR__ . '/helper.php';
require_once JPATH_BASE . '/components/com_spmoviedb/helpers/helper.php';

$doc = JFactory::getDocument();
$doc->addStylesheet( JURI::root(true).'/modules/'.$module->module .'/assets/css/style.css' );
$doc->addScript( JURI::base(true) . '/modules/'.$module->module .'/assets/js/spmoviedb-search.js' );
$doc->addStylesheet( JURI::root(true) . '/components/com_spmoviedb/assets/css/spmoviedb-font.css' );


require JModuleHelper::getLayoutPath('mod_spmoviedb_search', $params->get('layout'));