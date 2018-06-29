<?php
/**
* @package com_spmedical
* @author JoomShaper http://www.joomshaper.com
* @copyright Copyright (c) 2010 - 2018 JoomShaper
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/

// No Direct Access
defined ('_JEXEC') or die('Restricted Access');

?>

<div id="spmedical" class="spmedical view-spmedical-specialist spmedical-person">

	<div class="spmedical-row">
		<div class="spmedical-col-md-5 spmedical-col-lg-4 spmedical-col-xl-3">
			<div class="specialist-info">

				<div class="specialist-img">
					<?php if($this->item->image) { ?>
						<img src="<?php echo $this->item->thumb; ?>" class="spmedical-person-image spmedical-img-responsive" alt="<?php echo $this->item->title; ?>">
					<?php } ?>
				</div>

				<div class="specialist-name">
					<h3><?php echo $this->item->title; ?></h3>

					<?php if($this->item->designation){ ?>
						<span><?php echo $this->item->designation; ?></span>
					<?php } ?>
				</div>
				
				<div class="specialist-specialties">
					<h3><?php echo JText::_('COM_SPMEDICAL_SPECIALTIES_SPECIALTY'); ?></h3>
					<?php echo $this->item->specialitist_on; ?>
				</div>

				<div class="specialist-contact-info">
					<h3><?php echo JText::_('COM_SPMEDICAL_SPECIALTIES_CONTACT_INFO'); ?></h3>
					<?php if (!empty($this->item->phone)) { ?>
						<p><?php echo $this->item->phone; ?></p>
					<?php } ?>

					<?php if (!empty($this->item->email)) { ?>
						<a href="mailto:install@joomshaper.com"><?php echo $this->item->email; ?></a>
					<?php } ?>

					<?php if(count((array)$this->item->socials) || $this->item->website ) { ?>
						<ul class="specialist-social-icon">
							<?php foreach ($this->item->socials as $socials) { ?>
								<li>
									<a href="<?php echo $socials->social_url; ?>" target="_blank"><i class="<?php echo $socials->social_icon; ?>" aria-hidden="true"></i></a>
								</li>
							<?php } ?>
							<?php if($this->item->website) { ?>
								<li>
									<a href="<?php echo $this->item->website; ?>" target="_blank"><i class="fa fa-globe" aria-hidden="true"></i></a>
								</li>
							<?php } ?>
						</ul>
					<?php } // END:: Socials ?>

				</div>
				
				<?php if(count((array)$this->item->visiting_times)) { ?>
					<div class="specialist-available-hours">
						<h3><?php echo JText::_('COM_SPMEDICAL_SPECIALTIES_AVAILABLE_HOURS'); ?></h3>
						<ul>
							<?php foreach ($this->item->visiting_times as $visiting_time) { ?>
								<li>
									<span class="date"><?php echo ucfirst($visiting_time->day); ?></span>
									<span class="time"><?php echo $visiting_time->visiting_time; ?>
								</li>
							<?php } ?>
						</ul>
					</div>
				<?php } ?>

				<div class="appointment-button">
					<a class="spmedical-btn btn-primary" href="<?php echo $this->item->appointment_url; ?>">
						<?php echo JText::_('COM_SPMEDICAL_SPECIALTIES_REQUEST_BUTTON'); ?>
					</a>
				</div> <!-- /.appointment-button -->

			</div>
		</div> <!-- //.spmedical-col-sm-4 -->

		<div class="spmedical-col-md-6 spmedical-col-lg-7 spmedical-col-xl-7 spmedical-offset-lg-1">
			<div class="about-specialist">

				<div class="specialist-intro">
					<h2><?php echo JText::_('COM_SPMEDICAL_ABOUT_THE_SPECIALTIES'); ?></h2>
					<?php if($this->item->description){ ?>
						<?php echo $this->item->description; ?>
					<?php } ?>
				</div>

				<?php if(isset($this->item->experiences) && $this->item->experiences) { ?>
					<?php echo JLayoutHelper::render('specialists.specialist_timeline', array('informations' => $this->item->experiences, 'informations_title' => JText::_('COM_SPMEDICAL_SPECIALIST_WORK_EXPERIENCE'), 'informations_type' => 'specialist-work-experience')); ?>
				<?php } // has experiences; ?>

				<?php if(isset($this->item->awards_honers) && $this->item->awards_honers) { ?>
					<?php echo JLayoutHelper::render('specialists.specialist_timeline', array('informations' => $this->item->awards_honers, 'informations_title' => JText::_('COM_SPMEDICAL_SPECIALIST_AWARDS'), 'informations_type' => 'specialist-awards')); ?>
				<?php } // has experiences; ?>

				<?php if(isset($this->item->educations) && $this->item->educations) { ?>
					<?php echo JLayoutHelper::render('specialists.specialist_timeline', array('informations' => $this->item->educations, 'informations_title' => JText::_('COM_SPMEDICAL_SPECIALIST_EDUCATION'), 'informations_type' => 'specialist-education')); ?>
				<?php } // has educations; ?>

			</div> <!-- //.about-specialist -->
		</div> <!-- //.spmedical-col-sm-8 -->

	</div> <!-- //.spmedical-row -->

</div> <!-- //.spmedical view-spmedical-teacher -->
