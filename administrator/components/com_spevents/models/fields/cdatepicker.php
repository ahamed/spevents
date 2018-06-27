<?php

defined ('_JEXEC') or die('Resticted Aceess');


jimport('joomla.application.component.helper');

class JFormFieldCdatepicker extends JFormField
{
	protected $type = 'Cdatepicker';

	protected function getInput()
	{
        $required  = $this->required ? ' required aria-required="true"' : '';
        
        $doc = JFactory::getDocument();
        $doc->addStyleSheet( JURI::base(true) . '/components/com_spevents/assets/css/jquery.datepick.css');
        $doc->addScript( JURI::base(true) . '/components/com_spevents/assets/js/jquery.plugin.min.js');
        $doc->addScript( JURI::base(true) . '/components/com_spevents/assets/js/jquery.datepick.js');
        $doc->addScriptDeclaration('
            jQuery(function($){
                $(".datepicker").datepick({
                    multiSelect:1000,
                    monthsToShow:2,
                    showAnim:"fadeIn",
                    showSpeed:"fast",
                    dateFormat:"yyyy-mm-dd"
                    
                });
            });    
        ');


        $doc->addStyleDeclaration('
            .datepick-popup{
                position: relative;
                z-index: 100000;
            }
        ');
        return '<input type="text" class="datepicker inputbox" autocomplete="off" name="' . $this->name .'" value="'. $this->value .'" />';

    }

}
