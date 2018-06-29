<?php
/**
 * @package     SP Property
 *
 * @copyright   Copyright (C) 2010 - 2016 JoomShaper. All rights reserved.
 * @license     GNU General Public License version 2 or later.
 */

defined('_JEXEC') or die('Restricted Access');

// get component params
jimport('joomla.application.component.helper');
$this->cParams = JComponentHelper::getParams('com_spproperty');
$property_rm_btn = $this->cParams->get('prpry_rm_btn_text', JText::_('COM_SPPROPERTY_PROPERTIES_BTN_TEXT'));

$property     = $displayData['property'];

if ($property) { ?>
    <div class="sp-properties-wrapper property-status-<?php echo $property->property_status; ?>">
        <?php if($property->property_status == 'sold') { ?>
          <span class="spproperty-badge-sold"><?php echo JText::_('COM_SPPROPERTY_PROPERTIES_SOLD'); ?></span>
        <?php } ?>
        <div class="property-image">
            <img src="<?php echo JUri::root() . $property->image; ?>" alt="<?php echo $property->title; ?>">
        </div>
        <div class="property-details">
            <span class="property-category">
                <?php
                  $category_name = ($property->property_status) ? $property->category_name . ', ' . $property->property_status_txt : $property->category_name;
                  echo $category_name;
                ?>
            </span>
            <h3 class="property-title">
                <a href="<?php echo $property->url; ?>">
                    <?php echo $property->title; ?>
                </a>
            </h3>
            <span class="property-price">
                <?php echo $property->price; ?>/<?php echo empty(trim($this->cParams['measurement'])) ?  JText::_('COM_SPPROPERTY_PROPERTIES_SQFT') : $this->cParams['measurement']; ?>
            </span>
            <?php if($property->psize || $property->beds || $property->baths || $property->garages){ ?>
                <span class="property-summery">
                    <ul>
                        <?php if($property->psize){ ?>
                            <li class="area-size"><?php echo $property->psize; ?> <?php echo empty(trim($this->cParams['measurement'])) ?  JText::_('COM_SPPROPERTY_PROPERTIES_SQFT') : $this->cParams['measurement']; ?></li>
                        <?php } if($property->beds){ ?>
                            <li class="bedroom"><?php echo $property->beds; ?> <?php echo JText::_('COM_SPPROPERTY_PROPERTIES_BEDROOMS'); ?></li>
                        <?php } if($property->baths){ ?>
                            <li class="bathroom"><?php echo $property->baths; ?> <?php echo JText::_('COM_SPPROPERTY_PROPERTIES_BATHS'); ?></li>
                        <?php } if($property->garages){ ?>
                            <li class="parking"><?php echo $property->garages; ?> <?php echo JText::_('COM_SPPROPERTY_PROPERTIES_PARKING'); ?></li>
                        <?php } ?>
                    </ul>
                </span>
            <?php } ?>
            <span class="properties-search-button">
                <a href="<?php echo $property->url; ?>" class="sppb-btn sppb-btn-primary sppb-btn-sm" role="button"><?php echo $property_rm_btn; ?></a>
            </span>
        </div>
    </div> <!-- /.sp-properties-wrapper -->
<?php } ?>