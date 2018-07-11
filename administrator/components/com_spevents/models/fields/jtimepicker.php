<?php

defined ('_JEXEC') or die('Resticted Aceess');


jimport('joomla.application.component.helper');

class JFormFieldJtimepicker extends JFormField
{
	protected $type = 'Jtimepicker';

	protected function getInput()
	{
        $required  = $this->required ? ' required="required"' : '';

        if (isset($this->element['interval']) && !empty((string)$this->element['interval']))
        {   
            $interval = (string)$this->element['interval'];
        }
        else 
        {
            $interval = "30";
        }
        
        $doc = JFactory::getDocument();
        $doc->addStyleSheet( JURI::base(true) . '/components/com_spevents/assets/css/jquery.timepicker.min.css');
        $doc->addScript( JURI::base(true) . '/components/com_spevents/assets/js/jquery.timepicker.min.js');
        $doc->addScriptDeclaration('
            jQuery(function($){
                $(".timepicker").timepicker({
                    timeFormat: "H:mm:ss",
                    interval: ' . $interval . ',
                    dynamic: true,
                    dropdown: true,
                    scrollbar: true
                });
            });    
        ');
        $doc->addStyleDeclaration('
            .ui-timepicker-container{
                z-index: 9999!important;
            }
        ');
        return '<input type="text" class="timepicker inputbox" autocomplete="off"'. $required . 'name="' . $this->name .'" value="'. $this->value .'" />';

    }

}
