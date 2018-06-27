<?php
/**
 * @package SP Page Builder
 * @author JoomShaper http://www.joomshaper.com
 * @copyright Copyright (c) 2010 - 2016 JoomShaper
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
 */
//no direct accees
defined('_JEXEC') or die('resticted aceess');

class SppagebuilderAddonEventum_schedules extends SppagebuilderAddons {

    public function render() {
        $schedule_count = (isset($this->addon->settings->schedule_count) && $this->addon->settings->schedule_count) ? $this->addon->settings->schedule_count : '';
        $session_count = (isset($this->addon->settings->session_count) && $this->addon->settings->session_count) ? $this->addon->settings->session_count : '';
        $schedule_layout = (isset($this->addon->settings->schedule_layout) && $this->addon->settings->schedule_layout) ? $this->addon->settings->schedule_layout : '';
        $column = (isset($this->addon->settings->column) && $this->addon->settings->column) ? $this->addon->settings->column : '';
        $class = (isset($this->addon->settings->class) && $this->addon->settings->class) ? $this->addon->settings->class : '';

        $schedules = $this->getSchedules($schedule_count);

        // Prepare Schedules
        foreach ($schedules as $schedule) {
            $sessions = $this->getEventumSessions($schedule->speventum_schedule_id, $session_count);
            $schedule->sessions = $sessions;

            if (count($schedule->sessions)) {
                foreach ($schedule->sessions as $session) {
                    $session->speakers = $this->getEventumSpeakers($session->speakers);
                }
            }
        }


        if ($column > count($schedules))
            $column = count($schedules);

        if (count($schedules)) {
            $output = ob_start();

            if ($schedule_layout == 'grid') {
                ?>
                <div class="eventum-schedules layout-addon">
                    <div class="row">
                        <?php foreach ($schedules as $key => $schedule) { ?>
                            <div class="eventum-schedule col-sm-<?php echo round(12 / $column); ?>">

                                <div class="scedule-date">
                                    <span class="scedule-date-day">
                                        <?php echo Jhtml::_('date', $schedule->date, 'd'); ?>
                                    </span>
                                    <?php echo Jhtml::_('date', $schedule->date, 'M, Y'); ?>
                                </div>

                                <div class="event-sessions">
                                    <?php foreach ($schedule->sessions as $key => $schedule->session) { ?>
                                        <div class="event-session">
                                            <h4 class="session-title"><?php echo $schedule->session->title; ?></h4>
                                            <div class="session-speakers">
                                                <?php if (count($schedule->session->speakers) == 1) { ?>
                                                    <?php echo JText::_('EVENTUM_SPEAKER'); ?>:
                                                <?php } elseif (count($schedule->session->speakers) > 1) { ?>
                                                    <?php echo JText::_('EVENTUM_SPEAKERS'); ?>:
                                                <?php } ?>
                                                <?php foreach ($schedule->session->speakers as $key => $speaker) { ?>
                                                    <a class="event-speaker" href="<?php echo JRoute::_('index.php?option=com_speventum&view=speaker&id=' . $speaker->speventum_speaker_id . ':' . $speaker->slug); ?>"><?php echo $speaker->title; ?></a><?php if ($key != count($schedule->session->speakers) - 1) echo ", "; ?>
                                                <?php } ?> 
                                            </div>

                                            <div class="session-meta">
                                                <?php echo $schedule->session->opening; ?> - <?php echo $schedule->session->closing; ?>, <?php echo $schedule->session->venue; ?>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>

            <?php } else { ?>

                <div class="eventum-schedules layout-addon schedules-list">

                    <?php foreach ($schedules as $key => $schedule) { ?>
                        <div class="eventum-schedule">
                            <div class="scedule-date text-center">
                                <h3><?php echo Jhtml::_('date', $schedule->date, 'DATE_FORMAT_LC'); ?></h3>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Session</th>
                                            <th>Speaker(s)</th>
                                            <th>Time</th>
                                            <th>Venue</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($schedule->sessions as $key => $schedule->session) { ?>
                                            <tr>
                                                <td scope="row"><?php echo $key + 1; ?></td>
                                                <td><?php echo $schedule->session->title; ?></td>
                                                <td>
                                                    <?php foreach ($schedule->session->speakers as $key => $speaker) { ?>
                                                        <a class="event-speaker" href="<?php echo JRoute::_('index.php?option=com_speventum&view=speaker&id=' . $speaker->speventum_speaker_id . ':' . $speaker->slug); ?>"><?php echo $speaker->title; ?></a><?php if ($key != count($schedule->session->speakers) - 1) echo ", "; ?>
                                                    <?php } ?>
                                                    <?php if (!count($schedule->session->speakers)) { ?>
                                                        .....
                                                    <?php } ?>
                                                </td>
                                                <td><?php echo $schedule->session->opening; ?> - <?php echo $schedule->session->closing; ?></td>
                                                <td><?php echo $schedule->session->venue; ?></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <?php
            }
        }
        return ob_get_clean();
    }

    private function getSchedules($schedule_count) {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select(array('a.*'));
        $query->from($db->quoteName('#__speventum_schedules', 'a'));
        $query->where($db->quoteName('a.enabled') . " = " . $db->quote('1'));
        $query->where('a.language in (' . $db->quote(JFactory::getLanguage()->getTag()) . ',' . $db->quote('*') . ')');
        $query->where($db->quoteName('a.access') . " IN (" . implode(',', JFactory::getUser()->getAuthorisedViewLevels()) . ")");
        $query->order($db->quoteName('a.date') . ' ASC');
        $query->setLimit($schedule_count);
        $db->setQuery($query);
        $schedules = $db->loadObjectList();
        return $schedules;
    }

    private function getEventumSessions($id = NULL, $count) {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select(array('a.*'));
        $query->from($db->quoteName('#__speventum_sessions', 'a'));
        $query->where($db->quoteName('a.schedule_id') . " = " . $db->quote($id));
        //$query->where($db->quoteName('a.speakers')." != ".$db->quote(''));
        $query->where($db->quoteName('a.enabled') . " = " . $db->quote('1'));
        $query->where('a.language in (' . $db->quote(JFactory::getLanguage()->getTag()) . ',' . $db->quote('*') . ')');
        $query->where($db->quoteName('a.access') . " IN (" . implode(',', JFactory::getUser()->getAuthorisedViewLevels()) . ")");
        $query->order($db->quoteName('a.ordering') . ' DESC');
        $query->setLimit($count);
        $db->setQuery($query);
        $sessions = $db->loadObjectList();

        return $sessions;
    }

    private function getEventumSpeakers($ids = NULL) {

        $ids = json_decode($ids);

        if ($ids) {
            $ids = implode(',', $ids);

            $db = JFactory::getDbo();
            $query = $db->getQuery(true);
            $query->select(array('a.*'));
            $query->from($db->quoteName('#__speventum_speakers', 'a'));
            $query->where($db->quoteName('a.speventum_speaker_id') . " IN (" . $ids . ")");
            $query->where($db->quoteName('a.enabled') . " = " . $db->quote('1'));
            $query->where('a.language in (' . $db->quote(JFactory::getLanguage()->getTag()) . ',' . $db->quote('*') . ')');
            $query->where($db->quoteName('a.access') . " IN (" . implode(',', JFactory::getUser()->getAuthorisedViewLevels()) . ")");
            $db->setQuery($query);
            $speaker = $db->loadObjectList();

            return $speaker;
        }

        return array();
    }

}
