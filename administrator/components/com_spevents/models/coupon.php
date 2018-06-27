<?php
defined('_JEXEC') or die;


class SpeventsModelCoupon extends JModelAdmin
{
	protected $text_prefix = 'COM_SPEVENTS';

	public function getTable($name = 'Coupon', $prefix = 'SpeventsTable', $config = array())
	{
		return JTable::getInstance($name, $prefix, $config);
	}

	public function getForm($data = array(), $loadData = true)
	{
		$app = JFactory::getApplication();
		$form = $this->loadForm('com_spevents.coupon','coupon',array('control' => 'jform', 'load_data' => $loadData));

		if (empty($form))
		{
			return false;
		}

		return $form;
	}


	public function loadFormData()
	{
		$data = JFactory::getApplication()
			->getUserState('com_spevents.edit.coupon.data',array());

		if (empty($data))
		{
			$data = $this->getItem();
		}

		return $data;
	}

	protected function canDelete($record)
	{
		if (!empty($record->id))
		{
			if ($record->enabled != -2) {
				return ;
			}

			$user = JFactory::getUser();

			return parent::canDelete($record);
		}

	}

	protected function canEditState($record)
	{
		return parent::canEditState($record);
	}
}