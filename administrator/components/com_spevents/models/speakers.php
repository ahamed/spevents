<?php
defined('_JEXEC') or die;


class SpeventsModelSpeakers extends JModelList
{
	public function __construct(array $config = array())
	{
		if (empty($config['filter_fields']))
		{
			$config['filter_fields'] = [
				'id','a.id',
				'title','a.title',
				'created_by','a.created_by',
				'enabled','a.enabled',
				'access','a.access',
				'created_on','a.created_on',
				'ordering','a.ordering',
				'language','a.language',

			];
		}

		parent::__construct($config);
	}

	protected function populateState($ordering = 'a.ordering', $direction = 'asc')
	{
		$app = JFactory::getApplication();
		$context = $this->context;

		$search = $this->getUserStateFromRequest($this->context . '.filter.search', 'filter_search');
		$this->setState('filter.search', $search);

		$access = $this->getUserStateFromRequest($this->context . '.filter.access', 'filter_access');
		$this->setState('filter.access', $access);

		$published = $this->getUserStateFromRequest($this->context . '.filter.enabled', 'filter_enabled', '');
		$this->setState('filter.enabled', $published);

		$language = $this->getUserStateFromRequest($this->context . '.filter.language', 'filter_language', '');
		$this->setState('filter.language', $language);

		parent::populateState($ordering, $direction);
	}

	protected function getStoreId($id = '')
	{
		$id .= ':' . $this->getState('filter.search');
		$id .= ':' . $this->getState('filter.access');
		$id .= ':' . $this->getState('filter.enabled');
		$id .= ':' . $this->getState('filter.language');

		return parent::getStoreId($id);
	}

	protected function getListQuery()
	{
		$app = JFactory::getApplication();
		$state = $this->get('State');
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);

		$query->select(
			$this->getState('list.select','a.*')
		);
		$query->from('#__spevents_speakers as a');
		$published = $this->getState('filter.enabled',false);

		if (is_numeric($published))
		{
			$query->where($db->quoteName('a.enabled') . ' = ' . (int)$published);
		}
		elseif ($published == '')
		{
			$query->where($db->quoteName('a.enabled') . ' IN (0, 1)');
		}

		$search = $this->getState('filter.search');
		if (!empty($search))
		{
			$search = $db->quote('%' . $db->escape($search,true) . '%');
			$query->where('a.title LIKE '. $search );
		}

		$orderCol = $this->getState('list.ordering','a.ordering');
		$orderDirn = $this->getState('list.direction','asc');

		$order = $db->escape($orderCol) . ' ' . $db->escape($orderDirn);
		$query->order($order);


		return $query;
	}

}