<?php
defined('_JEXEC') or die;
use SpeventsHelper as SP;

class SpeventsModelEvents extends JModelList
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
				'categories','a.categories','category_title',
				'access','a.access','access_level',
				'created_on','a.created_on',
				'ordering','a.ordering',
				'language','a.language',
				'organizers', 'a.organizers'
			];
		}

		parent::__construct($config);
	}

	protected function populateState($ordering = 'a.ordering', $direction = 'asc')
	{
		$app 		= JFactory::getApplication();
		$context 	= $this->context;

		$search 	= $this->getUserStateFromRequest($this->context . '.filter.search', 'filter_search');
		$this->setState('filter.search', $search);

		$access 	= $this->getUserStateFromRequest($this->context . '.filter.access', 'filter_access');
		$this->setState('filter.access', $access);

		$published 	= $this->getUserStateFromRequest($this->context . '.filter.enabled', 'filter_enabled', '');
		$this->setState('filter.enabled', $published);

		$language 	= $this->getUserStateFromRequest($this->context . '.filter.language', 'filter_language', '');
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
		$app 	= JFactory::getApplication();
		$state 	= $this->get('State');
		$db 	= JFactory::getDbo();
		$query 	= $db->getQuery(true);
		$query->select(
			$this->getState('list.select','a.*')
		);
		$query->from('#__spevents_events as a');
		$published 	= $this->getState('filter.enabled',false);

		if (is_numeric($published))
		{
			$query->where($db->quoteName('a.enabled') . ' = ' . (int)$published);
		}
		elseif ($published == '')
		{
			$query->where($db->quoteName('a.enabled') . ' IN (0, 1)');
		}

		if ($access = $this->getState('filter.access'))
		{
			$query->where($db->quoteName('a.access') . ' = ' . $db->quote($access));
		}

		if ($location = $this->getState('filter.location'))
		{
			$query->where($db->quoteName('a.location') . ' = ' . $db->quote($location));
		}

		//filter by tags
		if ($tag = $this->getState('filter.tag'))
		{
			$tags = SpeventsHelper::findInObject("tags", "#__spevents_events", $tag);
			if (count($tags))
			{
				$query->where($db->quoteName('a.id') . " IN( ". implode(',',$tags) . " )");
			}
			else
			{
				$query->where($db->quoteName('a.id') . ' < 0');
			}
		}

		//filter by categories
		if ($category 	= $this->getState('filter.category'))
		{
			$categories = SpeventsHelper::findInObject("categories", "#__spevents_events", $category);
			if (count($categories))
			{
				$query->where($db->quoteName('a.id') . " IN( " . implode(',', $categories) . " )");
			}
			else
			{
				$query->where($db->quoteName('a.id') . ' < 0');
			}
		}

		//filter by organizers
		if ($organizer 	= $this->getState('filter.organizer'))
		{
			$organizers = SpeventsHelper::findInObject("organizers", "#__spevents_events", $organizer);
			if (count($organizers))
			{
				$query->where($db->quoteName('a.id') . " IN( " . implode(',', $organizers) . " )");
			}
			else
			{
				$query->where($db->quoteName('a.id') . ' < 0');
			}
		}

		$user = JFactory::getUser();
		$user_id = $user->get('id','INT');
		if ($user_id)
		{
			$query->where($db->quoteName('a.created_by') . '=' . $db->quote($user_id));
		}

		//filter by keyword
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

	public function getItems()
	{
		$items = parent::getItems();
		foreach($items as $key => $item)
		{
			$item->ogranizer_info 	= $this->getOrganizers($item->organizers);
			$item->location_info 	= $this->getLocation($item->location);
		}

		return $items;
	}

	public function getOrganizers($id)
	{
		$db 	= JFactory::getDbo();
		$query 	= $db->getQuery(true);

		if (!is_array($id))
		{
			$id = (array) json_decode($id,true);
		}

		$id = implode(',',$id);

		$query->select('o.id, o.title');
		$query->from($db->quoteName('#__spevents_organizers','o'));
		$query->where($db->quoteName('id') . ' IN (' . $id . ')');
		
		$db->setQuery($query);
		$items = $db->loadObjectList();

		return $items;
	}

	public function getLocation($location_id = 0){

		$obj = new JObject;

		if ($location_id == 0)
		{
			$obj->id = 0;
			$obj->title = "Online";
			return $obj;
		}
		else
		{
			$db 	= JFactory::getDbo();
			$query 	= $db->getQuery(true);

			$query->select('lc.id, lc.venue_name as title')
				->from($db->quoteName('#__spevents_locations', 'lc'))
				->where($db->quoteName('lc.id') . ' = '. (int)$location_id);
			$db->setQuery($query);
			
			$result = $db->loadObject();
			return $result;
		}
	}

	//generate iteratable period
	public function generatePeriod($id, $param = 'recurring', $tbl_name = '#__spevents_events')
	{
		$begin 	= new DateTime();
		$end 	= new DateTime();

		$interval_string = "1 day";
		
		$dates 			= [];
		$repeat_also 	= [];
		$repeat_not 	= [];

		$recurring = SpeventsHelper::_get($param,$tbl_name,$id);

		if (!empty($recurring->repeat_start))
		{
			$begin = new DateTime($recurring->repeat_start);
		}

		if (!empty($recurring->repeat_end))
		{
			$end = new DateTime($recurring->repeat_end);
			$end = $end->modify( '+1 day' );
		}

		if (!empty($recurring->repeat_also))
		{
			$repeat_also = explode(',', $recurring->repeat_also);
			foreach($repeat_also as $key => &$ra)
			{
				$ra = new DateTime($ra);
			}
		}

		if (!empty($recurring->repeat_not))
		{
			$repeat_not = explode(',', $recurring->repeat_not);
			foreach($repeat_not as $key => &$r)
			{
				$r = new DateTime($r);
			}
		}
		
		if (!empty($recurring->repeat_amount) && !empty($recurring->repeat_type))
		{
			$interval_string = $recurring->repeat_amount . ' ' . $recurring->repeat_type;
		}

		$interval 	= DateInterval::createFromDateString($interval_string);
		$period 	= new DatePeriod($begin, $interval, $end);

		$data['repeat_also'] 	= $repeat_also;
		$data['repeat_not'] 	= $repeat_not;
		$data['period'] 		= $period;
		
		return $data;
	}

	/**
	 * calculate recurring event's dates
	 * 
	 * Find out all the dates when a specific event will held
	 * @return list of dates.
	 */
	public function calculateRecurringDate()
	{
		$db 	= JFactory::getDbo();
		$query 	= $db->getQuery(true);

		$query->select('*')->from($db->quoteName('#__spevents_events'));
		$query->where($db->quoteName('enabled') . '=' . $db->quote('1'));

		$db->setQuery($query);
		$results = $db->loadObjectList();

		$dates = [];
		foreach($results as $key => $result)
		{
			$tmp =[];
			if (SpeventsHelper::isEmptyObject($result->recurring))
			{
				$tmp['id'] 		= $result->id;
				$tmp['title'] 	= $result->title;
				$tmp['start'] 	= $result->start_date . 'T' . $result->start_time;
				$tmp['end'] 	= $result->end_date . 'T' . $result->start_time;
				$tmp['color'] 	= '#740474';

				$tmp['eventBorderColor'] 	= '#740474';
				$tmp['textColor'] 			= '#ffffff';
				
				$dates[] = $tmp;
			}
			else
			{
				$period = $this->generatePeriod($result->id);
				foreach ($period['period'] as $key => $p)
				{
					if (!in_array($p, $period['repeat_not']))
					{
						$tmp['id']		= $result->id;
						$tmp['title'] 	= $result->title;
						$tmp['start'] 	= $p->format('Y-m-d');
						$tmp['color'] 	= '#007404';

						$tmp['eventBorderColor'] 	= '#007404';
						$tmp['textColor'] 			= '#ffffff';
						
						$dates[] = $tmp;
						
					}	
				}

				foreach ($period['repeat_also'] as $key => $also)
				{
					$tmp['id'] 	  = $result->id;
					$tmp['title'] = $result->title;
					$tmp['start'] = $also->format('Y-m-d');
					$tmp['color'] = '#007404';

					$tmp['eventBorderColor'] 	= '#007404';
					$tmp['textColor'] 			= '#ffffff';
					
					$dates[] = $tmp;
				}
			}
			
		}

		return json_encode($dates);
	}

}