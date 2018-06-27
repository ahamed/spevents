<?php

/**
 * @package     SP Property
 *
 * @copyright   Copyright (C) 2010 - 2016 JoomShaper. All rights reserved.
 * @license     GNU General Public License version 2 or later.
 */

defined('JPATH_PLATFORM') or die;

class JFormFieldSpcategory extends JFormField
{
	protected $type = 'Spcategory';

	protected $static;

	protected $repeatable;

	/**
	 * Method to get certain otherwise inaccessible properties from the form field object.
	 *
	 * @param   string  $name  The property name for which to the the value.
	 *
	 * @return  mixed  The property value or null.
	 *
	 * @since   2.0
	 */
	public function __get($name)
	{
		switch ($name)
		{
			case 'static':
				if (empty($this->static))
				{
					$this->static = $this->getStatic();
				}

				return $this->static;
				break;

			case 'repeatable':
				if (empty($this->repeatable))
				{
					$this->repeatable = $this->getRepeatable();
				}

				return $this->repeatable;
				break;

			default:
				return parent::__get($name);
		}
	}

	/**
	 * Get the rendering of this field type for static display, e.g. in a single
	 * item view (typically a "read" task).
	 *
	 * @since 2.0
	 *
	 * @return  string  The field HTML
	 */
	public function getStatic()
	{
		return $this->getInput();
	}

	/**
	 * Get the rendering of this field type for a repeatable (grid) display,
	 * e.g. in a view listing many item (typically a "browse" task)
	 *
	 * @since 2.0
	 *
	 * @return  string  The field HTML
	 */
	public function getRepeatable()
	{
		return $this->getInput();
	}

	public function getInput()
	{

		$cat_id = $this->value;

		if($cat_id) {
			//$property_id = implode(',', json_decode($property_ids));
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select( array('a.*') );
		    $query->from($db->quoteName('#__spproperty_categories', 'a'));
		    //$query->where($db->quoteName('a.spproperty_property_id')." IN (" . $property_ids . ")");
		    $query->where($db->quoteName('a.spproperty_category_id')." = " . $cat_id);
		    $db->setQuery($query);
			$category = $db->loadObject();

			$output = '';

			if ($category) {
				$output .= '<a href="index.php?option=com_spproperty&view=category&id=' . $category->spproperty_category_id . '">' . $category->title . '</a>';
			}

			return $output;
		}

		return '....';
	}

}
