<?php
/**
 * @package     SP Properties
 * @subpackage  mod_spproperty_search
 *
 * @copyright   Copyright (C) 2010 - 2016 JoomShaper. All rights reserved.
 * @license     GNU General Public License version 2 or later.
 */

// no direct access
defined('_JEXEC') or die;

$input      = JFactory::getApplication()->input;
$keyword    = $input->get('keyword', NULL, 'STRING');
$pstatus    = $input->get('pstatus', NULL, 'STRING');
$city_name  = $input->get('city', NULL, 'STRING');
$minsize    = $input->get('minsize', NULL, 'INT');
$maxsize    = $input->get('maxsize', NULL, 'INT');
$beds       = $input->get('beds', NULL, 'INT');
$baths      = $input->get('baths', NULL, 'INT');

$parking    = $input->get('parking', NULL, 'INT');
$zipcode    = $input->get('zipcode', NULL, 'INT');
$catid      = $input->get('catid', NULL, 'INT');
$min_price  = $input->get('min_price', NULL, 'INT');
$max_price  = $input->get('max_price', NULL, 'INT');

$numerics   = array(1, 2, 3, 4, 5);

$property_statuses = array(
  'rent'          => JText::_('MOD_SPPROPERTY_SEARCH_STATUS_RENT'),
  'sell'          => JText::_('MOD_SPPROPERTY_SEARCH_STATUS_SELL'),
  'in_hold'       => JText::_('MOD_SPPROPERTY_SEARCH_STATUS_IN_HOLD'),
  'pending'       => JText::_('MOD_SPPROPERTY_SEARCH_STATUS_IN_PENDING'),
  'sold'          => JText::_('MOD_SPPROPERTY_SEARCH_STATUS_IN_SOLD'),
  'under_offer'   => JText::_('MOD_SPPROPERTY_SEARCH_STATUS_IN_UNDER_OFFER')
);

$itemid = $input->get('Itemid',NULL, 'STRING');

$reset_uri = '';
if($itemid){
    $reset_uri = JRoute::_('index.php?option=com_spproperty&view=property' . SppropertyHelper::getItemid('properties'));
}

$isReset = false;
if (!empty($keyword) || !empty($pstatus) || !empty($city_name)
    || !empty($minsize) || !empty($maxsize) || !empty($beds)
    || !empty($baths) || !empty($parking) || !empty($zipcode)
    || !empty($catid) || !empty($max_price) || !empty($min_price))
{
    $isReset = true;
}


?>

<div id="mod-sp-property-search<?php echo $module->id; ?>" class="sp-property-search <?php echo $params->get('moduleclass_sfx') ?>">
    <div class="row">
        <form class="spproperty-search">
            <div class="col-sm-4 col-lg-2">
                <div class="keyword">
                    <input type="text" name="keyword" id="keyword" class="form-control" placeholder="<?php echo JText::_('MOD_SPPROPERTY_SEARCH_KEYWORD'); ?>" value="<?php echo $keyword; ?>">
                </div>
            </div>
            <div class="col-sm-4 col-lg-2">
                <div class="location">
                    <div class="form-group">
                        <select name="city" id="city" class="form-control">
                            <option value="" <?php echo ($city_name == '') ? 'selected="selected"' : ''; ?>>
                                <?php echo JText::_('MOD_SPPROPERTY_SEARCH_LOCATION'); ?>
                            </option>
                            <?php foreach ($items as $city) { ?>
                                <option value="<?php echo $city->city; ?>" <?php echo ($city_name == $city->city) ? 'selected="selected"' : ''; ?>> <?php echo $city->city; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-lg-2 col-sm-4">
                <div class="pstatus">
                    <select name="pstatus" id="pstatus" class="form-control">
                        <option value="" <?php echo ($pstatus == '') ? 'selected="selected"' : ''; ?>>
                            <?php echo JText::_('MOD_SPPROPERTY_SEARCH_STATUS'); ?>
                        </option>
                        <?php foreach ($property_statuses as $key => $status) { ?>
                          <option value="<?php echo $key; ?>" <?php echo ($pstatus == $key) ? 'selected="selected"' : ''; ?>>
                              <?php echo $status; ?>
                          </option>
                        <?php } ?>
                    </select>
                </div>
            </div>

            <div class="col-sm-4 col-lg-2">
                <div class="area">
                    <input type="number" name="min-size" id="min-size" class="form-control" placeholder="<?php echo JText::_('MOD_SPPROPERTY_SEARCH_MIN_SIZE_SQFT'); ?>" value="<?php echo $minsize; ?>">
                </div>
            </div>

            <div class="col-sm-4 col-lg-2">
                <div class="max-price">
                    <input type="number" name="max-price" id="max-price" class="form-control" placeholder="<?php echo JText::_('MOD_SPPROPERTY_SEARCH_MAX_PRICE'); ?>" value="<?php echo $max_price; ?>">
                </div>
            </div>

            <div class="input-box">
                <input type="hidden" name="rooturl" id="url" value="<?php echo JUri::root(); ?>">
                <input type="hidden" name="menuid" id="menuid" value="<?php echo SppropertyHelper::getItemid('properties'); ?>">
            </div>

            <div class="col-sm-4 col-lg-2">
                <div class="property-search-button">
                    <button type="submit" id="mod-spproperty-search-submit" class="sppb-btn sppb-btn-primary btn-sm">
                        <?php echo JText::_('MOD_SPPROPERTY_SEARCH_BTN_TEXT'); ?>
                    </button>
                </div>
            </div>
        </form>	<!-- #spproperty-search -->
    </div><!--/.row-->
    <div calss="row">
        <div class="property-advance-search">
            <a href="#" data-toggle="modal" data-target=".sp-modal-lg"><i class="fa fa-plus-square"></i><span class="btn-text"><?php echo JText::_('MOD_SPPROPERTY_SEARCH_ADVANCED_SEARCH'); ?></span></a>
        </div>
    </div>
</div>
<!-- Modal Content -->
<div class="modal fade sp-modal-lg sp-property-search" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="sp-advaced-search">
                <div class="container">
                    <div class="row">
                        <div class="sp-advance-search-wrap">
                            <div class="sp-advance-serach-title text-center">
                                <div class="sp-advance-icon">
                                    <i class="fa fa-search" aria-hidden="true"></i>
                                </div>
                                <h4><?php echo JText::_('MOD_SPPROPERTY_SEARCH_ADVANCED_SEARCH'); ?></h4>
                            </div>
                            <form class="spproperty-adv-search">
                                <div class="row">
                                    <div class="col-sm-4 col-lg-2">
                                        <div class="keyword">
                                            <input type="text" id="keyword" class="form-control" placeholder="<?php echo JText::_('MOD_SPPROPERTY_SEARCH_KEYWORD'); ?>" value="<?php echo $keyword; ?>">
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-sm-4">
                                        <div class="location">
                                            <div class="form-group">
                                                <select id="city" class="form-control">
                                                    <option value="" <?php echo ($city_name == '') ? 'selected="selected"' : ''; ?>>
                                                        <?php echo JText::_('MOD_SPPROPERTY_SEARCH_LOCATION'); ?>
                                                    </option>
                                                    <?php foreach ($items as $city) { ?>
                                                        <option value="<?php echo $city->city; ?>" <?php echo ($city_name == $city->city) ? 'selected="selected"' : ''; ?>> <?php echo $city->city; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-sm-4">
                                        <div class="zip-code">
                                            <input name="zip-code" id="zip-code" type="text" placeholder="<?php echo JText::_('MOD_SPPROPERTY_SEARCH_ZIP_CODE'); ?>" value="<?php echo $zipcode; ?>">
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-lg-2">
                                        <div class="category">
                                            <select id="category" class="form-control">
                                                <option value="" <?php echo ($catid == '') ? 'selected="selected"' : ''; ?>>
                                                    <?php echo JText::_('MOD_SPPROPERTY_SEARCH_CATEGORY'); ?>
                                                </option>
                                                <?php foreach ($cats as $cat) { ?>
                                                    <option value="<?php echo $cat->spproperty_category_id; ?>" <?php echo ($catid == $cat->spproperty_category_id) ? 'selected="selected"' : ''; ?>><?php echo $cat->title; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-sm-4">
                                        <div class="area">
                                            <input type="min-size" id="min-size" class="form-control" placeholder="<?php echo JText::_('MOD_SPPROPERTY_SEARCH_MIN_SIZE_SQFT'); ?>" value="<?php echo $minsize; ?>">
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-sm-4">
                                        <div class="area">
                                            <input type="max-size" id="max-size" class="form-control" placeholder="<?php echo JText::_('MOD_SPPROPERTY_SEARCH_MAX_SIZE_SQFT'); ?>" value="<?php echo $maxsize; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                  <div class="col-lg-2 col-sm-4">
                                      <div class="pstatus">
                                          <select name="pstatus" id="pstatus" class="form-control">
                                              <option value="" <?php echo ($pstatus == '') ? 'selected="selected"' : ''; ?>>
                                                  <?php echo JText::_('MOD_SPPROPERTY_SEARCH_STATUS'); ?>
                                              </option>
                                              <?php foreach ($property_statuses as $key => $status) { ?>
                                                <option value="<?php echo $key; ?>" <?php echo ($pstatus == $key) ? 'selected="selected"' : ''; ?>>
                                                    <?php echo $status; ?>
                                                </option>
                                              <?php } ?>
                                          </select>
                                      </div>
                                  </div>
                                    <div class="col-lg-2 col-sm-4">
                                        <div class="bed">
                                            <select name="beds" id="beds" class="form-control">
                                                <option value="" <?php echo ($beds == '') ? 'selected="selected"' : ''; ?>><?php echo JText::_('MOD_SPPROPERTY_SEARCH_BED'); ?></option>

                                                <?php
                                                foreach ($numerics as $key => $numeric) {
                                                    $bed_text = ($key == 0) ? JText::_('MOD_SPPROPERTY_SEARCH_BED') : JText::_('MOD_SPPROPERTY_SEARCH_BEDS');
                                                    ?>
                                                    <option value="<?php echo $numeric; ?>" <?php echo ($beds == $numeric) ? 'selected="selected"' : ''; ?>><?php echo $numeric . ' ' . $bed_text; ?></option>
                                                <?php } ?>

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-sm-4">
                                        <div class="bath">
                                            <select name="baths" id="baths" class="form-control">
                                                <option value="" <?php echo ($baths == '') ? 'selected="selected"' : ''; ?>>
                                                    <?php echo JText::_('MOD_SPPROPERTY_SEARCH_BATH'); ?>
                                                </option>

                                                <?php
                                                foreach ($numerics as $key => $numeric) {
                                                    $bath_text = ($key == 0) ? JText::_('MOD_SPPROPERTY_SEARCH_BATH') : JText::_('MOD_SPPROPERTY_SEARCH_BATHS');
                                                    ?>
                                                    <option value="<?php echo $numeric; ?>" <?php echo ($baths == $numeric) ? 'selected="selected"' : ''; ?>>
                                                        <?php echo $numeric . ' ' . $bath_text; ?>
                                                    </option>
                                                <?php } ?>

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-sm-4">
                                        <div class="parking">
                                            <select id="parking" class="form-control">
                                                <option value=""  <?php echo ($parking == '') ? 'selected="selected"' : ''; ?>>
                                                    <?php echo JText::_('MOD_SPPROPERTY_SEARCH_PARKING'); ?>
                                                </option>

                                                <?php
                                                foreach ($numerics as $key => $numeric) {
                                                    $park_text = ($key == 0) ? JText::_('MOD_SPPROPERTY_SEARCH_PARKING') : JText::_('MOD_SPPROPERTY_SEARCH_PARKINGS');
                                                    ?>

                                                    <option value="<?php echo $numeric; ?>" <?php echo ($parking == $numeric) ? 'selected="selected"' : ''; ?>>
                                                        <?php echo $numeric . ' ' . $park_text; ?>
                                                    </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-lg-2">
                                        <div class="min-price">
                                            <input name="min-price" id="min-price" type="number" placeholder="<?php echo JText::_('MOD_SPPROPERTY_SEARCH_MIN_PRICE'); ?>" value="<?php echo $min_price; ?>">
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-lg-2">
                                        <div class="max-price">
                                            <input name="max-price" id="max-price" type="number" placeholder="<?php echo JText::_('MOD_SPPROPERTY_SEARCH_MAX_PRICE'); ?>" value="<?php echo $max_price; ?>">
                                        </div>
                                    </div>

                                    <div class="input-box">
                                        <input type="hidden" id="url" name="rooturl" value="<?php echo JUri::root(); ?>">
                                        <input type="hidden" id="menuid" name="menuid" value="<?php echo SppropertyHelper::getItemid('properties'); ?>">
                                    </div>

                                </div>
                                <div class="row sp-property-search-button-wrap">
                                    <div class="col-sm-12">
                                        <div class="property-search-button">
                                            <button type="submit" id="mod-spproperty-advsearch-submit" class="sppb-btn sppb-btn-primary btn-sm">
                                                <?php echo JText::_('MOD_SPPROPERTY_SEARCH_BTN_TEXT'); ?>
                                            </button>
                                        </div>
                                        <?php if($isReset) { ?>
                                            <!--adding a reset button -->
                                            <div class="property-search-button">
                                                <a href="<?php echo JRoute::_($reset_uri);?>" id="mod-spproperty-advsearch-reset"
                                                class="sppb-btn sppb-btn-danger btn-sm text-center">
                                                    <?php echo JText::_('MOD_SPPROPERTY_RESET_BTN_TEXT') ;?>
                                                </a>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </form>	<!-- /.spproperty-search -->
                            <span class="close" data-dismiss="modal" aria-label="Close"><i class="fa fa-times" aria-hidden="true"></i></span>
                        </div>
                    </div><!--/.row-->
                </div>
            </div>
        </div>
    </div>
</div>