<?php
/**
* @package com_spmedical
* @author JoomShaper http://www.joomshaper.com
* @copyright Copyright (c) 2010 - 2018 JoomShaper
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/

// No Direct Access
defined ('_JEXEC') or die('Restricted Access');

use Joomla\String\StringHelper;

class SpmedicalModelDepartment extends JModelAdmin {
	/**
	* Method to get a table object, load it if necessary.
	*
	* @param   string  $type    The table name. Optional.
	* @param   string  $prefix  The class prefix. Optional.
	* @param   array   $config  Configuration array for model. Optional.
	*
	* @return  JTable  A JTable object
	*
	* @since   1.6
	*/

	public function getTable($type = 'Department', $prefix = 'SpmedicalTable', $config = array()) {
		return JTable::getInstance($type, $prefix, $config);
	}
	

	/**
	* Method to get the record form.
	*
	* @param   array    $data      Data for the form.
	* @param   boolean  $loadData  True if the form is to load its own data (default case), false if not.
	*
	* @return  mixed    A JForm object on success, false on failure
	*
	* @since   1.6
	*/
	public function getForm($data = array(), $loadData = true) {

		// Get the form.
		$form = $this->loadForm('com_spmedical.department', 'department', array( 'control' => 'jform', 'load_data' => $loadData ) );

		if (empty($form)) {
			return false;
		}

		return $form;
	}

	/**
	* Method to get the data that should be injected in the form.
	*
	* @return  mixed  The data for the form.
	*
	* @since   1.6
	*/
	protected function loadFormData($data = array(), $loadData = true) {

		// Check the session for previously entered form data.
		$data = JFactory::getApplication()->getUserState( 'com_spmedical.edit.department.data', array() );
		if (empty($data)) {
			$data = $this->getItem();
		}

		return $data;
	}

	public function save($data) {
		$input  = JFactory::getApplication()->input;
		$filter = JFilterInput::getInstance();

		// Automatic handling of alias for empty fields
		if (in_array($input->get('task'), array('apply', 'save')) && (!isset($data['id']) || (int) $data['id'] == 0)) {
			if ($data['alias'] == null) {
				if (JFactory::getConfig()->get('unicodeslugs') == 1) {
					$data['alias'] = JFilterOutput::stringURLUnicodeSlug($data['title']);
				} else {
					$data['alias'] = JFilterOutput::stringURLSafe($data['title']);
				}
				
				$table = JTable::getInstance('Department', 'SpmedicalTable');
				while ($table->load(array('alias' => $data['alias']))) {
					$data['alias'] = StringHelper::increment($data['alias'], 'dash');
				}
			}
		}

		if (parent::save($data)) {
			return true;
		}

		return false;
	}

	/**
	* Method to check if it's OK to delete a message. Overwrites JModelAdmin::canDelete
	*/
	protected function canDelete($record) {
		if (!empty($record->id)) {
			if ($record->published != -2) {
				return false;
			}

			return JFactory::getUser()->authorise('core.delete', 'com_spmedical.department.' . (int) $record->id);
		}

		return false;
	}
}
