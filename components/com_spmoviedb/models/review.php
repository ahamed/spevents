<?php
/**
 * @package     SP Movie Databse
 *
 * @copyright   Copyright (C) 2010 - 2016 JoomShaper. All rights reserved.
 * @license     GNU General Public License version 2 or later.
 */

defined('_JEXEC') or die('Restricted Access');

class SpmoviedbModelReview extends FOFModel {

	public function __construct($config = array()){
		parent::__construct($config);
	}

	public function storeReview($movie_id = 0, $review = '', $rating = 1) {

		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$columns = array('movieid', 'review', 'rating', 'created_by', 'created_on', 'enabled');
		$values = array($db->quote($movie_id), $db->quote($review), $db->quote($rating), JFactory::getUser()->id, $db->quote(JFactory::getDate()), 1);
		$query
		    ->insert($db->quoteName('#__spmoviedb_reviews'))
		    ->columns($db->quoteName($columns))
		    ->values(implode(',', $values));
		 
		$db->setQuery($query);
		$db->execute();

		return $db->insertid();
	}

	public function updateReview($review = '', $rating = 1, $review_id) {

		$db = JFactory::getDbo();
		$query = $db->getQuery(true);

		$fields = array(
			$db->quoteName('review') . ' = ' . $db->quote($review),
			$db->quoteName('rating') . ' = ' . $db->quote($rating),
			);

		$conditions = array(
			$db->quoteName('spmoviedb_review_id') . ' = ' . $db->quote($review_id),
			$db->quoteName('created_by') . ' = ' . $db->quote(JFactory::getUser()->id),
			);
		$query->update($db->quoteName('#__spmoviedb_reviews'))->set($fields)->where($conditions);
		$db->setQuery($query);
		$db->execute();
	}

	public function getReview($review_id = 0) {
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select( array('a.*', 'b.email', 'b.name') );
	    $query->from($db->quoteName('#__spmoviedb_reviews', 'a'));
	    $query->join('LEFT', $db->quoteName('#__users', 'b') . ' ON (' . $db->quoteName('a.created_by') . ' = ' . $db->quoteName('b.id') . ')');
	    $query->where($db->quoteName('a.spmoviedb_review_id') . ' = ' . $db->quote($review_id));
	    $query->order($db->quoteName('a.created_on') . ' DESC');
	    
	    $db->setQuery($query);

	    $review = $db->loadObject();

	    if(count($review)) {
	    	$review->gravatar = md5($review->email);
	    	$review->created_date = SpmoviedbHelper::timeago($review->created_on);
	    	return $review;
	    }

	    return false;
	}

	public function getRatings($movie_id) {
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select( array('COUNT(a.rating) AS count', 'SUM(a.rating) AS total') );
	    $query->from($db->quoteName('#__spmoviedb_reviews', 'a'));
	    $query->where($db->quoteName('a.movieid') . ' = ' . $db->quote($movie_id));
	    $db->setQuery($query);
		
		return $db->loadObject();
	}
}