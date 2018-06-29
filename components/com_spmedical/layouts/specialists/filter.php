<?php
/**
* @package com_spmedical
* @author JoomShaper http://www.joomshaper.com
* @copyright Copyright (c) 2010 - 2018 JoomShaper
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/

// No Direct Access
defined ('_JEXEC') or die('Restricted Access');

$specialities   = $displayData['specialities']; 
$departments    = $displayData['departments'];

$input = JFactory::getApplication()->input;
$departmentid    = $input->get('departmentid', '', 'INT');
$specialityname  = $input->get('speciality', '', 'STRING');
$gender          = $input->get('gender', '', 'STRING');

?>

<div class="spmedical-col-md-4 spmedical-col-lg-3">
    <aside class="spmedical-sidebar">
        <h3 class="sidebar-title">Narrow Your Search</h3>
        <form id="spmedical-specialists-filters-form" class="spmedical-specialists-filters">
            <?php if(count((array)$departments) ) { ?>
                <div class="spmedical-category-search">
                    <h3><?php echo JText::_('COM_SPMEDICAL_BY_DEPARTMENTS'); ?></h3>
                    <ul id="spmedical-filter-departments">
                        <?php foreach ($departments as $key => $department) { ?>
                            <li>
                                <label class="custom-checkbox" for="<?php echo $department->id; ?>">
                                    <input type="radio" id="<?php echo $department->id; ?>" value="<?php echo $department->id; ?>" name="department" <?php echo ( $departmentid == $department->id ) ? 'checked="checked"': ''; ?> >
                                    <span class="checkmark"><?php echo $department->title; ?></span>
                                </label>
                            </li>
                        <?php } ?>
                    </ul>
                </div> <!-- //.spmedical-category-search -->
            <?php } ?>
            <?php if(count((array)$specialities) ) { ?>
            <div class="spmedical-category-search">
                <h3><?php echo JText::_('COM_SPMEDICAL_BY_SPECIALITY'); ?></h3>
                <ul id="spmedical-filter-specialities">
                    <?php foreach ($specialities as $key => $speciality) { ?>
                        <li>
                            <label class="custom-checkbox" for="<?php echo $key; ?>">
                                <input type="radio" id="<?php echo $key; ?>" name="speciality" value="<?php echo strtolower($speciality); ?>" <?php echo ( $specialityname == strtolower($speciality) ) ? 'checked="checked"': ''; ?>  >
                                <span class="checkmark"><?php echo $speciality; ?></span>
                            </label>
                        </li>
                    <?php } ?>
                </ul>
            </div> <!-- //.spmedical-category-search -->
            <?php } ?>
            <div class="spmedical-category-search">
                <h3><?php echo JText::_('COM_SPMEDICAL_BY_GENDER'); ?></h3>
                <ul>
                    <li>
                        <input type="radio" name="gender" id="male" value="m" <?php echo ( $gender == 'm' ) ? 'checked="checked"': ''; ?> >
                        <label for="male"><?php echo JText::_('COM_SPMEDICAL_MALE'); ?></label>
                    </li>
                    <li>
                        <input type="radio" name="gender" id="female" value="f" <?php echo ( $gender == 'f' ) ? 'checked="checked"': ''; ?>>
                        <label for="female"><?php echo JText::_('COM_SPMEDICAL_FEMALE'); ?></label>
                    </li>
                </ul>
            </div> <!-- //.spmedical-category-search -->
            
            <input type="hidden" id="url" name="rooturl" value="<?php echo JUri::root(); ?>">
            <input type="hidden" id="menuid" name="menuid" value="<?php echo SpmedicalHelper::getItemid('specialists'); ?>">

            <div class="spmedical-buttons-group">
                <button type="submit" class="spmedical-btn spmedical-btn-primary spmedical-submit-button"><?php echo JText::_('COM_SPMEDICAL_SUBMIT'); ?></button>
                <button type="reset" class="spmedical-btn spmedical-btn-link reset-button"><?php echo JText::_('COM_SPMEDICAL_RESET'); ?></button>
            </div>
        </form>
    </aside>
</div><!-- //.spmedical-col-sm-3 -->
