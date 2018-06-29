<?php
/**
* @package com_spmedical
* @author JoomShaper http://www.joomshaper.com
* @copyright Copyright (c) 2010 - 2018 JoomShaper
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/

// No Direct Access
defined ('_JEXEC') or die('Restricted Access');

// get component params
jimport('joomla.application.component.helper');
$this->cParams = JComponentHelper::getParams('com_spmedical');
$specialists = $displayData['specialists'];
$total_items = count($specialists);

if (count((array)$specialists)) { ?>
<div class="spmedical-col-md-8 spmedical-col-lg-9">
    <div class="spmedical-result-counter spmedical-justify-content-between spmedical-align-items-center spmedical-row">
        <h4 class="spmedical-col-auto"><?php echo $total_items; ?> <?php echo JText::_('COM_SPMEDICAL_TOTAL_ITEM_FOUND'); ?></h4>
    </div>
    <?php foreach ($specialists as $specialist) { ?>
        <div class="spmedical-specialists">
            <div class="specialist-wrapper spmedical-d-flex">
                <div class="specialists-img-wrapper">
                    <img src="<?php echo $specialist->thumb; ?>" class="spmedical-person-img spmedical-img-responsive" alt="<?php echo $specialist->title; ?>">
                    <a href="<?php echo $specialist->url; ?>" class="spmedical-btn spmedical-btn-primary"><?php echo JText::_('COM_SPMEDICAL_SPECIALIST_VIEW_PROFILE'); ?></a>
                </div> <!-- /.specialists-img-wrapper -->
                <div class="specialists-info-wrapper">
                    <div class="specialists-name">
                        <h3><a class="splms-person-title" href="<?php echo $specialist->url; ?>"><?php echo $specialist->title; ?></a></h3>
                        <?php if (!empty($specialist->designation)) { ?>
                            <span class="specialists-designation">
                                <?php echo $specialist->designation; ?>
                            </span>
                        <?php } ?>
                    </div>
                    
                    <div class="area-of-specialties">
                        <?php if($specialist->specialitist_on) { 
                            $specialitists = explode(', ', $specialist->specialitist_on);
                        ?>
                        <div class="specialists-category">
                            <h3><?php echo JText::_('COM_SPMEDICAL_SPECIALTY_TITLE') . ':'; ?></h3>
                            <ul>
                                <?php $total_specialitists = count((array)$specialitists);
                                foreach ($specialitists as $key => $specialitist) {
                                    $key ++;
                                ?>
                                    <li><?php echo $specialitist; ?> <?php echo ($total_specialitists != $key) ? ', ' : ''; ?> </li>
                                <?php } ?>
                            </ul>
                        </div>
                        <?php } ?>
                        <?php if(isset($specialist->visiting_times) && count((array)$specialist->visiting_times)) { ?>
                        <div class="specialists-available-hours">
                            <h3><?php echo JText::_('COM_SPMEDICAL_AVAILABLE_HOURS') . ':'; ?></h3>
                            <ul>
                                <?php foreach ($specialist->visiting_times as $visiting_time) { ?>
                                    <li>
                                        <span class="date"><?php echo $visiting_time->day; ?></span>
                                        <span class="time"><?php echo $visiting_time->visiting_time; ?></span>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                        <?php } ?>
                        <div class="specialists-social-profile">
                            <?php if(isset($specialist->socials) && count((array)$specialist->socials)) { ?>
                            <ul>
                                <?php foreach ($specialist->socials as $social) { ?>
                                <li>
                                    <a href="<?php echo $social->social_url; ?>"><i class="<?php echo $social->social_icon; ?>" aria-hidden="true"></i></a>
                                </li>
                                <?php } ?>
                                <?php if($specialist->website) { ?>
                                    <li>
                                        <a href="<?php echo $specialist->website; ?>" target="_blank"><i class="fa fa-globe" aria-hidden="true"></i></a>
                                    </li>
                                <?php } ?>
                            </ul>
                            <?php } ?>
                            <a href="<?php echo $specialist->appointment_url; ?>" class="btn btn-link"><?php echo JText::_('COM_SPMEDICAL_REQUEST_APPOINTMENT'); ?></a>
                        </div>
                    </div>
                </div> <!-- /.specialists-info-wrapper -->
            </div>
        </div> <!-- /.spmedical-specialists -->    
    <?php } ?>
</div><!-- //.spmedical-col-sm-9 -->  
<?php } else { ?>
    <div class="row">
        <div class="spmedical-col-sm-12 sp-no-item-found">
            <p><?php echo JText::_('COM_SPMEDICAL_NO_ITEMS_FOUND'); ?></p>
        </div>
    </div>
<?php } ?>