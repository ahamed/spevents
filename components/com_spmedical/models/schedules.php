<?php
/**
* @package com_spmedical
* @author JoomShaper http://www.joomshaper.com
* @copyright Copyright (c) 2010 - 2018 JoomShaper
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/

// No Direct Access
defined ('_JEXEC') or die('Restricted Access');

class SpmedicalModelSchedules extends JModelList {

	public function __construct($config = array()) {
    	parent::__construct($config);
	}
	
	// Get Schedules
	public static function getSpecialistsSchedules() {
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		// Order it by the ordering field.
		$query->select($db->quoteName(array('id', 'title', 'alias', 'image', 'designation', 'department_id', 'visiting_times', 'specialitist_on')));
		$query->from($db->quoteName('#__spmedical_specialists'));
		$query->where($db->quoteName('published')." = 1");
		$query->where($db->quoteName('visiting_times')." != ''" );
		$query->order('ordering DESC');
		$db->setQuery($query);
		$results = $db->loadObjectList();

		foreach ($results as &$result) {
			$result->url = JRoute::_('index.php?option=com_spmedical&view=specialist&id='.$result->id.':'.$result->alias . SpmedicalHelper::getItemid('specialists'));
		}
		
		return $results;
	}

}
