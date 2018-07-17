<?php
/**
 * @package     SP Movie Databse
 *
 * @copyright   Copyright (C) 2010 - 2016 JoomShaper. All rights reserved.
 * @license     GNU General Public License version 2 or later.
 */

defined('_JEXEC') or die('Restricted Access');

class SpmoviedbModelCelebrities extends FOFModel {

	public function __construct($config = array()){
		parent::__construct($config);
	}

	public function buildQuery($overrideLimits = false) {

		if(FOFPlatform::getInstance()->isFrontend()) {
			// Get Params
			$app 			= JFactory::getApplication();
			$params   		= $app->getMenu()->getActive()->params; // get the active item
			$order_by 		= $params->get('order_by', '');
			$celebrity_type = $params->get('celebrities_type', '');
			$gender 		= $params->get('gender', '');
		}

		$alphaindex = $this->input->get('alphaindex', '', 'WORD');

		$db = $this->getDbo();
		$query = $db->getQuery(true);
		$this->modelDispatcher->trigger('onBeforeBuildQuery', array(&$this, &$query));

		$query->select( array('a.*') );
	    $query->from($db->quoteName('#__spmoviedb_celebrities', 'a'));

	    if(FOFPlatform::getInstance()->isFrontend()) {

	    	if($alphaindex) {
		    	$query->where($db->quoteName('a.title')." LIKE " . $db->quote(strtolower($alphaindex) . '%'));	
		    }

	    	$query->where($db->quoteName('a.enabled')." = ".$db->quote('1'));

		    if ($order_by=='desc') {
				$query->order($db->quoteName('a.created_on') . ' DESC');
			} elseif ($order_by=='asc') {
				$query->order($db->quoteName('a.created_on') . ' ASC');
			} elseif ($order_by== 'featured') {
				$query->where($db->quoteName('a.featured') . ' = 1');
				$query->order($db->quoteName('a.ordering') . ' DESC');
			} else {
				$query->order($db->quoteName('a.ordering') . ' DESC');
			}

			if ($celebrity_type == 'actors') {
				$query->where('a.celebrity_type in (' . $db->quote('actor') . ',' . $db->quote('both') . ')');
			} elseif ($celebrity_type == 'directors') {
				$query->where('a.celebrity_type in (' . $db->quote('director') . ',' . $db->quote('both') . ')');
			}

			if ($gender == 'male') {
				$query->where($db->quoteName('a.gender') . ' = '. $db->quote('male') );
			} elseif ($gender == 'female') {
				$query->where($db->quoteName('a.gender') . ' = '. $db->quote('female'));
			} elseif ($gender == 'others') {
				$query->where($db->quoteName('a.gender') . ' = '. $db->quote('others'));
			}

			//Language
			$query->where('a.language in (' . $db->quote(JFactory::getLanguage()->getTag()) . ',' . $db->quote('*') . ')');
		    //Access
			$query->where($db->quoteName('a.access')." IN (" . implode( ',', JFactory::getUser()->getAuthorisedViewLevels() ) . ")");

		} else {
			$query->order($db->quoteName('a.ordering') . ' DESC');
		}

		// Call the behaviors
		if (!FOFPlatform::getInstance()->isFrontend()) {
			$this->modelDispatcher->trigger('onAfterBuildQuery', array(&$this, &$query));
		}

	    return $query;
	}

	public function &getItem($id = null) {
		$item = parent::getItem($id);
		
		if(FOFPlatform::getInstance()->isFrontend()) {
			if($item->spmoviedb_celebrity_id) {
				return $item;
			} else {
				return JError::raiseError(404, JText::_('COM_SPMOVIEDB_ERROR_CELEBRITY_NOT_FOUND'));
			}
		} else {
			return $item;
		}
	}

	// get celebrity movies
	public static function getCelebrityMoviesbyId($celebrity_id, $limit = 4) {

		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select( array('a.*') );
	    $query->from($db->quoteName('#__spmoviedb_movies', 'a'));
	    $query->where($db->quoteName('a.actors')." LIKE " . $db->quote('%"' . $celebrity_id . '"%'));
	    $query->where($db->quoteName('a.enabled')." = ".$db->quote('1'));
	    $query->where($db->quoteName('a.trailer_one') . '!=""');
	    $query->order($db->quoteName('a.created_on') . ' DESC');
	    $query->setLimit($limit);
	    $db->setQuery($query);
		$results = $db->loadObjectList();
		
		return $results;
	}

	//Count Celebrities
	public static function getCountCelebrities() {
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select( array('COUNT(a.spmoviedb_celebrity_id) as total_celebrities') );
	    $query->from($db->quoteName('#__spmoviedb_celebrities', 'a'));
	    $query->where($db->quoteName('a.enabled')." = ".$db->quote('1'));
	    $db->setQuery($query);
		return $db->loadObject();
	}
}