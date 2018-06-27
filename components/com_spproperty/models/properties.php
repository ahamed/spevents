<?php
/**
 * @package     SP Property
 *
 * @copyright   Copyright (C) 2010 - 2016 JoomShaper. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// No Direct Access
defined ('_JEXEC') or die('Resticted Aceess');

jimport( 'joomla.application.component.helper' );

class SppropertyModelProperties extends FOFModel{
	// build query
	public function buildQuery($overrideLimits = false){
		//Frontend
		if(FOFPlatform::getInstance()->isFrontend()) {
			$input 			= JFactory::getApplication()->input;
			$sort_catid 	= $input->get('catid', NULL, 'INT');
			$keyword 		= $input->get('keyword', NULL, 'STRING');
			$city 			= $input->get('city', NULL, 'STRING');
			$pstatus 		= $input->get('pstatus', NULL, 'STRING');
			$minsize    	= $input->get('minsize', NULL, 'INT');
			$maxsize    	= $input->get('maxsize', NULL, 'INT');
			$beds 			= $input->get('beds', NULL, 'INT');
			$baths 			= $input->get('baths', NULL, 'INT');
			$parking 		= $input->get('parking', NULL, 'INT');
			$zipcode 		= $input->get('zipcode', NULL, 'STRING');
			$min_price 		= $input->get('min_price', NULL, 'INT');
			$max_price 		= $input->get('max_price', NULL, 'INT');
		}

		$db = $this->getDbo();
		$query = $db->getQuery(true);
		$this->modelDispatcher->trigger('onBeforeBuildQuery', array(&$this, &$query));
		$query->select( array('a.*') );

		if(FOFPlatform::getInstance()->isFrontend()) {
			$query->select($db->quoteName('b.title', 'category_name'));
		}

		$query->from($db->quoteName('#__spproperty_properties', 'a'));

		if(FOFPlatform::getInstance()->isFrontend()) {
			$query->join('LEFT', $db->quoteName('#__spproperty_categories', 'b') . ' ON (' . $db->quoteName('a.spproperty_category_id') . ' = ' . $db->quoteName('b.spproperty_category_id') . ')');
		}

		//Frontend
		if(FOFPlatform::getInstance()->isFrontend()) {
			// Get menu Params
			$app 				= JFactory::getApplication();
			$menu  			= $app->getMenu()->getActive(); // get the active item

			$params  		= $menu->params; // get the active item
			$order_by 	= $params->get('order_by', '');
			$catid   		= $params->get('catid', '');
			$agentid 		= $params->get('agentid', '');
			$pstatus		= ($pstatus) ? $pstatus : $params->get('property_status', '');

			if ($sort_catid) {
				$query->where($db->quoteName('a.spproperty_category_id').'=' . $sort_catid);
			} elseif ($catid) {
				$query->where($db->quoteName('a.spproperty_category_id').'=' . $catid);
			}

			if ($keyword) {
				$keyword = preg_replace('#\xE3\x80\x80#s', " ", trim($keyword));
				$keyword_array = explode(" ", $keyword);
				$query_string = implode("|",$keyword_array);
				$query->where($db->quoteName('a.title') . ' REGEXP '. $db->quote($query_string));
			}

			if ($city) {
				$city = preg_replace('#\xE3\x80\x80#s', " ", trim($city));
				$city_array = explode(" ", $city);
				$city_string = implode("|",$city_array);
				$query->where($db->quoteName('a.city') . ' REGEXP ' . $db->quote($city_string));
			}

			if($pstatus){
				$query->where($db->quoteName('a.property_status').'=' . $db->quote($pstatus));
			}

			if ($minsize) {
				$query->where($db->quoteName('a.psize').'>=' . $db->quote($minsize));
			}


			if ($maxsize) {
				$query->where($db->quoteName('a.psize').'<=' . $db->quote($maxsize));
			}

			if ($beds) {
				$query->where($db->quoteName('a.beds').'=' . $beds);
			}

			if ($baths) {
				$query->where($db->quoteName('a.baths').'=' . $baths);
			}

			if ($agentid) {
				$query->where($db->quoteName('a.spproperty_agent_id').'=' . $agentid);
			}

			if ($parking) {
				$query->where($db->quoteName('a.garages').'=' . $parking);
			}

			if ($zipcode) {
				$query->where($db->quoteName('a.zip').'=' . $zipcode);
			}

			if ($min_price) {
				$query->where($db->quoteName('a.price').'>=' . $min_price);
			}

			if ($max_price) {
				$query->where($db->quoteName('a.price').'<=' . $max_price);
			}

			//Enabled
			$query->where($db->qn('a.enabled')." = ".$db->quote('1'));
			// ordering
			if ($order_by=='asc') {
				$query->order($db->quoteName('a.ordering') . ' ASC');
			} elseif ($order_by== 'featured') {
				$query->where($db->quoteName('a.featured') . ' = 1');
				$query->order($db->quoteName('a.ordering') . ' DESC');

			} else {
				$query->order($db->quoteName('a.ordering') . ' DESC');
			}

		}

		if(!FOFPlatform::getInstance()->isFrontend()) {
			// Call the behaviors
			$this->modelDispatcher->trigger('onAfterBuildQuery', array(&$this, &$query));
		}
		return $query;

	}

	//if item not found
	public function &getItem($id = null) {
		$item = parent::getItem($id);
		if(FOFPlatform::getInstance()->isFrontend()) {
			if($item->spproperty_property_id) {
				return $item;
			} else {
				return JError::raiseError(404, JText::_('COM_SPPROPERTY_NO_ITEMS_FOUND'));
			}
		} else {
			return $item;
		}
	}

	// Get Lessons by course ID
	public static function getAllProperties($params = '', $limit = '') {

		$order_by = $params->get('order_by', 'DESC');

		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select($db->quoteName(array('a.spproperty_property_id', 'a.title', 'a.slug', 'a.image', 'a.description', 'a.spproperty_category_id', 'a.price', 'a.psize', 'a.beds', 'a.baths', 'a.garages', 'a.country' ,'a.city', 'a.property_status')));
		$query->select($db->quoteName('b.title', 'category_name'));
		$query->from($db->quoteName('#__spproperty_properties', 'a'));
		$query->join('LEFT', $db->quoteName('#__spproperty_categories', 'b') . ' ON (' . $db->quoteName('a.spproperty_category_id') . ' = ' . $db->quoteName('b.spproperty_category_id') . ')');

		//Language
		$query->where('a.language in (' . $db->quote(JFactory::getLanguage()->getTag()) . ',' . $db->quote('*') . ')');

		if ($catid = $params->get('catid')) {
			$query->where($db->quoteName('a.spproperty_category_id').'=' . $catid);
		}

		if ($agentid = $params->get('agentid')) {
			$query->where($db->quoteName('a.spproperty_agent_id').'=' . $agentid);
		}

		if ($limit = $params->get('limit', 6)) {
			$query->setLimit($limit);
		}

		$query->where($db->quoteName('a.enabled')." = 1");

		if ($order_by=='asc') {
			$query->order($db->quoteName('a.ordering') . ' ASC');
		} elseif ($order_by== 'featured') {
			$query->where($db->quoteName('a.featured') . ' = 1');
			$query->order($db->quoteName('a.ordering') . ' DESC');
		} else {
			$query->order($db->quoteName('a.ordering') . ' DESC');
		}

		$db->setQuery($query);
		$results = $db->loadObjectList();

		foreach ($results as &$result) {
			$result->url = JRoute::_('index.php?option=com_spproperty&view=property&id='.$result->spproperty_property_id.':'.$result->slug . SppropertyHelper::getItemid('properties'));
		}

		return $results;
	}


	// Get property types
	public static function getCategories($limit = '4', $ordering = 'DESC', $pstatus = '') {

		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select( array('a.*') );
		$query->from($db->quoteName('#__spproperty_categories', 'a'));

		//Language
	 	$query->where('a.language in (' . $db->quote(JFactory::getLanguage()->getTag()) . ',' . $db->quote('*') . ')');
		$query->setLimit($limit);
		$query->where($db->quoteName('a.enabled')." = 1");
		if ($ordering != 'featured') {
			$query->order('a.ordering '. $ordering);
		} else{
			$query->order('a.ordering DESC');
		}

		$db->setQuery($query);
		$results = $db->loadObjectList();

		foreach ($results as &$result) {
			$result->this_count 	= self::countProperties($result->spproperty_category_id, $ordering, $pstatus);
			$result->url = JRoute::_('index.php?option=com_spproperty&view=properties&catid='.$result->spproperty_category_id.':'.$result->slug . SppropertyHelper::getItemid('properties'));
		}

		return $results;
	}

	// Count properties by id
	public static function countProperties($type_id = '', $ordering = '', $pstatus = '') {

		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select( array('COUNT(a.spproperty_property_id)') );
	  	$query->from($db->quoteName('#__spproperty_properties', 'a'));

	  	//Language
		$query->where('a.language in (' . $db->quote(JFactory::getLanguage()->getTag()) . ',' . $db->quote('*') . ')');

		if ($type_id) {
			$query->where($db->quoteName('a.spproperty_category_id').'=' . $type_id);
		}

		if($pstatus){
			$query->where($db->quoteName('a.property_status').'=' . $db->quote($pstatus));
		}

		// if ($cat_id) {
		// 	$query->where($db->quoteName('a.spproperty_category_id').'=' . $cat_id);
		// }

		if ($ordering == 'featured') {
			$query->where($db->quoteName('a.featured') . ' = 1');
		}

		$query->where($db->quoteName('a.enabled').' = 1');
		$db->setQuery($query);
		$count = $db->loadResult();

		return $count;
	}

	// Get Category info by ID
	public static function getCatInfo($catid = '') {

		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select( array('a.*') );
	  	$query->from($db->quoteName('#__spproperty_categories', 'a'));
		$query->where($db->quoteName('a.spproperty_category_id').'=' . $db->quote($catid));

		//Language
		$query->where('a.language in (' . $db->quote(JFactory::getLanguage()->getTag()) . ',' . $db->quote('*') . ')');
		$query->where($db->quoteName('a.enabled').' = 1');
		$db->setQuery($query);
		$result = $db->loadObject();

		return $result;
	}

	// Get features
	public static function getPfeatures( $fetid ='' ) {

		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select( array('a.*') );
	    $query->from($db->quoteName('#__spproperty_propertyfeatures', 'a'));
	    if ($fetid) {
	    	$query->where($db->quoteName('a.spproperty_propertyfeature_id').'=' . $fetid);
	    }
	    //Language
		$query->where('a.language in (' . $db->quote(JFactory::getLanguage()->getTag()) . ',' . $db->quote('*') . ')');
		$query->where($db->quoteName('a.enabled').' = 1');
		$db->setQuery($query);

		if ($fetid) {
			$results = $db->loadObject();
		} else {
			$results = $db->loadObjectList();
		}

		return $results;
	}

	// Get Agent info by id
	public static function getAgntInfo($agntid = '') {

		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select( array('a.*') );
	    $query->from($db->quoteName('#__spproperty_agents', 'a'));
		$query->where($db->quoteName('a.spproperty_agent_id').'=' . $agntid);
		$query->where($db->quoteName('a.enabled').' = 1');
		$db->setQuery($query);
		$result = $db->loadObject();

		return $result;
	}

	// ajax booking
	public function insertBooking( $pid = '', $name = '', $phone = '', $email= '', $message = '', $user_id = 0, $visitor_ip) {

		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$columns = array('spproperty_property_id', 'customer_name', 'customer_email', 'customer_phone', 'customer_comments', 'visitor_ip', 'created_by', 'created_on', 'enabled');
		$values = array($db->quote($pid), $db->quote($name), $db->quote($email), $db->quote($phone), $db->quote($message), $db->quote($visitor_ip), $db->quote($user_id), $db->quote(JFactory::getDate()), 1);
		$query
		    ->insert($db->quoteName('#__spproperty_visitrequests'))
		    ->columns($db->quoteName($columns))
		    ->values(implode(',', $values));

		$db->setQuery($query);
		$db->execute();

		return $db->insertid();
	}


}