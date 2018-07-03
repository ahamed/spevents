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
                            <span class="title">Categories</span>
                        </div>
                    </div>
                <div class="spevents-col-lg-4">
                    <div class="total-categories departments spevents-box">
                        <i class="fa fa-calendar-alt"></i>
                        <span class="count"><?php echo $this->events->total_events; ?></span>
                        <span class="title">Events</span>
                    </div>
                </div>
                <div class="spevents-col-lg-4">
                    <div class="total-categories departments spevents-box">
                        <i class="fa fa-microphone"></i>
                        <span class="count"><?php echo $this->speakers->total_speakers; ?></span>
                        <span class="title">Speakers</span>
                    </div>
                </div>
            </div>

            <div class="spevents-row">
                <div class="spevents-col-lg-6">
                    <div class="spevents-box">
                        <h6>Lastest Events</h6>
                        <table class="spevents-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Title</th>
                                    <th>ID</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($this->items as $key => $item){ ?>
                                <tr>
                                    <td><?php echo ($key+1); ?></td>
                                    <td><?php echo $item->title; ?></td>
                                    <td><?php echo $item->id; ?></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="spevents-col-lg-6">
                    <div class="spevents-box">
                        <h6>Latest Speakers</h6>
                        <table class="spevents-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Title</th>
                                    <th>ID</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($this->speakerList as $key => $item){ ?>
                                <tr>
                                    <td><?php echo ($key+1); ?></td>
                                    <td><?php echo $item->title; ?></td>
                                    <td><?php echo $item->id; ?></td>
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

