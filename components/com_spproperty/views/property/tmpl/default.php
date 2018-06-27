<?php

/**
 * @package     SP Property
 *
 * @copyright   Copyright (C) 2010 - 2016 JoomShaper. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// No Direct Access
defined('_JEXEC') or die('Resticted Aceess');


$doc = JFactory::getDocument();
$doc->addScriptdeclaration('var spproperty_url="' . JURI::base() . 'index.php?option=com_spproperty";');

?>

<div id="spproperty" class="spproperty spproperty-view-property">
    <?php if ($this->item->galleries) { ?>
        <div class="owl-carousel owl-theme" id="spproperty-slider">
            <?php foreach ($this->item->galleries as $key => $image) { ?>
                <div class="spproperty-img">
                    <img alt="<?php echo $image['alt_text']; ?>" src="<?php echo JUri::root() . $image['photo']; ?>">
                </div>
            <?php } ?>
        </div><!-- /.spproperty-slider -->
    <?php } ?>

    <div class="spproperty-details-title text-center">
        <?php if ($this->item->cat_info->icon_image) { ?>
            <div class="spproperty-details-icon icon-image">
                <img src="<?php echo JUri::root() . $this->item->cat_info->image; ?>" alt="<?php echo $this->item->cat_info->title; ?>" />
            </div>
            <?php
        } else {
            $cicon = ($this->item->cat_info->icon_image) ? $this->item->cat_info->icon_image : 'fa-building';
            ?>
            <div class="spproperty-details-icon">
                <i class="fa <?php echo $cicon; ?>" aria-hidden="true"></i>
            </div>
        <?php } ?>

        <h2>
            <span><?php echo $this->item->cat_info->title; ?></span>
            <?php echo $this->item->title; ?>
        </h2>

        <?php echo JLayoutHelper::render('properties.social_share', array('url' => $this->item->url, 'title' => $this->item->title)); ?>

    </div><!-- /.spproperty-details-title -->

    <div class="container">
        <div class="row">
            <div class="col-sm-8 col-xs-12">
                <div class="spproperty-short-overview">
                    <h5><?php echo JText::_('COM_SPPROPERTY_SHORT_OVERVIEW'); ?></h5>

                    <?php if ($this->item->description) { ?>
                        <div class="spproperty-short-overview-text">
                            <?php echo $this->item->description; ?>
                        </div>
                    <?php } ?>

                    <div class="spproperty-overview-list">
                        <?php if ($this->item->lvl_fltno) { ?>
                            <div class="spproperty-single-list pull-left">
                                <span class="pull-left">
                                    <i class="fa fa-building" aria-hidden="true"></i>
                                </span>
                                <p class="pull-left"><?php echo $this->item->lvl_fltno; ?></p>
                            </div>
                        <?php } if ($this->item->psize) { ?>
                            <div class="spproperty-single-list pull-left">
                                <span class="pull-left">
                                    <i class="fa fa-object-group" aria-hidden="true"></i>
                                </span>
                                <p class="pull-left">
                                    <?php echo $this->item->psize . ' ' . JText::_('COM_SPPROPERTY_PROPERTIES_SQFT'); ?>
                                </p>
                            </div>
                        <?php } if ($this->item->beds) { ?>
                            <div class="spproperty-single-list pull-left">
                                <span class="pull-left">
                                    <i class="fa fa-bed" aria-hidden="true"></i>
                                </span>
                                <p class="pull-left">
                                    <?php echo $this->item->beds . ' ' . JText::_('COM_SPPROPERTY_PROPERTIES_BEDROOMS'); ?>
                                </p>
                            </div>
                        <?php } if ($this->item->baths) { ?>
                            <div class="spproperty-single-list pull-left">
                                <span class="pull-left">
                                    <i class="fa fa-sign-language" aria-hidden="true"></i>
                                </span>
                                <p class="pull-left">
                                    <?php echo $this->item->baths . ' ' . JText::_('COM_SPPROPERTY_PROPERTIES_BATHS'); ?>
                                </p>
                            </div>
                        <?php } if ($this->item->garages) { ?>
                            <div class="spproperty-single-list pull-left">
                                <span class="pull-left">
                                    <i class="fa fa-bus" aria-hidden="true"></i>
                                </span>
                                <p class="pull-left">
                                    <?php echo $this->item->garages . ' ' . JText::_('COM_SPPROPERTY_PROPERTIES_PARKING'); ?>
                                </p>
                            </div>
                        <?php } ?>
                        <div class="clearfix"></div>
                    </div>
                </div>

                <?php if (count($this->featureinfos) && $this->featureinfos) {
                    ?>
                    <div class="spproperty-feature-overview">
                        <h5><?php echo JText::_('COM_SPPROPERTY_FEATURES_OVERVIEW') ?></h5>
                        <p>
                            <?php echo $this->item->features_text; ?>
                        </p>
                        <ul class="spproperty-feature-overview-list">

                            <?php foreach ($this->featureinfos as $featureinfo) { ?>
                                <li>
                                    <div class="spproperty-feature-overview-signle-list">
                                        <i class="fa fa-check" aria-hidden="true"></i>
                                        <span><?php echo $featureinfo->title; ?></span>
                                        <div class="clearfix"></div>
                                    </div>
                                </li>
                            <?php } ?>
                        </ul>
                    </div> <!-- /.spproperty-feature-overview -->
                <?php } // has features  ?>

                <?php if (filter_var($this->item->video, FILTER_VALIDATE_URL)) { ?>
                    <!-- Featue Video Overview -->
                    <div class="spproperty-video-overview">
                        <h5><?php echo JText::_('COM_PROPERTY_PROPERTY_VIDEO_TITLE'); ?></h5>
                        <p>
                            <?php echo $this->item->video_text; ?>
                        </p>
                        <div class="spproperty-video">
                            <iframe class="spproperty-embed-responsive-item" src="<?php echo $this->videosrc; ?>" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
                            <div class="clearfix"></div>
                        </div><!-- /.spproperty-video -->
                    </div> <!-- /.spproperty-feature-overview -->
                <?php } ?>

                <?php if ($this->item->floor_plans && count($this->item->floor_plans)) { ?>
                    <div class="spproperty-floor-plan">
                        <h5><?php echo JText::_('COM_SPPROPERTY_EXPLORE_FLOOR_PLAN'); ?></h5>
                        <p><?php echo $this->item->fp_text; ?></p>
                        <div class="spproperty-floor-plan-tab">
                            <!-- Nav tabs -->
                            <ul class="spproperty-floor-tab-nav" role="tablist">
                                <?php
                                $i = 0;
                                foreach ($this->item->floor_plans as $key => $floor_plan) {
                                    $tav_active = ($i == 0) ? 'active' : '';
                                    ?>
                                    <li role="presentation" class="<?php echo $tav_active; ?>"><a href="#layout-<?php echo $key; ?>" aria-controls="layout-<?php echo $key; ?>" role="tab" data-toggle="tab">
                                            <?php echo $floor_plan['layout_name']; ?>
                                        </a></li>
                                <?php $i++; } ?>
                            </ul>
                            <div class="tab-content">

                                <?php
                                $i = 0;
                                foreach ($this->item->floor_plans as $key => $floor_plan) {
                                    $tav_active = ($i == 0) ? 'active' : '';
                                    ?>
                                    <div role="tabpanel" class="tab-pane fade in <?php echo $tav_active; ?> text-center" id="layout-<?php echo $key; ?>">
                                        <div class="spproperty-floor-img">
                                            <img alt="" src="<?php echo JUri::root() . $floor_plan['img']; ?>">
                                        </div>

                                        <div class="spproperty-floor-text">
                                            <?php echo $floor_plan['text']; ?>
                                        </div>
                                    </div> <!-- /.tab-pane -->
                                <?php $i++;} ?>
                            </div> <!-- /.tab-content -->
                        </div> <!-- /.spproperty-floor-plan-tab -->
                    </div> <!-- /.spproperty-floor-plan -->
                <?php } // has floor plans   ?>
            </div> <!-- /.col-sm-8 -->

            <div class="col-sm-4 col-xs-12">
                <aside class="spproperty-call-us-widget">

                    <?php if ($this->item->price) { ?>
                        <h3>
                            <span><?php echo JText::_('COM_SPPROPERTY_PROPERTY_PRICE'); ?></span>
                            <?php echo $this->item->price; ?>/<?php echo JText::_('COM_SPPROPERTY_PROPERTIES_SQFT'); ?>
                        </h3>
                    <?php } ?>

                    <?php if ((isset($this->item->agent->phone) && $this->item->agent->phone) || (isset($this->item->agent->mobile) && $this->item->agent->mobile)) { ?>
                        <p><?php echo JText::_('COM_SPPROPERTY_AGENT_CALL_FOR_BOOKING'); ?></p>
                        <a href="#" class="btn btn-primary btn-sm"><i class="fa fa-phone" aria-hidden="true"></i>
                            <?php if ($this->item->agent->phone) { ?>
                                <span><?php echo $this->item->agent->phone; ?></span>
                            <?php } else { ?>
                                <span><?php echo $this->item->agent->mobile; ?></span>
                            <?php } ?>
                        </a>
                    <?php } ?>

                </aside>

                <?php if ($this->item->address) { ?>
                    <aside class="spproperty-map-widget">
                        <div class="spproperty-map">
                            <div class="spproperty-property-map">
                                <div id="spproperty-property-map" class="spproperty-gmap-canvas" data-lat="<?php echo $this->map[0]; ?>" data-lng="<?php echo $this->map[1]; ?>" style="height:300px">

                                </div>
                            </div>
                            <p><i class="fa fa-map-marker" aria-hidden="true"></i></p>
                        </div>
                        <div class="spproperty-map-widget-content">
                            <span><?php echo JText::_('COM_SPPROPERTY_PROJECT_ADDRESS'); ?></span>
                            <p class="spproperty-project-address-text">
                                <?php echo $this->item->address; ?>
                            </p>
                        </div>
                    </aside>
                <?php } ?>

                <?php if (isset($this->item->agent) && $this->item->agent) { ?>
                    <aside class="spproperty-agent-widget-wrap">
                        <?php echo JLayoutHelper::render('agents.agent', array('agent' => $this->item->agent, 'desc_limit' => true)); ?>
                    </aside>
                <?php } ?>

                <?php if ($this->cParams->get('req_visit', 1)) { ?>
                    <aside class="spproperty-contact-us-widget">
                        <h3>
                            <span><?php echo JText::_('COM_SPPROPERTY_PROPERTY_ENQUIRY'); ?></span>
                            <?php echo JText::_('COM_SPPROPERTY_PROPERTY_REQUREST_FOR_VISIT'); ?>
                        </h3>
                        <p><?php echo JText::_('COM_SPPROPERTY_PROPERTY_REQUREST_FOR_VISIT_DESC'); ?></p>
                        <form class="spproperty-widget-form">
                            <input type="text" name="name" placeholder="<?php echo JText::_('COMPROPERTY_PLACEHOLDER_FULLNAME'); ?>" required="required">
                            <input type="email" name="email" placeholder="<?php echo JText::_('COMPROPERTY_PLACEHOLDER_EMAIL'); ?>" required="required">
                            <input type="tel" name="phone" placeholder="<?php echo JText::_('COMPROPERTY_PLACEHOLDER_PHONE'); ?>" required="required">
                            <textarea name="message" placeholder="<?php echo JText::_('COMPROPERTY_PLACEHOLDER_MESSAGE'); ?>" required="required"></textarea>
                            <input type="hidden" name="sender" value="<?php echo base64_encode($this->recipient); ?>">
                            <input type="hidden" name="pid" value="<?php echo $this->item->spproperty_property_id; ?>">
                            <input type="hidden" name="visitor_ip" value="<?php echo $this->visitorip; ?>">
                            <input type="hidden" name="pname" value="<?php echo $this->item->title; ?>">
                            <?php if($this->contact_tac && $this->contact_tac_text) { ?>
								<div class="input-field">
									<label class="form-checkbox">
										<input type="checkbox" id="tac" name="tac" value="tac" required="true" data-apptac="true">
										<?php echo $this->contact_tac_text; ?>
									</label>
								</div>
							<?php } ?>
                            <button type="submit" class="btn btn-primary btn-sm spproperty-req-submit"><?php echo JText::_('COM_PROPERTY_FORMBTN_SUBMIT'); ?></button>
                        </form>
                        <div style="display:none;margin-top:10px;" class="spproperty-req-status"></div>
                    </aside>
                <?php } ?>

            </div>
        </div>
    </div>
</div> <!-- /.spproperty -->