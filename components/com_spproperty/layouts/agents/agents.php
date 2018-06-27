<?php
/**
 * @package     SP Property
 *
 * @copyright   Copyright (C) 2010 - 2016 JoomShaper. All rights reserved.
 * @license     GNU General Public License version 2 or later.
 */

defined('_JEXEC') or die('Restricted Access');

$agents = $displayData['agents'];
$columns = $displayData['columns'];

if (count($agents)) { ?>
    <?php foreach (array_chunk($agents, $columns) as $agents) { ?>
        <div class="row">
            <?php foreach ($agents as $agent) { ?>
                <div class="spproperty-col-sm-<?php echo round(12 / $columns); ?>">
                    <?php echo JLayoutHelper::render('agents.agent', array('agent' => $agent, 'desc_limit' => true)); ?>
                </div> <!-- /.col-sm- -->
            <?php } ?>
        </div> <!-- /.row -->
    <?php } ?>
    
<?php } else { ?>
    <div class="row">
        <div class="spproperty-col-sm-12 sp-no-item-found">
            <p><?php echo JText::_('COM_SPPROPERTY_NO_ITEMS_FOUND'); ?></p>
        </div>
    </div>
<?php } ?>