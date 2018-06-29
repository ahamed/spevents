<?php
/**
 * @package     SP Medical
 * @subpackage  mod_spmedical_specialists
 *
 * @copyright   Copyright (C) 2010 - 2018 JoomShaper. All rights reserved.
 * @license     GNU General Public License version 2 or later.
 */

// no direct access
defined('_JEXEC') or die('Restricted access!');

require_once __DIR__ . '/helper.php';
require_once JPATH_BASE . '/components/com_spmedical/helpers/helper.php';

$doc = JFactory::getDocument();
$doc->addStylesheet( JURI::root(true).'/modules/'.$module->module .'/assets/css/style.css' );
$doc->addStylesheet( JURI::root(true) . '/components/com_spmedical/assets/css/spmedical-structure.css' );

// Get items
$items 			 = modSpmedicalHelper::getSpecialists($params);
$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));
$columns = htmlspecialchars($params->get('columns', 4));

require JModuleHelper::getLayoutPath('mod_spmedical_specialists', $params->get('layout'));