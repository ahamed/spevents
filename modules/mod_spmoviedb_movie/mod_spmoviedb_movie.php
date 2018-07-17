<?php
/**
 * @package     SP Movie Database
 * @subpackage  mod_spmoviedb_movie
 *
 * @copyright   Copyright (C) 2010 - 2016 JoomShaper. All rights reserved.
 * @license     GNU General Public License version 2 or later.
 */

// no direct access
defined('_JEXEC') or die('Restricted access!');

require_once __DIR__ . '/helper.php';
require_once JPATH_BASE . '/components/com_spmoviedb/models/movies.php';
require_once JPATH_BASE . '/components/com_spmoviedb/helpers/helper.php';

// Load the method jquery script.
JHtml::_('jquery.framework');

$doc = JFactory::getDocument();
$doc->addStylesheet( JURI::root(true).'/modules/'.$module->module .'/assets/css/owl.carousel.css' );
$doc->addStylesheet( JURI::root(true).'/modules/'.$module->module .'/assets/css/owl.theme.css' );
$doc->addStylesheet( JURI::root(true).'/modules/'.$module->module .'/assets/css/style.css' );
$doc->addScript( JURI::root(true).'/modules/'.$module->module .'/assets/js/owl.carousel.min.js' );
$doc->addScript( JURI::root(true).'/modules/'.$module->module .'/assets/js/main.js' );
$doc->addStylesheet( JURI::root(true) . '/components/com_spmoviedb/assets/css/spmoviedb-font.css' );

// Get items
$items 				= ModSpmoviedbMovieHelper::getMovies($params);
$moduleclass_sfx 	= htmlspecialchars($params->get('moduleclass_sfx'));

require JModuleHelper::getLayoutPath('mod_spmoviedb_movie', $params->get('layout'));