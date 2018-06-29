<?php
defined('_JEXEC') or die;

$doc = JFactory::getDocument();
JHtml::_('behavior.formvalidator');
JHtml::_('behavior.keepalive');
JHtml::_('formbehavior.chosen','select',null,array('disable_search_threshold' => 0));
?>

<form action="<?php echo JRoute::_('index.php?option=com_spevents&view=speaker&layout=edit&id=' . (int) $this->item->id); ?>" name="adminForm" id="adminForm" method="post" class="form-validate">

	<div class="form-horizontal">
		<div class="row-fluid">
			<div class="span8">
				<ul class="nav nav-tabs">
					<li class="active">
						<a href="#basic" data-toggle="tab">Basic*</a>
					</li>
                    <li>
                        <a href="#social" data-toggle="tab">Social</a>
                    </li>
					<li>
						<a href="#options" data-toggle="tab">Options</a>
					</li>
				</ul>
				<div class="tab-content">
					<div id="basic" class="tab-pane active">
						<?php echo $this->form->renderFieldset('basic'); ?>
					</div>
					<div id="social" class="tab-pane">
						<?php echo $this->form->renderFieldset('social'); ?>
					</div>
					<div id="options" class="tab-pane">
						<?php echo $this->form->renderFieldset('options'); ?>
					</div>
				</div>

			</div>
		</div>
	</div>

	<input type="hidden" name="task" value="event.edit" />
	<?php echo JHtml::_('form.token'); ?>
</form>
