<?php
defined('_JEXEC') or die;

use SpeventsHelper as EH;

class SpeventsViewSpeakers extends JViewLegacy
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
		$this->model = $this->getModel('speakers');
		$this->filterForm = $this->get('FilterForm');
		$this->activeFilters = $this->get('ActiveFilters');

		SpeventsHelper::addSubmenu('speakers');


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
			JToolbarHelper::addNew('speaker.add');
		}

		if ($canDo->get('core.edit'))
		{
			JToolbarHelper::editList('speaker.edit');
		}

		if ($canDo->get('core.edit.state'))
		{
			JToolbarHelper::publish('speakers.publish','JTOOLBAR_PUBLISH',true);
			JToolbarHelper::unpublish('speakers.unpublish','JTOOLBAR_UNPUBLISH',true);
			JToolbarHelper::archiveList('speakers.archive');
			JToolbarHelper::checkin('speakers.checkin');
		}

		if ($state->get('filter.enabled') == -2 && $canDo->get('core.delete'))
		{
			JToolbarHelper::deleteList('','speakers.delete','JTOOLBAR_EMPTY_TRASH');
		}
		elseif ($canDo->get('core.edit.state'))
		{
			JToolbarHelper::trash('speakers.trash');
		}

		if ($canDo->get('core.admin'))
		{
			JToolbarHelper::preferences('com_spevents');
		}

		JHtmlSidebar::setAction('index.php?option=com_spevents&view=speakers');
		JHtmlSidebar::addFilter(
			JText::_('JOPTION_SELECT_PUBLISHED'),'filter_enabled',
			JHtml::_('select.options',JHtml::_('jgrid.publishedOptions'), 'value','text',$state->get('filter.enabled'), true)
		);

		JToolbarHelper::title(JText::_('COM_SPEVENTS_SPEAKERS_TITLE_LABEL'), 'users');
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