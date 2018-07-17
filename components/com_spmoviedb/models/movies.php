<?php
/**
 * @package     SP Movie Databse
 *
 * @copyright   Copyright (C) 2010 - 2016 JoomShaper. All rights reserved.
 * @license     GNU General Public License version 2 or later.
 */

defined('_JEXEC') or die('Restricted Access');

jimport( 'joomla.application.component.helper' );

class SpmoviedbModelMovies extends FOFModel {

	public function __construct($config = array()){
		parent::__construct($config);
	}

	public function buildQuery($overrideLimits = false) {

		if(FOFPlatform::getInstance()->isFrontend()) {
			// Get Params
			$app = JFactory::getApplication();
			$active_menu   = $app->getMenu()->getActive(); // get the active item

			if ($active_menu) {
				$params   = $active_menu->params; // get the active item
				$genreid 	= $params->get('genreid', '');
				$country 	= $params->get('country', '');
				$order_by = $params->get('order_by', '');
			}

			$now = JHtml::_('date', JFactory::getDate(), 'Y-m-d');
			$db = $this->getDbo();
			$alphaindex = $this->input->get('alphaindex', '', 'WORD');
			$yearindex = $this->input->get('yearindex', '', 'INT');
		}

		$query = $db->getQuery(true);
		$this->modelDispatcher->trigger('onBeforeBuildQuery', array(&$this, &$query));
		$query->select( array('a.*') );
	    $query->from($db->quoteName('#__spmoviedb_movies', 'a'));
	    $query->where($db->quoteName('a.enabled')." = ".$db->quote(1));

		if(FOFPlatform::getInstance()->isFrontend()) {
			//Language & access
			$query->where($db->quoteName('a.language') .' IN (' . $db->quote(JFactory::getLanguage()->getTag()) . ',' . $db->quote('*') . ')');
			$query->where($db->quoteName('a.access').' IN (' . 	implode( ',', $db->quote( JFactory::getUser()->getAuthorisedViewLevels()) ) . ')');

	    if($alphaindex) {
	    	$query->where($db->quoteName('a.title')." LIKE " . $db->quote(strtolower($alphaindex) . '%'));
	    }
	    if($yearindex) {
	    	$query->where('YEAR('.$db->quoteName('a.release_date').')  = '. $db->quote($yearindex));
	    }

			if ($active_menu) {
	    	if($genreid) {
	    		$query->where($db->quoteName('a.genres')." LIKE " . $db->quote('%' .$genreid . '%'));
	    	}
	    	if($country) {
	    		$query->where($db->quoteName('a.country')." = ".$db->quote($country));
	    	}
				if ($order_by=='desc') {
					$query->order($db->quoteName('a.release_date') . ' DESC');
				} elseif ($order_by=='asc') {
					$query->order($db->quoteName('a.release_date') . ' ASC');
				} elseif ($order_by=='latest_released') {
					$query->where($db->quoteName('a.release_date') . ' <= ' . $db->quote($now));
					$query->order($db->quoteName('a.release_date') . ' DESC');
				} elseif ($order_by== 'featured') {
					$query->where($db->quoteName('a.featured') . ' = 1');
					$query->order($db->quoteName('a.release_date') . ' DESC');
				} elseif ($order_by=='coming') {
					$query->where($db->quoteName('a.release_date') . ' > ' . $db->quote($now));
					$query->order($db->quoteName('a.created_on') . ' ASC');
				} else {
					$query->order($db->quoteName('a.ordering') . ' DESC');
				}
			}
		}

		// Call the behaviors
		if(!FOFPlatform::getInstance()->isFrontend()) {
			$this->modelDispatcher->trigger('onAfterBuildQuery', array(&$this, &$query));
		}

	  return $query;
	}

	public function &getItem($id = null) {
		$item = parent::getItem($id);
		if(FOFPlatform::getInstance()->isFrontend()) {
			if($item->spmoviedb_movie_id) {
				return $item;
			} else {
				return JError::raiseError(404, JText::_('COM_SPMOVIEDB_ERROR_MOVIE_NOT_FOUND'));
			}
		} else {
			return $item;
		}
	}

	// get genries by genry ids
	public static function getGenries($genre_ids) {
		$db = JFactory::getDbo();
		$genre_ids = implode(',', $db->quote(json_decode($genre_ids)));
		$query = $db->getQuery(true);
		$query->select( array('a.*') );
    $query->from($db->quoteName('#__spmoviedb_genres', 'a'));
    $query->where($db->quoteName('a.spmoviedb_genre_id') . " IN (" . $genre_ids . ")");
    $db->setQuery($query);
    $results = $db->loadObjectList();

		return $results;
	}

	// get celebrities by celebrity ids
	public static function getCelebrities($celebrity_ids) {
		$db = JFactory::getDbo();
		$celebrity_ids = implode(',', $db->quote(json_decode($celebrity_ids)));
		$query = $db->getQuery(true);
		$query->select( array('a.*') );
    $query->from($db->quoteName('#__spmoviedb_celebrities', 'a'));
    $query->where($db->quoteName('a.spmoviedb_celebrity_id')." IN (" . $celebrity_ids . ")");
    $db->setQuery($query);
		$celebrities = $db->loadObjectList();

		$celebrity_output = '';
		foreach ($celebrities as $key => $celebrity) {
			$celebrity_url 		= JRoute::_('index.php?option=com_spmoviedb&view=celebrity&id=' . $celebrity->spmoviedb_celebrity_id . ':' . $celebrity->slug . SpmoviedbHelper::getItemid('celebrities'));
			$celebrity_output .= '<a href="' . $celebrity_url . '">' . $celebrity->title . '</a>' . ', ';
		}

		return rtrim(trim($celebrity_output), ',');
	} // END:: getCelebrities

	//Get Related Items
	public function getRelated($genres, $id = 0) {
		$db = JFactory::getDbo();
		$str_tag_ids = implode(' OR ', array_map(function ($entry) {
			return "`a`.`genres` LIKE '%" . $entry->spmoviedb_genre_id . "%'";
		}, $genres));

		$query = $db->getQuery(true);
    $query->select( array('a.*') );
    $query->from($db->quoteName('#__spmoviedb_movies', 'a'));
    $query->where($str_tag_ids);
  	$query->where($db->quoteName('a.spmoviedb_movie_id')." != ".$db->quote($id));
  	$query->where($db->quoteName('a.enabled')." = ".$db->quote('1'));
  	$query->order($db->quoteName('a.created_on') . ' DESC');
    $query->setLimit(3);
    $db->setQuery($query);

    return $db->loadObjectList();
	}

	public function getReviews($movie_id) {
		$params = JComponentHelper::getParams('com_spmoviedb');
		$input = JFactory::getApplication()->input;
		$start 	= $input->post->get('start', 0, 'INT');
		$limit 	= $params->get('review_limit', 12);
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select( array('a.*', 'b.email', 'b.name') );
    $query->from($db->quoteName('#__spmoviedb_reviews', 'a'));
    $query->join('INNER', $db->quoteName('#__users', 'b') . ' ON (' . $db->quoteName('a.created_by') . ' = ' . $db->quoteName('b.id') . ')');
    $query->where($db->quoteName('a.movieid') . ' = ' . $db->quote($movie_id));
    $query->order($db->quoteName('a.created_on') . ' DESC');
    $query->setLimit($limit, $start);
    $db->setQuery($query);
		$reviews = $db->loadObjectList();

		return $reviews;
	}

	//Get Movie Years
	public static function getMoviesYear() {

		// Get Params
		$app = JFactory::getApplication();
		$params   = $app->getMenu()->getActive()->params; // get the active item
		$order_by = $params->get('order_by', '');
		$now = JHtml::_('date', JFactory::getDate(), 'Y-m-d');

		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select('DISTINCT YEAR( release_date ) AS year');
		$query->from($db->quoteName('#__spmoviedb_movies', 'a'));
		$query->where($db->quoteName('enabled')." = ".$db->quote('1'));

		if ($order_by=='latest_released') {
			$query->where($db->quoteName('a.release_date') . ' <= ' . $db->quote($now));
		} elseif ($order_by=='coming') {
			$query->where($db->quoteName('a.release_date') . ' >= ' . $db->quote($now));
		}

		$query->group($db->quoteName('year'));
		$query->order('a.release_date DESC');
		$db->setQuery($query);
		return $db->loadObjectList();
	}

	//Get Movies By Year
	public static function getMoviesByYear($year = 0) {
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select('DISTINCT YEAR( release_date ) AS year');
		$query->from($db->quoteName('#__spmoviedb_movies'));
		$query->where($db->quoteName('enabled')." = ".$db->quote('1'));
		$query->group($db->quoteName('year'));
		$query->order('release_date DESC');
		$db->setQuery($query);
		return $db->loadObjectList();
	}

	// Get total reviews by movie id
	public function getTotalReviews($movie_id) {
		$input = JFactory::getApplication()->input;
		$start 	= $input->post->get('start', 0, 'INT');
		$limit 	= 1;
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select( array('COUNT(a.spmoviedb_review_id)') );
    $query->from($db->quoteName('#__spmoviedb_reviews', 'a'));
    $query->join('INNER', $db->quoteName('#__users', 'b') . ' ON (' . $db->quoteName('a.created_by') . ' = ' . $db->quoteName('b.id') . ')');
    $query->where($db->quoteName('a.movieid') . ' = ' . $db->quote($movie_id));
    $query->where($db->quoteName('a.enabled')." = ".$db->quote('1'));
    $db->setQuery($query);

		return $db->loadResult();
	}

	public function getRatings($movie_id) {
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select( array('COUNT(a.rating) AS count', 'SUM(a.rating) AS total') );
    $query->from($db->quoteName('#__spmoviedb_reviews', 'a'));
    $query->where($db->quoteName('a.movieid') . ' = ' . $db->quote($movie_id));
    $query->where($db->quoteName('a.enabled')." = ".$db->quote('1'));
    $db->setQuery($query);

		return $db->loadObject();
	}

	// get move by movie id
	public static function getMovieById($movie_id) {
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select( array('a.spmoviedb_movie_id', 'a.title', 'a.slug', 'a.movie_story', 'a.release_date', 'a.genres') );
		$query->from($db->quoteName('#__spmoviedb_movies', 'a'));
		$query->where($db->quoteName('a.spmoviedb_movie_id')." = " . $db->quote($movie_id) );
		$db->setQuery($query);
		$result = $db->loadObject();

		return $result;
	}

	public function getMyReview($movie_id) {

		$user = JFactory::getUser();

		if($user->id) {
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select( array('a.*', 'b.email', 'b.name') );
    	$query->from($db->quoteName('#__spmoviedb_reviews', 'a'));
    	$query->join('LEFT', $db->quoteName('#__users', 'b') . ' ON (' . $db->quoteName('a.created_by') . ' = ' . $db->quoteName('b.id') . ')');
    	$query->where($db->quoteName('a.movieid') . ' = ' . $db->quote($movie_id));
	    $query->where($db->quoteName('a.created_by') . ' = ' . $db->quote($user->id));
	    $query->where($db->quoteName('a.enabled')." = ".$db->quote('1'));
	    $db->setQuery($query);
	    $review = $db->loadObject();

	    if(count($review)) {
	    	$review->gravatar = md5($review->email);
    		$review->created_date = SpmoviedbHelper::timeago($review->created_on);
	    	return $review;
	    }
	    return false;
		}

	    return false;
	}

	// get generate trailers
	public static function GenerateTrailers($movie_id) {

		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select( array('a.*') );
		$query->from($db->quoteName('#__spmoviedb_movies', 'a'));
		$query->where($db->quoteName('a.spmoviedb_movie_id')." = " . $movie_id . "");
		$db->setQuery($query);
		$item = $db->loadObject();

		$trailer_urls   = array($item->trailer_one, $item->trailer_two, $item->trailer_three, $item->trailer_four, $item->trailer_five, $item->trailer_six, $item->trailer_seven, $item->trailer_eight, $item->trailer_nine, $item->trailer_ten);

		$trailer_title = array($item->trailer_one_title, $item->trailer_two_title, $item->trailer_three_title, $item->trailer_four_title, $item->trailer_five_title, $item->trailer_six_title, $item->trailer_seven_title, $item->trailer_eight_title, $item->trailer_nine_title, $item->trailer_ten_title);

		$trailer_thumbs = array($item->t_thumb_one, $item->t_thumb_two, $item->t_thumb_three, $item->t_thumb_four, $item->t_thumb_five, $item->t_thumb_six, $item->t_thumb_seven, $item->t_thumb_eight, $item->t_thumb_nine, $item->t_thumb_ten);


		if (isset($trailer_urls)) {
			$urls 			= $trailer_urls;
			$title 			= $trailer_title;
			$tmb_large 	= $trailer_thumbs;

			// Trailers URLS
			$turls = array();
			$ukey 		   = 0;
			foreach ($urls as $id => $url) {
				if ($url) {

					if (isset($trailer_title[$id]) && $trailer_title[$id]) {
						$trailer_title[$id] = $trailer_title[$id];
					} else {
						$trailer_title[$id] = $item->title;
					}

					$turls[$ukey] = array(
						'url' 			=> $urls[$id],
						'trailer_title' => $trailer_title[$id],
						'tmb_large' 	=> $tmb_large[$id],
					);
					$ukey ++;
				}
			}

			// trailers urls
			$item->turls = array();
			foreach ($turls as $key => $turl) {
				$vurl = parse_url($turl['url']);
				switch($vurl['host']) {
					case 'youtu.be':
					$id = trim($vurl['path'],'/');
					$src = '//www.youtube.com/embed/' . $id;
					$host = 'youtube';
					break;

					case 'www.youtube.com':
					case 'youtube.com':
					parse_str($vurl['query'], $query);
					$id = $query['v'];
					$src = '//www.youtube.com/embed/' . $id;
					$host = 'youtube';
					break;

					case 'vimeo.com':
					case 'www.vimeo.com':
					$id = trim($vurl['path'],'/');
					$src = "//player.vimeo.com/video/{$id}";
					$host = 'vimeo';
					break;

					case 'dailymotion.com':
					case 'www.dailymotion.com':
					$id = trim(strtok(basename($vurl['path']), '_'));
					$src = "//dailymotion.com/embed/video/{$id}";
					$host = 'dailymotion';
					break;

					default:
					$id = trim($vurl['path'],'/');
					$src = $turl['url'];
					$host = 'self';
					break;

				} // END:: switch case

				$thumb_baseurl = basename($turl['tmb_large']);
				//generate thumb url
				if (isset($thumb_baseurl) && $thumb_baseurl) {
					$trailer_thumb = dirname($turl['tmb_large']) .  '/_spmedia_thumbs' . '/' . JFile::stripExt($thumb_baseurl) .  '.' . JFile::getExt($thumb_baseurl);
				}

				$item->turls[$key] = array(
					'id' 			=> $id,
					'src'			=> $src,
					'host'			=> $host,
					'title'			=> $turl['trailer_title'],
					'genres'		=> self::getGenries($item->genres),
					'movie_id'		=> $item->spmoviedb_movie_id,
					'tmb_large'		=> $turl['tmb_large'],
					'tmb_small'		=> $trailer_thumb,
				);

			} // END:: foreach turl
		} // END:: isset has url decode


		return $item->turls;

	}
	
	// check date valid
	function validateDate($date){
		$d = DateTime::createFromFormat('Y-m-d', $date);
		return $d && $d->format('Y-m-d') == $date;
	}

}
