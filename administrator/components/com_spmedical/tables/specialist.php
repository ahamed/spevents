<?php
/**
* @package com_spmedical
* @author JoomShaper http://www.joomshaper.com
* @copyright Copyright (c) 2010 - 2018 JoomShaper
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/

// No Direct Access
defined ('_JEXEC') or die('Restricted Access');

class SpmedicalTableSpecialist extends JTable{

	public function __construct(&$db) {
		parent::__construct('#__spmedical_specialists', 'id', $db);
	}

	public function store($updateNulls = false) {

		$date = JFactory::getDate();
		$user = JFactory::getUser();

		if ($this->id) {
			$this->modified		= $date->toSql();
			$this->modified_by	= $user->get('id');
		} else {
			if (!(int) $this->created) {
				$this->created = $date->toSql();
			}
			if (empty($this->created_by)) {
				$this->created_by = $user->get('id');
			}
		}

		// Verify that the alias is unique
		$table = JTable::getInstance('Specialist', 'SpmedicalTable');

		if ($table->load(array('alias' => $this->alias)) && ($table->id != $this->id || $this->id == 0)) {
			$this->setError(JText::_('COM_SPMEDICAL_ERROR_UNIQUE_ALIAS'));

			return false;
		}

		return parent::store($updateNulls);
	}

	public function check(){
		// Check for valid name.
		if (trim($this->title) == '') {
			throw new UnexpectedValueException(sprintf('The title is empty'));
		}

		if (empty($this->alias)) {
			$this->alias = $this->title;
		}

		$this->alias = JApplicationHelper::stringURLSafe($this->alias, $this->language);

		if (trim(str_replace('-', '', $this->alias)) == '') {
			$this->alias = JFactory::getDate()->format('Y-m-d-H-i-s');
		}

		//educations
		if (is_array($this->educations)){
			if (!empty($this->educations)){
				$this->educations = json_encode($this->educations);
			}
		}
		if (is_null($this->educations) || empty($this->educations)){
			$this->educations = '';
		}

		//experiences
		if (is_array($this->experiences)){
			if (!empty($this->experiences)){
				$this->experiences = json_encode($this->experiences);
			}
		}
		if (is_null($this->experiences) || empty($this->experiences)){
			$this->experiences = '';
		}

		//awards_honers
		if (is_array($this->awards_honers)){
			if (!empty($this->awards_honers)){
				$this->awards_honers = json_encode($this->awards_honers);
			}
		}
		if (is_null($this->awards_honers) || empty($this->awards_honers)){
			$this->awards_honers = '';
		}

		//visiting_times
		if (is_array($this->visiting_times)){
			if (!empty($this->visiting_times)){
				$this->visiting_times = json_encode($this->visiting_times);
			}
		}
		if (is_null($this->visiting_times) || empty($this->visiting_times)){
			$this->visiting_times = '';
		}

		//socials
		if (is_array($this->socials)){
			if (!empty($this->socials)){
				$this->socials = json_encode($this->socials);
			}
		}
		if (is_null($this->socials) || empty($this->socials)){
			$this->socials = '';
		}

		//Generate Thumbnails
		if($this->image) {
			jimport('joomla.application.component.helper');
			$params = JComponentHelper::getParams('com_spmedical');
			$thumb = $params->get('specialist_thumbnail', '263X357');

			if(isset($this->image) && $this->image) {
				jimport( 'joomla.filesystem.file' );
				jimport( 'joomla.filesystem.folder' );
				jimport( 'joomla.image.image' );
				$image = JPATH_ROOT . '/' . $this->image;
				$sizes = array($thumb);
				$image = new JImage($image);
				$image->createThumbs($sizes, 5);
			}
		}

		return true;
	}
	
}
