<?php
/**
* @package com_spmedical
* @author JoomShaper http://www.joomshaper.com
* @copyright Copyright (c) 2010 - 2018 JoomShaper
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/

// No Direct Access
defined ('_JEXEC') or die('Restricted Access');

if (!JFactory::getUser()->authorise('core.manage', 'com_spmedical')){
	throw new JAccessExceptionNotallowed(JText::_('JERROR_ALERTNOAUTHOR'), 403);
}

JHtml::_('jquery.framework');
$doc = JFactory::getDocument();
$doc->addStylesheet( JURI::root(true) . '/administrator/components/com_spmedical/assets/css/spmedical.css' );
$doc->addStylesheet( JURI::root(true) . '/components/com_spmedical/assets/css/spmedical-structure.css' );


// Require helper file
JLoader::register('SpmedicalHelper', JPATH_COMPONENT . '/helpers/spmedical.php');
$controller = JControllerLegacy::getInstance('Spmedical');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();
