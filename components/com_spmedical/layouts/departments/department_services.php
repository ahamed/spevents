<?php
/**
* @package com_spmedical
* @author JoomShaper http://www.joomshaper.com
* @copyright Copyright (c) 2010 - 2018 JoomShaper
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/

// No Direct Access
defined ('_JEXEC') or die('Restricted Access');

$services_title = $displayData['services_title'];
$columns 		= $displayData['columns'];
$services 		= $displayData['services'];

if(count((array)$services)) { ?>
	<div class="spmedical-col-md-12 spmedical-col-lg-<?php echo round(12/$columns)?>">
		<div class="spmedical-department-price-list">
			<h3 class="title"><?php echo $services_title; ?></h3>
			<ul>
				<?php foreach ($services as $service) { ?>
					<li>
						<span class="spmedical-float-left"><?php echo $service->title; ?></span>
						<?php if ( $service->price ){ ?>
							<span class="spmedical-float-right"><?php echo SpmedicalHelper::generateCurrency($service->price); ?></span>
						<?php } ?>
					</li>
				<?php } ?>
			</ul>
		</div>
	</div> <!-- //.spmedical-col-md-4  -->
<?php } ?>