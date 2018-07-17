<?php
defined('_JEXEC') or die;

use SpeventsHelper as EH;

class SpeventsViewSubscriptions extends JViewLegacy
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
		$this->model = $this->getModel('subscriptions');

//		/SpeventsHelper::___($this->items);

		SpeventsHelper::addSubmenu('subscriptions');


		if (count($errors = $this->get('Errors')))
		{
			JError::raiseError(500,implode('<br>', $errors));
			return false;
		}

        //$this->addToolbar();
        JToolbarHelper::title(JText::_("COM_SPEVENTS_SUBMENU_SUBSCRIBERS"), 'mail');
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