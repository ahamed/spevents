<?php
/**
* @package com_spmedical
* @author JoomShaper http://www.joomshaper.com
* @copyright Copyright (c) 2010 - 2018 JoomShaper
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/

// No Direct Access
defined ('_JEXEC') or die('Restricted Access');

$doc = JFactory::getDocument();
$input = JFactory::getApplication()->input;
$doc->addScript( JURI::root(true) . '/components/com_spmedical/assets/js/jquery-ui.js' );

//get specialists from main view
$specialist_lists   = $displayData['specialists'];
// get specialistid from post
$specialistid       = $input->get('specialistid', '', 'INT');

?>
    <div class="spmedical-specialists-search">
        <h3 class="spmedical-title"><?php echo JText::_('COM_SPMEDIAL_FIND_A_DOCTOR');?></h3>
        <p class="spmedical-subtitle"><?php echo JText::_('COM_SPMEDIAL_FIND_A_DOCTOR_SUB_TITLE');?></p>
        <div class="spmedical-specialists-search-wrapper">
            <form class="spmedical-specialist-search spmedial-suggest-fields">
                <div class="input-filters">
                    <div class="input-item specialist-wrapper">
                        <select id="spmedical-specialist" class="spmedical-combobox" data-placeholder="<?php echo JText::_('COM_SPMEDIAL_FIND_A_DOCTOR_SEARCH');?>">
                            <option <?php echo ($specialistid == '') ? 'selected' : '';?>></option>
                            <?php foreach ($specialist_lists as $specialist_list) { ?>
                                <option <?php echo ($specialistid == $specialist_list->id) ? 'selected' : '';?> value="<?php echo $specialist_list->id; ?>"><?php echo $specialist_list->title; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="input-item">
                        <button type="submit" class="spmedical-btn spmedical-btn-primary"><?php echo JText::_('COM_SPMEDIAL_FIND_A_DOCTOR_SUBMIT');?></button>
                    </div>
                </div>
                <input type="hidden" id="url" name="rooturl" value="<?php echo JUri::root(); ?>">
                <input type="hidden" id="menuid" name="menuid" value="<?php echo SpmedicalHelper::getItemid('specialists'); ?>">
            </form>
        </div>
    </div>
