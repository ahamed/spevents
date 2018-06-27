<?php
/**
 * @package     SP Properties
 * @subpackage  mod_spproperty_search
 *
 * @copyright   Copyright (C) 2010 - 2016 JoomShaper. All rights reserved.
 * @license     GNU General Public License version 2 or later.
 */

// no direct access
defined('_JEXEC') or die;

JHtml::_('jquery.framework');

//helper & model
$com_helper 		= JPATH_BASE . '/components/com_spproperty/helpers/helper.php';
$com_property_model = JPATH_BASE . '/components/com_spproperty/models/properties.php';

if (file_exists($com_helper) && file_exists($com_property_model)) {
    require_once($com_helper);
    require_once($com_property_model);
} else {
	echo '<p class="alert alert-warning">' . JText::_('MOD_SPPROPERTY_COMPONENT_NOT_INSTALLED_OR_MISSING_FILE') . '</p>';
	return;
}

$doc = JFactory::getDocument();
$doc->addStylesheet( JURI::root(true) . '/components/com_spproperty/assets/css/style.css' );
$doc->addScript( JURI::base(true) . '/modules/' .$module->module . '/assets/js/spproperty-search.js' );
$doc->addStylesheet( JURI::root(true).'/modules/'.$module->module .'/assets/css/style.css' );

$getItems 	= SppropertyModelProperties::getAllProperties($params);
$items = array();
foreach($getItems as $element){
    $hash = $element->city;
    $items[$hash] = $element;
}

$cats 	= SppropertyModelProperties::getCategories();

require JModuleHelper::getLayoutPath('mod_spproperty_search', $params->get('layout'));
