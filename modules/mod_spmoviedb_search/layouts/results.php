<?php
/**
 * @package     mod_sp_vmajaxsearch
 *
 * @copyright   Copyright (C) 2010 - 2016 JoomShaper. All rights reserved.
 * @license     GNU General Public License version 2 or later.
 */

// no direct access
defined('_JEXEC') or die;

// load movie model
$model = FOFModel::getAnInstance('Movies', 'SpmoviedbModel');
// load component layout
$genres = new JLayoutFile('movie.genres', $basePath = JPATH_ROOT .'/components/com_spmoviedb/layouts');

$results = $displayData['results'];
$type 	 = $displayData['type'];

// get params
jimport( 'joomla.application.module.helper' );
$module = JModuleHelper::getModule( 'mod_spmoviedb_search' );
$registry = new JRegistry();
$params = $registry->loadString($module->params);

// get show thumb
$show_thumb = $params->get('show_thumb');

$thumb_class = ($show_thumb) ? 'show-thumb': '';

?>

<ul class="spmoviedb-movie-search results-list <?php echo $thumb_class; ?>">
	<?php 
 	if (!empty($results)) {
		foreach ($results as $result) {

			// if type genre
			if( $type =='genres' ) {
				$genres_info = $model->getGenries($result->genres);
			} 

			// if type not celebrities
			if ($type !='celebrities') {
				$result->ratings 	= $model->getRatings($result->spmoviedb_movie_id);

				if(isset($result->ratings) && $result->ratings->count) {
					$rating = round($result->ratings->total/$result->ratings->count);
				} else {
					$rating = 0;
				}
			}

			?>

			<li>
				<a href="<?php echo $result->url; ?>">

				<?php if ($result->profile_image && $show_thumb) { ?>
					<img class="spmoviedb-search-movie-img" src="<?php echo JUri::root() . $result->profile_image; ?>" style="width: 40px;" />
				<?php } else { ?>
					<i class="spmoviedb-icon-search"></i>
				<?php } ?>
				
				
				<span class="spmoviedb-search-movie-genres">
					<?php
					if( $type =='genres' ) {
						echo $result->title . ' (' . $genres->render(array('genres'=>$genres_info, 'type'=>'search')) . ')';
					} else {
						echo $result->title;
					} ?>
				</span>

				<?php if ($type !='celebrities') { ?>
					<div class="sp-moviedb-rating-wrapper">
						<div class="sp-moviedb-rating">
							<span class="star active"></span>
						</div>
						<span class="spmoviedb-rating-summary"><span><?php echo $rating; ?></span>/<?php echo JText::_('COM_SPMOVIEDB_RATING_MAX'); ?></span>
					</div>
				<?php } ?>

				</a>
			</li>
	<?php  } // end:: foreach
	} else { ?>
		<li class="spmoviedb-empty">
			<?php echo JText::_('MOD_SPMOVIEDBESEARCH_NO_ITEM_FOUND'); ?>
		</li>
	<?php } ?>
</ul>
