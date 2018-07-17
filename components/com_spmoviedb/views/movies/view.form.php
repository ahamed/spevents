<?php
/**
 * @package     SP Movie Databse
 *
 * @copyright   Copyright (C) 2010 - 2016 JoomShaper. All rights reserved.
 * @license     GNU General Public License version 2 or later.
 */

defined('_JEXEC') or die('Restricted Access');

class SpmoviedbViewMovies extends FOFViewForm{

	public function display($tpl = null){

		$params  = JComponentHelper::getParams('com_spmoviedb');
		$this->columns = $params->get('movie_columns', 4);

		$model = $this->getModel();
		$this->items 		= $model->getItemList();
		$this->movies_years = $model->getMoviesYear();

		$this->alphabets = array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z');

		foreach ($this->items as $this->item) {
			$this->item->url 		= JRoute::_('index.php?option=com_spmoviedb&view=movie&id=' . $this->item->spmoviedb_movie_id . ':' . $this->item->slug . SpmoviedbHelper::getItemid('movies'));
			$this->item->genres 	= (isset($this->item->genres) && $this->item->genres) ? $model->getGenries($this->item->genres) : '' ;
			$this->item->ratings 	= $model->getRatings($this->item->spmoviedb_movie_id);
			$this->item->turls 		= $model->GenerateTrailers($this->item->spmoviedb_movie_id);
		}

		return parent::display($tpl = null);
	}
}