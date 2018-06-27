<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_spevents
 *
 * @license     MIT
 */

defined('_JEXEC') or die;
if(file_exists(__DIR__.'/vendor/autoload.php')){
  include __DIR__.'/vendor/autoload.php';
}

$controller = JControllerLegacy::getInstance('Spevents');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();
