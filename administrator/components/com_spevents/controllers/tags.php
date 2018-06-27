<?php
defined('_JEXEC') or die;


class SpeventsControllerTags extends JControllerAdmin
{

	public function getModel($name = 'Tag', $prefix = 'SpeventsModel', $config = array('ignore_request' => true))
	{
		$model = parent::getModel($name, $prefix, $config);
		return $model;
	}
}