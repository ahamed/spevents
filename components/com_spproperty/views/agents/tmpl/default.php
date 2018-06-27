<?php

/**
 * @package     SP Property
 *
 * @copyright   Copyright (C) 2010 - 2016 JoomShaper. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die('resticted aceess');

?>

<div id="spproperty" class="spproperty spproperty-view-agents spproperty-agents">

    <?php echo JLayoutHelper::render('agents.agents', array('agents' => $this->items, 'columns' => $this->columns)); ?>

    <?php if ($this->pagination->get('pages.total')>1) { ?>
      <div class="pagination">
        <?php echo $this->pagination->getPagesLinks(); ?>
      </div>
    <?php } ?>

</div> <!-- /.spproperty-view-agents -->












