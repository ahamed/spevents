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
?>

<div id="spmoviedb" class="spmoviedb view-spmoviedb-celebrity">

	<!-- celebrity cover -->
	<div class="celebrity-cover" style="background-image: url(<?php echo JURI::root(). $this->item->cover_image; ?>); ">
		<div class="spmoviedb-container">
			<div class="spmoviedb-row">
				<div class="spmoviedb-col-sm-9 spmoviedb-col-sm-offset-3">
					<div class="celebrity-info-warpper">
						<!-- celebrity-info -->
						<div class="celebrity-info">
							<div class="">
								<h1 class="celebrity-title"><?php echo $this->item->title; ?></h1>
								<span class="designation"><?php echo $this->item->designation; ?></span>
								<div class="movie-social-icon">
									<span><?php echo JText::_('COM_SPMOVIEDB_MOVIE_SOCIAL_SHARE'); ?>:</span>
									<?php echo JLayoutHelper::render('social_share', array('url'=>$this->item->url, 'title' =>$this->item->title)); ?>
								</div> <!-- /.social-icon -->
							</div>
						</div>  <!-- //celebrity-info -->
					</div>
				</div>
			</div>			
		</div>
	</div> <!-- //end cover -->

	<!-- celebrity details -->
	<div class="celebrity-details-wrap">
		<div class="spmoviedb-container">
			<div class="spmoviedb-row">
				<div id="celebrity-info-sidebar" class="spmoviedb-col-sm-3 celebrity-info-sidebar">
					<div class="img-wrap">
						<div class="item-img">
					 		<img src="<?php echo JURI::root(). $this->item->profile_image; ?>" alt="">
						</div>
						<div class="spmoviedb-details-wrapper">
						 	<h3 class="title"><?php echo JText::_('COM_SPMOVIEDB_CELEBRITY_PERSONAL_INFO'); ?></h3>
						 	<ul class="list-style-none list-inline">
						 		<?php if(isset($this->item->birth_name) && $this->item->birth_name){ ?>
						 		<li>
						 			<span><?php echo JText::_('COM_SPMOVIEDB_CELEBRITY_BIRTHNAME'); ?>: </span>
						 			<?php echo $this->item->birth_name; ?>
						 		</li>
						 		<?php } if(isset($this->item->dob) && $this->item->dob){ ?>
						 		<li>
						 			<span><?php echo JText::_('COM_SPMOVIEDB_CELEBRITY_DOB'); ?>: </span>
						 			<?php echo JHTML::date($this->item->dob, 'd, M Y'); ?>
						 		</li>
						 		<?php } if(isset($this->item->residence) && $this->item->residence){ ?>
						 		<li>
						 			<span><?php echo JText::_('COM_SPMOVIEDB_CELEBRITY_RESIDENCE'); ?>: </span>
						 			<?php echo $this->item->residence; ?>
						 		</li>
						 		<?php } if(isset($this->item->height) && $this->item->height){ ?>
						 		<li>
						 			<span><?php echo JText::_('COM_SPMOVIEDB_CELEBRITY_HEIGHT'); ?>: </span>
						 			<?php echo $this->item->height; ?>
						 		</li>
						 		<?php } ?>
						 	</ul>
						 	<?php if ( isset($this->item->facebook) || isset($this->item->twitter) || isset($this->item->gplus) || isset($this->item->youtube) || isset($this->item->vimeo) || isset($this->item->website) ) { ?>
								<div class="movie-social-icon">
									<span><?php echo JText::_('COM_SPMOVIEDB_MOVIE_SOCIAL'); ?>:</span>
									<ul class="list-style-none list-inline">
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
								</div> <!-- /.social-icon -->
							<?php } ?>
						 </div> <!-- //spmoviedb-details-wrapper -->
					</div>
				</div> <!-- //celebrity-info-sidebar -->
				
				<div class="spmoviedb-col-sm-9 celebrity-info-warpper">
					
					<!-- celebrity-details -->
					<div class="celebrity-details">
						<div class="header-title">
							<span><i class="spmoviedb-icon-story"></i></span>
							<h3 class="title"><?php echo JText::_('COM_SPMOVIEDB_CELEBRITY_BIOGRAPHY'); ?></h3>
						</div>
						<?php echo $this->item->biography; ?>

					</div> <!-- //celebrity-details -->

					<?php if( isset($this->item->celebrity_movies) && (count($this->item->celebrity_movies) > 0) && $this->item->celebrity_movies ){ ?>
						<!-- Filmography -->
						<div class="spmoviedb-filmography col-sm-12">
							<div class="header-title">
								<span><i class="spmoviedb-icon-film"></i></span>
								<h3 class="title"><?php echo JText::_('COM_SPMOVIEDB_CELEBRITY_FILMOGRAPHY'); ?></h3>
							</div> <!-- //header-title -->
							
							<ul class="list-unstyled spmoviedb-film-list">
								<li class="main-title">
									<p class="pull-left"><?php echo JText::_('COM_SPMOVIEDB_MOVIE_NAME'); ?></p>
									<p class="pull-right"><?php echo JText::_('COM_SPMOVIEDB_MOVIE_RATINGS'); ?></p>
								</li> <!-- //main-title -->

								<?php foreach ($this->item->celebrity_movies as $c_movie) { ?>
									<li calss="movie-list">
										<div class="details pull-left">
											<div class="img-warp pull-left" style="background-image: url(<?php echo JURI::root(true) . '/' .  $c_movie->profile_image; ?>); ">
											</div>
											<div>
												<a href="<?php echo $c_movie->murl; ?>" class="movie-name">
													<strong>
														<?php echo $c_movie->title; ?>
													</strong>
												</a>
												<div class="clelarfix"></div>
												<p class="celebrity-movie-genres"> 
													<?php  $genres = new JLayoutFile('movie.genres', $basePath = JPATH_ROOT .'/components/com_spmoviedb/layouts');
			                           					 echo $genres->render(array('genres'=>$c_movie->genres));
													?> 
												</p>
											</div>
										</div> <!-- //details -->

										<div class="pull-right sp-moviedb-rating-wrap">
												<?php
								                    if(isset($c_movie->ratings) && $c_movie->ratings->count) {
								                        $rating = round($c_movie->ratings->total/$c_movie->ratings->count);
								                    } else {
								                        $rating = 0;
								                    }
								                    $layout = new JLayoutFile('review.ratings', $basePath = JPATH_ROOT .'/components/com_spmoviedb/layouts');
								                    echo $layout->render(array('rating'=>$rating));
								               	?>
										</div> <!-- /.sp-moviedb-rating-wrap -->
									</li> <!-- //movie-list -->
								<?php } ?>
								
							</ul>
						</div>
						<div class="clearfix"></div>
						<!-- //Filmography -->
					<?php } // Filmography ?>	

					<?php if( isset($this->item->actor_trailers) && (count($this->item->actor_trailers) > 0) && $this->item->actor_trailers ){ ?>
						<!-- trailers-videos -->
						<div class="trailers-videos">
							<div class="header-title pull-left">
								<span><i class="spmoviedb-icon-trailer"></i></span>
								<h3 class="title">
									<?php echo JText::_('COM_SPMOVIEDB_CELEBRITY_TRAILERS_AND_VIDEOS'); ?>
								</h3>
							</div>

							<div class="spmoviedb-row">						
								<?php foreach ($this->item->actor_trailers as $key => $trailer) {
									if ($key == 0) {
										$item_type = 'leading spmoviedb-col-sm-12';
										$trailer->thumb = $trailer->turls['tmb_large'];  
									} else {
										$item_type = 'subleading spmoviedb-col-sm-4';
										$trailer->thumb = $trailer->turls['tmb_small']; 
									}
								?>

								<div class="spmoviedb-trailer-item <?php echo $item_type; ?>">
									<div class="spmoviedb-trailer">
										<div class="trailer-image-wrap">
											<img src="<?php echo JURI::root(true). '/' . $trailer->thumb; ?>" alt="">
											<a class="play-video" href="<?php echo $trailer->turls['src']; ?>" data-type="<?php echo $trailer->turls['host']; ?>">
												<i class="play-icon spmoviedb-icon-play"></i>
											</a>
										</div>
										<div class="spmoviedb-trailer-info sp-spmoviedb-trailers-info">

											<div class="spmoviedb-trailer-info-block">
											<?php if($key == 0 ){?>
												<img src="<?php echo JURI::root(true). '/' . $trailer->turls['tmb_small']; ?>" class="thumb-img" alt="">
											<?php } ?>
												<a href="<?php echo $trailer->murl;?>">
													<h4 class="celebrity-title"><?php echo $trailer->title; ?></h4>
												</a>
												<?php //if($key == 0 ){?>
													<p class="spmoviedb-genry">
														<?php echo JLayoutHelper::render('movie.genres', array('genres'=>$trailer->genres)); ?>
													</p>
												<?php //} ?>
											</div>
										</div>

									</div>
								</div>
								<?php } ?>
							</div> <!-- ./spmoviedb-row -->

							<div class="video-container">
								<span class="video-close"><i class="spmoviedb-icon-close"></i></span>
							</div> <!-- /.video-container -->

						</div> <!-- //trailers-videos -->
						<?php } ?>

					<div class="clearfix"></div>
				</div> <!-- //col-sm-9 -->
			</div> <!-- //spmoviedb-row -->
		</div> <!-- //spmoviedb-container -->
	</div>
</div> <!-- //celebrity details -->

</div> <!-- /#spmoviedb .spmoviedb -->