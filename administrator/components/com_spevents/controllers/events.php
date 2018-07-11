<?php
defined('_JEXEC') or die;


use Joomla\Utilities\ArrayHelper;

class SpeventsControllerEvents extends JControllerAdmin
{

	public function getModel($name = 'Event', $prefix = 'SpeventsModel', $config = array('ignore_request' => true))
	{
		$model = parent::getModel($name, $prefix, $config);
		return $model;
	}

	public function taskTest()
	{
		$data = ["test" => "ok"];
		$app = JFactory::getApplication();
        $app->setHeader('Content-Type', 'application/json', true)
            ->sendHeaders();
        $data =  json_encode($data);
		$app->close();
		SpeventsHelper::___($data);
		return $data;
	}
}

