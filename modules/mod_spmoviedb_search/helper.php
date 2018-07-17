<?php
/**
 * @package     SP Movie Database
 * @subpackage  mod_spmoviedb_search
 *
 * @copyright   Copyright (C) 2010 - 2016 JoomShaper. All rights reserved.
 * @license     GNU General Public License version 2 or later.
 */

defined('_JEXEC') or die;

// Load Component Helper
require_once JPATH_BASE . '/components/com_spmoviedb/helpers/helper.php';

class modSpmoviedbSearchHelper {

	public static function getAjax(){

		$input  = JFactory::getApplication()->input;
		$type 	= $input->post->get('type', '', 'STRING');
		$word 	= $input->post->get('query', '', 'STRING');

		if($word == '') return;

		$results = self::getSearchedItems($word, $type);

		$layout = new JLayoutFile('results', $basePath = JPATH_ROOT .'/modules/mod_spmoviedb_search/layouts');
		$html = $layout->render(array('results'=>$results, 'type'=>$type));

		$output = array(
			'status'=>'true',
			'content'=>$html
			);

		echo json_encode($output);
		die;
	}

	private static function getSearchedItems($word, $type){

		// get params
		jimport( 'joomla.application.module.helper' );
		$module = JModuleHelper::getModule( 'mod_spmoviedb_search' );
		$registry = new JRegistry();
		$params = $registry->loadString($module->params);
		// get limit
		$limit = $params->get('limit', 5);

		$db = JFactory::getDbo();
		$query = $db->getQuery(true);

		$search = preg_replace('#\xE3\x80\x80#s', " ", trim($word));
		$search_array = explode(" ", $db->escape($search));
		
		if ($type =='celebrities') {
			$query->select($db->quoteName( array('spmoviedb_celebrity_id', 'title', 'slug', 'profile_image')) );
			$query->from($db->quoteName('#__spmoviedb_celebrities'));
		} elseif ($type =='trailers'){
			$query->select($db->quoteName( array('spmoviedb_movie_id', 'title', 'slug', 'genres', 'profile_image')) );
			$query->from($db->quoteName('#__spmoviedb_movies'));
			$query->where($db->quoteName('trailer_one') . '!=""');
		} elseif( $type =='genres' ) {
			$genres = self::getMatchesGenres($word);

			if (count($genres) && $genres) {
				$str_tag_ids = implode(' OR ', array_map(function ($entry) {
					return "genres LIKE '%" . $entry->spmoviedb_genre_id . "%'";
				}, $genres));

				$query->select( $db->quoteName(array('spmoviedb_movie_id', 'title', 'slug', 'genres', 'profile_image')) );
				$query->from($db->quoteName('#__spmoviedb_movies'));
				$query->where($str_tag_ids);
			} else {
				return '';
			}

		} else {
			$query->select( $db->quoteName(array('spmoviedb_movie_id', 'title', 'slug', 'genres', 'profile_image')) );
			$query->from($db->quoteName('#__spmoviedb_movies'));
		}

		// search string
		if( $type !='genres' ) {
			$query->where($db->quoteName('title') . " LIKE '%" . implode("%' OR " . $db->quoteName('title') . " LIKE '%", $search_array) . "%'");
		}

		$query->where($db->quoteName('enabled')." = 1");

		if ( $type =='celebrities') {
			$query->order('ordering DESC');
		} else {
			$query->order('release_date DESC');
		}

		$query->setLimit($limit);
		$db->setQuery($query);
		$results = $db->loadObjectList();

		foreach ($results as &$result) {
			if ($type =='celebrities') {
				$result->url  = JRoute::_('index.php?option=com_spmoviedb&view=celebrity&id=' . $result->spmoviedb_celebrity_id . ':' . $result->slug . SpmoviedbHelper::getItemid('celebrities'));
			} else {
				$result->url  = JRoute::_('index.php?option=com_spmoviedb&view=movie&id=' . $result->spmoviedb_movie_id . ':' . $result->slug . SpmoviedbHelper::getItemid('movies'));
			}
			$result->title = JFilterOutput::ampReplace($result->title);	
		}

		return $results;
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
		$query->setLimit(10);
		$db->setQuery($query);
		$results = $db->loadObjectList();

		return $results;
	}

}
