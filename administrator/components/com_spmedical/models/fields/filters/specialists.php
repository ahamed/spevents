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

class JFormFieldSpecialists extends JFormField{

	protected $type = 'Specialists';

	public function getItems() {

		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select('*');
		$query->from($db->quoteName('#__spmedical_specialists'));
		$query->where($db->quoteName('published')." = 1");
		$query->order('ordering DESC');
		$db->setQuery($query);

		return $db->loadObjectList();

	}

	public function getInput() {
		$Items    = $this->getItems();

		$itemid = '';
		if ($this->value) {
			$itemid = $this->value;
		}

		$selected = ($itemid == '') ? 'selected' : '' ;
		$output = '';
		$output .= '<select id="'.$this->id.'" name="'.$this->name.'" onchange="this.form.submit();">';
		$output .= '<option value="" ' . $selected . '>'. JText::_('COM_SPMEDICAL_FILTER_SPECIALISTS') .'</option>';
		foreach ($Items as $key => $item) {
			$selected = ($item->id == $itemid) ? 'selected' : '' ;
			$output .= '<option value="'. $item->id .'" ' . $selected . '>'. $item->title .'</option>';
		}
		$output .= '</select>';

		return $output;
	}

}
