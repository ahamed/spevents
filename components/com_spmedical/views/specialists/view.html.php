<?php
/**
* @package com_spmedical
* @author JoomShaper http://www.joomshaper.com
* @copyright Copyright (c) 2010 - 2018 JoomShaper
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/

// No Direct Access
defined ('_JEXEC') or die('Restricted Access');

class SpmedicalViewSpecialists extends JViewLegacy{

	protected $items;
	protected $params;
	protected $layout_type;

	function display($tpl = null) {
		// Assign data to the view
		$model = $this->getModel();
		$this->items = $this->get('items');
		$this->pagination	= $this->get('Pagination');

		$doc = JFactory::getDocument();
		$app = JFactory::getApplication();
		$this->params = $app->getParams();
		$menus = JFactory::getApplication()->getMenu();
		$menu = $menus->getActive();
		$layout = $this->params->get('layout_type', 'default');

		//$doc->addScriptdeclaration('var spmedical_url="' . JURI::base() . 'index.php?option=com_spmedical";');

		$input          = JFactory::getApplication()->input;
		$searching    	= $input->get('searching', NULL, 'STRING');
		
		$this->layout_type = str_replace('_', '-', $layout);
		$this->setLayout($this->layout_type);
		
		// Check for errors.
		if (count($errors = $this->get('Errors'))) {
			JLog::add(implode('<br />', $errors), JLog::WARNING, 'jerror');
			return false;
		}

		// Load Lessons model
		jimport('joomla.application.component.model');
		JModelLegacy::addIncludePath(JPATH_SITE.'/components/com_spmedical/models');

		// Load Schedules model
		$departments_model = JModelLegacy::getInstance( 'Departments', 'SpmedicalModel' );
		// Get image thumb
		$this->thumb_size = strtolower($this->params->get('specialist_thumbnail', '263X357'));

		// Get Specialist's specialities
		$this->specialities = SpmedicalHelper::getSpecialities();;
		// get departments
		$this->departments = SpmedicalHelper::getDepartments(true);
		// ger specialists
		$this->specialists = SpmedicalHelper::getSpecialists(true);

		foreach ($this->items as $this->item) {
			if ($this->item->socials) {
				$this->item->socials = json_decode($this->item->socials);
			}
			if ($this->item->visiting_times) {
				$this->item->visiting_times = json_decode($this->item->visiting_times);
			}
			$this->item->url = JRoute::_('index.php?option=com_spmedical&view=specialist&id='.$this->item->id.':'.$this->item->alias . SpmedicalHelper::getItemid('specialists'));

			$this->item->appointment_url = JRoute::_('index.php?option=com_spmedical&view=appointments&specialistid='.$this->item->id . SpmedicalHelper::getItemid('appointments'));

			// image thumb size
			$filename = basename($this->item->image);
			$path = JPATH_BASE .'/'. dirname($this->item->image) . '/thumbs/' . JFile::stripExt($filename) . '_' . $this->thumb_size . '.' . JFile::getExt($filename);
			$src = JURI::base(true) . '/' . dirname($this->item->image) . '/thumbs/' . JFile::stripExt($filename) . '_' . $this->thumb_size . '.' . JFile::getExt($filename);
			
			if(JFile::exists($path)) {
				$this->item->thumb = $src;
			} else {
				$this->item->thumb = $this->item->image;	
			}

		}

		//Generate Item Meta
        SpmedicalHelper::itemMeta();
		parent::display($tpl);
	}

}
