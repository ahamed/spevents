<?php
/**
* @package     SP Movie Database
* @copyright   Copyright (C) 2010 - 2016 JoomShaper. All rights reserved.
* @license     GNU General Public License version 2 or later.
*/

defined('_JEXEC') or die('Restricted access!');

jimport('joomla.form.formfield');

class FOFFormFieldSpcelebrities extends FOFFormFieldList{

	public function getOptions() {
		$db		= JFactory::getDbo();
		$query	= $db->getQuery(true)
			->select('DISTINCT a.spmoviedb_celebrity_id AS value, a.title AS text')
			->from('#__spmoviedb_celebrities AS a');

		$query->order('a.spmoviedb_celebrity_id ASC');

		// Get the options.
		$db->setQuery($query);

		try
		{
			$options = $db->loadObjectList();
		}
		catch (RuntimeException $e)
		{
			return false;
		}

		$options = array_merge(parent::getOptions(), $options);

		return $options;
	}

	public function getRepeatable()
	{
		$celebrity_ids = $this->value;

		if(isset($celebrity_ids) && count(json_decode($celebrity_ids))) {
			$celebrity_ids = implode(',', json_decode($celebrity_ids));
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select( array('a.*') );
		    $query->from($db->quoteName('#__spmoviedb_celebrities', 'a'));
		    $query->where($db->quoteName('a.spmoviedb_celebrity_id')." IN (" . $celebrity_ids . ")");
		    $db->setQuery($query);
			$clebrities = $db->loadObjectList();

			$output = '';
			foreach ($clebrities as $key => $celebrity) {
				$output .= '<a href="index.php?option=com_spmoviedb&view=celebrity&id=' . $celebrity->spmoviedb_celebrity_id . '">' . $celebrity->title . '</a>' . ', ';
			}

			return rtrim(trim($output), ',');
		}

		return '....';
	}
}
