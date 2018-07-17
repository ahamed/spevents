<?php
/**
* @package     SP Movie Database
* @copyright   Copyright (C) 2010 - 2016 JoomShaper. All rights reserved.
* @license     GNU General Public License version 2 or later.
*/

defined('_JEXEC') or die('Restricted access!');

class SpmoviedbTableMovie extends FOFTable{

	public function check() {

		$result = true;		

		//actors
		if (is_array($this->actors)){
			if (!empty($this->actors)){
				$this->actors = json_encode($this->actors);
			}
		}
		if (is_null($this->actors) || empty($this->actors)){
			$this->actors = '';
		}

		//directors
		if (is_array($this->directors)){
			if (!empty($this->directors)){
				$this->directors = json_encode($this->directors);
			}
		}
		if (is_null($this->directors) || empty($this->directors)){
			$this->directors = '';
		}

		//genres
		if (is_array($this->genres)){
			if (!empty($this->genres)){
				$this->genres = json_encode($this->genres);
			}
		}
		if (is_null($this->genres) || empty($this->genres)){
			$this->genres = '';
		}

		return $result;
	}

	public function onAfterLoad(&$result) {

		// actors
		if(!is_array($this->actors)) {
			if(!empty($this->actors)) {
				$this->actors = json_decode($this->actors, true);
			}
		}

		if(is_null($this->actors) || empty($this->actors)) {
			$this->actors = array();
		}

		// directors
		if(!is_array($this->directors)) {
			if(!empty($this->directors)) {
				$this->directors = json_decode($this->directors, true);
			}
		}

		if(is_null($this->directors) || empty($this->directors)) {
			$this->directors = array();
		}

		// genres
		if(!is_array($this->genres)) {
			if(!empty($this->genres)) {
				$this->genres = json_decode($this->genres, true);
			}
		}

		if(is_null($this->genres) || empty($this->genres)) {
			$this->genres = array();
		}

		return parent::onAfterLoad($result);
	}
}