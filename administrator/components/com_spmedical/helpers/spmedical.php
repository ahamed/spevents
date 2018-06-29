<?php
/**
* @package com_spmedical
* @author JoomShaper http://www.joomshaper.com
* @copyright Copyright (c) 2010 - 2018 JoomShaper
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/

// No Direct Access
defined ('_JEXEC') or die('Restricted Access');

class SpmedicalHelper {

	public static $extension = 'com_spmedical';

	public static function addSubmenu($submenu) {
		JHtmlSidebar::addEntry(
			JText::_('COM_SPMEDICAL_DASHBOARD'),
			'index.php?option=com_spmedical&view=dashboard',
			$submenu == 'dashboard'
		);

		JHtmlSidebar::addEntry(
			JText::_('COM_SPMEDICAL_SPECIALISTS'),
			'index.php?option=com_spmedical&view=specialists',
			$submenu == 'specialists'
		);

		JHtmlSidebar::addEntry(
			JText::_('COM_SPMEDICAL_DEPARTMENTS'),
			'index.php?option=com_spmedical&view=departments',
			$submenu == 'departments'
		);

		JHtmlSidebar::addEntry(
			JText::_('COM_SPMEDICAL_APPOINTMENTS'),
			'index.php?option=com_spmedical&view=appointments',
			$submenu == 'appointments'
		);
	}

	public static function getActions($messageId = 0) {
		$result	= new JObject;

		if (empty($messageId)) {
			$assetName = 'com_spmedical';
		} else {
			$assetName = 'com_spmedical.doctor.'.(int) $messageId;
		}

		$actions = JAccess::getActions('com_spmedical', 'component');

		foreach ($actions as $action) {
			$result->set($action->name, JFactory::getUser()->authorise($action->name, $assetName));
		}

		return $result;
	}

	//Get Appointments sales by day
	public static function getAppointments($day, $month, $year) {

		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select('count(id)');
		$query->from($db->quoteName('#__spmedical_appointments'));
		$query->where('DAY(appintment_date) = ' . $day);
		$query->where('MONTH(appintment_date) = ' . $month);
		$query->where('YEAR(appintment_date) = ' . $year);
		$query->where($db->quoteName('published')." = 1");
		$db->setQuery($query);
		$results = $db->loadResult();

		return $results;
	}

	public static function getVersion() {
		$db = JFactory::getDbo();
		$query = $db->getQuery(true)
		->select('e.manifest_cache')
		->select($db->quoteName('e.manifest_cache'))
		->from($db->quoteName('#__extensions', 'e'))
		->where($db->quoteName('e.element') . ' = ' . $db->quote('com_spmedical'));
		$db->setQuery($query);
		$manifest_cache = json_decode($db->loadResult());
		if(isset($manifest_cache->version) && $manifest_cache->version) {
			return $manifest_cache->version;
		}	
		return '1.0';
	}
	
}
