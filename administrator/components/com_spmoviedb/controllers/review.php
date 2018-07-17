<?php
/**
 * @package     SP Property
 *
 * @copyright   Copyright (C) 2010 - 2016 JoomShaper. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined ('_JEXEC') or die('resticted aceess');
class SpmoviedbControllerReview extends FOFController
{

	public function redirect() {
		if ($this->redirect) {
			$app = JFactory::getApplication();
			$app->enqueueMessage($this->message, $this->messageType);
			$url = JURI::base().$this->redirect;

			$app->setHeader('Status', 'HTTP/1.1 303 See other', true);
			$app->setHeader('Location', $url, true);
			$app->redirect($this->redirect);
			return true;
		}

		return false;
	}

}
