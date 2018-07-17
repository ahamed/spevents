<?php

defined ('_JEXEC') or die('Resticted Aceess');


jimport('joomla.application.component.helper');

class JFormFieldSpmap extends JFormField{

	protected $type = 'Spmap';

	protected function getInput()
	{
		$required  = $this->required ? ' required aria-required="true"' : '';

		$params = JComponentHelper::getParams('com_spevents');
		$cmap_api = $params->get('cmap_api');

		JHtml::_('jquery.framework');
		// Load Map js
		$doc = JFactory::getDocument();

		if ($cmap_api) {
			$doc->addScript('//maps.google.com/maps/api/js?sensor=false&libraries=places&key='. $cmap_api .'');
		} else{
			$doc->addScript('//maps.google.com/maps/api/js?sensor=false&libraries=places');
		}

		$doc->addScript( JURI::base(true) . '/components/com_spevents/assets/js/locationpicker.jquery.js' );

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
