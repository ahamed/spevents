<?php
/**
* @package com_spmedical
* @author JoomShaper http://www.joomshaper.com
* @copyright Copyright (c) 2010 - 2018 JoomShaper
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/

// No Direct Access
defined ('_JEXEC') or die('Restricted Access');

$infos = $displayData['informations'];
$infos_title = $displayData['informations_title'];
$infos_type = $displayData['informations_type'];

if (count((array)$infos)) { ?>
    <div class="<?php echo $infos_type; ?>">
        <h2><?php echo $infos_title; ?></h2>	
        <?php foreach ($infos as $info) { ?>
            <div class="spmedical-timeline-wrap">
                <div class="spmedical-row">
                    <div class="spmedical-col-sm-3">
                        <div class="date">
                            <?php echo $info->time; ?>
                        </div>
                    </div>
                    <div class="spmedical-col-sm-9">
                        <div class="info">
                            <span><?php echo $info->title; ?></span>
                            <?php echo $info->text; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div> <!-- /.specialist-{type} -->
<?php } ?>