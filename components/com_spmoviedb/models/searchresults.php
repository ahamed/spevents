<?php
/**
 * @package     SP Movie Databse
 *
 * @copyright   Copyright (C) 2010 - 2016 JoomShaper. All rights reserved.
 * @license     GNU General Public License version 2 or later.
 */

defined('_JEXEC') or die('Restricted Access');

jimport( 'joomla.application.component.helper' );

class SpmoviedbModelSearchresults extends FOFModel {

	public function __construct($config = array()) {
		$config['table'] = 'movies';
		parent::__construct($config);
	}

	public function buildQuery($overrideLimits = false) {

		// Get Params
		$app = JFactory::getApplication();
		$params   = $app->getMenu()->getActive()->params; // get the active item
		$db = $this->getDbo();

		//$menu_genre 	= $params->get('genre');
		$input 			= JFactory::getApplication()->input;
		$searchword 	= $this->input->get('searchword', '', 'STRING');
		$searchtype 	= $this->input->get('type', '', 'WORD');
		$search 		= preg_replace('#\xE3\x80\x80#s', " ", trim($searchword));
		$search_array 	= explode(" ", $db->escape($search));

		$query = $db->getQuery(true);
		// Call the behaviors
		$this->modelDispatcher->trigger('onBeforeBuildQuery', array(&$this, &$query));

		if ($searchtype == 'celebrities') {
			$query->select( array('a.spmoviedb_celebrity_id', 'a.title', 'a.slug', 'a.profile_image') );
			$query->from($db->quoteName('#__spmoviedb_celebrities', 'a'));
			$query->order($db->quoteName('a.ordering') . ' DESC');
		} elseif ($searchtype == 'genres'){
			$genres = self::getMatchesGenres($searchword);
			$str_tag_ids = implode(' OR ', array_map(function ($entry) {
				return "a.genres LIKE '%" . $entry->spmoviedb_genre_id . "%'";
			}, $genres));

			$str_tag_ids = (isset($str_tag_ids) && $str_tag_ids) ? $str_tag_ids : 0 ;
			$query->select(  array('a.spmoviedb_movie_id', 'a.title', 'a.genres', 'a.slug', 'a.profile_image', 'a.release_date') );
			$query->from($db->quoteName('#__spmoviedb_movies', 'a'));
			$query->where($str_tag_ids);
			$query->order($db->quoteName('a.release_date') . ' DESC');
		} elseif ($searchtype == 'trailers'){
			$query->select( array('a.spmoviedb_movie_id', 'a.title', 'a.genres', 'a.slug', 'a.profile_image', 'a.release_date') );
	    	$query->from($db->quoteName('#__spmoviedb_movies', 'a'));
	    	$query->order($db->quoteName('a.release_date') . ' DESC');
		} else{
			$query->select( array('a.spmoviedb_movie_id', 'a.title', 'a.genres', 'a.slug', 'a.profile_image', 'a.release_date') );
	    	$query->from($db->quoteName('#__spmoviedb_movies', 'a'));
	    	$query->order($db->quoteName('a.release_date') . ' DESC');
		}

	    if ( $searchtype != 'genres' && $searchword ) {
	    	$query->where($db->quoteName('title') . " LIKE '%" . implode("%' OR " . $db->quoteName('title') . " LIKE '%", $search_array) . "%'");
	    }

		$query->where($db->quoteName('a.enabled')." = ".$db->quote(1));
		//Language & access
		$query->where($db->quoteName('a.language') .' IN (' . $db->quote(JFactory::getLanguage()->getTag()) . ',' . $db->quote('*') . ')');
		$query->where($db->quoteName('a.access').' IN (' . 	implode( ',', $db->quote( JFactory::getUser()->getAuthorisedViewLevels()) ) . ')');

		if(!FOFPlatform::getInstance()->isFrontend()) {
		  // Call the behaviors
			$this->modelDispatcher->trigger('onAfterBuildQuery', array(&$this, &$query));
		}
		
	  	return $query;
	}

	// get matches genres
	private static function getMatchesGenres($word){
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$search = preg_replace('#\xE3\x80\x80#s', " ", trim($word));
		$search_array = explode(" ", $db->escape($search));
		$query->select($db->quoteName(array('spmoviedb_genre_id', 'title', 'slug')));
		$query->from($db->quoteName('#__spmoviedb_genres'));
		$query->where($db->quoteName('title') . " LIKE '%" . implode("%' OR " . $db->quoteName('title') . " LIKE '%", $search_array) . "%'");
		$query->where($db->quoteName('enabled')." = 1");
		$db->setQuery($query);
		$results = $db->loadObjectList();

		return $results;
	}

}
