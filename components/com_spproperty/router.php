<?php
/**
 * @package     SP Property
 *
 * @copyright   Copyright (C) 2010 - 2016 JoomShaper. All rights reserved.
 * @license     GNU General Public License version 2 or later.
 */

defined('_JEXEC') or die('Restricted Access');

function SppropertyBuildRoute(&$query) {
	$app 		= JFactory::getApplication();
	$menu   	= $app->getMenu();

	$segments = array();

	if (empty($query['Itemid'])) {
		$menuItem = $menu->getActive();
		$menuItemGiven = false;
	} else {
		$menuItem = $menu->getItem($query['Itemid']);
		$menuItemGiven = true;
	}

	// Check again
	if ($menuItemGiven && isset($menuItem) && $menuItem->component != 'com_spproperty') {
		$menuItemGiven = false;
		unset($query['Itemid']);
	}

	if (isset($query['view'])) {
		$view = $query['view'];
	} else {
		return $segments;
	}

	if (($menuItem instanceof stdClass) && $menuItem->query['view'] == $query['view']) {

		if (!$menuItemGiven) {
			$segments[] = $view;
		}

		// Properties
		if ($view == 'properties') {

			
			if(isset($query['catid']) && $query['catid']) {
				$segments[] = 'catid';
				$segments[] = $query['catid'];
				unset($query['catid']);
			}

			if(isset($query['keyword']) && $query['keyword']) {
				$segments[] = 'keyword';
				$segments[] = $query['keyword'];
				unset($query['keyword']);
			}

			if(isset($query['city']) && $query['city']) {
				$segments[] = 'city';
				$segments[] = $query['city'];
				unset($query['city']);
			}

			if(isset($query['size']) && $query['size']) {
				$segments[] = 'size';
				$segments[] = $query['size'];
				unset($query['size']);
			}

			unset($query['view']);
		}

		return $segments;
	}

	// Single View
	if (($view == 'property') || ($view == 'agent')) {
		
		if (!$menuItemGiven) {
			$segments[] = $view;
		}

		// Id
		if(isset($query['id']) && $query['id']) {
			$segments[] = str_replace(':', '-', $query['id']);
			unset($query['id']);
		}
		
		unset($query['view']);
	}

	return $segments;
}


function SppropertyParseRoute($segments) {

	$app 		= JFactory::getApplication();
	$menu   	= $app->getMenu();
	$item 		= $menu->getActive();
	$total 		= count($segments);
	$vars 		= array();

	switch ($item->query['view']) {

		case 'properties':

			if($total==4) {
				$vars['view'] 		= 'properties';
				$vars[$segments[0]] = $segments[1]; // cat
				$vars[$segments[2]] = $segments[3]; // keyword
			} elseif ($total==2) {
				$vars['view'] 		= 'properties';
				$vars[$segments[0]] = $segments[1]; // cat or keyword
			} else {
				$vars['view'] 	= 'property';
				$vars['id'] 	= (int) $segments[0];	
			}
			
			break;

		case 'agents':

			if ($total == 2) {
				$vars['view'] 	= 'agents';
			} else {
				$vars['view'] 	= 'agent';
				$vars['id'] 	= (int) $segments[0];
			}

			break;	
		
		default:
			$vars['view'] 	= 'properties';
			$vars['id'] 	= (int) $segments[0];
			break;
	}

	return $vars;
}