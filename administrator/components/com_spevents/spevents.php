<?php

/**
 * @package     Joomla.Administrator
 * @subpackage  com_spevents
 *
 * @license     MIT
 */
defined('_JEXEC') or die;
if(file_exists(JPATH_COMPONENT.'/vendor/autoload.php')){
  include JPATH_COMPONENT.'/vendor/autoload.php';
}

if(!JFactory::getUser()->authorise('core.manage','com_spevents')){
  return JError::raiseWarning(404,JText::_('JERROR_ALERTNOAUTHOR'));
}
if(file_exists(JPATH_COMPONENT.'/helpers/spevents.php')){
  JLoader::register('SpeventsHelper', JPATH_COMPONENT . '/helpers/spevents.php');
}

// Execute the task.
$controller=JControllerLegacy::getInstance('Spevents');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();
