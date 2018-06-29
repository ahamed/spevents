<?php
/**
* @package com_spmedical
* @author JoomShaper http://www.joomshaper.com
* @copyright Copyright (c) 2010 - 2018 JoomShaper
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/

// No Direct Access
defined ('_JEXEC') or die('Restricted Access');

jimport('joomla.filesystem.file');

class JFormFieldDepartments extends JFormField{

	protected $type = 'Departments';

	public function getDepartments() {

		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select('*');
		$query->from($db->quoteName('#__spmedical_departments'));
		$query->where($db->quoteName('published')." = 1");
		$query->order('ordering DESC');
		$db->setQuery($query);

		return $db->loadObjectList();

	}

	public function getInput() {
		$departments    = $this->getDepartments();

		$deptid = '';
		if ($this->value) {
			$deptid = $this->value;
		}

		$selected = ($deptid == '') ? 'selected' : '' ;
		$output = '';
		$output .= '<select id="'.$this->id.'" name="'.$this->name.'" onchange="this.form.submit();">';
		$output .= '<option value="" ' . $selected . '>'. JText::_('COM_SPMEDICAL_FILTER_DEPARTMENTS') .'</option>';
		foreach ($departments as $key => $department) {
			$selected = ($department->id == $deptid) ? 'selected' : '' ;
			$output .= '<option value="'. $department->id .'" ' . $selected . '>'. $department->title .'</option>';
		}
		$output .= '</select>';

		return $output;
	}

}
