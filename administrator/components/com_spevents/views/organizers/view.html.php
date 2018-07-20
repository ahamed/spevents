<?php
defined('_JEXEC') or die;

use SpeventsHelper as EH;

class SpeventsViewOrganizers extends JViewLegacy
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
		$this->model = $this->getModel('organizers');
		$this->filterForm = $this->get('FilterForm');
		$this->activeFilters = $this->get('ActiveFilters');

		SpeventsHelper::addSubmenu('organizers');


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
			JToolbarHelper::addNew('organizer.add');
		}

		if ($canDo->get('core.edit'))
		{
			JToolbarHelper::editList('organizer.edit');
		}

		if ($canDo->get('core.edit.state'))
		{
			JToolbarHelper::publish('organizers.publish','JTOOLBAR_PUBLISH',true);
			JToolbarHelper::unpublish('organizers.unpublish','JTOOLBAR_UNPUBLISH',true);
			JToolbarHelper::archiveList('organizers.archive');
			JToolbarHelper::checkin('organizers.checkin');
		}

		if ($state->get('filter.enabled') == -2 && $canDo->get('core.delete'))
		{
			JToolbarHelper::deleteList('','organizers.delete','JTOOLBAR_EMPTY_TRASH');
		}
		elseif ($canDo->get('core.edit.state'))
		{
			JToolbarHelper::trash('organizers.trash');
		}

		if ($canDo->get('core.admin'))
		{
			JToolbarHelper::preferences('com_spevents');
		}

		JHtmlSidebar::setAction('index.php?option=com_spevents&view=organizers');
		JToolbarHelper::title(JText::_('COM_SPEVENTS_ORGANIZERS_TITLE_LABEL'), 'wand');
	}

	protected function getSortFields() {
		return [
			'a.ordering' => JText::_('JGRID_HEADING_ORDERING'),
			'a.phone' => 'Phone',
			'a.enabled' => JText::_('JSTATUS'),
			'a.title' => JText::_('JGLOBAL_TITLE'),
			'a.id' => JText::_('JGRID_HEADING_ID')
		];
	}
}