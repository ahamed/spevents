<?php
/**
* @package com_spmedical
* @author JoomShaper http://www.joomshaper.com
* @copyright Copyright (c) 2010 - 2018 JoomShaper
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/

// No Direct Access
defined ('_JEXEC') or die('Restricted Access');

class SpmedicalViewDepartment extends JViewLegacy{
	
	protected $item;
	protected $params;

	function display($tpl = null) {
		// Assign data to the view
		$this->item = $this->get('Item');
		$app = JFactory::getApplication();
		$this->params = $app->getParams();
		$menus = JFactory::getApplication()->getMenu();
		$menu = $menus->getActive();

		//get Component Params
		$this->params = JComponentHelper::getParams('com_spmedical');

		// Load Lessons model
		jimport('joomla.application.component.model');
		JModelLegacy::addIncludePath(JPATH_SITE.'/components/com_spmedical/models');

		// Check for errors.
		if (count($errors = $this->get('Errors'))) {
			JError::raiseWarning(500, implode("\n", $errors));
			return false;
		}

		// Load models
		$model 		   = JModelLegacy::getInstance( 'Departments', 'SpmedicalModel' );
		$specialists_model = JModelLegacy::getInstance( 'Specialists', 'SpmedicalModel' );

		// Get image thumb
		$medicalparams 	= JComponentHelper::getParams('com_spmedical');
		$this->thumb_size = strtolower($medicalparams->get('department_thumbnail', '480X300'));
		
		$this->specialists = $specialists_model->getSpecialistsByDepartentId($this->item->id);
		
		if($this->item->treatments){
			$this->item->treatments 	= json_decode($this->item->treatments); 
		}
		if ($this->item->investigations) {
			$this->item->investigations 	= json_decode($this->item->investigations); 
		}
		if ($this->item->others_services) {
			$this->item->others_services 	= json_decode($this->item->others_services); 
		}

		//costestimate URL
		$this->item->costestimate_url = JRoute::_('index.php?option=com_spmedical&view=costestimates&deptid='.$this->item->id . SpmedicalHelper::getItemid('costestimates'));
		
		//Generate Item Meta
        $itemMeta               = array();
        $itemMeta['title']      = $this->item->title;
        $cleanText              = $this->item->description;
        $itemMeta['metadesc']   = JHtml::_('string.truncate', JFilterOutput::cleanText($cleanText), 155);
        if ($this->item->image) {
        	$itemMeta['image']      = JURI::base() . $this->item->image;
        }
        
        SpmedicalHelper::itemMeta($itemMeta);
		parent::display($tpl);
	}
	
}
