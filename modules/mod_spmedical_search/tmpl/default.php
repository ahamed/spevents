<?php
/**
 * @package     SP Medical
 * @subpackage  mod_spmedical_search
 *
 * @copyright   Copyright (C) 2010 - 2018 JoomShaper. All rights reserved.
 * @license     GNU General Public License version 2 or later.
 */

// no direct access
defined('_JEXEC') or die;

$input         = JFactory::getApplication()->input;
$departmentid    = $input->get('departmentid', '', 'INT');
$specialistid       = $input->get('specialistid', '', 'INT');
$specialityname  = $input->get('speciality', '', 'STRING');

?>

<div id="mod-spmedical-search<?php echo $module->id; ?>" class="mod-spmedical-search <?php echo $params->get('moduleclass_sfx') ?>">
    <div class="">
        <form class="spmedical-search">
            <div class="input-item input-services">
                <select id="spmedical-departments" class="spmedical-combobox"  data-placeholder="<?php echo JText::_('MOD_SPMEDICAL_SEARCH_DEPARTMENTS'); ?>">
                    <option <?php echo ($departmentid == '') ? 'selected' : '';?>></option>
                    <?php foreach ($departments as $key => $department) { ?>
                        <option <?php echo ($departmentid == $department->id) ? 'selected' : '';?> value="<?php echo $department->id; ?>"><?php echo $department->title; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="input-item">

                <select id="spmedical-specialities" class="spmedical-combobox" data-placeholder="<?php echo JText::_('MOD_SPMEDICAL_SEARCH_SPECIALITIES'); ?>">
                    <option <?php echo ($specialityname == '') ? 'selected' : '';?>></option>
                    <?php foreach ($specialities as $key => $speciality) { ?>
                        <option <?php echo ($specialityname == strtolower($speciality)) ? 'selected' : '';?> value="<?php echo strtolower($speciality); ?>"><?php echo $speciality; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="input-item">
                <select id="spmedical-specialists" class="spmedical-combobox" data-placeholder="<?php echo JText::_('MOD_SPMEDICAL_SEARCH_SPECIALISTS'); ?>">
                    <option <?php echo ($specialistid == '') ? 'selected' : '';?>></option>
                    <?php foreach ($specialists as $specialist) { ?>
                         <option <?php echo ($specialistid == $specialist->id) ? 'selected' : '';?> value="<?php echo $specialist->id; ?>"><?php echo $specialist->title; ?></option>
                    <?php } ?>
                </select>
            </div>
           
            <!-- <div class="input-item">
                <input type="text" name="date" placeholder="Date" required>
            </div> -->

            <input type="hidden" id="url" name="rooturl" value="<?php echo JUri::root(); ?>">
            <input type="hidden" id="menuid" name="menuid" value="<?php echo SpmedicalHelper::getItemid('specialists'); ?>">

            <div class="input-item">
                <button type="submit" class="btn btn-primary"><?php echo JText::_('MOD_SPMEDICAL_SEARCH_SEARCH_DOCTOR'); ?></button>
            </div>
        </form>	<!-- #spmedical-search -->
    </div><!--/.row-->
</div>
