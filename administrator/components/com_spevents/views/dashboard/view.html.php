<?php
defined('_JEXEC') or die;

use SpeventsHelper as EH;

class SpeventsViewDashboard extends JViewLegacy
{
	protected $items;

	protected $state;

	protected $pagination;

    protected $model;
    
	protected $categories, $events, $speakers, $upcomingEventsCount; 
	
	protected $speakerList, $eventList, $upcomingEvents, $ordersList;
	
	protected $google_map; 

	protected $upcomingSessions;

	public function display($tpl = null)
	{
		$this->items    = $this->get('Items');
		$this->state    = $this->get('State');
		$this->pagination = $this->get('Pagination');
		$this->model = $this->getModel('dashboard');

//		/SpeventsHelper::___($this->items);

		SpeventsHelper::addSubmenu('dashboard');


		if (count($errors = $this->get('Errors')))
		{
			JError::raiseError(500,implode('<br>', $errors));
			return false;
		}

        JHtmlSidebar::setAction('index.php?option=com_spevents&view=dashboard');
        
        $this->sidebar = JHtmlSidebar::render();
        JToolbarHelper::title(JText::_("COM_SPEVENTS_SUBMENU_DASHBOARD"));

        $this->categories = $this->model->calculateCategories();
        $this->events = $this->model->calculateEvents();
        $this->speakers = $this->model->calculateSpeakers();
		$this->speakerList = $this->model->getSpeakers();
		$this->eventList = $this->model->getEvents();
		$this->upcomingEvents = $this->model->upcomingEvents();
		$this->upcomingEventsCount = $this->model->calculateUpcomingEvents();
		$this->upcomingSessions = $this->model->upcomingSessions();
		$this->ordersList = $this->model->getOrders();

		$this->google_map = $this->generateMapMarkers();

		return parent::display($tpl);
	}

	public function sessionsSpeakers($speakers)
	{
		$speakers = implode(',', $speakers);

		$db = JFactory::getDbo();
		$query = $db->getQuery(true);

		$query->select('a.*')
			->from($db->quoteName('#__spevents_speakers','a'))
			->where($db->quoteName('id') . ' IN(' . $speakers . ')');

		$db->setQuery($query);
		$result = $db->loadObjectList();

		return $result;
	}

	//generate events map location markers
	public function generateMapMarkers()
	{
		$positions = array();
		if (count($this->eventList))
		{
			$center = explode(',',SpeventsHelper::belongsTo('#__spevents_events', '#__spevents_locations', 'id', 'location', $this->eventList[0]->location)->lat_lng);	
		}
		else 
		{
			$center[0] = '23.7554981';
			$center[1] = '90.3741232';
		}

		$maps .= "var map;\n";
		$maps .= "function initMap(){\n";
		$maps .= "	map = new google.maps.Map(document.getElementById(\"map\"),{\n";
		$maps .= "	center : {lat: ". $center[0] . ", lng: ". $center[1] . "},\n ";
		$maps .= "	zoom: 6\n";
		$maps .= "});\n";
		foreach($this->eventList as $key => $event)
		{
			$map = EH::belongsTo('#__spevents_events', '#__spevents_locations', 'id', 'location', $event->location);
			$lat_lng = explode(',', $map->lat_lng);
			$marker = "setTimeout(function(){\n";
			$marker .= "	var marker" . $key . ";\n";
			$marker .= "	marker" . $key . "= new google.maps.Marker({\n";
			$marker .= "	position: {lat: " . $lat_lng[0] . ", lng: " . $lat_lng[1] . "},\n";
			$marker .= "	animation: google.maps.Animation.DROP,";
			$marker .= "	map: map,\n";
			$marker .= "	title: marker" . $key . "\n";
			$marker .= "});\n";
			$marker .= "}," . ($key * 200). ");";
			$positions[] = $marker;
		}
		$maps .= implode("\n", $positions);
		$maps .= "}\n";

		return $maps;
	}

}