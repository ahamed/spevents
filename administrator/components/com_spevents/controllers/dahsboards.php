<?php
defined('_JEXEC') or die;


class SpeventsControllerDashboards extends JControllerAdmin
{

	public function getModel($name = 'Dashboard', $prefix = 'SpeventsModel', $config = array('ignore_request' => true))
	{
		$model = parent::getModel($name, $prefix, $config);
		return $model;
	}
}