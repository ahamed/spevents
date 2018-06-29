<?php
defined('_JEXEC') or die;

$doc = JFactory::getDocument();
JHtml::_('behavior.formvalidator');
JHtml::_('behavior.keepalive');
JHtml::_('formbehavior.chosen','select',null,array('disable_search_threshold' => 0));
?>

<form action="<?php echo JRoute::_('index.php?option=com_spevents&layout=edit&id=' . (int) $this->item->id); ?>" name="adminForm" id="adminForm" method="post" class="form-validate">

	<div class="form-horizontal">
		<div class="row-fluid">
			<div class="span8">
				<ul class="nav nav-tabs">
					<li class="active">
						<a href="#basic" data-toggle="tab">Basic*</a>
					</li>
					<li>
						<a href="#dateTime" data-toggle="tab">Date Time*</a>
					</li>
                    <li>
                        <a href="#recurring" data-toggle="tab">Repeat Event</a>
                    </li>
                    <li>
                        <a href="#registration" data-toggle="tab">Event Registration</a>
					</li>
					<li>
                        <a href="#gallery" data-toggle="tab">Gallery</a>
                    </li>
                    <li>
                        <a href="#social" data-toggle="tab">Social</a>
                    </li>
					<li>
						<a href="#options" data-toggle="tab">Options</a>
					</li>
					<li>
						<a href="#settings" data-toggle="tab">Frontend Settings</a>
					</li>
				</ul>
				<div class="tab-content">
					<div id="basic" class="tab-pane active">
						<?php echo $this->form->renderFieldset('basic'); ?>
					</div>
					<div id="dateTime" class="tab-pane">
						<?php echo $this->form->renderFieldset('date-time'); ?>
					</div>
					<div id="recurring" class="tab-pane">
						<?php echo $this->form->renderFieldset('repeat'); ?>
					</div>
					<div id="registration" class="tab-pane">
						<?php echo $this->form->renderFieldset('registration'); ?>
					</div>
					<div id="gallery" class="tab-pane">
						<?php echo $this->form->renderFieldset('gallery'); ?>
					</div>
					<div id="social" class="tab-pane">
						<?php echo $this->form->renderFieldset('social'); ?>
					</div>
					<div id="options" class="tab-pane">
						<?php echo $this->form->renderFieldset('options'); ?>
					</div>
					<div id="ticket" class="tab-pane">
						<?php echo $this->form->renderFieldset('ticket'); ?>
					</div>
					<div id="settings" class="tab-pane">
                        <div class="span4">
                            <h4>Sharing options</h4>
                            <hr>
                            <?php echo $this->form->renderFieldset('sharing'); ?>
                        </div>
                        <div class="span4">
                            <h4>Event Listing</h4>
                            <hr>
                            <?php echo $this->form->renderFieldset('event_list'); ?>
                        </div>
                        <div class="span4">
                            <h4>Event Details</h4>
                            <hr>
                            <?php echo $this->form->renderFieldset('event_details'); ?>
                        </div>

					</div>

				</div>

			</div>
		</div>
	</div>

	<input type="hidden" name="task" value="event.edit" />
	<?php echo JHtml::_('form.token'); ?>
</form>
