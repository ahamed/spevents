<?php
/**
 * @package     SP Medical
 * @subpackage  mod_spmedical_service
 *
 * @copyright   Copyright (C) 2010 - 2018 JoomShaper. All rights reserved.
 * @license     GNU General Public License version 2 or later.
 */

// no direct access
defined('_JEXEC') or die('Restricted access!');
?>

<div class="mod-spmedical-services spmedical <?php echo $moduleclass_sfx; ?>">
	<div class="spmedical-service-list">
		<div class="spmedical-row">
			<?php foreach (array_chunk($items, $columns) as $items) { ?>
				<?php foreach ($items as $item) { ?>
				<div class="spmedical-departments spmedical-col-md-<?php echo round(12 / $columns); ?>">
					<?php if ($dep_layout == 'image') { ?>
						<div class="spmedical-department-wrap has-image">
							<a href="<?php echo $item->url; ?>">
								<div class="spmedical-department-img-wrap">
									<img src="<?php echo JURI::root() . $item->image; ?>" alt="">
								</div>
								<div class="spmedical-department-content">
									<h3 class="spmedical-department-title"><?php echo $item->title; ?></h3>
									<div class="spmedical-department-details"><?php echo JHtmlString::truncate(strip_tags($item->description), 90); ?></div>
								</div>
							</a>
						</div>
					<?php } else { ?>
						<div class="spmedical-department-wrap has-icon">
							<!-- has service icon -->
							<div class="spmedical-department-icon-wrap">
								<a href="<?php echo $item->url; ?>">
									<i class="<?php echo $item->icon; ?>"></i>
								</a>
							</div>
							<div class="spmedical-department-content">
								<h3 class="spmedical-department-title"><a href="<?php echo $item->url; ?>"><?php echo $item->title; ?></a></h3>
								<div class="spmedical-department-details"><?php echo JHtmlString::truncate(strip_tags($item->description), 55); ?></div>
							</div>
						</div>
					<?php } ?>
				</div>
				<?php } ?>
			<?php } ?>
		</div>
	</div>
</div>

<script>
	jQuery(function($){ 'use strict';
		//For custom feature box
    $('.spmedical-departments .spmedical-department-wrap a').on('hover', function(e){
        $(this).find('.spmedical-department-details').slideToggle(300);
    });
	});
</script>






