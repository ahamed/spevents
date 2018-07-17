<?php
/**
 * @package     SP Movie Database
 * @subpackage  mod_spmoviedb_celebraties
 *
 * @copyright   Copyright (C) 2010 - 2016 JoomShaper. All rights reserved.
 * @license     GNU General Public License version 2 or later.
 */

// no direct access
defined('_JEXEC') or die('Restricted access!');

class modSpmoviedbCelebritiesHelper {

	public static function getCelebrities($params) {
		$order_by = $params->get('order_by');
		
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select(array('spmoviedb_celebrity_id', 'title', 'slug', 'designation', 'profile_image','featured'));
		$query->from($db->quoteName('#__spmoviedb_celebrities'));
		$query->where($db->quoteName('enabled') . ' = 1');

		if ($order_by=='featured') {
			$query->order($db->quoteName('featured') . ' DESC');
		} elseif ($order_by=='asc') {
			$query->order($db->quoteName('created_on') . ' ASC');
		} elseif ($order_by=='hits') {
			$query->order($db->quoteName('hits') . ' DESC');
		} else {
			$query->order($db->quoteName('ordering') . ' DESC');
		}

		$query->setLimit($params->get('limit', 6));
		$db->setQuery($query);
		$items = $db->loadObjectList();

		foreach ($items as $item) {
			$item->url 	= JRoute::_('index.php?option=com_spmoviedb&view=celebrity&id=' . $item->spmoviedb_celebrity_id . ':' . $item->slug . SpmoviedbHelper::getItemid('celebrities'));
		}

		return $items;
	}
}