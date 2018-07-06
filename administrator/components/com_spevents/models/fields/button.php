<?php

defined ('_JEXEC') or die('Resticted Aceess');


jimport('joomla.application.component.helper');

class JFormFieldButton extends JFormField
{
	protected $type = 'Button';

	protected function getInput()
	{
        $name = $this->name;
        $class = $this->class;
        $text = (string)$this->element['text'];
        $id = $this->id;

        return '<button id="' . $id . '" class="' . $class . '">'. $text .'</button>';

    }

}
