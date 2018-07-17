<?php
/**
* @package     SP Movie Databse
* @copyright   Copyright (C) 2010 - 2016 JoomShaper. All rights reserved.
* @license     GNU General Public License version 2 or later.
*/

defined('_JEXEC') or die('Restricted Access');

?>
<div class="user-reviews">
	<div id="my-reviews" class="spmoviedb sp-moviedb-view-myreviews">

		<?php if(!count($this->myreviews)) { ?>
		<div class="alert alert-warning">
			<?php echo JText::_('COM_SPMOVIEDB_NOTHING_FOUND'); ?>
		</div>
		<?php } ?>

		<?php foreach ($this->myreviews as $key => $myreview) { ?>
		<div class="review-wrap review-item" id="review-id-<?php echo $myreview->spmoviedb_review_id; ?>">
			<div class="review-box">

				<h4 class="movie-title">
					<a href="<?php echo $myreview->url; ?>">
						<?php echo $myreview->title; ?>
					</a>
				</h4>

				<?php echo JLayoutHelper::render('review.ratings', array('rating'=>$myreview->rating)); ?>

				<div class="reviewers-review">
					<div class="date-time">
						<i class="spmoviedb-icon-clock"></i><span class="sppb-meta-date" itemprop="dateCreated"><?php echo SpmoviedbHelper::timeago($myreview->created_on); ?></span>
					</div>
					<div class="clearfix"></div>
					<div class="review-message">
						<p><?php echo nl2br($myreview->review); ?></p>
					</div>
				</div>
			</div>
		</div>
		<?php } ?>
	</div>
</div>