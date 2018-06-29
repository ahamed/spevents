<?php
/**
* @package com_spmedical
* @author JoomShaper http://www.joomshaper.com
* @copyright Copyright (c) 2010 - 2018 JoomShaper
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/

// No Direct Access
defined ('_JEXEC') or die('Restricted Access');

$this->columns = $this->params->get('columns', '3');

?>

<div id="spmedical" class="spmedical view-spmedical-specialists spmedical-specialists-list">
	<!-- spmedical-specialists-search -->
	<?php echo JLayoutHelper::render('specialists.search', array('specialists' => $this->specialists)); ?>
	<!-- spmedical-specialists-search-result -->
	<div class="spmedical-specialists-search-result">
		<div class="spmedical-row">
			<?php echo JLayoutHelper::render('specialists.filter', array('specialists' => $this->items, 'specialities' => $this->specialities, 'departments' => $this->departments)); ?>
			<?php echo JLayoutHelper::render('specialists.items', array('specialists' => $this->items)); ?>
		</div>
	</div> <!-- //.spmedical-specialists-search-result -->
</div> <!-- /#spmedical -->

<?php if ($this->params->get('hide_pagination') == 0) { ?>
	<?php if ($this->pagination->get('pages.total') >1) { ?>
		<div class="pagination">
			<?php echo $this->pagination->getPagesLinks(); ?>
		</div>
	<?php } ?>
<?php } ?>
