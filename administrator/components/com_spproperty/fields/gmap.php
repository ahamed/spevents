<?php

/**
 * @package     SP Property
 *
 * @copyright   Copyright (C) 2010 - 2016 JoomShaper. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// No Direct Access
defined ('_JEXEC') or die('Resticted Aceess');

//Joomla Component Helper & Get LMS Params
jimport('joomla.application.component.helper');

class JFormFieldGmap extends JFormField{

	protected $type = 'Gmap';
	
	protected function getInput()
	{
		$required  = $this->required ? ' required aria-required="true"' : '';

		$params = JComponentHelper::getParams('com_spproperty');
		$gmap_api = $params->get('gmap_api');
	
		JHtml::_('jquery.framework');
		$doc = JFactory::getDocument();
		// Load Map js
		$doc = JFactory::getDocument();

		if ($gmap_api) {
			$doc->addScript('//maps.google.com/maps/api/js?sensor=false&libraries=places&key='. $gmap_api .'');
		} else{
			$doc->addScript('//maps.google.com/maps/api/js?sensor=false&libraries=places');
		}

		$doc->addScript( JURI::base(true) . '/components/com_spproperty/assets/js/locationpicker.jquery.js' );

		if ( empty($this->value) ) {
			$this->value = '40.7324319, -73.82480799999996';
		}

		$map = explode( ',', $this->value );

		$doc->addStyleDeclaration('.spproperty-gmap-canvas {
			height: 300px;
			margin-top: 10px;
		}
		.pac-container {
			z-index: 99999;
		}
		');

		return '<input class="addon-input gmap-latlng" type="hidden" name="' . $this->name . '" id="' . $this->id . '" value="' . $this->value . '" '. $required .'>
		<input class="form-control spproperty-gmap-address" type="text" data-latitude="' . trim($map[0]) . '" data-longitude="' . trim($map[1]) . '" autocomplete="off" '. $required .'>';

	}
}
