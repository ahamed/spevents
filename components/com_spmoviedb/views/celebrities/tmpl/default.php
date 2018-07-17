<?php
/**
 * @package     SP Movie Databse
 *
 * @copyright   Copyright (C) 2010 - 2016 JoomShaper. All rights reserved.
 * @license     GNU General Public License version 2 or later.
 */

defined('_JEXEC') or die('Restricted Access');

$input = JFactory::getApplication()->input;
$Itemid = $input->get('Itemid', 0, 'INT');
$alphaindex = $input->get('alphaindex', 'all', 'WORD');

$allAlphaUrl = 'index.php?option=com_spmoviedb&view=celebrities&Itemid=' . $Itemid;

if ($alphaindex) {
	$alphaUrl = 'index.php?option=com_spmoviedb&view=celebrities&alphaindex='. $alphaindex .'&Itemid=' . $Itemid;
}else{
	$alphaUrl = 'index.php?option=com_spmoviedb&view=celebrities&Itemid=' . $Itemid;
}

?>

<div id="com-sp-moviedb" class="spmoviedb sp-moviedb sp-moviedb-view-celebrities">

	<div class="moviedb-filters">
		<div class="pull-left">
			<ul>
				<li class="<?php echo ($alphaindex == 'all') ? 'active': '';?>">
					<a href="<?php echo JRoute::_($allAlphaUrl);?>"><?php echo JText::_('COM_SPMOVIEDB_ALL'); ?></a>
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
		<div class="pull-right">
			<?php echo JText::_('COM_SPMOVIEDB_TOTAL'); ?>: 
			<strong><?php echo $this->total_celebrities; ?></strong>
		</div>
	</div>

	<?php if(!count($this->items)) { ?>
	<div class="alert alert-warning">
		<?php echo JText::_('COM_SPMOVIEDB_NOTHING_FOUND'); ?>
	</div>
	<?php } ?>

	<?php foreach(array_chunk($this->items, $this->columns) as $this->items) { ?>
	<div class="spmoviedb-row">
		<?php foreach ($this->items as $celebrity) {?>
		<div class="item spmoviedb-col-sm-<?php echo round(12/$this->columns); ?>">
			<div class="celebritie-poster">
				<img src="<?php echo JUri::root() . $celebrity->profile_image; ?>" alt="<?php echo $celebrity->title; ?>">
				<a href="<?php echo $celebrity->url; ?>" class="play-icon"><i class="spmoviedb-icon-celebrities"></i></a>
			</div>
			<div class="celebritie-details">
				<div class="celebritie-name">
					<a href="<?php echo $celebrity->url; ?>"><h4 class="celebritie-title"><?php echo $celebrity->title; ?></h4></a>
					<span><?php echo $celebrity->designation; ?></span>
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