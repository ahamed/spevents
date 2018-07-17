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

?>

<div id="com-sp-moviedb" class="spmoviedb view-trailers sp-moviedb-view-items">

	<div class="moviedb-view-top-wrap">
		<p class="search-result-title"><?php echo JText::_('COM_SPMOVIEDB_SEARCH_RESULTS'); ?></p>
	</div>

	<?php if(!count($this->items)) { ?>
	<div class="alert alert-warning">
		<?php echo JText::_('COM_SPMOVIEDB_NOTHING_FOUND'); ?>
	</div>
	<?php } ?>

	<?php foreach(array_chunk($this->items, $this->columns) as $this->items) { ?>
	<div class="spmoviedb-row">
		<?php foreach ($this->items as $item) { 
			$item->item_id = (isset($item->spmoviedb_movie_id) && $item->spmoviedb_movie_id) ? 'item-id-' . $item->spmoviedb_movie_id : '';
		?>
		<div class="item spmoviedb-col-xs-12 spmoviedb-col-sm-6 spmoviedb-col-md-6 spmoviedb-col-lg-<?php echo round(12/$this->columns); ?> <?php echo $item->item_id; ?>">
			<div class="movie-poster">
				<img src="<?php echo JUri::root() . $item->profile_image; ?>" alt="<?php echo $item->title; ?>">
				<?php if (isset($item->spmoviedb_movie_id) && $item->spmoviedb_movie_id) { ?>
					<?php if (isset($item->turls[0]) && $item->turls[0]) { ?>
						<a href="javascript:void(0);" data-id="<?php echo $item->spmoviedb_movie_id; ?>" class="play-icon show-movie-trailers" >
							<i class="spmoviedb-icon-play"></i>
						</a>
					<?php }else{ ?>
						<a href="<?php echo $item->url; ?>" class="play-icon" >
							<i class="spmoviedb-icon-enter"></i>
						</a>
					<?php } ?>
				<?php } else { ?>
					<a href="<?php echo $item->url; ?>" class="play-icon">
						<i class="spmoviedb-icon-enter"></i>
					</a>
				<?php } ?>
			</div>
			<div class="movie-details">
				<div class="movie-name">
					<a href="<?php echo $item->url; ?>"><h4 class="movie-title"><?php echo $item->title; ?></h4></a>
					
					<?php if (isset($item->spmoviedb_movie_id) && $item->spmoviedb_movie_id) { ?>
						<span><?php echo JLayoutHelper::render('movie.genres', array('genres'=>$item->genres)); ?></span>	
					<?php } ?>
				</div>
			</div>
		</div>
		<?php } ?>
	</div>
	<?php } ?>
	
	<?php if ($this->pagination->get('pages.total') >1) { ?>
		<?php echo $this->pagination->getPagesLinks(); ?>
	<?php } ?>
</div>