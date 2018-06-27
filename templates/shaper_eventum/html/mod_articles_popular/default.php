<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_articles_popular
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
?>
<div class="mostread<?php echo $moduleclass_sfx; ?>">
<?php foreach ($list as $item) : ?>
	<div itemscope itemtype="http://schema.org/Article" class="clearfix">

		<?php $params  = $item->params; ?>
		<?php $images = json_decode($item->images); ?>
			<?php if (isset($images->image_intro) && !empty($images->image_intro)) : ?>
				<div class="entry-image"> 
					<?php if ($params->get('link_titles') && $params->get('access-view')) : ?>
					<a href="<?php echo JRoute::_(ContentHelperRoute::getArticleRoute($item->slug, $item->catid, $item->language)); ?>"><img
						<?php if ($images->image_intro_caption):
						echo 'class="caption"' . ' title="' . htmlspecialchars($images->image_intro_caption) . '"';
						endif; ?>
						src="<?php echo htmlspecialchars($images->image_intro); ?>" alt="<?php echo htmlspecialchars($images->image_intro_alt); ?>" itemprop="thumbnailUrl"/></a>
					<?php else : ?><img
					<?php if ($images->image_intro_caption):
					echo 'class="caption"' . ' title="' . htmlspecialchars($images->image_intro_caption) . '"';
					endif; ?>
					src="<?php echo htmlspecialchars($images->image_intro); ?>" alt="<?php echo htmlspecialchars($images->image_intro_alt); ?>" itemprop="thumbnailUrl"/>
				<?php endif; ?> 
			</div>
		<?php endif; ?>

		<a href="<?php echo $item->link; ?>" itemprop="url">
			<span itemprop="name">
				<?php echo $item->title; ?>
			</span>
		</a>
		<small><?php echo JHtml::_('date', $item->created, JText::_('DATE_FORMAT_LC3')); ?></small>
	</div>
<?php endforeach; ?>
</div>
