<?php
/**
 * @package     SP Medical
 * @subpackage  mod_spmedical_search
 *
 * @copyright   Copyright (C) 2010 - 2018 JoomShaper. All rights reserved.
 * @license     GNU General Public License version 2 or later.
 */

// no direct access
defined('_JEXEC') or die;

//helper & model
$com_helper 		= JPATH_BASE . '/components/com_spmedical/helpers/helper.php';
$com_specialists_model = JPATH_BASE . '/components/com_spmedical/models/specialists.php';
// Include the helper.
require_once __DIR__ . '/helper.php';

if (file_exists($com_helper) && file_exists($com_specialists_model)) {
    require_once($com_helper);
    require_once($com_specialists_model);
} else {
	echo '<p class="alert alert-warning">' . JText::_('MOD_SPMEDICAL_COMPONENT_NOT_INSTALLED_OR_MISSING_FILE') . '</p>';
	return;
}

JHtml::_('jquery.framework');
$doc = JFactory::getDocument();
$doc->addStylesheet( JURI::root(true) . '/components/com_spmedical/assets/css/spmedical.css' );
$doc->addStylesheet( JURI::root(true) . '/components/com_spmedical/assets/css/medico-fonts.css' );
$doc->addStylesheet( JURI::root(true).'/modules/'.$module->module .'/assets/css/style.css' );

$doc->addScript( JURI::root(true) . '/components/com_spmedical/assets/js/jquery-ui.js' );
$doc->addScript( JURI::base(true) . '/modules/' .$module->module . '/assets/js/spmedical-search.js' );

// get departments
$departments = SpmedicalHelper::getDepartments(true);
// Get Specialist's specialities
$specialities = SpmedicalHelper::getSpecialities();;
// get Specialists
$specialists = SpmedicalHelper::getSpecialists(true);

// echo '<pre>';
// print_r($specialities);
// echo '</pre>';

require JModuleHelper::getLayoutPath('mod_spmedical_search', $params->get('layout'));

?>