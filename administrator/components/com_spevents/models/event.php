<?php
defined('_JEXEC') or die;


class SpeventsModelEvent extends JModelAdmin
{
	protected $text_prefix = 'COM_SPEVENTS';

	public function getTable($name = 'Event', $prefix = 'SpeventsTable', $config = array())
	{
		return JTable::getInstance($name, $prefix, $config);
	}

	public function getForm($data = array(), $loadData = true)
	{
		$app = JFactory::getApplication();
		$form = $this->loadForm('com_spevents.event','event',array('control' => 'jform', 'load_data' => $loadData));

		if (empty($form))
		{
			return false;
		}

		return $form;
	}


	public function loadFormData()
	{
		$data = JFactory::getApplication()
			->getUserState('com_spevents.edit.event.data',array());

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
			$registry->loadString($item->organizers);
			$item->organizers = $registry->toArray();

			$registry = new JRegistry();
			$registry->loadString($item->categories);
			$item->categories = $registry->toArray();

			$registry = new JRegistry();
			$registry->loadString($item->recurring);
			$item->recurring = $registry->toArray();

			$registry = new JRegistry();
			$registry->loadString($item->registration);
			$item->registration = $registry->toArray();

			$registry = new JRegistry();
			$registry->loadString($item->discount);
			$item->discount = $registry->toArray();

			$registry = new JRegistry();
			$registry->loadString($item->tickets);
			$item->tickets = $registry->toArray();

			$registry = new JRegistry();
			$registry->loadString($item->tags);
			$item->tags = $registry->toArray();

			$registry = new JRegistry();
			$registry->loadString($item->settings);
			$item->settings = $registry->toArray();

			$registry = new JRegistry();
			$registry->loadString($item->slots);
			$item->slots = $registry->toArray();

			$registry = new JRegistry();
			$registry->loadString($item->social_tags);
			$item->social_tags = $registry->toArray();

			$registry = new JRegistry();
			$registry->loadString($item->gallery);
			$item->gallery = $registry->toArray();
			
			return $item;
		}

		return parent::getItem($pk);
	}


}