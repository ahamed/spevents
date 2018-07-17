<?php
/**
 * @package     SP Movie Database
 * @subpackage  mod_sp_moviedb_trailers
 *
 * @copyright   Copyright (C) 2010 - 2016 JoomShaper. All rights reserved.
 * @license     GNU General Public License version 2 or later.
 */

//no direct access
defined('_JEXEC') or die('No direct access');

JHtml::_('jquery.framework');

require_once __DIR__ . '/helper.php';
require_once JPATH_BASE . '/components/com_spmoviedb/models/movies.php';
require_once JPATH_BASE . '/components/com_spmoviedb/helpers/helper.php';

//includes js and css
$doc = JFactory::getDocument();
$doc->addStylesheet( JURI::root(true) . '/components/com_spmoviedb/assets/css/spmoviedb-common.css' );
$doc->addScript( JURI::base(true) . '/modules/'.$module->module .'/assets/js/spmoviedb-trailers.js' );
$doc->addStylesheet( JURI::root(true) . '/components/com_spmoviedb/assets/css/spmoviedb-font.css' );
$doc->addStylesheet( JURI::root(true).'/modules/'.$module->module .'/assets/css/style.css' );

// Get items
$items 				= ModSpmoviedbTrailersHelper::getTrailers($params);
$moduleclass_sfx 	= htmlspecialchars($params->get('moduleclass_sfx'));

require JModuleHelper::getLayoutPath('mod_sp_moviedb_trailers', $params->get('layout'));