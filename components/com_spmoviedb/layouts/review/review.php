<?php
/**
 * @package     SP Movie Databse
 *
 * @copyright   Copyright (C) 2010 - 2016 JoomShaper. All rights reserved.
 * @license     GNU General Public License version 2 or later.
 */

defined('_JEXEC') or die('Restricted Access');

$review = $displayData['review'];

if(isset($review) && $review) {
?>
<div class="review-wrap review-item" id="review-id-<?php echo $review->spmoviedb_review_id; ?>" data-review_id="<?php echo $review->spmoviedb_review_id; ?>">
	<div class="profile-img">
		<img src="//www.gravatar.com/avatar/<?php echo md5($review->email); ?>?s=68" alt="">
	</div>
	<div class="review-box">
		<?php echo JLayoutHelper::render('review.ratings', array('rating'=>$review->rating)); ?>

		<div class="reviewers-review">
			<p class="pull-left reviewers-name">
				<?php echo $review->name; ?>
			</p>
			<div class="date-time">
				<i class="spmoviedb-icon-clock"></i><span class="sppb-meta-date" itemprop="dateCreated"><?php echo SpmoviedbHelper::timeago($review->created_on); ?></span>
			</div>
			<div class="clearfix"></div>
			<?php if(isset($review->review) && $review->review) { ?>
			<div class="review-message">
				<p>
					<?php echo nl2br($review->review); ?>
				</p>
			</div>
			<?php } ?>
		</div>
	</div>
</div>
<?php }