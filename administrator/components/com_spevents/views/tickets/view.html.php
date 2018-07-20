<?php
defined('_JEXEC') or die;

use SpeventsHelper as EH;

class SpeventsViewTickets extends JViewLegacy
{
	protected $items;

	protected $state;

	protected $pagination;

	protected $model;

	public $filterForm, $activeFilters;

	public function display($tpl = null)
	{
		$this->items    = $this->get('Items');
		$this->state    = $this->get('State');
		$this->pagination = $this->get('Pagination');
		$this->model = $this->getModel('tickets');
		$this->filterForm = $this->get('FilterForm');
		$this->activeFilters = $this->get('ActiveFilters');


		SpeventsHelper::addSubmenu('tickets');


		if (count($errors = $this->get('Errors')))
		{
			JError::raiseError(500,implode('<br>', $errors));
			return false;
		}

		$this->addToolbar();
		$this->sidebar = JHtmlSidebar::render();

		return parent::display($tpl);
	}


	protected function addToolbar()
	{
		$state = $this->get('State');
		$canDo = SpeventsHelper::getActions('com_spevents','component');
		$user = JFactory::getUser();
		$bar = JToolbar::getInstance('toolbar');


		if ($canDo->get('core.create'))
		{
			JToolbarHelper::addNew('ticket.add');
		}

		if ($canDo->get('core.edit'))
		{
			JToolbarHelper::editList('ticket.edit');
		}

		if ($canDo->get('core.edit.state'))
		{
			JToolbarHelper::publish('tickets.publish','JTOOLBAR_PUBLISH',true);
			JToolbarHelper::unpublish('tickets.unpublish','JTOOLBAR_UNPUBLISH',true);
			JToolbarHelper::archiveList('tickets.archive');
			JToolbarHelper::checkin('tickets.checkin');
		}

		if ($state->get('filter.enabled') == -2 && $canDo->get('core.delete'))
		{
			JToolbarHelper::deleteList('','tickets.delete','JTOOLBAR_EMPTY_TRASH');
		}
		elseif ($canDo->get('core.edit.state'))
		{
			JToolbarHelper::trash('tickets.trash');
		}

		if ($canDo->get('core.admin'))
		{
			JToolbarHelper::preferences('com_spevents');
		}

		JHtmlSidebar::setAction('index.php?option=com_spevents&view=tickets');
		JToolbarHelper::title(JText::_('COM_SPEVENTS_TICKETS_TITLE_LABEL'), 'tags');
	}

	protected function getSortFields() {
		return [
			'a.ordering' => JText::_('JGRID_HEADING_ORDERING'),
			'a.enabled' => JText::_('JSTATUS'),
			'a.title' => JText::_('JGLOBAL_TITLE'),
			'a.id' => JText::_('JGRID_HEADING_ID')
		];
	}
}