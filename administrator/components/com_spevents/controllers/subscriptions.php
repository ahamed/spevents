<?php
defined('_JEXEC') or die;


use Joomla\Utilities\ArrayHelper;

class SpeventsControllerSubscriptions extends JControllerAdmin
{

	public function getModel($name = 'Subscription', $prefix = 'SpeventsModel', $config = array('ignore_request' => true))
	{
		$model = parent::getModel($name, $prefix, $config);
		return $model;
		
	}
}

