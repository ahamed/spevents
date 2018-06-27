<?php
/**
 * @package     SP Property
 *
 * @copyright   Copyright (C) 2010 - 2016 JoomShaper. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined ('_JEXEC') or die('resticted aceess');

class SppropertyToolbar extends FOFToolbar{

	function onBrowse()
	{
		JToolBarHelper::preferences('com_spproperty');
		parent::onBrowse();
	}
}