<?php
/**
 * @package     SP Property
 *
 * @copyright   Copyright (C) 2010 - 2016 JoomShaper. All rights reserved.
 * @license     GNU General Public License version 2 or later.
 */

defined('_JEXEC') or die('Restricted Access');

$property_total     = $displayData['property_total'];
$all_properties_url = $displayData['all_properties_url'];
$property_types     = $displayData['property_types'];
$catid  	          = $displayData['catid'];

?>

<?php if($property_total){ ?>
    <ul class="spproperty-listing-url">
        <li <?php echo ($catid == '') ? 'class="active"': '';?>>
            <a href="<?php echo $all_properties_url; ?>"><?php echo JText::_('COM_SPPROPERTY_ALL') . ' (' . $property_total . ')';?></a>
        </li>
        <?php foreach ($property_types as $property_type) { ?>
            <li <?php echo ($catid == $property_type->spproperty_category_id) ? 'class="active"': '';?>>
                <a href="<?php echo $property_type->url; ?>"><?php echo $property_type->title . ' (' . $property_type->this_count . ')';?></a>
            </li>

        <?php } ?>
    </ul>
<?php } ?>
