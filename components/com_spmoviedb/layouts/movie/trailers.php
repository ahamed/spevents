<?php
/**
 * @package     SP Movie Databse
 *
 * @copyright   Copyright (C) 2010 - 2016 JoomShaper. All rights reserved.
 * @license     GNU General Public License version 2 or later.
 */

defined('_JEXEC') or die('Restricted Access');

$trailers 	= $displayData['trailers'];

?>
<!-- trailers-videos -->
<div class="trailers-videos">
	<div class="header-title">
		<span><i class="spmoviedb-icon-trailer"></i></span>
		<h3 class="title"><?php echo JText::_('COM_SPMOVIEDB_MOVIE_TRAILER_AND_VIDOES'); ?></h3>
	</div>

	<div class="spmoviedb-row">
		<?php foreach ($trailers as $key => $trailer) {
			if ($key == 0) {
				$item_type = 'leading spmoviedb-col-sm-12';
				$trailer['thumb'] = $trailer['tmb_large'];
			} else {
				$item_type = 'subleading spmoviedb-col-sm-4';
				$trailer['thumb'] = $trailer['tmb_small'];
			} ?>

			<div class="spmoviedb-trailer-item <?php echo $item_type; ?>">
				<div class="spmoviedb-trailer">
					<div class="trailer-image-wrap">
						<img src="<?php echo $trailer['thumb']; ?>" alt="">
						<a class="play-video" href="<?php echo $trailer['src']; ?>" data-type="<?php echo $trailer['host']; ?>">
							<i class="play-icon spmoviedb-icon-play"></i>
						</a>
					</div> <!-- trailer-image-wrap -->
					<div class="spmoviedb-trailer-info sp-spmoviedb-trailers-info">
						<div class="spmoviedb-trailer-info-block">
							<?php if ($key == 0) { ?>
							<img src="<?php echo $trailer['tmb_small']; ?>" class="thumb-img" alt="">
							<?php } ?>
							<h4 class="movie-title"><?php echo $trailer['title']; ?></h4>
							<?php if ($key == 0) { ?>
							<p class="spmoviedb-genry">
								<?php echo JLayoutHelper::render('movie.genres', array('genres'=>$trailer['genres'])); ?>
							</p>
							<?php } ?>
						</div>
					</div>

				</div>
			</div>
			<?php } ?>
		</div> <!-- /.row -->
	

	</div> <!-- //trailers-videos -->