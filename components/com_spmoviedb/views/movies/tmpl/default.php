<?php
/**
* @package     SP Movie Databse
* @copyright   Copyright (C) 2010 - 2016 JoomShaper. All rights reserved.
* @license     GNU General Public License version 2 or later.
*/

defined('_JEXEC') or die('Restricted Access');

$input = JFactory::getApplication()->input;
$Itemid = $input->get('Itemid', 0, 'INT');
$alphaindex = $input->get('alphaindex', NULL, 'WORD');
$yearindex = $input->get('yearindex', NULL, 'INT');

if($yearindex) {
	$alphaUrl = 'index.php?option=com_spmoviedb&view=movies&yearindex='. $yearindex .'&Itemid=' . $Itemid;
} else {
	$alphaUrl = 'index.php?option=com_spmoviedb&view=movies&Itemid=' . $Itemid;
}

if($alphaindex) {
	$yearUrl = 'index.php?option=com_spmoviedb&view=movies&alphaindex='. $alphaindex .'&Itemid=' . $Itemid;
} else {
	$yearUrl = 'index.php?option=com_spmoviedb&view=movies&Itemid=' . $Itemid;
}

JHtml::_('jquery.framework');
$doc = JFactory::getDocument();
$doc->addScript(JURI::base(true) . '/components/com_spmoviedb/assets/js/spmoviedb.js');
?>
<div id="com-sp-moviedb" class="spmoviedb sp-moviedb sp-moviedb-view-items">
	<div class="moviedb-filters">
		<div class="pull-left">
			<ul class="list-inline list-style-none">
				<li class="<?php echo ($alphaindex == NULL) ? 'active': '';?>">
					<a href="<?php echo JRoute::_($alphaUrl);?>"><?php echo JText::_('COM_SPMOVIEDB_ALL'); ?></a>
				</li>
				<?php foreach ($this->alphabets as $alphabet) {?>
				<li class="<?php echo ($alphaindex == $alphabet) ? 'active': '';?>">
					<a href="<?php echo JRoute::_($alphaUrl . '&alphaindex='.$alphabet);?>">
						<?php echo $alphabet; ?>
					</a>
				</li>
				<?php } ?>
			</ul>
		</div>
		<div class="pull-right moviedb-yearindex">
			<label><?php echo JText::_('COM_SPMOVIEDB_YEAR'); ?>:
				<select name="sorting-by-years" id="sorting-by-years">
					<option <?php echo ($yearindex == 'all') ? 'selected="selected"': '';?> value="<?php echo JRoute::_($yearUrl);?>">
						<?php echo JText::_('COM_SPMOVIEDB_ALL'); ?>
					</option>
					<?php foreach ($this->movies_years as $year) { ?>
					<option <?php echo ($yearindex == $year->year) ? 'selected="selected"': '';?> value="<?php echo JRoute::_($yearUrl . '&yearindex='.$year->year);?>"><?php echo $year->year; ?></option>
					<?php } ?>
				</select>
			</label>
		</div>
	</div>
	
	<?php if(!count($this->items)) { ?>
		<div class="alert alert-warning">
			<?php echo JText::_('COM_SPMOVIEDB_NOTHING_FOUND'); ?>
		</div>
	<?php } ?>

	<div class="spmoviedb-row">
		<?php foreach ($this->items as $item) { ?>
		<div class="item spmoviedb-col-xs-12 spmoviedb-col-sm-4 spmoviedb-col-lg-<?php echo round(12/$this->columns); ?>">
			<div class="movie-poster">
				<img src="<?php echo JUri::root() . $item->profile_image; ?>" alt="<?php echo $item->profile_image->title; ?>">
				<?php if( (count($item->turls) > 0) && $item->turls ){ ?>
				<a class="play-icon play-video" href="<?php echo $item->turls[0]['src']; ?>" data-type="<?php echo $item->turls[0]['host']; ?>">
					<i class="spmoviedb-icon-play"></i>
				</a>
				<?php } else{ ?>
				<a class="play-icon" href="<?php echo $item->url; ?>">
					<i class="spmoviedb-icon-enter"></i>
				</a>
				<?php } ?>
			</div> <!-- ./movie-poster -->
			<div class="movie-details">
				<?php
				if(isset($item->ratings) && $item->ratings->count) {
					$rating = round($item->ratings->total/$item->ratings->count);
				} else {
					$rating = 0;
				} ?>
				<div class="sp-moviedb-rating-wrapper">
					<div class="sp-moviedb-rating">
						<span class="star active"></span>
					</div>
					<span class="spmoviedb-rating-summary"><span><?php echo $rating; ?></span>/<?php echo JText::_('COM_SPMOVIEDB_RATING_MAX'); ?></span>
				</div>
				<div class="movie-name">
					<a href="<?php echo $item->url; ?>"><h4 class="movie-title"><?php echo $item->title; ?></h4></a>
					<?php if(isset($item->genres) && $item->genres){ ?>
						<span><?php echo JLayoutHelper::render('movie.genres', array('genres'=>$item->genres)); ?></span>
					<?php } ?>
				</div>
			</div> <!-- /.movie-details -->
		</div> <!-- /.item -->
		<?php } ?>
	</div> <!-- ./spmoviedb-row -->
	<?php //} // END:: Array chunk ?>
</div> <!-- ./spmoviedb-row-fluid -->

<div class="video-container">
	<span class="video-close"><i class="spmoviedb-icon-close"></i></span>
</div> <!-- /.video-container -->

<?php if ($this->pagination->get('pages.total') >1) { ?>
<?php echo $this->pagination->getPagesLinks(); ?>
<?php } ?>
</div> <!-- /.com-sp-moviedb -->