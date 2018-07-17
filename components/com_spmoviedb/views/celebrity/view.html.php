<?php
/**
 * @package     SP Movie Databse
 *
 * @copyright   Copyright (C) 2010 - 2016 JoomShaper. All rights reserved.
 * @license     GNU General Public License version 2 or later.
 */

defined('_JEXEC') or die('Restricted Access');

class SpmoviedbViewCelebrities extends FOFViewHtml{

	public function display($tpl = null){
		// Get model
		$model = $this->getModel();
		// get item
		$this->item = $model->getItem();

		//Load movie Model
		$movie_model = FOFModel::getTmpInstance('Movies', 'SpmoviedbModel');
		//get celebrities latest movies
		$this->item->celebrity_movies = $model->getCelebrityMoviesbyId($this->item->spmoviedb_celebrity_id, 5);
		
		foreach ($this->item->celebrity_movies as $this->item->celebrity_movie) {
			$this->item->celebrity_movie->ratings 	= $movie_model->getRatings($this->item->celebrity_movie->spmoviedb_movie_id);
			$this->item->celebrity_movie->genres 	= $movie_model->getGenries($this->item->celebrity_movie->genres);

			$this->item->celebrity_movie->murl = JRoute::_('index.php?option=com_spmoviedb&view=movie&id=' . $this->item->celebrity_movie->spmoviedb_movie_id . ':' . $this->item->celebrity_movie->slug . SpmoviedbHelper::getItemid('movies'));
		}

		// Get actor_trailers
		$this->item->actor_trailers = $model->getCelebrityMoviesbyId($this->item->spmoviedb_celebrity_id, 4);
		foreach ($this->item->actor_trailers as $this->item->actor_trailer) {
			$this->item->actor_trailer->title 	= $this->item->actor_trailer->title . ' (' . JHTML::date($this->item->actor_trailer->release_date, 'Y') . ')';
			$this->item->actor_trailer->turls 	= $movie_model->GenerateTrailers($this->item->actor_trailer->spmoviedb_movie_id)[0];

			$this->item->actor_trailer->murl = JRoute::_('index.php?option=com_spmoviedb&view=movie&id=' . $this->item->actor_trailer->spmoviedb_movie_id . ':' . $this->item->actor_trailer->slug . SpmoviedbHelper::getItemid('movies'));
			$this->item->actor_trailer->genres 	= $movie_model->getGenries($this->item->actor_trailer->genres);
		}

		$this->item->url 		= JRoute::_('index.php?option=com_spmoviedb&view=movie&id=' . $this->item->spmoviedb_celebrity_id . ':' . $this->item->slug . SpmoviedbHelper::getItemid('celebrities'));	
	
		$model->hit();
		
		//Generate Item Meta
		$itemMeta 				= array();
		$itemMeta['title'] 		= $this->item->title;
		
		if(isset($this->item->designation) && count($this->item->designation)) {
			$itemMeta['keywords'] 	= rtrim($this->item->designation, ', ');
		}

		$cleanText = $this->item->biography;

		$itemMeta['metadesc'] 	= JHtml::_('string.truncate', JFilterOutput::cleanText($cleanText), 155);
		$itemMeta['image'] 		= JURI::base() . $this->item->profile_image;
		SpmoviedbHelper::itemMeta($itemMeta);
	
		return parent::display($tpl = null);
	}
}