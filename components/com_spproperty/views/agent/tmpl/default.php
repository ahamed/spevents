<?php

/**
 * @package     SP Property
 *
 * @copyright   Copyright (C) 2010 - 2016 JoomShaper. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// No Direct Access
defined('_JEXEC') or die('Resticted Aceess');


$doc = JFactory::getDocument();
$doc->addScriptdeclaration('var spproperty_url="' . JURI::base() . 'index.php?option=com_spproperty";');

?>

<div id="spproperty-agent" class="spproperty spproperty-view-agent">
	<div class="agent-info">

		<?php echo JLayoutHelper::render('agents.agent', array('agent' => $this->item, 'desc_limit' => false)); ?>

	</div>
	
	<?php if(count($this->plocations)) { ?>
		<div class="spproperty-agent-map-widget">
			<div id="spproperty-agent-map" class="spproperty-agent-map" style="width: 100%; height: 500px;" data-locations='<?php echo json_encode($this->plocations); ?>'> </div>
		</div>
	<?php } ?>

	<?php if ($this->cParams->get('show_contact', 1)) { ?>
		<div class="agent-contact-from">
			<div class="contact-from-title text-center">
				<h2 class="title-heading"><?php echo JText::_('COM_SPPROPERTY_AGENT_CONTACT_TITLE'); ?></h2>
				<p class="title-subheading"><?php echo JText::_('COM_SPPROPERTY_AGENT_CONTACT_DESC'); ?></p>
			</div>
			<form class="spproperty-agent-form">
				<div class="controls controls-row">
					<input type="text" name="name" id="name" class="col-sm-4" placeholder="<?php echo JText::_('COMPROPERTY_PLACEHOLDER_FULLNAME'); ?>">
					<input type="email" name="email" id="email" class="col-sm-4" placeholder="<?php echo JText::_('COMPROPERTY_PLACEHOLDER_EMAIL'); ?>">
					<input type="text" name="phone" id="phone" class="col-sm-4" placeholder="<?php echo JText::_('COMPROPERTY_PLACEHOLDER_PHONE'); ?>">
				</div>
				<div class="controls controls-row">
					<input id="subject" name="subject" type="text" class="col-sm-12" placeholder="<?php echo JText::_('COMPROPERTY_PLACEHOLDER_SUBJECT'); ?>">
				</div>
				<div class="controls">
					<textarea id="message" name="message" class="col-sm-12" placeholder="<?php echo JText::_('COMPROPERTY_PLACEHOLDER_MESSAGE'); ?>" rows="5"></textarea>
					<input type="hidden" name="agnt_email" value="<?php echo base64_encode($this->item->email); ?>">
				</div>
				<div class="controls spproperty-row">
					<?php if($this->contact_tac && $this->contact_tac_text) { ?>
						<div class="input-field spproperty-col-sm-10">
							<label class="form-checkbox">
								<input type="checkbox" id="tac" name="tac" value="tac" required="true" data-apptac="true">
								<?php echo $this->contact_tac_text; ?>
							</label>
						</div>

						<div class="spproperty-col-sm-2">
							<button type="submit" id="contact-submit"  class="btn btn-primary btn-sm input-medium pull-right"><?php echo JText::_('COM_PROPERTY_FORMBTN_SUBMIT'); ?></button>
						</div>
					<?php } else {?>
						<div class="spproperty-col-sm-12">
							<button type="submit" id="contact-submit"  class="btn btn-primary btn-sm input-medium pull-right"><?php echo JText::_('COM_PROPERTY_FORMBTN_SUBMIT'); ?></button>
						</div>
					<?php } ?>
					
				</div>
			</form>
			<div style="display:none;margin-top:10px;" class="spproperty-cont-status"></div>
		</div> <!-- /.agent-contact-from -->
	<?php } ?>

	<div class="agent-property-list">
		<div class="agent-properties-from-title text-center">
			<h2 class="title-heading"><?php echo JText::_('COM_SPPROPERTY_AGENT_MYPROPERTIES'); ?></h2>
			<p class="title-subheading"><?php echo JText::_('COM_SPPROPERTY_AGENT_MYPROPERTIES_DESC'); ?></p>
		</div> <!-- /.agent-properties-from-title -->
		<div class="agent-properties">
			 <?php echo JLayoutHelper::render('properties.properties', array('properties' => $this->agent_properties, 'columns' => $this->properties_columns)); ?>
		</div> <!-- /.agent-properties -->
	</div> <!-- /.agent-property-list -->

</div> <!-- /.spproperty-agent -->
