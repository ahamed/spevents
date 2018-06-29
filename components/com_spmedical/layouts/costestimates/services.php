<?php
/**
* @package com_spmedical
* @author JoomShaper http://www.joomshaper.com
* @copyright Copyright (c) 2010 - 2018 JoomShaper
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/

// No Direct Access
defined ('_JEXEC') or die('Restricted Access');

$services 		= $displayData['services'];
$service_id 	= $displayData['service_id'];
$type 			= $displayData['type'];
$services_title = $displayData['services_title'];
$columns 		= $displayData['columns'];

if (count((array)$services)) { ?>
	<div class="spmedical-col-md-<?php echo round(12/$columns); ?>">
		<div class="spmedical-test-list-wrapper">
		<h3><?php echo $services_title; ?></h3>
		<div class="spmedical-test-list">
			<?php foreach ($services as $key => $service) { 
			$key ++;
			if($service->price){
			?>
				<div class="spmedical-test">
				<label for="<?php echo $type . '-' . $service_id . '-' . $key; ?>" class="custom-checkbox">
					<input class="cost-checkbox" type="checkbox" id="<?php echo $type . '-' . $service_id . '-' . $key; ?>" value="<?php echo $service->price; ?>">
					<span class="checkmark"><?php echo $service->title; ?></span>
				</label>
				</div><!-- //.spmedical-test -->
			<?php } } //END:: foreach ?>
		</div>
		</div>
	</div> <!-- //.spmedical-col-sm-4 -->

<?php } else { ?>
    <div class="row">
        <div class="spmedical-col-sm-12 sp-no-item-found">
            <p><?php echo JText::_('COM_SPMEDICAL_NO_ITEMS_FOUND'); ?></p>
        </div>
    </div>
<?php } ?>