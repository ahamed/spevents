<?php
/**
* @package     SP Properties
* @copyright   Copyright (C) 2010 - 2016 JoomShaper. All rights reserved.
* @license     GNU General Public License version 2 or later.
*/

defined('_JEXEC') or die('Restricted access!');

jimport('joomla.form.formfield');
JFormHelper::loadFieldClass('checkboxes');
jimport( 'joomla.application.component.helper' );

class JFormFieldSpfeatures extends JFormField {

      protected $type = 'Spfeatures';
      protected function getInput(){

            $pfeatures  = SppropertyModelProperties::getPfeatures();
            $output  = '';

            $output .= '<fieldset id="' . $this->name . '" class="checkboxes">';

            foreach($pfeatures as $key => $pfeature){

                  $hasChecked = (in_array($pfeature->spproperty_propertyfeature_id, $this->value))? 'checked': '';

                  $output .= '<label for="' . $this->name . $key .'" class="checkbox">';
                        $output .= '<input type="checkbox" id="' . $this->name . $key .'" name="' . $this->name . '[]" value="' . $pfeature->spproperty_propertyfeature_id . '" '. $hasChecked .'>';
                        $output .= $pfeature->title;
                  $output .= '</label>';
            }

            $output .= '</fieldset>';

            return $output;

      }
}