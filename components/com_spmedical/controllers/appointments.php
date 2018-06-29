<?php
/**
* @package com_spmedical
* @author JoomShaper http://www.joomshaper.com
* @copyright Copyright (c) 2010 - 2018 JoomShaper
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/

// No Direct Access
defined ('_JEXEC') or die('Restricted Access');

class SpmedicalControllerAppointments extends JControllerForm {

	public function getModel($name = 'form', $prefix = '', $config = array('ignore_request' => true)) {
		$model = parent::getModel($name, $prefix, $config); 
		return $model; 
	}

	public function submit(){
		
		// Load Lessons model
		jimport('joomla.application.component.model');
		JModelLegacy::addIncludePath(JPATH_SITE.'/components/com_spmedical/models');
		$specialists_model 	= JModelLegacy::getInstance( 'Specialists', 'SpmedicalModel' );
		$appointments_model = JModelLegacy::getInstance( 'Appointments', 'SpmedicalModel' );

		$input 		= JFactory::getApplication()->input;
		$mail  		= JFactory::getMailer();

		$user 		= JFactory::getUser();
		$user_id 	= $user->id;
		
		$specialist_id 		= $input->post->get('specialist_id', NULL, 'INT');
		$patient_name 		= $input->post->get('patient_name', NULL, 'STRING');
		$patient_phone 		= $input->post->get('phone', NULL, 'STRING');
		$patient_email		= $input->post->get('email', NULL, 'STRING');
		$appointment_date 	= $input->post->get('appointment_date', NULL, 'STRING');
		$patient_note 		= $input->post->get('patient_note', NULL, 'STRING');
		$showcaptcha 		= $input->post->get('showcaptcha', NULL, 'INT');

		$output = array();
		$output['status'] = false;
		$output['content'] = '';

		if($showcaptcha) {
			JPluginHelper::importPlugin('captcha');
			$dispatcher = JEventDispatcher::getInstance();
			$res = $dispatcher->trigger('onCheckAnswer');

			if(!$res[0]) {
				$output['content'] = JText::_('COM_SPMEDICAL_RECAPTCHA_INVALID_CAPTCHA');
				echo json_encode($output);
				die();
			}
		}

		$specialist_info =  '';
		$department_id 	 = '';
		if($specialist_id) {
			$specialist_info	= $specialists_model->getSpecialist($specialist_id);
			$specialist_email 	= $specialist_info->email;
			$department_id		= $specialist_info->department_id;
		}

		//message body
		$visitorip      = isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR'];
		
		// get site name 
		$site_name 		= isset($_SERVER['SERVER_NAME']) ? $_SERVER['SERVER_NAME'] : '';
		$subject 		= 'You have an appointment request from ' . ' Email Address: ' . $patient_email . ' | ' . $site_name;

		if( $appointment_no = $appointments_model->insertAppointment($patient_name, $patient_phone, $patient_email, $appointment_date, $patient_note, $specialist_id, $department_id, $user_id, $visitorip) ){
			
			$msg  = '';
			$msg .= '<span>Appointment ID : ' . $appointment_no .'</span><br />';
			$msg .= '<span>Patient Name : ' . $patient_name .'</span><br />';
			$msg .= '<span>Patient Phone : ' . $patient_phone .'</span><br />';
			$msg .= '<span>Patient Email : ' . $patient_email .'</span><br />';
			$msg .= '<span>Appointment Date : ' . $appointment_date .'</span><br />';
			$msg .= '<span>Patient Note : ' . $patient_note .'</span><br />';
			$msg .= '<span>Sender IP : ' . $visitorip .'</span>';

			// Sent email
			$sender = array($patient_email, $patient_name);
			$mail->setSender($sender);
			$mail->addRecipient($specialist_email);
			$mail->setSubject($subject);
			$mail->isHTML(true);
			$mail->Encoding = 'base64';
			$mail->setBody($msg);

			$output['appointment_id'] = '';
			if ($mail->Send()) {
				$output['status'] = true;
				$output['content'] = JText::_('COM_SPMEDICAL_SPECIALIST_APPOINTMENT_SUCCESS') . ' <strong>' .$appointment_no . '<strong>';
				$output['appointment_id'] = $appointment_no;
			} else {
				$output['content'] = JText::_('COM_SPMEDICAL_SPECIALIST_APPOINTMENT_ERROR');
			}
		}
		echo json_encode($output);
		die();
	}
	
}
