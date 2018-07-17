<?php
/**
 * @package     SP Movie Databse
 *
 * @copyright   Copyright (C) 2010 - 2016 JoomShaper. All rights reserved.
 * @license     GNU General Public License version 2 or later.
 */

defined('_JEXEC') or die('Restricted Access');


$genres 	= $displayData['genres'];
$type 		= (isset($displayData['type']) && $displayData['type']) ? $displayData['type'] : '' ;
$genre_output = '';

foreach ($genres as $key => $genre) {
	$genre->url    = JRoute::_('index.php?option=com_spmoviedb&view=searchresults&searchword=' . $genre->title . '&type=genres'. SpmoviedbHelper::getItemid('movies'));
	if ($type != 'search') {
		$genre_output .= '<a class="spmoviedb-genre-title" href="' . $genre->url . '">' . $genre->title . '</a>' . ', ';
	} else {
		$genre_output .= $genre->title. ', ';
	}
	
}

echo rtrim(trim($genre_output), ',');