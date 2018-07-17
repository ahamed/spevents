<?php
/**
 * @package     SP Movie Databse
 *
 * @copyright   Copyright (C) 2010 - 2016 JoomShaper. All rights reserved.
 * @license     GNU General Public License version 2 or later.
 */

defined('_JEXEC') or die('Restricted Access');

JHtml::_('jquery.framework');
$input = JFactory::getApplication()->input;
$doc = JFactory::getDocument();
$user = JFactory::getUser();
$doc->addScript(JURI::base(true) . '/components/com_spmoviedb/assets/js/spmoviedb.js');
$doc->addScriptdeclaration('var spmoviedb_url="'. JURI::base() .'index.php?option=com_spmoviedb";');

JText::script('COM_SPMOVIEDB_REVIEW_UPDATED');
?>

<div id="spmoviedb" class="spmoviedb view-spmoviedb-movie">

	<!-- movie cover -->
	<div class="movie-cover" style="background-image: url(<?php echo JURI::root(). $this->item->cover_image; ?>); ">
		<div class="spmoviedb-container">
			<div class="spmoviedb-row">
				<div class="spmoviedb-col-sm-9 spmoviedb-col-sm-offset-3">
					<div class="movie-info-warpper">
						<div class="movie-info">
						<div class="pull-left">
							<h1 class="movie-title"><?php echo $this->item->title; ?></h1>
							<?php if(isset($this->item->genres) && $this->item->genres){ ?>
							<span class="tag"><?php echo JLayoutHelper::render('movie.genres', array('genres'=>$this->item->genres)); ?></span> | 
							<?php } if(isset($this->item->duration) && $this->item->duration){ ?>
								<span class="movie-duration"><?php echo $this->item->duration; ?></span>
							<?php } ?>
							<div class="rating-star">
								<span><?php echo JText::_('COM_SPMOVIEDB_MOVIE_YOUR_RATTING'); ?>:</span>
								<?php if(isset($this->ratings) && $this->ratings->count) {
									$rating = round($this->ratings->total/$this->ratings->count);
								} else {
									$rating = 0;
								} ?>
								<?php echo JLayoutHelper::render('review.ratings', array('rating'=>$rating)); ?>
							</div> <!-- ?rating-star -->

							<?php if ( isset($this->item->facebook) || isset($this->item->twitter) || isset($this->item->gplus) || isset($this->item->youtube) || isset($this->item->vimeo) || isset($this->item->website) ) { ?>
								<div class="movie-social-icon">
									<ul>
										<?php if(isset($this->item->facebook) && $this->item->facebook){ ?>
											<li>
												<a class="facebook" href="<?php echo $this->item->facebook; ?>">
												<i class="spmoviedb-icon-facebook"></i></a>
											</li>
										<?php } if(isset($this->item->twitter) && $this->item->twitter){ ?>
											<li>
												<a class="twitter" href="<?php echo $this->item->twitter; ?>">
												<i class="spmoviedb-icon-twitter"></i></a>
											</li>
										<?php } if(isset($this->item->gplus) && $this->item->gplus){ ?>
											<li>
												<a class="googleplus" href="<?php echo $this->item->gplus; ?>">
												<i class="spmoviedb-icon-google-plus"></i></a>
											</li>
										<?php } if(isset($this->item->youtube) && $this->item->youtube){ ?>
											<li>
												<a class="youtube" href="<?php echo $this->item->youtube; ?>">
												<i class="spmoviedb-icon-youtube"></i></a>
											</li>
										<?php } if(isset($this->item->vimeo) && $this->item->vimeo){ ?>
											<li>
												<a class="vimeo" href="<?php echo $this->item->vimeo; ?>">
												<i class="spmoviedb-icon-vimeo"></i></a>
											</li>
										<?php } if(isset($this->item->website) && $this->item->website){ ?>
											<li>
												<a class="vimeo" href="<?php echo $this->item->website; ?>">
												<i class="spmoviedb-icon-web"></i></a>
											</li>
										<?php } ?>
									</ul>
								</div> <!-- /.movie-social-icon -->								
							<?php } ?>
							
						</div>
						<div class="pull-right count-rating-wrapper">
							<div class="count-rating">
								<span>
									<?php if(isset($this->ratings) && $this->ratings->count) {
										$rating = round($this->ratings->total/$this->ratings->count);
									} else {
										$rating = 0;
									} 
									echo $rating;
									?>
								</span>
							</div>
						</div>
					</div>  <!-- //movie-info -->
					<div class="clearfix"></div>
					</div>
				</div>
		</div>
		</div>

	</div> <!-- //end cover -->

	<!-- movie details -->
	<div class="movie-details-wrap">
		<div class="spmoviedb-container">
			<div class="spmoviedb-row">
				<div id="movie-info-sidebar" class="spmoviedb-col-sm-3 movie-info-sidebar">
					<div class="img-wrap">
						<div class="item-img">
							<img src="<?php echo JURI::root(). $this->item->profile_image; ?>" alt="">
						</div>
					 	<div class="spmoviedb-details-wrapper">
					 		<h3 class="title"><?php echo JText::_('COM_SPMOVIEDB_MOVIE_INFO'); ?></h3>
					 		<ul class="list-style-none list-inline">
					 			<?php if(isset($this->item->directors) && $this->item->directors){ ?>
					 			<li class="director">
					 				<span><?php echo JText::_('COM_SPMOVIEDB_DIRECTOR'); ?>: </span>
					 				<?php echo $this->item->directors; ?>
					 			</li>
					 			<?php } if(isset($this->item->actors) && $this->item->actors){ ?>
					 			<li class="actors">
					 				<span><?php echo JText::_('COM_SPMOVIEDB_MOVIE_ACTORS'); ?>: </span>
					 				<?php echo $this->item->actors; ?>
					 			</li>
					 			<?php } if(isset($this->item->release_date) && $this->item->release_date){ ?>
					 			<li class="release-date">
					 				<span><?php echo JText::_('COM_SPMOVIEDB_MOVIE_RELEASED_DATE'); ?>: </span>
					 				<?php echo JHTML::date($this->item->release_date, 'd M, Y'); ?>
					 			</li>
					 			<?php } if(isset($this->item->genres) && $this->item->genres){ ?>
					 			<li class="genres">
					 				<span><?php echo JText::_('COM_SPMOVIEDB_MOVIE_GENRES'); ?>: </span>
					 				<?php echo JLayoutHelper::render('movie.genres', array('genres'=>$this->item->genres)); ?>
					 			</li>
					 			<?php } if(isset($this->item->country) && $this->item->country){ ?>
					 			<li class="country">
					 				<span><?php echo JText::_('COM_SPMOVIEDB_MOVIE_COUNTRY'); ?>:</span>
					 				<?php echo $this->item->country; ?>
					 			</li>
					 			<?php } if(isset($this->item->m_language) && $this->item->m_language){ ?>
					 			<li class="language">
					 				<span><?php echo JText::_('COM_SPMOVIEDB_MOVIE_LANGUAGE'); ?>:</span> 
					 				<?php echo $this->item->m_language; ?>
					 			</li>
					 			<?php } ?>
					 		</ul>
					 	</div> <!-- //spmoviedb-details-wrapper -->
					 </div>
					 <?php if(isset($this->item->dvdlink) && $this->item->dvdlink){ ?>
					 	<a href="<?php echo $this->item->dvdlink; ?>" class="btn sppb-btn-primary btn-block buy-ticket" target="_blank">
					 		<i class="sp-moview-ticket"></i> <?php echo JText::_('COM_SPMOVIEDB_MOVIE_BUY_DVD'); ?>
					 	</a>
					 <?php } ?>

				</div> <!-- movie-info-sidebar -->

				<div class="spmoviedb-col-sm-9 movie-info-warpper">
					
					<!-- movie-details -->
					<div class="movie-details">
						<div class="header-title">
							<span><i class="spmoviedb-icon-story"></i></span> <h3 class="title"><?php echo JText::_('COM_SPMOVIEDB_MOVIE_STORY'); ?></h3>
						</div>
						<div class="movie-details-text">
							<?php echo $this->item->movie_story; ?>
						</div>

						<div class="movie-social-icon">
							<span><?php echo JText::_('COM_SPMOVIEDB_MOVIE_SOCIAL_SHARE'); ?>:</span>
							<?php echo JLayoutHelper::render('social_share', array('url'=>$this->item->url, 'title' =>$this->item->title)); ?>
						</div> <!-- /.social-icon -->

					</div> <!-- //movie-details -->

					<!-- trailers -->
					<?php if( (count($this->item->turls) > 0) && $this->item->turls ){ 
						echo JLayoutHelper::render('movie.trailers', array('trailers'=>$this->item->turls));
					 } ?>

					<div class="clearfix"></div>

					<div class="user-reviews">
						<div class="reviews-menu">
							<div class="header-title pull-left">
								<span><i class="spmoviedb-icon-user-review"></i></span> <h3 class="title">Reviews <small>( <?php echo count($this->reviews); ?> )</small></h3>
							</div>
							<div class="pull-right">
								<ul class="list-inline list-style-none">
									<?php if($this->myReview) { ?>
										<li><a id="spmoviedb-my-review" href="#"><i class="spmoviedb-icon-write"></i> <?php echo JText::_('COM_SPMOVIEDB_EDIT_REVIEW'); ?></a></li>
									<?php } ?>

									<?php if($user->guest) { ?>
										<li><a href="<?php echo JRoute::_('index.php?option=com_users&view=login&return=' . base64_encode('index.php?option=com_spmoviedb&view=movie&id=' . $this->item->spmoviedb_movie_id . ':' . $this->item->slug . SpmoviedbHelper::getItemid('movies'))); ?>"><i class="spmoviedb-icon-write"></i> <?php echo JText::_('COM_SPMOVIEDB_LOGIN_TO_REVIEW'); ?></a></li>
									<?php } ?>
								</ul>
							</div>
						</div><!--/.reviews-menu -->
						<div class="clearfix"></div>

						<?php echo JLayoutHelper::render('review.form', array('review'=>$this->myReview, 'movie_id'=>$this->item->spmoviedb_movie_id, 'url'=>'index.php?option=com_spmoviedb&view=movie&id=' . $this->item->spmoviedb_movie_id . ':' . $this->item->slug . SpmoviedbHelper::getItemid('movies'))); ?>

						<div id="reviews">
							<?php
							foreach ($this->reviews as $key => $this->review) {
								echo JLayoutHelper::render('review.review', array('review'=>$this->review));
							}
							?>
						</div>

						<?php if($this->showLoadMore) { ?>
							<a id="spmoviedb-load-review" class="btn btn-link btn-lg btn-block" data-movie_id="<?php echo $this->item->spmoviedb_movie_id; ?>" href="#"><i class="fa fa-refresh"></i> <?php echo JText::_('COM_SPMOVIEDB_REVIEW_LOAD_MORE'); ?></a>
						<?php } ?>
					</div><!--/.user-reviews-->

					<?php if(isset($this->item->show_times) && $this->item->show_times) { ?>
					<!-- Movie Showtime -->
					<div class="movie-showtime">
						<div class="header-title">
							<span><i class="spmoviedb-icon-showtime"></i></span> <h3 class="title"><?php echo JText::_('COM_SPMOVIEDB_MOVIE_SHOW_TIME'); ?></h3>
						</div>

						<?php foreach ($this->item->show_times as $showtime) { ?>
						<div class="movie-schedule spmoviedb-row">
							<div class="spmoviedb-col-sm-4 location">
								<p class="location-name"><?php echo $showtime['theatre_name']; ?></p>
								<p class="address"><i class="fa fa-map-marker"></i> <?php echo $showtime['theatre_location']; ?></p>
							</div>

							<div class="spmoviedb-col-sm-8">
								<?php if( (count($showtime['times']) > 0) && $showtime['times'] ){ ?>
								<div class="times pull-left">
									<p class="visible-xs show-time"><?php echo JText::_('COM_SPMOVIEDB_MOVIE_SHOW_TIME_TITLE'); ?></p>
									<ul class="list-style-none list-inline">
										<?php foreach ($showtime['times'] as $time) { ?>
										<li><span><?php echo $time; ?></span></li>
										<?php } ?>
									</ul>
								</div>
								<?php } ?>
								
								<?php if( (count($showtime['ticket_url']) > 0) && $showtime['ticket_url'] ){ ?>
								<div class="ticket-urls pull-right">
									<a href="<?php echo $showtime['ticket_url'] ?>" class="btn sppb-btn-primary buy-ticket" target="_blank">
										<i class="spmoviedb-icon-ticket"></i> 
										<?php echo JText::_('COM_SPMOVIEDB_MOVIE_BUY_TICKET'); ?>
									</a>
								</div>
								<?php } ?>
							</div>
						</div> <!-- //movie-schedule -->
						<div class="clearfix"></div>
						<?php } ?>

					</div> <!-- //Movie Showtime -->
					<?php } ?>
					
					<!-- Recommend movies -->
					<?php if(isset($this->related_movies) && count($this->related_movies) && $this->related_movies) { ?>
						<div class="recommend-movies">
							<div class="header-title">
								<span><i class="spmoviedb-icon-like"></i></span> <h3 class="title">Recommend movies</h3>
							</div>
							<div class="spmoviedb-row">
							<?php foreach ($this->related_movies as $this->related_movie) { ?>
							<div class="item spmoviedb-col-sm-4 spmoviedb-col-xs-12">
								<?php echo JLayoutHelper::render('movie.list_layout', array('movie'=>$this->related_movie)); ?>
							</div> 
							<?php } ?>
							</div> <!-- //spmoviedb-row -->
							
						</div> <!-- //Recommend movies -->
					<?php } ?>
				</div> <!-- //col-sm-9 -->
			</div> <!-- //spmoviedb-row -->
		</div> <!-- //spmoviedb-container -->
		<div class="video-container">
			<span class="video-close"><i class="spmoviedb-icon-close"></i></span>
		</div> <!-- /.video-container -->
	</div>
</div> <!-- //movie details -->

</div> <!-- /#spmoviedb .spmoviedb -->
