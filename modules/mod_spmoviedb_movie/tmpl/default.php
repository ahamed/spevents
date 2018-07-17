<?php
/**
 * @package     SP Movie Database
 * @subpackage  mod_spmoviedb_movie
 *
 * @copyright   Copyright (C) 2010 - 2016 JoomShaper. All rights reserved.
 * @license     GNU General Public License version 2 or later.
 */

// no direct access
defined('_JEXEC') or die('Restricted access!');

$autoplay = ($params->get('autoplay'))? 'data-autoplay="true"':'data-autoplay="false"';
$slidelimit = ($params->get('slidelimit'))? 'data-slidelimit="'.$params->get('slidelimit').'"':'data-slidelimit="5"';

?>

<div id="spmoviedb-movie" class="mod-spmoviedb-movie moduleid-<?php echo $module->id; ?> spmoviedb-trailers <?php echo $params->get('moduleclass_sfx') ?>">
    <div class="row-fluid">
    	<div class="sp-mv-movie" <?php echo $autoplay; ?> <?php echo $slidelimit; ?>>
        <?php foreach ($items as $movie) { ?>
    		<div class="item">
				<div class="movie-poster">
                    <img src="<?php echo JURI::root(). $movie->profile_image; ?>" alt="">
                </div> <!-- /.movie-poster -->
                    <?php if( (count($movie->turls) > 0) && $movie->turls ){ ?>
                        <a class="play-icon play-video" href="<?php echo $movie->turls[0]['src']; ?>" data-type="<?php echo $movie->turls[0]['host']; ?>">
                            <i class="spmoviedb-icon-play"></i>
                        </a>
                    <?php } else{ ?>
                        <a class="play-icon" href="<?php echo $movie->url; ?>">
                            <i class="spmoviedb-icon-enter"></i>
                        </a>
                    <?php } ?>
                <div class="movie-details">
                    <?php if(isset($movie->ratings) && $movie->ratings->count) {
                        $rating = round($movie->ratings->total/$movie->ratings->count);
                    } else {
                        $rating = 0;
                    }
                    ?>
                    <div class="sp-moviedb-rating-wrapper">
                        <div class="sp-moviedb-rating">
                            <span class="star active"></span>
                        </div>
                        <span class="spmoviedb-rating-summary"><span><?php echo $rating; ?></span>/<?php echo JText::_('COM_SPMOVIEDB_RATING_MAX'); ?></span>
                    </div>
                    <div class="movie-name">
                        <h2 class="movie-title"><a href="<?php echo $movie->url; ?>"><?php echo $movie->title; ?></a></h2>
                        <span class="tag">
                            <?php
                            $genres = new JLayoutFile('movie.genres', $basePath = JPATH_ROOT .'/components/com_spmoviedb/layouts');
                            echo $genres->render(array('genres'=>$movie->genres));
                            ?>
                        </span>
                    </div><!--/.movie-name-->
                    <div class="cast">
                        <span><?php echo JText::_('COM_SPMOVIEDB_CAST'); ?> : </span> <?php echo $movie->actors; ?>
                    </div> <!-- /.cast -->
                </div>

            </div>
    		<?php } // END:: foreach ?>

    	</div> <!-- /.sp-mv-movie -->
    </div><!--/.row-fluid-->

    <div class="mod-spmoviedb-movie video-container">
        <span class="video-close"> <i class="spmoviedb-icon-close"></i> </span>
    </div><!-- /.video-container -->

</div> <!-- /.sp-moview-movie -->