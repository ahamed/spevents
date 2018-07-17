<?php
/**
 * @package     SP Movie Database
 * @subpackage  mod_spmoviedb_celebraties
 *
 * @copyright   Copyright (C) 2010 - 2016 JoomShaper. All rights reserved.
 * @license     GNU General Public License version 2 or later.
 */

// no direct access
defined('_JEXEC') or die('Restricted access!');
?>

<div id="mod-spmoviedb-celebraties<?php echo $module->id; ?>" class="mod-spmoviedb-celebrities <?php echo $params->get('moduleclass_sfx') ?>">
	<?php foreach ($items as $item) { ?>

	<?php
	$profile_image = dirname($item->profile_image) . '/_spmedia_thumbs/' . basename($item->profile_image);
	if(file_exists(JPATH_ROOT . '/' . $profile_image)) {
		$item->profile_image = $profile_image;
	}
	?>

	<div class="spmoviedb-celebrity clearfix">
		<a href="<?php echo $item->url; ?>">
			<div class="pull-left spmoviedb-celebrity-thumb" style="background-image: url(<?php echo JURI::base(true). '/' . $item->profile_image; ?>); "></div>
		</a>
		<div class="moviedb-celebrity-info">
			<div class="moviedb-celebrity-name">
				<a href="<?php echo $item->url; ?>"><?php echo $item->title; ?></a>
				<small class="moviedb-celebrity-designation"><?php echo $item->designation; ?></small>
			</div>
		</div> <!-- /.moviedb-top-celebrities-info -->
	</div><!-- /.moviedb-top-celebrity -->
	<?php } ?>
</div><!-- /.mod-spmoviedb-celebrities -->