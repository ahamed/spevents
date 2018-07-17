<?php
/**
* @package     SP Movie Database
* @copyright   Copyright (C) 2010 - 2016 JoomShaper. All rights reserved.
* @license     GNU General Public License version 2 or later.
*/

defined('_JEXEC') or die('Restricted access!');

jimport('joomla.form.formfield');

class JFormFieldSpmovie extends JFormField
{
	protected $type = 'Spmovie';

	public function getRepeatable()
	{
		return $this->getInput();
	}

	public function getInput()
	{
		$movie_id = $this->value;
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select( array('a.*') );
		$query->from($db->quoteName('#__spmoviedb_movies', 'a'));
		$query->where($db->quoteName('a.spmoviedb_movie_id') . ' = ' . $db->quote($movie_id));
		$db->setQuery($query);
		$movie = $db->loadObject();

		return '<a href="index.php?option=com_spmoviedb&view=movie&id='. $movie_id .'">'. $movie->title .'</a>';
	}
}