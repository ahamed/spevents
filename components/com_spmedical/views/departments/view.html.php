<?php
/**
* @package com_spmedical
* @author JoomShaper http://www.joomshaper.com
* @copyright Copyright (c) 2010 - 2018 JoomShaper
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/

// No Direct Access
defined ('_JEXEC') or die('Restricted Access');

class SpmedicalViewDepartments extends JViewLegacy{

	protected $items;
	protected $params;
	protected $layout_type;

	function display($tpl = null) {
		// Assign data to the view
		$model = $this->getModel();
		$this->items = $this->get('items');
		$this->pagination	= $this->get('Pagination');

		$app = JFactory::getApplication();
		$this->params = $app->getParams();
		$menus = JFactory::getApplication()->getMenu();
		$this->menu = $menus->getActive();
		
		$this->logo_type = 'icon';
		$this->columns	 = 3;
		if ($this->menu) {
			$menu_params = $this->menu->params;
			$this->logo_type = $menu_params->get('logo_type', 'icon');
			// get column
			$this->columns = $menu_params->get('columns', 3);
		}
		
		$this->layout_type = str_replace('_', '-', $this->params->get('layout_type', 'default'));

		// Check for errors.
		if (count($errors = $this->get('Errors'))) {
			JLog::add(implode('<br />', $errors), JLog::WARNING, 'jerror');
			return false;
		}

		foreach ($this->items as $this->item) {
			$this->item->url = JRoute::_('index.php?option=com_spmedical&view=department&id='.$this->item->id.':'.$this->item->alias . SpmedicalHelper::getItemid('departments'));
			
		}

		//Generate Item Meta
        SpmedicalHelper::itemMeta();
		parent::display($tpl);
	}

}
