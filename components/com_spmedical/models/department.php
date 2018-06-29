<?php
/**
* @package com_spmedical
* @author JoomShaper http://www.joomshaper.com
* @copyright Copyright (c) 2010 - 2018 JoomShaper
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/

// No Direct Access
defined ('_JEXEC') or die('Restricted Access');

class SpmedicalModelDepartment extends JModelItem {

	protected $_context = 'com_spmedical.department';

	protected function populateState() {
		$app = JFactory::getApplication('site');
		$itemId = $app->input->getInt('id');
		$this->setState('department.id', $itemId);
		$this->setState('filter.language', JLanguageMultilang::isEnabled());
	}

	public function getItem( $itemId = null ) {
		$user = JFactory::getUser();

		$itemId = (!empty($itemId))? $itemId : (int)$this->getState('department.id');

		if ( $this->_item == null ) {
			$this->_item = array();
		}

		if (!isset($this->_item[$itemId])) {
			try {
				$db = $this->getDbo();
				$query = $db->getQuery(true);
				$query->select('a.*');
				$query->from('#__spmedical_departments as a');
				$query->where('a.id = ' . (int) $itemId);

				// Filter by published state.
				$query->where('a.published = 1');

				if ($this->getState('filter.language')) {
					$query->where('a.language in (' . $db->quote(JFactory::getLanguage()->getTag()) . ',' . $db->quote('*') . ')');
				}

				//Authorised
				$groups = implode(',', $user->getAuthorisedViewLevels());
				$query->where('a.access IN (' . $groups . ')');

				$db->setQuery($query);
				$data = $db->loadObject();

				if (empty($data)) {
					return JError::raiseError(404, JText::_('COM_SPMEDICAL_ERROR_ITEM_NOT_FOUND'));
				}

				$user = JFactory::getUser();
				$groups = $user->getAuthorisedViewLevels();
				if(!in_array($data->access, $groups)) {
					return JError::raiseError(404, JText::_('COM_SPMEDICAL_ERROR_NOT_AUTHORISED'));
				}

				$this->_item[$itemId] = $data;
			}
			catch (Exception $e) {
				if ($e->getCode() == 404 ) {
					JError::raiseError(404, $e->getMessage());
				} else {
					$this->setError($e);
					$this->_item[$itemId] = false;
				}
			}
		}

		return $this->_item[$itemId];
	}

}