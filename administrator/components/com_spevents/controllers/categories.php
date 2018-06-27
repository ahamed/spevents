<?php
defined('_JEXEC') or die;


class SpeventsControllerCategories extends JControllerAdmin
{

	public function getModel($name = 'Category', $prefix = 'SpeventsModel', $config = array('ignore_request' => true))
	{
		$model = parent::getModel($name, $prefix, $config);
		return $model;
	}
}