<?php
/**
* @package com_spmedical
* @author JoomShaper http://www.joomshaper.com
* @copyright Copyright (c) 2010 - 2018 JoomShaper
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/

// No Direct Access
defined ('_JEXEC') or die('Restricted Access');

class SpmedicalViewSpecialist extends JViewLegacy{
	
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
		jimport('joomla.application.component.helper');
		$this->params = JComponentHelper::getParams('com_spmedical');

		// Load Lessons model
		jimport('joomla.application.component.model');
		JModelLegacy::addIncludePath(JPATH_SITE.'/components/com_spmedical/models');

		// Check for errors.
		if (count($errors = $this->get('Errors'))) {
			JError::raiseWarning(500, implode("\n", $errors));
			return false;
		}

		// Load courses & lesson Model
		$model 		   = JModelLegacy::getInstance( 'Doctors', 'SpmedicalModel' );

		// Get image thumb
		$this->user = JFactory::getUser();
		$medicalparams 	= JComponentHelper::getParams('com_spmedical');
		// Get image thumb
		$this->thumb_size = strtolower($this->params->get('specialist_thumbnail', '263X357'));
		
		//Generate Item Meta
        $itemMeta               = array();
        $itemMeta['title']      = $this->item->title;
        $cleanText              = $this->item->description;
        $itemMeta['metadesc']   = JHtml::_('string.truncate', JFilterOutput::cleanText($cleanText), 155);
        if ($this->item->image) {
			// image thumb size
			$filename = basename($this->item->image);
			$path = JPATH_BASE .'/'. dirname($this->item->image) . '/thumbs/' . JFile::stripExt($filename) . '_' . $this->thumb_size . '.' . JFile::getExt($filename);
			$src = JURI::base(true) . '/' . dirname($this->item->image) . '/thumbs/' . JFile::stripExt($filename) . '_' . $this->thumb_size . '.' . JFile::getExt($filename);
			
			if(JFile::exists($path)) {
				$this->item->thumb = $src;
			} else {
				$this->item->thumb = $this->item->image;	
			}
			
        	$itemMeta['image']      = JURI::base() . $this->item->image;
		}
		//socials decode
		if ($this->item->socials) {
			$this->item->socials = json_decode($this->item->socials);
		}
		// visiting time decode
		if ($this->item->visiting_times) {
			$this->item->visiting_times = json_decode($this->item->visiting_times);
		}
		// experiences decode
		if ($this->item->experiences) {
			$this->item->experiences = json_decode($this->item->experiences);
		}

		// awards_honers decode
		if ($this->item->awards_honers) {
			$this->item->awards_honers = json_decode($this->item->awards_honers);
		}

		// educations decode
		if ($this->item->educations) {
			$this->item->educations = json_decode($this->item->educations);
		}

		//appointment URL
		$this->item->appointment_url = JRoute::_('index.php?option=com_spmedical&view=appointments&specialistid='.$this->item->id.':'.$this->item->alias . SpmedicalHelper::getItemid('appointments'));
        
        SpmedicalHelper::itemMeta($itemMeta);
		parent::display($tpl);
	}
	
}