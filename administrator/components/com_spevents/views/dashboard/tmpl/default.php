<?php
use SpeventsHelper as H;
defined('_JEXEC') or die;

$user = JFactory::getUser();

$listOrder = $this->escape($this->state->get('list.ordering'));

$listDirn = $this->escape($this->state->get('list.direction'));

$params = JComponentHelper::getParams('com_spevents');
$currency = explode(':',$params->get('currency'));

$currency = $currency[1];

$canOrder = $user->authorise('core.edit.state','com_spevents.category');
$saveOrder = $listOrder == 'a.ordering';

$doc = JFactory::getDocument();
$doc->addStyleSheet( JURI::base(true) . '/components/com_spevents/assets/css/spevents-structure.css');
$doc->addStyleSheet( JURI::base(true) . '/components/com_spevents/assets/css/fontawesome.css');
$doc->addStyleSheet( JURI::base(true) . '/components/com_spevents/assets/css/spevents.css');
$doc->addScript( JURI::base(true) . '/components/com_spevents/assets/js/Chart.min.js');

$doc->addStyleSheet( JURI::base(true) . '/components/com_spevents/assets/fullcalendar/fullcalendar.min.css');

$doc->addScript(JURI::base(ture) . '/components/com_spevents/assets/fullcalendar/lib/moment.min.js');
$doc->addScript(JURI::base(true) . '/components/com_spevents/assets/fullcalendar/fullcalendar.min.js');

$doc->addScriptDeclaration('var events = ' . $this->calendar);


if($saveOrder) {
	$saveOrderingUrl = 'index.php?option=com_spevents&task=dashboard.saveOrderAjax&tmpl=component';
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

<script type="text/javascript">
    jQuery(function($){
        $('#calendar').fullCalendar({
            header: {left: 'month,agendaWeek', center : 'title', right: 'today prev,next'}, 
            weekends: true,
            events: events,
            aspectRatio: 2,
            nowIndicator: true,
            themeSystem: 'bootstrap4',
            navLinks: true,
            eventLimit: true,
            views: {
                agenda: {
                    eventLimit: 4
                },
                month: {
                    eventLimit: 4
                }
            },
            eventClick: function(event, jEvent, view){
                alert('Title: ' + event.title + '\nStart: ' + new Date(event.start) + (event.end ? '\nEnd: ' + new Date(event.end) : '') );
                console.log(event);
            }
        });
    });
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
                    <div class="infobox spevents-box">
                        <div id="calendar"></div>
                    </div>
                </div>
            </div>    

            <div class="spevents-row">
                <div class="spevents-col-lg-8">
                    <div class="infobox spevents-box">
                        <?php if (empty($this->upcomingSessions)){ ?>
                        <p class="text-center spevents-v-center"><code>No Upcoming Session</code></p>
                        <?php } else { ?>
                        <h6><?php echo JText::_('COM_SPEVENTS_DASHBOARD_UPCOMING_SESSIONS_TITLE'); ?> <a href="<?php echo JRoute::_('index.php?option=com_spevents&view=sessions'); ?>" class="pull-right btn btn-link" style="color: #000;">(see all)</a></h6>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th><?php echo JText::_('JGLOBAL_TITLE'); ?></th>
                                    <th><?php echo JText::_('COM_SPEVENTS_DASHBOARD_EVENTS_TITLE'); ?></th>
                                    <th><?php echo JText::_('COM_SPEVENTS_DASHBOARD_SESSION_START_TITLE'); ?></th>
                                    <th><?php echo JText::_('COM_SPEVENTS_DASHBOARD_SESSION_END_TITLE'); ?></th>
                                    <th><?php echo JText::_('COM_SPEVENTS_DASHBOARD_HALL_TITLE'); ?></th>
                                    <th><?php echo JText::_('COM_SPEVENTS_DASHBOARD_SPEAKERS_TITLE'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($this->upcomingSessions as $key => $item){ ?>
                                <tr>
                                    <td><?php echo ($key+1); ?></td>
                                    <td><a class="spevents-link" href="<?php echo JRoute::_('index.php?option=com_spevents&task=session.edit&id=' . $item->id); ?>"><?php echo $item->title; ?></a></td>
                                    <td><?php echo SpeventsHelper::belongsTo('#__spevents_sessions', '#__spevents_events', 'id', 'event_id', $item->event_id)->title; ?></td>
                                    <td><?php echo date('d F, Y', strtotime($item->date)) . date(' h:i A', strtotime($item->time_from)); ?></td>
                                    <td><?php echo date('d F, Y', strtotime($item->date)) . date(' h:i A', strtotime($item->time_to)); ?></td>
                                    <td><?php echo $item->hall; ?></td>
                                    <td>
                                        <?php foreach($speakers = $this->sessionsSpeakers(SpeventsHelper::stringToArray($item->speakers)) as $spk){ ?>
                                            <a class="spevents-speakers-link" href="<?php echo JRoute::_('index.php?option=com_spevents&task=speaker.edit&id=' . $spk->id); ?>"><?php echo $spk->title; ?></a>
                                        <?php } ?>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        <?php } ?>
                    </div>
                </div>

                <div class="spevents-col-lg-4">
                    <div class="infobox spevents-box">
                        <?php if (empty($this->ordersList)){ ?>
                        <p class="text-center spevents-v-center"><code>No Order</code></p>
                        <?php } else { ?>
                        <h6><?php echo JText::_('COM_SPEVENTS_DASHBOARD_LATEST_ORDER'); ?> <a href="<?php echo JRoute::_('index.php?option=com_spevents&view=orders'); ?>" class="pull-right btn btn-link" style="color: #000;">(see all)</a></h6>
                        <table class="spevents-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th><?php echo JText::_('COM_SPEVENTS_DASHBOARD_ORDER'); ?></th>
                                    <th><?php echo JText::_('COM_SPEVENTS_DASHBOARD_CUSTOMER'); ?></th>
                                    <th><?php echo JText::_('COM_SPEVENTS_DASHBOARD_PRICE'); ?></th>
                                    <th><?php echo JText::_('COM_SPEVENTS_DASHBOARD_QUANTITY'); ?></th>
                                    <th><?php echo JText::_('COM_SPEVENTS_DASHBOARD_TOTAL'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($this->ordersList as $key => $item){ ?>
                                <tr>
                                    <td><?php echo ($key+1); ?></td>
                                    <td><?php echo $item->order_id; ?></td>
                                    <td><?php echo SpeventsHelper::belongsTo('#__spevents_orders', '#__users', 'id', 'customer_id', $item->customer_id)->name; ?></td>
                                    <td><?php echo $currency . '' . $item->price; ?></td>
                                    <td><?php echo $item->quantity; ?></td>
                                    <td><?php echo $currency . '' . $item->price * $item->quantity; ?></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        <?php } ?>
                    </div>
                </div>
            </div>

            <div class="spevents-row">
                <div class="spevents-col-lg-4">
                    <div class="infobox spevents-box">
                        <?php if (empty($this->eventList)){ ?>
                        <p class="text-center spevents-v-center"><code>No Event</code></p>
                        <?php } else { ?>
                        <h6><?php echo JText::_('COM_SPEVENTS_DASHBOARD_LATEST_EVENTS_TITLE'); ?> <a href="<?php echo JRoute::_('index.php?option=com_spevents&view=events'); ?>" class="pull-right btn btn-link" style="color: #000;">(see all)</a></h6>
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
                        <?php } ?>
                    </div>
                </div>

                <div class="spevents-col-lg-4">
                    <div class="infobox spevents-box">
                        <?php if (empty($this->upcomingEvents)){ ?>
                        <p class="text-center spevents-v-center"><code>No Upcoming Event</code></p>
                        <?php } else { ?>
                        <h6><?php echo JText::_('COM_SPEVENTS_DASHBOARD_UPCOMING_EVENTS_TITLE'); ?> <a href="<?php echo JRoute::_('index.php?option=com_spevents&view=events'); ?>" class="pull-right btn btn-link" style="color: #000;">(see all)</a></h6>
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
                        <?php } ?>
                    </div>
                </div>

                <div class="spevents-col-lg-4">
                    <div class="infobox spevents-box">
                        <?php if (empty($this->speakerList)){ ?>
                        <p class="text-center spevents-v-center"><code>No Speaker</code></p>
                        <?php } else { ?>
                        <h6><?php echo JText::_('COM_SPEVENTS_DASHBOARD_LATEST_SPEAKERS_TITLE'); ?> <a href="<?php echo JRoute::_('index.php?option=com_spevents&view=speakers'); ?>" class="pull-right btn btn-link" style="color: #000;">(see all)</a></h6>
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
                        <?php } ?>
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
        