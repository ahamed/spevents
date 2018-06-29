<?php
/**
* @package com_spmedical
* @author JoomShaper http://www.joomshaper.com
* @copyright Copyright (c) 2010 - 2018 JoomShaper
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/

// No Direct Access
defined ('_JEXEC') or die('Restricted Access');

class SpmedicalModelSpecialists extends JModelList {

	protected function getListQuery() {
		$app 	= JFactory::getApplication();
		$user 	= JFactory::getUser();
		$input  = JFactory::getApplication()->input;
		// Get Params
		$params   = $app->getMenu()->getActive()->params;
		$ordering 		= $params->get('ordering', ' DESC');
		$department_id 	= $params->get('department_id', '');
		
		// get post data
		$searching 		= $input->get('searching', NULL, 'STRING');
		$specialistid 	= $input->get('specialistid', NULL, 'INT');
		$departmentid 	= $input->get('departmentid', NULL, 'INT');
		$speciality 	= $input->get('speciality', NULL, 'STRING');
		$gender 		= $input->get('gender', NULL, 'STRING');

		// Create a new query object.
		$db = $this->getDbo();
		$query = $db->getQuery(true);
		$query->select('a.*');
		$query->from($db->quoteName('#__spmedical_specialists', 'a'));
		$groups = implode(',', $user->getAuthorisedViewLevels());
		$query->where('a.access IN (' . $groups . ')');
		$query->where('a.language in (' . $db->quote(JFactory::getLanguage()->getTag()) . ',' . $db->quote('*') . ')');
		$query->where($db->qn('a.published')." = ".$db->quote('1'));

		if ($searching && $specialistid) {
			$query->where($db->qn('a.id')." = ".$db->quote($db->escape($specialistid)));
		}
		
		// if search
		if ( $searching && $departmentid ) {
			$query->where($db->qn('a.department_id')." = ".$db->quote($db->escape($departmentid)));
		}

		if ( !$searching && $department_id ) {
			$query->where($db->qn('a.department_id')." = ".$db->quote($db->escape($department_id)));
		}

		if ($searching && $gender) {
			$query->where($db->qn('a.gender')." = ". $db->quote($db->escape($gender)));
		}

		if ($searching && $speciality) {
			$query->where( $db->quoteName('a.specialitist_on') ." LIKE '%" . $db->escape( $speciality ) . "%'" );
		}

		$query->order($db->quoteName('a.ordering') . $ordering);

		return $query;
	}

	protected function populateState($ordering = null, $direction = null) {
		$app = JFactory::getApplication('site');
		$params = $app->getParams();
		$this->setState('list.start', $app->input->get('limitstart', 0, 'uint'));
		$limit = $params->get('limit');
		$this->setState('list.limit', $limit);
	}

	//if item not found
	public function &getItem($id = null) {
		$item = parent::getItem($id);
		if(JFactory::getApplication()->isSite()) {
			if($item->id) {
				return $item;
			} else {
				return JError::raiseError(404, JText::_('COM_SPMEDICAL_NO_ITEMS_FOUND'));
			}
		} else {
			return $item;
		}
	}

	// Get Specialist by id
	public static function getSpecialist($id, $short = false) {
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		if($short == true) {
			$query->select($db->quoteName(array('id', 'title', 'alias', 'image', 'department_id')));
		} else {
			$query->select('*');
		}
		$query->from($db->quoteName('#__spmedical_specialists'));
		$query->where($db->quoteName('published')." = 1");
		$query->where($db->quoteName('id')." = ".$db->quote($db->escape($id)));
		$query->order('ordering DESC');
		$db->setQuery($query);
		$result = $db->loadObject();

		if ($result != '') {
			$result->url = JRoute::_('index.php?option=com_spmedical&view=specialist&id='.$result->id.':'.$result->alias . SpmedicalHelper::getItemid('specialists'));
		}
		
		return $result;
	}

	// Get Specialist by department id
	public static function getSpecialistsByDepartentId($dept_id) {
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		// Order it by the ordering field.
		$query->select($db->quoteName(array('id', 'title', 'alias', 'image', 'designation', 'description' , 'department_id', 'email', 'socials')));
		$query->from($db->quoteName('#__spmedical_specialists'));
		$query->where($db->quoteName('published')." = 1");
		$query->where($db->quoteName('department_id')." = ".$db->quote($db->escape($dept_id)));
		$query->order('ordering DESC');
		$db->setQuery($query);
		$results = $db->loadObjectList();

		foreach ($results as &$result) {
			$result->url = JRoute::_('index.php?option=com_spmedical&view=specialist&id='.$result->id.':'.$result->alias . SpmedicalHelper::getItemid('specialists'));
		}
		
		return $results;
	}

}
