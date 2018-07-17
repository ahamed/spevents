<?php
/**
 * @package     SP Movie Databse
 *
 * @copyright   Copyright (C) 2010 - 2016 JoomShaper. All rights reserved.
 * @license     GNU General Public License version 2 or later.
 */

defined('_JEXEC') or die('Restricted Access');

JHtml::_('jquery.framework');
$doc = JFactory::getDocument();
$doc->addScript(JURI::base(true) . '/components/com_spmoviedb/assets/js/spmoviedb.js');
$doc->addScriptdeclaration('var spmoviedb_url="'. JURI::base() .'index.php?option=com_spmoviedb";');


$movie 	= $displayData['movie'];

?>

<div class="movie-poster">
	<img src="<?php echo $movie->profile_image; ?>" alt="<?php echo $movie->title; ?>">

	<?php if( (count($movie->turls) > 0) && $movie->turls ){ ?>
        <a class="play-icon play-video" href="<?php echo $movie->turls[0]['src']; ?>" data-type="<?php echo $movie->turls[0]['host']; ?>">
            <i class="spmoviedb-icon-play"></i>
        </a>
    <?php } else{ ?>
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
	<a href="<?php echo $movie->url; ?>"><h4 class="movie-title"><?php echo $movie->title; ?></h4></a>
	</div>
</div>