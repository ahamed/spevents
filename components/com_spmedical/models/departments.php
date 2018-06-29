<?php
/**
* @package com_spmedical
* @author JoomShaper http://www.joomshaper.com
* @copyright Copyright (c) 2010 - 2018 JoomShaper
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/

// No Direct Access
defined ('_JEXEC') or die('Restricted Access');

class SpmedicalModelDepartments extends JModelList {

	protected function getListQuery() {
		$app = JFactory::getApplication();
		$user = JFactory::getUser();
		// Get Params
		$params   = $app->getMenu()->getActive()->params;
		$ordering = $params->get('ordering', ' DESC');

		// Create a new query object.
		$db = $this->getDbo();
		$query = $db->getQuery(true);
		$query->select('a.*');
		$query->from($db->quoteName('#__spmedical_departments', 'a'));
		$groups = implode(',', $user->getAuthorisedViewLevels());
		$query->where('a.access IN (' . $groups . ')');
		$query->where('a.language in (' . $db->quote(JFactory::getLanguage()->getTag()) . ',' . $db->quote('*') . ')');
		$query->where($db->qn('a.published')." = ".$db->quote('1'));
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

	// Get departments
	public static function getDepartments($id = '', $short = false) {
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		// Order it by the ordering field.
		if($short){
			$query->select($db->quoteName(array('id', 'title', 'alias')));
		} else {
			$query->select($db->quoteName(array('id', 'title', 'alias', 'description' , 'image', 'treatments', 'investigations', 'others_services')));
		}
		$query->from($db->quoteName('#__spmedical_departments'));
		$query->where($db->quoteName('published')." = 1");
		if($id){
			$query->where($db->quoteName('id')." = ".$db->quote($id));
		}
		$query->order('ordering DESC');
		$db->setQuery($query);
		
		if($id){
			$results = $db->loadObject();
			if ($result != '') {
				$result->url = JRoute::_('index.php?option=com_spmedical&view=department&id='.$result->id.':'.$result->alias . SpmedicalHelper::getItemid('departments'));
			}
		} else {
			$results = $db->loadObjectList();
		}
		
		return $results;
	}

}
