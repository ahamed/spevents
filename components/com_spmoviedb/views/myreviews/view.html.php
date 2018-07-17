<?php
/**
 * @package     SP Movie Databse
 *
 * @copyright   Copyright (C) 2010 - 2016 JoomShaper. All rights reserved.
 * @license     GNU General Public License version 2 or later.
 */

defined('_JEXEC') or die('Restricted Access');

class SpmoviedbViewMyreviews extends FOFViewHtml{

	public function display($tpl = null){
		$model = $this->getModel();
		$this->items = $model->getItemList();
		$user = JFactory::getUser();
		
		if($user->guest) {
			echo '<p class="alert alert-danger">' . JText::_('COM_SPMOVIEDB_MY_REVIEWS_LOGIN') . '</p>';
			return false;	
		}

		$this->myreviews = $model->getMyReviews( $user->id );
		if (empty($this->myreviews)) {
			echo '<p class="alert alert-warning">' . JText::_('COM_SPMOVIEDB_EMPTY_REVIEWS') . '</p>';
			return false;
		}

		return parent::display($tpl = null);
	}
}