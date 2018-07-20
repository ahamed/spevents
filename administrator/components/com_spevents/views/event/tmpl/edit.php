<?php
defined('_JEXEC') or die;

$doc = JFactory::getDocument();
JHtml::_('behavior.formvalidator');
JHtml::_('behavior.keepalive');
JHtml::_('formbehavior.chosen','select',null,array('disable_search_threshold' => 0));
$doc->addStyleDeclaration('
	.tabs-left > .nav-tabs {
		width: 300px;
	}
')
?>
<form action="<?php echo JRoute::_('index.php?option=com_spevents&layout=edit&id=' . (int) $this->item->id); ?>" name="adminForm" id="adminForm" method="post" class="form-validate">
	<?php if (!empty($this->sidebar)) : ?>
    <div id="j-sidebar-container" class="span2">
		<?php echo $this->sidebar; ?>
    </div>
    <div id="j-main-container" class="span10" >
		<?php else: ?>
            <div id="j-main-container"></div>
		<?php endif; ?>
	<div class="form-horizontal">
		<div class="row-fluid">
			<div class="span12">
				<?php 
				$options = array(
    				'useCookie' => true,
    				'active' => 'basic'
				);

				// Start Tabs
				echo '<div class="tabbable tabs-left">';
				echo JHtml::_('bootstrap.startTabSet', 'events_tabs', $options); 
				
				echo JHtml::_('bootstrap.addTab', 'events_tabs', 'basic', 'Basic*');
				echo $this->form->renderFieldset('basic');
				echo JHtml::_('bootstrap.endTab');

				
				echo JHtml::_('bootstrap.addTab', 'events_tabs', 'dateTime', 'Date and Time*');
				echo $this->form->renderFieldset('date-time');
				echo JHtml::_('bootstrap.endTab');

				echo JHtml::_('bootstrap.addTab', 'events_tabs', 'recurring', 'Repeat Event');
				echo $this->form->renderFieldset('repeat');
				echo JHtml::_('bootstrap.endTab');

				echo JHtml::_('bootstrap.addTab', 'events_tabs', 'registration', 'Event Registration');
				echo $this->form->renderFieldset('registration');
				echo JHtml::_('bootstrap.endTab');

				echo JHtml::_('bootstrap.addTab', 'events_tabs', 'gallery', 'Gallery');
				echo $this->form->renderFieldset('gallery');
				echo JHtml::_('bootstrap.endTab');

				echo JHtml::_('bootstrap.addTab', 'events_tabs', 'social', 'Social');
				echo $this->form->renderFieldset('social');
				echo JHtml::_('bootstrap.endTab');

				echo JHtml::_('bootstrap.addTab', 'events_tabs', 'options', 'Options');
				echo $this->form->renderFieldset('options');
				echo JHtml::_('bootstrap.endTab');

				// End Tabs
				echo JHtml::_('bootstrap.endTabSet');
				echo '</div>';
				;?>
			</div>
			
			<!-- <div class="span8">
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
				</ul>
				<div class="tab-content">
					<div id="basic" class="tab-pane active">
						<?php //echo $this->form->renderFieldset('basic'); ?>
					</div>
					<div id="dateTime" class="tab-pane">
						<?php //echo $this->form->renderFieldset('date-time'); ?>
					</div>
					<div id="recurring" class="tab-pane">
						<?php //echo $this->form->renderFieldset('repeat'); ?>
					</div>
					<div id="registration" class="tab-pane">
						<?php //echo $this->form->renderFieldset('registration'); ?>
					</div>
					<div id="gallery" class="tab-pane">
						<?php //echo $this->form->renderFieldset('gallery'); ?>
					</div>
					<div id="social" class="tab-pane">
						<?php //echo $this->form->renderFieldset('social'); ?>
					</div>
					<div id="options" class="tab-pane">
						<?php //echo $this->form->renderFieldset('options'); ?>
					</div>
					<div id="ticket" class="tab-pane">
						<?php //echo $this->form->renderFieldset('ticket'); ?>
					</div>

				</div>

			</div> -->
		</div>
	</div>

	

	<input type="hidden" name="task" value="event.edit" />
	<?php echo JHtml::_('form.token'); ?>
	</div>
</form>
