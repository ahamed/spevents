<?php
/**
 * @package     SP Movie Databse
 *
 * @copyright   Copyright (C) 2010 - 2016 JoomShaper. All rights reserved.
 * @license     GNU General Public License version 2 or later.
 */

defined('_JEXEC') or die('Restricted Access');

class SpmoviedbControllerTrailers extends FOFController{

	public function __construct($config = array())
	{
		$config['table'] = 'movies';
		parent::__construct($config);
	}


	public function display($cachable = false, $urlparams = false, $tpl = null){
		$cachable = true;
		if (!is_array($urlparams))
		{
			$urlparams = [];
		}
		$additionalParams = array(
			'catid' => 'INT',
			'id' => 'INT',
			'cid' => 'ARRAY',
			'year' => 'INT',
			'month' => 'INT',
			'alphaindex' => 'STRING',
			'yearindex' => 'STRING',
			'limit' => 'UINT',
			'limitstart' => 'UINT',
			'showall' => 'INT',
			'return' => 'BASE64',
			'filter' => 'STRING',
			'filter_order' => 'CMD',
			'filter_order_Dir' => 'CMD',
			'filter-search' => 'STRING',
			'print' => 'BOOLEAN',
			'lang' => 'CMD',
			'Itemid' => 'INT');

		$urlparams = array_merge($additionalParams, $urlparams);
		parent::display($cachable, $urlparams, $tpl);
	}

	public function onBeforeBrowse()
	{

		$params = JComponentHelper::getParams('com_spmoviedb');
		$limit 	= $params->get('trailer_limit', 12);
		$this->getThisModel()->limit( $limit );
		$this->getThisModel()->limitstart($this->input->getInt('limitstart', 0));
		
		return true;
	}
}