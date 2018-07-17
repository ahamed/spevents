<?php
/**
 * @package     SP Movie Databse
 *
 * @copyright   Copyright (C) 2010 - 2016 JoomShaper. All rights reserved.
 * @license     GNU General Public License version 2 or later.
 */

defined('_JEXEC') or die('Restricted Access');
class SpmoviedbControllerMovies extends FOFController
{

	public function __construct($config = array())
	{
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
		$limit 	= $params->get('movies_limit', 12);
		$this->getThisModel()->limit( $limit );
		$this->getThisModel()->limitstart($this->input->getInt('limitstart', 0));
		
		return true;
	}

	public function getModel($name = 'Movies', $prefix = 'SpmoviedbModel', $config = array())
	{
		return parent::getModel($name = 'Movies', $prefix = 'SpmoviedbModel', $config = array());
	}

	public function trailers()
	{
		$model = $this->getModel();
		$input = JFactory::getApplication()->input;
		$id = $input->get('id', 0, 'INT');;

		if(!$id) {
			$output['status'] = false;
			echo json_encode($output);
			die();
		}

		$trailers    = $model->GenerateTrailers($id);
		$movies_info = $model->getMovieById($id);

		$output = array();

		if(count($trailers)) {
			$output['status'] = true;
			$output['content'] = JLayoutHelper::render('movie.trailer', array('trailers'=>$trailers, 'movie_info'=>$movies_info));
		} else {
			$output['status'] = false;
		}

		echo json_encode($output);
		die();
	}
}