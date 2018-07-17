<?php
/**
 * @package     SP Movie Database
 * @subpackage  mod_sp_moviedb_trailers
 *
 * @copyright   Copyright (C) 2010 - 2016 JoomShaper. All rights reserved.
 * @license     GNU General Public License version 2 or later.
 */

//no direct access
defined('_JEXEC') or die('No direct access');

$genres = new JLayoutFile('movie.genres', $basePath = JPATH_ROOT .'/components/com_spmoviedb/layouts');

?>

<div id="sp-moviewdb-trailers<?php echo $module->id; ?>" class="mod-spmoviedb-trailers spmoviedb-trailers spmoviedb <?php echo $moduleclass_sfx; ?>">

   <!-- trailers-videos -->
	<div class="trailers-videos">
		<div class="spmoviedb-row">
			<?php foreach ($items as $key => $item) {
			if ($key == 0) {
				$item_type = 'leading spmoviedb-col-sm-12';
				$turl['thumb'] = $item->turls[0]['tmb_large'];
			}else{
				$item_type = 'subleading spmoviedb-col-sm-3';
				$turl['thumb'] = $item->turls[0]['tmb_small'];
			} ?>

			<div class="spmoviedb-trailer-item <?php echo $item_type; ?>">
				<div class="spmoviedb-trailer">
					<div class="trailer-image-wrap">
						<img src="<?php echo $turl['thumb']; ?>" alt="">
						<a class="play-video" href="<?php echo $item->turls[0]['src']; ?>" data-type="<?php echo $item->turls[0]['host']; ?>">
							<i class="play-icon spmoviedb-icon-play"></i>
						</a>
					</div> <!-- trailer-image-wrap -->
					<div class="spmoviedb-trailer-info sp-spmoviedb-trailers-info">
						<div class="spmoviedb-trailer-info-block">
							<?php if ($key == 0) { ?>
								<img src="<?php echo $item->turls[0]['tmb_large']; ?>" class="thumb-img" alt="">
							<?php } ?>
							
							<h3 class="movie-title"><a href="<?php echo $item->url; ?>"><?php echo $item->title; ?></a></h3>
							<p class="spmoviedb-genry">
								<?php echo $genres->render(array('genres'=>$item->genres)); ?>
							</p>
						</div>

						<?php if ($key == 0) { ?>
						<div class="count-rating pull-right">
							<span>
								<?php if(isset($item->ratings) && $item->ratings->count) {
			                        $rating = round($item->ratings->total/$item->ratings->count);
			                    } else {
			                        $rating = 0;
			                    }
			                    echo $rating ?>
							</span>
						</div>
						<?php } ?>
						
					</div>
				</div>
			</div>

			<?php } ?>
		</div> <!-- /.row -->
	</div> <!-- //trailers-videos -->

	<div class="video-container">
		<span class="video-close"><i class="spmoviedb-icon-close"></i></span>
	</div> <!-- /.video-container -->

	<div class="clearfix"></div>

</div>