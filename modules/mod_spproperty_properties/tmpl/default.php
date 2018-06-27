<?php
/**
 * @package     SP Properties
 * @subpackage  mod_spproperty_properties
 *
 * @copyright   Copyright (C) 2010 - 2016 JoomShaper. All rights reserved.
 * @license     GNU General Public License version 2 or later.
 */

// no direct access
defined('_JEXEC') or die; ?>

<div id="sp-property-properties<?php echo $module->id; ?>" class="spproperty <?php echo $params->get('moduleclass_sfx') ?>">

    <?php foreach (array_chunk($properties, $columns) as $properties) { ?>
        <div class="row">
            <?php foreach ($properties as $property) { ?>
                <div class="spproperty-col-sm-<?php echo round(12 / $columns); ?>">
                    <div class="sp-properties-wrapper property-status-<?php echo $property->property_status; ?>">

                        <?php if($property->property_status == 'sold') { ?>
                          <span class="spproperty-badge-sold"><?php echo JText::_('MOD_SPPROPERTY_PROPERTIES_SOLD'); ?></span>
                        <?php } ?>

                        <?php if($property->image) { ?>
                          <div class="property-image">
                              <img src="<?php echo JUri::root() . $property->image; ?>" alt="<?php echo $property->title; ?>">
                          </div>
                        <?php } ?>

                        <div class="property-details">

                            <?php if($property->category_name) { ?>
                                <span class="property-category">
                                  <?php
                                    $category_name = ($property->property_status) ? $property->category_name . ', ' . $property->property_status : $property->category_name;
                                    echo $category_name;
                                  ?>
                                </span>
                            <?php } ?>

                            <h3 class="property-title">
                                <a href="<?php echo $property->url; ?>">
                                    <?php echo $property->title; ?>

                                </a>
                            </h3>

                            <?php if($property->price){ ?>
                                <span class="property-price"><?php echo $property->price; ?>/<?php echo JText::_('MOD_SPPROPERTY_PROPERTIES_SQFT'); ?></span>
                            <?php } ?>

                            <?php if( $property->psize || $property->beds || $property->baths || $property->garages ){ ?>
                                <span class="property-summery">
                                    <ul>
                                        <?php if($property->psize) { ?>
                                        <li class="area-size">
                                            <?php echo $property->psize; ?> <?php echo JText::_('MOD_SPPROPERTY_PROPERTIES_SQFT'); ?>
                                        </li>
                                        <?php } if($property->beds) { ?>
                                        <li class="bedroom">
                                            <?php echo $property->beds; ?> <?php echo JText::_('MOD_SPPROPERTY_PROPERTIES_BEDROOMS'); ?>
                                        </li>
                                        <?php } if($property->baths) { ?>
                                        <li class="bathroom">
                                            <?php echo $property->baths; ?> <?php echo JText::_('MOD_SPPROPERTY_PROPERTIES_BATHS'); ?>
                                        </li>
                                        <?php } if($property->garages) { ?>
                                        <li class="parking">
                                            <?php echo $property->garages; ?> <?php echo JText::_('MOD_SPPROPERTY_PROPERTIES_PARKING'); ?>
                                        </li>
                                        <?php } ?>
                                    </ul>
                                </span>
                            <?php } ?>

                            <span class="properties-search-button">
                                <a href="<?php echo $property->url; ?>" class="sppb-btn sppb-btn-primary sppb-btn-sm" role="button"><?php echo JText::_('MOD_SPPROPERTY_PROPERTIES_BTN_TEXT'); ?></a>
                            </span>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div><!--/.row-->
    <?php } ?>
</div>
