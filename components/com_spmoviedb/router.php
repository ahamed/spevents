<?php
/**
 * @package     SP Movie Databse
 *
 * @copyright   Copyright (C) 2010 - 2016 JoomShaper. All rights reserved.
 * @license     GNU General Public License version 2 or later.
 */

defined('_JEXEC') or die('Restricted Access');

function SpmoviedbBuildRoute(&$query) {
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
	if ($menuItemGiven && isset($menuItem) && $menuItem->component != 'com_spmoviedb') {
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

		// Movies
		if ($view == 'movies') {

			if(isset($query['alphaindex']) && $query['alphaindex']) {
				$segments[] = 'alphaindex';
				$segments[] = $query['alphaindex'];
				unset($query['alphaindex']);
			}

			if(isset($query['yearindex']) && $query['yearindex']) {
				$segments[] = 'yearindex';
				$segments[] = $query['yearindex'];
				unset($query['yearindex']);
			}

			unset($query['view']);
		}

		// Celebrities
		if ($view == 'celebrities') {

			if(isset($query['alphaindex']) && $query['alphaindex']) {
				$segments[] = 'alphaindex';
				$segments[] = $query['alphaindex'];
				unset($query['alphaindex']);
			}

			unset($query['view']);
		}

		return $segments;
	}

	// Single View
	if (($view == 'movie') || ($view == 'celebrity')) {
		
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


function SpmoviedbParseRoute($segments) {

	$app 		= JFactory::getApplication();
	$menu   	= $app->getMenu();
	$item 		= $menu->getActive();
	$total 		= count($segments);
	$vars 		= array();

	switch ($item->query['view']) {

		case 'movies':

			if($total==4) {
				$vars['view'] 		= 'movies';
				$vars[$segments[0]] = $segments[1]; // Alphaindex
				$vars[$segments[2]] = $segments[3]; // Yearindex
			} elseif ($total==2) {
				$vars['view'] 		= 'movies';
				$vars[$segments[0]] = $segments[1]; // Alpha or Year index
			} else {
				$vars['view'] 	= 'movie';
				$vars['id'] 	= (int) $segments[0];	
			}
			
			break;

		case 'celebrities':

			if ($total==2) {
				$vars['view'] 		= 'celebrities';
				$vars[$segments[0]] = $segments[1]; // Alphaindex
			} else {
				$vars['view'] 	= 'celebrity';
				$vars['id'] 	= (int) $segments[0];	
			}

			break;	
		
		default:
			$vars['view'] 	= 'movie';
			$vars['id'] 	= (int) $segments[0];
			break;
	}

	return $vars;
}