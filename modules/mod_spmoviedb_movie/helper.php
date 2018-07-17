<?php
/**
 * @package     SP Movie Database
 * @subpackage  mod_spmoviedb_movie
 *
 * @copyright   Copyright (C) 2010 - 2016 JoomShaper. All rights reserved.
 * @license     GNU General Public License version 2 or later.
 */

// no direct access
defined('_JEXEC') or die('Restricted access!');

class ModSpmoviedbMovieHelper {

	public static function getMovies($params) {

		$model = FOFModel::getAnInstance('Movies', 'SpmoviedbModel');
		// Get param options
		$order_by = $params->get('order_by');

		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select(array('spmoviedb_movie_id', 'title', 'slug', 'profile_image', 'actors', 'genres', 'trailer_one', 't_thumb_one'));
		$query->from($db->quoteName('#__spmoviedb_movies'));
		$query->where($db->quoteName('enabled') . ' = 1');

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
			$item->genres 		= $model->getGenries($item->genres);
			$item->actors 		= $model->getCelebrities($item->actors);
			$item->url 			= JRoute::_('index.php?option=com_spmoviedb&view=movie&id=' . $item->spmoviedb_movie_id . ':' . $item->slug . SpmoviedbHelper::getItemid('movies'));
			$item->turls 		= $model->GenerateTrailers($item->spmoviedb_movie_id);
			$item->ratings 		= self::getRatings($item->spmoviedb_movie_id);

		}

		return $items;
	}

	private static function getRatings($movie_id) {
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select( array('COUNT(a.rating) AS count', 'SUM(a.rating) AS total') );
	    $query->from($db->quoteName('#__spmoviedb_reviews', 'a'));
	    $query->where($db->quoteName('a.movieid') . ' = ' . $db->quote($movie_id));
	    $db->setQuery($query);
		
		return $db->loadObject();
	}
}
