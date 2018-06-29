<?php
/**
* @package com_spmedical
* @subpackage  mod_spmedicalsesearch
*
* @author JoomShaper http://www.joomshaper.com
* @copyright Copyright (c) 2010 - 2018 JoomShaper
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/

// No Direct Access
defined ('_JEXEC') or die('Resticted Aceess');

//helper & model
$com_helper 		= JPATH_BASE . '/components/com_spmedical/helpers/helper.php';
$com_specialists_model = JPATH_BASE . '/components/com_spmedical/models/specialists.php';
// Include the helper.
require_once __DIR__ . '/helper.php';

class modSpmedicalsearchHelper {

	public static function getAjax(){

		// Load Lessons model
		jimport('joomla.application.component.model');
		JModelLegacy::addIncludePath(JPATH_SITE.'/components/com_spmedical/models');
		$specialists_model = JModelLegacy::getInstance( 'Specialists', 'SpmedicalModel' );

		$input  = JFactory::getApplication()->input;
		//$input 	= $input->get('data', '', 'RAW');
		$data 	= $input->get('data', '', 'RAW');
		$type 	= ($data['type']) ? $data['type'] : 'specialists';
		$query 	= ($data['query']) ? $data['query'] : '';
		//$query 	= $data['query'];

		if($query == '') return;

		if($query){
			$results = $specialists_model->getSearchedData($query, $type);
		}

		$output = array();
		$output['type'] = $type;
		$output['content'] = '<ul class="spmedical-search results-list">';
		if (!empty($results)) {
			foreach ($results as $result) {
				$output['content'] .= '<li>';
				$output['content'] .= '<a href="javascript:void(0);">';
				$output['content'] .= $result->title;
				$output['content'] .= '</a>';
				$output['content'] .= '</li>';
			}
		}else{
			$output['content'] .= '<li class="spmedical-empty">';
			$output['content'] .= JText::_('MOD_SPMEDICALSEARCH_NO_ITEM_FOUND');
			$output['content'] .= '</li>';
		}

		$output['content'] .= '</ul>';

		return json_encode($output);
	}

}
