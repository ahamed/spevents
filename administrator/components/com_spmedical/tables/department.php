<?php
/**
* @package com_spmedical
* @author JoomShaper http://www.joomshaper.com
* @copyright Copyright (c) 2010 - 2018 JoomShaper
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/

// No Direct Access
defined ('_JEXEC') or die('Restricted Access');

class SpmedicalTableDepartment extends JTable{

	public function __construct(&$db) {
		parent::__construct('#__spmedical_departments', 'id', $db);
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
		$table = JTable::getInstance('Department', 'SpmedicalTable');

		if ($table->load(array('alias' => $this->alias)) && ($table->id != $this->id || $this->id == 0)) {
			$this->setError(JText::_('COM_SPMEDICAL_ERROR_UNIQUE_ALIAS'));

			return false;
		}

		return parent::store($updateNulls);
	}

	public function check(){
		// Check for valid name.
		if (trim($this->title) == '') {
			throw new UnexpectedValueException(sprintf('The title is empty'));
		}

		if (empty($this->alias)) {
			$this->alias = $this->title;
		}

		$this->alias = JApplicationHelper::stringURLSafe($this->alias, $this->language);

		if (trim(str_replace('-', '', $this->alias)) == '') {
			$this->alias = JFactory::getDate()->format('Y-m-d-H-i-s');
		}

		//treatments
		if (is_array($this->treatments)){
			if (!empty($this->treatments)){
				$this->treatments = json_encode($this->treatments);
			}
		}
		if (is_null($this->treatments) || empty($this->treatments)){
			$this->treatments = '';
		}

		//investigations
		if (is_array($this->investigations)){
			if (!empty($this->investigations)){
				$this->investigations = json_encode($this->investigations);
			}
		}
		if (is_null($this->investigations) || empty($this->investigations)){
			$this->investigations = '';
		}

		//others_services
		if (is_array($this->others_services)){
			if (!empty($this->others_services)){
				$this->others_services = json_encode($this->others_services);
			}
		}
		if (is_null($this->others_services) || empty($this->others_services)){
			$this->others_services = '';
		}

		return true;
	}
	
}
