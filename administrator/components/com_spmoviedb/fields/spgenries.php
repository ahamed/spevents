<?php
/**
* @package     SP Movie Database
* @copyright   Copyright (C) 2010 - 2016 JoomShaper. All rights reserved.
* @license     GNU General Public License version 2 or later.
*/

defined('_JEXEC') or die('Restricted access!');

jimport('joomla.form.formfield');

class JFormFieldSpgenries extends JFormField
{
	protected $type = 'Spgenries';

	public function getRepeatable(){
		return $this->getInput();
	}

	public function getInput()
	{

		$genre_ids = $this->value;

		if(isset($genre_ids) && count(json_decode($genre_ids))) {
			$genre_ids = implode(',', json_decode($genre_ids));
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select( array('a.*') );
		    $query->from($db->quoteName('#__spmoviedb_genres', 'a'));
		    $query->where($db->quoteName('a.spmoviedb_genre_id')." IN (" . $genre_ids . ")");
		    $db->setQuery($query);
			$genries = $db->loadObjectList();

			$output = '';
			foreach ($genries as $key => $genre) {
				$output .= '<a href="index.php?option=com_spmoviedb&view=genre&id=' . $genre->spmoviedb_genre_id . '">' . $genre->title . '</a>' . ', ';
			}

			return rtrim(trim($output), ',');
		}

		return '....';
	}

}
