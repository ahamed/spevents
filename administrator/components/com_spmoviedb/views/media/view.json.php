<?php
/**
 * @package     SP Movie Database
 *
 * @copyright   Copyright (C) 2010 - 2016 JoomShaper. All rights reserved.
 * @license     GNU General Public License version 2 or later.
 */

defined('_JEXEC') or die();

class SpmoviedbViewMedia extends FOFView
{

	function display($tpl = null)
    {
    	$input 			= JFactory::getApplication()->input;
        $layout         = $input->get('layout', 'browse', 'STRING');
        $this->date 	= $input->post->get('date', NULL, 'STRING');
        $this->start 	= $input->post->get('start', 0, 'INT');
        $this->search   = $input->post->get('search', NULL, 'STRING');
        $this->limit 	= 18;

    	$model 			= $this->getModel();

        if($layout == 'browse') {
            $this->items    = $model->getItems();
            $this->filters  = $model->getDateFilters($this->date, $this->search);
            $this->total    = $model->getTotalMedia($this->date, $this->search);
        } else {
            $this->media = $model->getFolders();
        }

    	parent::display($tpl);
    }
}