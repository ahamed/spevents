<?php
/**
* @package com_spmedical
* @author JoomShaper http://www.joomshaper.com
* @copyright Copyright (c) 2010 - 2018 JoomShaper
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/

// No Direct Access
defined ('_JEXEC') or die('Restricted Access');

require_once JPATH_COMPONENT . '/helpers/helper.php';
JHtml::_('jquery.framework');
$doc = JFactory::getDocument();

// Include CSS files
$doc->addStylesheet( JURI::root(true) . '/components/com_spmedical/assets/css/spmedical.css' );
$doc->addStylesheet( JURI::root(true) . '/components/com_spmedical/assets/css/medico-fonts.css' );
$doc->addStylesheet( JURI::root(true) . '/components/com_spmedical/assets/css/spmedical-structure.css' );

// Include JS
$doc->addScript( JURI::root(true) . '/components/com_spmedical/assets/js/spmedical.js' );

$controller = JControllerLegacy::getInstance('Spmedical');
$input = JFactory::getApplication()->input;
$controller->execute($input->getCmd('task'));
$controller->redirect();
