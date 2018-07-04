<?php
use SpeventsHelper as H;
defined('_JEXEC') or die;

$user = JFactory::getUser();

$listOrder = $this->escape($this->state->get('list.ordering'));

$listDirn = $this->escape($this->state->get('list.direction'));

$canOrder = $user->authorise('core.edit.state','com_spevents.category');
$saveOrder = $listOrder == 'a.ordering';

$doc = JFactory::getDocument();
$doc->addStyleSheet( JURI::base(true) . '/components/com_spevents/assets/css/spevents-structure.css');
$doc->addStyleSheet( JURI::base(true) . '/components/com_spevents/assets/css/fontawesome.css');
$doc->addStyleSheet( JURI::base(true) . '/components/com_spevents/assets/css/spevents.css');


if($saveOrder) {
	$saveOrderingUrl = 'index.php?option=com_spevents&task=dashboards.saveOrderAjax&tmpl=component';
	JHtml::_('sortablelist.sortable', 'eventList','adminForm', strtolower($listDirn),$saveOrderingUrl);
}



JHtml::_('jquery.framework', false);

?>

<script type="text/javascript">
    Joomla.orderTable = function() {
        //table = document.getELementById('sortTable');
        table = document.getElementById('sortTable');
        direction = document.getElementById('directionTable');

        order = table.options[table.selectedIndex].value;

        if (order != '<?php echo $listOrder; ?>') {
            dirn = 'asc';
        } else {
            dirn = direction.options[direction.selectedIndex].value;
        }

        Joomla.tableOrdering(order, dirn, '');
    }

</script>

<div class="spevents spevents-view-dashboard">

    <?php if (!empty($this->sidebar)) : ?>
        <div id="j-sidebar-container" class="span2">
            <?php echo $this->sidebar; ?>
        </div>



        <div id="j-main-container" class="span10" >
            <?php else: ?>
                <div id="j-main-container"></div>
            <?php endif; ?>
            
            <div class="spevents-row">
                <div class="spevents-col-lg-4">
                        <div class="total-categories departments spevents-box">
                            <i class="icon icon-grid"></i>
                            <span class="count"><?php echo $this->categories->total_categories; ?></span>
                            <span class="title"><?php echo JText::_('COM_SPEVENTS_DASHBOARD_CATEGORIES'); ?></span>
                        </div>
                    </div>
                <div class="spevents-col-lg-4">
                    <div class="total-categories departments spevents-box">
                        <i class="fa fa-calendar-alt"></i>
                        <span class="count"><?php echo $this->events->total_events; ?></span>
                        <span class="title"><?php echo JText::_('COM_SPEVENTS_DASHBOARD_EVENTS'); ?></span>
                    </div>
                </div>
                <div class="spevents-col-lg-4">
                    <div class="total-categories departments spevents-box">
                        <i class="fa fa-microphone"></i>
                        <span class="count"><?php echo $this->speakers->total_speakers; ?></span>
                        <span class="title"><?php echo JText::_('COM_SPEVENTS_DASHBOARD_SPEAKERS'); ?></span>
                    </div>
                </div>
            </div>

            <div class="spevents-row">
                <div class="spevents-col-lg-6">
                    <div class="spevents-box">
                        <h6>Lastest Events <a href="<?php echo JRoute::_('index.php?option=com_spevents&view=events'); ?>" class="pull-right btn btn-link" style="color: #000;">(see all)</a></h6>
                        <table class="spevents-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th><?php echo JText::_('JGLOBAL_TITLE'); ?></th>
                                    <th><?php echo JText::_('COM_SPEVENTS_DASHBOARD_LOCATION'); ?></th>
                                    <th><?php echo JText::_('COM_SPEVENTS_DASHBOARD_START_TIME'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($this->eventList as $key => $item){ ?>
                                <tr>
                                    <td><?php echo ($key+1); ?></td>
                                    <td><?php echo $item->title; ?></td>
                                    <td><?php echo !empty($item->venue) ? $item->venue : '----'; ?></td>
                                    <td><?php echo date('d F, Y h:i A', strtotime($item->start_time)); ?></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="spevents-col-lg-6">
                    <div class="spevents-box">
                        <h6>Upcoming Events <a href="<?php echo JRoute::_('index.php?option=com_spevents&view=events'); ?>" class="pull-right btn btn-link" style="color: #000;">(see all)</a></h6>
                        <table class="spevents-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th><?php echo JText::_('JGLOBAL_TITLE'); ?></th>
                                    <th><?php echo JText::_('COM_SPEVENTS_DASHBOARD_LOCATION'); ?></th>
                                    <th><?php echo JText::_('COM_SPEVENTS_DASHBOARD_START_TIME'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($this->upcomingEvents as $key => $item){ ?>
                                <tr>
                                    <td><?php echo ($key+1); ?></td>
                                    <td><?php echo $item->title; ?></td>
                                    <td><?php echo !empty($item->venue) ? $item->venue : '----'; ?></td>
                                    <td><?php echo date('d F, Y h:i A', strtotime($item->start_time)); ?></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="spevents-row">
                <div class="spevents-col-lg-6">
                    <div class="spevents-box">
                        <h6>Latest Speakers <a href="<?php echo JRoute::_('index.php?option=com_spevents&view=speakers'); ?>" class="pull-right btn btn-link" style="color: #000;">(see all)</a></h6>
                        <table class="spevents-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th><?php echo JText::_('COM_SPEVENTS_DASHBOARD_NAME'); ?></th>
                                    <th><?php echo JText::_('COM_SPEVENTS_DASHBOARD_DESIGNATION'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($this->speakerList as $key => $item){ ?>
                                <tr>
                                    <td><?php echo ($key+1); ?></td>
                                    <td><?php echo $item->title; ?></td>
                                    <td><?php echo $item->designation; ?></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            <input type="hidden" name="task" value="" />

            <input type="hidden" name="boxchecked" value="0" />
            <input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
            <input type="hidden" name="filter_order_Dir" value="<?php echo $lilstDirn; ?>" />

            <?php echo JHtml::_('form.token'); ?>

        </div>
    </div>

