<?php
/**
 * @package     SP Property
 *
 * @copyright   Copyright (C) 2010 - 2016 JoomShaper. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// No Direct Access
defined ('_JEXEC') or die('Resticted Aceess');

class SppropertyControllerAgents extends FOFController{

	public function __construct($config = array()){
		parent::__construct($config);
	}

	public function onBeforeBrowse(){
		$params = JComponentHelper::getParams('com_spproperty');
		$limit 	= $params->get('agents_limit', 6);

		$this->getThisModel()->limit( $limit );
		$this->getThisModel()->limitstart($this->input->getInt('limitstart', 0));
	
		return true;
	}

	public function getModel($name = 'Agents', $prefix = 'SppropertyModel', $config = array()) {
		return parent::getModel($name = 'Agents', $prefix = 'SppropertyModel', $config = array());
	}

	public function contact(){
		
		$model 		= $this->getModel();
		$user 		= JFactory::getUser();
		$user_id 	= $user->id;

		$input 		= JFactory::getApplication()->input;
		$mail  		= JFactory::getMailer();

		$name 		= $input->post->get('name', NULL, 'STRING');
		$email 		= $input->post->get('email', NULL, 'STRING');
		$phone 		= $input->post->get('phone', NULL, 'STRING');
		$subject 	= $input->post->get('subject', NULL, 'STRING');
		$subject 	= $subject . ' | Phone Number: ' . $phone;
		$message 	= nl2br($input->post->get('message', NULL, 'STRING'));
		$recipient = base64_decode($input->post->get('agnt_email', NULL, 'STRING'));


		//message body
        $visitorip      = isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR'];

		$msg  = '';
		$msg .= '<p><span>Name : ' . $name .'</span></p> <br />';
		$msg .= '<p><span>Phone : ' . $phone .'</span></p> <br />';
		if ($user_name = $user->name) {
			$msg .= '<p><span>User name : ' . $user_name .'</span></p> <br />';
		}
		$msg .= '<p><span>Sender IP : ' . $visitorip .'</span></p> <br />';
		$msg .= '<p><span>Email : ' . $email .'</span></p> <br />';
		$msg .= '<p><span>message : ' . nl2br( $message ) .'</span></p> <br />';

		// Sent email
		$sender = array($email, $name);	
		$mail->setSender($sender);
		$mail->addRecipient($recipient);
		$mail->setSubject($subject);
		$mail->isHTML(true);
		$mail->Encoding = 'base64';	
		$mail->setBody($msg);

		$output['status'] = false;
		$output = array();

		if ($mail->Send()) {
			$output['status'] = true;
			$output['content'] = JText::_('COM_SPPROPERTY_CONTACT_SUCCESS');
		} else {
			$output['content'] = JText::_('COM_SPPROPERTY_CONTACT_ERROR');
		}

		echo json_encode($output);
		die();
	}


}