<?php
defined('_JEXEC') or die;

class SpeventsControllerTicket extends JControllerForm
{
	public function __construct($config = array())
	{
		parent::__construct($config);
	}

	protected function allowAdd($data = array())
	{
		return parent::allowAdd($data);
	}

	protected function allowEdit($data = array(), $key = 'id')
	{
		$id = (int) isset($data[$key]) ? $data[$key] : 0;

		if (!empty($id))
		{
			return JFactory::getUser()->authorise('core.edit','com_spevents.ticket.' . $id);
		}
		return parent::allowEdit($data, $key);
	}
}