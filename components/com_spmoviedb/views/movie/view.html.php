<?php
/**
 * @package     SP Movie Databse
 *
 * @copyright   Copyright (C) 2010 - 2016 JoomShaper. All rights reserved.
 * @license     GNU General Public License version 2 or later.
 */

defined('_JEXEC') or die('Restricted Access');

class SpmoviedbViewMovie extends FOFViewHtml{

	public function display($tpl = null){
		// Get model
		$user 	= JFactory::getUser(); 
		$model 	= $this->getModel();
		$input = JFactory::getApplication()->input;	
		
		// get item
		$this->item = $model->getItem();

		// Get Values
		if ($model->validateDate($this->item->release_date)) {
			$this->item->title 		= $this->item->title . ' (' . JHTML::date($this->item->release_date, 'Y') . ')';
		}

		if (!$model->validateDate($this->item->release_date)) {
			$this->item->release_date = ''; 
		}	

		$this->item->genres 	= (isset($this->item->genres) && $this->item->genres) ? $model->getGenries(json_encode($this->item->genres)) : '' ;
		$this->item->directors  = (isset($this->item->directors) && $this->item->directors) ? $model->getCelebrities(json_encode($this->item->directors)) : '' ;
		$this->item->actors 	= (isset($this->item->actors) && $this->item->actors) ? $model->getCelebrities(json_encode($this->item->actors)) : '' ;
		$this->item->turls 		= $model->GenerateTrailers($this->item->spmoviedb_movie_id);
		$this->item->url 		= JRoute::_('index.php?option=com_spmoviedb&view=movie&id=' . $this->item->spmoviedb_movie_id . ':' . $this->item->slug . SpmoviedbHelper::getItemid('movies'));


		//cover image
		$cover_baseurl = basename($this->item->cover_image);
		//generate thumb url
		if (isset($cover_baseurl) && $cover_baseurl) {
			$cover_image = dirname($this->item->cover_image) .  '/_spmedia_thumbs' . '/' . JFile::stripExt($cover_baseurl) .  '.' . JFile::getExt($cover_baseurl);
		}

		if (file_exists($cover_image)) {
			$this->item->cover_image = $cover_image;
		}

		//profile image
		$profile_baseurl = basename($this->item->profile_image);
		//generate thumb url
		if (isset($profile_baseurl) && $profile_baseurl) {
			$profile_image = dirname($this->item->profile_image) .  '/_spmedia_thumbs' . '/' . JFile::stripExt($profile_baseurl) .  '.' . JFile::getExt($profile_baseurl);
		}

		if (file_exists($profile_image)) {
			$this->item->profile_image = $profile_image;
		}

		// generate showtime
		$showtime_decode = json_decode($this->item->show_time);

			if (isset($showtime_decode) && $showtime_decode) {
			$theatre_names 		= $showtime_decode->theatre_name;
			$theatre_locations 	= $showtime_decode->theatre_location;
			$times 				= $showtime_decode->time;
			$ticket_url			= $showtime_decode->ticket_url;

			// Trailers URLS
			$this->item->show_times = array();
			$stkey 		   = 0;
			foreach ($theatre_names as $id => $tname) {
				if ($tname) {
					$this->item->show_times[$stkey] = array(
						'theatre_name' 		=> $theatre_names[$id],
						'theatre_location'	=> $theatre_locations[$id],
						'times' 			=> explode(" | ",$times[$id]),
						'ticket_url'		=> $ticket_url[$id],
					);
					$stkey ++;
				}	
			}
		}	

		$this->myReview = $model->getMyReview($this->item->spmoviedb_movie_id);
		$this->reviews 	= $model->getReviews($this->item->spmoviedb_movie_id);
		$this->ratings 	= $model->getRatings($this->item->spmoviedb_movie_id);

		$this->showLoadMore = false;
		if($model->getTotalReviews($this->item->spmoviedb_movie_id) > count($this->reviews)) {
			$this->showLoadMore = true;
		}

		if (isset($this->item->genres) && $this->item->genres) {		
			//Related movies
			$this->related_movies = $model->getRelated($this->item->genres, $this->item->spmoviedb_movie_id);
			foreach ($this->related_movies as $this->related_movie) {
				$this->related_movie->url 		= JRoute::_('index.php?option=com_spmoviedb&view=movie&id=' . $this->related_movie->spmoviedb_movie_id . ':' . $this->related_movie->slug . SpmoviedbHelper::getItemid('movies'));
				$this->related_movie->ratings 	= $model->getRatings($this->related_movie->spmoviedb_movie_id);
				$this->related_movie->turls 	= $model->GenerateTrailers($this->related_movie->spmoviedb_movie_id);
			}
		}

		$model->hit();

		//Generate Item Meta
		$itemMeta 				= array();
		$itemMeta['title'] 		= $this->item->title;
		
		if(isset($this->item->genres) && count($this->item->genres) && $this->item->genres) {
			$genres = '';
			foreach ($this->item->genres as $this->item->genre) {
				$genres .= $this->item->genre->title . ', ';
			}
			$itemMeta['keywords'] 	= rtrim($genres, ', ');
		}

		$cleanText = $this->item->movie_story;

		$itemMeta['metadesc'] 	= JHtml::_('string.truncate', JFilterOutput::cleanText($cleanText), 155);
		$itemMeta['image'] 		= JURI::base() . $this->item->profile_image;
		SpmoviedbHelper::itemMeta($itemMeta);
	
		return parent::display($tpl = null);
	}

}