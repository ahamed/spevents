<?php
/**
 * @package     SP Movie Databse
 *
 * @copyright   Copyright (C) 2010 - 2016 JoomShaper. All rights reserved.
 * @license     GNU General Public License version 2 or later.
 */

defined('_JEXEC') or die('Restricted Access');

class SpmoviedbHelper {
	
	// Common
	public static function getItemid($view = 'movies') {
		$db = JFactory::getDbo();
		$query = $db->getQuery(true); 
		$query->select($db->quoteName(array('id')));
		$query->from($db->quoteName('#__menu'));
		$query->where($db->quoteName('link') . ' LIKE '. $db->quote('%option=com_spmoviedb&view='. $view .'%'));
		$query->where($db->quoteName('published') . ' = '. $db->quote('1'));
		$db->setQuery($query);
		$result = $db->loadResult();

		if(count($result)) {
			return '&Itemid=' . $result;
		}

		return false;
	}

	// Common
	public static function getSpImage($image_id) {

		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select( array('a.*') );
		$query->from($db->quoteName('#__spmoviedb_media', 'a'));
		$query->where($db->quoteName('a.spmoviedb_medium_id')." = " . $image_id . "");
		$db->setQuery($query);
		$result = $db->loadObject();
		
		return $result;
	}


	public static function timeago($time)
	{
	   $periods = array("SECOND", "MINUTE", "HOUR", "DAY", "WEEK", "MONTH", "YEAR", "DECADE");
	   $lengths = array("60","60","24","7","4.35","12","10");

       $difference     = strtotime(JFactory::getDate('now')) - strtotime($time);
       $tense         = "ago";

	   for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {
	       $difference /= $lengths[$j];
	   }

	   $difference = round($difference);

	   if($difference == 0) $difference = 1;

	   if($difference != 1) {
	       $periods[$j] .= "S";
	   }

	   return $difference . ' ' . JText::_('COM_SPMOVIEDB_TIMEAGO_' . $periods[$j]) . ' ' . JText::_('COM_SPMOVIEDB_TIMEAGO_AGO');
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
}
