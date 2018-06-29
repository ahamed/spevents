<?php
/**
* @package com_spmedical
* @author JoomShaper http://www.joomshaper.com
* @copyright Copyright (c) 2010 - 2018 JoomShaper
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/

// No Direct Access
defined ('_JEXEC') or die('Restricted Access');

class SpmedicalModelDashboard extends JModelLegacy {

	// Get specialists
	public static function getSpecialists() {
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select('COUNT(id)');
		$query->from($db->quoteName('#__spmedical_specialists'));
		$query->where($db->quoteName('published')." = 1");
		$query->order('ordering DESC');
		$db->setQuery($query);
		$results = $db->loadResult();

		return $results;
	}

	// Get specialists
	public static function getDepartments() {
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select('COUNT(id)');
		$query->from($db->quoteName('#__spmedical_departments'));
		$query->where($db->quoteName('published')." = 1");
		$query->order('ordering DESC');
		$db->setQuery($query);
		$results = $db->loadResult();

		return $results;
	}

	// Get specialists
	public static function getAppointments() {
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select('COUNT(id)');
		$query->from($db->quoteName('#__spmedical_appointments'));
		$query->where($db->quoteName('published')." = 1");
		$query->order('ordering DESC');
		$db->setQuery($query);
		$results = $db->loadResult();

		return $results;
	}

	// get specialists list
	public static function getSpecialistsList() {
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);

		$query->select($db->quoteName(array('a.id', 'a.title', 'a.created', 'a.designation', 'a.department_id')));
		$query->select($db->quoteName('b.title', 'department_name'));
		$query->from('#__spmedical_specialists as a');
		$query->join('LEFT', $db->quoteName('#__spmedical_departments', 'b') . ' ON (' . $db->quoteName('a.department_id') . ' = ' . $db->quoteName('b.id') . ')');
		$query->where($db->quoteName('a.published')." = 1");
		$query->setLimit('5');
		$query->order('a.created DESC');
		$db->setQuery($query);
		$results = $db->loadObjectList();

		return $results;
	}

	//Orders List
	public static function getAppointmentList() {
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);

		$query->select($db->quoteName(array('a.id', 'a.patient_name', 'a.specialist_id', 'a.appintment_date')));
		$query->select($db->quoteName('b.title', 'specialist_name'));
		$query->from($db->quoteName('#__spmedical_appointments', 'a'));
		$query->join('LEFT', $db->quoteName('#__spmedical_specialists', 'b') . ' ON (' . $db->quoteName('a.specialist_id') . ' = ' . $db->quoteName('b.id') . ')');
		$query->where($db->quoteName('a.published')." = 1");
		$query->setLimit('5');
		$query->order('a.created DESC');
		$db->setQuery($query);
		$results = $db->loadObjectList();

		if ($results && count($results)) {
			return $results;
		} else {
			return array();
		}
	}
	  
}
