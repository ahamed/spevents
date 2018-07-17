<?php
/**
 * @package     SP Movie Databse
 *
 * @copyright   Copyright (C) 2010 - 2016 JoomShaper. All rights reserved.
 * @license     GNU General Public License version 2 or later.
 */

defined('_JEXEC') or die('Restricted Access');

class SpmoviedbViewCelebrities extends FOFViewForm{

	public function display($tpl = null){

		$model = $this->getModel();
		$params = JComponentHelper::getParams('com_spmoviedb');
		$this->columns = $params->get('celebrities_columns', 4);
		
		// Get model
		$this->items = $model->getItemList();
		$this->total_celebrities = $model->getCountCelebrities()->total_celebrities;
		$this->alphabets = array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z');

		foreach ($this->items as &$this->item) {
			$this->item->url = JRoute::_('index.php?option=com_spmoviedb&view=celebrity&id=' . $this->item->spmoviedb_celebrity_id . ':' . $this->item->slug . SpmoviedbHelper::getItemid('celebrities'));
		}

		return parent::display($tpl = null);
	}
}