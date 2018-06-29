<?php
/**
* @package com_spmedical
* @author JoomShaper http://www.joomshaper.com
* @copyright Copyright (c) 2010 - 2018 JoomShaper
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/

// No Direct Access
defined ('_JEXEC') or die('Resticted Aceess');

$doc = JFactory::getDocument();
JHtml::_('behavior.formvalidator');
JHtml::_('behavior.keepalive');
JHtml::_('formbehavior.chosen', 'select', null, array('disable_search_threshold' => 0 ));


?>
<form action="<?php echo JRoute::_('index.php?option=com_spmedical&layout=edit&id=' . (int) $this->item->id); ?>"
  method="post" name="adminForm" id="adminForm" class="form-validate">

    <div class="form-horizontal">
      <div class="row-fluid">
        <div class="span9">
          <?php echo $this->form->renderFieldset('basic'); ?>
        </div>
        <div class="span3">
          <fieldset class="form-vertical">
            <?php echo $this->form->renderFieldset('sidebar'); ?>
          </fieldset>
        </div>
      </div>
    </div>

  <input type="hidden" name="task" value="course.edit" />
  <?php echo JHtml::_('form.token'); ?>
</form>
