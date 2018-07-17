<?php
/**
 * @package     SP Movie Databse
 *
 * @copyright   Copyright (C) 2010 - 2016 JoomShaper. All rights reserved.
 * @license     GNU General Public License version 2 or later.
 */

defined('_JEXEC') or die('Restricted Access');

$rating 	= $displayData['rating'];

$class = '';
if(isset($displayData['class']) && $displayData['class']) {
	$class 		= $displayData['class'];
}

?>
<div class="sp-moviedb-rating <?php echo $class; ?>">
	<?php
	$max_rating = 10;
	$j = 0;
	for($i = $rating; $i < $max_rating; $i++){
		echo '<span class="star" data-rating_val="'.($max_rating-$j).'"></span>';
		$j = $j+1;
	}
	for ($i = 0; $i < $rating; $i++)
	{
		echo '<span class="star active" data-rating_val="'.($rating - $i).'"></span>';
	}
	?>
</div>
<span class="spmoviedb-rating-summary"><span><?php echo $rating; ?></span>/10</span>