<?php
/**
 * @package     SP Medical
 * @subpackage  mod_spmedical_service
 *
 * @copyright   Copyright (C) 2010 - 2018 JoomShaper. All rights reserved.
 * @license     GNU General Public License version 2 or later.
 */

// no direct access
defined('_JEXEC') or die('Restricted access!');

class modSpmedicalServicesHelper {

	public static function getdepartments($params) {
		$ordering = $params->get('ordering');
	
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select(array('id', 'title', 'alias', 'description', 'image', 'icon'));
		$query->from($db->quoteName('#__spmedical_departments'));
		$query->where($db->quoteName('published') . ' = 1');
		$query->order($db->quoteName('ordering') . $ordering);
		$query->setLimit($params->get('limit', 4));
		$db->setQuery($query);
		$items = $db->loadObjectList();

		foreach ($items as $item) {
			$item->url 	= JRoute::_('index.php?option=com_spmedical&view=department&id=' . $item->id . ':' . $item->alias . SpmedicalHelper::getItemid('departments'));
		}

		return $items;
	}
}