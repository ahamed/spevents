<?php
/**
* @package com_spmedical
* @author JoomShaper http://www.joomshaper.com
* @copyright Copyright (c) 2010 - 2018 JoomShaper
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/

// No Direct Access
defined ('_JEXEC') or die('Restricted Access');

class SpmedicalModelAppointments extends JModelList {

	public function __construct($config = array()) {
		if (empty($config['filter_fields'])){
			$config['filter_fields'] = array(
				'id','a.id',
				'specialist_name','a.specialist_id',
				'department','a.department_id',
				'patient_name','a.patient_name',
				'checked_out', 'a.checked_out',
				'checked_out_time', 'a.checked_out_time',
				'created_by','a.created_by',
				'published','a.published',
				'created_on','a.created_on',
				'ordering', 'a.ordering',
				'hits', 'a.hits',
				'specialist_id',
				'department_id',
				'appintment_date',
			);
		}

		parent::__construct($config);
	}

	protected function populateState($ordering = 'a.id', $direction = 'desc') {
		$app = JFactory::getApplication();
		$context = $this->context;

		$search = $this->getUserStateFromRequest($this->context . '.filter.search', 'filter_search');
		$this->setState('filter.search', $search);

		$published = $this->getUserStateFromRequest($this->context . '.filter.published', 'filter_published', '');
		$this->setState('filter.published', $published);
		
		$departmentId = $this->getUserStateFromRequest($this->context . '.filter.department_id', 'filter_department_id');
		$this->setState('filter.department_id', $departmentId);

		$specialistId = $this->getUserStateFromRequest($this->context . '.filter.specialist_id', 'filter_specialist_id');
		$this->setState('filter.specialist_id', $specialistId);

		$appintmentDate = $this->getUserStateFromRequest($this->context . '.filter.appintment_date', 'filter_appintment_date');

		$this->setState('filter.appintment_date', $appintmentDate);

		// List state information.
		parent::populateState($ordering, $direction);
	}

	protected function getStoreId($id = '') {
		// Compile the store id.
		$id .= ':' . $this->getState('filter.search');
		$id .= ':' . $this->getState('filter.published');
		$id .= ':' . $this->getState('filter.department_id');
		$id .= ':' . $this->getState('filter.specialist_id');
		$id .= ':' . $this->getState('filter.appintment_date');

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

		$query->select($db->quoteName('b.title', 'specialist_name'));
		$query->select($db->quoteName('c.title', 'department_name'));
		$query->from('#__spmedical_appointments as a');
		$query->join('LEFT', $db->quoteName('#__spmedical_specialists', 'b') . ' ON (' . $db->quoteName('a.specialist_id') . ' = ' . $db->quoteName('b.id') . ')');
		$query->join('LEFT', $db->quoteName('#__spmedical_departments', 'c') . ' ON (' . $db->quoteName('a.department_id') . ' = ' . $db->quoteName('c.id') . ')');
		// Join over the users for the checked out user.
		$query->select('uc.name AS editor')
			->join('LEFT', '#__users AS uc ON uc.id=a.checked_out');
		$query->select('ua.name AS author_name')
			->join('LEFT', '#__users AS ua ON ua.id = a.created_by');

		// Filter by published state
		$published = $this->getState('filter.published');

		if (is_numeric($published)) {
			$query->where('a.published = ' . (int) $published);
		} elseif ($published === '') {
			$query->where('(a.published IN (0, 1))');
		}

		// Filter by a single or group of departments.
		$departmentId = $this->getState('filter.department_id');
		if (is_numeric($departmentId)){
			$query->where('a.department_id = ' . $db->quote($departmentId));
		} elseif (is_array($departmentId)) {
			JArrayHelper::toInteger($departmentId);
			$departmentId = implode(',', $departmentId);
			$query->where('a.department_id IN (' . $departmentId . ')');
		}

		// Filter by a single or group of specialists.
		$specialistId = $this->getState('filter.specialist_id');
		if (is_numeric($specialistId)){
			$query->where('a.specialist_id = ' . $db->quote($specialistId));
		} elseif (is_array($specialistId)) {
			JArrayHelper::toInteger($specialistId);
			$specialistId = implode(',', $specialistId);
			$query->where('a.specialist_id IN (' . $specialistId . ')');
		}

		// Filter by a single date.
		$appintmentDate = $db->escape($this->getState('filter.appintment_date'));
		if($appintmentDate && self::is_date($appintmentDate)) {
			$query->where('a.appintment_date = ' . $db->quote($appintmentDate));
		}

		$search = $this->getState('filter.search');
		if (!empty($search)) {
			if (stripos($search, 'id:') === 0) {
				$query->where('a.id = ' . (int) substr($search, 3));
			} elseif (stripos($search, 'email:') === 0) {
				$search = $db->quote('%' . $db->escape(substr($search, 7), true) . '%');
				$query->where('(a.patient_email LIKE ' . $search . ')');
			} else {
				$search = $db->quote('%' . $db->escape($search, true) . '%');
				$query->where('(a.patient_email LIKE ' . $search . ' OR a.patient_name LIKE ' . $search . ' OR a.patient_phone LIKE ' . $search . ')');
			}
		}

		// Add the list ordering clause.
		$orderCol = $app->getUserStateFromRequest($this->context.'filter_order', 'filter_order', 'id', 'cmd');
		$orderDirn = $app->getUserStateFromRequest($this->context.'filter_order_Dir', 'filter_order_Dir', 'desc', 'cmd');

		$query->order($db->escape($orderCol) . ' ' . $db->escape($orderDirn));

		return $query;
	}

	protected static function is_date( $str ) {
		try {
			$dt = new DateTime( trim($str) );
		}
		catch( Exception $e ) {
			return false;
		}
		$month = $dt->format('m');
		$day = $dt->format('d');
		$year = $dt->format('Y');
		if( checkdate($month, $day, $year) ) {
			return true;
		}
		else {
			return false;
		}
	}

}
