<?php
/**
 * @package     SP Properties
 * @subpackage  mod_spproperty_properties
 *
 * @copyright   Copyright (C) 2010 - 2017 JoomShaper. All rights reserved.
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

//includes js and css
$doc = JFactory::getDocument();
$doc->addStylesheet( JURI::root(true) . '/components/com_spproperty/assets/css/spproperty-structure.css' );
$doc->addStylesheet( JURI::root(true) . '/modules/'.$module->module .'/assets/css/style.css' );
$doc->addStylesheet( JURI::root(true) . '/components/com_spproperty/assets/css/style.css' );

jimport('joomla.application.component.helper');
$cParams 			= JComponentHelper::getParams('com_spproperty');
// Get Columns
$columns = $params->get('columns', 2);
// Get items
$properties 		= SppropertyModelProperties::getAllProperties($params);

foreach ($properties as $property) {
	$property->property_status_txt = $property->property_status;
	if($property->property_status == 'rent') {
		$property->property_status_txt = JText::_('MOD_SPPROPERTY_PROPERTOES_STATUS_RENT');
	} elseif($property->property_status == 'sell') {
		$property->property_status_txt = JText::_('MOD_SPPROPERTY_PROPERTOES_STATUS_SELL');
	} elseif($property->property_status == 'in_hold') {
		$property->property_status_txt = JText::_('MOD_SPPROPERTY_PROPERTOES_STATUS_IN_HOLD');
	} elseif($property->property_status == 'pending') {
		$property->property_status_txt = JText::_('MOD_SPPROPERTY_PROPERTOES_STATUS_IN_PENDING');
	} elseif($property->property_status == 'sold') {
		$property->property_status_txt = JText::_('MOD_SPPROPERTY_PROPERTOES_STATUS_IN_SOLD');
	} elseif($property->property_status == 'under_offer') {
		$property->property_status_txt = JText::_('MOD_SPPROPERTY_PROPERTOES_STATUS_IN_UNDER_OFFER');
	}

	$property->price = SppropertyHelper::generateCurrency($property->price);
}

$moduleclass_sfx 	= htmlspecialchars($params->get('moduleclass_sfx'));

require JModuleHelper::getLayoutPath('mod_spproperty_properties', $params->get('layout'));
