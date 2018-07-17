<?php
/**
 * @package     SP Movie Database
 * @subpackage  mod_spmoviedb_tab
 *
 * @copyright   Copyright (C) 2010 - 2016 JoomShaper. All rights reserved.
 * @license     GNU General Public License version 2 or later.
 */

// no direct access
defined('_JEXEC') or die;

require_once __DIR__ . '/helper.php';
require_once JPATH_BASE . '/components/com_spmoviedb/models/movies.php';
require_once JPATH_BASE . '/components/com_spmoviedb/helpers/helper.php';

// Load the method jquery script.
JHtml::_('jquery.framework');
$limit = $params->get('limit', 6);

$doc = JFactory::getDocument();
$doc->addStylesheet( JURI::root(true).'/modules/'.$module->module .'/assets/css/owl.carousel.css' );
$doc->addStylesheet( JURI::root(true).'/modules/'.$module->module .'/assets/css/owl.theme.css' );
$doc->addStylesheet( JURI::root(true).'/modules/'.$module->module .'/assets/css/style.css' );
$doc->addScript( JURI::root(true).'/modules/'.$module->module .'/assets/js/owl.carousel.min.js' );
$doc->addScript( JURI::root(true).'/modules/'.$module->module .'/assets/js/spmoviedb-tab.js' );
$doc->addStylesheet( JURI::root(true) . '/components/com_spmoviedb/assets/css/spmoviedb-font.css' );

// Get items
$movies_lists = array();
$movies_lists['latest']['title'] = JText::_('MOD_SPMOVIEDB_TAB_LATEST');
$movies_lists['latest']['movies'] = ModSpmoviedbTabHelper::getMovies('latest', $limit);

if($params->get('show_fetured')){
	$movies_lists['featured']['title'] = JText::_('MOD_SPMOVIEDB_TAB_FEATURED');
	$movies_lists['featured']['movies'] = ModSpmoviedbTabHelper::getMovies('featured', $limit);
}

if($params->get('show_comingsoon')){
	$movies_lists['coming']['title'] = JText::_('MOD_SPMOVIEDB_TAB_COMING_SOON');
	$movies_lists['coming']['movies'] = ModSpmoviedbTabHelper::getMovies('coming', $limit);
}

if($params->get('show_toprated')){
	$movies_lists['toprated']['title'] = JText::_('MOD_SPMOVIEDB_TAB_TOP_RATED');
	$movies_lists['toprated']['movies'] = ModSpmoviedbTabHelper::getMovies('top', $limit);
}

if($params->get('show_latesttrailer')){
	$movies_lists['trailer']['title'] = JText::_('MOD_SPMOVIEDB_TAB_TOP_LATEST_TRAILERS');
	$movies_lists['trailer']['movies'] = ModSpmoviedbTabHelper::getMovies('ltrailers', $limit);
}

$moduleclass_sfx 	= htmlspecialchars($params->get('moduleclass_sfx'));

require JModuleHelper::getLayoutPath('mod_spmoviedb_tab', $params->get('layout'));