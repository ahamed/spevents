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
		SpeventsHelper::addSubmenu('orders');

		if (count($errors = $this->get('Errors')))
		{
			JError::raiseError(500,implode('<br>', $errors));
			return false;
		}

        JToolbarHelper::title(JText::_('COM_SPEVENTS_ORDERS_TITLE_LABEL'), 'cart');
		$this->sidebar = JHtmlSidebar::render();

		return parent::display($tpl);
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