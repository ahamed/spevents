<?php
/**
 * @package     SP Movie Databse
 *
 * @copyright   Copyright (C) 2010 - 2016 JoomShaper. All rights reserved.
 * @license     GNU General Public License version 2 or later.
 */

defined('_JEXEC') or die('Restricted Access');

$trailers 	= $displayData['trailers'];
$movie_info = $displayData['movie_info'];
$model = FOFModel::getAnInstance('Movies', 'SpmoviedbModel');
$movie_info->genres = $model->getGenries($movie_info->genres);
$movie_info->url = JRoute::_('index.php?option=com_spmoviedb&view=movie&id=' . $movie_info->spmoviedb_movie_id . ':' . $movie_info->slug . SpmoviedbHelper::getItemid('movies'));

$genres = new JLayoutFile('movie.genres', $basePath = JPATH_ROOT .'/components/com_spmoviedb/layouts');

?>
<!-- trailers-videos -->
<div class="trailers-videos spmoviedb-row">
	<div class="spmoviedb-trailer-item spmoviedb-col-md-6 spmoviedb-col-sm-12">
		<div class="spmoviedb-trailer">
			<?php if ($trailers[0]['host'] == 'youtube' || $trailers[0]['host'] == 'vimeo') { ?>
				<iframe width="100%" height="315" src="<?php echo $trailers[0]['src']; ?>" frameborder="0" allowfullscreen></iframe>
			<?php } elseif ($trailers[0]['host'] == 'dailymotion') { ?>
				<iframe id="video-player" src="<?php echo $trailers[0]['src']; ?>?autoplay=1&color=ffffff&title=0&byline=0&portrait=0&badge=0" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
			<?php } else { ?>
				<video id="video-player" controls autoplay> <source src="<?php echo $trailers[0]['src']; ?>">Your browser does not support the video tag.</video>
			<?php } ?>
		</div>
	</div> <!-- //spmoviedb-trailer-item -->
	<div class="spmoviedb-trailer-item-details spmoviedb-col-md-6 spmoviedb-col-sm-12">
		<h3 class="spmoviedb-movie-title">
			<a href="<?php echo $movie_info->url; ?>"><?php echo $movie_info->title . ' (' . JHTML::date($movie_info->release_date, 'Y') . ')'; ?></a>
		</h3>
		<p class="trailer-genres"><?php echo $genres->render(array('genres'=>$movie_info->genres)); ?></p>
		
		<p> 
			<?php echo JHtml::_('string.truncate', strip_tags($movie_info->movie_story), 380); ?> 
		</p>

		<a href="<?php echo $movie_info->url; ?>" class="btn sppb-btn-primary buy-ticket">
	 		<i class="sp-moview-ticket"></i> <?php echo JText::_('COM_SPMOVIEDB_MOVIE_MORE_DETAILS'); ?>
	 	</a>
	</div> <!-- //spmoviedb-trailer-item-details -->
	<span class="video-close"></span>
</div> <!-- //trailers-videos --> <!-- /.row -->
