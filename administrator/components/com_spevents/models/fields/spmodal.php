<?php

defined ('_JEXEC') or die('Resticted Aceess');

use SpeventsHelper as SP;

jimport('joomla.application.component.helper');

class JFormFieldSpmodal extends JFormField{

	protected $type = 'Spmodal';

	protected function getInput()
    {
        $doc = JFactory::getDocument();
        $doc->addScript( JURI::base(true) . '/components/com_spevents/assets/js/sp-reload-list.js' );
        $doc->addStyleSheet( JURI::base(true) . '/components/com_spevents/assets/css/fontawesome.css' );

        $btn_style = isset($this->element['btn_style']) && $this->element['btn_style'] != '' ? $this->element['btn_style'] : 'btn-primary';

        $html = [];
        $html[] = "<a class='btn btn-small " . $btn_style .  "' data-toggle='modal' role='button' href='#" .  $this->element['modal_id'] . "'><span class='fa fa-plus'></span> " . JText::_( $this->element['button_text']) . "</a>";

        $footer     = [];
        $footer[]   = "<a type='button' class='btn' data-dismiss='modal' aria-hidden='true' onclick='jQuery(\"#" . $this->element['modal_id']  ." iframe\").contents().find(\"#closeBtn\").click();'>" . JText::_('JLIB_HTML_BEHAVIOR_CLOSE') . "</a>";
        $footer[]   =  "<button type='button' class='btn btn-success save' aria-hidden='true'>" . JText::_('JAPPLY') . "</button>";

        $modal_config = [
            'title'         => $this->element['modal_title'],
            'backdrop'      => isset($this->element['backdrop']) && $this->element['backdrop'] != '' ? $this->element['backdrop'] : 'static',
            'keyboard'      => isset($this->element['keyboard']) && $this->element['keyboard'] != '' ? $this->element['keyboard'] : false,
            'closeButton'   => isset($this->element['close_button']) && $this->element['close_button'] != '' ? $this->element['close_button'] : false,
            'url'           => JRoute::_(implode('&', explode(':',$this->element['url']))),
            'height'        => isset($this->element['height']) && $this->element['height'] != '' ? $this->element['height'] : '400px',
            'width'         => isset($this->element['width']) && $this->element['width'] != '' ? $this->element['width'] : '800px',
            'bodyHeight'    => isset($this->element['body_height']) && $this->element['body_height'] != '' ? $this->element['body_height'] : '70',
            'modalWidth'    => isset($this->element['modal_width']) && $this->element['modal_width'] != '' ? $this->element['modal_width'] : '80',
            'footer'        => implode(" ", $footer)
        ];

        $html[] = JHtml::_(
            'bootstrap.renderModal',
            (string) $this->element['modal_id'],
            $modal_config
        );
        
        $script = [];
        $script[] = "jQuery(document).spreloadlist({";
        $script[] = "   clickBtnSelector: '.save',";
        $script[] = "   modalSelector: '#" . $this->element['modal_id'] . "',";
        $script[] = "   triggerBtnSelector: '#applyBtn',";
        $script[] = "   reloadSectionSelector: '#jform_" . $this->element['element'] . "',";
        $script[] = "});";

        $doc->addScriptDeclaration(implode("\n", $script));

        return implode("\n",$html);
        
	}
}
