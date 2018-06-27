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

class SppropertyModelAgents extends FOFModel{

	public function buildQuery($overrideLimits = false){
		$db = $this->getDbo();
		$query = $db->getQuery(true);
		$this->modelDispatcher->trigger('onBeforeBuildQuery', array(&$this, &$query));
		$query->select( array('a.*') );
	  $query->from($db->quoteName('#__spproperty_agents', 'a'));

		//Frontend
		if(FOFPlatform::getInstance()->isFrontend()) {
			// Get menu Params
			$app = JFactory::getApplication();
			$params  = $app->getMenu()->getActive()->params; // get the active item

			$order_by = $params->get('order_by', '');
			//Enabled
			$query->where($db->qn('a.enabled')." = ".$db->quote('1'));
			// ordering
			if ($order_by=='asc') {
				$query->order($db->quoteName('a.ordering') . ' ASC');
			} else {
				$query->order($db->quoteName('a.ordering') . ' DESC');
			}

		}

		if(FOFPlatform::getInstance()->isFrontend()) {
			// Call the behaviors
			$this->modelDispatcher->trigger('onAfterBuildQuery', array(&$this, &$query));
		}

		return $query;

	}

	//if item not found
	public function &getItem($id = null) {
		$item = parent::getItem($id);
		if(FOFPlatform::getInstance()->isFrontend()) {

			if($item->spproperty_agent_id) {
				return $item;
			} else {
				return JError::raiseError(404, JText::_('COM_SPPROPERTY_NO_ITEMS_FOUND'));
			}
		} else {
			return $item;
		}
	}

	// Get agent properties
	public static function getAgntProperties($agentid ='', $limit = '') {
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select( array('a.*') );
		$query->select($db->quoteName('b.title', 'category_name'));
		$query->from($db->quoteName('#__spproperty_properties', 'a'));
		$query->join('LEFT', $db->quoteName('#__spproperty_categories', 'b') . ' ON (' . $db->quoteName('a.spproperty_category_id') . ' = ' . $db->quoteName('b.spproperty_category_id') . ')');
		//Language
		$query->where('a.language in (' . $db->quote(JFactory::getLanguage()->getTag()) . ',' . $db->quote('*') . ')');
		$query->where($db->quoteName('a.spproperty_agent_id').'=' . $agentid);
		$query->where($db->quoteName('a.enabled')." = 1");
		if ($limit) {
			$query->setLimit($limit);
		}
		$db->setQuery($query);
		$results = $db->loadObjectList();

		foreach ($results as &$result) {
			$result->url = JRoute::_('index.php?option=com_spproperty&view=property&id='. $result->spproperty_property_id .':'. $result->slug . SppropertyHelper::getItemid('properties'));
		}
		return $results;
	}

	// ajax booking
	public function insertBooking( $pid = '', $name = '', $phone = '', $email= '', $message = '', $user_id = 0) {
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$columns = array('spproperty_property_id', 'customer_name', 'customer_email', 'customer_phone', 'customer_comments', 'created_by', 'created_on', 'enabled');
		$values = array($db->quote($pid), $db->quote($name), $db->quote($email), $db->quote($phone), $db->quote($message), $db->quote($user_id), $db->quote(JFactory::getDate()), 1);
		$query
		    ->insert($db->quoteName('#__spproperty_bookings'))
		    ->columns($db->quoteName($columns))
		    ->values(implode(',', $values));

		$db->setQuery($query);
		$db->execute();

		return $db->insertid();
	}


}
