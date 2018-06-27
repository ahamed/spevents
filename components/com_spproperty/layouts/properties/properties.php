<?php
/**
 * @package     SP Property
 *
 * @copyright   Copyright (C) 2010 - 2016 JoomShaper. All rights reserved.
 * @license     GNU General Public License version 2 or later.
 */

defined('_JEXEC') or die('Restricted Access');

// get component params
jimport('joomla.application.component.helper');
$this->cParams = JComponentHelper::getParams('com_spproperty');
$property_rm_btn = $this->cParams->get('prpry_rm_btn_text', JText::_('COM_SPPROPERTY_PROPERTIES_BTN_TEXT'));

$properties = $displayData['properties'];
$columns = $displayData['columns'];

if (count($properties)) { ?>
    <?php foreach (array_chunk($properties, $columns) as $properties) { ?>
        <div class="row">
            <?php foreach ($properties as $property) { ?>
                <div class="spproperty-col-sm-<?php echo round(12 / $columns); ?>">
                    <?php echo JLayoutHelper::render('properties.property', array('property' => $property)); ?>
                </div> <!-- /.spproperty-col-sm -->
            <?php } ?>
        </div><!--/.row-->
    <?php } ?>
<?php } else { ?>
    <div class="row">
        <div class="spproperty-col-sm-12 sp-no-item-found">
            <p><?php echo JText::_('COM_SPPROPERTY_NO_ITEMS_FOUND'); ?></p>
        </div>
    </div>
<?php } ?>