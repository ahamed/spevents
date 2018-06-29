<?php
/**
* @package com_spmedical
* @author JoomShaper http://www.joomshaper.com
* @copyright Copyright (c) 2010 - 2018 JoomShaper
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/

// No Direct Access
defined ('_JEXEC') or die('Resticted Aceess');

class SpmedicalViewDoctor extends JViewLegacy {

	protected $form;
	protected $item;
	protected $canDo;
	protected $id;

	public function display($tpl = null) {
		// Get the Data
		$model = $this->getModel('Doctor');
		$this->form = $this->get('Form');
		$this->item = $this->get('Item');
		$this->id = $this->item->id;

		$this->canDo = SpmedicalHelper::getActions($this->item->id);

		// Check for errors.
		if (count($errors = $this->get('Errors'))) {
			JError::raiseError(500, implode('<br />', $errors));
			return false;
		}

		$this->addToolBar();
		parent::display($tpl);
	}

	protected function addToolBar() {
		$input = JFactory::getApplication()->input;
		$userId       = JFactory::getUser()->id;

		// Hide Joomla Administrator Main menu
		$input->set('hidemainmenu', true);
		$isNew = ($this->item->id == 0);

		JToolBarHelper::title(JText::_('COM_SPMEDICAL_DOCTORS') . ': '.  ($isNew ? JText::_('COM_SPMEDICAL_NEW') : JText::_('COM_SPMEDICAL_EDIT')), 'pencil');

		if ($isNew) {
			// For new records, check the create permission.
			if ($this->canDo->get('core.create')) {
				JToolBarHelper::apply('doctor.apply', 'JTOOLBAR_APPLY');
				JToolBarHelper::save('doctor.save', 'JTOOLBAR_SAVE');
			}
			JToolBarHelper::cancel('doctor.cancel', 'JTOOLBAR_CANCEL');
		} else {
			if ($this->canDo->get('core.edit') || $this->canDo->get('core.edit.own') && $this->item->created_by == $userId ) {
				// We can save the new record
				JToolBarHelper::apply('doctor.apply', 'JTOOLBAR_APPLY');
				JToolBarHelper::save('doctor.save', 'JTOOLBAR_SAVE');
			}
			JToolBarHelper::cancel('doctor.cancel', 'JTOOLBAR_CLOSE');
		}
	}
}
