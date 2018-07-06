<?php
defined('_JEXEC') or die;

use SpeventsHelper as EH;

class SpeventsViewOrders extends JViewLegacy
{
	protected $items;

	protected $state;

	protected $pagination;

	protected $model;

	public function display($tpl = null)
	{
		$this->items    = $this->get('Items');
		$this->state    = $this->get('State');
		$this->pagination = $this->get('Pagination');
		$this->model = $this->getModel('orders');

//		/SpeventsHelper::___($this->items);

		SpeventsHelper::addSubmenu('orders');


		if (count($errors = $this->get('Errors')))
		{
			JError::raiseError(500,implode('<br>', $errors));
			return false;
		}

        //$this->addToolbar();
        JToolbarHelper::title(JText::_('COM_SPEVENTS_ORDERS_TITLE_LABEL'), 'cart');
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
			JToolbarHelper::addNew('location.add');
		}

		if ($canDo->get('core.edit'))
		{
			JToolbarHelper::editList('locations.edit');
		}

		if ($canDo->get('core.edit.state'))
		{
			JToolbarHelper::publish('locations.publish','JTOOLBAR_PUBLISH',true);
			JToolbarHelper::unpublish('locationss.unpublish','JTOOLBAR_UNPUBLISH',true);
			JToolbarHelper::archiveList('locations.archive');
			JToolbarHelper::checkin('locations.checkin');
		}

		if ($state->get('filter.enabled') == -2 && $canDo->get('core.delete'))
		{
			JToolbarHelper::deleteList('','locations.delete','JTOOLBAR_EMPTY_TRASH');
		}
		elseif ($canDo->get('core.edit.state'))
		{
			JToolbarHelper::trash('locations.trash');
		}

		if ($canDo->get('core.admin'))
		{
			JToolbarHelper::preferences('com_spevents');
		}

		JHtmlSidebar::setAction('index.php?option=com_spevents&view=locations');
		JHtmlSidebar::addFilter(
			JText::_('JOPTION_SELECT_PUBLISHED'),'filter_enabled',
			JHtml::_('select.options',JHtml::_('jgrid.publishedOptions'), 'value','text',$state->get('filter.enabled'), true)
		);

		
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