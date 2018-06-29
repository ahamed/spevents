<?php
defined('_JEXEC') or die;


class SpeventsControllerTickets extends JControllerAdmin
{

	public function getModel($name = 'Ticket', $prefix = 'SpeventsModel', $config = array('ignore_request' => true))
	{
		$model = parent::getModel($name, $prefix, $config);
		return $model;
	}
}