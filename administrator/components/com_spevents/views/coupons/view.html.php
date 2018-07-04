<?php
defined('_JEXEC') or die;

use SpeventsHelper as EH;

class SpeventsViewCoupons extends JViewLegacy
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
		$this->model = $this->getModel('coupons');

		SpeventsHelper::___($this->items);

		SpeventsHelper::addSubmenu('coupons');


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
			JToolbarHelper::addNew('coupon.add');
		}

		if ($canDo->get('core.edit'))
		{
			JToolbarHelper::editList('coupon.edit');
		}

		if ($canDo->get('core.edit.state'))
		{
			JToolbarHelper::publish('coupons.publish','JTOOLBAR_PUBLISH',true);
			JToolbarHelper::unpublish('coupons.unpublish','JTOOLBAR_UNPUBLISH',true);
			JToolbarHelper::archiveList('coupons.archive');
			JToolbarHelper::checkin('coupons.checkin');
		}

		if ($state->get('filter.enabled') == -2 && $canDo->get('core.delete'))
		{
			JToolbarHelper::deleteList('','coupons.delete','JTOOLBAR_EMPTY_TRASH');
		}
		elseif ($canDo->get('core.edit.state'))
		{
			JToolbarHelper::trash('coupons.trash');
		}

		if ($canDo->get('core.admin'))
		{
			JToolbarHelper::preferences('com_spevents');
		}

		JHtmlSidebar::setAction('index.php?option=com_spevents&view=coupons');
		JHtmlSidebar::addFilter(
			JText::_('JOPTION_SELECT_PUBLISHED'),'filter_enabled',
			JHtml::_('select.options',JHtml::_('jgrid.publishedOptions'), 'value','text',$state->get('filter.enabled'), true)
		);

		JToolbarHelper::title(JText::_('COM_SPEVENTS_COUPONS_TITLE_LABEL'), 'stack');
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