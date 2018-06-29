<?php
/**
* @package com_spmedical
* @author JoomShaper http://www.joomshaper.com
* @copyright Copyright (c) 2010 - 2018 JoomShaper
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/

// No Direct Access
defined ('_JEXEC') or die('Restricted Access');

class SpmedicalViewAppointments extends JViewLegacy{

	protected $items;
	protected $params;
	protected $layout_type;

	function display($tpl = null) {
		
		// Assign data to the view
		$app = JFactory::getApplication();
		$doc = JFactory::getDocument();
		$input = JFactory::getApplication()->input;
		$this->params = $app->getParams();
		$menus = JFactory::getApplication()->getMenu();
		$menu = $menus->getActive();
		$this->appointment_tac 		= $this->params->get('appointment_tac', 1);
		$this->appointment_tac_text = $this->params->get('appointment_tac_text', '
			I agree with the <a href="#">Terms of Use</a> and <a href="#">Privacy Policy</a> and I declare that I have read the information that is required in accordance with <a href="http://eur-lex.europa.eu/legal-content/EN/TXT/?uri=uriserv:OJ.L_.2016.119.01.0001.01.ENG&amp;toc=OJ:L:2016:119:TOC" target="_blank">Article 13 of GDPR.</a>
		');
		
		if($menu) {
			//$this->params->merge($menu->params);
		}

		$doc->addScriptdeclaration('var spmedical_url="' . JURI::base() . 'index.php?option=com_spmedical";');

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
		$model = JModelLegacy::getInstance( 'Appointments', 'SpmedicalModel' );
		//Show Captcha or not
		$this->captcha = $this->params->get('appointment_captcha', '');

		// get Specialists
		$this->specialists = SpmedicalHelper::getSpecialists(true);

		parent::display($tpl);
	}

}
