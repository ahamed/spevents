<?php
/**
 * @package     SP Movie Databse
 *
 * @copyright   Copyright (C) 2010 - 2016 JoomShaper. All rights reserved.
 * @license     GNU General Public License version 2 or later.
 */

defined('_JEXEC') or die('Restricted Access');

jimport( 'joomla.application.component.helper' );

class SpmoviedbModelTrailers extends FOFModel {

	public function __construct($config = array()){
		$config['table'] = 'movies';
		parent::__construct($config);
	}

	public function buildQuery($overrideLimits = false) {

		// Get Params
		$app = JFactory::getApplication();
		$params   = $app->getMenu()->getActive()->params; // get the active item
		$order_by = $params->get('order_by', '');

		$db = $this->getDbo();
		$query = $db->getQuery(true);

		// Call the behaviors
		$this->modelDispatcher->trigger('onBeforeBuildQuery', array(&$this, &$query));

		$query->select( array('a.*') );
	    $query->from($db->quoteName('#__spmoviedb_movies', 'a'));
	    $query->where($db->quoteName('a.enabled')." = ".$db->quote(1));

	    $query->where($db->quoteName('trailer_one') . '!=""');

	    if ($order_by=='desc') {
			$query->order($db->quoteName('a.release_date') . ' DESC');
		} elseif ($order_by=='asc') {
			$query->order($db->quoteName('a.release_date') . ' ASC');
		} elseif ($order_by== 'featured') {
			$query->where($db->quoteName('a.featured') . ' = 1');
			$query->order($db->quoteName('a.release_date') . ' DESC');
		} else {
			$query->order($db->quoteName('a.ordering') . ' DESC');
		}
	    
	    //Language
		$query->where('a.language in (' . $db->quote(JFactory::getLanguage()->getTag()) . ',' . $db->quote('*') . ')');
	    //Access
		$query->where($db->quoteName('a.access')." IN (" . implode( ',', JFactory::getUser()->getAuthorisedViewLevels() ) . ")");

	    // Call the behaviors
		$this->modelDispatcher->trigger('onAfterBuildQuery', array(&$this, &$query));

	    return $query;
	}




}