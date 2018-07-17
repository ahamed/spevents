<?php
/**
 * @package     SP Movie Database
 * @subpackage  mod_sp_moviedb_trailers
 *
 * @copyright   Copyright (C) 2010 - 2016 JoomShaper. All rights reserved.
 * @license     GNU General Public License version 2 or later.
 */

//no direct access
defined('_JEXEC') or die('No direct access');

class ModSpmoviedbTrailersHelper {

	public static function getTrailers($params) {
		$model = FOFModel::getAnInstance('Movies', 'SpmoviedbModel');
		$order_by = $params->get('order_by', 'latest');

		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select(array('spmoviedb_movie_id', 'title', 'slug', 'genres', 'trailer_one', 't_thumb_one'));
		$query->from($db->quoteName('#__spmoviedb_movies'));
		$query->where($db->quoteName('enabled') . ' = 1');
		$query->where($db->quoteName('trailer_one') . '!=""');

		if ($order_by=='asc') {
			$query->order($db->quoteName('release_date') . ' ASC');
		} elseif ($order_by== 'featured') {
			$query->where($db->quoteName('featured') . ' = 1');
			$query->order($db->quoteName('release_date') . ' DESC');
		} else {
			$query->order($db->quoteName('release_date') . ' DESC');
		}

		$query->setLimit($params->get('limit', 6));
		$db->setQuery($query);
		$items = $db->loadObjectList();

		foreach ($items as &$item) {
			$item->url 			= JRoute::_('index.php?option=com_spmoviedb&view=movie&id=' . $item->spmoviedb_movie_id . ':' . $item->slug . SpmoviedbHelper::getItemid('movies'));
			$item->genres 		= $model->getGenries($item->genres);
			$item->turls 		= $model->GenerateTrailers($item->spmoviedb_movie_id);
			$item->ratings 		= $model->getRatings($item->spmoviedb_movie_id);
		}

		return $items;
	}
}