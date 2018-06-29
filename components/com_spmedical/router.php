<?php
/**
* @package com_spmedical
* @author JoomShaper http://www.joomshaper.com
* @copyright Copyright (c) 2010 - 2018 JoomShaper
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/

// No Direct Access
defined ('_JEXEC') or die('Restricted Access');

class SpmedicalRouter extends JComponentRouterView {

	protected $noIDs = false;

	public function __construct($app = null, $menu = null){

		$params = JComponentHelper::getParams('com_spmedical');
		$this->noIDs = (bool) $params->get('sef_ids', 1);

		// single view without menu
		$this->registerView(new JComponentRouterViewconfiguration('appointments'));
		$this->registerView(new JComponentRouterViewconfiguration('costestimates'));
		$this->registerView(new JComponentRouterViewconfiguration('schedules'));

		// course categories
		$departments = new JComponentRouterViewconfiguration('departments');
		$this->registerView($departments);
		$department = new JComponentRouterViewconfiguration('department');
		$department->setKey('id')->setParent($departments);
		$this->registerView($department);

		// Specialist
		$specialists = new JComponentRouterViewconfiguration('specialists');
		$this->registerView($specialists);
		$specialist = new JComponentRouterViewconfiguration('specialist');
		$specialist->setKey('id')->setParent($specialists);
		$this->registerView($specialist);

		// generate rules
		parent::__construct($app, $menu);	
		$this->attachRule(new JComponentRouterRulesNomenu($this));
		if ($params->get('sef_advanced', 0)) {
			$this->attachRule(new JComponentRouterRulesMenu($this));
			$this->attachRule(new JComponentRouterRulesStandard($this));
		} else {
			JLoader::register('SpmedicalRouterRulesLegacy', __DIR__ . '/helpers/legacyrouter.php');
			$this->attachRule(new SpmedicalRouterRulesLegacy($this));
		}

	}

	// Department
	public function getDepartmentSegment($id, $query) {
		if (!strpos($id, ':')) {
			$db = JFactory::getDbo();
			$dbquery = $db->getQuery(true);
			$dbquery->select($dbquery->qn('alias'))
			->from($dbquery->qn('#__spmedical_departments'))
			->where('id = ' . $dbquery->q($id));
			$db->setQuery($dbquery);

			$id .= ':' . $db->loadResult();
		}

		if ($this->noIDs) {
			list($void, $segment) = explode(':', $id, 2);

			return array($void => $segment);
		}
		return array((int) $id => $id);
	}
	public function getDepartmentId($segment, $query) {

		if ($this->noIDs) {
			$db = JFactory::getDbo();
			$dbquery = $db->getQuery(true);
			$dbquery->select($dbquery->qn('id'))
				->from($dbquery->qn('#__spmedical_departments'))
				->where('alias = ' . $dbquery->q($segment));
			$db->setQuery($dbquery);
			return (int) $db->loadResult();
		}
		return (int) $segment;
	}

	// specialist
	public function getSpecialistSegment($id, $query) {
		if (!strpos($id, ':')) {
			$db = JFactory::getDbo();
			$dbquery = $db->getQuery(true);
			$dbquery->select($dbquery->qn('alias'))
			->from($dbquery->qn('#__spmedical_specialists'))
			->where('id = ' . $dbquery->q($id));
			$db->setQuery($dbquery);

			$id .= ':' . $db->loadResult();
		}

		if ($this->noIDs) {
			list($void, $segment) = explode(':', $id, 2);

			return array($void => $segment);
		}
		return array((int) $id => $id);
	}
	public function getSpecialistId($segment, $query) {

		if ($this->noIDs) {
			$db = JFactory::getDbo();
			$dbquery = $db->getQuery(true);
			$dbquery->select($dbquery->qn('id'))
				->from($dbquery->qn('#__spmedical_specialists'))
				->where('alias = ' . $dbquery->q($segment));
			$db->setQuery($dbquery);
			return (int) $db->loadResult();
		}
		return (int) $segment;
	}
}

/**
 * Users router functions
 *
 * These functions are proxys for the new router interface
 * for old SEF extensions.
 *
 * @param   array  &$query  REQUEST query
 *
 * @return  array  Segments of the SEF url
 *
 * @deprecated  4.0  Use Class based routers instead
 */
function spmedicalBuildRoute(&$query){
	$app = JFactory::getApplication();
	$router = new SpmedicalRouter($app, $app->getMenu());

	return $router->build($query);
}

/**
 * Convert SEF URL segments into query variables
 *
 * @param   array  $segments  Segments in the current URL
 *
 * @return  array  Query variables
 *
 * @deprecated  4.0  Use Class based routers instead
 */
function spmedicalParseRoute($segments){
	$app = JFactory::getApplication();
	$router = new SpmedicalRouter($app, $app->getMenu());

	return $router->parse($segments);
}
