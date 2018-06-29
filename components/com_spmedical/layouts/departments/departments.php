<?php
/**
* @package com_spmedical
* @author JoomShaper http://www.joomshaper.com
* @copyright Copyright (c) 2010 - 2018 JoomShaper
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/

// No Direct Access
defined ('_JEXEC') or die('Restricted Access');

$this->items = $displayData['departments'];
$this->logo_type = $displayData['logo_type'];
$columns = $displayData['columns'];

if (count((array)$this->items)) { ?>
    <div class="spmedical-row">
		<?php foreach ($this->items as $this->item) { ?>
		<div class="spmedical-departments spmedical-col-md-12 spmedical-col-lg-<?php echo round(12/$columns); ?>">
            <?php if( $this->logo_type == 'icon' ){ 
				$this->item->icon =  ($this->item->icon) ? $this->item->icon : 'medico-Service-7';
			?>
				<div class="spmedical-department-wrap has-icon">
					<!-- has service icon -->
					<div class="spmedical-department-icon-wrap">
						<a href="<?php echo $this->item->url; ?>">
							<i class="<?php echo $this->item->icon; ?>"></i>
						</a>
					</div>
					<div class="spmedical-department-content">
						<h3 class="spmedical-department-title"><a href="<?php echo $this->item->url; ?>"><?php echo $this->item->title; ?></a></h3>
						<div class="spmedical-department-details"><?php echo JHtmlString::truncate(strip_tags($this->item->description), 55); ?></div>
					</div>
				</div>
			<?php } elseif ( $this->logo_type == 'image' ) { ?>
				<div class="spmedical-department-wrap has-image">
					<a href="<?php echo $this->item->url; ?>">
						<div class="spmedical-department-img-wrap">
							<img src="<?php echo JURI::root() . $this->item->image; ?>" alt="<?php echo $this->item->title; ?>">
						</div>
						<div class="spmedical-department-content">
							<h3 class="spmedical-department-title"><?php echo $this->item->title; ?></h3>
							<div class="spmedical-department-details"><?php echo JHtmlString::truncate(strip_tags($this->item->description), 150); ?></div>
						</div>
					</a>
				</div>
			<?php } ?>
		</div> <!-- /.spmedical-departments -->
		<?php } ?>
	</div> <!-- /.spmedical-row -->

<?php } else { ?>
    <div class="row">
        <div class="spmedical-col-sm-12 sp-no-item-found">
            <p><?php echo JText::_('COM_SPMEDICAL_NO_ITEMS_FOUND'); ?></p>
        </div>
    </div>
<?php } ?>