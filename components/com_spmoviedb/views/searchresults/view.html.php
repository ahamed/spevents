<?php
/**
 * @package     SP Movie Databse
 *
 * @copyright   Copyright (C) 2010 - 2016 JoomShaper. All rights reserved.
 * @license     GNU General Public License version 2 or later.
 */

defined('_JEXEC') or die('Restricted Access');

class SpmoviedbViewSearchresults extends FOFViewHtml{

	public function display($tpl = null){

		$params  = JComponentHelper::getParams('com_spmoviedb');
		$this->columns = $params->get('search_columns', 4);

		$model = $this->getModel();
		$this->items = $model->getItemList();

		$input = JFactory::getApplication()->input;
		$searchtype = $input->get('type', 'all', 'WORD');

		$model_movie = FOFModel::getAnInstance('Movies', 'SpmoviedbModel');

		if (!count($this->items) && !$this->items) {
			echo '<p class="alert alert-warning">' . JText::_('MOD_SPMOVIEDB_NO_ITEM_FOUND') . '</p>';
			return false;
		}

		foreach ($this->items as $this->item) {
			if (isset($this->item->spmoviedb_celebrity_id) && $this->item->spmoviedb_celebrity_id) {
				$this->item->url = JRoute::_('index.php?option=com_spmoviedb&view=celebrity&id=' . $this->item->spmoviedb_celebrity_id . ':' . $this->item->slug . SpmoviedbHelper::getItemid('celebrities'));

			} elseif(isset($this->item->spmoviedb_movie_id) && $this->item->spmoviedb_movie_id) {
				$this->item->title  = $this->item->title . ' (' . JHTML::date($this->item->release_date, 'Y') . ')';
				$this->item->turls  = $model_movie->GenerateTrailers($this->item->spmoviedb_movie_id);
				$this->item->genres = $model_movie->getGenries($this->item->genres);
				$this->item->url    = JRoute::_('index.php?option=com_spmoviedb&view=movie&id=' . $this->item->spmoviedb_movie_id . ':' . $this->item->slug . SpmoviedbHelper::getItemid('movies'));
			}
		}

		return parent::display($tpl = null);
	}
}