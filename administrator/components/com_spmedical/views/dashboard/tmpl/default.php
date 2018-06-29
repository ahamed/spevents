<?php
/**
* @package com_spmedical
* @author JoomShaper http://www.joomshaper.com
* @copyright Copyright (c) 2010 - 2018 JoomShaper
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/

// No Direct Access
defined ('_JEXEC') or die('Restricted Access');

jimport('joomla.application.component.helper');
$params = JComponentHelper::getParams('com_spmedical');
$currency = explode(':', $params->get('currency', 'USD:$'));

$doc = JFactory::getDocument();
JHtml::_('jquery.framework');
$doc->addStylesheet( JURI::root(true) . '/components/com_spmedical/assets/css/medico-fonts.css' );
$doc->addStylesheet( JURI::base(true) . '/components/com_spmedical/assets/css/font-awesome.min.css' );
$doc->addScript( JURI::base(true) . '/components/com_spmedical/assets/js/Chart.min.js' );

?>
<div class="spmedical spmedical-view-dashboard">
<?php if (!empty( $this->sidebar)) { ?>
    <div id="j-sidebar-container" class="span2">
      <?php echo $this->sidebar; ?>
    </div>
    <div id="j-main-container" class="span10">
    <!-- <div class="spmedical-dashboard-content"> -->
  <?php } else { ?>
    <div id="j-main-container">
  <?php } ?>

  <div id="spmedical">

    <div class="spmedical-row">
      <div class="spmedical-col-sm-12">
        <div class="spmedical-row">

           <div class="spmedical-col-lg-4">
            <div class="total-earnings departments spmedical-box">
              <i class="specialists-icon medico-hospital"></i>
              <span class="title"><?php echo JText::_('COM_SPMEDICAL_TOTAL_DEPARTMENTS'); ?></span>
              <span class="count"><?php echo $this->departments; ?></span>
            </div>
          </div>

          <div class="spmedical-col-lg-4">
            <div class="total-earnings spmedical-box">
              <i class="specialists-icon medico-teacher"></i>
              <span class="title"><?php echo JText::_('COM_SPMEDICAL_TOTAL_SPECIALISTS'); ?></span>
              <span class="count"><?php echo $this->specialists; ?></span>
            </div>
          </div>

          <div class="spmedical-col-lg-4">
            <div class="total-earnings appointments spmedical-box">
              <i class="specialists-icon medico-appoinment"></i>
              <span class="title"><?php echo JText::_('COM_SPMEDICAL_TOTAL_APPOINTMENTS'); ?></span>
              <span class="count"><?php echo $this->appointments; ?></span>
            </div>
          </div>
          
        </div>
      </div> <!-- /.spmedical-col-sm -->
    </div> <!-- /.spmedical-row -->

    <div class="spmedical-row">
      <div class="spmedical-col-sm-12">
        <div class="spmedical-dashboard-canvas spmedical-box">
          <div>
            <canvas id="spmedical-appointment-chart" height="50px"></canvas>
          </div>
        </div>

        <?php
        $currentTime = new JDate('now');
        $jnow = JFactory::getDate();
        $month = $jnow->format('m');
        $year = $jnow->format('Y');
        $days = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        $data = '';

        for ($i=1; $i<=$days; $i++) {
          $data .= '"' . SpmedicalHelper::getAppointments($i, $month, $year) . '",';
        }

        $data = rtrim($data, ',');
        $labels = '';
        $month = $jnow->format('M');
        for ($i=1; $i<=$days; $i++) {
          $labels .= '"' . $month .' - ' . $i . '",';
        }
        $labels = rtrim($labels, ',');
      
        ?>

        <script>
        (function($) {
          'use strict';
           $(function() {
            if ($('#spmedical-appointment-chart').length) {
              var lineChartCanvas = $("#spmedical-appointment-chart").get(0).getContext("2d");
              var data = {
                labels : [<?php echo $labels; ?>],
                datasets: [{
                    label: 'Appointment(s)',
                    data : [<?php echo $data; ?>],
                    backgroundColor: 'rgba(25, 145 ,235, 0.7)',
                    borderColor: [
                      'rgba(25, 145 ,235, 1)'
                    ],
                    borderWidth: 3,
                    fill: true
                  }
                ]
              };
              var options = {
                scales: {
                  yAxes: [{
                    ticks: {
                      beginAtZero: true
                    },
                    gridLines: {
                      display: true
                    }
                  }],
                  xAxes: [{
                    ticks: {
                      beginAtZero: true
                    },
                    gridLines: {
                      display: false
                    }
                  }]
                },
                legend: {
                  display: false
                },
                elements: {
                  point: {
                    radius: 3
                  }
                }
              };
              var lineChart = new Chart(lineChartCanvas, {
                type: 'line',
                data: data,
                options: options
              });
            }
          });
          })(jQuery);
        </script>
      </div> <!-- /.spmedical-col-sm -->
    </div> <!-- /.spmedical-row -->
 
    <div class="spmedical-row latest-specialists-wrapper">
      <div class="spmedical-col-sm-6">
        <div class="latest-specialists spmedical-box">
          <h3><?php echo JText::_('COM_SPMEDICAL_LATEST_SPECIALISTS'); ?></h3>
          <?php if(isset($this->specialistsList) && count((array)$this->specialistsList)) { ?>
            <ul>
              <li class="title-wrap">
                <div><?php echo JText::_('COM_SPMEDICAL_LATEST_SPECIALISTS_NAME'); ?></div>
                <div><?php echo JText::_('COM_SPMEDICAL_LATEST_SPECIALISTS_DESIGNATION'); ?></div>
                <div><?php echo JText::_('COM_SPMEDICAL_LATEST_SPECIALISTS_DEPARTMENT'); ?></div>
              </li>
              <?php foreach ($this->specialistsList as $specialist) { ?>
                <li>
                  <div class="designation-wrap">
                    <a href="<?php echo JRoute::_('index.php?option=com_spmedical&view=specialist&layout=edit&id=' . $specialist->id); ?>">
                      <?php echo $specialist->title; ?>
                    </a>
                  </div>
                  <div>
                    <small class="designation gray-color"><?php echo $specialist->designation; ?></small>
                  </div>
                  <div class="department-name gray-color">
                    <?php echo $specialist->department_name; ?>
                  </div>
                </li>
              <?php } ?>
            </ul>
            <?php } else { ?>
              <p class="alert alert-info"><?php echo JText::_('COM_SPMEDICAL_COMMON_NORECORDS'); ?></p>
            <?php } ?>
        </div>
      </div>

      <div class="spmedical-col-sm-6">
        <div class="recent-orders spmedical-box">
          <h3><?php echo JText::_('COM_SPMEDICAL_RECENT_APPOINTMENTS'); ?></h3>
          <?php if(isset($this->appointmentsList) && count((array)$this->appointmentsList)) { ?>
            <ul>
              <li class="title-wrap">
                <div><?php echo JText::_('COM_SPMEDICAL_LATEST_APPOINTMENTS_PATIENT_NAME'); ?></div>
                <div><?php echo JText::_('COM_SPMEDICAL_LATEST_APPOINTMENTS_DATE'); ?></div>
                <div><?php echo JText::_('COM_SPMEDICAL_LATEST_SPECIALISTS_NAME'); ?></div>
              </li>
              <?php foreach ($this->appointmentsList as $appointment) { ?>
                <li>
                  <div>
                    <a href="<?php echo JRoute::_('index.php?option=com_spmedical&view=appointment&layout=edit&id=' . $appointment->id); ?>">
                      <?php echo $appointment->patient_name ?>
                    </a>
                  </div>
                  <div class="gray-color">
                    <?php echo JHtml::_('date', $appointment->appintment_date, JText::_('DATE_FORMAT_LC3')); ?>
                  </div>
                  <div class="gray-color">
                    <?php echo $appointment->specialist_name; ?>
                  </div>
                </li>
              <?php } ?>
            </ul>
            <?php } else { ?>
              <p class="alert alert-info"><?php echo JText::_('COM_SPMEDICAL_COMMON_NORECORDS'); ?></p>
            <?php } ?>
        </div>
      </div>
    </div>

    <div class="spmedical-box spmedical-dashboard-footer">
      <div class="spmedical-row">
        <div class="spmedical-col-sm-6">
          <p>&copy; 2010 - <?php echo date('Y'); ?> JoomShaper. All Rights Reserved | License: <a href="http://www.gnu.org/copyleft/gpl.html">GNU General Public License</a></p>
        </div>
        <div class="spmedical-col-sm-6 text-right">
          <p>Version: <?php echo SpmedicalHelper::getVersion(); ?></p>
        </div>
      </div>
    </div>
  </div>
</div> <!-- /.spmedical-dashboard -->