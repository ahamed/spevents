<?php
/**
 * @package     SP Medical
 * @subpackage  mod_spmedical_specialists
 *
 * @copyright   Copyright (C) 2010 - 2018 JoomShaper. All rights reserved.
 * @license     GNU General Public License version 2 or later.
 */

// no direct access
defined('_JEXEC') or die('Restricted access!');
?>

<div class="mod-spmedical-specialists spmedical <?php echo $moduleclass_sfx; ?>">
	<div class="spmedical-specialist-list">
		<div class="spmedical-row">
			<?php foreach (array_chunk($items, $columns) as $items) { ?>
			<?php foreach ($items as $item) { ?>
			<div class="col-sm-6 spmedical-col-lg-<?php echo round(12 / $columns); ?>">
				<div class="spmedical-specialist">
					<a href="<?php echo $item->url; ?>">
						<img src="<?php echo JURI::root() . $item->image; ?>" alt="">
					</a>
					<div class="medical-specialist-info">
						<div class="medical-specialist-name">
							<a href="<?php echo $item->url; ?>"><?php echo $item->title; ?></a>
							<small class="medical-specialist-designation"><?php echo $item->designation; ?></small>
						</div>
					</div> <!-- /.medical-specialist-info -->
				</div><!-- /.spmedical-specialist -->
			</div>
			<?php } ?>
			<?php } ?>
		</div> <!-- /.row -->
	</div>
</div>







