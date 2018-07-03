<?php
defined('_JEXEC') or die;

use SpeventsHelper as EH;

class SpeventsViewDashboards extends JViewLegacy
{
	protected $items;

	protected $state;

	protected $pagination;

    protected $model;
    
    protected $categories, $events, $speakers, $speakerList;

	public function display($tpl = null)
	{
		$this->items    = $this->get('Items');
		$this->state    = $this->get('State');
		$this->pagination = $this->get('Pagination');
		$this->model = $this->getModel('dashboards');

//		/SpeventsHelper::___($this->items);

		SpeventsHelper::addSubmenu('dashboards');


		if (count($errors = $this->get('Errors')))
		{
			JError::raiseError(500,implode('<br>', $errors));
			return false;
		}

        JHtmlSidebar::setAction('index.php?option=com_spevents&view=dashboards');
        
        $this->sidebar = JHtmlSidebar::render();
        JToolbarHelper::title(JText::_("COM_SPEVENTS_SUBMENU_DASHBOARD"));

        $this->categories = $this->model->calculateCategories();
        $this->events = $this->model->calculateEvents();
        $this->speakers = $this->model->calculateSpeakers();
        $this->speakerList = $this->model->getSpeakers();

        //EH::___($this->items, false);

		return parent::display($tpl);
	}

}