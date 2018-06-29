<?php
/**
* @package com_spmedical
* @author JoomShaper http://www.joomshaper.com
* @copyright Copyright (c) 2010 - 2018 JoomShaper
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/

// No Direct Access
defined ('_JEXEC') or die('Resticted Aceess');

class SpmedicalViewSpecialists extends JViewLegacy {

	protected $items;
	protected $pagination;
	protected $state;
	public $filterForm;
	public $activeFilters;
	protected $sidebar;

	function display($tpl = null){

		// Get application
		$app = JFactory::getApplication();
		$context = "com_spmedical.specialists";

		// Get data from the model
		$this->items = $this->get('Items');
		$this->pagination = $this->get('Pagination');
		$this->state = $this->get('State');
		$this->filter_order = $app->getUserStateFromRequest($context.'filter_order', 'filter_order', 'id', 'cmd');
		$this->filter_order_Dir = $app->getUserStateFromRequest($context.'filter_order_Dir', 'filter_order_Dir', 'desc', 'cmd');
		$this->filterForm = $this->get('FilterForm');
		$this->activeFilters = $this->get('ActiveFilters');
		$this->canDo = SpmedicalHelper::getActions();

		// Check for errors.
		if (count($errors = $this->get('Errors'))){
			JError::raiseError(500, implode('<br />', $errors));
			return false;
		}

		// Set the submenu
		SpmedicalHelper::addSubmenu('specialists');
		$this->addToolBar();
		$this->sidebar = JHtmlSidebar::render();

		return parent::display($tpl);
	}

	protected function addToolBar() {
		JToolBarHelper::title(JText::_('COM_SPMEDICAL_PAGE_HEADING') .  JText::_('COM_SPMEDICAL_SPECIALISTS'));

		if ($this->canDo->get('core.create')) {
			JToolBarHelper::addNew('specialist.add', 'JTOOLBAR_NEW');
		}
		if ($this->canDo->get('core.edit')) {
			JToolBarHelper::editList('specialist.edit', 'JTOOLBAR_EDIT');
		}

		if ($this->canDo->get('core.edit.state')) {
			JToolbarHelper::publish('specialists.publish', 'JTOOLBAR_PUBLISH', true);
			JToolbarHelper::unpublish('specialists.unpublish', 'JTOOLBAR_UNPUBLISH', true);
			JToolbarHelper::archiveList('specialists.archive');
			JToolbarHelper::checkin('specialists.checkin');
		}

		if ($this->state->get('filter.published') == -2 && $this->canDo->get('core.delete')) {
			JToolbarHelper::deleteList('', 'specialists.delete', 'JTOOLBAR_EMPTY_TRASH');
		} elseif ($this->canDo->get('core.edit.state')) {
			JToolbarHelper::trash('specialists.trash');
		}

		if ($this->canDo->get('core.admin')) {
			JToolBarHelper::divider();
			JToolBarHelper::preferences('com_spmedical');
		}
	}
}