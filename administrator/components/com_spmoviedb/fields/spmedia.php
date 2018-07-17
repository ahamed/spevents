<?php
/**
* @package     SP Movie Database
* @copyright   Copyright (C) 2010 - 2016 JoomShaper. All rights reserved.
* @license     GNU General Public License version 2 or later.
*/

defined('_JEXEC') or die('Restricted access!');

jimport('joomla.form.formfield');

class JFormFieldSpmedia extends JFormField
{
	protected $type = 'Spmedia';

	protected function getInput() {

		$lang = JFactory::getLanguage();
		$lang->load('com_spmoviedb', JPATH_ADMINISTRATOR, $lang->getName(), true);

		JText::script('SPMEDIA_MANAGER');
		JText::script('SPMEDIA_MANAGER_UPLOAD_FILE');
		JText::script('SPMEDIA_MANAGER_CLOSE');
		JText::script('SPMEDIA_MANAGER_INSERT');
		JText::script('SPMEDIA_MANAGER_SEARCH');
		JText::script('SPMEDIA_MANAGER_CANCEL');
		JText::script('SPMEDIA_MANAGER_DELETE');
		JText::script('SPMEDIA_MANAGER_CONFIRM_DELETE');
		JText::script('SPMEDIA_MANAGER_LOAD_MORE');
		JText::script('SPMEDIA_MANAGER_UNSUPPORTED_FORMAT');
		JText::script('SPMEDIA_MANAGER_BROWSE_MEDIA');
		JText::script('SPMEDIA_MANAGER_BROWSE_FOLDERS');

		JHtml::_('jquery.framework');

		$doc = JFactory::getDocument();
		$doc->addStylesheet( JURI::base(true) . '/components/com_spmoviedb/assets/css/font-awesome.min.css' );
		$doc->addStylesheet( JURI::base(true) . '/components/com_spmoviedb/assets/css/spmedia.css' );
		$doc->addScript( JURI::base(true) . '/components/com_spmoviedb/assets/js/spmedia.js' );

		// Custom Thumbnail size
		$thumbsize = '300x225';
		if($this->getAttribute('thumbsize') != NULL) {
			$thumbsize	= $this->getAttribute('thumbsize');
		}

		if($this->value) {
			$html = '<img class="sp-media-preview" src="' . JURI::root(true) . '/' . $this->value . '" alt="" />';
		} else {
			$html  = '<img class="sp-media-preview no-image" alt="">';
		}
		
		$html .= '<input class="sp-media-input" type="hidden" name="'. $this->name .'" id="'. $this->id .'" value="'. $this->value .'">';
		$html .= '<a href="#" class="btn btn-primary sp-btn-media-manager" data-id="' . $this->id . '" data-thumbsize="'. strtolower($thumbsize) .'"><i class="fa fa-picture-o"></i> '. JText::_('SPMEDIA_MANAGER_SELECT') .'</a> <a href="#" class="btn btn-danger btn-clear-image"><i class="fa fa-times"></i></a>';		

		return $html;
	}

	public function getRepeatable(){

		$path = $this->value;

		if($path && !(is_numeric($path))) {
			$thumb = dirname($path) . '/_spmedia_thumbs/' . basename($path);

			if(file_exists(JPATH_ROOT . '/' . $thumb)) {
				$image = '<img src="'. JURI::root(true) . '/' . $thumb .'">';
			} else {	
				$image = '<img src="'. JURI::root(true) . '/' . $path .'">';
			}

			return $image;
		}

		return '';
	}
}
