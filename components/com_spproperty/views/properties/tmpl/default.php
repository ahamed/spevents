<?php

/**
 * @package     SP Property
 *
 * @copyright   Copyright (C) 2010 - 2016 JoomShaper. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die('resticted aceess');

$input 		   = JFactory::getApplication()->input;
$catid 		   = $input->get('catid', NULL, 'INT');
$searchitem  = $input->get('searchitem', NULL, 'INT');

//$catid = ($catid) ? $catid : $this->catid;

?>

<div id="sp-property-properties " class="spproperty-view-properties spproperty">

    <?php if(!$searchitem && !$this->catid) { // if isn't search ?>
    	<?php echo JLayoutHelper::render('properties.properties_sort', array('property_types' => $this->property_types, 'property_total' => $this->property_total, 'catid' => $catid, 'all_properties_url' => $this->all_properties_url)); ?>
    <?php } ?>

    <?php echo JLayoutHelper::render('properties.properties', array('properties' => $this->items, 'columns' => $this->columns)); ?>


    <?php if ($this->pagination->get('pages.total')>1) { ?>
      <div class="pagination">
        <?php echo $this->pagination->getPagesLinks(); ?>
      </div>
    <?php } ?>

</div>
