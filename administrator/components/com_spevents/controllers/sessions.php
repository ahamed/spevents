<?php
defined('_JEXEC') or die;


class SpeventsControllerSessions extends JControllerAdmin
{

	public function getModel($name = 'Session', $prefix = 'SpeventsModel', $config = array('ignore_request' => true))
	{
		$model = parent::getModel($name, $prefix, $config);
		return $model;
	}
}