<?php

/**
 * @package     SP Property
 *
 * @copyright   Copyright (C) 2010 - 2016 JoomShaper. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// No Direct Access
defined('_JEXEC') or die('Resticted Aceess');

class SppropertyViewAgent extends FOFViewHtml {

    public function display($tpl = null) {
        // Get model
        $model = $this->getModel();
        // get item
        $this->item = $model->getItem();
        // get component params
        jimport('joomla.application.component.helper');
        $this->cParams  = JComponentHelper::getParams('com_spproperty');
        $this->contact_tac 		= $this->cParams->get('contact_tac', 1);
		$this->contact_tac_text = $this->cParams->get('contact_tac_text', '
			I agree with the <a href="#">Terms of Use</a> and <a href="#">Privacy Policy</a> and I declare that I have read the information that is required in accordance with <a href="http://eur-lex.europa.eu/legal-content/EN/TXT/?uri=uriserv:OJ.L_.2016.119.01.0001.01.ENG&amp;toc=OJ:L:2016:119:TOC" target="_blank">Article 13 of GDPR.</a>
        ');
        // get columns
        $this->properties_columns  = $this->cParams->get('properties_columns', 2);

        $gmap_api = $this->cParams->get('gmap_api');
        $doc = JFactory::getDocument();
        if ($gmap_api) {
            $doc->addScript('//maps.google.com/maps/api/js?libraries=places&key='. $gmap_api .'');
        } else {
            $doc->addScript('//maps.google.com/maps/api/js?libraries=places');
        }

        $doc->addScript( JURI::base(true) . '/components/com_spproperty/assets/js/gmap_mutiple.js');
        $doc->addScript( JURI::root(true) . '/components/com_spproperty/assets/js/spproperty.js');

        $this->agent_properties = $model->getAgntProperties($this->item->spproperty_agent_id);

        foreach ($this->agent_properties as $this->agent_property) {
            $this->agent_property->price = SppropertyHelper::generateCurrency($this->agent_property->price);
        }

        //Get Currency
        $this->currency = explode(':', $this->cParams->get('currency', 'USD:$'));
        $this->currency = $this->currency[1];

        $this->plocations = array();
        foreach ($this->agent_properties as $key => &$this->agent_property) {
            $this->plocations[$key] ['title']       = htmlspecialchars($this->agent_property->title, ENT_QUOTES);
            $this->plocations[$key] ['location']    = $this->agent_property->map;
        }


        return parent::display($tpl = null);
    }

}
