<?php
/**
* @package com_spmedical
* @author JoomShaper http://www.joomshaper.com
* @copyright Copyright (c) 2010 - 2018 JoomShaper
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/

// No Direct Access
defined ('_JEXEC') or die('Restricted Access');

class SpmedicalControllerSpecialists extends JControllerLegacy {

	public function getModel($name = 'form', $prefix = '', $config = array('ignore_request' => true)) {
		$model = parent::getModel($name, $prefix, $config); 
		return $model; 
	}

	public function display($cachable = false, $urlparams = false, $tpl = null){

		$cachable = true;
		if (!is_array($urlparams)) {
			$urlparams = [];
		}
		$additionalParams = array(
			'catid' => 'INT',
			'id' => 'INT',
			'cid' => 'ARRAY',
			'year' => 'INT',
			'month' => 'INT',
			'limit' => 'UINT',
			'limitstart' => 'UINT',
			'showall' => 'INT',
			'return' => 'BASE64',
			'filter' => 'STRING',
			'filter_order' => 'CMD',
			'filter_order_Dir' => 'CMD',
			'filter-search' => 'STRING',
			'print' => 'BOOLEAN',
			'lang' => 'CMD',
			'Itemid' => 'INT');

		$urlparams = array_merge($additionalParams, $urlparams);
		parent::display($cachable, $urlparams, $tpl);
	}

	public function getitems(){

		// Load Lessons model
		jimport('joomla.application.component.model');
		JModelLegacy::addIncludePath(JPATH_SITE.'/components/com_spmedical/models');
		$specialists_model = JModelLegacy::getInstance( 'Specialists', 'SpmedicalModel' );

		// get post value
		$input 		= JFactory::getApplication()->input;
		$type 		= $input->post->get('type', '', 'STRING');
		$query 		= $input->post->get('query', '', 'STRING');

		if($query == '') return;

		if($query){
			$results = $specialists_model->getSearchedData($query, $type);
		}

		$output = array();
		$output['status'] = false;
		$output['type'] = $type;
		$output['content'] = '<ul class="spmedical-search results-list">';
		if (!empty($results)) {
			$output['status'] = true;
			foreach ($results as $result) {
				$output['content'] .= '<li data-specialistid="'. $result->id .'">';
				$output['content'] .= '<a href="javascript:void(0);">';
				$output['content'] .= $result->title;
				$output['content'] .= '</a>';
				$output['content'] .= '</li>';
			}
		} else {
			$output['status'] = true;
			$output['content'] .= '<li class="spmedical-empty">';
			$output['content'] .= JText::_('COM_SPMEDICALSEARCH_NO_ITEM_FOUND');
			$output['content'] .= '</li>';
		}

		$output['content'] .= '</ul>';

		echo json_encode($output);
		die();

		// echo json_encode($output);
		// die();
	}
	
}
