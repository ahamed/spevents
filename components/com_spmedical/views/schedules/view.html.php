<?php
/**
* @package com_spmedical
* @author JoomShaper http://www.joomshaper.com
* @copyright Copyright (c) 2010 - 2018 JoomShaper
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/

// No Direct Access
defined ('_JEXEC') or die('Restricted Access');

class SpmedicalViewSchedules extends JViewLegacy{

	protected $items;
	protected $params;
	protected $layout_type;

	function display($tpl = null) {
		
		// Assign data to the view
		$app = JFactory::getApplication();
		$this->params = $app->getParams();
		$menus = JFactory::getApplication()->getMenu();
		$menu = $menus->getActive();

		if($menu) {
			//$this->params->merge($menu->params);
		}

		$this->layout_type = str_replace('_', '-', $this->params->get('layout_type', 'default'));
		// Check for errors.
		if ($errors = $this->get('Errors') && count($errors = $this->get('Errors'))) {
			JLog::add(implode('<br />', $errors), JLog::WARNING, 'jerror');
			return false;
		}

		// Load Lessons model
		jimport('joomla.application.component.model');
		JModelLegacy::addIncludePath(JPATH_SITE.'/components/com_spmedical/models');

		// Load Schedules model
		$model = JModelLegacy::getInstance( 'Schedules', 'SpmedicalModel' );
		
		$this->schedules = $model->getSpecialistsSchedules();
		
		foreach ($this->schedules as $this->schedule) {
			if($this->schedule->visiting_times){
				$this->schedule->visiting_times = json_decode($this->schedule->visiting_times);

				$this->schedule->times = array();
				$this->schedule->days = array();
				foreach ($this->schedule->visiting_times as $key => $visiting_time) {
					$this->schedule->times[] = $visiting_time->visiting_time;
					$this->schedule->days[] = $visiting_time->day;
				}
			}
		}
		
		// Generate uniq times
		$vtimes = self::getUniqTimes($this->schedules);

		$this->schedule_items = array();
		foreach ($vtimes as $vtime) {
			$this->schedule_items[$vtime] = array();
			foreach ($this->schedules as $key => $schedule) {
				if($schedule->times){
					if (in_array($vtime, $schedule->times)) {
						$this->schedule_items[$vtime][] = $schedule;	
					}	
				}		
			}
		}

		parent::display($tpl);
	}

	private static function getUniqTimes($items) {
		$times = array();
		$j = 1;
		foreach ($items as $mkey => $item) {	
			foreach ($item->visiting_times as $skey => $v_time) {
				$times[$v_time->visiting_time] = $v_time->visiting_time;
				$j ++;
			}
		}
		return $times;
	}

}
