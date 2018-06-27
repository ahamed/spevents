<?php
defined('_JEXEC') or die;


class SpeventsControllerOrganizers extends JControllerAdmin
{

	public function getModel($name = 'Organizer', $prefix = 'SpeventsModel', $config = array('ignore_request' => true))
	{
		$model = parent::getModel($name, $prefix, $config);
		return $model;
	}
}