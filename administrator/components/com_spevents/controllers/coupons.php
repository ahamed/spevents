<?php
defined('_JEXEC') or die;


class SpeventsControllerCoupons extends JControllerAdmin
{

	public function getModel($name = 'Coupon', $prefix = 'SpeventsModel', $config = array('ignore_request' => true))
	{
		$model = parent::getModel($name, $prefix, $config);
		return $model;
	}
}