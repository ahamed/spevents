<?php
defined('_JEXEC') or die;

$doc = JFactory::getDocument();
JHtml::_('behavior.formvalidator');
JHtml::_('behavior.keepalive');
JHtml::_('formbehavior.chosen','select',null,array('disable_search_threshold' => 0));
?>

<form action="<?php echo JRoute::_('index.php?option=com_spevents&view=tag&layout=edit&id=' . (int) $this->item->id); ?>" name="adminForm" id="adminForm" method="post" class="form-validate">

	<div class="form-horizontal">
		<div class="row-fluid">
			<div class="span8">
				<?php echo $this->form->renderFieldset('basic'); ?>
			</div>
			<div class="span4">
				<?php echo $this->form->renderFieldset('options'); ?>
			</div>
		</div>
	</div>

	<input type="hidden" name="task" value="tag.edit" />
	<?php echo JHtml::_('form.token'); ?>
</form>
