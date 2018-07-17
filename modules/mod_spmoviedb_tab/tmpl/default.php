<?php

/**
 * @package     SP Movie Database
 * @subpackage  mod_spmoviedb_tab
 *
 * @copyright   Copyright (C) 2010 - 2016 JoomShaper. All rights reserved.
 * @license     GNU General Public License version 2 or later.
 */

// no direct access
defined ('_JEXEC') or die ('restricted aceess');

$genres = new JLayoutFile('movie.genres', $basePath = JPATH_ROOT .'/components/com_spmoviedb/layouts');

$autoplay = ($params->get('autoplay'))? 'data-autoplay="true"':'data-autoplay="false"';
$slidelimit = ($params->get('slidelimit'))? 'data-slidelimit="'.$params->get('slidelimit').'"':'data-slidelimit="4"';

?>

<div id="sp-spmoviedb-tab" class="mod-spmoviedb-tab spmoviedb-tab module-id-<?php echo $module->id; ?> <?php echo $params->get('moduleclass_sfx') ?>">

    <ul class="nav nav-tabs" role="tablist">
        <?php foreach ($movies_lists as $key => $section) { ?>
        <li role="presentation" class="<?php echo ($key=='latest')?'active':''; ?>">
            <a href="#sp-spmoviedb-tab-<?php echo $key; ?>" aria-controls="sp-spmoviedb-tab-<?php echo $key; ?>" role="tab" data-toggle="tab">
                <?php echo $section['title']; ?>
            </a>
        </li>
        <?php } ?>
    </ul><!-- /.nav-tabs -->

    <!-- Tab panes -->
    <div class="tab-content">
        <?php foreach ($movies_lists as $key => $movies_list) { ?>
        <div id="sp-spmoviedb-tab-<?php echo $key; ?>" class="spmoviedb-tab-wrap fade in tab-pane<?php echo ($key=='latest')?' active':''; ?>" role="tabpanel" <?php echo $autoplay; ?> <?php echo $slidelimit; ?>>
        <?php foreach ($movies_list['movies'] as $movie) { ?>
            <div class="item">
                <div class="movie-poster">
                    <img src="<?php echo JURI::root(). $movie->profile_image; ?>" alt="">
                    <?php if( (count($movie->turls) > 0) && $movie->turls ){ ?>
                        <a class="play-icon play-video" href="<?php echo $movie->turls[0]['src']; ?>" data-type="<?php echo $movie->turls[0]['host']; ?>">
                            <i class="spmoviedb-icon-play"></i>
                        </a>
                    <?php } else { ?>
                        <a class="play-icon" href="<?php echo $movie->url; ?>">
                            <i class="spmoviedb-icon-enter"></i>
                        </a>
                    <?php } ?>
                </div>
                <div class="movie-details">
                    <?php
                    if(isset($movie->ratings) && $movie->ratings->count) {
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
                        <a href="<?php echo $movie->url; ?>"><h3 class="movie-title"><?php echo $movie->title; ?></h3></a>
                        <span><?php echo $genres->render(array('genres'=>$movie->genres)); ?></span>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
        <?php } ?>
    </div><!-- /.tab-content -->

    <div class="mod-spmoviedb-movie video-container">
        <span class="video-close"><i class="spmoviedb-icon-close"></i></span>
    </div><!-- /.video-container -->
</div> <!-- /.sp-spmoviedb-tab -->