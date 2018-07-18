<?php

defined ('_JEXEC') or die('Resticted Aceess');

use SpeventsHelper as SP;

jimport('joomla.application.component.helper');

class JFormFieldSprepeat extends JFormField{

    protected $type = 'Sprepeat';
    public $id;
    
    private function renderMediaFields($that, $holder)
    {
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

		// Custom Thumbnail size
		$thumbsize = '300x225';
		if($that->getAttribute('thumbsize') != NULL) {
			$thumbsize	= $that->getAttribute('thumbsize');
        }
        

		if($holder['value']) {
			$html = '<img class="sp-media-preview" src="' . JURI::root(true) . '/' . $holder['value'] . '" alt="" />';
		} else {
			$html  = '<img class="sp-media-preview" alt="" src="' . JUri::root() . "/images/no-preview.jpg" .'">';
		}
        $gr = $this->getRepeatable();

		$html .= '<input class="sp-media-input" type="hidden" name="'. $holder['name'] .'" id="'. $holder['id'] .'" value="'. $holder['value'] .'">';
		$html .= '<a href="#" class="btn btn-primary sp-btn-media-manager" data-id="' . $holder['id'] . '" data-thumbsize="'. strtolower($thumbsize) .'"><i class="fa fa-picture-o"></i> '. JText::_('SPMEDIA_MANAGER_SELECT') .'</a> <a href="#" class="btn btn-danger btn-clear-image"><i class="fa fa-times"></i></a>';		
		return $html;
    }

    private function wrapperOpen()
    {
        $html     = "<div class='repeat' id='sprepeat-" . $this->id .  "'>";
        $button     = "<div class='spevents-row'><button class='btnc spevents-btn-metarial pull-right' title='Add new' id='spevents-add-new-section-" . $this->id . "'><span class='fa fa-plus'></span></button></div><br><br>";
        $html     .= $button;
        $html     .= "<div class='spevents-row spevents-section-container' id='sortable-" . $this->id . "'>";
        return $html;
    }

    private function wrapperClose()
    {
        $html = "</div></div>";
        return $html;

    }

    private function renderTextareaFields($attr, $value)
    {
        $html = "<textarea ";
        $html .= implode(" ", $attr);
        $html .= ">";
        $html .= $value;
        $html .= "</textarea>";
        return $html;
    }

    private function renderListFields($attr, $options,  $value = '')
    {
        $html = "<select ";
        $html .= implode(" ", $attr);
        $html .= ">";
        foreach($options as $key => $option)
        {
            $opt = "<option value='" . $option['value'] . "'" . ($option['value'] == $value ? 'selected' : '') . ">" . $option['text'] . "</option>";
            $html .= $opt;
        }
        $html .= "</select>";
        return $html;
    }

    private function renderCommonFields($attr)
    {
        $html = "<input ";
        $html .= implode(" ", $attr);
        $html .= "/>";
        return $html;
    }

    public function getRepeatable()
    {
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
    
    private function getOptions()
	{
        $options = []; 
        foreach($this->element as $element)
        {
            $json = json_decode(json_encode($element));
            if ($json->{'@attributes'}->type == 'list')
            {
                $xml = $element->xpath('option');
                foreach($xml as $x)
                {
                    $x = json_decode(json_encode($x));
                    $tmp = [];
                    $tmp['value'] = $x->{'@attributes'}->value;
                    $tmp['text'] = $x->{'0'};
                    $options[] = $tmp;    
                }
            }
            
        }
        return $options;
	}

	protected function getInput()
	{
        $doc = JFactory::getDocument();
        $doc->addStyleSheet(JURI::base(true) . '/components/com_spevents/assets/css/fontawesome.css');
        $doc->addStyleSheet(JURI::base(true) . '/components/com_spevents/assets/css/spevents.css');
        $doc->addStyleSheet(JURI::base(true) . '/components/com_spevents/assets/css/sprepeat.css');
        $doc->addStylesheet( JURI::base(true) . '/components/com_spevents/assets/css/spmedia.css' );
        
        $doc->addScript( JURI::base(true) . '/components/com_spevents/assets/js/spmedia.js' );
        $doc->addScript( JURI::base(true) . '/components/com_spevents/assets/js/jquery-ui.js' );
        
        
        $fields     = json_decode(json_encode($this->element))->field;
        $name       = (string)$this->element['name'];
        $this->id         = (string)$this->element['id'];

        if (empty($name))
        {
            JError::raiseError(500, "You must have to use name field in the sprepeat field!");
        }

        if (empty($this->id))
        {
            JError::raiseError(500, 'You must have to use id field in the sprepeat field!');
        }

        $return = $this->wrapperOpen();
        
        if (empty($this->value))
        {
            $return         .= "<div class='spevents-clonable'>";
            $add_close      = "<div class='btn-group pull-right' role='group' aria-label='add close buttons'>";
            $add_close      .= "<a href='javascript:' class='spevents-close btn btn-danger'><span class='fa fa-minus-circle'></span></a>";
            $add_close      .= "<a href='javascript:' class='btn btn-success spevents-add'><span class='fa fa-plus-circle'></span></a>";
            $add_close      .= "</div>";
            $return         .= $add_close;


            foreach($fields as $key => $field)
            {
                
                $label      = isset($field->{'@attributes'}->label) ? JText::_($field->{'@attributes'}->label) : $field->{'@attributes'}->name;
                $star       = (isset($field->{'@attributes'}->required) && $field->{'@attributes'}->required == 'true') ? 
                              "<span class='star'>&nbsp;*</span>" : "";
                $description= isset($field->{'@attributes'}->description) ? JText::_($field->{'@attributes'}->description) : ''; 
                $inputs     = "";
                $inputs     = "<div class='control-group'>";
                $inputs     .= "<div class='control-label'>";
                $inputs     .= "<label id='jform_" . $field->{'@attributes'}->name . "-lbl' title='" . $description . "' >" . $label . $star .                          "</label></div>"; 
                $inputs     .= "<div class='controls'>";
                
                $type       = $field->{'@attributes'}->type;
                $attr       = [];
                $attr[]     = "name='jform[" . $name ."][" . $name. "0" ."][". $field->{'@attributes'}->name ."]'";
                $attr[]     = "id='jform-" . $name . "-" . $name . "0-" . $field->{'@attributes'}->name . "'"; 
                $attr[]     = "class='inputbox'";
                $attr[]     = isset($field->{'@attributes'}->required) ? "required='required'" : "";


                switch ($type)
                {
                    case 'media':
                        $holder = [];
                        $holder['value']    = $field_value;
                        $holder['name']     = "jform[" . $name ."][" . $name . "0" ."][". $field->{'@attributes'}->name ."]";
                        $holder['id']       = "jform-" . $name . "-" . $name . "0-" . $field->{'@attributes'}->name; 
                        $inputs             .= $this->renderMediaFields($this, $holder);
                        break;
                    case 'textarea': 
                    case 'editor': 
                        $field_value    = "";
                        $inputs         .= $this->renderTextareaFields($attr, $field_value);
                        break;
                    case 'list':
                        $options    = $this->getOptions();
                        $inputs     .= $this->renderListFields($attr, $options, $field_value);
                        break;
                    default: 
                        $attr[]         = "type='" . $type . "'";
                        $attr[]         = "value='" . htmlspecialchars($field_value) . "'";
                        $inputs         .= $this->renderCommonFields($attr);
                        break;
                }

                $inputs     .= "<br>";
                $inputs     .= "</div>";
                $inputs     .= "</div>";
                $return     .= $inputs;
            }
            $return .= "</div>";
        }
        else 
        {
            $index = 0;
            foreach ($this->value as $i => $value)
            {
                $return         .= "<div class='spevents-clonable sortable'>";
                $add_close      = "<div class='btn-group pull-right' role='group' aria-label='add close buttons'>";
                $add_close      .= "<a href='javascript:' class='spevents-close btn btn-danger'><span class='fa fa-minus-circle'></span></a>";
                $add_close      .= "<a href='javascript:' class='btn btn-success spevents-add'><span class='fa fa-plus-circle'></span></a>";
                $add_close      .= "</div>";
                $return         .= $add_close;

                foreach($fields as $key => $field)
                {
                    $field_value = $value[$field->{'@attributes'}->name];
                    
                    $label      = isset($field->{'@attributes'}->label) ? JText::_($field->{'@attributes'}->label) : $field->{'@attributes'}->name;
                    $star       = (isset($field->{'@attributes'}->required) && $field->{'@attributes'}->required == 'true') ? 
                                  "<span class='star'>&nbsp;*</span>" : "";
                    $description= isset($field->{'@attributes'}->description) ? JText::_($field->{'@attributes'}->description) : ''; 

                    $inputs     = "";
                    $inputs     = "<div class='control-group'>";
                    $inputs     .= "<div class='control-label'>";
                    $inputs     .= "<label id='jform_" . $field->{'@attributes'}->name . "-lbl' title='" . $description .  "'>" . $label . $star .                       "</label></div>"; 
                    $inputs     .= "<div class='controls'>";
                    
                    $type       = $field->{'@attributes'}->type;
                    $attr       = [];
                    $attr[]     = "name='jform[" . $name ."][" . $name. $index ."][". $field->{'@attributes'}->name ."]'";
                    $attr[]     = "id='jform-" . $name . "-" . $name . $index . "-" . $field->{'@attributes'}->name . "'"; 
                    $attr[]     = "class='inputbox'";
                    $attr[]     = isset($field->{'@attributes'}->required) ? "required='required'" : "";
                    
                    switch ($type)
                    {
                        case 'media':
                            $holder = [];
                            $holder['value']    = $field_value;
                            $holder['name']     = "jform[" . $name ."][" . $name . $index ."][". $field->{'@attributes'}->name ."]";
                            $holder['id']       = "jform-" . $name . "-" . $name . $index . "-" . $field->{'@attributes'}->name; 
                            $inputs .= $this->renderMediaFields($this, $holder);
                            break;
                        case 'textarea': 
                        case 'editor': 
                            $inputs .= $this->renderTextareaFields($attr, htmlspecialchars($field_value));
                        break;
                        case 'list':
                            $options    = $this->getOptions();
                            $inputs     .= $this->renderListFields($attr, $options, $field_value);
                            break;
                        default: 
                            $attr[]     = "type='" . $type . "'";
                            $attr[]     = "value='" . htmlspecialchars($field_value) . "'";
                            $inputs     .= $this->renderCommonFields($attr);
                            break;
                    }
                    
                    
                    $inputs     .= "<br>";
                    $inputs     .= "</div>";
                    $inputs     .= "</div>";
                    $return     .= $inputs;    
                }
                $index++;
                $return         .= "</div>";
            }
        }

        $doc->addStyleDeclaration('
            .repeat {
                min-width: 100px;
                min-height: 100px;
                padding: 20px;
            }
            .spevents-clonable {
                margin-top: 12px;
                background: #f9f9f9;
                padding: 20px;
                cursor: move;
            }

            .ui-sortable-helper {
                -ms-transform: rotate(3deg); /* IE 9 */
                -webkit-transform: rotate(3deg); /* Safari */
                transform: rotate(3deg);

                -webkit-box-shadow: 2px 2px 10px 0px rgba(92,92,92,0.59);
                -moz-box-shadow: 2px 2px 10px 0px rgba(92,92,92,0.59);
                box-shadow: 2px 2px 10px 0px rgba(92,92,92,0.59);
            }

            .ui-sortable-placeholder {
                background: #07575B;
                border: 3px dashed #C4DFE6;
                visibility: visible!important;
            }

            .spevents-preview {
                width: 100px;
                height: 100px;
                background: #eee;
                margin-right: 20px;
            }

            .spevents-btn-metarial:focus {
                outline: none;
            }
        ');

        $doc->addScript(JUri::base(true). "/components/com_spevents/assets/js/sprepeat.js");
        
        $doc->addScriptDeclaration("
            jQuery(document).sprepeat({
                base_url: '" . JUri::root() . "',
                common_name: '" . $name . "',
                id: '" . $this->id . "'
            });

            jQuery(document).spsortable({
                id: '#sprepeat-" . $this->id . "', 
                items: '.spevents-clonable',
                common_id: '#sprepeat-" . $this->id . "',
                common_name: '" . $name . "'
            });
        ");
        
        $return .= $this->wrapperClose();
        
        
        return $return;
    }
}
