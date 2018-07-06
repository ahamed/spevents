<?php
defined('_JEXEC') or die;


class SpeventsTableEvent extends JTable
{
	public function __construct(&$db)
	{
		parent::__construct('#__spevents_events','id',$db);
	}

	public function bind($src, $ignore = array())
	{
		//SpeventsHelper::___($src);

		if (isset($src['organizers']) && is_array($src['organizers']))
		{
			$registry = new JRegistry();
			$registry->loadArray($src['organizers']);
			$src['organizers'] = (string)$registry;
		}

		if (isset($src['categories']) && is_array($src['categories']))
		{
			$registry = new JRegistry();
			$registry->loadArray($src['categories']);
			$src['categories'] = (string)$registry;
		}

		if (isset($src['recurring']) && is_array($src['recurring']))
		{
			$registry = new JRegistry();
			$registry->loadArray($src['recurring']);
			$src['recurring'] = (string)$registry;
		}

		if (isset($src['registration']) && is_array($src['registration']))
		{
			$registry = new JRegistry();
			$registry->loadArray($src['registration']);
			$src['registration'] = (string)$registry;
		}

		if (isset($src['discount']) && is_array($src['discount']))
		{
			$registry = new JRegistry();
			$registry->loadArray($src['discount']);
			$src['discount'] = (string)$registry;
		}

		if (isset($src['tickets']) && is_array($src['tickets']))
		{
			$registry = new JRegistry();
			$registry->loadArray($src['tickets']);
			$src['tickets'] = (string)$registry;

		}
		if (isset($src['tags']) && is_array($src['tags']))
		{
			$registry = new JRegistry();
			$registry->loadArray($src['tags']);
			$src['tags'] = (string)$registry;
		}
		if (isset($src['settings']) && is_array($src['settings']))
		{
			$registry = new JRegistry();
			$registry->loadArray($src['settings']);
			$src['settings'] = (string)$registry;
		}
		if (isset($src['social_tags']) && is_array($src['social_tags']))
		{
			$registry = new JRegistry();
			$registry->loadArray($src['social_tags']);
			$src['social_tags'] = (string)$registry;
		}
		if (isset($src['slots']) && is_array($src['slots']))
		{
			$registry = new JRegistry();
			$registry->loadArray($src['slots']);
			$src['slots'] = (string)$registry;
		}
		if (isset($src['gallery']) && is_array($src['gallery']))
		{
			$registry = new JRegistry();
			$registry->loadArray($src['gallery']);
			$src['gallery'] = (string)$registry;
		}

		if (isset($src['all_day_event']))
		{
			if ($src['all_day_event'])
			{
				$src['end_time'] = '';
			}
		}

		return parent::bind($src, $ignore);
	}

	public function store($updateNulls = false)
	{

		//SpeventsHelper::___($this);

		$user = JFactory::getUser();
		$app  = JFactory::getApplication();
		$date = new JDate('now', $app->getCfg('offset'));

		if ($this->id)
		{
			$this->modified_on = (string)$date;
			$this->modified_by = $user->get('id');
		}

		if (empty($this->created_on))
		{
			$this->created_on = (string)$date;
		}

		if (empty($this->created_by))
		{
			$this->created_by = $user->get('id');
		}

		$table = JTable::getInstance('Event','SpeventsTable');

		if ($table->load(['alias' => $this->alias]) && ($table->id != $this->id || $this->id == 0) )
		{
			$this->setError(JText::_('COM_SPEVENTS_ERROR_UNIQUE_ALIAS'));
			return false;
		}

		return parent::store($updateNulls);
	}

	public function check()
	{
		if (trim($this->title) == '')
		{
			throw new UnexpectedValueException(sprintf('The title is empty'));
		}

		if (empty($this->alias))
		{
			$this->alias = $this->title;
		}

		$this->alias = JApplicationHelper::stringURLSafe($this->alias, $this->language);

		if (trim(str_replace('-','',$this->alias)) == '')
		{
			$this->alias = JFactory::getDate()->format('Y-m-d-H-i-s');
		}
		return true;
	}

	public function publish($pks = null, $enabled = 1, $userId = 0)
	{
		$k = $this->_tbl_key;

		JArrayHelper::toInteger($pks);
		$enabled = (int) $enabled;

		if (empty($pks)) {
			if ($this->$k) {
				$pks = array($this->$k);
			} else {
				$this->setError(JText::_('JLIB_DATABASE_ERROR_NO_ROWS_SELECTED'));
				return false;
			}
		}


		$where = $k . '=' . implode(' OR '. $k . ' = ', $pks);

		$query = $this->_db->getQuery(true)
			->update($this->_db->quoteName($this->_tbl))
			->set($this->_db->quoteName('enabled') . ' = '. $enabled)
			->where($where);

		$this->_db->setQuery($query);


		try {
			$this->_db->execute();
		}catch(RuntimeException $e){
			$this->setError($e->getMessage());
			return false;
		}


		if (in_array($this->$k, $pks)) {
			$this->enabled = $enabled;
		}

		$this->setError('');
		return true;

	}


}