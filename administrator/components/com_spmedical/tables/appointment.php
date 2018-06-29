<?php
/**
* @package com_spmedical
* @author JoomShaper http://www.joomshaper.com
* @copyright Copyright (c) 2010 - 2018 JoomShaper
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/

// No Direct Access
defined ('_JEXEC') or die('Restricted Access');

class SpmedicalTableAppointment extends JTable{

	public function __construct(&$db) {
		parent::__construct('#__spmedical_appointments', 'id', $db);
	}

	public function store($updateNulls = false) {

		$date = JFactory::getDate();
		$user = JFactory::getUser();

		if ($this->id) {
			$this->modified			= $date->toSql();
			$this->modified_by		= $user->get('id');
		} else {
			if (!(int) $this->created) {
				$this->created = $date->toSql();
			}
			if (empty($this->created_by)) {
				$this->created_by = $user->get('id');
			}
		}

		// Verify that the alias is unique
		$table = JTable::getInstance('Appointment', 'SpmedicalTable');

		return parent::store($updateNulls);
	}

	public function check(){
		// // Check for valid name.
		if (trim($this->patient_name) == '') {
			throw new UnexpectedValueException(sprintf('Patient Name is empty'));
		}

		return true;
	}
	
}
