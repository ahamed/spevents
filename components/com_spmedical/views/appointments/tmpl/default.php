<?php
/**
* @package com_spmedical
* @author JoomShaper http://www.joomshaper.com
* @copyright Copyright (c) 2010 - 2018 JoomShaper
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/

// No Direct Access
defined ('_JEXEC') or die('Restricted Access');

$doc 	= JFactory::getDocument();
$input  = JFactory::getApplication()->input;
$doc->addStylesheet( JURI::root(true) . '/components/com_spmedical/assets/css/bootstrap-datepicker3.css' );

$doc->addScript( JURI::root(true) . '/components/com_spmedical/assets/js/jquery-ui.js' );
$doc->addScript( JURI::root(true) . '/components/com_spmedical/assets/js/bootstrap-datepicker.min.js' );

$specialistid       = $input->get('specialistid', '', 'INT');
?>

<div id="spmedical" class="spmedical view-spmedical-appointments spmedical-appointments">
	<!-- spmedical specialists Appointment(for details page) -->
	<div class="spmedical-specialist-appointment">
		<div class="img-wrap"></div>
		<div class="spmedical-specialist-appointment-form">
			<h3><?php echo JText::_('COM_SPMEDICAL_MAKE_AN_APPOINTMENT'); ?></h3>
			<form id="spmedical-specialist-appintment-from" class="spmedical-specialist-appintment spmedial-suggest-fields">
				<div class="input-item">
					<select id="spmedical-specialists" class="spmedical-combobox spmedical-appointment-combobox" data-placeholder="<?php echo Jtext::_('COM_SPMEDIAL_APPOINTMENT_SPECIALISTS');?>">
						<option <?php echo ($specialistid == '') ? 'selected' : '';?>></option>
						<?php foreach ($this->specialists as $specialist) { ?>
							<option <?php echo ($specialistid == $specialist->id) ? 'selected' : '';?> value="<?php echo $specialist->id; ?>"><?php echo $specialist->title; ?></option>
						<?php } ?>
					</select>
				</div>
				<div class="input-field">
					<input type="text" id="patient-name" name="patient-name" placeholder="<?php echo Jtext::_('COM_SPMEDIAL_APPOINTMENT_PH_PATIENT_NAME'); ?>" required="true" autocomplete="off">
				</div>
				<div class="input-field-half-wrap">
					<div class="input-field input-field-half">
						<input type="text" name="phone" placeholder="<?php echo Jtext::_('COM_SPMEDIAL_APPOINTMENT_PH_PATIENT_PHONE'); ?>" required="true">
					</div>
					<div class="input-field input-field-half">
						<input type="text" name="email" placeholder="<?php echo Jtext::_('COM_SPMEDIAL_APPOINTMENT_PH_PATIENT_EMAIL'); ?>" required="true">
					</div>
				</div>
				<div class="input-field">
					<input type="text" name="appointment-date" placeholder="<?php echo Jtext::_('COM_SPMEDIAL_APPOINTMENT_PH_DATE'); ?>" required="true" autocomplete="off">
				</div>
				<div class="input-field">
					<textarea name="patient-note" placeholder="<?php echo Jtext::_('COM_SPMEDIAL_APPOINTMENT_PH_NOTE'); ?>" cols="30" rows="5"></textarea>
				</div>
				<input type="hidden" id="showcaptcha" name="showcaptcha" value="<?php echo $this->captcha; ?>">
				<?php if($this->captcha) { ?>
					<div class="input-field">
						<?php
							JPluginHelper::importPlugin('captcha', 'recaptcha');
							$dispatcher = JDispatcher::getInstance();
							$dispatcher->trigger('onInit', 'dynamic_recaptcha_spmedical');
							$recaptcha = $dispatcher->trigger('onDisplay', array(null, 'dynamic_recaptcha_spmedical', 'class="spmedical-dynamic-recaptcha"'));
							
							echo (isset($recaptcha[0])) ? $recaptcha[0] : '<p class="spmedical-text-danger">' . JText::_('COM_SPMEDICAL_CAPTCHA_NOT_INSTALLED') . '</p>';
						?>
					</div>
				<?php } ?>

				<?php if($this->appointment_tac && $this->appointment_tac_text) { ?>
					<div class="input-field">
						<label class="custom-checkbox">
							<input type="checkbox" id="tac" name="tac" value="tac" required="true" data-apptac="true">
							<span class="checkbox-text">
								<?php echo $this->appointment_tac_text; ?>
							</span>
						</label>
					</div>
				<?php } ?>

				<div class="input-field spmedical-text-center">
					<button type="submit" id="appointment-submit" class="spmedical-btn spmedical-btn-primary"><?php echo JText::_('COM_SPMEDICAL_REQUEST_APPOINTMENT');?></button>
				</div>
			</form>
			<div class="spmedical-appointment-status"></div>
		</div>
	</div> <!-- //.end specialist appointment -->
</div> <!-- /#spmedical -->