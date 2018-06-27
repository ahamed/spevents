<?php
/**
 * @package     SP Property
 *
 * @copyright   Copyright (C) 2010 - 2016 JoomShaper. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die('Restricted access!');

class SppropertyTableProperty extends FOFTable{

	public function check() {

		$result = true;

		//features
		if (is_array($this->features)){
			if (!empty($this->features)){
				$this->features = json_encode($this->features);
			}
		}
		if (is_null($this->features) || empty($this->features)){
			$this->features = '';
		}

		if (is_array($this->gallery)){
			if (!empty($this->gallery)){
				$this->gallery = json_encode($this->gallery);
			}
		}
		if (is_null($this->gallery) || empty($this->gallery)){
			$this->gallery = '';
		}

		if (is_array($this->floor_plans)){
			if (!empty($this->floor_plans)){
				$this->floor_plans = json_encode($this->floor_plans);
			}
		}
		if (is_null($this->floor_plans) || empty($this->floor_plans)){
			$this->floor_plans = '';
		}

		return $result;
	}

	public function onAfterLoad(&$result) {

		// features
		if(!is_array($this->features)) {
			if(!empty($this->features)) {
				$this->features = json_decode($this->features, true);
			}
		}

		if(is_null($this->features) || empty($this->features)) {
			$this->features = array();
		}

		// has gallery
		if(!is_array($this->gallery) && !empty($this->gallery) ) {
				$this->gallery =  json_decode($this->gallery, true);
				if (isset($this->gallery['photo']) && $this->gallery['photo']) {
					$gallery 			= array();
					$photos 			= $this->gallery['photo'];
					$alt_texts 		= $this->gallery['alt_text'];
					$glkey 				= 1;
					foreach ($photos as $id => $photo) {
						if ($photo) {
							$gallery[$glkey] = array(
								'photo' 			=> $photo,
								'alt_text'		=> $alt_texts[$id],
							);
							$glkey ++;
						}
					}
					$this->gallery = $gallery;
				} // if old repeatable field
		}

		// has Floor Plans
		if(!is_array($this->floor_plans) && !empty($this->floor_plans) ) {
			$this->floor_plans =  json_decode($this->floor_plans, true);
			if (isset($this->floor_plans['img']) && $this->floor_plans['img']) {
				$floor_plans 	= array();
				$imgs					= $this->floor_plans['img'];
				$layout_names 	= $this->floor_plans['layout_name'];
				$texts 				= $this->floor_plans['text'];
				$glkey 				= 1;
				foreach ($imgs as $id => $img) {
					if ($img) {
						$floor_plans[$glkey] = array(
							'img' 				=> $img,
							'layout_name'	=> $layout_names[$id],
							'text'				=> $texts[$id],
						);
						$glkey ++;
					}
				}
				$this->floor_plans = $floor_plans;
			} // if old repeatable field
		}



		return parent::onAfterLoad($result);
	}
}
