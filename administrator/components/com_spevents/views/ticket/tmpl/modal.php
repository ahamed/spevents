<?php

defined('_JEXEC') or die;

JHtml::_('bootstrap.tooltip', '.hasTooltip', array('placement' => 'bottom'));
?>
<button id="applyBtn" type="button" class="hidden" onclick="Joomla.submitbutton('ticket.apply');"></button>
<button id="closeBtn" type="button" class="hidden" onclick="Joomla.submitbutton('ticket.cancel');"></button>



<div class="container-popup">
	<?php $this->setLayout('edit'); ?>
	<?php echo $this->loadTemplate(); ?>
</div>


