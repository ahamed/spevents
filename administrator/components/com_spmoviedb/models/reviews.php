<?php
/**
* @package     SP Movie Database
* @copyright   Copyright (C) 2010 - 2016 JoomShaper. All rights reserved.
* @license     GNU General Public License version 2 or later.
*/

defined('_JEXEC') or die('Restricted access!');

class SpmoviedbModelReviews extends FOFModel
{
    
	public function buildQuery($overrideLimits = false)
    {
        $db = $this->getDbo();
        $query = parent::buildQuery($overrideLimits = true);

        $status = $this->getState('status', null);

        if( $status != null  )
        {
            $query->where($db->quoteName('enabled') . ' = ' . $db->quote($status));
        }

        $filter_order = $this->getState('filter_order', 'created_on');

        if($filter_order) {
            $filter_order = 'created_on';
        }

        $filter_order_dir = $this->getState('filter_order_Dir', 'DESC');
        $query->order($filter_order . ' ' . $filter_order_dir);

        return $query;
    }
}