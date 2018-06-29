<?php
/**
* @package com_spmedical
* @author JoomShaper http://www.joomshaper.com
* @copyright Copyright (c) 2010 - 2018 JoomShaper
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/

// No Direct Access
defined ('_JEXEC') or die('Restricted Access');

class SpmedicalHelper {

	public static function getItemid($view = 'specialists') {
		$db = JFactory::getDbo();

		$query = $db->getQuery(true);
		$query->select($db->quoteName(array('id')));
		$query->from($db->quoteName('#__menu'));
		$query->where($db->quoteName('link') . ' LIKE '. $db->quote('%option=com_spmedical&view='. $view .'%'));
		$query->where($db->quoteName('published') . ' = '. $db->quote('1'));
		$db->setQuery($query);
		$result = $db->loadResult();

		if($result) {
			return '&Itemid=' . $result;
		}

		return;
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
		$doc->addCustomTag('<meta property="og:title" content="' . $title . '" />');

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
			$doc->addCustomTag('<meta property="og:description" content="'. $metadesc .'" />');
		} else {
			if ($menu) {
				if ($menu->params->get('menu-meta_description')) {
					$metadesc = $menu->params->get('menu-meta_description');
					$doc->setDescription($menu->params->get('menu-meta_description'));
					$doc->addCustomTag('<meta property="og:description" content="'. $metadesc .'" />');
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

		$doc->addCustomTag('<meta property="og:type" content="website" />');
		$doc->addCustomTag('<link rel="canonical" href="'.JURI::current().'" />');
		$doc->addCustomTag('<meta property="og:url" content="'.JURI::current().'" />');

		if (isset($meta['image']) && $meta['image']) {
			$doc->addCustomTag('<meta property="og:image" content="'. $meta['image'] .'" />');
			$doc->addCustomTag('<meta property="og:image:width" content="600" />');
			$doc->addCustomTag('<meta property="og:image:height" content="315" />');
		}
	}

	// Get departments
	public static function getDepartments($short = false) {

		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		// Order it by the ordering field.
		if($short){
			$query->select($db->quoteName(array('id', 'title', 'alias')));
		} else {
			$query->select($db->quoteName(array('id', 'title', 'alias', 'description' , 'image', 'treatments', 'investigations', 'others_services')));
		}
		$query->from($db->quoteName('#__spmedical_departments'));
		$query->where($db->quoteName('published')." = 1");
		$query->order('ordering DESC');
		$db->setQuery($query);

		$results = $db->loadObjectList();
		foreach ($results as $result) {
			$result->url = JRoute::_('index.php?option=com_spmedical&view=department&id='.$result->id.':'.$result->alias . SpmedicalHelper::getItemid('departments'));
		}

		return $results;
	}

	// Get Specialists
	public static function getSpecialists($short = false) {
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		// Order it by the ordering field.
		if($short){
			$query->select($db->quoteName(array('id', 'title', 'alias')));
		} else {
			$query->select('*');
		}
		$query->from($db->quoteName('#__spmedical_specialists'));
		$query->where($db->quoteName('published')." = 1");
		$query->order('ordering DESC');
		$db->setQuery($query);
		
		$results = $db->loadObjectList();
		foreach ($results as $result) {
			$result->url = JRoute::_('index.php?option=com_spmedical&view=department&id='.$result->id.':'.$result->alias . SpmedicalHelper::getItemid('departments'));
		}

		return $results;
	}

	// Get Specialist from all specialists
	public static function getSpecialities() {
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		// Order it by the ordering field.
		$query->select($db->quoteName(array('specialitist_on')));
		$query->from($db->quoteName('#__spmedical_specialists'));
		$query->where($db->quoteName('published')." = 1");
		$query->order('ordering DESC');
		$db->setQuery($query);
		$results = $db->loadObjectList();

		$marge_specialities = implode(', ', array_map(function ($item) {
			return $item->specialitist_on;
		}, $results));

		$explode_specialities = explode(', ' , $marge_specialities);

		$specialities = array();
		foreach($explode_specialities as $speciality){
			$hash = str_replace(array(' ', '.'), array('-', ''), strtolower($speciality) );
			$specialities[$hash] = $speciality;
		}

		return $specialities;
	}

	//check json validation
	public static function isJson($string) {
		json_decode($string);
		return (json_last_error() == JSON_ERROR_NONE);
	}

	// Generate Currency
	public static function generateCurrency($amt = 0){

		//Joomla Component Helper & Get LMS Params
		jimport('joomla.application.component.helper');
		$params = JComponentHelper::getParams('com_spmedical');
		//Get Currency
		$currency = explode(':', $params->get('currency', 'USD:$'));
		//$currency =  $currency[1];
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
		
		if ($currency[0] == 'EUR' || $currency[0] == 'RUB' || $currency[0] == 'CZK' || $currency[0] == 'HUF' || $currency[0] == 'PLN') {
			setlocale(LC_MONETARY, $lancode);
			if (function_exists('money_format')) {
				setlocale(LC_MONETARY, $lancode);
				$result = money_format( '%!n ' . $currency[1], $amt);
			} else {
				setlocale(LC_MONETARY, $lancode);
				$result = self::money_format( '%!n ' . $currency[1], $amt);
			}
		} else {
			setlocale(LC_MONETARY, $lancode);
			if (function_exists('money_format')) {
				setlocale(LC_MONETARY, $lancode);
				$result = money_format( $currency[1] . '%!n', $amt);
			} else {
				setlocale(LC_MONETARY, $lancode);
				$result = self::money_format( $currency[1] . '%!n', $amt);
			}
		}

		return $result;
	}

	private static function money_format($format, $number){
		$regex  = '/%((?:[\^!\-]|\+|\(|\=.)*)([0-9]+)?'.
		'(?:#([0-9]+))?(?:\.([0-9]+))?([in%])/';
		if (setlocale(LC_MONETARY, 0) == 'C') {
			setlocale(LC_MONETARY, '');
		}
		$locale = localeconv();
		preg_match_all($regex, $format, $matches, PREG_SET_ORDER);
		foreach ($matches as $fmatch) {
			$value = floatval($number);
			$flags = array(
				'fillchar'  => preg_match('/\=(.)/', $fmatch[1], $match) ?
				$match[1] : ' ',
				'nogroup'   => preg_match('/\^/', $fmatch[1]) > 0,
				'usesignal' => preg_match('/\+|\(/', $fmatch[1], $match) ?
				$match[0] : '+',
				'nosimbol'  => preg_match('/\!/', $fmatch[1]) > 0,
				'isleft'    => preg_match('/\-/', $fmatch[1]) > 0
			);
			$width      = trim($fmatch[2]) ? (int)$fmatch[2] : 0;
			$left       = trim($fmatch[3]) ? (int)$fmatch[3] : 0;
			$right      = trim($fmatch[4]) ? (int)$fmatch[4] : $locale['int_frac_digits'];
			$conversion = $fmatch[5];

			$positive = true;
			if ($value < 0) {
				$positive = false;
				$value  *= -1;
			}
			$letter = $positive ? 'p' : 'n';

			$prefix = $suffix = $cprefix = $csuffix = $signal = '';

			$signal = $positive ? $locale['positive_sign'] : $locale['negative_sign'];
			switch (true) {
				case $locale["{$letter}_sign_posn"] == 1 && $flags['usesignal'] == '+':
				$prefix = $signal;
				break;
				case $locale["{$letter}_sign_posn"] == 2 && $flags['usesignal'] == '+':
				$suffix = $signal;
				break;
				case $locale["{$letter}_sign_posn"] == 3 && $flags['usesignal'] == '+':
				$cprefix = $signal;
				break;
				case $locale["{$letter}_sign_posn"] == 4 && $flags['usesignal'] == '+':
				$csuffix = $signal;
				break;
				case $flags['usesignal'] == '(':
				case $locale["{$letter}_sign_posn"] == 0:
				$prefix = '(';
				$suffix = ')';
				break;
			}
			if (!$flags['nosimbol']) {
				$currency = $cprefix .
				($conversion == 'i' ? $locale['int_curr_symbol'] : $locale['currency_symbol']) .
				$csuffix;
			} else {
				$currency = '';
			}
			$space  = $locale["{$letter}_sep_by_space"] ? ' ' : '';

			$value = number_format($value, $right, $locale['mon_decimal_point'],
				$flags['nogroup'] ? '' : $locale['mon_thousands_sep']);
			$value = @explode($locale['mon_decimal_point'], $value);

			$n = strlen($prefix) + strlen($currency) + strlen($value[0]);
			if ($left > 0 && $left > $n) {
				$value[0] = str_repeat($flags['fillchar'], $left - $n) . $value[0];
			}
			$value = implode($locale['mon_decimal_point'], $value);
			if ($locale["{$letter}_cs_precedes"]) {
				$value = $prefix . $currency . $space . $value . $suffix;
			} else {
				$value = $prefix . $value . $space . $currency . $suffix;
			}
			if ($width > 0) {
				$value = str_pad($value, $width, $flags['fillchar'], $flags['isleft'] ?
					STR_PAD_RIGHT : STR_PAD_LEFT);
			}

			$format = str_replace($fmatch[0], $value, $format);
		}
		return $format;
	}

}