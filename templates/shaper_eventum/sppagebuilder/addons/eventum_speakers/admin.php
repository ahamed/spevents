<?php

defined ('_JEXEC') or die('resticted aceess');

SpAddonsConfig::addonConfig(
	array(
		'type'=>'content',
		'addon_name'=>'sp_eventum_speakers',
		'category'=>'Eventum',
		'title'=>JText::_('COM_SPPAGEBUILDER_ADDON_SPEAKERS'),
		'desc'=>JText::_('COM_SPPAGEBUILDER_ADDON_SPEAKERS_DESC'),
		'attr'=>array(
			'general' => array(
				'speaker_type'=>array(
					'type'=>'select',
					'title'=>JText::_('COM_SPPAGEBUILDER_ADDON_SPEAKERS_TYPE'),
					'desc'=>JText::_('COM_SPPAGEBUILDER_ADDON_SPEAKERS_TYPE_DESC'),
					'values'=>array(
						'1'=>JText::_('COM_SPPAGEBUILDER_ADDON_SPEAKERS_TYPE_ALL'),
						'2'=>JText::_('COM_SPPAGEBUILDER_ADDON_SPEAKERS_TYPE_KEYNOTE'),
						'3'=>JText::_('COM_SPPAGEBUILDER_ADDON_SPEAKERS_TYPE_NOT_KEYNOTE')
						),
					'std'=>'1',
				),

				'count'=>array(
					'type'=>'number',
					'title'=>JText::_('COM_SPPAGEBUILDER_ADDON_SPEAKERS_COUNT'),
					'desc'=>JText::_('COM_SPPAGEBUILDER_ADDON_SPEAKERS_COUNT_DESC'),
					'std'=>'8'
					),

				'column'=>array(
					'type'=>'number',
					'title'=>JText::_('COM_SPPAGEBUILDER_ADDON_SPEAKERS_COLUMN'),
					'desc'=>JText::_('COM_SPPAGEBUILDER_ADDON_SPEAKERS_COLUMN_DESC'),
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
