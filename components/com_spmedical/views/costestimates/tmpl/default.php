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

<div id="spmedical" class="spmedical view-spmedical-costestimates spmedical-costestimates">
  <h3 class="spmedical-title"><?php echo JText::_('COM_SPMEDICAL_COST_ESTIMATE_TITLE'); ?></h3>
  <p class="spmedical-subtitle"><?php echo JText::_('COM_SPMEDICAL_COST_ESTIMATE_SUBTITLE'); ?></p>  

  <div class="spmedical-services-list-wrapper">
  
    <div class="spmedical-services-list">
      <select name="services" class="spmedical-custom-select">
        <?php foreach ($this->has_services as $service) { 
          $selected = '';
          if($this->department_id == $service->id) {
              $selected = 'selected';
          }  
        ?>
          <option <?php echo $selected; ?> value="<?php echo $service->id; ?>"><?php echo $service->title; ?></option>
        <?php } ?>
      </select>
    </div> <!-- //list -->

    <div class="spmedical-services-test">
      <!-- Each service tests -->
      <?php foreach ($this->has_services as $key => $service) { 
        $active_class = '';
        if( ($this->department_id == $service->id) || ($this->department_id =='' &&  $key == 0) ) {
          $active_class = 'active';
        }
      ?>
      <div class="spmedical-service-tests <?php echo $active_class; ?>" data-tab="<?php echo $service->id; ?>" >
        <div class="spmedical-row">
          <?php if ($service->investigations){ ?>
            <?php echo JLayoutHelper::render('costestimates.services', array('services' => $service->investigations, 'type' => 'investigations', 'services_title' => 'Investigations', 'service_id' => $service->id , 'columns' => 3)); ?>
          <?php } // has item ?>

          <?php if ($service->treatments){ ?>
            <?php echo JLayoutHelper::render('costestimates.services', array('services' => $service->treatments, 'type' => 'treatments', 'services_title' => 'treatments', 'service_id' => $service->id , 'columns' => 3)); ?>
          <?php } // has item ?>
          
          <?php if ($service->others_services){ ?>
            <?php echo JLayoutHelper::render('costestimates.services', array('services' => $service->others_services, 'type' => 'others_services', 'services_title' => 'Tests', 'service_id' => $service->id , 'columns' => 3)); ?>
          <?php } // has item ?>

        </div> <!-- //.spmedical-row -->
      </div>
      <?php } ?>
      
    </div><!-- //.services-content -->

    <!-- Total cost -->
    <div class="spmedical-total-cost-wrapper">
      <div class="spmedical-test-total-wrap"><?php echo $this->currency[1]; ?>
      <span class="spmedical-test-total-cost">0.00</span></div>
    </div>
  </div>
</div> <!-- /#spmedical -->