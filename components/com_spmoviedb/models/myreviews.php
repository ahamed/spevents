<?php
/**
 * @package     SP Movie Databse
 *
 * @copyright   Copyright (C) 2010 - 2016 JoomShaper. All rights reserved.
 * @license     GNU General Public License version 2 or later.
 */

defined('_JEXEC') or die('Restricted Access');

jimport( 'joomla.application.component.helper' );

class SpmoviedbModelMyreviews extends FOFModel {

	public function __construct($config = array()){
		$config['table'] = 'reviews';
		parent::__construct($config);
	}

	public function buildQuery($overrideLimits = false) {

		$db = $this->getDbo();
		$query = $db->getQuery(true);

		// Call the behaviors
		$this->modelDispatcher->trigger('onBeforeBuildQuery', array(&$this, &$query));

		$query->select( array('a.*') );
	    $query->from($db->quoteName('#__spmoviedb_reviews', 'a'));
	    $query->where($db->quoteName('a.enabled')." = ".$db->quote(1));

	    $query->order($db->quoteName('a.created_on') . ' DESC');

	    // Call the behaviors
		$this->modelDispatcher->trigger('onAfterBuildQuery', array(&$this, &$query));

	    return $query;
	}

	public function getMyReviews($user_id) {

		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select( array('a.*', 'b.spmoviedb_movie_id', 'b.title', 'b.slug') );
    	$query->from($db->quoteName('#__spmoviedb_reviews', 'a'));
    	$query->join('LEFT', $db->quoteName('#__spmoviedb_movies', 'b') . ' ON (' . $db->quoteName('a.movieid') . ' = ' . $db->quoteName('b.spmoviedb_movie_id') . ')');
	    $query->where($db->quoteName('a.created_by') . ' = ' . $db->quote($user_id));
	    $query->where($db->quoteName('a.enabled')." = ".$db->quote('1'));
	    $db->setQuery($query);

	    $reviews = $db->loadObjectList();

	    foreach ($reviews as $review) {
	    	$review->url = JRoute::_('index.php?option=com_spmoviedb&view=movie&id=' . $review->movieid . ':' . $review->slug . SpmoviedbHelper::getItemid('movies'));
	    }

	    return $reviews;
	}
}