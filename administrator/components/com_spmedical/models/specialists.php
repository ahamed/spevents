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

	public function __construct($config = array()) {
		if (empty($config['filter_fields'])){
			$config['filter_fields'] = array(
				'id','a.id',
				'title','a.title',
				'department','a.department_id',
				'checked_out', 'a.checked_out',
				'checked_out_time', 'a.checked_out_time',
				'created_by','a.created_by',
				'published','a.published',
				'access', 'a.access', 'access_level',
				'created_on','a.created_on',
				'ordering', 'a.ordering',
				'hits', 'a.hits',
				'language','a.language',
				'department_id',
			);
		}

		parent::__construct($config);
	}

	protected function populateState($ordering = 'a.id', $direction = 'desc') {
		$app = JFactory::getApplication();
		$context = $this->context;

		$search = $this->getUserStateFromRequest($this->context . '.filter.search', 'filter_search');
		$this->setState('filter.search', $search);

		$access = $this->getUserStateFromRequest($this->context . '.filter.access', 'filter_access');
		$this->setState('filter.access', $access);

		$published = $this->getUserStateFromRequest($this->context . '.filter.published', 'filter_published', '');
		$this->setState('filter.published', $published);

		$departmentId = $this->getUserStateFromRequest($this->context . '.filter.department_id', 'filter_department_id');
		$this->setState('filter.department_id', $departmentId);

		$language = $this->getUserStateFromRequest($this->context . '.filter.language', 'filter_language', '');
		$this->setState('filter.language', $language);

		// List state information.
		parent::populateState($ordering, $direction);
	}

	protected function getStoreId($id = '') {
		// Compile the store id.
		$id .= ':' . $this->getState('filter.search');
		$id .= ':' . $this->getState('filter.access');
		$id .= ':' . $this->getState('filter.published');
		$id .= ':' . $this->getState('filter.department_id');
		$id .= ':' . $this->getState('filter.language');

		return parent::getStoreId($id);
	}

	/**
	* Method to build an SQL query to load the list data.
	*
	* @return      string  An SQL query
	*/
	protected function getListQuery() {
		// Initialize variables.
		$app = JFactory::getApplication();
		$db    = JFactory::getDbo();
		$query = $db->getQuery(true);

		// Create the base select statement.
		$query->select(
			$this->getState(
				'list.select',
				'a.*'
			)
		);
		$query->select($db->quoteName('d.title', 'department_name'));
		$query->from('#__spmedical_specialists as a');
		$query->join('LEFT', $db->quoteName('#__spmedical_departments', 'd') . ' ON (' . $db->quoteName('a.department_id') . ' = ' . $db->quoteName('d.id') . ')');
		$query->select('l.title AS language_title')
			->join('LEFT', $db->quoteName('#__languages') . ' AS l ON l.lang_code = a.language');
		// Join over the users for the checked out user.
		$query->select('uc.name AS editor')
			->join('LEFT', '#__users AS uc ON uc.id=a.checked_out');
		$query->select('ua.name AS author_name')
			->join('LEFT', '#__users AS ua ON ua.id = a.created_by');
		$query->select('ug.title AS access_title')
			->join('LEFT','#__viewlevels AS ug ON ug.id = a.access');

		// Filter by published state
		$published = $this->getState('filter.published');

		if (is_numeric($published)) {
			$query->where('a.published = ' . (int) $published);
		} elseif ($published === '') {
			$query->where('(a.published IN (0, 1))');
		}

		// Filter by language
		if ($language = $this->getState('filter.language')) {
			$query->where('a.language = ' . $db->quote($language));
		}

		// Filter by a single or group of categories.
		$baselevel = 1;
		$departmentId = $this->getState('filter.department_id');

		if (is_numeric($departmentId)){
			$query->where('a.department_id = ' . $db->quote($departmentId));
		} elseif (is_array($departmentId)) {
			JArrayHelper::toInteger($departmentId);
			$departmentId = implode(',', $departmentId);
			$query->where('a.department_id IN (' . $departmentId . ')');
		}

		$search = $this->getState('filter.search');
		if (!empty($search)) {
			if (stripos($search, 'id:') === 0) {
				$query->where('a.id = ' . (int) substr($search, 3));
			} elseif (stripos($search, 'author:') === 0) {
				$search = $db->quote('%' . $db->escape(substr($search, 7), true) . '%');
				$query->where('(uc.name LIKE ' . $search . ' OR uc.username LIKE ' . $search . ')');
			} else {
				$search = $db->quote('%' . $db->escape($search, true) . '%');
				$query->where('(a.title LIKE ' . $search . ')');
			}
		}

		// Add the list ordering clause.
		$orderCol = $app->getUserStateFromRequest($this->context.'filter_order', 'filter_order', 'id', 'cmd');
		$orderDirn = $app->getUserStateFromRequest($this->context.'filter_order_Dir', 'filter_order_Dir', 'desc', 'cmd');

		$query->order($db->escape($orderCol) . ' ' . $db->escape($orderDirn));

		return $query;
	}
}