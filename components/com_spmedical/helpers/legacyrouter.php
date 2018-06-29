<?php
/**
* @package com_spmedical
* @author JoomShaper http://www.joomshaper.com
* @copyright Copyright (c) 2010 - 2018 JoomShaper
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/

// No Direct Access
defined ('_JEXEC') or die('Restricted Access');

/**
 * Legacy routing rules class from com_content
 *
 * @since       3.6
 * @deprecated  4.0
 */
class SpmedicalRouterRulesLegacy implements JComponentRouterRulesInterface {

	/**
	 * Constructor for this legacy router
	 *
	 * @param   JComponentRouterView  $router  The router this rule belongs to
	 *
	 * @since       3.6
	 * @deprecated  4.0
	 */
	public function __construct($router) {
		$this->router = $router;
	}

	/**
	 * Preprocess the route for the com_content component
	 *
	 * @param   array  &$query  An array of URL arguments
	 *
	 * @return  void
	 *
	 * @since       3.6
	 * @deprecated  4.0
	 */
	public function preprocess(&$query) {

	}

	/**
	 * Build the route for the com_content component
	 *
	 * @param   array  &$query     An array of URL arguments
	 * @param   array  &$segments  The URL arguments to use to assemble the subsequent URL.
	 *
	 * @return  void
	 *
	 * @since       3.6
	 * @deprecated  4.0
	 */
	public function build(&$query, &$segments) {
		$segments = array();
		$app		= JFactory::getApplication();
		$menu		= $app->getMenu();

		// We need a menu item.  Either the one specified in the query, or the current active one if none specified
		if (empty($query['Itemid'])) {
			$menuItem = $menu->getActive();
			$menuItemGiven = false;
		} else {
			$menuItem = $menu->getItem($query['Itemid']);
			$menuItemGiven = true;
		}

		// Check again
		if ($menuItemGiven && isset($menuItem) && $menuItem->component != 'com_spmedical') {
			$menuItemGiven = false;
			unset($query['Itemid']);
			unset($query['view']);
		}

		if (isset($query['view'])) {
			$view = $query['view'];
		} else {
			// We need to have a view in the query or it is an invalid URL
			return $segments;
		}

		// Are we dealing with an article or category that is attached to a menu item?
		if (($menuItem instanceof stdClass)
				&& $menuItem->query['view'] == $query['view']
				&& isset($query['id'])
				&& $menuItem->query['id'] == (int) $query['id']) {

				unset($query['view']);
				unset($query['id']);

				return $segments;
		}

		//Replace with menu
		$mview = (empty($menuItem->query['view'])) ? null : $menuItem->query['view'];

		//Single view
		if ( $view == 'appointments' || $view == 'costestimates' || $view == 'schedules' ) {
			if($mview != $view) {
				$segments[] = $view;
			}
			unset($query['view']);
		}

		//
		if ($view == 'specialist' || $view == 'department') {
			
			$segments[] = $view;
			
			//Remove ID
			$id_slug = explode(':', $query['id']);
			if(count($id_slug)>1) {
				$segments[] = $id_slug[1];
			} else {
				$segments[] = $query['id'];
			}

			unset($query['view']);
			unset($query['id']);
		}

		$total = count($segments);

		for ($i = 0; $i < $total; $i++) {
			$segments[$i] = str_replace(':', '-', $segments[$i]);
		}

		return $segments;

	}

	/**
	 * Parse the segments of a URL.
	 *
	 * @param   array  &$segments  The segments of the URL to parse.
	 * @param   array  &$vars      The URL attributes to be used by the application.
	 *
	 * @return  void
	 *
	 * @since       3.6
	 * @deprecated  4.0
	 */
	public function parse(&$segments, &$vars) {
		
		$total = count($segments);
		$vars = array();

		for ($i = 0; $i < $total; $i++) {
			$segments[$i] = preg_replace('/-/', ':', $segments[$i], 1);
		}

		// Get the active menu item.
		$app	= JFactory::getApplication();
		$menu	= $app->getMenu();
		$item	= $menu->getActive();

		// Count route segments
		$count = count($segments);

		if($count>1) {
			$vars['view']	= $view = $segments[0];

			switch ($vars['view']) {

				case 'specialist':
					$table = 'spmedical_specialists';
					break;

				case 'department':
					$table = 'spmedical_departments';
					break;
		
			}

			//Retrive ID
			$slug = preg_replace('/:/', '-', $segments[1]);

			$db = JFactory::getDbo();
			$dbQuery = $db->getQuery(true)
				->select( $db->quotename( 'id' ) )
				->from('#__' . $table)
				->where( $db->quotename('alias') . '=' . $db->quote($slug));
			$db->setQuery($dbQuery);
			$id = $db->loadResult();

			$vars['id']		= $id;
			return $vars;
		} else {
			$vars['view']	= $view = $segments[0];
		}

		return $vars;

		
	}
}
