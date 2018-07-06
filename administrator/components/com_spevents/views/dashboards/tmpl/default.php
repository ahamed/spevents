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
$doc->addScript( JURI::base(true) . '/components/com_spevents/assets/js/Chart.min.js');


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
                <div class="spevents-col-lg-3">
                        <div class="total-categories departments spevents-box">
                            <i class="icon icon-grid"></i>
                            <span class="count"><?php echo $this->categories; ?></span>
                            <span class="title"><?php echo JText::_('COM_SPEVENTS_DASHBOARD_CATEGORIES'); ?></span>
                        </div>
                    </div>
                <div class="spevents-col-lg-3">
                    <div class="total-categories departments spevents-box">
                        <i class="fa fa-calendar-alt"></i>
                        <span class="count"><?php echo $this->events; ?></span>
                        <span class="title"><?php echo JText::_('COM_SPEVENTS_DASHBOARD_EVENTS'); ?></span>
                    </div>
                </div>
                <div class="spevents-col-lg-3">
                    <div class="total-categories departments spevents-box">
                        <i class="fa fa-clock"></i>
                        <span class="count"><?php echo $this->upcomingEventsCount; ?></span>
                        <span class="title"><?php echo JText::_('COM_SPEVENTS_DASHBOARD_UPCOMING_COUNT'); ?></span>
                    </div>
                </div>
                <div class="spevents-col-lg-3">
                    <div class="total-categories departments spevents-box">
                        <i class="fa fa-microphone"></i>
                        <span class="count"><?php echo $this->speakers; ?></span>
                        <span class="title"><?php echo JText::_('COM_SPEVENTS_DASHBOARD_SPEAKERS'); ?></span>
                    </div>
                </div>
            </div><!-- end of counting row-->

            <div class="spevents-row">
                <div class="spevents-col-lg-12">
                    <div class="spevents-box">
                        <canvas id="myChart" height="100"></canvas>
                    </div>
                </div>
            </div>

            <div class="spevents-row">
                <div class="spevents-col-lg-4">
                    <div class="infobox spevents-box">
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
                                    <td><a class="spevents-link" href="<?php echo JRoute::_('index.php?option=com_spevents&task=event.edit&id=' . $item->id); ?>"><?php echo $item->title; ?></a></td>
                                    <td><?php echo !empty($item->venue) ? $item->venue : '----'; ?></td>
                                    <td><?php echo date('d F, Y h:i A', strtotime($item->start_time)); ?></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="spevents-col-lg-4">
                    <div class="infobox spevents-box">
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
                                    <td><a class="spevents-link" href="<?php echo JRoute::_('index.php?option=com_spevents&task=event.edit&id=' . $item->id); ?>"><?php echo $item->title; ?></a></td>
                                    <td><?php echo !empty($item->venue) ? $item->venue : '----'; ?></td>
                                    <td><?php echo date('d F, Y h:i A', strtotime($item->start_time)); ?></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="spevents-col-lg-4">
                    <div class="infobox spevents-box">
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
                                    <td><a class="spevents-link" href="<?php echo JRoute::_('index.php?option=com_spevents&task=speaker.edit&id=' . $item->id); ?>"><?php echo $item->title; ?></a></td>
                                    <td><?php echo $item->designation; ?></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div> <!-- end of info row-->

            <div class="spevents-row">
                <div class="spevents-col-lg-12">
                    <div class="infobox spevents-box">
                        <div id="map">
                            <div class="text-center" style="margin-top: 200px;">
                                <code>Map Error! Check your google map api key or contact with us.</code>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- end of map row-->

            <div class="spevents-row">
                <div class="spevents-col-lg-12">
                    <div class="spevents-box">
                        <div class="spevents-row">
                            <div class="spevents-col-sm-6">
                                <p>&copy; 2010 - <?php echo date('Y'); ?> JoomShaper. All Rights Reserved | License: <a href="http://www.gnu.org/copyleft/gpl.html">GNU General Public License</a></p>
                            </div>
                            <div class="spevents-col-sm-6 text-right">
                                <p>Version: <?php echo SpeventsHelper::getVersion(); ?></p>
                            </div>
                        </div> 
                    </div>
                </div>
            </div><!-- end of footer row-->


            
            <input type="hidden" name="task" value="" />

            <input type="hidden" name="boxchecked" value="0" />
            <input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
            <input type="hidden" name="filter_order_Dir" value="<?php echo $lilstDirn; ?>" />

            <?php echo JHtml::_('form.token'); ?>
            

            <?php
                $params = JComponentHelper::getParams('com_spevents');
                $gmap_api = $params->get('cmap_api');
                $src = "";
                $doc = JFactory::getDocument();
                if (!empty($gmap_api))
                {
                     $doc->addScriptDeclaration($this->google_map);
                     $doc->addScript("https://maps.googleapis.com/maps/api/js?key=". $gmap_api ."&callback=initMap",'text/javascript',true, false);
                }
                
                $doc->addStyleDeclaration('
                    #map{
                        min-height: 400px;
                    }
                ');

            ?>
        </div>
    </div>
                    