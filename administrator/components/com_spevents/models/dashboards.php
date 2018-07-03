<?php
defined('_JEXEC') or die;


class SpeventsModelDashboards extends JModelList
{

	public function __construct(array $config = array())
	{
		if (empty($config['filter_fields']))
		{
			$config['filter_fields'] = [
				'id','a.id',
				'title','a.title',
				'alias', 'a.alias',
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

		$query->select('*');
		$query->from($db->quoteName('#__spevents_events'));
		$query->order('UNIX_TIMESTAMP(created_on) DESC');
		$query->setLimit(3);
		
		return $query;
	}

	public function getSpeakers()
	{
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select("*")->from($db->quoteName('#__spevents_speakers'));
		$query->order("UNIX_TIMESTAMP(created_on) DESC");
		$query->setLimit(3);
		$db->setQuery($query);
		
		$result = $db->loadObjectList();
		return $result;

	}

	public function calculateCategories()
	{
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select("COUNT(id) as total_categories")->from($db->quoteName("#__spevents_categories"));
		$db->setQuery($query);
		$result = $db->loadObject();
		return $result;
	}

	public function calculateEvents()
	{
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select("COUNT(id) AS total_events")->from($db->quoteName('#__spevents_events'));
		$db->setQuery($query);
		$result = $db->loadObject();
		return $result;
	}

	public function calculateSpeakers()
	{
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select("COUNT(id) AS total_speakers")->from($db->quoteName('#__spevents_speakers'));
		$db->setQuery($query);
		$result = $db->loadObject();
		return $result;
	}


}