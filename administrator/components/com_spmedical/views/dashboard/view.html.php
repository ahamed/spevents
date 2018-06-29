<?php
/**
* @package com_spmedical
* @author JoomShaper http://www.joomshaper.com
* @copyright Copyright (c) 2010 - 2018 JoomShaper
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/

// No Direct Access
defined ('_JEXEC') or die('Restricted Access');

class SpmedicalViewDashboard extends JViewLegacy {

	public function display($tpl = null) {

		$model = $this->getModel('Dashboard');	
		$this->canDo = SpmedicalHelper::getActions();

		// Check for errors.
		$errors = $this->get('Errors');
		if ($errors && count($errors)) {
			JError::raiseError(500, implode('<br />', $errors));
			return false;
		}

		JHtml::_('jquery.framework');
		$doc = JFactory::getDocument();
		$doc->addScript( JURI::root(true) . '/administrator/components/com_spmedical/assets/js/Chart.min.js' );

		// get datas
		$this->specialists = $model->getSpecialists();
		$this->departments = $model->getDepartments();
		$this->appointments = $model->getAppointments();
		$this->specialistsList = $model->getSpecialistsList();
		$this->appointmentsList = $model->getAppointmentList();

		SpmedicalHelper::addSubmenu('dashboard');
		$this->addToolBar();
		$this->sidebar = JHtmlSidebar::render();
		parent::display($tpl);

	}

	protected function addToolBar() {
		JToolBarHelper::title(JText::_('COM_SPMEDICAL_PAGE_HEADING') .  JText::_('COM_SPMEDICAL_MANAGER_DASHBOARD'));
		
		if ($this->canDo->get('core.admin')) {
			JToolBarHelper::preferences('com_spmedical');
		}
	}

}
