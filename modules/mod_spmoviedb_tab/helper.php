<?php
/**
 * @package     SP Movie Database
 * @subpackage  mod_spmoviedb_tab
 *
 * @copyright   Copyright (C) 2010 - 2016 JoomShaper. All rights reserved.
 * @license     GNU General Public License version 2 or later.
 */

defined('_JEXEC') or die;


class ModSpmoviedbTabHelper {

	public static function getMovies($order_by ='', $limit = 5) {
		$model = FOFModel::getAnInstance('Movies', 'SpmoviedbModel');

		$now = JHtml::_('date', JFactory::getDate(), 'Y-m-d');

		$db = JFactory::getDbo();
		$query = $db->getQuery(true);

		$query->select( array('a.spmoviedb_movie_id', 'a.title', 'a.slug', 'a.profile_image', 'a.genres', 'a.trailer_one', 'a.t_thumb_one', 'COUNT(b.rating) AS ratings_count', 'SUM(b.rating) AS ratings_sum' ));
		$query->from($db->quoteName('#__spmoviedb_movies', 'a'));
		$query->join('LEFT', $db->quoteName('#__spmoviedb_reviews', 'b') . ' ON (' . $db->quoteName('a.spmoviedb_movie_id') . ' = ' . $db->quoteName('b.movieid') . ')');
		
		if ($order_by== 'top') {
			$query->where($db->quoteName('b.enabled') . ' = 1');
			$query->group($db->quoteName('b.movieid'));
		} else {
			$query->where($db->quoteName('a.enabled') . ' = 1');
			$query->group($db->quoteName('a.spmoviedb_movie_id'));
		}
		
		if ($order_by=='coming') {
			$query->where($db->quoteName('a.release_date') . ' > ' . $db->quote($now));
			$query->order($db->quoteName('a.release_date') . ' ASC');
		} elseif ($order_by=='latest') {
			$query->where($db->quoteName('a.release_date') . ' <= ' . $db->quote($now));
			$query->order($db->quoteName('a.release_date') . ' DESC');
		} elseif ($order_by== 'top') {
			$query->order('ratings_sum DESC');
		} elseif ($order_by== 'featured') {
			$query->where($db->quoteName('a.featured') . ' = 1');
			$query->order($db->quoteName('a.created_on') . ' DESC');
		} elseif ($order_by== 'ltrailers') {
			$query->where($db->quoteName('a.trailer_one') . '!=""');
			$query->order($db->quoteName('a.ordering') . ' DESC');
		} else {
			$query->order($db->quoteName('a.ordering') . ' DESC');
		}

		$query->setLimit($limit);
		$db->setQuery($query);
		$items = $db->loadObjectList();
		

		foreach ($items as &$item) {
			$item->genres 		= $model::getGenries($item->genres);
			$item->url 			= JRoute::_('index.php?option=com_spmoviedb&view=movie&id=' . $item->spmoviedb_movie_id . ':' . $item->slug . SpmoviedbHelper::getItemid('movies'));
			$item->turls 		= $model::GenerateTrailers($item->spmoviedb_movie_id);
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
