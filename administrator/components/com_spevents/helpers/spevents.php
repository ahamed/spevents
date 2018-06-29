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

		/*--EOS EndOfSection: Dont't remove for future submenus generation--*/
	}

	public static function getActions($component = '', $section = '', $id = 0)
	{
		return parent::getActions($component, $section, $id);
	}

	public static function _get($param,$table_name,$id)
	{
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select($db->quoteName($param));
		$query->from($db->quoteName($table_name));
		$query->where($db->quoteName('id') . ' = '. $db->quote($id));
		$db->setQuery($query);
		$result = $db->loadObject();
		return $result;
		$result = $result->$param;
		return json_decode($result);

	}

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

	//Debugging function
	public static function ___($data, $die = true)
	{
		echo "<pre>";
		print_r($data);
		echo "</pre>";
		if ($die)
			die;
	}

}
