<?php
/**
 * @package     SP Property
 *
 * @copyright   Copyright (C) 2010 - 2016 JoomShaper. All rights reserved.
 * @license     GNU General Public License version 2 or later.
 */
defined('_JEXEC') or die('Restricted Access');

$agent = $displayData['agent'];
$desc_limit = ($displayData['desc_limit']) ? $displayData['desc_limit'] : false;

if ($agent) {
    ?>
    <div class="spproperty-agent-widget">

        <?php if (isset($agent->image) && $agent->image) { ?>
            <div class="agent-img">
                <img alt="<?php echo $agent->title; ?>" src="<?php echo JUri::root() . $agent->image; ?>">
            </div>
        <?php } ?>

        <h3>
            <a href="<?php echo $agent->url; ?>">
                <?php if ($agent->designation) { ?>
                    <span><?php echo $agent->designation; ?></span>
                <?php } ?>
                <?php echo $agent->title; ?>
            </a>
        </h3>

        <?php if ($agent->description) { ?>
            <div class="spproperty-agent-desc">
                <?php if ($desc_limit == true) { ?>
                    <?php echo JHtml::_('string.truncate', strip_tags($agent->description), 80); ?>
                <?php } else { ?>
                    <?php echo $agent->description; ?>
                <?php } ?>
            </div>
        <?php } ?>

        <?php if ($agent->phone || $agent->mobile || $agent->email) { ?>
            <ul class="spproperty-agent-mailing">
                <?php if ($agent->mobile) { ?>
                    <li>
                        <i class="fa fa-phone-square" aria-hidden="true"></i>
                        <a href="tel://<?php echo $agent->mobile; ?>">
                          <span><?php echo $agent->mobile; ?></span>
                        </a>
                    </li>
                <?php } if ($agent->skype) { ?>
                    <li>
                        <i class="fa fa-skype" aria-hidden="true"></i>
                        <a href="skype:<?php echo $agent->skype; ?>?chat">
                          <span><?php echo $agent->skype; ?></span>
                        </a>
                    </li>
                <?php } if ($agent->email) { ?>
                    <li>
                        <i class="fa fa-envelope-square" aria-hidden="true"></i>
                        <a href="mailto:<?php echo $agent->email; ?>?subject=Request for visit">
                          <span><?php echo $agent->email; ?></span>
                        </a>
                    </li>
                <?php } ?>
            </ul>
        <?php } ?>

        <?php if ($agent->facebook || $agent->twitter || $agent->gplus || $agent->linkedin) { ?>
            <ul class="spproperty-agent-social">
                <?php if ($agent->facebook) { ?>
                    <li>
                        <a href="<?php echo $agent->facebook; ?>" target="_blank" class="facebook">
                            <i class="fa fa-facebook"></i>
                        </a>
                    </li>
                <?php } if ($agent->twitter) { ?>
                    <li>
                        <a href="<?php echo $agent->twitter; ?>" target="_blank" class="twitter">
                            <i class="fa fa-twitter"></i>
                        </a>
                    </li>
                <?php } if ($agent->gplus) { ?>
                    <li>
                        <a href="<?php echo $agent->gplus; ?>" target="_blank" class="gplus">
                            <i class="fa fa-google-plus"></i>
                        </a>
                    </li>
                <?php } if ($agent->linkedin) { ?>
                    <li>
                        <a href="<?php echo $agent->linkedin; ?>" target="_blank" class="linkedin">
                            <i class="fa fa-linkedin"></i>
                        </a>
                    </li>
                <?php } ?>
            </ul>
        <?php } ?>

    </div> <!-- /.spproperty-agent-widget -->
<?php } ?>
