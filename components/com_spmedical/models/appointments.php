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
    	parent::__construct($config);
	}

	// ajax apointment
	public function insertAppointment( $patient_name = '', $patient_phone = '', $patient_email = '', $appointment_date = '', $patient_note = '', $specialist_id = '', $department_id = '', $user_id, $visitorip = '' ) {

		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$columns = array('patient_name', 'patient_phone', 'patient_email', 'appintment_date', 'patient_note', 'specialist_id', 'department_id', 'visitorip', 'created_by', 'created', 'published');
		$values = array($db->quote($patient_name), $db->quote($patient_phone), $db->quote($patient_email), $db->quote($appointment_date), $db->quote($patient_note), $db->quote($specialist_id), $db->quote($department_id), $db->quote($visitorip), $db->quote($user_id), $db->quote(JFactory::getDate()), 1);
		$query
		    ->insert($db->quoteName('#__spmedical_appointments'))
		    ->columns($db->quoteName($columns))
		    ->values(implode(',', $values));

		$db->setQuery($query);
		$db->execute();
		return $db->insertid();
	}

}
