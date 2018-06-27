<?php
defined('_JEXEC') or die;


class SpeventsControllerLocations extends JControllerAdmin
{

	public function getModel($name = 'Location', $prefix = 'SpeventsModel', $config = array('ignore_request' => true))
	{
		$model = parent::getModel($name, $prefix, $config);
		return $model;
	}
}