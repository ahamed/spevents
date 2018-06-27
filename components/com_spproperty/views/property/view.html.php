<?php

/**
 * @package     SP Property
 *
 * @copyright   Copyright (C) 2010 - 2016 JoomShaper. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// No Direct Access
defined('_JEXEC') or die('Resticted Aceess');

class SppropertyViewProperty extends FOFViewHtml {

    public function display($tpl = null) {
        // Get model
        $model = $this->getModel();
        // get item
        $this->item = $model->getItem();

        // get component params
        jimport('joomla.application.component.helper');
        $this->cParams          = JComponentHelper::getParams('com_spproperty');
        $gmap_api               = $this->cParams->get('gmap_api');
        $this->recipient        = $this->cParams->get('recipient');
        $this->contact_tac 		= $this->cParams->get('contact_tac', 1);
		$this->contact_tac_text = $this->cParams->get('contact_tac_text', '
			I agree with the <a href="#">Terms of Use</a> and <a href="#">Privacy Policy</a> and I declare that I have read the information that is required in accordance with <a href="http://eur-lex.europa.eu/legal-content/EN/TXT/?uri=uriserv:OJ.L_.2016.119.01.0001.01.ENG&amp;toc=OJ:L:2016:119:TOC" target="_blank">Article 13 of GDPR.</a>
        ');

        // Add Script
        $doc = JFactory::getDocument();
        if ($gmap_api) {
            $doc->addScript('//maps.google.com/maps/api/js?libraries=places&key='. $gmap_api .'');
        } else{
            $doc->addScript('//maps.google.com/maps/api/js?libraries=places');
        }

        $doc->addScript(JURI::root(true) . '/components/com_spproperty/assets/js/owl.carousel.min.js');
        $doc->addScript(JURI::root(true) . '/components/com_spproperty/assets/js/spproperty.js');
        $doc->addScript( JURI::base(true) . '/components/com_spproperty/assets/js/gmap.js');
        $doc->addStylesheet(JURI::root(true) . '/components/com_spproperty/assets/css/owl.carousel.min.css');
        $doc->addStylesheet(JURI::root(true) . '/components/com_spproperty/assets/css/owl.theme.default.min.css');

        //this item url
        $this->item->url      = JRoute::_('index.php?option=com_spproperty&view=property&id=' . $this->item->spproperty_property_id . ':' . $this->item->slug . SppropertyHelper::getItemid('properties'));

        // get category info
        $this->item->cat_info = $model->getCatInfo($this->item->spproperty_category_id);

        //get visitor IP
        $this->visitorip      = isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR'];

        // Map
        $this->map = explode(',', $this->item->map);

        //features
        $this->featureinfos = array();
        foreach ($this->item->features as $key => $feature) {
            $this->featureinfos [$key] = $model->getPfeatures($feature);
        }

        //agent info
        if ($this->item->spproperty_agent_id) {
            $this->item->agent = $model->getAgntInfo($this->item->spproperty_agent_id);
            $this->item->agent->url = JRoute::_('index.php?option=com_spproperty&view=agent&id='. $this->item->agent->spproperty_agent_id .':'. $this->item->agent->slug . SppropertyHelper::getItemid('agents'));
        }
        
        // Gellery
        if (!is_array($this->item->gallery) && !count($this->item->gallery)) {
            $gl_decode = json_decode($this->item->gallery);
            $this->item->galleries = '';
            if (isset($gl_decode)) {
                $photos      = $gl_decode->photo;
                $alt_texts   = $gl_decode->alt_text;

                // gallaries
                $this->item->galleries = array();
                $glkey  = 0;
                foreach ($photos as $id => $photo) {
                    $this->item->galleries[$glkey] = array(
                        'photo'     => $photos[$id],
                        'alt_text'  => $alt_texts[$id],
                    );
                    $glkey ++;
                }
            }
        } else {
            $this->item->galleries = $this->item->gallery;
        }

        if (!is_array($this->item->floor_plans) && !count($this->item->floor_plans)) {
            // floor plans
            $fp_decode = json_decode($this->item->floor_plans);
            $this->item->floor_plans = '';
            if (isset($fp_decode)) {
                $layout_names   = $fp_decode->layout_name;
                $imgs           = $fp_decode->img;
                $texts          = $fp_decode->text;

                // floor plans
                $this->item->floor_plans = array();
                $fpkey  = 0;
                foreach ($imgs as $id => $img) {
                    $this->item->floor_plans[$fpkey] = array(
                        'layout_name'   => $layout_names[$id],
                        'img'           => $imgs[$id],
                        'text'          => $texts[$id],
                    );
                    $fpkey ++;
                }
            }
        }

        //Get Currency
        $this->item->price = SppropertyHelper::generateCurrency($this->item->price);

        if (filter_var($this->item->video, FILTER_VALIDATE_URL)) {
            //video parse
            $video = parse_url($this->item->video);

            switch($video['host']) {
                case 'youtu.be':
                    $id = trim($video['path'],'/');
                    $this->videosrc = '//www.youtube.com/embed/' . $id;
                break;

                case 'www.youtube.com':
                case 'youtube.com':
                    parse_str($video['query'], $query);
                    $id = $query['v'];
                    $this->videosrc = '//www.youtube.com/embed/' . $id;
                break;

                case 'vimeo.com':
                case 'www.vimeo.com':
                    $id = trim($video['path'],'/');
                    $this->videosrc = "//player.vimeo.com/video/{$id}";
            }
        }

        //Generate Item Meta
        $itemMeta               = array();
        $itemMeta['title']      = $this->item->title;
        $cleanText              = $this->item->description;
        $itemMeta['metadesc']   = JHtml::_('string.truncate', JFilterOutput::cleanText($cleanText), 155);
        $itemMeta['image']      = JURI::base() . $this->item->image;
        SppropertyHelper::itemMeta($itemMeta);


        return parent::display($tpl = null);
    }

}
