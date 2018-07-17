<?php
/**
 * @package     SP Movie Databse
 *
 * @copyright   Copyright (C) 2010 - 2016 JoomShaper. All rights reserved.
 * @license     GNU General Public License version 2 or later.
 */

defined('_JEXEC') or die('Restricted Access');

jimport( 'joomla.application.component.helper' );

class SpmoviedbControllerReview extends FOFController {

	public function __construct($config = array())
	{
		parent::__construct($config);
	}

	public function getModel($name = 'Review', $prefix = 'SpmoviedbModel', $config = array())
	{
		return parent::getModel($name, $prefix, $config);
	}
	
	public function add_review()
	{
		$model = $this->getModel();
		$user = JFactory::getUser();
		$input = JFactory::getApplication()->input;
		$output = array();

		if(!$user->id) {
			$output['status'] = false;
			$output['content'] = JText::_('COM_SPMOVIEDB_LOGIN_TO_REVIEW');
			echo json_encode($output);
			die();
		}

		$movie_id 			= $input->post->get('movie_id', 0, 'INT');
		$review 			= $input->post->get('review', NULL, 'STRING');
		$rating 			= $input->post->get('rating', 0, 'INT');
		$existing_review_id = $input->post->get('review_id', 0, 'INT');
		
		$output['status'] = false;

		if($rating && $movie_id) {

			if($existing_review_id) {
				$model->updateReview($review, $rating, $existing_review_id);
				$review_output = $model->getReview($existing_review_id);
				$output['update'] = true;
				
			} else {
				$review_id = $model->storeReview($movie_id, $review, $rating);
				$review_output = $model->getReview($review_id);
				$output['update'] = false;
			}

			$output['content'] = JLayoutHelper::render('review.review', array( 'review'=>$review_output));
			$output['ratings'] = $model->getRatings($movie_id);;
			$output['status'] = true;
		}

		echo json_encode($output);
		die();
	}

	public function reviews()
	{

		$params = JComponentHelper::getParams('com_spmoviedb');
		$model = $this->getModel();
		$user = JFactory::getUser();
		$input = JFactory::getApplication()->input;
		$start 	= $input->post->get('start', 0, 'INT');
		$limit 	= $params->get('review_limit', 12);
		$movieModel = $this->getModel('Movies', 'SpmoviedbModel');

		$movie_id 		= $input->post->get('movie_id', 0, 'INT');
		$reviews 		= $movieModel->getReviews($movie_id);
		$total 			= $movieModel->getTotalReviews($movie_id);

		$output = array();
		$output['status']  = false;
		$output['content'] = '';

		// Load More
		if($total > ($limit + $start)) {
			$output['loadmore'] 	= true;
		} else {
			$output['loadmore'] 	= false;	
		}

		foreach ($reviews as $key => $review) {
			$output['status']   = true;
			$output['content'] .= JLayoutHelper::render('review.review', array( 'review'=>$review));
		}

		echo json_encode($output);
		die();
	}
}