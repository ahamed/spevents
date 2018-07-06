<?php
defined('_JEXEC') or die;


class SpeventsControllerOrders extends JControllerAdmin
{

	public function getModel($name = 'Order', $prefix = 'SpeventsModel', $config = array('ignore_request' => true))
	{
		$model = parent::getModel($name, $prefix, $config);
		return $model;
	}
}