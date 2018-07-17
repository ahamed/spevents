<?php
/**
* @package     SP Movie Database
* @copyright   Copyright (C) 2010 - 2016 JoomShaper. All rights reserved.
* @license     GNU General Public License version 2 or later.
*/

defined('_JEXEC') or die('Restricted access!');

jimport('joomla.form.formfield');

class JFormFieldSpreview extends FOFFormFieldText implements FOFFormField
{
	protected $type = 'Spreview';

	public function getRepeatable()
	{
		return $this->getInput();
	}

	public function getInput()
	{
		$keyfield = $this->item->getKeyName();
		$id  = $this->item->$keyfield;

		$doc = JFactory::getDocument();
		$doc->addStylesheet(JURI::root(true) . '/components/com_spmoviedb/assets/css/spmoviedb-font.css');

		$ratings = $this->getRating();
		$output = '<div class="movie-rating" style="margin-bottom: 10px;">';

		for ($i=0; $i < $ratings; $i++) { 
			$output .= '<i class="spmoviedb-icon-star" style="color: #ffc000;"></i>';
		}

		for ($i=0; $i < 10-$ratings; $i++) { 
			$output .= '<i class="spmoviedb-icon-star-blank" style="color: #ffc000;"></i>';
		}

		$output .= ' ('. $ratings .')';

		$output .= '</div>';

		$output .= '<div class="movie-review" style="margin-bottom: 10px;">';
		$output .= $this->value;
		$output .= '</div>';

		$output .= '<a href="index.php?option=com_spmoviedb&view=review&id=' . $id . '">'. JText::_('COM_SPMOVIEDB_EDIT_REVIEW') .'</a>';

		return $output;
	}

	protected function getRating()
	{
		$keyfield = $this->item->getKeyName();
		$id  = $this->item->$keyfield;

		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select( array('a.rating') );
		$query->from($db->quoteName('#__spmoviedb_reviews', 'a'));
		$query->where($db->quoteName('a.spmoviedb_review_id') . ' = ' . $db->quote($id));
		$db->setQuery($query);
		$rating = $db->loadResult();

		return $rating;
	}
}