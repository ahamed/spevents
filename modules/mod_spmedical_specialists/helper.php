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

class modSpmedicalHelper {

	public static function getspecialists($params) {
		$ordering = $params->get('ordering');
		
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select(array('id', 'title', 'alias', 'designation', 'image'));
		$query->from($db->quoteName('#__spmedical_specialists'));
		$query->where($db->quoteName('published') . ' = 1');
		$query->order($db->quoteName('ordering') . $ordering);
		$query->setLimit($params->get('limit', 6));
		$db->setQuery($query);
		$items = $db->loadObjectList();

		foreach ($items as $item) {
			$item->url 	= JRoute::_('index.php?option=com_spmedical&view=specialist&id=' . $item->id . ':' . $item->alias . SpmedicalHelper::getItemid('specialists'));
		}

		return $items;
	}
}