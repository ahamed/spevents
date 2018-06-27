<?php

defined ('_JEXEC') or die('resticted aceess');

SpAddonsConfig::addonConfig(
	array(
		'type'=>'content',
		'addon_name'=>'sp_eventum_schedules',
		'category'=>'Eventum',
		'title'=>JText::_('COM_SPPAGEBUILDER_ADDON_SCHEDULES'),
		'desc'=>JText::_('COM_SPPAGEBUILDER_ADDON_SCHEDULES_DESC'),
		'attr'=>array(
			'general' => array(
				'schedule_count'=>array(
					'type'=>'number',
					'title'=>JText::_('COM_SPPAGEBUILDER_ADDON_SCHEDULES_COUNT'),
					'desc'=>JText::_('COM_SPPAGEBUILDER_ADDON_SCHEDULES_COUNT_DESC'),
					'std'=>'1'
					),

				'session_count'=>array(
					'type'=>'number',
					'title'=>JText::_('COM_SPPAGEBUILDER_ADDON_SCHEDULES_SESSION_COUNT'),
					'desc'=>JText::_('COM_SPPAGEBUILDER_ADDON_SCHEDULES_SESSION_COUNT_DESC'),
					'std'=>'6'
					),

				'schedule_layout'=>array(
					'type'=>'select',
					'title'=>JText::_('COM_SPPAGEBUILDER_ADDON_SCHEDULES_LAYOUT'),
					'desc'=>JText::_('COM_SPPAGEBUILDER_ADDON_SCHEDULES_LAYOUT_DESC'),
					'values'=>array(
						'grid'=>JText::_('COM_SPPAGEBUILDER_ADDON_SCHEDULES_LAYOUT_GRID'),
						'list'=>JText::_('COM_SPPAGEBUILDER_ADDON_SCHEDULES_LAYOUT_LIST')
						),
					'std'=>'list',
				),

				'column'=>array(
					'type'=>'number',
					'title'=>JText::_('COM_SPPAGEBUILDER_ADDON_SCHEDULES_COLUMN'),
					'desc'=>JText::_('COM_SPPAGEBUILDER_ADDON_SCHEDULES_COLUMN_DESC'),
					'std'=>'4'
					),

				'class'=>array(
					'type'=>'text',
					'title'=>JText::_('COM_SPPAGEBUILDER_ADDON_CLASS'),
					'desc'=>JText::_('COM_SPPAGEBUILDER_ADDON_CLASS_DESC'),
					'std'=> ''
					)
			 )		
		)
	)
);
