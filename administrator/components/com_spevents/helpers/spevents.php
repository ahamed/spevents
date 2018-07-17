<?php

/**
 * @package     Joomla.Administrator
 * @subpackage  com_spevents
 *
 * @license     MIT
 */
defined('_JEXEC') or die;

/**
 * Spevents component helper.
 *
 * @since  1.6
 */

class SpeventsHelper extends JHelperContent
{


	public static function addSubmenu($vName){
		JHtmlSidebar::addEntry(
			JText::_('COM_SPEVENTS_SUBMENU_DASHBOARD'),
			'index.php?option=com_spevents&view=dashboard',
			$vName == 'dashboard'
		);
		JHtmlSidebar::addEntry(
			JText::_('COM_SPEVENTS_SUBMENU_CATEGORY'),
			'index.php?option=com_spevents&view=categories',
			$vName == 'categories'
		);
		JHtmlSidebar::addEntry(
			JText::_('COM_SPEVENTS_SUBMENU_LOCATION'),
			'index.php?option=com_spevents&view=locations',
			$vName == 'locations'
		);
		JHtmlSidebar::addEntry(
			JText::_('COM_SPEVENTS_SUBMENU_ORGANIZER'),
			'index.php?option=com_spevents&view=organizers',
			$vName == 'organizers'
		);
		JHtmlSidebar::addEntry(
			JText::_('COM_SPEVENTS_SUBMENU_COUPONS'),
			'index.php?option=com_spevents&view=coupons',
			$vName == 'coupons'
		);
		JHtmlSidebar::addEntry(
			JText::_('COM_SPEVENTS_SUBMENU_TICKETS'),
			'index.php?option=com_spevents&view=tickets',
			$vName == 'tickets'
		);
		JHtmlSidebar::addEntry(
			JText::_('COM_SPEVENTS_SUBMENU_TAGS'),
			'index.php?option=com_spevents&view=tags',
			$vName == 'tags'
		);
		JHtmlSidebar::addEntry(
			JText::_('COM_SPEVENTS_SUBMENU_EVENTS'),
			'index.php?option=com_spevents&view=events',
			$vName == 'events'
		);
		JHtmlSidebar::addEntry(
			JText::_('COM_SPEVENTS_SUBMENU_SPEAKERS'),
			'index.php?option=com_spevents&view=speakers',
			$vName == 'speakers'
		);
		JHtmlSidebar::addEntry(
			JText::_('COM_SPEVENTS_SUBMENU_SESSIONS'),
			'index.php?option=com_spevents&view=sessions',
			$vName == 'sessions'
		);
		JHtmlSidebar::addEntry(
			JText::_('COM_SPEVENTS_SUBMENU_ORDERS'),
			'index.php?option=com_spevents&view=orders',
			$vName == 'orders'
		);
		JHtmlSidebar::addEntry(
			JText::_('COM_SPEVENTS_SUBMENU_SUBSCRIBERS'),
			'index.php?option=com_spevents&view=subscriptions',
			$vName == 'subscriptions'
		);

		/*--EOS EndOfSection: Dont't remove for future submenus generation--*/
	}

	public static function getActions($component = '', $section = '', $id = 0)
	{
		return parent::getActions($component, $section, $id);
	}
	
	//generate a random string of specific range
	public static function generateRandom($length = 8)
	{
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}

	//generate a random hex color code
	public static function generateRandomColor()
	{
		$codes = "0123456789ABCDEF";
		$codeLength = strlen($codes);
		$color = '';

		for( $i = 0; $i < 6; $i++)
		{
			$color .= $codes[rand(0, $codeLength - 1)];
		}
		return '#' . $color; 
	}



	/**
	 * relationship mapping
	 * table_a contains primary key
	 * table_b contains foreign key
	 * mapping OneToOne relationship
	 * @return Object
	 */
	public static function hasOne($table_a, $table_b, $primary_key, $foreign_key, $id)
	{
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);

		$query->select('r.*');
		$query->from($db->quoteName($table_a, 'l'));
		$query->join('LEFT', 
		$db->quoteName($table_b, 'r') . ' ON(' . $db->quoteName('l.' . $primary_key) . '=' . $db->quoteName('r.' . $foreign_key) . ')');
		$query->where($db->quoteName('r.'. $foreign_key) . '=' . $db->quote($id));

		$db->setQuery($query);
		$result = $db->loadObject();
		return $result;
	}



	/**
	 * relationship mapping
	 * table_a contains primary key
	 * table_b contains foreign key
	 * mapping OneToMany relationship
	 * @return ObjectList
	 */
	public static function hasMany($table_a, $table_b, $primary_key, $foreign_key, $id)
	{
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);

		$query->select('r.*');
		$query->from($db->quoteName($table_a, 'l'));
		$query->join('LEFT', 
		$db->quoteName($table_b, 'r') . ' ON(' . $db->quoteName('l.' . $primary_key) . '=' . $db->quoteName('r.' . $foreign_key) . ')');
		$query->where($db->quoteName('r.'. $foreign_key) . '=' . $db->quote($id));

		$db->setQuery($query);
		$result = $db->loadObjectList();
		return $result;
	}



	/**
	 * relationship mappping
	 * table_a's data belogs to table_b
	 * table_a contains the foreign key and
	 * table_b contains the primary key
	 * mapping OneToOne or ManyToOne relationship
	 * @return Object
	 */
	public static function belongsTo($table_a, $table_b, $primary_key, $foreign_key, $id)
	{
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);

		$query->select('r.*');
		$query->from($db->quoteName($table_a, 'l'));
		$query->join('LEFT', 
		$db->quoteName($table_b, 'r') . ' ON(' . $db->quoteName('l.' . $foreign_key) . '=' . $db->quoteName('r.' . $primary_key) . ')');
		$query->where($db->quoteName('r.'. $primary_key) . '=' . $db->quote($id));

		$db->setQuery($query);
		$result = $db->loadObject();
		return $result;

	}

	//get object data of a specific parameter
	public static function _get($param,$table_name,$id)
	{
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select($db->quoteName($param));
		$query->from($db->quoteName($table_name));
		$query->where($db->quoteName('id') . ' = '. $db->quote($id));
		$db->setQuery($query);
		$result = json_decode($db->loadResult());
		return $result;

	}

	//get component version
	public static function getVersion($component = 'com_spevents') {
		$db = JFactory::getDbo();
		$query = $db->getQuery(true)
		->select('e.manifest_cache')
		->select($db->quoteName('e.manifest_cache'))
		->from($db->quoteName('#__extensions', 'e'))
		->where($db->quoteName('e.element') . ' = ' . $db->quote($component));
		$db->setQuery($query);
		$manifest_cache = json_decode($db->loadResult());
		if(isset($manifest_cache->version) && $manifest_cache->version) {
			return $manifest_cache->version;
		}	
		return '1.0';
	}

	//convert object string to array
	public static function stringToArray($obj)
	{
		$registry = new JRegistry();
		$registry->loadString($obj);
		$obj = $registry->toArray();

		return $obj;
	}

	//convert array to object string
	public static function arrayToString($arr)
	{
		$registry = new JRegistry();
		$registry->loadArray($arr);
		$arr = (string)$registry;
		
		return $arr;
	}

	public static function isEmptyObject($object)
	{
		$object = json_decode($object, true);
		$count = 0;
		foreach($object as $key => $obj)
		{
			if (empty($obj))
			{
				$count++;
			}
		}

		if (count($object) === $count)
			return true;
		return false;
	}

	//Debugging function
	public static function ___($data, $die = true)
	{
		echo "<pre>";
		print_r($data);
		echo "</pre>";
		if ($die) die;
	}

}
