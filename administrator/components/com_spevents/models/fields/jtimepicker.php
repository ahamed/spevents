<?php

defined ('_JEXEC') or die('Resticted Aceess');


jimport('joomla.application.component.helper');

class JFormFieldJtimepicker extends JFormField
{
	protected $type = 'Jtimepicker';

	protected function getInput()
	{
        $required  = $this->required ? ' required="required"' : '';
        
        $doc = JFactory::getDocument();
        $doc->addStyleSheet( JURI::base(true) . '/components/com_spevents/assets/css/jquery.timepicker.min.css');
        $doc->addScript( JURI::base(true) . '/components/com_spevents/assets/js/jquery.timepicker.min.js');
        $doc->addScriptDeclaration('
            jQuery(function($){
                $(".timepicker").timepicker({
                    timeFormat: "h:mm p",
                    interval: 30,
                    dynamic: true,
                    dropdown: true,
                    scrollbar: true
                });
            });    
        ');
        return '<input type="text" class="timepicker inputbox" autocomplete="off"'. $required . 'name="' . $this->name .'" value="'. $this->value .'" />';

    }

}
