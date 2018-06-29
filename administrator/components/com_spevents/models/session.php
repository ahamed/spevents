<?php
defined('_JEXEC') or die;


class SpeventsModelSession extends JModelAdmin
{
	protected $text_prefix = 'COM_SPEVENTS';

	public function getTable($name = 'Session', $prefix = 'SpeventsTable', $config = array())
	{
		return JTable::getInstance($name, $prefix, $config);
	}

	public function getForm($data = array(), $loadData = true)
	{
		$app = JFactory::getApplication();
		$form = $this->loadForm('com_spevents.session','session',array('control' => 'jform', 'load_data' => $loadData));

		if (empty($form))
		{
			return false;
		}

		return $form;
	}


	public function loadFormData()
	{
		$data = JFactory::getApplication()
			->getUserState('com_spevents.edit.session.data',array());

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

	public function getItem($pk = null)
	{
		if ($item = parent::getItem($pk))
		{
			$registry = new JRegistry();
			$registry->loadString($item->speakers);
			$item->speakers = $registry->toArray();
			return $item;
		}
		return parent::getItem($pk);
	}
}