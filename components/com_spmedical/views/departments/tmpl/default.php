<?php
/**
* @package com_spmedical
* @author JoomShaper http://www.joomshaper.com
* @copyright Copyright (c) 2010 - 2018 JoomShaper
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/

// No Direct Access
defined ('_JEXEC') or die('Restricted Access');

?>

<div id="spmedical" class="spmedical view-spmedical-departments spmedical-departments-list">
	<?php echo JLayoutHelper::render('departments.departments', array('departments' => $this->items, 'columns' => $this->columns, 'logo_type' => $this->logo_type)); ?>
</div> <!-- /#spmedical -->

<?php if ($this->params->get('hide_pagination') == 0) {?>
	<?php if ($this->pagination->get('pages.total') >1) { ?>
	<div class="pagination">
		<?php echo $this->pagination->getPagesLinks(); ?>
	</div>
	<?php } ?>
<?php } ?>