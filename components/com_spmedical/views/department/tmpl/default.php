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

<div id="spmedical" class="spmedical view-spmedical-department spmedical-department">

	<div class="spmedical-department-wrapper">
	
		<div class="spmedical-department-main-content">
			<?php if($this->item->image){ ?>
				<div class="img-wrapper">
					<img src="<?php echo JURI::root() . $this->item->image; ?>" alt="">
				</div>
			<?php } ?>
			<h2 class="spmedical-title"><?php echo $this->item->title; ?></h2>
			<div class="spmedical-details"><?php echo $this->item->description; ?></div>
		</div>

		<?php if(count($this->specialists)) { ?>
			<!-- Care Providers -->
			<div class="spmedical-specialists-wrapper">
				<h2 class="spmedical-title"><?php echo JText::_('COM_SPMEDICAL_CARE_PROVIDER_TITLE'); ?></h2>
				<div class="spmedical-details"><?php echo JText::_('COM_SPMEDICAL_CARE_PROVIDER_SUBTITLE'); ?></div>
				<div class="spmedical-row">
					<?php foreach ($this->specialists as $specialist) { ;
						?>
					<div class="spmedical-specialists spmedical-col-md-3 spmedical-col-sm-6">
						<div class="specialists-wrapper">
							<div class="specialists-img-wrapper">
								<?php if($specialist->image) { ?>
									<img src="<?php echo JURI::root() . $specialist->image; ?>" class="spmedical-person-img spmedical-img-responsive" alt="<?php echo $specialist->title; ?>">
								<?php } ?>
								<div class="area-of-specialties">
									<div class="specialists-name">
										<h3><a class="splms-person-title" href="<?php echo $specialist->url; ?>"><?php echo $specialist->title; ?></a></h3>
										<?php if($specialist->designation){ ?>
											<p class="specialists-designation"><?php echo $specialist->designation; ?></p>
										<?php } ?>
									</div>
								</div>
							</div> <!-- /.specialists-img-wrapper -->
						</div>
					</div> <!-- /.spmedical-specialists -->
					<?php } ?>
				</div> <!-- //.spmedical-row -->
			</div>
		<?php } //has specialitist ?>

		<?php if( $this->item->treatments || $this->item->investigations || $this->item->others_services ) { ?>
			<h2 class="spmedical-title"><?php echo JText::_('COM_SPMEDICAL_TEST_TITLE'); ?></h2>
			<div class="spmedical-details"><?php echo JText::_('COM_SPMEDICAL_TEST_SUBTITLE'); ?></div>
			<div class="spmedical-row">
				<?php if( $this->item->treatments ) { ?>
					<?php echo JLayoutHelper::render('departments.department_services', array('services' => $this->item->treatments, 'columns' => 3, 'services_title' => JText::_('COM_SPMEDICAL_DEPARTMENT_TREATMENTS'))); ?>
				<?php } if( $this->item->investigations ) { ?>
					<?php echo JLayoutHelper::render('departments.department_services', array('services' => $this->item->investigations, 'columns' => 3, 'services_title' => JText::_('COM_SPMEDICAL_DEPARTMENT_INVESTIGATIONS'))); ?>
				<?php } if( $this->item->others_services ) { ?>
					<?php echo JLayoutHelper::render('departments.department_services', array('services' => $this->item->others_services, 'columns' => 3, 'services_title' => JText::_('COM_SPMEDICAL_DEPARTMENT_OTHERS_SERVICES'))); ?>
				<?php } ?>
			</div> <!-- //.spmedical-row -->
		<?php } ?>
		
		<!-- CTA -->
		<div class="spmedical-department-cta">
			<div class="spmedical-row">
				<div class="spmedical-col-md-8">
					<h3 class="tilte"><?php echo JText::_('COM_SPMEDICAL_COST_CALCULATOR'); ?></h3>
				</div>
				<div class="spmedical-col-md-4 spmedical-text-right">
					<a href="<?php echo $this->item->costestimate_url; ?>" class="spmedical-btn spmedical-btn-primary"><?php echo JText::_('COM_SPMEDICAL_ESTIMATE_COST'); ?></a>
				</div>
			</div>
		</div>

	</div> <!-- //.spmedical-department-wrapper -->
</div> <!-- //.splms view-splms-teacher -->
