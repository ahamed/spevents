<?php
/**
 * @package     SP Property
 *
 * @copyright   Copyright (C) 2010 - 2016 JoomShaper. All rights reserved.
 * @license     GNU General Public License version 2 or later.
 */

defined('_JEXEC') or die('Restricted Access');

class SppropertyHelper {

	// Common
	public static function getItemid($view = 'properties') {
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select($db->quoteName(array('id')));
		$query->from($db->quoteName('#__menu'));
		$query->where($db->quoteName('link') . ' LIKE '. $db->quote('%option=com_spproperty&view='. $view .'%'));
		$query->where('language in (' . $db->quote(JFactory::getLanguage()->getTag()) . ',' . $db->quote('*') . ')');
		$query->where($db->quoteName('published') . ' = '. $db->quote('1'));
		$db->setQuery($query);
		$result = $db->loadResult();

		if(count($result)) {
			return '&Itemid=' . $result;
		}

		return false;
	}

	// Item Meta
	public static function itemMeta($meta = array()) {
		$config 	= JFactory::getConfig();
		$app 		= JFactory::getApplication();
		$doc 		= JFactory::getDocument();
		$menus   	= $app->getMenu();
		$menu 		= $menus->getActive();
		$title 		= '';

		//Title
		if (isset($meta['title']) && $meta['title']) {
			$title = $meta['title'];
		} else {
			if ($menu) {
				if($menu->params->get('page_title', '')) {
					$title = $menu->params->get('page_title');
				} else {
					$title = $menu->title;
				}
			}
		}

		//Include Site title
		$sitetitle = $title;
		if($config->get('sitename_pagetitles')==2) {
			$sitetitle = $title . ' | ' . $config->get('sitename');
		} elseif ($config->get('sitename_pagetitles')===1) {
			$sitetitle = $config->get('sitename') . ' | ' . $title;
		}

		$doc->setTitle($sitetitle);
		$doc->addCustomTag('<meta content="' . $title . '" property="og:title" />');

		//Keywords
		if (isset($meta['keywords']) && $meta['keywords']) {
			$keywords = $meta['keywords'];
			$doc->setMetadata('keywords', $keywords);
		} else {
			if ($menu) {
				if ($menu->params->get('menu-meta_keywords')) {
					$keywords = $menu->params->get('menu-meta_keywords');
					$doc->setMetadata('keywords', $keywords);
				}
			}
		}

		//Metadescription
		if (isset($meta['metadesc']) && $meta['metadesc']) {
			$metadesc = $meta['metadesc'];
			$doc->setDescription($metadesc);
			$doc->addCustomTag('<meta content="'. $metadesc .'" property="og:description" />');
		} else {
			if ($menu) {
				if ($menu->params->get('menu-meta_description')) {
					$metadesc = $menu->params->get('menu-meta_description');
					$doc->setDescription($menu->params->get('menu-meta_description'));
					$doc->addCustomTag('<meta content="'. $metadesc .'" property="og:description" />');
				}
			}
		}

		//Robots
		if ($menu) {
			if ($menu->params->get('robots'))
			{
				$doc->setMetadata('robots', $menu->params->get('robots'));
			}
		}

		//Open Graph
		foreach ( $doc->_links as $k => $array ) {
			if ( $array['relation'] == 'canonical' ) {
				unset($doc->_links[$k]);
			}
		} // Remove Joomla canonical

		$doc->addCustomTag('<meta content="website" property="og:type"/>');
		$doc->addCustomTag('<link href="'.JURI::current().'" rel="canonical" />');
		$doc->addCustomTag('<meta content="'.JURI::current().'" property="og:url" />');

		if (isset($meta['image']) && $meta['image']) {
			$doc->addCustomTag('<meta content="'. $meta['image'] .'" property="og:image" />');
		}
	}

	// Generate Currency
	public static function generateCurrency($amt = 0){

		//Joomla Component Helper & Get Property Params
		jimport('joomla.application.component.helper');
		$params = JComponentHelper::getParams('com_spproperty');

		//Get Currency
		$currency = explode(':', $params->get('currency', 'USD:$'));

		switch ($currency[0]) {
			case 'USD':
				$lancode = 'en_GB';
				break;

			case 'GBP':
				$lancode = 'en_GB';
				break;

			case 'RUB':
				$lancode = 'ru_RU';
				break;

			case 'BRL':
				$lancode = 'pt_BR';
				break;

			case 'CAD':
				$lancode = 'en_CA';
				break;

			case 'CZK':
				$lancode = 'cs_CZ';
				break;

			case 'DKK':
				$lancode = 'en_DK';
				break;

			case 'EUR':
				$lancode = 'fr_FR';
				break;

			case 'HKD':
				$lancode = 'zh_HK';
				break;

			case 'HUF':
				$lancode = 'hu_HU';
				break;

			case 'ILS':
				$lancode = 'zh_HK';
				break;

			case 'JPY':
				$lancode = 'ja_JP';
				break;

			case 'MXN':
				$lancode = 'es_MX';
				break;

			case 'NOK':
				$lancode = 'nb_NO';
				break;

			case 'NZD':
				$lancode = 'en_GB';
				break;

			case 'PHP':
				$lancode = 'en_PH';
				break;

			case 'PLN':
				$lancode = 'pl_PL';
				break;

			case 'SGD':
				$lancode = 'zh_SG';
				break;

			case 'SEK':
				$lancode = 'sv_SE';
				break;

			case 'CHF':
				$lancode = 'de_LI';
				break;

			case 'TWD':
				$lancode = 'zh_TW';
				break;

			case 'THB':
				$lancode = 'th_TH';
				break;

			case 'TRY':
				$lancode = 'tr_TR';
				break;

			default:
				$lancode = 'en_GB';
				break;
		}

		// $fmt = new NumberFormatter( $lancode, NumberFormatter::CURRENCY );
		// $result = $fmt->formatCurrency($amt, $currency[0]);

		if ($currency[0] == 'EUR' || $currency[0] == 'RUB' || $currency[0] == 'CZK' || $currency[0] == 'HUF' || $currency[0] == 'PLN') {
			setlocale(LC_MONETARY, $lancode);
			//$result = money_format( '%!n ' . $currency[1], $amt);
			$result = number_format($amt ,2) . ' ' . $currency[1];
		} else {
			setlocale(LC_MONETARY, $lancode);
			//$result = money_format( $currency[1] . '%!n', $amt);
			$result = $currency[1] . number_format($amt);
		}


		return $result;
	}
}
