<?php
/**
 * @package     SP Movie Databse
 *
 * @copyright   Copyright (C) 2010 - 2016 JoomShaper. All rights reserved.
 * @license     GNU General Public License version 2 or later.
 */

defined('_JEXEC') or die('Restricted Access');

$review = $displayData['review'];
$user = JFactory::getUser();
$can_rate = ($user->id) ? 'can-rate': '';

?>

<?php if($review) { ?>
<div id="reviewers-form-popup" style="display:none">
	<a class="close-popup" href="#"><i class="fa fa-times"></i></a>
	<?php } ?>
	<div class="review-wrap reviewers-form">
		<i class="fa fa-spinner fa-spin"></i>

		<div class="profile-img">
			<img src="//www.gravatar.com/avatar/<?php echo md5($user->email); ?>?s=68" alt="<?php echo $user->name; ?>">
		</div>
		<div class="review-box clearfix">
			<?php if($user->id) { ?>
			<p class="reviewers-name">
				<span><?php echo $user->name; ?></span>
			</p>
			<?php } ?>
			
			<?php
			if($review) {
				$rating = $review->rating;
			} else {
				$rating = 1;
			}
			echo JLayoutHelper::render('review.ratings', array('rating'=>$rating, 'class'=>$can_rate));
			?>
			<div class="reviewers-review">
				<form id="form-movie-review">
					<?php if($review) { ?>
					<textarea name="review" id="input-review" placeholder="Write Your Review" cols="30" rows="10"><?php echo $review->review; ?></textarea>
					<input type="hidden" id="input-rating" name="rating" value="<?php echo $review->rating; ?>">
					<input type="hidden" id="input-review-id" name="review_id" value="<?php echo $review->spmoviedb_review_id; ?>">
					<?php } else { ?>
					<textarea name="review" id="input-review" placeholder="Write Your Review" cols="30" rows="10" <?php echo ($user->id) ? '': 'disabled="disabled"'; ?>></textarea>
					<input type="hidden" id="input-rating" name="rating" value="1">
					<input type="hidden" id="input-review-id" name="review_id" value="">
					<?php } ?>

					<input type="hidden" name="movie_id" value="<?php echo $displayData['movie_id']; ?>">
					<?php if($user->id) { ?>
					<input type="submit" value="<?php echo JText::_('COM_SPMOVIEDB_SUBMIT_REVIEW'); ?>" id="submit-review" class="btn btn-success btn-lg pull-right">
					<?php } else { ?>
					<a href="<?php echo JRoute::_('index.php?option=com_users&view=login&return=' . base64_encode($displayData['url'])); ?>" class="btn btn-success btn-lg pull-right"><i class="fa fa-lock"></i> <?php echo JText::_('COM_SPMOVIEDB_LOGIN_TO_REVIEW'); ?></a>
					<?php } ?>
				</form>
			</div>
		</div>
	</div>
	
	<?php if($review) { ?>
</div>
<?php } ?>
