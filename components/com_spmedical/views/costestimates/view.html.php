<?php
/**
* @package com_spmedical
* @author JoomShaper http://www.joomshaper.com
* @copyright Copyright (c) 2010 - 2018 JoomShaper
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/

// No Direct Access
defined ('_JEXEC') or die('Restricted Access');

class SpmedicalViewCostestimates extends JViewLegacy{

	protected $items;
	protected $params;
	protected $layout_type;

	function display($tpl = null) {
		
		// Assign data to the view
		$app = JFactory::getApplication();
		$input = JFactory::getApplication()->input;
		$this->params = $app->getParams();
		$menus = JFactory::getApplication()->getMenu();
		$menu = $menus->getActive();
		$this->department_id   = $input->get('deptid', '', 'INT');
		
		if($menu) {
			//$this->params->merge($menu->params);
		}

		//Get Currency
		$this->currency = explode(':', $this->params->get('currency', 'USD:$'));

		$this->layout_type = str_replace('_', '-', $this->params->get('layout_type', 'default'));
		// Check for errors.
		if ($errors = $this->get('Errors') && count($errors = $this->get('Errors'))) {
			JLog::add(implode('<br />', $errors), JLog::WARNING, 'jerror');

			return false;
		}
		
		// import models
		jimport('joomla.application.component.model');
		JModelLegacy::addIncludePath(JPATH_SITE.'/components/com_spmedical/models');

		// Load Costestimates model
		$model = JModelLegacy::getInstance( 'Costestimates', 'SpmedicalModel' );
		$departments = $model->getDepartmentServieces();

		// load the services which have data
		$load_services = array();
		foreach ($departments as $department) {
			if ( $department->treatments || $department->investigations || $department->others_services) {
				
				if($department->treatments){
					$department->treatments 	= json_decode($department->treatments);
					$hastreatments = array();
					foreach ($department->treatments as $treatment) {
						if($treatment->price){
							$hastreatments [] = $treatment;
						}
					}
					$department->treatments = $hastreatments;
				}

				if ($department->investigations) {
					$department->investigations 	= json_decode($department->investigations);
					$hasinvestigations = array();
					foreach ($department->investigations as $investigation) {
						if($investigation->price){
							$hasinvestigations [] = $investigation;
						}
					}
					$department->investigations = $hasinvestigations;
				}
				if ($department->others_services) {
					$department->others_services 	= json_decode($department->others_services);
					$hasothers = array();
					foreach ($department->others_services as $others_service) {
						if($others_service->price){
							$hasothers [] = $others_service;
						}
					}
					$department->others_services = $hasothers;
				}
				$load_services[] = $department;
			}
		}

		// load the services with have price
		$this->has_services = array ();
		foreach ($load_services as $key => $load_service) {
			if ( $load_service->treatments || $load_service->investigations || $load_service->others_services) {
				$this->has_services[] = $load_service;
			}
		}

		parent::display($tpl);
	}

}
