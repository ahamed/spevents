<?php
defined('_JEXEC') or die;


class SpeventsTableLocation extends JTable
{
	public function __construct(&$db)
	{
		parent::__construct('#__spevents_locations','id',$db);
	}

	public function bind($src, $ignore = array())
	{

		return parent::bind($src, $ignore);
	}

	public function store($updateNulls = false)
	{
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

		$table = JTable::getInstance('Location','SpeventsTable');

		if ($table->load(['alias' => $this->alias]) && ($table->id != $this->id || $this->id == 0) )
		{
			$this->setError(JText::_('COM_SPEVENTS_ERROR_UNIQUE_ALIAS'));
			return false;
		}

		return parent::store($updateNulls);
	}

	public function check()
	{
		if (trim($this->venue_name) == '')
		{
			throw new UnexpectedValueException(sprintf('The venue name is empty'));
		}

		if (empty($this->alias))
		{
			$this->alias = $this->venue_name;
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