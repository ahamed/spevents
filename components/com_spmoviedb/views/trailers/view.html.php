<?php
/**
 * @package     SP Movie Databse
 * @copyright   Copyright (C) 2010 - 2016 JoomShaper. All rights reserved.
 * @license     GNU General Public License version 2 or later.
 */

defined('_JEXEC') or die('Restricted Access');

class SpmoviedbViewTrailers extends FOFViewHtml{

	public function display($tpl = null){

		$params  = JComponentHelper::getParams('com_spmoviedb');
		$this->columns = $params->get('trailer_columns', 4);

		$model = $this->getModel();
		$this->items = $model->getItemList();

		$model_movie = FOFModel::getAnInstance('Movies', 'SpmoviedbModel');

		foreach ($this->items as $this->item) {
			$this->item->title 		= $this->item->title . ' (' . JHTML::date($this->item->release_date, 'Y') . ')';
			$this->item->url 		= JRoute::_('index.php?option=com_spmoviedb&view=movie&id=' . $this->item->spmoviedb_movie_id . ':' . $this->item->slug . SpmoviedbHelper::getItemid('movies'));
			$this->item->genres 	= $model_movie->getGenries($this->item->genres);
			$this->item->turls 		= $model_movie->GenerateTrailers($this->item->spmoviedb_movie_id);
		}

		return parent::display($tpl = null);
	}
}