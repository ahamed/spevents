<?php
defined('_JEXEC') or die;


class SpeventsControllerSpeakers extends JControllerAdmin
{

	public function getModel($name = 'Speaker', $prefix = 'SpeventsModel', $config = array('ignore_request' => true))
	{
		$model = parent::getModel($name, $prefix, $config);
		return $model;
	}
}